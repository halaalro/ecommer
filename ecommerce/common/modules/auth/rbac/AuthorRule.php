<?php

namespace common\modules\auth\rbac;
use yii\rbac\Rule;
use app\models\Post;

/**
 * Checks if authorID matches user passed via params
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {


        if (isset($params['model'])) {

            $model=$params['model'];}
            else{

                $id=\Yii::$app->request->get('id');
                $model=\Yii::$app->controller->findUserModel($id);
            }
            return $model->cretedBy==$user;
       // return isset($params['post']) ? $params['post']->createdBy == $user : false;
    }
}










?>