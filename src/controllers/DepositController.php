<?php

namespace graychen\jd\deposit\controllers;

use graychen\jd\deposit\components\JdVerifyController;
use graychen\jd\deposit\models\OrderDeposit;
use Yii;
use yii\web\NotFoundHttpException;

class DepositController extends JdVerifyController
{
    /**
     * 京东订单推送
     */
    public function actionCreate()
    {
        $model = new OrderDeposit();
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->validate() && $model->save()) {
            Yii::$app->response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new yii\web\ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * 查询京东订单状态
     */
    public function actionStatus()
    {
        $params = Yii::$app->request->getBodyParams();
        $arrayData = json_decode(base64_decode($params['data']), true);
        $orderId = $arrayData['orderId'];
        if (($order = OrderDeposit::findOne(['sn' => \common\models\OrderDeposit::SOURCE_JD . $orderId])) == null) {
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
