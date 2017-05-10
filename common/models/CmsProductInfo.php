<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_product_info".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property integer $category_id
 * @property string $product_name
 * @property string $product_info
 * @property string $product_cover
 * @property string $product_content
 * @property integer $status
 * @property integer $recommend
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsProductInfo extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $product_cover_file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_product_info';
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
            [['lang_id', 'site_id', 'category_id', 'product_name', 'product_info', 'product_cover', 'product_content'], 'required'],
            [['lang_id', 'site_id', 'category_id', 'status', 'recommend', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['product_info', 'product_content'], 'string'],
            [['product_name', 'product_cover'], 'string', 'max' => 255],
            [['recommend'], 'default', 'value'=>0],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['product_cover_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
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
            'category_id' => Yii::t('app', 'Category ID'),
            'product_name' => Yii::t('app', 'Product Name'),
            'product_info' => Yii::t('app', 'Product Info'),
            'product_cover' => Yii::t('app', 'Product Cover'),
            'product_cover_file' => Yii::t('app', 'Product Cover'),
            'product_content' => Yii::t('app', 'Product Content'),
            'status' => Yii::t('app', 'Status'),
            'recommend' => Yii::t('app', 'Recommend'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function uploadProductCover($site_id,$dirName='product/images')
    {
        if (empty($this->product_cover_file))
        {
            return false;
        }
        return UtilHelper::upload($this->product_cover_file, $site_id, $dirName);
    }

    public function getCategory(){
        return $this->hasOne(CmsProductCategory::className(), ['id' => 'category_id']);
    }
}
