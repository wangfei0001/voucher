<?php

/**
 * This is the model class for table "userskey".
 *
 * The followings are the available columns in table 'userskey':
 * @property string $id_userskey
 * @property string $fk_user
 * @property string $public_key
 * @property string $private_key
 */
class Userskey extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Userskey the static model class
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
		return 'userskey';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fk_user, public_key, private_key', 'required'),
			array('fk_user', 'length', 'max'=>20),
			array('public_key, private_key', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_userskey, fk_user, public_key, private_key', 'safe', 'on'=>'search'),
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
            'user'=>array(self::BELONGS_TO, 'User', 'fk_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_userskey' => 'Id Userskey',
			'fk_user' => 'Fk User',
			'public_key' => 'Public Key',
			'private_key' => 'Private Key',
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

		$criteria->compare('id_userskey',$this->id_userskey,true);

		$criteria->compare('fk_user',$this->fk_user,true);

		$criteria->compare('public_key',$this->public_key,true);

		$criteria->compare('private_key',$this->private_key,true);

		return new CActiveDataProvider('Userskey', array(
			'criteria'=>$criteria,
		));
	}
}