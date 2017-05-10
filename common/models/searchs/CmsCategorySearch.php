<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CmsCategory;

/**
 * CmsCategorySearch represents the model behind the search form about `common\models\CmsCategory`.
 */
class CmsCategorySearch extends CmsCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lang_id', 'site_id', 'parent_id', 'status','sort_val','created_at'], 'integer'],
            [['name'], 'safe'],
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
        $query = CmsCategory::find();

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
            'parent_id' => $this->parent_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        
        $query->orderBy('sort_val asc,created_at asc');

        return $dataProvider;
    }
}
