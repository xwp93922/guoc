<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cms_banner".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property string $pos
 * @property integer $status
 * @property integer $sort_val
 * @property integer $necessary
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsBanner extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_banner';
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
            [['lang_id', 'site_id', 'pos'], 'required'],
            [['lang_id', 'site_id', 'status', 'sort_val', 'created_at', 'updated_at', 'necessary'], 'integer'],
            [['necessary'], 'default', 'value'=>0],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['pos'], 'safe'],
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
            'pos' => Yii::t('app', 'Pos'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'necessary' => Yii::t('app', 'Necessary'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getImages(){
        return $this->hasMany(CmsBannerPic::className(), ['banner_id' => 'id'])->orderBy('sort_val asc');
    }
}
