<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\helpers\utils\DataPack;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', '返回'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', '删除'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '你确定要删除订单吗?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sn',
            'game_id',
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return $model::getTypeList()[$model->type];
                }
            ],
            [
                'attribute' => 'beauty',
                'value' => function ($model) {
                    return $model::getBeautyList()[$model->beauty];
                }
            ],
            'user_id',
            [
                'attribute' => 'current_tiers',
                'value' => function ($model) {
                    return DataPack::kingGloryLevels()[$model->current_tiers-1]['name'];
                },
                'visible' => $model->game_id == $model::GAME_KG,
            ],
            [
                'attribute' => 'current_divisions',
                'visible' => $model->game_id == $model::GAME_KG,
            ],
            [
                'attribute' => 'target_tiers',
                'value' => function ($model) {
                    return DataPack::kingGloryLevels()[$model->target_tiers-1]['name'];
                },
                'visible' => $model->game_id == $model::GAME_KG,
            ],
            [
                'attribute' => 'target_divisions',
                'visible' => $model->game_id == $model::GAME_KG,
            ],
            [
                'attribute' => 'mingwen',
                'visible' => $model->game_id == $model::GAME_KG,
            ],
            'count',
            'start_time',
            'end_time',
            'hours',
            'final_price',
            'equipment',
            'serverinfo',
            'account',
            'password',
            'remark',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model::getStatusList()[$model->status];
                }
            ],
            'created_at:dateTime',
            'updated_at:dateTime',
            [
                'attribute' => 'payment_method',
                'value' => function ($model) {
                    return $model::getPaymentMethodList()[$model->payment_method];
                }
            ],
            'client_id',
            'name',
            'description',
        ],
    ]) ?>

</div>
