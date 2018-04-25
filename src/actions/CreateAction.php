<?php
namespace graychen\yii2\jd\deposit\actions;

use graychen\yii2\jd\deposit\models\OrderDeposit;
use Yii;

class CreateAction extends JdVerifyAction
{
    public function run()
    {
        $model = new OrderDeposit();
        $data = json_decode(base64_decode(Yii::$app->request->getBodyParam('data')), true);
        $model->equipment = $data['gameArea']['name'] ?? '无';
        $model->serverinfo = $data['gameServer']['name'] ?? '无';
        $model->raw = json_encode($data);
        if ($model->load($data, '') && $model->validate() && $model->save()) {
            Yii::$app->response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new yii\web\ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}
