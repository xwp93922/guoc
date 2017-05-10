<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_share_btn".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property string $name
 * @property integer $type
 * @property string $pic
 * @property string $content
 * @property integer $sort_val
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsShareBtn extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const TYPE_LINK = 1001;
    const TYPE_QRCODE = 2001;
    
    public $pic_file;
    public $content_file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_share_btn';
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
            [['lang_id', 'site_id', 'name', 'type', 'pic', 'content'], 'required'],
            [['lang_id', 'site_id', 'type', 'sort_val', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'pic', 'content'], 'string', 'max' => 255],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['pic_file', 'content_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
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
            'type' => Yii::t('app', 'Type'),
            'pic' => Yii::t('app', 'Pic'),
            'pic_file' => Yii::t('app', 'Pic'),
            'content_file' => Yii::t('app', 'Qrcode'),
            'content' => Yii::t('app', 'Link'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadPic($site_id,$dirName='share/images')
    {
        if (empty($this->pic_file))
        {
            return false;
        }
        return UtilHelper::upload($this->pic_file, $site_id, $dirName);
    }
    
    public function uploadContent($site_id,$dirName='share/images')
    {
        if (empty($this->content_file))
        {
            return false;
        }
        return UtilHelper::upload($this->content_file, $site_id, $dirName);
    }
}
