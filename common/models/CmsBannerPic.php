<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_banner_pic".
 *
 * @property integer $id
 * @property integer $banner_id
 * @property string $image
 * @property string $link
 * @property integer $status
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsBannerPic extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $image_file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_banner_pic';
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
            [['banner_id', 'image', 'link'], 'required'],
            [['banner_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['image'], 'string'],
            [['link'], 'string', 'max' => 255],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['image_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),	
            'banner_id' => Yii::t('app', 'Banner ID'),
            'image' => Yii::t('app', 'Image'),
            'image_file' => Yii::t('app', 'Image'),
            'link' => Yii::t('app', 'Link'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadImage($site_id,$dirName='banner/images')
    {
        if (empty($this->image_file))
        {
            return false;
        }
        return UtilHelper::upload($this->image_file, $site_id, $dirName);
    }
}
