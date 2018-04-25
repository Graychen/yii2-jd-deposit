<?php

namespace graychen\yii2\jd\deposit\models;

use common\helpers\utils\DataPack;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\web\ConflictHttpException;

/**京东充值
 * Class OrderDeposit
 */
class OrderDeposit extends Model
{
    public $orderId;//京东订单号
    public $buyNum;//购买数量
    public $skuId; //对应京东的商品 skuId
    public $brandId; //对应京东游戏品牌 ID
    public $userIp; //用户 ip 地址
    public $totalPrice; //订单总价
    public $gameAccount; //游戏账号
    public $permit; //通行证
    public $raw;
    public $equipment;
    public $serverinfo;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    public function rules()
    {
        return [
            [['orderId', 'buyNum', 'skuId', 'brandId', 'userIp', 'totalPrice', 'gameAccount'], 'required'],
            [['orderId', 'brandId', 'skuId'], 'integer'],
            [['orderId', 'skuId'], 'match', 'pattern' => '/^\d{11,}$/'],
            ['buyNum', 'integer', 'min' => 1, 'max' => 200],
            ['userIp', 'ip'],
            ['totalPrice', 'double'],
            [['gameAccount', 'equipment', 'serverinfo', 'permit'], 'string'],
            ['raw', 'safe'],
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

    public function save()
    {
        if (Order::find()->where(['sn' => Order::SOURCE_JD . $this->orderId])->exists()) {
            throw new ConflictHttpException('订单号已存在');
        }
        /* @var $order Order */
        $order = new Order();
        $order->sn = Order::SOURCE_JD . $this->orderId;
        $order->name = Order::skuidList()[$this->skuId]['name'] ?? '京东订单';
        $order->count = $this->buyNum;
        $order->final_price = $this->totalPrice;
        $order->account = $this->gameAccount;
        $order->remark = $this->raw;
        $order->game_id = Order::skuidList()[$this->skuId]['game_id'] ?? 1;
        $order->hours = 1;
        $order->type = Order::skuidList()[$this->skuId]['type'] ?? Order::TYPE_PEIWAN_PUTONG;
        $order->start_time = date('Y-m-d H:i');
        $order->end_time = date('Y-m-d H:i', strtotime($order->start_time) + 3600);
        $order->equipment = $this->equipment;
        $order->serverinfo = $this->serverinfo;
        $order->user_id = 1;
        $order->status = Order::STATUS_PAID;
        $order->source = $order::SOURCE_JD;
        $order->payment_method = Order::PAYMENT_METHOD_JD;
        return $order->save();
    }

}
