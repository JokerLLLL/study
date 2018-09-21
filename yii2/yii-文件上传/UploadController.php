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
                   return ['code'=>1,'msg'=>'error'];
               }

           }catch(\Exception $e) {
               return ['code'=>1,'msg'=>$e->getMessage()];
           }
      }


}