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
            'reusable'=>'是否可以重复使用'
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

    public function create()
    {
        return false;
    }
}
