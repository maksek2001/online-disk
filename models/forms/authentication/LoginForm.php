<?php

namespace app\models\forms\authentication;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Форма авторизации пользователя
 */
class LoginForm extends Model
{
    /** @var string $username */
    public $username;

    /** @var string $password */
    public $password;

    /** @var bool $rememberMe */
    public $rememberMe = true;

    /** @var bool $_user*/
    private $_user = false;

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня'
        ];
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'message' => 'Обязательное поле!'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный логин или пароль');
            }
        }
    }

    /**
     * Авторизация
     * @return bool
     */
    public function login(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(),  $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Получение пользователя по его имени
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
            if ($this->_user) {
                $this->_user->scenario = User::SCENARIO_LOGIN;
            }
        }

        return $this->_user;
    }
}
