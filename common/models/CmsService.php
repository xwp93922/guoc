<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_service".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property string $name
 * @property string $description
 * @property string $content
 * @property string $cover
 * @property string $cover_hover
 * @property integer $status
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsService extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    public $cover_file;
    public $cover_hover_file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_service';
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
            [['lang_id', 'name', 'description', 'cover'], 'required'],
            [['lang_id', 'site_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['cover','cover_hover','content'], 'string'],
            [['name', 'description'], 'string', 'max' => 255],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['cover_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
        	[['cover_hover_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
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
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        	'content'	=>yii::t('app','Content'),
            'cover' => Yii::t('app', 'Cover'),
            'cover_file' => Yii::t('app', 'Cover'),
        	'cover_hover' => Yii::t('app', 'cover_hover'),
        	'cover_hover_file' => Yii::t('app', 'cover_hover'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadCover($site_id,$dirName='service/images')
    {
        if (empty($this->cover_file))
        {
            return false;
        }
        return UtilHelper::upload($this->cover_file, $site_id, $dirName);
    }
    public function uploadCoverHover($site_id,$dirName='service/images')
    {
    	if (empty($this->cover_hover_file))
    	{
    		return false;
    	}
    	return UtilHelper::upload($this->cover_hover_file, $site_id, $dirName);
    }
}
