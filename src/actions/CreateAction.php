<?php
namespace graychen\yii2\jd\deposit\actions;

use graychen\yii2\jd\deposit\models\Order;
use Yii;

class CreateAction extends JdVerifyAction
{
    public function run()
    {
        $model = new Order();
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->validate() && $model->save()) {
            Yii::$app->response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new yii\web\ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}