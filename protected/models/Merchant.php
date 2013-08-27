<?php

/**
 * This is the model class for table "merchants".
 *
 * The followings are the available columns in table 'merchants':
 * @property string $id_merchant
 * @property string $company
 * @property string $fk_user
 * @property string $fk_category
 * @property double $lag
 * @property double $lng
 * @property string $address1
 * @property string $address2
 * @property integer $postcode
 * @property string $phone
 * @property string $fax
 * @property string $website
 * @property string $logo
 * @property string $term_condition
 * @property string $geohash
 * @property string $created_at
 * @property string $updated_at
 */
class Merchant extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Merchant the static model class
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
		return 'merchants';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company, fk_user, fk_category, address1, phone', 'required'),
			array('postcode', 'numerical', 'integerOnly'=>true),
			array('lat, lng', 'numerical'),
			array('company', 'length', 'max'=>256),
			array('fk_user', 'length', 'max'=>20),
			array('address1, address2', 'length', 'max'=>1024),
			array('phone, fax', 'length', 'max'=>32),
			array('website, logo', 'length', 'max'=>128),
			array('term_condition, geohash', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_merchant, company, fk_user, lat, lng, address1, address2, postcode, phone, fax, website, logo, term_condition, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'fk_user0' => array(self::BELONGS_TO, 'Users', 'fk_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_merchant' => 'Id Merchant',
			'company' => 'Company',
			'fk_user' => 'Fk User',
            'fk_category' => 'FK Category',
			'lat' => 'Lat',
			'lng' => 'Lng',
			'address1' => 'Address1',
			'address2' => 'Address2',
			'postcode' => 'Postcode',
			'phone' => 'Phone',
			'fax' => 'Fax',
			'website' => 'Website',
			'logo' => 'Logo',
			'term_condition' => 'Term Condition',
            'geohash' => 'Geohash',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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

		$criteria->compare('id_merchant',$this->id_merchant,true);

		$criteria->compare('company',$this->company,true);

		$criteria->compare('fk_user',$this->fk_user,true);

        $criteria->compare('fk_category',$this->fk_category,true);

		$criteria->compare('lat',$this->lat);

		$criteria->compare('lng',$this->lng);

		$criteria->compare('address1',$this->address1,true);

		$criteria->compare('address2',$this->address2,true);

		$criteria->compare('postcode',$this->postcode);

		$criteria->compare('phone',$this->phone,true);

		$criteria->compare('fax',$this->fax,true);

		$criteria->compare('website',$this->website,true);

		$criteria->compare('logo',$this->logo,true);

		$criteria->compare('term_condition',$this->term_condition,true);

		$criteria->compare('created_at',$this->created_at,true);

		$criteria->compare('updated_at',$this->updated_at,true);

        $criteria->compare('geohash',$this->geohash,true);

		return new CActiveDataProvider('Merchant', array(
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
        $merchant = parent::save($runValidation, $attributes);
        //update session
        if($merchant){
            Yii::app()->user->setState('merchant', $this->attributes);
            Yii::app()->user->setState('merchantCompleted', true);

        }
        //var_dump($this->attributes);die();
        return $merchant;
    }
}