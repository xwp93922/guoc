<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CmsTheme;

/**
 * CmsThemeSearch represents the model behind the search form about `common\models\CmsTheme`.
 */
class CmsThemeSearch extends CmsTheme
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'site_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['theme_id'], 'safe'],
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
        $query = CmsTheme::find();

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
            'site_id' => $this->site_id,
            'status' => $this->status,
            'sort_val' => $this->sort_val,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'theme_id', $this->theme_id]);

        return $dataProvider;
    }
}
