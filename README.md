# yii-jd-deposit
[![Latest Stable Version](https://poser.pugx.org/graychen/yii2-jd-deposit/version)](https://packagist.org/packages/graychen/yii2-jd-deposit)
[![Total Downloads](https://poser.pugx.org/graychen/yii2-jd-deposit/downloads)](https://packagist.org/packages/graychen/yii2-jd-deposit)
[![Build Status](https://travis-ci.org/Graychen/yii2-jd-deposit.svg?branch=master)](https://travis-ci.org/Graychen/yii2-jd-deposit)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Graychen/yii2-jd-deposit/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Graychen/yii2-jd-deposit/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Graychen/yii2-jd-deposit/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Graychen/yii2-jd-deposit/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Graychen/yii2-jd-deposit/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Graychen/yii2-jd-deposit/build-status/master)
[![StyleCI](https://styleci.io/repos/109097207/shield?branch=master)](https://styleci.io/repos/109097207)

This is a background for yii-queue, there are queue statistics, temporary support redis driver
# Migrate database

## To add a lookup table to your database, following is the sql for lookup:
you can use yii migration
```
yii migrate/up --migrationPath=@graychen/yii2/jd/deposit/migrations
```
## api 
Config Module in components part

    'jd-deposit' => [
        'class' => 'graychen\yii2\jd\deposit\Module',
    ]

Use Actions

class jdController extends Controller
{
    public function actions()
    {
        return [
            'create' => [
                'class' => 'graychen\yii2\jd\deposit\createAction'
            ],
             'status' => [
                            'class' => 'graychen\yii2\jd\deposit\statusAction'
             ]
        ];
    }
}
## backend
### Config -> main.php 
```
'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@graychen/yii2/jd/deposit/migrations'
            ],
        ],
    ],
```
### Config Module in components part
``` php 
'queue' => [
            'class' => 'graychen\yii2\deposit\backend\Module',
]
```
## View
### after that,you can website `https://localhost/admin/deposit/default`
## ChangeLog
[changelog](https://github.com/Graychen/yii2-queue-backend/blob/master/CHANGELOG.md)