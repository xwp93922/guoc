<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cms_product_pic".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property integer $product_id
 * @property integer $sku_id
 * @property string $image
 * @property integer $status
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsProductPic extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_product_pic';
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
            [['lang_id', 'site_id', 'product_id', 'image'], 'required'],
            [['lang_id', 'site_id', 'product_id', 'sku_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
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
            'sku_id' => Yii::t('app', 'Sku ID'),
            'image' => Yii::t('app', 'Image'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
