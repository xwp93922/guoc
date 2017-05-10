<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cms_album_pic".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property integer $album_id
 * @property string $name
 * @property string $desc
 * @property string $url
 * @property integer $status
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsAlbumPic extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_album_pic';
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
            [['lang_id', 'album_id', 'name', 'url'], 'required'],
            [['lang_id', 'site_id', 'album_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['name', 'desc', 'url'], 'string', 'max' => 255],
            [['sort_val'], 'default', 'value'=>10],
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
            'album_id' => Yii::t('app', 'Album ID'),
            'name' => Yii::t('app', 'Name'),
            'desc' => Yii::t('app', 'Desc'),
            'url' => Yii::t('app', 'Url'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
