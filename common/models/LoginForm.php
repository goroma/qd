<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\captcha\Captcha;

/**
 * Login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $repassword;
    public $token;
    public $rememberMe = true;
    public $verify_code;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'repassword', 'token'], 'string', 'min' => 3],
            ['username', 'required', 'on' => 'login'],
            ['password', 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['verify_code', 'captcha'],
            // password is validated by validatePassword()
            ['password', 'validatePassword', 'on' => 'login'],
            ['repassword', 'required', 'on' => 'reset'],
            ['repassword', 'compare', 'compareAttribute' => 'password', 'message' => '密码不一致'],
        ];
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
                'username' => \Yii::t('app', '用户名'),
                'password' => \Yii::t('app', '密码'),
                'repassword' => \Yii::t('app', '确认密码'),
                'token' => \Yii::t('app', '密钥'),
                'verify_code' => \Yii::t('app', '验证码'),
            ]
        );
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array  $params    the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Reset password.
     *
     * @return bool whether the reset is successfully
     */
    public function resetPassword()
    {
        if (($user = User::findByPasswordResetToken($this->token)) != null) {
            $user->setPassword($this->password);
            $user->generatePasswordResetToken();
            if ($user->save()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Finds user by [[username]].
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
