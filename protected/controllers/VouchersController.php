<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-7-14
 * Time: PM9:21
 * To change this template use File | Settings | File Templates.
 */
class VouchersController extends Controller
{

    public $layout = 'column2';


    public function actionList()
    {

        $this->selectedMenu = 'list';

        $this->render('list');
    }
}
