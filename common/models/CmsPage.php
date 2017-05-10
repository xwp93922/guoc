<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_page".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $lang_id
 *  @property integer $type
 * @property integer $site_id
 * @property string $name
 * @property string $cover
 * @property string $content
 * @property string $other
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $status
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsPage extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    const TYPE_ABOUT=0;
    const TYPE_NEWS=1;
    const TYPE_CHANGE=2;
    const TYPE_EXAMPLE=3;
    const TYPE_ONBASE=4;
    const TYPE_COMPARE=5;
    public $cover_file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_page';
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
            [['lang_id', 'name', 'content'], 'required'],
            [['lang_id', 'type','parent_id','site_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['content','other'], 'string'],
            [['name', 'cover', 'meta_keywords', 'meta_description'], 'string', 'max' => 255],
            [['sort_val'], 'default', 'value'=>10],
        	[['parent_id','type'], 'default', 'value'=>0],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['cover_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
        	'parent_id' => Yii::t('app', 'Parent_id'),	
            'lang_id' => Yii::t('app', 'Lang ID'),
            'site_id' => Yii::t('app', 'Site ID'),
        	'type' =>Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
        	'other' => Yii::t('app', 'Other'),
            'cover' => Yii::t('app', 'Cover'),
            'cover_file' => Yii::t('app', 'Cover'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadCover($site_id,$dirName='page/images')
    {
        if (empty($this->cover_file))
        {
            return false;
        }
        return UtilHelper::upload($this->cover_file, $site_id, $dirName);
    }
}
