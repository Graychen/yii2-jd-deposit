<?php
/**
 * 配置REST URL 信息
 */
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'jd/v1/deposit',
        'only' => ['create','status'],
        'extraPatterns' => [
            'POST deposits' => 'create',
            'POST status' => 'status',
        ]
    ]
];
