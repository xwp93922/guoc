<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_page_about".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property string $company_name
 * @property string $company_desc
 * @property string $company_slogan
 * @property string $company_keywords
 * @property string $company_idea
 * @property string $company_wish
 * @property string $company_culture
 * @property string $banner
 * @property string $top_banner_name
 * @property string $top_banner_desc
 * @property string $homepage_name
 * @property string $more_btn_name
 * @property string $homepage_left_pic
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsPageAbout extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    public $banner_file;
    public $homepage_left_pic_file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_page_about';
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
            [['lang_id', 'company_name', 'company_desc'], 'required'],
            [['lang_id', 'site_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['company_name', 'company_slogan', 'company_keywords', 'company_idea', 'company_wish', 'company_culture', 'banner', 'homepage_left_pic', 'top_banner_name', 'top_banner_desc', 'homepage_name', 'more_btn_name'], 'string', 'max' => 255],
            [['company_desc'], 'string'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['banner_file', 'homepage_left_pic_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
            
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
            'company_name' => Yii::t('app', 'Company Name'),
            'company_desc' => Yii::t('app', 'Company Desc'),
            'company_slogan' => Yii::t('app', 'Company Slogan'),
            'company_keywords' => Yii::t('app', 'Company Keywords'),
            'company_idea' => Yii::t('app', 'Company Idea'),
            'company_wish' => Yii::t('app', 'Company Wish'),
            'company_culture' => Yii::t('app', 'Company Culture'),
            'banner' => Yii::t('app', 'Top Banner'),
            'banner_file' => Yii::t('app', 'Top Banner'),
            'homepage_left_pic' => Yii::t('app', 'Homepage Left Pic'),
            'homepage_left_pic_file' => Yii::t('app', 'Homepage Left Pic'),
            'top_banner_name' => Yii::t('app', 'Top Banner Name'),
            'top_banner_desc' => Yii::t('app', 'Top Banner Desc'),
            'homepage_name' => Yii::t('app', 'Homepage Name'),
            'more_btn_name' => Yii::t('app', 'More Btn Name'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getTeams(){
        return $this->hasMany(CmsAboutTeam::className(), ['about_id' => 'id'])->where(['status' => 10]);
    }

    public function getEvents(){
        return $this->hasMany(CmsAboutTimeline::className(), ['about_id' => 'id'])->where(['status' => 10])->orderBy('date desc');
    }
    
    public function uploadBanner($site_id,$dirName='about/images')
    {
        if (empty($this->banner_file))
        {
            return false;
        }
        return UtilHelper::upload($this->banner_file, $site_id, $dirName);
    }
    
    public function uploadLeftPic($site_id,$dirName='about/images')
    {
        if (empty($this->homepage_left_pic_file))
        {
            return false;
        }
        return UtilHelper::upload($this->homepage_left_pic_file, $site_id, $dirName);
    }
}
