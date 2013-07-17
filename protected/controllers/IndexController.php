<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-7-14
 * Time: PM3:51
 * To change this template use File | Settings | File Templates.
 */
class IndexController extends Controller
{


    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionContact()
    {
        $this->breadcrumbs = array('联系我们');

        $this->render('index');
    }


    public function actionAbout()
    {
        $this->breadcrumbs = array('关于我们');

        $this->render('index');
    }
}
