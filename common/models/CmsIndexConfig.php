<?php

namespace common\models;

use Yii;
use common\helpers\UtilHelper;
use Prophecy\Doubler\Generator\Node\ClassNode;

/**
 * This is the model class for table "cms_index_config".
 *
 * @property integer $id
 * @property integer $site_id
 * @property integer $lang_id
 * @property string $value
 * @property integer $status
 * @property integer $config_id
 * @property string $feature
 */
class CmsIndexConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $image;
    public static function tableName()
    {
        return 'cms_index_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'lang_id','value',  'config_id', 'status'], 'required'],
            [['site_id', 'lang_id', 'config_id','status'], 'integer'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'site_id' => Yii::t('app', 'Site ID'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'value' => Yii::t('app', 'Value'),
            'config_id'=> Yii::t('app', 'Config_id'),
            'status' => Yii::t('app', 'Status'),
        	'feature'=>	Yii::t('app', 'feature')
        ];
    }
    public function uploadImage($site_id,$dirName='config/images')
    {
    	if (empty($this->image))
    	{
    		return false;
    	}
    	return UtilHelper::upload($this->image,$site_id,  $dirName);
    } 
    public function getType(){
    	return $this->hasOne(CmsConfigType::className(), ['config_id'=>'id']);
    }
}
