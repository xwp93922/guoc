<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CmsProductInfo;

/**
 * CmsProductInfoSearch represents the model behind the search form about `common\models\CmsProductInfo`.
 */
class CmsProductInfoSearch extends CmsProductInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lang_id', 'site_id', 'category_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['product_name', 'product_info', 'product_cover', 'product_content'], 'safe'],
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
        $query = CmsProductInfo::find();

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
            'category_id' => $this->category_id,
            'status' => $this->status,
            'sort_val' => $this->sort_val,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_info', $this->product_info])
            ->andFilterWhere(['like', 'product_cover', $this->product_cover])
            ->andFilterWhere(['like', 'product_content', $this->product_content]);

        return $dataProvider;
    }
}
