<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-7-19
 * Time: PM7:48
 * To change this template use File | Settings | File Templates.
 */
class CreateVoucherForm extends CFormModel
{

    public $name;

    public $term_condition;

    public $start_time;

    public $end_time;

    public $reusable;



    public function init()
    {
        $this->term_condition = Yii::app()->user->merchant['term_condition'];

        $this->reusable = true;

        $this->start_time = date('Y-m-d');
    }


    public function loadVoucher($id = null)
    {
        if(!empty($id)){
            $data = Voucher::model()->find('id_voucher = :id_voucher', array('id_voucher' => $id));
            if($data){
                $this->attributes = $data->attributes;

                return true;
            }
        }
        return false;
    }

    public function rules()
    {
        return array(
            // username and password are required
            array('name', 'required'),
            array('start_time','checkStartTime'),
            array('end_time','checkEndTime')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'name'=>'优惠折扣标题',
            'term_condition'=>'使用条款限制',
            'start_time'=>'生效时间',
            'end_time'=>'过期时间',
            'reusable'=>'无使用次数限制'
        );
    }

    /***
     * Check start time
     *
     * @param $attribute
     * @param $params
     */
    public function checkStartTime($attribute,$params)
    {
        if(!empty($this->end_time)){
            if(strtotime($this->end_time) < strtotime($this->start_time)){
                $this->addError($attribute, '生效时间设置错误');
            }
        }
        if(strtotime($this->start_time) < time()){
            $this->addError($attribute, '生效时间设置错误');
        }

    }


    /***
     * Check end time
     *
     * @param $attribute
     * @param $params
     */
    public function checkEndTime($attribute,$params)
    {
        if(!empty($this->start_time)){
            if(strtotime($this->start_time) > strtotime($this->end_time)){
                $this->addError($attribute, '过期时间设置错误');
            }
        }

    }



    /***
     * @return mixed
     */
    public function create()
    {
        //we need to check if the merchant still can created the voucher

        $voucher = new Voucher();

        $voucher->attributes = $this->attributes;

        $voucher->fk_merchant = Yii::app()->user->merchant['id_merchant'];

        $voucher->status = Voucher::VOUCHER_STATUS_APPROVED;


        $result = $voucher->save();

        if($result){

        }else{
            var_dump($voucher->getErrors());
        }

        return $result;
    }
}
