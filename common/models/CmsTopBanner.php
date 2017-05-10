<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "cms_top_banner".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property string $pos
 * @property string $pic
 * @property string $name
 * @property string $desc
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class CmsTopBanner extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    public $pic_file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_top_banner';
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
            [['lang_id', 'pos', 'pic', 'name', 'desc'], 'required'],
            [['lang_id', 'site_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['pos', 'pic', 'name', 'desc'], 'string', 'max' => 255],
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
            'pos' => Yii::t('app', 'Pos'),
            'pic' => Yii::t('app', 'Pic'),
            'name' => Yii::t('app', 'Name'),
            'desc' => Yii::t('app', 'Description'),
            'pic_file' => Yii::t('app', 'Pic'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function uploadPic($site_id,$dirName='banner/images')
    {
        if (empty($this->pic_file))
        {
            return false;
        }
        return UtilHelper::upload($this->pic_file, $site_id, $dirName);
    }
}
