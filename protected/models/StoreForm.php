<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-7-14
 * Time: PM9:32
 * To change this template use File | Settings | File Templates.
 */
class StoreForm extends CFormModel
{
    public $company;

    public $lat;

    public $lng;

    public $address1;

    //public $address2;

    public $postcode;

    public $phone;

    public $fax;

    public $website;

    public $logo;

    public $term_condition;


    public function rules()
    {
        return array(
            // username and password are required
            array('company, address1, postcode', 'required','message'=>'请输入{attribute}.'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'company'=>'商家名称',
            'address1'=>'地址',
            //'address2'=>'地址2',
            'postcode'=>'邮编',
            'phone'=>'电话/手机',
            'fax'=>'传真',
            'website'=>'网址',
            'logo'=>'标志',
            'term_condition'=>'优惠券使用条款'
        );
    }

    public function save()
    {

    }
}
