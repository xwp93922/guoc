<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_brand_category".
 *
 * @property integer $id
 * @property string $cat_name
 * @property string $cat_desc
 */
class CmsBrandCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_brand_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_name', 'cat_desc'], 'required'],
            [['id'], 'integer'],
            [['cat_desc'], 'string'],
            [['cat_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => 'Cat Name',
            'cat_desc' => 'Cat Desc',
        ];
    }
}
