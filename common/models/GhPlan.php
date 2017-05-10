<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "gh_plan".
 *
 * @property integer $id
 * @property string $name
 * @property string $price_origin
 * @property string $price
 * @property string $desc
 * @property string $suggest
 * @property string $equipments
 * @property string $space
 * @property string $flow
 * @property integer $month
 * @property integer $remarks
 * @property string $image_addon
 * @property integer $status
 * @property integer $sort_val
 * @property integer $created_at
 * @property integer $updated_at
 */
class GhPlan extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gh_plan';
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
            [['name', 'desc', 'suggest', 'equipments', 'space', 'flow', 'month'], 'required'],
            [['price_origin', 'price'], 'number'],
            [['desc', 'suggest', 'equipments', 'space', 'flow'], 'string'],
            [['month', 'remarks', 'status', 'sort_val', 'created_at', 'updated_at'], 'integer'],
            [['name', 'image_addon'], 'string', 'max' => 255],
            [['sort_val'], 'default', 'value'=>10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
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
            'price_origin' => Yii::t('app', 'Price Origin'),
            'price' => Yii::t('app', 'Price'),
            'desc' => Yii::t('app', 'Desc'),
            'suggest' => Yii::t('app', 'Suggest'),
            'equipments' => Yii::t('app', 'Equipments'),
            'space' => Yii::t('app', 'Space'),
            'flow' => Yii::t('app', 'Flow'),
            'month' => Yii::t('app', 'Month'),
            'remarks' => Yii::t('app', 'Remarks'),
            'image_addon' => Yii::t('app', 'Image Addon'),
            'status' => Yii::t('app', 'Status'),
            'sort_val' => Yii::t('app', 'Sort Val'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
