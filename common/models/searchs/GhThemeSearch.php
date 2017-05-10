<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GhTheme;

/**
 * GhThemeSearch represents the model behind the search form about `common\models\GhTheme`.
 */
class GhThemeSearch extends GhTheme
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'type', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code', 'desc', 'features', 'image_pc', 'image_pad', 'image_phone', 'image_addon'], 'safe'],
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
        $query = GhTheme::find();

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
            'category_id' => $this->category_id,
            'price_origin' => $this->price_origin,
            'price' => $this->price,
            'type' => $this->type,
            'status' => $this->status,
            'sort_val' => $this->sort_val,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'features', $this->features])
            ->andFilterWhere(['like', 'image_pc', $this->image_pc])
            ->andFilterWhere(['like', 'image_pad', $this->image_pad])
            ->andFilterWhere(['like', 'image_phone', $this->image_phone])
            ->andFilterWhere(['like', 'image_addon', $this->image_addon]);

        return $dataProvider;
    }
}
