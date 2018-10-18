<?php
/** 单文件上传
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/9/21
 * Time: 18:09
 */

class NewUpload extends Model
{
     public $file;


    /**
     * 文件验证配置
     */
     public function rules()
     {
         array_merge(parent::rules(),[
            ['file','file','extensions' =>'gif,jpg,jpeg,bmp,png'],
         ]);
     }

    /** 单文件上传
     * @return array|bool
     */
    public  function  ImgUpload()
    {
        //拿到文件信息
        $this->file = UploadedFile::getInstanceByName('file');
        if (!$this->file) {
            return false;
        }

        if ($this->validate()) {
            $relativePath = Yii::$app->params['base_img_up'];   //保存的物理路径
            if (!is_dir($relativePath)) {
                FileHelper::createDirectory($relativePath);
            }
            $fileName = $this->file->baseName . '.' . $this->file->extension;
            //随机一个名字


            $this->file->saveAs($relativePath . $fileName);
            return [
                'code' => 0,
                'url' =>  Yii::$app->param['webuploader']['base_img_url'].$fileName,      //url地址 用于查图片地址
                'attachment' => Yii::$app->param['webuploader']['base_img_url'].$fileName,  //入库地址
            ];
        } else {
            return false;
        }

    }
}