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
        if(Yii::app()->user->isGuest){
            $this->setFlash('warning','没有权限操作，请先登录');
            $this->redirect('/account/login');
        }

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
            $row['start_time'] = date('Y-m-d', strtotime($row['start_time']));
            $row['end_time'] = date('Y-m-d', strtotime($row['end_time']));
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

                if($model->save()){
                    die('ok');
                }else{
                    $this->setFlash('error', 'Can not create voucher.');
                }
            }
        }

        $this->render('edit', array('model'=>$model, 'canModify'=>true));
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

        $canModify = true;

        $this->breadcrumbs = array('编辑优惠券');

        $model = new CreateVoucherForm();

        $result = $model->loadVoucher($id);
        if(!$result){
            die('we can\'t find this voucher');
        }

        $model->start_time = date('Y-m-d', strtotime($model->start_time));

        $model->end_time = date('Y-m-d', strtotime($model->end_time));

        /***
         * If they can't modify it
         */
        if(strtotime($model->start_time) < time()){
            $this->setFlash('warning', '该优惠券已经生效，只允许修改过期时间');
            $canModify = false;
        }


        //check fk user
        if(isset($_POST['CreateVoucherForm'])){
            $model->attributes=$_POST['CreateVoucherForm'];

            $model->image = $model->voucher->image;
            if($model->validate()){

                if($model->save()){
                    $this->setFlash('success', '已经修改优惠券信息');
                }else{
                    $this->setFlash('error','无法保存优惠券');
                }

            }

        }

        $this->render('edit', array(
            'model'     =>  $model,
            'canModify' =>  $canModify
        ));
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
        $result = true;
        $message = '';
        $data = null;

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


        $imageFile = CUploadedFile::getInstanceByName('CreateVoucherForm[image]');

        $path = $imageFile->getTempName();

        if(!in_array($imageFile->getType(),array('image/jpeg'))){
            $message = '文件不支持，只支持Jpg,Png,Gif';
            $result = false;
        }else if(filesize($path) > 500 * 1024){
            $message = '文件太大，文件大小必须小于500K';
            $result = false;
        }else{


            $img = new Image($path);

            //we need to check the resolution
            $imageSize = Yii::app()->params['voucherImageSize'];
            $info = $img->getInfo();
            if($info['width'] != $imageSize['width'] || $info['height'] != $imageSize['height']){
                $message = '图片规格不支持，我们只支持' .$imageSize['width'] .' X ' .$imageSize['height'] .'的图片';
                $result = false;
            }

            if($result){

                if($imageFile->getType() != 'image/jpeg'){
                    $img->convert();
                }

                $newPath = 'uploads/' .$id .'.jpg';

                $img->save($newPath);

                //$model->image->saveAs();

                $model->image = true;

                $model->save();

                $data = array(
                    'path'  =>  $newPath
                );

            }

        }

        echo CJSON::encode(array(
            'result'    =>  $result,
            'data'      =>  $data,
            'message'   =>  $message
        ));

        Yii::app()->end();
    }
}
