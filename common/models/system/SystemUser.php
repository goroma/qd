<?php

namespace common\models\system;

use yii\helpers\ArrayHelper;
use common\models\auth\AuthItem;
use backend\components\RbacHelper;

class SystemUser extends \dbbase\models\system\SystemUser
{
    public $repassword;
    private $_statusLabel;
    private $_roleLabel;

    //const CLASSIFY_SYSTEM = 0;
    //const CLASSIFY_BOSS = 1;
    //const CLASSIFY_MINIBOSS = 2;
    //public static function getClassifes()
    //{
        //return [
            //self::CLASSIFY_SYSTEM=>'系统保留',
            //self::CLASSIFY_BOSS=>'BOSS 用户',
            //self::CLASSIFY_MINIBOSS=>'MINI BOSS 用户'
        //];
    //}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['username', 'email', 'mobile', 'password', 'repassword'], 'trim'],
            [['username', 'password'], 'required', 'on' => 'create'],
            [['mobile', 'email'], 'required'],
            [['username', 'mobile', 'email'], 'unique', 'targetClass' => self::className(), 'on' => 'create', 'message' => '{attribute}{value}已被使用'],
            //[['password', 'repassword'], 'required', 'on' => ['create']],
            [['password'], 'string', 'min' => 8, 'max' => 32, 'message' => '密码长度8-32位，必须包含字母、数字'],
            [['password'], 'match', 'pattern' => '/[\d]{1,}/', 'message' => '密码长度8-32位，必须包含字母、数字'],
            [['password'], 'match', 'pattern' => '/[a-z]{1,}/', 'message' => '密码长度8-32位，必须包含字母、数字'],
            //[['password'], 'match', 'pattern'=>'/[A-Z]{1,}/', 'message'=>'密码长度8-32位，必须包含大小写字母、数字'],
            [['username', 'email', 'mobile'], 'unique'],
            ['mobile', 'match', 'pattern' => '/[\d]{11,11}/', 'message' => '手机号格式不正确'],
            ['username', 'string', 'min' => 3, 'max' => 30],
            ['email', 'string', 'max' => 100],
            ['email', 'email'],
            ['repassword', 'compare', 'compareAttribute' => 'password'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['roles', 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        return array_merge(
            $labels,
            [
                'classify' => '用户类别',
                'mobile' => '手机号',
                'password' => \Yii::t('app', '密码'),
                'repassword' => \Yii::t('app', '确认密码'),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            //'admin-create' => ['username', 'email', 'password', 'repassword', 'status', 'role'],
            //'admin-update' => ['username', 'email', 'password', 'repassword', 'status', 'role']
        ]);
    }

    private $_roles = [];

    public function setRoles($roles)
    {
        if (is_array($roles)) {
            $this->_roles = $roles;
        } else {
            $this->_roles = [$roles];
        }
    }

    /**
     * 权限保存.
     *
     * @return multitype:\yii\rbac\Role |multitype:
     */
    public function saveRoles()
    {
        $_has_roles = array_keys(self::getArrayRole());
        $roles = array_intersect($this->_roles, $_has_roles);
        $auth = \Yii::$app->authManager;
        if (!empty($roles)) {
            $auth->revokeAll($this->id);
            foreach ($roles as $role_name) {
                $role = $auth->getRole($role_name);
                if (!empty($role)) {
                    $auth->assign($role, $this->id);
                }
            }
            RbacHelper::updateConfigVersion();

            return $auth->getRolesByUser($this->id);
        } else {
            return [];
        }
    }

    public function getRoles()
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRolesByUser($this->id), 'name', 'name');
    }

    public function getRolesLabel()
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRolesByUser($this->id), 'name', 'description');
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusLabel()
    {
        if ($this->_statusLabel === null) {
            $statuses = self::getArrayStatus();
            $this->_statusLabel = empty($statuses[$this->status]) ? '无效' : $statuses[$this->status];
        }

        return $this->_statusLabel;
    }

    /**
     * 显示分类名.
     */
    public function getClassifyLabel()
    {
        $classifys = self::getClassifes();
        if (isset($classifys[$this->classify])) {
            return $classifys[$this->classify];
        } else {
            return '';
        }
    }

    /**
     * 获取用户列表.
     */
    public static function getuserlist()
    {
        $usernamelist = self::find()->select('id,username')->asArray()->all();
        if ($usernamelist) {
            return ArrayHelper::map($usernamelist, 'id', 'username');
        } else {
            return array();
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getArrayStatus()
    {
        return [
            self::STATUS_ACTIVE => \Yii::t('app', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => \Yii::t('app', 'STATUS_INACTIVE'),
            self::STATUS_DELETED => \Yii::t('app', 'STATUS_DELETED'),
        ];
    }

    /**
     * 获取角色列表.
     */
    public static function getArrayRole()
    {
        $res = ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
        if (!\Yii::$app->user->can(AuthItem::SYSTEM_ROLE_SUPER_ADMIN)) {
            unset($res[AuthItem::SYSTEM_ROLE_SUPER_ADMIN]);
        }

        return $res;
    }

    public function getRoleLabel()
    {
        if ($this->_roleLabel === null) {
            $roles = self::getArrayRole();
            $this->_roleLabel = isset($roles[$this->role]) ? $roles[$this->role] : '';
        }

        return $this->_roleLabel;
    }

    /**
     * 非管理员.
     */
    public function isNotAdmin()
    {
        $auth = \Yii::$app->authManager;

        return !$auth->checkAccess($this->id, AuthItem::SYSTEM_ROLE_ADMIN);
    }

    /**
     * 通过用户id返回用名称.
     */
    public static function get_id_name($id)
    {
        $usernamelist = self::find()->select('username')->where(['id' => $id])->asArray()->one();
        if ($usernamelist) {
            return $usernamelist['username'];
        } else {
            return '未知';
        }
    }

    /**
     * 校验手机号唯一性.
     */
    public static function validateMobile($model)
    {
        return self::find()
            ->andWhere(['mobile' => $model->mobile])
            ->andWhere(['<>', 'id', $model->id])
            ->exists();
    }

    /**
     * 校验邮箱唯一性.
     */
    public static function validateEmail($model)
    {
        return self::find()
            ->andWhere(['email' => $model->email])
            ->andWhere(['<>', 'id', $model->id])
            ->exists();
    }
}
