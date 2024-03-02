<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Prodects]].
 *
 * @see Prodects
 */
class ProdectsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Prodects[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Prodects|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    /** @return \common\models\ProdectsQuery */
    public function published(){
    return $this->andWhere(['status'=>1]);

    }

    public function id($id){
        return $this->andWhere(['id'=>$id]);
    
        }
}
