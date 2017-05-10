<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cms_about_timeline".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property integer $about_id
 * @property string $date
 * @property string $content
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsAboutTimeline extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_about_timeline';
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
            [['lang_id', 'about_id', 'date', 'content'], 'required'],
            [['lang_id', 'site_id', 'about_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
            [['content'], 'string'],
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
            'lang_id' => Yii::t('app', 'Lang ID'),
            'site_id' => Yii::t('app', 'Site ID'),
            'about_id' => Yii::t('app', 'About ID'),
            'date' => Yii::t('app', 'Date'),
            'content' => Yii::t('app', 'Content'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
