<?php

/**
 * This is the model class for table "version".
 *
 * The followings are the available columns in table 'version':
 * @property string $id_version
 * @property string $version
 * @property string $description
 * @property string $released_at
 */
class Version extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Version the static model class
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
		return 'version';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('version, description, released_at', 'required'),
			array('version', 'length', 'max'=>32),
			array('description', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_version, version, description, released_at', 'safe', 'on'=>'search'),
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
			'id_version' => 'Id Version',
			'version' => 'Version',
			'description' => 'Description',
			'released_at' => 'Released At',
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

		$criteria->compare('id_version',$this->id_version,true);

		$criteria->compare('version',$this->version,true);

		$criteria->compare('description',$this->description,true);

		$criteria->compare('released_at',$this->released_at,true);

		return new CActiveDataProvider('Version', array(
			'criteria'=>$criteria,
		));
	}


    public function getLatestVersion()
    {
        $criteria=new CDbCriteria;
        $criteria->order = 'version desc';
        $criteria->limit = 1;

        return self::model()->find($criteria);
    }
}