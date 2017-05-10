<?php

namespace common\models;

use Yii;
use common\helpers\UtilHelper;

/**
 * This is the model class for table "gh_config_lang".
 *
 * @property integer $id
 * @property string $name
 * @property string $name18n
 * @property string $flag
 * @property integer $sort_val
 * @property integer $necessary
 */
class GhConfigLang extends \yii\db\ActiveRecord
{
    public $flag_file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gh_config_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'name18n'], 'required'],
            [['sort_val','necessary'], 'integer'],
            [['necessary'], 'default', 'value'=>0],
            [['sort_val'], 'default', 'value'=>10],
            [['name', 'name18n', 'flag'], 'string', 'max' => 255],
            [['flag_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 1024*1024*2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'name18n' => Yii::t('app', 'Name18n'),
            'flag' => Yii::t('app', 'Flag'),
            'flag_file' => Yii::t('app', 'Flag'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'necessary' => Yii::t('app', 'Necessary'),
        ];
    }
    
    public function uploadFlag($site_id,$dirName='lang/images')
    {
        if (empty($this->flag_file))
        {
            return false;
        }
        return UtilHelper::upload($this->flag_file, $site_id, $dirName);
    }
}
