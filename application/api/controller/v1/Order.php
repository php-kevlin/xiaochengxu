<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/17
 * Time: 21:42
 */

namespace app\api\controller\v1;

use app\api\validate\IdMustBePostiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Order as OrderService;
use app\api\service\Token as TokenService;
use app\api\validate\PagingParameter;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;
use tests\thinkphp\library\think\paginateTest;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope'=>['only'=>'placeOrder'],
        'checkPrimaryScope'=>['only'=>'getSummaryByUser'],
    ];
        public function placeOrder()
        {
            (new OrderPlace())->goCheck();
            $product = input('post.products/a');
            $uid = TokenService::getCurrentUid();

            $order = new OrderService();
            $status = $order->place($uid,$product);
            return $status;
        }
        public function getSummaryByUser($page =1,$size=4){
            (new PagingParameter())->goCheck();
            $uid = TokenService::getCurrentUid();
            $pagingDatas = OrderModel::getSummaryByUser($uid,$page,$size);
            if($pagingDatas->isEmpty()){
                return [
                  'data'=>[],
                    'current_page'=>$pagingDatas->currentPage()
                ];
            }
            $data = $pagingDatas->hidden(['snap_items','snap_address','prepay_id'])->toArray();
            return [
                'data'=>$data,
                'current_page'=>$pagingDatas->currentPage()
            ];
        }

        /*
         * 获取订单详请
         */
        public function getDetail($id)
        {
            (new IdMustBePostiveInt())->goCheck();
            $orderDetail = OrderModel::get($id);
            if(!$orderDetail){
                throw new OrderException([

                ]);
            }

            return $orderDetail->hidden(['prepay_id']);
        }
        /*
         * 获取所有订单
         */

        public function getSummary($page=1,$size=4)
        {
            header('Access-Control-Allow-Origin:*');//允许所有域名访问
            header('Access-Allow-Control-Header:token,Origin,X-Requested-with，Content-Type,Accept');//允许其他域名访问时携带的数据
            header('Access-Control-Allow-Methods:POST,GET');
            (new PagingParameter())->goCheck();
            $paginOrders = OrderModel::getSummaryByPage($page,$size);
            if($paginOrders->isEmpty()){
                return [
                    'current_page'=>$paginOrders->currentPage(),
                    'data'=>[]
                ];
            }
            $data = $paginOrders->hidden(['snap_items','snap_address'])->toArray();
            return [
                'current_page'=>$paginOrders->currentPage(),
                'data'=>$data
            ];
        }


}