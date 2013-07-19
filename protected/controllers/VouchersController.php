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

        $this->breadcrumbs = array('发布的折扣');


        $model = Voucher::model();

        $condition = 'fk_merchant =' . Yii::app()->user->merchant['id_merchant'];
        $limit = 25;
        $totalItems = $model->count($condition);

        $criteria = new CDbCriteria(array(
            'condition' => $condition,
            'order' => 'created_at DESC',
            'limit' => $limit,
            'offset' => $totalItems - $limit // if offset less, thah 0 - it starts from the beginning
        ));


        $pages=new CPagination($totalItems);     // results per page
        $pages->pageSize=$limit;
        $pages->applyLimit($criteria);

        $rows = $model->findAll($criteria);

        $vouchers = array();

        foreach($rows as $row){
            $row = $row->attributes;
            $row['id'] = $row['id_voucher'];
            $row['name'] = CHtml::link($row['name'], array("vouchers/view","id"=>$row['id']));
            unset($row['id_voucher']);
            $vouchers[] = $row;
        }
        $this->render('list', array('vouchers' => $vouchers, 'pages'=>$pages));
    }


    /***
     *
     */
    public function actionCreate()
    {

        $this->breadcrumbs = array('发布新的优惠券');

        $model = new CreateVoucherForm();


        if(isset($_POST['CreateVoucherForm'])){
            $model->attributes=$_POST['CreateVoucherForm'];

            if($model->validate()){

                if($model->create()){
                    die('ok');
                }else{
                    $this->setFlash('error', 'Can not create voucher.');
                }
            }
        }

        $this->render('create', array('model'=>$model));
    }


    public function actionEdit()
    {
        $id = $this->getParam('id');
        if(empty($id)){
            //error

        }

        $this->breadcrumbs = array('编辑优惠券');

        $model = new CreateVoucherForm();

        $result = $model->loadVoucher($id);
        if(!$result){
            die('we can\'t find this voucher');
        }


        if(isset($_POST['CreateVoucherForm'])){
            $model->attributes=$_POST['CreateVoucherForm'];


        }

        $this->render('create', array('model'=>$model));
    }


    /***
     *
     */
    public function actionView()
    {


        $this->render('view');
    }
}
