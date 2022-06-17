<?php

namespace app\models;

use Yii;

/**
 * Пользователь
 * 
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property int $memory_limit
 * 
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'registration';

    public function scenarios()
    {
        return [
            self::SCENARIO_LOGIN => ['username', 'password'],
            self::SCENARIO_REGISTER => ['username', 'email', 'password'],
        ];
    }

    public static function tableName()
    {
        return '{{users}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
    }

    public static function findByUsername($username)
    {
        return User::find()->where(['username' => $username])->one();
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * @param string $username
     * @return bool
     */
    public function validateUsername($username): bool
    {
        return User::find()->where(['username' => $username])->count() == 0;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function validateEmail($email): bool
    {
        return User::find()->where(['email' => $email])->count() == 0;
    }

    /**
     * @param string $email
     */
    public function searchByEmail($email)
    {
        return User::find()->where(['email' => $email])->one();
    }


    /**
     * @param int $id
     * @param string $email
     * @param string $phone
     */
    public static function updateUserInfo($id, $email, $phone): bool
    {
        $user = User::findOne($id);
        $user->email = $email;
        $user->phone = $phone;
        return $user->save(false);
    }

    /**
     * @param string $email
     */
    public function createNewUserByEmail($email): array
    {
        $user = new User(['scenario' => User::SCENARIO_REGISTER]);
        if ($this->validateEmail($email)) {
            $user->username = $email;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($email);
            $user->email = $email;
            $user->create();
            return ['new' => true, 'user' => $this->searchByEmail($email)];
        }
        return ['new' => false, 'user' => $this->searchByEmail($email)];
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}
