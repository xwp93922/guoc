<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CmsIndexConfig;

/**
 * CmsIndexConfigSearch represents the model behind the search form about `common\models\CmsIndexConfig`.
 */
class CmsIndexConfigSearch extends CmsIndexConfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'site_id', 'config_id','lang_id', 'status'], 'integer'],
            [['value'], 'safe'],
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
        $query = CmsIndexConfig::find();

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
            'lang_id' => $this->lang_id,
            'status' => $this->status,
        	'config_id'=>$this->config_id
        ]);

        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
