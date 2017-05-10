<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_about_team".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property integer $about_id
 * @property string $name
 * @property string $headnode
 * @property string $profession
 * @property string $desc
 * @property integer $status
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsAboutTeam extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    public $headnode_file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_about_team';
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
            [['lang_id', 'about_id', 'name', 'headnode'], 'required'],
            [['lang_id', 'site_id', 'about_id', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['name', 'headnode', 'profession', 'desc'], 'string', 'max' => 255],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['headnode_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
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
            'about_id' => Yii::t('app', 'About ID'),
            'name' => Yii::t('app', 'Name'),
            'headnode' => Yii::t('app', 'Headnode'),
            'headnode_file' => Yii::t('app', 'Headnode'),
            'profession' => Yii::t('app', 'Profession'),
            'desc' => Yii::t('app', 'Desc'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadHeadnode($site_id,$dirName='about/images')
    {
        if (empty($this->headnode_file))
        {
            return false;
        }
        return UtilHelper::upload($this->headnode_file, $site_id, $dirName);
    }
}
