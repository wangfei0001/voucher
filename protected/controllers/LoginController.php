<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-7-12
 * Time: PM11:06
 * To change this template use File | Settings | File Templates.
 */
class LoginController extends Controller
{

    public function actionIndex()
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
        $this->render('index',array('model'=>$model));
    }


}
