<?php

namespace app\models\office;

/**
 * Пользовательский файл
 * 
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $path
 * @property string $extension
 * @property double $size размер файла в МБ
 * @property DateTime $datetime_add
 * 
 */
class UserFile extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{user_files}}';
    }

    public static function getAllFiles($user_id)
    {
        return static::find()->where(['user_id' => $user_id])->orderBy(['datetime_add' => SORT_DESC])->all();
    }

    public static function deleteById($id)
    {
        $file = static::findOne(['id' => $id]);
        return $file->delete();
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}
