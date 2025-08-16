<?php
namespace common\models;

use Yii;
use yii\base\Model;

class UploadForm extends Model
{
    public $excelFile;

    public function rules()
    {
        return [
            [['excelFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'], // Проверьте, что расширение файла - xlsx
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $filePath = Yii::getAlias('@backend/runtime/upload/') . $this->excelFile->baseName . '.' . $this->excelFile->extension;
            if ($this->excelFile->saveAs($filePath)) {
                // Файл успешно сохранен на сервере
                return $filePath;
            }
        }
        return false;
    }
}

