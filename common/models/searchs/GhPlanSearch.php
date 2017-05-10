<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GhPlan;

/**
 * GhPlanSearch represents the model behind the search form about `common\models\GhPlan`.
 */
class GhPlanSearch extends GhPlan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'month', 'remarks', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['name', 'desc', 'suggest', 'equipments', 'space', 'flow', 'image_addon'], 'safe'],
            [['price_origin', 'price'], 'number'],
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
        $query = GhPlan::find();

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
            'price_origin' => $this->price_origin,
            'price' => $this->price,
            'month' => $this->month,
            'remarks' => $this->remarks,
            'status' => $this->status,
            'sort_val' => $this->sort_val,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'suggest', $this->suggest])
            ->andFilterWhere(['like', 'equipments', $this->equipments])
            ->andFilterWhere(['like', 'space', $this->space])
            ->andFilterWhere(['like', 'flow', $this->flow])
            ->andFilterWhere(['like', 'image_addon', $this->image_addon]);

        return $dataProvider;
    }
}
