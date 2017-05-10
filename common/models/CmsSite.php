<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_site".
 *
 * @property integer $id
 * @property integer $site_id
 * @property integer $lang_id
 * @property string $name
 * @property string $logo
 * @property string $footer_logo
 * @property string $description
 * @property string $homepage_news_banner
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsSite extends \yii\db\ActiveRecord
{
    public $host_name;
    public $logo_file;
    public $footer_logo_file;
    public $homepage_news_banner_file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_site';
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
            [['site_id','lang_id'], 'required'],
            [['site_id','lang_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'logo' ,'footer_logo', 'description', 'homepage_news_banner'], 'string', 'max' => 255],
            [['logo_file', 'footer_logo_file', 'homepage_news_banner_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
            //[['use_case_category'],'default','value'=>0],
            [['host_name'], 'string', 'max' => 255],
            //['host_name', 'url', 'defaultScheme' => 'http'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'site_id' => Yii::t('app', 'Site ID'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'name' => Yii::t('app', 'Name'),
            'logo' => Yii::t('app', 'Logo'),
            'logo_file' => Yii::t('app', 'Logo'),
            'footer_logo' => Yii::t('app', 'Footer Logo'),
            'footer_logo_file' => Yii::t('app', 'Footer Logo'),
            'description' => Yii::t('app', 'Description'),
            'homepage_news_banner' => Yii::t('app', 'Homepage News Banner'),
            'homepage_news_banner_file' => Yii::t('app', 'Homepage News Banner'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'host_name' => Yii::t('app', 'Host Name'),
        ];
    }
    
    public function uploadLogo($site_id,$dirName='site/images')
    {
        if (empty($this->logo_file))
        {
            return false;
        }
        return UtilHelper::upload($this->logo_file, $site_id, $dirName);
    }
    
    public function uploadFooterLogo($site_id,$dirName='site/images')
    {
        if (empty($this->footer_logo_file))
        {
            return false;
        }
        return UtilHelper::upload($this->footer_logo_file, $site_id, $dirName);
    }
    
    public function uploadHomePageBanner($site_id,$dirName='site/images')
    {
        if (empty($this->homepage_news_banner_file))
        {
            return false;
        }
        return UtilHelper::upload($this->homepage_news_banner_file, $site_id, $dirName);
    }
    
    public function getContact(){
    	return $this->hasOne(CmsPageContact::className(), ['site_id'=>'site_id','lang_id'=>'lang_id']);
    }
    public function getCaseConfig(){
    	return $this->hasOne(CmsCaseConfig::className(), ['site_id'=>'site_id','lang_id'=>'lang_id']);
    }
    public function getAlbumConfig(){
    	return $this->hasOne(CmsAlbumConfig::className(), ['site_id'=>'site_id','lang_id'=>'lang_id']);
    }
	public function getServiceConfig(){
    	return $this->hasOne(CmsServiceConfig::className(), ['site_id'=>'site_id','lang_id'=>'lang_id']);
    }
    public function getShareBtns(){
    	return $this->hasMany(CmsShareBtn::className(), ['site_id'=>'site_id','lang_id'=>'lang_id']);
    }
    public function getPage(){
    	return $this->hasMany(CmsPage::className(), ['site_id'=>'site_id','lang_id'=>'lang_id']);
    }
    public function getLink(){
    	return $this->hasMany(FriendLink::className(), ['site_id'=>'site_id','lang_id'=>'lang_id']);
    }
    public function getHomeConfig(){
    	return $this->hasMany(CmsIndexConfig::className(), ['site_id'=>'site_id','lang_id'=>'lang_id']);
    }
}
