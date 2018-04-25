<?php
namespace graychen\yii2\jd\deposit\tests;

use Yii;
use PHPUnit\Framework\TestCase as BaseTestCase;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the base class for all yii framework unit tests.
 */
class TestCase extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockWebApplication();
        $this->createTestDbData();
    }
    protected function tearDown()
    {
        parent::tearDown();
        $this->destroyTestDbData();
        $this->destroyWebApplication();
    }
    protected function mockWebApplication($config = [], $appClass = '\yii\web\Application')
    {
        return new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'mysql:host=localhost:3306;dbname=test',
                    'username' => 'root',
                    'password' => '206065',
                    'tablePrefix' => 'tb_'
                ],
                'i18n' => [
                    'translations' => [
                        '*' => [
                            'class' => 'yii\i18n\PhpMessageSource',
                        ]
                    ]
                ],
            ],
            'modules' => [
                'jd-deposit' => [
                    'class' => 'graychen\yii2\jd\deposit\Module',
                    'controllerNamespace' => 'graychen\yii2\jd\deposit\tests\controllers'
                ]
            ]
        ], $config));
    }
    /**
     * @return string vendor path
     */
    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }
    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyWebApplication()
    {
        if (\Yii::$app && \Yii::$app->has('session', true)) {
            \Yii::$app->session->close();
        }
        \Yii::$app = null;
    }
    protected function destroyTestDbData()
    {
        $db = Yii::$app->getDb();
        $db->createCommand()->dropTable('tb_order')->execute();
    }
    protected function createTestDbData()
    {
        //Yii::$app->runAction('/migrate', ['migrationPath' => '@migrate']);
        $db = Yii::$app->getDb();
        try {
            $db->createCommand()->createTable('tb_order', [
                'id' => 'pk',
                'sn' => "int(11) not null",
                'game_id' => "int(11) not null",
                'type' => "smallint(6) not null",
                'user_id' => "int(100) not null",
                'count' => "int(100) not null",
                'hours' => "int(100) not null",
                'final_price' => "float(100) not null",
                'equipment' => "string(100) not null",
                'serverinfo' => "string(100) not null",
                'account' => "string(100) not null",
                'remark' => "string(100)",
                'status' => "smallint(6) not null",
                'created_at' => "int(100) not null",
                'updated_at' => "int(100) not null",
                'start_time' => "datetime",
                'end_time' => "datetime",
                'payment_method' => "smallint(6) not null",
                //'client_id' => "string(100) not null",
                'name' => "string(255) not null",
                //'description' => "string(100) not null",
            ])->execute();
        } catch (Exception $e) {
            return;
        }
    }
}
