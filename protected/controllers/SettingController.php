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



        //get address
        $addresses = Address::model()->findAll('fk_merchant = :fk_merchant', array('fk_merchant' => Yii::app()->user->merchant['id_merchant']));
        $data = array();
        if($addresses){
            foreach($addresses as $address){
                $data[] = array(
                    'id'        =>      $address->id_address,
                    'name'      =>      $address->name,
                    'address1'  =>      $address->address1,
                    'phone'     =>      $address->phone,
                    'fax'       =>      $address->fax,
                    'lat'       =>      $address->lat,
                    'lng'       =>      $address->lng,
                    'postcode'  =>      $address->postcode
                );
            }
        }

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


        $addrModel = new AddressForm();

        $this->render('store', array('model' => $model,
            'categories' => Category::getAllForDropdown(),
            'addresses' => $data,
            'addrModel' => $addrModel
        ));
    }



    /***
     * save address for the merchant
     */
    public function actionSaveAddress()
    {
        $model = new AddressForm();
        if(Yii::app()->request->isAjaxRequest && isset($_POST['AddressForm'])){
            $result = false;

            $model->attributes=$_POST['AddressForm'];

            //get merchant id
            $model->fk_merchant = Yii::app()->user->merchant['id_merchant'];


            if($model->validate()){
                $result = $model->save();
            }

            echo CJSON::encode(array(
                'status'    =>      $result,
                'message'   =>      null,
                'data'      =>      $result?array(
                    'id'        =>      $model->id_address,
                    'name'      =>      $model->name,
                    'address1'  =>      $model->address1,
                    'phone'     =>      $model->phone,
                    'fax'       =>      $model->fax,
                    'lat'       =>      $model->lat,
                    'lng'       =>      $model->lng,
                    'postcode'  =>      $model->postcode
                ):null,
                'errors'    =>      $result?null : $model->getErrors()
            ));
        }
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
