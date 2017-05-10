<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_problem".
 *
 * @property integer $id
 * @property integer $site_id
 * @property integer $lang_id
 * @property string $title
 * @property string $content
 * @property integer $created_at
 * @property integer $status
 */
class CmsProblem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_problem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'title', 'created_at'], 'required'],
            [['site_id', 'lang_id', 'created_at', 'status'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'content' => 'Content',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
