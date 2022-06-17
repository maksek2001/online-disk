<?php

namespace app\controllers;

use Yii;
use app\models\forms\authentication\LoginForm;
use app\models\forms\authentication\RegistrationForm;


/**
 * Контроллер авторизации и регистрации
 */
class AuthenticationController extends SiteController
{

    public $layout = 'authentication';

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginForm = new LoginForm();
        if ($loginForm->load(Yii::$app->request->post())) {
            if ($loginForm->login()) {
                return $this->redirect(['site/index']);
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось авторизоваться!');
            }
        }

        $loginForm->password = '';
        return $this->render('login', [
            'loginForm' => $loginForm,
        ]);
    }

    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $registrationForm = new RegistrationForm();
        if ($registrationForm->load(Yii::$app->request->post())) {
            if ($registrationForm->registration()) {
                Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались!');
                return $this->redirect('login');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось зарегистрироваться!');
            }
        }

        return $this->render('registration', [
            'registrationForm' => $registrationForm,
        ]);
    }
}
