<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CmsCase;

/**
 * CmsCaseSearch represents the model behind the search form about `common\models\CmsCase`.
 */
class CmsCaseSearch extends CmsCase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lang_id', 'site_id', 'category_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['name', 'summary', 'content', 'meta_keywords', 'meta_description', 'image_main', 'image_node'], 'safe'],
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
        $query = CmsCase::find();

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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'image_main', $this->image_main])
            ->andFilterWhere(['like', 'image_node', $this->image_node]);

        return $dataProvider;
    }
}
