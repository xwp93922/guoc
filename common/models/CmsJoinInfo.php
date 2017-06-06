<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_join_info".
 *
 * @property integer $id
 * @property integer $site_id
 * @property integer $lang_id
 * @property string $name
 * @property string $phone
 * @property string $mail
 * @property string $content
 * @property integer $created_at
 * @property integer $status
 */
class CmsJoinInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_join_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'lang_id', 'name', 'phone', 'mail', 'content', 'created_at'], 'required'],
            [['site_id', 'lang_id',  'created_at', 'status'], 'integer'],
            [['phone','content'], 'string'],
            [['name'], 'string', 'max' => 10],
            [['mail'], 'string', 'max' => 50],
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
            'phone' => 'Phone',
            'mail' => 'Mail',
            'content' => 'Content',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
