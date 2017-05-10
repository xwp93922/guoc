<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "gh_plan_order".
 *
 * @property integer $id
 * @property integer $plan_id
 * @property integer $user_id
 * @property integer $site_id
 * @property string $serial_id
 * @property string $transaction_id
 * @property string $price
 * @property integer $count
 * @property string $need_pay
 * @property string $payed
 * @property integer $pay_method
 * @property string $discount_money
 * @property string $discount_note
 * @property integer $status
 * @property string $comment
 * @property integer $plan_expired_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class GhPlanOrder extends \yii\db\ActiveRecord
{
    const STATUS_UNPAID = 10;
    const STATUS_PAID = 11;
    
    const PAY_METHOD_ALIPAY = 1;
    const PAY_METHOD_WXPAY = 2;
    const PAY_METHOD_BANK = 3;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gh_plan_order';
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
            [['plan_id', 'user_id', 'site_id', 'count', 'status', 'plan_expired_at', 'pay_method'], 'integer'],
            [['price', 'need_pay', 'payed', 'discount_money'], 'number'],
            [['discount_note', 'comment', 'serial_id', 'transaction_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'plan_id' => Yii::t('app', 'Plan ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'site_id' => Yii::t('app', 'Site ID'),
            'price' => Yii::t('app', 'Price'),
            'count' => Yii::t('app', 'Count'),
            'need_pay' => Yii::t('app', 'Need Pay'),
            'payed' => Yii::t('app', 'Payed'),
            'discount_money' => Yii::t('app', 'Discount Money'),
            'discount_note' => Yii::t('app', 'Discount Note'),
            'status' => Yii::t('app', 'Status'),
            'comment' => Yii::t('app', 'Comment'),
            'plan_expired_at' => Yii::t('app', 'Plan Expired At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function getPlan()
    {
        return $this->hasOne(GhPlan::className(), ['id' => 'plan_id'])->select(['id','name']);
    }
}
