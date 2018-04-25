<?php

namespace graychen\yii2\jd\deposit\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order}}".
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @property OrderPaymentRecord $orderPaymentRecord
 */
class Order extends \yii\db\ActiveRecord
{
    public $source = 'PC';
    const TYPE_JD= 'JD充值';
    const SOURCE_JD= 'JD';//京东
    const PAYMENT_METHOD_JD = 9; //京东支付

    const STATUS_SUCCESS=0;
    const STATUS_RECHARGE=1;
    const STATUS_FAILURE=2;

    const TYPE_PEIWAN_PUTONG = 1; //普通陪玩
    const TYPE_PEIWAN_YANZHI = 2; //颜值陪玩
    const TYPE_SHANGFEN_PEILIAN = 3; //陪练上分
    const TYPE_SHANGFEN_DAIDA = 4; //代打上分

    const STATUS_REFUNDING = -5; //退款中
    const STATUS_REFUND_FAILED = -4; //退款失败
    const STATUS_REFUNDED = -3; //已退款
    const STATUS_PAY_FAILED = -2; //支付失败
    const STATUS_UNPAID = -1; //未支付
    const STATUS_PAID = 0; //未派单, 已支付
    const STATUS_IN_DISPATCH = 1; //正在派单
    const STATUS_IN_SERVICE = 2; //服务中
    const STATUS_APPLY_COMPLETED = 3; //申请完成
    const STATUS_FINISHED = 4; //已完成
    const STATUS_CLOSED = 5; //已关闭


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
        return [
           [['id', 'game_id', 'type','user_id','hours', 'status', 'created_at', 'updated_at', 'payment_method'], 'integer'],
           [['sn',  'serverinfo', 'account', 'password', 'remark', 'client_id', 'name', 'description'], 'safe'],
           [['count', 'final_price'], 'number'],
        ];
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
            'count' =>'陪玩局数/时长',
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

    /**
     * 京东Skuid对照表
     */
    public static function skuidList()
    {
        return [
            '21064017372' => [
                'game_id' => 2,
                'type' => self::TYPE_PEIWAN_YANZHI,
                'name' => '吃鸡陪玩绝地求生大逃杀全军出击刺激战场荒野行动光荣使命双排吃鸡实力带躺',
            ],
            '19025625428' => [
                'game_id' => 1,
                'type' => self::TYPE_SHANGFEN_PEILIAN,
                'name' => '王者荣耀陪练排位大神陪玩包带上分上星代练代打双排匹配熟练度升级成就赏金冒险连胜'
            ],
            '19027152924' => [
                'game_id' => 1,
                'type' => self::TYPE_SHANGFEN_PEILIAN,
                'name' => '王者荣耀大神陪练美女陪玩双排排位匹配熟练度升级成就赏金冒险连胜'
            ],
            '19087622210' => [
                'game_id' => 1,
                'type' => self::TYPE_SHANGFEN_PEILIAN,
                'name' => '王者荣耀代练上星代打上分上段美女陪玩大神陪练排位匹配熟练度成就升级赏金冒险连胜'
            ],
            '19148161614' => [
                'game_id' => 1,
                'type' => self::TYPE_SHANGFEN_PEILIAN,
                'name' => '补差价单 王者荣耀代打代练大神陪练美女陪玩双排匹配成就熟练度升级赏金冒险'
            ],
            '25219449932' => [
                'game_id' => 1,
                'type' => self::TYPE_PEIWAN_YANZHI,
                'name' => 'QQ飞车手游qq飞车代抽永久A车黑夜传说大神代练美女陪玩代刷成就剧情等级经验金币'
            ]
        ];
    }
}
