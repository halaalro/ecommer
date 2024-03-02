<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_items}}".
 *
 * @property int $id
 * @property string $prodect_name
 * @property int|null $prodect_id
 * @property float $unit_price
 * @property int $order_id
 * @property int $quantity
 */
class OrderItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_items}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prodect_name', 'prodect_id', 'unit_price', 'order_id', 'quantity'], 'required'],
            [['prodect_id', 'order_id', 'quantity'], 'integer'],
            [['unit_price'], 'number'],
            [['prodect_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prodect_name' => 'Prodect Name',
            'prodect_id' => 'Prodect ID',
            'unit_price' => 'Unit Price',
            'order_id' => 'Order ID',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * {@inheritdoc}
     * @return OrderItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderItemsQuery(get_called_class());
    }
    public function getOrderBy()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
    }
    public function getProtectBy()
    {
        return $this->hasOne(Prodects::class, ['id' => 'prodect_id']);
    }  public function getProdid()
    {
        return $this->hasOne(Prodects::class, ['id' => 'prodid']);
    }
}
