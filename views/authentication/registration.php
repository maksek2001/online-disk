<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\Alert;

$this->title = 'Регистрация';
?>

<div class="edit-form col-md-4 text-center">
    <h3><?= Html::encode($this->title) ?></h3>

    <p>Пожалуйста, заполните поля для регистрации</p>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'options' => [
            'class' => 'justify-content-center'
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($registrationForm, 'username')->textInput(['autofocus' => true]) ?>
    <?= $form->field($registrationForm, 'email')->textInput() ?>
    <?= $form->field($registrationForm, 'password')->passwordInput() ?>

    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-secondary']) ?>


    <?php ActiveForm::end(); ?>

</div>