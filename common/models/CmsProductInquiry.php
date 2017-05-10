<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cms_product_inquiry".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property integer $product_id
 * @property string $inquiry_detail
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsProductInquiry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_product_inquiry';
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
            [['lang_id', 'site_id', 'product_id', 'inquiry_detail'], 'required'],
            [['lang_id', 'site_id', 'product_id', 'created_at', 'updated_at'], 'integer'],
            [['inquiry_detail'], 'string'],
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
            'product_id' => Yii::t('app', 'Product Name'),
            'inquiry_detail' => Yii::t('app', 'Inquiry Detail'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getProduct(){
        return $this->hasOne(CmsProductInfo::className(), ['id' => 'product_id']);
    }
}
