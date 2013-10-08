<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-9-15
 * Time: PM10:56
 * To change this template use File | Settings | File Templates.
 */
class AddressForm extends CFormModel
{
    public $id_address;

    public $fk_merchant;

    public $address1;

    public $address2;

    public $lat;

    public $lng;

    public $postcode;

    public $phone;

    public $fax;

    public $geohash;


    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and body are required
            array('address1, postcode, lat, lng', 'required'),
            array('phone,fax,id_address','safe')
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'address1'=>'详细地址',
            'postcode'=>'邮编',
            'phone'=>'电话',
            'fax'=>'传真'
        );
    }


    /***
     * Save address
     *
     * @return mixed
     */
    public function save()
    {
        $address = new Address();

        $address->setAttributes($this->attributes);

        if($this->id_address){

            $row = Address::model()->find('fk_merchant = :fk_merchant and id_address = :id_address', array(
                'fk_merchant' => Yii::app()->user->merchant['id_merchant'],
                'id_address'  => $this->id_address
            ));

            if(!$row){

                return false;
            }

            $address->id_address = $this->id_address;

            $address->isNewRecord = false;
        }


        return $address->save();
    }
}
