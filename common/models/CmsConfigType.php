<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_config_type".
 *
 * @property integer $id
 * @property string $feature
 * @property string $name
 * @property string $code
 * @property integer $status
 * @property integer $type
 */
class CmsConfigType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	const CONFIG_RADIO=1;
	const CONFIG_INPUT=2;
	const CONFGI_IMAGE=3;
	const CONFIG_SELECT=4;
    public static function tableName()
    {
        return 'cms_config_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feature', 'name','code', 'type'], 'required'],
            [['status', 'type'], 'integer'],
            [['name', 'code'], 'string', 'max' => 20],
        	['status','default','value'=>10],
        	['features','safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'feature' => Yii::t('app', 'Feature'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'status' => Yii::t('app', 'Status'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
}
