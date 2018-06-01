<?php

namespace dbbase\models\system;

use Yii;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use dbbase\models\ActiveRecord;
use dbbase\models\operation\Consignee;
use dbbase\models\family\Parents;
use dbbase\models\nursery\Nursery;
use dbbase\models\nursery\NurseryTeacher;
use dbbase\models\nursery\TeacherComment;

/**
 * User model.
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property int $role
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $password write-only password
 */
class SystemUser extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = -1;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const ROLE_USER = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    //public function behaviors()
    //{
        //return [
            //TimestampBehavior::className(),
        //];
    //}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['mobile', 'localimgurl'], 'string'],
            [['mobile', 'email'], 'unique'],
            [['mobile', 'email'], 'required'],
            [['classify', 'role'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键ID'),
            'name' => Yii::t('app', '显示用户名'),
            'username' => Yii::t('app', '登录用户名'),
            'localimgurl' => Yii::t('app', '本地头像'),
            'auth_key' => Yii::t('app', '身份key'),
            'password' => Yii::t('app', 'Password'),
            'repassword' => Yii::t('app', 'Repassword'),
            'password_hash' => Yii::t('app', '密码加密值'),
            'password_reset_token' => Yii::t('app', '密码重设token'),
            'email' => Yii::t('app', '邮箱'),
            'mobile' => Yii::t('app', '手机号'),
            'classify' => Yii::t('app', '用户分类'),
            'access_token' => Yii::t('app', 'access_token'),
            'role' => Yii::t('app', '角色'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
            'is_del' => Yii::t('app', '是否逻辑删除'),
            'roles' => Yii::t('app', 'Role'),
            'create_user_id' => Yii::t('app', 'Create User Id'),
            'update_user_id' => Yii::t('app', 'Update User Id'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username.
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        if (trim($username) == 'admin') {
            return static::findOne([
                'username' => $username,
                'status' => self::STATUS_ACTIVE,
            ]);
        }

        return static::findOne([
            'mobile' => $username,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by password reset token.
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid.
     *
     * @param string $token password reset token
     *
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);

        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     */
    public $_password = '';

    public function getPassword()
    {
        return $this->_password;
    }

    public function setPassword($password)
    {
        if (!empty($password)) {
            $this->_password = $password;
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
    }

    /**
     * Generates "remember me" authentication key.
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
    }

    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    // --------------------根据后续业务所加.-----------------------

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsignees()
    {
        return $this->hasMany(Consignee::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotices()
    {
        return $this->hasMany(Notice::className(), ['creator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticeRecords()
    {
        return $this->hasMany(NoticeRecord::className(), ['receiver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNurseries()
    {
        return $this->hasMany(Nursery::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNurseryTeachers()
    {
        return $this->hasMany(NurseryTeacher::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNurseryTeacher()
    {
        return $this->hasOne(NurseryTeacher::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['order_uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(Parents::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemNoticeRecords()
    {
        return $this->hasMany(SystemNoticeRecord::className(), ['receiver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Parents::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherComments()
    {
        return $this->hasMany(TeacherComment::className(), ['user_id' => 'id']);
    }
}
