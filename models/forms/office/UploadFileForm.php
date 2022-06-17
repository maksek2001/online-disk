<?php

namespace app\models\forms\office;

use yii\base\Model;


class UploadFileForm extends Model
{
    /** @var UploadedFile $file */
    public $file;

    public function attributeLabels()
    {
        return [
            'file' => '',
        ];
    }
}
