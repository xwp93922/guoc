<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\UtilHelper;

class FriendLink extends \yii\db\ActiveRecord{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $logo_file;

    public static function tableName()
    {
        return 'friend_link';
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
            [['lang_id', 'name','site_url','site_id'], 'required'],
            [['lang_id', 'site_id', 'created_at', 'updated_at'], 'integer'],
            [['name','logo'], 'string', 'max' => 255],

            [['logo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lang_id' => Yii::t('app', 'lang id'),
            'site_id' => Yii::t('app', 'site id'),
            'name' => Yii::t('app', 'Name'),
            'site_url' => Yii::t('app', 'Site Url'),
            'logo' => Yii::t('app', 'Logo'),
        ];
    }

    public function uploadLogo($site_id,$dirName='friendlink/images')
    {
        if (empty($this->logo))
        {
            return false;
        }
        return UtilHelper::upload($this->logo, $site_id, $dirName);
    }



}