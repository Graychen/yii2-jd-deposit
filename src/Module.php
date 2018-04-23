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
    }
}
