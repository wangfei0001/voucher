<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-7-12
 * Time: PM11:06
 * To change this template use File | Settings | File Templates.
 */
class AccountController extends Controller
{

    /***
     *
     */
    public function actionLogin()
    {

        $this->breadcrumbs = array('商家登录');

        $model = new LoginForm;
        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        $this->render('login',array('model'=>$model));
    }


    /***
     *
     */
    public function actionCreate()
    {
        $this->breadcrumbs = array('注册商家');

        $model = new CreateForm();

        if(isset($_POST['CreateForm'])){
            $model->attributes=$_POST['CreateForm'];

            if($model->validate()){

                if($model->create()){
                    die('ok');
                }else{
                    $this->setFlash('error', 'Can not create users.');
                }
            }
        }





        $this->render('create', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }


    public function actionIndex()
    {
        $this->layout = 'column2';

        $this->selectedMenu = 'summary';

        $this->render('index');
    }
}
