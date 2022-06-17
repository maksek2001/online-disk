<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\Alert;

$this->title = 'Авторизация';
?>
<div class="edit-form col-md-4 text-center">
    <h3><?= Html::encode($this->title) ?></h3>

    <p>Пожалуйста, заполните поля для авторизации</p>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => [
            'class' => 'justify-content-center'
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($loginForm, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($loginForm, 'password')->passwordInput() ?>

    <?= $form->field($loginForm, 'rememberMe')->checkbox([
        'template' => "<div class=\"text-center justify-content-center custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>

    <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-secondary']) ?>


    <?php ActiveForm::end(); ?>

</div>