<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/18
 * Time: 9:40
 */

namespace app\api\service;


use app\api\model\Product;
use app\lib\exception\OrderException;

class Order
{
    //订单的商品列表，也就是客户端传来的product参数
    protected  $oProducts;

    //真实的商品信息（包括库存量）
    protected  $products;

    protected  $uid;

    public function place($uid,$oProducts)
    {
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
        //$oProduct和Product作对比


        //products从数据库中查询出来
    }

    private function getOrderStatus()
    {
        $status =  [
          'pass'=>true,  //订单状态，还有库存
            'orderPrice'=>0,  //订单总价格
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
            'count'=>0,
            'name'=>'',
            'totalPrice'=>0
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
            $pStatus['name']=$pStatus['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice']=$product['price']*$oCount;
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
        $products = Product::all([$oPIDs])
        ->visible(['id','price','stock','name','main_img_url'])
        ->toArray();
        return $products;
    }


}