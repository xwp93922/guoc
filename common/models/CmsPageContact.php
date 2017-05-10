<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_page_contact".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property string $name
 * @property string $phone
 * @property string $telephone
 * @property string $longitude
 * @property string $latitude
 * @property string $address
 * @property string $map_img
 * @property string $email
 * @property string $qq
 * @property string $zipcode
 * @property string $wxopenid
 * @property string $banner
 * @property string $top_banner_name
 * @property string $top_banner_desc
 * @property integer $status
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsPageContact extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $wxopenid_file;
    public $banner_file;
    public $map_img_file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_page_contact';
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
            [['lang_id', 'name', 'phone', 'address'], 'required'],
            [['lang_id', 'site_id', 'status', 'sort_val', 'created_at', 'updated_at', 'qq', 'zipcode'], 'integer'],
            [['name', 'phone', 'telephone', 'qq', 'zipcode'], 'string', 'max' => 20],
            [['longitude', 'latitude'], 'string', 'max' => 40],
            [['address'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 60],
            [['wxopenid','banner', 'top_banner_name', 'top_banner_desc','map_img'], 'string', 'max' => 255],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['email'], 'email'],
            [['phone'],'match','pattern'=>'/^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$|^([0-9]{3,4}-)?[0-9]{7,8}$/'],
            [['wxopenid_file','banner_file','map_img_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
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
            'phone' => Yii::t('app', 'Phone'),
			'telephone'  => Yii::t('app', 'Telephone'),
            'longitude' => Yii::t('app', 'Longitude'),
            'latitude' => Yii::t('app', 'Latitude'),
            'address' => Yii::t('app', 'Address'),
            'map_img' => Yii::t('app', 'Map Img'),
            'map_img_file' => Yii::t('app', 'Map Img'),
            'email' => Yii::t('app', 'Email'),
            'qq' => Yii::t('app', 'Qq'),
            'zipcode' => Yii::t('app', 'Zipcode'),
            'wxopenid' => Yii::t('app', 'Wxopenid'),
            'wxopenid_file' => Yii::t('app', 'Wxopenid'),
            'banner' => Yii::t('app', 'Top Banner'),
            'banner_file' => Yii::t('app', 'Top Banner'),
            'top_banner_name' => Yii::t('app', 'Top Banner Name'),
            'top_banner_desc' => Yii::t('app', 'Top Banner Desc'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadWxopenid($site_id,$dirName='contact/images')
    {
        if (empty($this->wxopenid_file))
        {
            return false;
        }
        return UtilHelper::upload($this->wxopenid_file, $site_id, $dirName);
    }
    
    public function uploadBanner($site_id,$dirName='contact/images')
    {
        if (empty($this->banner_file))
        {
            return false;
        }
        return UtilHelper::upload($this->banner_file, $site_id, $dirName);
    }
    
    public function uploadMapImg($site_id,$dirName='contact/images')
    {
        if (empty($this->map_img_file))
        {
            return false;
        }
        return UtilHelper::upload($this->map_img_file, $site_id, $dirName);
    }
}
