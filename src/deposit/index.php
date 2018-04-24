<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use common\models\OrderDeposit;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchOrder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '京东订单管理');
$this->params['breadcrumbs'][] = $this->title;
$css = <<<CSS
#search-option{

}
CSS;
$this->registerCss($css);
?>
<div class="premium-order-index">
    <div id="search-option">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-3\">{input}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ]
    ]); ?>

    <?= $form->field($searchModel, 'sn')->textInput(['placeholder' => '订单号'])->label(null); ?>

    <?= $form->field($searchModel, 'status')->dropDownList(['' => '支付状态'] + OrderDeposit::getStatusList())->label(null); ?>

    <?= $form->field($searchModel, 'start_time')->widget(DateTimePicker::classname(),
        ['options' => ['placeholder' => '开始时间'],
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd',
                'inline' => true,
            ]
        ])->label("预约开始时间");
    ?>
    <?= $form->field($searchModel, 'end_time')->widget(DateTimePicker::classname(),
        ['options' => ['placeholder' => '截止时间'],
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd',
                'inline' => true,
            ]
        ])->label(' 预约结束时间 ');
    ?>
    <div class="col-lg-3">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    </div>
    <div class="order-index">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'sn',
                'name',
                //'game_id',
                // 'user_id',
                // 'current_tiers',
                // 'current_divisions',
                // 'target_tiers',
                // 'target_divisions',
                // 'mingwen',
                'final_price',
                // 'equipment',
                // 'serverinfo',
                // 'password',
                // 'remark',
                'created_at:dateTime',
                [
                    'attribute' => 'payment_method',
                    'value' => function ($model) {
                        return '京东支付';
                    }
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        return OrderDeposit::getStatusList()[$model->status];
                    }
                ],
                // 'client_id',
                // 'description',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {successStatus} {failStatus}',
                    'buttons' => [
                        'successStatus' => function ($url, $model, $key) {
                            return Html::a('<span>充值成功</span>', 'javascript:void(0);', [
                                'title' => '充值成功',
                                'onclick' => 'changeStatus(' . substr($model->sn, 2) . ',0,this)'
                            ]);
                        },
                        'failStatus' => function ($url, $model, $key) {
                            return Html::a('<span>充值失败</span>', 'javascript:void(0);', [
                                'title' => '充值失败',
                                'onclick' => 'changeStatus(' . substr($model->sn, 2) . ',2,this)'
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
<?php
$url = Url::to(['deposit/game']);
$js = <<<JS
  function changeStatus(orderId,status,target){
    $.ajax({
            type: 'POST',
            data: {
              orderId:orderId,
              orderStatus:status
            },
            cache: false,
            url: '$url',
            success: function(response) {
              if(response.retCode==100){
                  console.log(response);
                  $(target).parent().prev().html('充值成功');
              }else{
                  alert("修改订单失败")
              }
            }
        });
  }
JS;
$this->registerJs($js, View::POS_END);
?>
