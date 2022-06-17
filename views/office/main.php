<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\Alert;
use uses\libs\config\GetConfig;

$this->title = Yii::$app->name;

$extensions = GetConfig::get('extensions');
?>
<div class="office-info">
    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>
    <div class="memory-block">
        <div class="memory-info">
            Занято: <?= number_format(Html::encode($user->memory_used), 3, ".", ""); ?> из <?= Html::encode($user->memory_limit) ?> мб.
        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: <?= $user->memory_used / $user->memory_limit * 100 ?>%" aria-valuenow="<?= $user->memory_used ?>" aria-valuemin="0" aria-valuemax="<?= $user->memory_limit ?>"></div>
        </div>
    </div>
    <?php $form = ActiveForm::begin([
        'id' => 'upload-file-form',
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($uploadFileForm, 'file')->fileInput(); ?>

    <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-secondary']) ?>

    <?php ActiveForm::end(); ?>
    <div class="files-list">
        <?php foreach ($filesList as $file) : ?>
            <div class="file-block">
                <img src="/web/public/icons/files/<?= $extensions[$file->extension] ? $extensions[$file->extension] : 'other-file.png' ?>" class='menu-icon'>
                <a href="download-file?file_id=<?= $file->id ?>"><?= $file->title ?>&nbsp;</a>
                <?= Html::a('❌', "delete-file?file_id=$file->id", [
                    'class' => 'info-text delete',
                    'data' => [
                        'confirm' => 'Вы действительно хотите удалить файл?',
                        'method' => 'post',
                    ],
                ]) ?>
                <span class='file-size'><?= number_format(Html::encode($file->size), 3, ".", ""); ?> Мб.</span>
            </div>
        <?php endforeach; ?>
    </div>

</div>