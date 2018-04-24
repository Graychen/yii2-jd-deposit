<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order}}".
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @property OrderPaymentRecord $orderPaymentRecord
 */
class OrderDeposit extends \yii\db\ActiveRecord
{
    public $source = 'PC';
    const TYPE_JD= 'JD充值';
    const SOURCE_JD= 'JD';//京东
    const PAYMENT_METHOD_JD = 9; //京东支付

    const STATUS_SUCCESS=0;
    const STATUS_RECHARGE=1;
    const STATUS_FAILURE=2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sn' => '订单号',
            'game_id' => '游戏ID',
            'type' => '订单分类',
            'user_id' => '用户ID',
            'final_price' => '价格',
            'equipment' => '区服信息',
            'serverinfo' => '详细区服信息',
            'account' => '用户帐号/游戏昵称',
            'password' => '用户帐号和密码',
            'remark' => '备注',
            'status' => '订单状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'payment_method' => '支付方式',
            'source' => '订单来源',
        ];
    }

    /**
     * 订单状态列表
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_SUCCESS => '充值成功',
            self::STATUS_RECHARGE => '充值中',
            self::STATUS_FAILURE => '充值失败',
        ];
    }
}
