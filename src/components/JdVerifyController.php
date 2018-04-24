<?php

namespace graychen\jd\deposit\components;

use api\modules\jd\v1\filters\JdSignAuth;
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
