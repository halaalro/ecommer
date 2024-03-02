<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CartItems]].
 *
 * @see CartItems
 */
class CartItemsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CartItems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CartItems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    } 
    /**
     * @param $userId
     *@return common/models/CartItemsQuery
     **/
    public function userId($userId)
    {
        return $this->andWhere(['created_by'=>$userId]);
    }
    /**
     * @param $prodectId
     *@return common/models/CartItemsQuery
     **/
    public function prodectId($prodectId)
    {
        return $this->andWhere(['product_id'=>$prodectId]);
    }
    /**
    * @param $orderId
    *@return common/models/CartItemsQuery
    **/
    public function orderId($orderId)
    {
        return $this->andWhere(['id'=>$orderId]);
    }
}
