<?php

/**
 * This is the model class for table "voucher_address".
 *
 * The followings are the available columns in table 'voucher_address':
 * @property string $id_voucher_address
 * @property string $fk_voucher
 * @property string $fk_address
 */
class VoucherAddress extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VoucherAddress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'voucher_address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fk_voucher, fk_address', 'required'),
			array('fk_voucher, fk_address', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_voucher_address, fk_voucher, fk_address', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'address' => array(self::BELONGS_TO, 'Address', 'fk_address'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_voucher_address' => 'Id Voucher Address',
			'fk_voucher' => 'Fk Voucher',
			'fk_address' => 'Fk Address',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_voucher_address',$this->id_voucher_address,true);

		$criteria->compare('fk_voucher',$this->fk_voucher,true);

		$criteria->compare('fk_address',$this->fk_address,true);

		return new CActiveDataProvider('VoucherAddress', array(
			'criteria'=>$criteria,
		));
	}
}