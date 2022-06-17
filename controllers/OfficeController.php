<?php

namespace app\controllers;

use app\models\forms\office\UploadFileForm;
use app\models\office\UserFile;
use app\models\User;
use uses\libs\config\GetConfig;
use uses\libs\storage\Storage;
use yii\web\UploadedFile;
use uses\libs\storage\classes\StorageFile;

use yii;

class OfficeController extends SiteController
{

    public $layout = 'office';

    public function actionMain()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = User::findOne(['id' => Yii::$app->user->id]);

        $uploadFileForm = new UploadFileForm();
        if (Yii::$app->request->post()) {

            $filesDir = GetConfig::get('storages');
            $storage = new Storage($filesDir['users_files']['directory']);

            $file = UploadedFile::getInstance($uploadFileForm, 'file');

            if ($uploadFileForm->load(Yii::$app->request->post())) {
                if ($file->tempName) {
                    $newFileName = date('YmdHis') . '.' . $file->extension;
                    $title = $file->baseName . '.' . $file->extension;
                    $fileSize = filesize($file->tempName) / 1024 / 1024;

                    if ($fileSize <= $user->memory_limit - $user->memory_used) {
                        $storageFile = new StorageFile($newFileName, file_get_contents($file->tempName));

                        if ($storage->uploadFile($storageFile)) {
                            $userFile = new UserFile();

                            $userFile->user_id = Yii::$app->user->id;
                            $userFile->title = $title;
                            $userFile->path = $newFileName;
                            $userFile->size = $fileSize;
                            $userFile->extension = $file->extension;
                            $userFile->datetime_add = date('YmdHis');

                            $userFile->create();

                            $user->memory_used += $userFile->size;

                            $user->save(false);

                            Yii::$app->session->setFlash('success', 'Файл загружен!');
                        } else {
                            Yii::$app->session->setFlash('error', 'Не удалось загрузить файл!');
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Недостаточно места для загрузки!');
                    }
                    return $this->redirect('main');
                }
            }
        }

        $filesList = UserFile::getAllFiles($user->id);

        return $this->render('main', [
            'user' => $user,
            'uploadFileForm' => $uploadFileForm,
            'filesList' => $filesList
        ]);
    }

    public function actionDownloadFile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $file = UserFile::findOne(['id' => $_GET['file_id']]);

        $filesDir = GetConfig::get('storages');

        return Yii::$app->response->sendFile($filesDir['users_files']['directory'] . DIRECTORY_SEPARATOR . $file->path, $file->title);
    }

    public function actionDeleteFile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $file = UserFile::findOne(['id' => $_GET['file_id']]);

        $user = User::findOne(['id' => Yii::$app->user->id]);
        $user->memory_used -= $file->size;
        $user->save(false);

        $filesDir = GetConfig::get('storages');
        $storage = new Storage($filesDir['users_files']['directory']);

        if ($storage->deleteFile($file->path)) {
            $file->delete();
            Yii::$app->session->setFlash('success', 'Файл успешно удалён');
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось найти данный файл');
        }

        return $this->redirect('main');
    }
}
