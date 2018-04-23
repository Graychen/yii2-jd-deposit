<?php
namespace graychen\yii2\queue\backend\tests;
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
            'bootstrap' => [
                'queue'
            ],
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'mysql:host=localhost:3306;dbname=test',
                    'username' => 'root',
                    'password' => '',
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
        $db->createCommand()->dropTable('tb_queue')->execute();
    }
    protected function createTestDbData()
    {
        Yii::$app->runAction('/migrate/up', ['migrationPath' => '@migrate']);
    }
}
