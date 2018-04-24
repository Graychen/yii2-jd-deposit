<?php

namespace graychen\yii2\jd\deposit\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use graychen\yii2\jd\deposit\models\Order;
use graychen\yii2\jd\deposit\models\OrderDeposit;

/**
 * SearchOrder represents the model behind the search form about `common\models\Order`.
 */
class SearchDeposit extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'game_id', 'type', 'beauty', 'user_id', 'current_tiers', 'current_divisions', 'target_tiers', 'target_divisions', 'mingwen', 'hours', 'equipment', 'status', 'created_at', 'updated_at', 'payment_method'], 'integer'],
            [['sn', 'start_time', 'end_time', 'serverinfo', 'account', 'password', 'remark', 'client_id', 'name', 'description'], 'safe'],
            [['count', 'final_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find()->orderBy('id desc')->andFilterWhere(['like', 'sn', OrderDeposit::SOURCE_JD]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'game_id' => $this->game_id,
            'type' => $this->type,
            'beauty' => $this->beauty,
            'user_id' => $this->user_id,
            'current_tiers' => $this->current_tiers,
            'current_divisions' => $this->current_divisions,
            'target_tiers' => $this->target_tiers,
            'target_divisions' => $this->target_divisions,
            'mingwen' => $this->mingwen,
            'count' => $this->count,
            'hours' => $this->hours,
            'final_price' => $this->final_price,
            'equipment' => $this->equipment,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'payment_method' => $this->payment_method,
        ]);

        $query->andFilterWhere(['like', 'sn', $this->sn])
            ->andFilterWhere(['like', 'start_time', $this->start_time])
            ->andFilterWhere(['like', 'end_time', $this->end_time])
            ->andFilterWhere(['like', 'serverinfo', $this->serverinfo])
            ->andFilterWhere(['like', 'account', $this->account])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'client_id', $this->client_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
