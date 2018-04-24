<?php
namespace graychen\yii2\jd\deposit\actions;


use graychen\yii2\jd\deposit\filters\JdSignAuth;
use yii\filters\VerbFilter;
use yii\filters\RateLimiter;
use yii\base\Action;

class JdVerifyAction extends action
{
    public function behaviors()
    {
        return [
            'bearerAuth' => [
                'class' => JdSignAuth::className(),
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
            'rateLimiter' => [
                'class' => RateLimiter::className(),
            ]
        ];
    }
}
