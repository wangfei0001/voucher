<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-7-14
 * Time: PM9:32
 * To change this template use File | Settings | File Templates.
 */
class MerchantForm extends CFormModel
{
    public $company;

    public $fk_category;

    public $website;

    public $logo;

    public $term_condition;


    public function rules()
    {
        return array(
            // username and password are required
            array('company, fk_category', 'required','message'=>'请输入{attribute}.'),
            array('website','safe'),
            array('term_condition','safe')
        );
    }

    public function attributeLabels()
    {
        return array(
            'company'=>'商家名称',
            'fk_category'   =>  '所属行业',
            'website'=>'网址',
            'logo'=>'标志',
            'term_condition'=>'优惠券使用条款'
        );
    }

    public function save()
    {
        $user = Yii::app()->user;

        $merchant = new Merchant();

        if(!empty($user->merchant)){

            $merchant->setAttributes($user->merchant);

            $merchant->id_merchant = $user->merchant['id_merchant'];

            $merchant->isNewRecord = false;

        }

        $merchant->setAttributes($this->attributes);

        $merchant->fk_user = $user->id;

        $result = $merchant->save();

        return $result;
    }


    public function init()
    {
        if(!empty(Yii::app()->user->merchant)){

            $this->setAttributes(Yii::app()->user->merchant);
//            var_dump($this->isAttributeSafe('lng'));
//            var_dump($this->isAttributeSafe('company'));
        }
    }
}
