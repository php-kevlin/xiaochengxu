<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/18
 * Time: 9:40
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\api\validate\AppTokenGet;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Db;
use think\Exception;

class Order
{
    //订单的商品列表，也就是客户端传来的product参数
    protected  $oProducts;

    //真实的商品信息（包括库存量）
    protected  $products;

    protected  $uid;

    public function place($uid,$oProducts)
    {
         //$oProduct和Product作对比
            //products从数据库中查询出来
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
        $status = $this->getOrderStatus();
        if(!$status['pass'])
        {
            $status['order_id'] = -1;
            return $status;
        }

        //开始创建订单
        //创建订单快照
        $orderSnap = $this->snapOrder($status);

        //开始创建订单
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;

    }


    /**
     * 创建订单并且将数据写入到数据库中
     */
    private function createOrder($snap)
    {
        Db::startTrans();
        try{
        $orderNo = $this->makeOrderNo();
        $order = new \app\api\model\Order();
        $order->user_id = $this->uid;
        $order->order_no = $orderNo;
        $order->total_price= $snap['orderPrice'];
        $order->total_count = $snap['totalCount'];
        $order->snap_img = $snap['snapImg'];
        $order->snap_name = $snap['snapName'];
        $order->snap_address = $snap['snapAddress'];
        $order->snap_items = json_encode($snap['pStatus']);
        $order->save();

        $orderID = $order->id;
        $create_time= $order->create_time;
        foreach ($this->oProducts as &$p)
        {
            $p['order_id'] = $orderID;
        }
        $orderProduct = new OrderProduct();
        $orderProduct->saveAll($this->oProducts);
        Db::commit();
        return [
            'order_no'=>$orderNo,
            'order_id'=>$orderID,
            'create_time'=>$create_time
        ];

        }catch (Exception $ex){
            Db::rollback();
            throw $ex;
        }


    }

    /**
     * 生成订单号
     */
    public static function makeOrderNo(){
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] .
            strtoupper(dechex(date('m'))) .
            date('d') .
            substr(time(), -5) .
            substr(microtime(), 2, 5) .
            sprintf('%02d', rand(0, 99));
        return $orderSn;
    }



    /**
     * 生成订单快照
     */
    private function snapOrder($status)
    {
        $snap = [
          'orderPrice' => 0,
            'totalCount'=>0,
            'pStatus'=>[],
            'snapAddress'=>null,
            'snapName'=>'',
            'snapImg'=>'',
        ];
        $snap['orderPrice']=$status['orderPrice'];
        $snap['totalCount']=$status['totalCount'];
        $snap['pStatus']=$status['pStatusArray'];
        $snap['snapAddress']=json_encode($this->userAddress());
        $snap['snapName']=$this->products[0]['name'];
        $snap['snapImg']= $this->products[0]['main_img_url'];
        if(count($this->products)>1)
        {
            $snap['snapName'].='等';
        }
        return $snap;

    }

    private function userAddress()
    {
        $userAddress = UserAddress::where('user_id','=',$this->uid)->find();
        if(!$userAddress)
        {
            throw new UserException([
                'msg'=>'用户收货地址不存在，下单失败',
                'err'=>'60002'
            ]);

        }
        return $userAddress->toArray();
    }

    private function getOrderStatus()
    {
        $status =  [
          'pass'=>true,  //订单状态，还有库存
            'orderPrice'=>0,  //订单总价格
            'totalCount'=>0,
            'pStatusArray'=>[]  //商品里面所有的详情信息
        ];
        foreach ($this->oProducts as $oProduct)
        {
            $pStatus = $this->getProductStatus($oProduct['product_id'],
               $oProduct['count'],$this->products
                );
            if(!$pStatus['haveStock']){
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['counts'];

            array_push($status['pStatusArray'],$pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID,$oCount,$products)
    {
        $pIndex = -1;
        $pStatus =[
            'id'=>null,
            'haveStock'=>false,
            'counts'=>0,
            'price'=>0,
            'name'=>'',
            'totalPrice'=>0,
            'main_img_url'=>null
        ];
        for($i=0;$i<count($products);$i++)
        {
            if($oPID == $products[$i]['id']){
                $pIndex = $i;
            }
        }
        if($pIndex == -1){
            throw new OrderException([
                'msg'=>'id为'.$oPID.'商品不存在，创建订单失败'
            ]);
        }else{
            $product = $products[$pIndex];
            $pStatus['id']= $product['id'];
            $pStatus['name']=$product['name'];
            $pStatus['counts'] = $oCount;
            $pStatus['price'] = $product['price'];
            $pStatus['totalPrice']=$product['price']*$oCount;
            $pStatus['main_img_url'] = $product['main_img_url'];
            if($product['stock']-$oCount>=0)
            {
                $pStatus['haveStock'] = true;
            }
        }

        return $pStatus;
    }

    //根据订单信息查找真实的商品信息
    public function getProductsByOrder($oProducts)
    {
        $oPIDs  = [];
        foreach ($oProducts as $item)
        {
            array_push($oPIDs,$item['product_id']);
        }
        $products = Product::all($oPIDs)
        ->visible(['id','name','price','stock','main_img_url'])
        ->toArray();
        return $products;
    }


}