<?php
namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload($path = "uploads/", $filename = '')
    {
        if ($filename == '') {
            $filename = $this->imageFile->baseName;
        }

        if ($this->validate()) {
            $this->imageFile->saveAs("{$path}" . $filename . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Search in path directory similar file and generate unique name
     * @param $path
     * @return string
     */
    public function formFilename($path)
    {
        $new_name = $this->imageFile->baseName;
        $extension = '.' . $this->imageFile->extension;
        if (count(glob($path . $new_name . $extension)) > 0) {
            $i = 1;
            while (count(glob($path . $new_name . $extension)) > 0) {
                $new_name = $this->imageFile->baseName . " - copy ({$i})";
                $i++;
            }
        }

        return $new_name;
    }
}