<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_nav".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $site_id
 * @property string $name
 * @property integer $type
 * @property integer $parent_id
 * @property integer $ext_id
 * @property string $ext_content
 * @property integer $status
 * @property integer $sort_val
 */
class CmsNav extends \yii\db\ActiveRecord
{
    const TYPE_CATEGORY = 1001;
    const TYPE_CATEGORY_SUB = 1002;
    
    const TYPE_PAGE = 2001;
    const TYPE_PAGE_ABOUT = 2002;
    const TYPE_PAGE_CONTACT = 2003;
    const TYPE_PAGE_PROBLEM = 2004;
    const TYPE_PAGE_BRAND = 2005;
    
    const TYPE_CUSTOMER_LINK = 3001;
    const TYPE_PREDEFINED_LINK = 4001;
    
    const TYPE_ALBUM = 5001;
    const TYPE_CASE = 6001;
    
    const TYPE_HOMEPAGE = 7001;
    
    const TYPE_PRODUCT = 8001;
    const TYPE_PRODUCT_CATEGORY = 8002;
    
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_nav';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'site_id', 'name', 'type'], 'required'],
            [['lang_id', 'site_id', 'type', 'ext_id', 'status', 'sort_val'], 'integer'],
            [['name', 'ext_content'], 'string', 'max' => 255],
            [['parent_id', 'ext_id'], 'default', 'value' => 0],
            [['sort_val'], 'default', 'value' => 10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]]
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
            'type' => Yii::t('app', 'Type'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'ext_id' => Yii::t('app', 'Ext ID'),
            'ext_content' => Yii::t('app', 'Ext Content'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
        ];
    }

    public function getChildren(){
        return $this->hasMany(CmsNav::className(), ['parent_id' => 'id'])->orderBy('sort_val asc');
    }
    
    public function getCategroy(){
    	return $this->hasMany(CmsCategory::className(), ['id' => 'ext_id']);
    }
}
