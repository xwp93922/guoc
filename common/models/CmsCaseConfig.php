<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_case_config".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property string $top_banner
 * @property string $top_banner_name
 * @property string $top_banner_desc
 * @property string $homepage_name
 * @property string $homepage_desc
 * @property string $more_btn_name
 * @property integer $use_category
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsCaseConfig extends \yii\db\ActiveRecord
{
    public $top_banner_file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_case_config';
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
            [['lang_id', 'site_id'], 'required'],
            [['lang_id', 'site_id', 'use_category', 'created_at', 'updated_at'], 'integer'],
            [['top_banner', 'top_banner_name', 'top_banner_desc', 'homepage_name', 'homepage_desc', 'more_btn_name'], 'string', 'max' => 255],

            [['top_banner_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
            
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
            'top_banner' => Yii::t('app', 'Top Banner'),
            'top_banner_file' => Yii::t('app', 'Top Banner'),
            'top_banner_name' => Yii::t('app', 'Top Banner Name'),
            'top_banner_desc' => Yii::t('app', 'Top Banner Desc'),
            'homepage_name' => Yii::t('app', 'Homepage Name'),
            'homepage_desc' => Yii::t('app', 'Homepage Desc'),
            'more_btn_name' => Yii::t('app', 'More Btn Name'),
            'use_category' => Yii::t('app', 'Use Category'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadTopBanner($site_id,$dirName='case/images')
    {
        if (empty($this->top_banner_file))
        {
            return false;
        }
        return UtilHelper::upload($this->top_banner_file, $site_id, $dirName);
    }
}
