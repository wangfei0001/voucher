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
        $this->breadcrumbs = array('商铺信息');

        $this->selectedMenu = 'store';

        $model = new MerchantForm();

        if(isset($_POST['MerchantForm'])){
            $model->attributes=$_POST['MerchantForm'];

            if($model->validate()){

                if($model->save()){
                    $this->setFlash('success', '已经成功保存信息');

                }else{
                    $this->setFlash('error', 'Can not save store information.');
                }
            }
        }


        $this->render('store', array('model' => $model,
            'categories' => Category::getAllForDropdown()
        ));
    }



    public function actionProfile()
    {
        $this->selectedMenu = 'profile';


        $model = new UserForm();




        if(isset($_POST['UserForm'])){

            $model->attributes = $_POST['UserForm'];

            if($model->Validate()){
                if($model->save()){
                    $this->setFlash('success', '成功保存信息');
                }else{
                    $this->setFlash('error', 'Database error. can not save');
                }

            }
        }

        $model->load(Yii::app()->user->id);

        $this->render('profile', array('model' => $model,
            'genders'   =>  array(
                '1' =>  '男',
                '2' =>  '女'
            ),
            'status'    =>  array(
                'active'    =>  '有效',
                'suspend'   =>  '禁用'
            )
        ));
    }
}
