<?php

/**
 * This is the model class for table "vouchers".
 *
 * The followings are the available columns in table 'vouchers':
 * @property string $id_voucher
 * @property string $name
 * @property string $fk_merchant
 * @property string $term_condition
 * @property string $start_time
 * @property string $end_time
 * @property integer $reusable
 * @property integer $status
 * @property integer $featured
 * @property string $created_at
 * @property string $updated_at
 */
class Voucher extends CActiveRecord
{

    const VOUCHER_STATUS_APPROVED = 'approved';

    const VOUCHER_STATUS_EXPIRED = 'expired';

    const VOUCHER_STATUS_INIT   =   'init';




	/**
	 * Returns the static model of the specified AR class.
	 * @return Voucher the static model class
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
		return 'vouchers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, fk_merchant, status', 'required'),
			array('reusable,featured', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('fk_merchant', 'length', 'max'=>20),
			array('term_condition, start_time, end_time', 'safe'),
            array('image', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_voucher, name, fk_merchant, term_condition, start_time, end_time, reusable, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'favourites' => array(self::HAS_MANY, 'Favourites', 'fk_voucher'),
			'redemptions' => array(self::HAS_MANY, 'Redemption', 'fk_voucher'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_voucher' => 'Id Voucher',
			'name' => 'Name',
			'fk_merchant' => 'Fk Merchant',
			'term_condition' => 'Term Condition',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'reusable' => 'Reusable',
            'status'   =>   'status',
            'featured'  =>  'featured',
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

		$criteria->compare('id_voucher',$this->id_voucher,true);

		$criteria->compare('name',$this->name,true);

		$criteria->compare('fk_merchant',$this->fk_merchant,true);

		$criteria->compare('term_condition',$this->term_condition,true);

		$criteria->compare('start_time',$this->start_time,true);

		$criteria->compare('end_time',$this->end_time,true);

		$criteria->compare('reusable',$this->reusable);

        $criteria->compare('status',$this->status);

        $criteria->compare('featured',$this->featured);

		$criteria->compare('created_at',$this->created_at,true);

		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider('Voucher', array(
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
}