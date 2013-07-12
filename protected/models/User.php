<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id_user
 * @property integer $fname
 * @property integer $lname
 * @property string $email
 * @property string $dob
 * @property integer $gender
 * @property string $fk_role
 * @property string $fk_country
 * @property string $fk_state
 * @property string $fk_city
 * @property string $created_at
 * @property string $updated_at
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fname, lname, email, gender, fk_role, created_at, updated_at', 'required'),
			array('fname, lname, gender', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>128),
			array('fk_role, fk_country, fk_state, fk_city', 'length', 'max'=>20),
			array('dob', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_user, fname, lname, email, dob, gender, fk_role, fk_country, fk_state, fk_city, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'favourites' => array(self::HAS_MANY, 'Favourites', 'fk_user'),
			'redemptions' => array(self::HAS_MANY, 'Redemption', 'fk_user'),
			'fk_role0' => array(self::BELONGS_TO, 'Roles', 'fk_role'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_user' => 'Id User',
			'fname' => 'Fname',
			'lname' => 'Lname',
			'email' => 'Email',
			'dob' => 'Dob',
			'gender' => 'Gender',
			'fk_role' => 'Fk Role',
			'fk_country' => 'Fk Country',
			'fk_state' => 'Fk State',
			'fk_city' => 'Fk City',
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

		$criteria->compare('id_user',$this->id_user,true);

		$criteria->compare('fname',$this->fname);

		$criteria->compare('lname',$this->lname);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('dob',$this->dob,true);

		$criteria->compare('gender',$this->gender);

		$criteria->compare('fk_role',$this->fk_role,true);

		$criteria->compare('fk_country',$this->fk_country,true);

		$criteria->compare('fk_state',$this->fk_state,true);

		$criteria->compare('fk_city',$this->fk_city,true);

		$criteria->compare('created_at',$this->created_at,true);

		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider('User', array(
			'criteria'=>$criteria,
		));
	}
}