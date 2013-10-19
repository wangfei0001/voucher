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
 * @property integer $reuse_total
 * @property integer $reuse_left
 * @property integer $status
 * @property integer $featured
 * @property string $click_total
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
			array('term_condition, start_time, end_time, reuse_total, image', 'safe'),
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
            'merchant' => array(self::BELONGS_TO, 'Merchant', 'fk_merchant')
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
            'click_total' => 'Click Total',
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

        $criteria->compare('click_total',$this->click_total);

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


    /***
     * Get all of the vouchers
     *
     * @return array
     */
    public static function getAll($param = null)
    {
        $return = array();

        $pageSize = Yii::app()->params['defaultItemsPage'];

        $criteria=new CDbCriteria;
        $criteria->with=array('merchant');
        $criteria->order = 't.created_at desc, id_voucher desc';
        $criteria->limit = $pageSize;

        if(isset($param['time']) && isset($param['id'])){
            $criteria->condition = 't.created_at <= "' .$param['time'] .'" and id_voucher < ' .$param['id'];
        }

        if(isset($param['search'])){
            if(!empty($criteria->condition)) $criteria->condition .= ' and ';
            $criteria->condition .= 't.name like "%' .$param['search'] .'%"';
        }

        if(isset($param['id_category'])){
            if(!empty($criteria->condition)) $criteria->condition .= ' and ';
            //check merchant
            $criteria->with = array('merchant');

            $criteria->condition .= 'merchant.fk_category = ' .$param['id_category'];
        }

        $rows = self::model()->findAll($criteria);
        if($rows){
            foreach($rows as $val){
                $return[] = $val->getBrief();
            }
        }
        return $return;
    }


    public function getBrief()
    {
        return array(
            'name'  =>  $this->name,
            'id_voucher' => $this->id_voucher,
            'merchant' => $this->merchant->getData4Voucher(),
            'addresses' => $this->getAddresses()
        );
    }


    /***
     * Get Address list for voucher
     *
     * @return array
     */
    public function getAddresses()
    {
        $addresses = array();
        $rows = VoucherAddress::model()->with('address')->findAll('fk_voucher = ' .$this->id_voucher);

        if($rows){
            foreach($rows as $row){
                $address = $row->address;
                $addresses[] = array(
                    'lat'   =>  $address->lat,
                    'lng'   =>  $address->lng,
                    'name'  =>  $address->name,
                    'address'   =>  $address->address1,
                    'phone' =>  $address->phone,
                    'fax'   =>  $address->fax
                );
            }
        }
        return $addresses;
    }


    /***
     * Check if the voucher expired
     */
    public function getIsExpired()
    {
        if($this->start_time && $this->end_time){
            $start = strtotime($this->start_time);
            $end = strtotime($this->end_time);

            if(time() >= $start && time() <= $end){
                return false;
            }else{
                return true;
            }
        }

        throw new Exception('Invalid Start time and end time.');
    }



    /***
     * Redeem the voucher
     *
     * @param $id_user
     * @throws Exception
     */
    public function redeem($id_user)
    {
        if($this->getIsExpired()){
            throw new Exception('该优惠券已经过期，无法继续使用！');
        }

        if($this->reusable){
            throw new Exception('该优惠券可重复使用，不需要兑现！');
        }

        if($this->reuse_left < 1){
            throw new Exception('已经达到最大使用次数，优惠券无效！');
        }



        //this voucher is ok to redeem
        $redemption = new Redemption();

        $redemption->fk_voucher = $this->id_voucher;

        $redemption->fk_user = $id_user;

        $redemption->status = Redemption::REDEMPTION_STATUS_INIT;

        if($redemption->save()){

            $this->reuse_left--;

            $this->reuse_total++;

            return $this->save();

        }

        return false;
    }


}