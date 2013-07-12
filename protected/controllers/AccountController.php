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
        $model=new LoginForm;
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


        $this->render('create');
    }
}
