<?php
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }
    
    public function uploadMultiple($site_id,$dirName)
    {
        if (!empty($this->imageFiles)) {
            $files = [];
            foreach ($this->imageFiles as $file) {
                $files[] = UtilHelper::upload($file, $site_id, $dirName, 80, 80);
            }
            return $files;
        } else {
            return false;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'imageFiles' => \Yii::t('app', 'Image Files'),
        ];
    }
}