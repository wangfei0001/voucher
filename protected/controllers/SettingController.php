<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-7-14
 * Time: PM9:05
 * To change this template use File | Settings | File Templates.
 */
class SettingController extends Controller
{
    public $layout = 'column2';


    public function actionStore()
    {
        $this->checkMerchantProfileCompleted = false;
        $this->selectedMenu = 'store';

        $model = new StoreForm();

        if(isset($_POST['StoreForm'])){
            $model->attributes=$_POST['StoreForm'];

            if($model->validate()){

                if($model->create()){
                    die('ok');
                }else{
                    $this->setFlash('error', 'Can not save store information.');
                }
            }
        }


        $this->render('store', array('model' => $model));
    }



    public function actionProfile()
    {
        $this->selectedMenu = 'profile';

        $this->render('profile');
    }
}