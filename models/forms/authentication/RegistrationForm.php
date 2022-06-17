<?php

namespace app\models\forms\authentication;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Форма регистрации пользователя
 */
class RegistrationForm extends Model
{
    /** @var string $username */
    public $username;

    /** @var string $email */
    public $email;

    /** @var string $password */
    public $password;

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'E-mail',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required', 'message' => 'Обязательное поле!'],
            [['username', 'password'], 'string', 'length' => [1, 20], 'tooLong' => 'Слишком длинный', 'tooShort' => 'Слишком короткий'],
            ['email', 'email', 'message' => 'Некорректный E-mail'],
            ['username', 'match', 'pattern' => '/^[a-z0-9-_]*$/i', 'message' => 'Введён недопустимый символ. Допустимые символы a-z 0-9 _'],
            ['password', 'match', 'pattern' => '/^[a-z0-9-_|!|@|#|&]*$/i',  'message' => 'Введён недопустимый символ. Допустимые символы a-z 0-9 _ ! @ # &'],
            ['username', 'validateUsername'],
            ['email', 'validateEmail']
        ];
    }

    public function validateUsername($attribute)
    {
        if (!$this->hasErrors()) {
            $user = new User();

            if (!$user || !$user->validateUsername($this->username)) {
                $this->addError($attribute, 'Данное имя пользователя уже занято');
            }
        }
    }

    public function validateEmail($attribute)
    {
        if (!$this->hasErrors()) {
            $user = new User();

            if (!$user || !$user->validateEmail($this->email)) {
                $this->addError($attribute, 'Данный e-mail занят');
            }
        }
    }

    public function registration(): bool
    {
        if ($this->validate()) {
            $user = new User(['scenario' => User::SCENARIO_REGISTER]);
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $user->attributes = $this->attributes;
            return $user->create();
        }
        return false;
    }
}
