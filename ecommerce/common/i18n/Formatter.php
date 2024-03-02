<?php
/**
 * User: TheCodeholic
 * Date: 12/18/2020
 * Time: 10:48 AM
 */

namespace common\i18n;

/**
 * Class Formatter
 *
 * @author  
 * @package common\i18n
 */
class Formatter extends \yii\i18n\Formatter
{
    public function asOrderStatus($status)
    {
        if ($status == \common\models\Orders::STATUS_COMPLETED) {
            return \yii\bootstrap5\Html::tag('span', 'Completed', ['class' => 'badge badge-success']);
        } else if ($status == \common\models\Orders::STATUS_PAID) {
            return \yii\bootstrap5\Html::tag('span', 'Paid', ['class' => 'badge badge-primary']);
        } else if ($status == \common\models\Orders::STATUS_DRAFT) {
            return \yii\bootstrap5\Html::tag('span', 'Unpaid', ['class' => 'badge badge-secondary']);
        } else {
            return \yii\bootstrap5\Html::tag('span', 'Failured', ['class' => 'badge badge-danger']);
        }
    }

    public function asProdectStatus($status)
    {
        if ($status == \common\models\Prodects::STATUS_Active) {
            return \yii\bootstrap5\Html::tag('span', 'Active', ['class' => 'badge badge-success']);
        } 
         else if ($status == \common\models\Prodects::STATUS_UNACTIVE) {
            return \yii\bootstrap5\Html::tag('span', 'Unactive', ['class' => 'badge badge-secondary']);
        } 
    } 
    
    
    public function asUserStatus($status)
    {
        if ($status == \common\models\User::STATUS_ACCESS) {
            return \yii\bootstrap5\Html::tag('span', 'Access', ['class' => 'badge badge-success']);
        } 
         else if ($status == \common\models\User::STATUS_NOACCESS) {
            return \yii\bootstrap5\Html::tag('span', 'UnAccess', ['class' => 'badge badge-secondary']);
        } 
    }
}