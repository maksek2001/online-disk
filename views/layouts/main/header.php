<?php

use yii\bootstrap4\NavBar;
use yii\helpers\Html;
?>

<header>
    <div class="main-header">
        <?php
        NavBar::begin([
            'brandLabel' => 'Online Disk',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'header navbar navbar-expand-md navbar-primary fixed-top pt-3 pb-3',
            ],
        ]);
        ?>
        <ul id="w1" class="navbar-nav nav">
            <li class="nav-item">
                <?php if (Yii::$app->user->isGuest) : ?>
                    <a class="nav-link" href="/authentication/registration">
                        Зарегистрироваться
                    </a>
                <?php else: ?>
                    <a class="nav-link" href="/office/main">
                        Личный кабинет
                        <img src="/web/public/icons/home.png" class='icon'>
                    </a>
                <?php endif; ?>
            </li>
            <li class="nav-item">
                <?php if (Yii::$app->user->isGuest) : ?>
                    <a class="nav-link" href="/authentication/login">
                        Войти
                        <img src="/web/public/icons/login.png" class='icon'>
                    </a>
                <?php else : ?>
                    <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline']); ?>
                    <button type="submit" class="btn btn-link logout">
                        Выйти
                        (<?= Yii::$app->user->identity->username ?>)
                        <img src="/web/public/icons/logout.png" class='icon'>
                    </button>
                    <?= Html::endForm(); ?>
                <?php endif; ?>
            </li>
        </ul>
        <ul id="w2" class="navbar-nav right nav">
            <li class="nav-item">
                <a class="nav-link" href="/site/help">
                    Помощь
                    <img src="/web/public/icons/help.png" class='icon'>
                </a>
            </li>
        </ul>
        <?php NavBar::end(); ?>
    </div>
</header>