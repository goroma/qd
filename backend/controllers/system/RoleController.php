<?php

namespace backend\controllers\system;

use Yii;
use yii\web\HttpException;
use yii\web\ForbiddenHttpException;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\auth\Auth;
use common\models\auth\AuthItem;
use common\models\auth\AuthSearch;
use common\models\auth\AuthItemChild;
use common\models\common\Common;
use backend\components\RbacHelper;
use backend\components\BaseAuthController;

/**
 * @author bobo
 */
class RoleController extends BaseAuthController
{
    public function init()
    {
        AuthItem::addDefaultRoles();
    }

    public function beforeAction($action)
    {
        $name = $this->id.'/'.$action->id;
        $auth = Yii::$app->authManager;
        $perm = $auth->getPermission($name);
        if (\Yii::$app->user->can($name) || \Yii::$app->user->can($this->id.'/index')) {
            return true;
        } else {
            throw new ForbiddenHttpException('没有访问权限！');
        }
    }

    public function actionIndex()
    {
        Url::remember();
        $searchModel = new AuthSearch();
        $searchModel->load(Yii::$app->request->get());
        $searchModel->type = Auth::TYPE_ROLE;
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $auth = \Yii::$app->authManager;
        $model = new Auth();
        $model->type = AuthItem::TYPE_ROLE;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $role = $auth->createRole($model->name);
            $role->description = $model->description;
            $auth->add($role);
            foreach ($model->permissions as $name) {
                $permission = $auth->getPermission($name);
                $auth->addChild($role, $permission);
            }
            RbacHelper::updateConfigVersion();

            return $this->redirect(['index']);
        }
        $permissions = $auth->getPermissions();
        $permissions = ArrayHelper::map($permissions, 'name', 'description');

        // 从菜单里面选出其它权限
        $menus = (array) RbacHelper::getMenus();
        $menu_permissions = Common::getMenuPermission($menus);
        $other_permissions = array_diff_key($permissions, array_flip($menu_permissions));

        return $this->render('create', [
            'model' => $model,
            'permissions' => $permissions,
            'other_permissions' => $other_permissions,
        ]);
    }

    public function actionUpdate($id)
    {
        $auth = \Yii::$app->authManager;
        $model = $this->findModel($id);
        $role = $auth->getRole($id);

        if ($model->load(Yii::$app->request->post())) {
            $role->description = $model->description;
            $auth->update($id, $role);

            $auth->removeChildren($role);
            foreach ($model->permissions as $name) {
                $permission = $auth->getPermission($name);
                $auth->addChild($role, $permission);
            }
            RbacHelper::updateConfigVersion();

            return $this->refresh();
        }
        $model->permissions = AuthItemChild::find()
        ->select(['child'])
        ->where(['parent' => $id])
        ->column();
        $permissions = $auth->getPermissions();
        $permissions = ArrayHelper::map($permissions, 'name', 'description');

        // 从菜单里面选出其它权限
        $menus = (array) RbacHelper::getMenus();
        $menu_permissions = Common::getMenuPermission($menus);
        $other_permissions = array_diff_key($permissions, array_flip($menu_permissions));

        return $this->render('update', [
            'model' => $model,
            'permissions' => $permissions,
            'other_permissions' => $other_permissions,
        ]);
    }

    public function actionDelete($id)
    {
        $name = $id;
        $auth = Yii::$app->getAuthManager();
        $role = $auth->getRole($name);

        // clear asset permissions
        $permissions = $auth->getPermissionsByRole($name);
        foreach ($permissions as $permission) {
            $auth->removeChild($role, $permission);
        }
        if ($auth->remove($role)) {
            Yii::$app->session->setFlash('success', " '$name' ".Yii::t('app', 'successfully removed'));
        }

        return $this->goBack();
    }

    public function actionView($id)
    {
        $auth = \Yii::$app->authManager;
        $model = $this->findModel($id);
        $role = $auth->getRole($id);

        $model->permissions = AuthItemChild::find()
        ->select(['child'])
        ->where(['parent' => $id])
        ->column();
        $permissions = $auth->getPermissions();
        $permissions = ArrayHelper::map($permissions, 'name', 'description');

        return $this->render('view', [
            'model' => $model,
            'permissions' => $permissions,
        ]);
    }

    protected function findModel($name)
    {
        if ($name) {
            $auth = Yii::$app->getAuthManager();
            $model = new Auth();
            $role = $auth->getRole($name);
            if ($role) {
                $model->name = $role->name;
                $model->description = $role->description;
                $model->setIsNewRecord(false);

                return $model;
            }
        }
        throw new HttpException(404);
    }
}
