<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GhPlanOrder;

/**
 * GhPlanOrderSearch represents the model behind the search form about `common\models\GhPlanOrder`.
 */
class GhPlanOrderSearch extends GhPlanOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'plan_id', 'user_id', 'site_id', 'count', 'status', 'plan_expired_at', 'created_at', 'updated_at'], 'integer'],
            [['price', 'need_pay', 'payed', 'discount_money'], 'number'],
            [['discount_note', 'comment'], 'safe'],
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
        $query = GhPlanOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'plan_id' => $this->plan_id,
            'user_id' => $this->user_id,
            'site_id' => $this->site_id,
            'price' => $this->price,
            'count' => $this->count,
            'need_pay' => $this->need_pay,
            'payed' => $this->payed,
            'discount_money' => $this->discount_money,
            'status' => $this->status,
            'plan_expired_at' => $this->plan_expired_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'discount_note', $this->discount_note])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
