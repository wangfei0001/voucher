<?php

/**
 * This is the model class for table "addresses".
 *
 * The followings are the available columns in table 'addresses':
 * @property string $id_address
 * @property string $fk_merchant
 * @property string $name
 * @property string $address1
 * @property string $address2
 * @property double $lat
 * @property double $lng
 * @property string $postcode
 * @property string $phone
 * @property integer $fax
 * @property string $geohash
 */
class Address extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Address the static model class
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
		return 'addresses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fk_merchant, address1, lat, lng, postcode, phone, geohash', 'required'),
			array('fax', 'numerical', 'integerOnly'=>true),
			array('lat, lng', 'numerical'),
			array('fk_merchant', 'length', 'max'=>20),
			array('address1, address2', 'length', 'max'=>255),
			array('postcode, phone', 'length', 'max'=>16),
			array('geohash', 'length', 'max'=>128),
            array('name','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, id_address, fk_merchant, address1, address2, lat, lng, postcode, phone, fax, geohash', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_address' => 'Id Address',
			'fk_merchant' => 'Fk Merchant',
            'name'  =>  'Name',
			'address1' => 'Address1',
			'address2' => 'Address2',
			'lat' => 'Lat',
			'lng' => 'Lng',
			'postcode' => 'Postcode',
			'phone' => 'Phone',
			'fax' => 'Fax',
			'geohash' => 'Geohash',
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

		$criteria->compare('id_address',$this->id_address,true);

		$criteria->compare('fk_merchant',$this->fk_merchant,true);

        $criteria->compare('name',$this->name,true);

		$criteria->compare('address1',$this->address1,true);

		$criteria->compare('address2',$this->address2,true);

		$criteria->compare('lat',$this->lat);

		$criteria->compare('lng',$this->lng);

		$criteria->compare('postcode',$this->postcode,true);

		$criteria->compare('phone',$this->phone,true);

		$criteria->compare('fax',$this->fax);

		$criteria->compare('geohash',$this->geohash,true);

		return new CActiveDataProvider('Address', array(
			'criteria'=>$criteria,
		));
	}


    /***
     * @return array
     */
    public function behaviors(){
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
                'updateAttribute' => 'updated_at',
            )
        );
    }

    public function save($runValidation = true, $attributes = NULL)
    {
        //calculate the geohash
        $geohash=new Geohash;
        $this->geohash = $geohash->encode($this->lat, $this->lng);

        return parent::save($runValidation, $attributes);
    }
}