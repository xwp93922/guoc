<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "gh_theme".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $code
 * @property string $desc
 * @property string $price_origin
 * @property string $price
 * @property string $features
 * @property string $home_features
 * @property string $image_pc
 * @property string $image_pad
 * @property string $image_phone
 * @property string $image_addon
 * @property integer $type
 * @property integer $status
 * @property integer $sort_val
 * @property integer $necessary
 * @property integer $created_at
 * @property integer $updated_at
 */
class GhTheme extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $image_pc_file;
    public $image_pad_file;
    public $image_phone_file;
    public $image_addon_file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gh_theme';
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
            [['category_id', 'type','id', 'status', 'sort_val', 'created_at', 'updated_at', 'necessary'], 'integer'],
            [['name', 'code', 'desc'], 'required'],
            [['price_origin', 'price'], 'number'],
            [['name', 'code', 'desc', 'image_pc', 'image_pad', 'image_phone', 'image_addon'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['features','home_features'],'safe'],
            [['type', 'necessary'], 'default', 'value'=>0],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['image_pc_file','image_pad_file','image_phone_file','image_addon_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'desc' => Yii::t('app', 'Desc'),
            'price_origin' => Yii::t('app', 'Price Origin'),
            'price' => Yii::t('app', 'Price'),
            'features' => Yii::t('app', 'Features'),
        	'home_features' => Yii::t('app', '	Home_Features'),
            'image_pc' => Yii::t('app', 'Image Pc'),
            'image_pad' => Yii::t('app', 'Image Pad'),
            'image_phone' => Yii::t('app', 'Image Phone'),
            'image_addon' => Yii::t('app', 'Image Addon'),
            'image_pc_file' => Yii::t('app', 'Image Pc'),
            'image_pad_file' => Yii::t('app', 'Image Pad'),
            'image_phone_file' => Yii::t('app', 'Image Phone'),
            'image_addon_file' => Yii::t('app', 'Image Addon'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'necessary' => Yii::t('app', 'Necessary'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadImagePc($site_id,$dirName='theme/images')
    {
        if (empty($this->image_pc_file))
        {
            return false;
        }
        return UtilHelper::upload($this->image_pc_file, $site_id, $dirName);
    }
    
    public function uploadImagePad($site_id,$dirName='theme/images')
    {
        if (empty($this->image_pad_file))
        {
            return false;
        }
        return UtilHelper::upload($this->image_pad_file, $site_id, $dirName);
    }
    
    public function uploadImagePhone($site_id,$dirName='theme/images')
    {
        if (empty($this->image_phone_file))
        {
            return false;
        }
        return UtilHelper::upload($this->image_phone_file, $site_id, $dirName);
    }
    
    public function uploadImageAddon($site_id,$dirName='theme/images')
    {
        if (empty($this->image_addon_file))
        {
            return false;
        }
        return UtilHelper::upload($this->image_addon_file, $site_id, $dirName);
    }
}
