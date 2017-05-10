<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_brand".
 *
 * @property integer $id
 * @property integer $site_id
 * @property integer $lang_id
 * @property string $name
 * @property string $desc
 * @property string $logo
 * @property string $pic
 * @property integer $created_at
 * @property integer $view_count
 * @property integer $status
 */
class CmsBrand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'name', 'created_at'], 'required'],
            [['site_id', 'lang_id', 'created_at', 'view_count', 'status'], 'integer'],
            [['desc'], 'string'],
            [['name', 'logo', 'pic'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'site_id' => 'Site ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'logo' => 'Logo',
            'pic' => 'Pic',
            'created_at' => 'Created At',
            'view_count' => 'View Count',
            'status' => 'Status',
        ];
    }
}
