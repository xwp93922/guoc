<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CmsProductSku;

/**
 * CmsProductSkuSearch represents the model behind the search form about `common\models\CmsProductSku`.
 */
class CmsProductSkuSearch extends CmsProductSku
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lang_id', 'site_id', 'product_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['name', 'value', 'pic'], 'safe'],
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
        $query = CmsProductSku::find();

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
            'lang_id' => $this->lang_id,
            'site_id' => $this->site_id,
            'product_id' => $this->product_id,
            'status' => $this->status,
            'sort_val' => $this->sort_val,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'pic', $this->pic]);

        return $dataProvider;
    }
}
