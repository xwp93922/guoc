<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_category".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property integer $parent_id
 * @property string $name
 * @property string $description
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $image_main
 * @property string $image_node
 * @property string $banner
 * @property integer $sort_val
 * @property integer $status
 * @property integer $necessary
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsCategory extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const CATE_NEWS='news';
    const CATE_LOGIN='login';
    const CATE_JOIN='join';
    const CATE_SYSTEM='system';
    const CATE_QUESTION='question';
    const CATE_FREECATE='freecate';
    const CATE_BRAND='brand';
    public $image_main_file;
    public $image_node_file;
    public $banner_file;
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_category';
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
            [['lang_id', 'name', 'description', 'status'], 'required'],
            [['lang_id', 'site_id', 'parent_id', 'sort_val', 'status', 'created_at', 'updated_at', 'necessary'], 'integer'],
            [['name', 'description', 'meta_keywords', 'meta_description', 'image_main', 'image_node','banner'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],
            [['parent_id', 'necessary'], 'default', 'value'=>0],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['image_main_file','image_node_file','banner_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'image_main' => Yii::t('app', 'Image Main'),
            'image_node' => Yii::t('app', 'Image Node'),
            'image_main_file' => Yii::t('app', 'Image Main'),
            'image_node_file' => Yii::t('app', 'Image Node'),
            'banner' => Yii::t('app', 'Top Banner'),
            'banner_file' => Yii::t('app', 'Top Banner'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'status' => Yii::t('app', 'Status'),
            'necessary' => Yii::t('app', 'Necessary'),
            'type' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getIndexArticles(){
        return $this->hasMany(CmsArticle::className(), ['category_id' => 'id'])->orderBy('sort_val asc')->limit(8);
    }
    
    public function uploadImageMain($site_id,$dirName='category/images')
    {
        if (empty($this->image_main_file))
        {
            return false;
        }
        return UtilHelper::upload($this->image_main_file, $site_id, $dirName);
    }
    
    public function uploadImageNode($site_id,$dirName='category/images')
    {
        if (empty($this->image_node_file))
        {
            return false;
        }
        return UtilHelper::upload($this->image_node_file, $site_id, $dirName);
    }
    
    public function uploadBanner($site_id,$dirName='category/images')
    {
        if (empty($this->banner_file))
        {
            return false;
        }
        return UtilHelper::upload($this->banner_file, $site_id, $dirName);
    }
}
