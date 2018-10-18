<?php

class UploadController extends Controller
{

    /** yii
     * @return array
     */
      public function actionImgUpload()
      {
           $model = new NewUpload();
           try{
               $info = $model->ImgUpload();
               if($info && in_array($info)) {
                     return $info;
                }else{
                   throw new Exception(current($model->errors)[0]);
               }

           }catch(\Exception $e) {
               return ['code'=>1,'msg'=>$e->getMessage()];
           }
      }


}