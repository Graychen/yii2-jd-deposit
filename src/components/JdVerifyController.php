<?php

namespace graychen\yii2\jd\deposit\components;

use graychen\yii2\modules\jd\deposit\filters\JdSignAuth;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\filters\RateLimiter;

class JdVerifyController extends Controller
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
