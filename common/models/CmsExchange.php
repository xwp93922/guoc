<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_exchange".
 *
 * @property integer $id
 * @property string $name
 * @property integer $unit
 * @property string $exc_buy
 * @property string $cash_buy
 * @property string $cash_sale
 * @property string $dicount
 * @property string $updated_at
 */
class CmsExchange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_exchange';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'unit', 'exc_buy', 'cash_buy', 'cash_sale', 'dicount', 'updated_at'], 'required'],
            [['id', 'unit'], 'integer'],
            [['exc_buy', 'cash_buy', 'cash_sale', 'dicount'], 'number'],
            [['updated_at'], 'safe'],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'unit' => 'Unit',
            'exc_buy' => 'Exc Buy',
            'cash_buy' => 'Cash Buy',
            'cash_sale' => 'Cash Sale',
            'dicount' => 'Dicount',
            'updated_at' => 'Updated At',
        ];
    }
}
