<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_site_lang".
 *
 * @property integer $id
 * @property integer $site_id
 * @property integer $lang_id
 * @property integer $theme_id
 * @property string $name
 * @property string $flag
 * @property integer $default
 * @property integer $status
 * @property integer $sort_val
 */
class CmsSiteLang extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_site_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'lang_id', 'name'], 'required'],
            [['site_id', 'lang_id', 'theme_id', 'default', 'sort_val'], 'integer'],
            [['name', 'flag'], 'string', 'max' => 255],
            [['theme_id','default'], 'default', 'value' => 0],
            [['sort_val'], 'default', 'value' => 10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'site_id' => Yii::t('app', 'Site ID'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'theme_id' => Yii::t('app', 'Theme ID'),
            'name' => Yii::t('app', 'Name'),
            'flag' => Yii::t('app', 'Flag'),
            'default' => Yii::t('app', 'Default'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
        ];
    }
}
