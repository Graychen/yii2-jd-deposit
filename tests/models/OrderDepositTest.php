<?php
namespace graychen\yii2\jd\deposit\tests\models;

use graychen\yii2\jd\deposit\models\OrderDeposit;
use graychen\yii2\jd\deposit\tests\TestCase;
use yii;

class OrderDepositTest extends TestCase
{
    public $model;
    protected function setUp()
    {
        parent::setUp();
    }
    protected function tearDown()
    {
        parent::tearDown();
    }
    public function testCreate()
    {
        $model = new OrderDeposit();
        //必须性验证
        $this->assertTrue($model->isAttributeRequired('orderId'));
        $this->assertTrue($model->isAttributeRequired('buyNum'));
        $this->assertTrue($model->isAttributeRequired('skuId'));
        $this->assertTrue($model->isAttributeRequired('brandId'));
        $this->assertTrue($model->isAttributeRequired('userIp'));
        $this->assertTrue($model->isAttributeRequired('totalPrice'));
        $this->assertTrue($model->isAttributeRequired('gameAccount'));
        //【1】订单号不正确：长度至少11位
        $model->orderId = '123456';
        $model->validate();
        $this->assertArrayHasKey('orderId', $model->getErrors());

        //【2】订单号不正确：必须全部是数字
        $model->orderId = 'JD73797050529';
        $model->validate();
        $this->assertArrayHasKey('orderId', $model->getErrors());

        //【3】订单号数量必须是1-200
        $model->buyNum = 201;
        $model->validate();
        $this->assertArrayHasKey('buyNum', $model->getErrors());
        $model->buyNum = 201;
        $model->validate();
        $this->assertArrayHasKey('buyNum', $model->getErrors());

        //userIp地址验证
        $ips = ['299.900.23.4', '255.255.255.255.20',];
        foreach ($ips as $ip) {
            $model->userIp = $ip;
            $model->validate();
            $this->assertArrayHasKey('userIp', $model->getErrors());
        }
        //totalPrice必须是数字
        $model->totalPrice = 'null';
        $model->validate();
        $this->assertArrayHasKey('totalPrice', $model->getErrors());
        //gameAccount必须字符串
        $model->gameAccount = '';
        $model->validate();
        $this->assertArrayHasKey('gameAccount', $model->getErrors());
        //skuid必须大于11位数字长度
        $model->skuId = 1064017372;
        $model->validate();
        $this->assertArrayHasKey('skuId', $model->getErrors());
        $model->skuId = 'skuid';
        $model->validate();
        $this->assertArrayHasKey('skuId', $model->getErrors());
        //正常写入
        $model->orderId = '73798050529';
        $model->buyNum = 99;
        $model->gameAccount = 'gitluochao';
        $model->equipment = '无';
        $model->userIp = '115.238.94.98';
        $model->skuId = '21064017372';
        $model->brandId = 100;
        $model->serverinfo = '无';
        $model->totalPrice = 100;
        $this->assertTrue($model->validate());
        $this->assertTrue($model->save());
    }
}
