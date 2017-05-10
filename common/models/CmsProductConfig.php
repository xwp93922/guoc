<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_product_config".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property string $product_field
 * @property string $product_order_btn
 * @property string $product_detail_title
 * @property string $product_detail_more_title
 * @property string $top_banner
 * @property string $top_banner_name
 * @property string $top_banner_desc
 * @property string $homepage_name
 * @property string $homepage_desc
 * @property string $more_btn_name
 * @property string $inquiry_title
 * @property string $inquiry_field
 * @property string $inquiry_email
 * @property string $inquiry_submit
 * @property string $blank_error
 * @property string $mobile_error
 * @property string $email_error
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsProductConfig extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    public $top_banner_file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_product_config';
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
            [['lang_id', 'site_id', 'product_field', 'inquiry_field', 'inquiry_email'], 'required'],
            [['lang_id', 'site_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['product_field', 'inquiry_field'], 'string'],
            [['product_order_btn'], 'string', 'max' => 40],
            [['product_detail_title', 'product_detail_more_title'], 'string', 'max' => 60],
            [['top_banner', 'top_banner_name', 'top_banner_desc', 'homepage_name', 'homepage_desc', 'more_btn_name', 'inquiry_title', 'inquiry_email', 'inquiry_submit','blank_error','mobile_error','email_error'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
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
            'product_field' => Yii::t('app', 'Product Field'),
            'product_order_btn' => Yii::t('app', 'Product Order Btn'),
            'product_detail_title' => Yii::t('app', 'Product Detail Title'),
            'product_detail_more_title' => Yii::t('app', 'Product Detail More Title'),
            'top_banner' => Yii::t('app', 'Top Banner'),
            'top_banner_file' => Yii::t('app', 'Top Banner'),
            'top_banner_name' => Yii::t('app', 'Top Banner Name'),
            'top_banner_desc' => Yii::t('app', 'Top Banner Desc'),
            'homepage_name' => Yii::t('app', 'Homepage Name'),
            'homepage_desc' => Yii::t('app', 'Homepage Desc'),
            'more_btn_name' => Yii::t('app', 'More Btn Name'),
            'inquiry_title' => Yii::t('app', 'Inquiry Title'),
            'inquiry_field' => Yii::t('app', 'Inquiry Field'),
            'inquiry_email' => Yii::t('app', 'Inquiry Email'),
            'blank_error' => Yii::t('app', 'Blank Error'),
            'mobile_error' => Yii::t('app', 'Mobile Error'),
            'email_error' => Yii::t('app', 'Email Error'),
            'inquiry_submit' => Yii::t('app', 'Inquiry Submit'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function uploadTopBanner($site_id,$dirName='product/images')
    {
        if (empty($this->top_banner_file))
        {
            return false;
        }
        return UtilHelper::upload($this->top_banner_file, $site_id, $dirName);
    }
}
