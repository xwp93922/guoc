<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_freecate".
 *
 * @property integer $id
 * @property integer $site_id
 * @property integer $lang_id
 * @property string $content
 * @property string $img
 * @property integer $sort
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsFreecate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_freecate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'status','lang_id', 'content', 'img', 'sort', 'created_at', 'updated_at'], 'required'],
            [['site_id', 'status','lang_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['img'], 'string', 'max' => 255],
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
            'lang_id' => 'Lang_id',
            'content' => 'Content',
        	'status'=>'Status',
            'img' => 'Img',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
