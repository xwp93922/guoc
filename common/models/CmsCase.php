<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_case".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property integer $category_id
 * @property string $name
 * @property string $summary
 * @property string $content
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $image_main
 * @property string $image_node
 * @property integer $status
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsCase extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $image_main_file;
    public $image_node_file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_case';
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
            [['lang_id', 'name', 'summary', 'content'], 'required'],
            [['lang_id', 'site_id', 'category_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['name', 'summary', 'meta_keywords', 'meta_description', 'image_main', 'image_node'], 'string', 'max' => 255],

            [['category_id'], 'default', 'value'=>0],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['image_main_file','image_node_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
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
            'name' => Yii::t('app', 'Name'),
            'summary' => Yii::t('app', 'Summary'),
            'content' => Yii::t('app', 'Content'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'image_main' => Yii::t('app', 'Image Main'),
            'image_node' => Yii::t('app', 'Image Node'),
            'image_main_file' => Yii::t('app', 'Image Main'),
            'image_node_file' => Yii::t('app', 'Image Node'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadImageMain($site_id,$dirName='case/images')
    {
        if (empty($this->image_main_file))
        {
            return false;
        }
        return UtilHelper::upload($this->image_main_file, $site_id, $dirName);
    }
    
    public function uploadImageNode($site_id,$dirName='case/images')
    {
        if (empty($this->image_node_file))
        {
            return false;
        }
        return UtilHelper::upload($this->image_node_file, $site_id, $dirName);
    }

    public function getCategory(){
        return $this->hasOne(CmsCaseCategory::className(), ['id' => 'category_id']);
    }
}
