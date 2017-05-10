<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_album".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property string $name
 * @property string $cover
 * @property string $desc
 * @property integer $count_pic
 * @property integer $status
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsAlbum extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    public $cover_file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_album';
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
            [['lang_id', 'name'], 'required'],
            [['lang_id', 'site_id', 'count_pic', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['name', 'cover', 'desc'], 'string', 'max' => 255],
            [['sort_val'], 'default', 'value'=>10],
            [['count_pic'], 'default', 'value'=>0],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['cover_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
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
            'name' => Yii::t('app', 'Name'),
            'cover' => Yii::t('app', 'Cover'),
            'desc' => Yii::t('app', 'Desc'),
            'cover_file' => Yii::t('app', 'Cover'),
            'count_pic' => Yii::t('app', 'Count Pic'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadCover($site_id,$dirName='album/images')
    {
        if (empty($this->cover_file))
        {
            return false;
        }
        return UtilHelper::upload($this->cover_file, $site_id, $dirName);
    }

    public function getPics(){
        return $this->hasMany(CmsAlbumPic::className(), ['album_id' => 'id'])->orderBy('sort_val asc');
    }
}
