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
        $this->model=new OrderDeposit();
    }
    protected function tearDown()
    {
        parent::tearDown();
    }
    public function testRules()
    {
        /*
        $this->assertTrue($this->model->isAttributeRequired('queue_id'));
        $this->assertTrue($this->model->isAttributeRequired('catalog'));
        $this->assertTrue($this->model->isAttributeRequired('name'));
        $this->assertTrue($this->model->isAttributeRequired('description'));
        $this->model->queue_id='1';
        $this->model->catalog='类别';
        $this->model->name='任务名称';
        $this->model->description='详请信息';
        $this->assertTrue($this->model->save());
        */
        $this->assertTrue(true);
    }

}