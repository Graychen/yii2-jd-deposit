<?php
namespace graychen\yii2\jd\deposit\actions;

use graychen\yii2\jd\deposit\models\Order;
use Yii;
use yii\web\NotFoundHttpException;

class StatusAction extends JdVerifyAction
{
    public function run()
    {
        $params = Yii::$app->request->getBodyParams();
        $arrayData = json_decode(base64_decode($params['data']), true);
        $orderId = $arrayData['orderId'];
        if (($order = Order::findOne(['sn' => Order::SOURCE_JD . $orderId])) == null) {
            throw new NotFoundHttpException('订单不存在');
        }
        $data = [];
        if ($order->status > 2) {
            $data['orderStatus'] = 0;
        } elseif ($order->status > -1) {
            $data['orderStatus'] = 1;
        } else {
            $data['orderStatus'] = 2;
        }
        return $data;
    }

}