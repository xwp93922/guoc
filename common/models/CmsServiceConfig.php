<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cms_service_config".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property string $homepage_name
 * @property string $homepage_desc
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsServiceConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_service_config';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'site_id'], 'required'],
            [['lang_id', 'site_id', 'created_at', 'updated_at'], 'integer'],
            [['homepage_name', 'homepage_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'site_id' => Yii::t('app', 'Site ID'),
            'homepage_name' => Yii::t('app', 'Homepage Name'),
            'homepage_desc' => Yii::t('app', 'Homepage Desc'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
