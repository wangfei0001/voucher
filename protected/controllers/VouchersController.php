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


    public function init()
    {
        $this->selectedMenu = 'list';

        parent::init();
    }


    /***
     * 检查用户有无权限对该Voucher操作
     *
     * @param $id_voucher
     */
//    protected function validateVoucher($id_voucher)
//    {
//
//
//
//        return true;
//    }

    public function actionList()
    {



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

        $this->render('edit', array('model'=>$model));
    }



    /***
     *
     */
    public function actionEdit()
    {
        $id = $this->getParam('id');
        if(empty($id)){
            //error
            die('error');

        }
        if(!$this->validateVoucher($id)){

            die('shit');
        }

        $this->breadcrumbs = array('编辑优惠券');

        $model = new CreateVoucherForm();

        $result = $model->loadVoucher($id);
        if(!$result){
            die('we can\'t find this voucher');
        }

        //check fk user


        if(isset($_POST['CreateVoucherForm'])){
            $model->attributes=$_POST['CreateVoucherForm'];


            if($model->validate()){

                if($model->save()){
                    $this->setFlash('success', '已经修改优惠券信息');
                }else{
                    $this->setFlash('error','无法保存优惠券');
                }

            }

        }

        $this->render('edit', array('model'=>$model));
    }


    /***
     *
     */
    public function actionView()
    {


        $this->render('view');
    }


    /***
     *
     */
    public function actionUpload()
    {
        $id = $this->getParam('id');
        if(empty($id)){
            //error
            die('error');

        }
//        if(!$this->validateVoucher($id)){
//
//            die('shit');
//        }

        $model = new CreateVoucherForm();

        $voucher = $model->loadVoucher($id);


        $model->image = CUploadedFile::getInstanceByName('CreateVoucherForm[image]');

        if(!$model->validate()){

            die('fuck');
        }

        die('ok');




        echo CJSON::encode(array(
            'result'    =>  true,
            'data'      =>  'fuck'
        ));

        Yii::app()->end();
    }
}
