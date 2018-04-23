<?php

namespace api\modules\jd\v1\models;

use common\helpers\utils\DataPack;
use common\models\Order;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\web\ConflictHttpException;

/**京东充值
 * Class OrderDeposit
 */
class OrderDeposit extends Model
{
    public $data;//数据
    public $customerId;//店铺id
    public $sign;//签名
    public $timestamp;//当前时间戳
    public $orderId;//京东订单号
    public $buyNum;//购买数量
    public $skuId; //对应京东的商品 skuId
    public $brandId; //对应京东游戏品牌 ID
    public $userIp; //用户 ip 地址
    public $totalPrice; //订单总价
    public $gameAccount; //游戏账号
    public $permit; //通行证
    public $gameAccountType; //账号类型
    public $chargeType;//充值类型
    public $gameArea; //游戏区
    public $gameServer; //游戏所在服
    public $features; //json格式字符串

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
            [['data'], 'required']
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
        $data = json_decode(base64_decode($this->data), true);
        if (Order::find()->where(['sn' => Order::SOURCE_JD . $data['orderId']])->exists()) {
            throw new ConflictHttpException('订单号已存在');
        }
        /* @var $order Order */
        $order = new \common\models\OrderDeposit();
        $order->sn = $order::SOURCE_JD . $data['orderId'];
        $order->name = DataPack::skuidList()[$data['skuId']]['name'] ?? '京东订单';
        $order->count = $data['buyNum'];
        $order->final_price = $data['totalPrice'];
        $order->account = $data['gameAccount'];
        $order->remark = json_encode($data);
        $order->game_id = DataPack::skuidList()[$data['skuId']]['game_id'] ?? 1;
        $order->hours = 1;
        $order->type = DataPack::skuidList()[$data['skuId']]['type'] ?? Order::TYPE_PEIWAN_PUTONG;
        $order->start_time = date('Y-m-d H:i');
        $order->end_time = date('Y-m-d H:i', strtotime($order->start_time) + 3600);
        $order->equipment = $data['gameArea']['name'];
        $order->serverinfo = $data['gameServer']['name'];
        $order->user_id = 1;
        $order->status = Order::STATUS_PAID;
        $order->source = $order::SOURCE_JD;
        $order->payment_method = Order::PAYMENT_METHOD_JD;
        return $order->save();
    }
}
