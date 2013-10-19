<?php

/**
 * This is the model class for table "redemption".
 *
 * The followings are the available columns in table 'redemption':
 * @property string $id_redemption
 * @property string $fk_voucher
 * @property string $fk_user
 * @property string $status
 * @property string $created_at
 */
class Redemption extends CActiveRecord
{

    const REDEMPTION_STATUS_INIT = 'init';

    const REDEMPTION_STATUS_DONE = 'done';


	/**
	 * Returns the static model of the specified AR class.
	 * @return Redemption the static model class
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
		return 'redemption';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fk_voucher, fk_user, status', 'required'),
			array('fk_voucher, fk_user', 'length', 'max'=>20),
			array('status', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_redemption, fk_voucher, fk_user, status, created_at', 'safe', 'on'=>'search'),
		);
	}


    /***
     * @return array
     */
    public function behaviors(){
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
            )
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
			'fk_voucher0' => array(self::BELONGS_TO, 'Vouchers', 'fk_voucher'),
			'fk_user0' => array(self::BELONGS_TO, 'Users', 'fk_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_redemption' => 'Id Redemption',
			'fk_voucher' => 'Fk Voucher',
			'fk_user' => 'Fk User',
			'status' => 'Status',
			'created_at' => 'Created At',
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

		$criteria->compare('id_redemption',$this->id_redemption,true);

		$criteria->compare('fk_voucher',$this->fk_voucher,true);

		$criteria->compare('fk_user',$this->fk_user,true);

		$criteria->compare('status',$this->status,true);

		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider('Redemption', array(
			'criteria'=>$criteria,
		));
	}
}