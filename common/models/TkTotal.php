<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tk_total".
 *
 * @property integer $id
 * @property integer $Cid
 * @property integer $GoodsID
 * @property string $SellerID
 * @property string $Quan_id
 * @property string $D_title
 * @property string $Title
 * @property double $Dsr
 * @property double $Commission_queqiao
 * @property string $Jihua_link
 * @property double $Price
 * @property integer $Jihua_shenhe
 * @property string $Introduce
 * @property integer $Sales_num
 * @property integer $IsTmall
 * @property double $Commission_jihua
 * @property string $Pic
 * @property double $Org_Price
 * @property integer $Quan_receive
 * @property double $Quan_price
 * @property string $Quan_time
 * @property string $Quan_link
 * @property string $Quan_m_link
 * @property string $ali_click
 * @property string $Quan_condition
 * @property integer $Quan_surplus
 */
class TkTotal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tk_total';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Cid', 'GoodsID',  'SellerID', 'Quan_id', 'D_title', 'Title', 'Dsr', 'Commission_queqiao', 'Jihua_link', 'Price', 'Jihua_shenhe', 'Introduce', 'Sales_num', 'IsTmall', 'Commission_jihua',  'Pic', 'Org_Price', 'Quan_receive', 'Quan_price', 'Quan_time', 'Quan_link', 'Quan_m_link', 'Quan_condition', 'Quan_surplus','ali_click'], 'required'],
            [['Cid', 'GoodsID', 'Jihua_shenhe', 'Sales_num', 'IsTmall', 'Quan_receive', 'Quan_surplus'], 'integer'],
            [['Dsr', 'Commission_queqiao', 'Price', 'Commission_jihua',  'Org_Price', 'Quan_price'], 'number'],
            [['SellerID', 'Quan_id'], 'string', 'max' => 20],
            [['D_title', 'Title', 'Jihua_link', 'Introduce', 'Pic', 'Quan_link', 'Quan_m_link', 'Quan_condition'], 'string', 'max' => 255],
            [['Quan_time'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'Cid' => Yii::t('app', 'Cid'),
            'GoodsID' => Yii::t('app', 'Goods ID'),
            'SellerID' => Yii::t('app', 'Seller ID'),
            'Quan_id' => Yii::t('app', 'Quan ID'),
            'D_title' => Yii::t('app', 'D Title'),
            'Title' => Yii::t('app', 'Title'),
            'Dsr' => Yii::t('app', 'Dsr'),
            'Commission_queqiao' => Yii::t('app', 'Commission Queqiao'),
            'Jihua_link' => Yii::t('app', 'Jihua Link'),
            'Price' => Yii::t('app', 'Price'),
            'Jihua_shenhe' => Yii::t('app', 'Jihua Shenhe'),
            'Introduce' => Yii::t('app', 'Introduce'),
            'Sales_num' => Yii::t('app', 'Sales Num'),
            'IsTmall' => Yii::t('app', 'Is Tmall'),
            'Commission_jihua' => Yii::t('app', 'Commission Jihua'),
            'Pic' => Yii::t('app', 'Pic'),
            'Org_Price' => Yii::t('app', 'Org  Price'),
            'Quan_receive' => Yii::t('app', 'Quan Receive'),
            'Quan_price' => Yii::t('app', 'Quan Price'),
            'Quan_time' => Yii::t('app', 'Quan Time'),
            'Quan_link' => Yii::t('app', 'Quan Link'),
            'Quan_m_link' => Yii::t('app', 'Quan M Link'),
            'Quan_condition' => Yii::t('app', 'Quan Condition'),
            'Quan_surplus' => Yii::t('app', 'Quan Surplus'),
        	'ali_click' => Yii::t('app', 'Ali_click'),
        ];
    }
    
    public function getClass(){
    	return $this->hasOne(TkClassInfo::className(), ['id'=>'Cid']);
    }
}
