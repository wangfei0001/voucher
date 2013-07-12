<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $id_category
 * @property string $name
 * @property integer $odr
 * @property string $created_at
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
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
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, created_at', 'required'),
			array('odr', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_category, name, odr, created_at', 'safe', 'on'=>'search'),
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
			'id_category' => 'Id Category',
			'name' => 'Name',
			'odr' => 'Odr',
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

		$criteria->compare('id_category',$this->id_category,true);

		$criteria->compare('name',$this->name,true);

		$criteria->compare('odr',$this->odr);

		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider('Category', array(
			'criteria'=>$criteria,
		));
	}




    /***
     * Get all of the categories
     * 
     * @return array
     */
    public static function getAll()
    {
        $return = array();
        $results = Category::model()->findAll();
        if($results){
            foreach($results as $val){
                $return[] = array(
                    'id_category'   =>  $val['id_category'],
                    'name'          =>  $val['name']
                );
            }
        }
        return $return;
    }
}