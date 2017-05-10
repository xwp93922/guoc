<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "gh_site".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $host_name
 * @property integer $type
 * @property integer $plan_id
 * @property integer $plan_created_at
 * @property integer $plan_expired_at
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class GhSite extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gh_site';
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
            [['user_id', 'host_name'], 'required'],
            [['user_id', 'type', 'plan_id', 'plan_created_at', 'plan_expired_at', 'status', 'created_at', 'updated_at'], 'integer'],
            [['host_name'], 'string', 'max' => 255],
            [['host_name'], 'unique'],
            //['host_name', 'url', 'defaultScheme' => 'http'],
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
            'user_id' => Yii::t('app', 'User ID'),
            'host_name' => Yii::t('app', 'Host Name'),
            'type' => Yii::t('app', 'Type'),
            'plan_id' => Yii::t('app', 'Plan ID'),
            'plan_created_at' => Yii::t('app', 'Plan Created At'),
            'plan_expired_at' => Yii::t('app', 'Plan Expired At'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
