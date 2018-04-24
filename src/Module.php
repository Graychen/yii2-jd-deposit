<?php

namespace api\modules\jd;

use yii;
use yii\web\Response;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\jd\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (YII_DEBUG) {
            $tag = Yii::$app->log->targets['debug']->tag;
            $url = getenv('APP_HOST') . 'api/debug/default/view?tag=' . $tag . '&panel=api';
            Yii::$app->response->headers->add('x-debug-tag', $tag);
            Yii::$app->response->headers->add('x-debug-url', $url);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->headers->add('x-author', 'lianluo.com');
        if (YII_DEBUG) {
            Yii::$app->response->headers->add('x-debug-tag', Yii::$app->log->targets['debug']->tag);
        }
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
        Yii::$app->request->parsers = [
            'application/json' => 'yii\web\JsonParser',
        ];
        //在API接口模块执行严格URL检查
        Yii::$app->urlManager->enableStrictParsing = true;
    }
}
