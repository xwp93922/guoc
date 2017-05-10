<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_product_sku".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property integer $product_id
 * @property string $name
 * @property string $value
 * @property string $pic
 * @property integer $status
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsProductSku extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    public $pic_file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_product_sku';
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
            [['lang_id', 'site_id', 'product_id', 'name', 'value', 'pic'], 'required'],
            [['lang_id', 'site_id', 'product_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['name', 'value', 'pic'], 'string', 'max' => 255],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['pic_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
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
            'product_id' => Yii::t('app', 'Product ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'pic' => Yii::t('app', 'Pic'),
            'pic_file' => Yii::t('app', 'Pic'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadPic($site_id,$dirName='product/images')
    {
        if (empty($this->pic_file))
        {
            return false;
        }
        return UtilHelper::upload($this->pic_file, $site_id, $dirName);
    }

    public function getPics(){
        return $this->hasMany(CmsProductPic::className(), ['sku_id' => 'id'])->orderBy('sort_val asc');
    }
}
