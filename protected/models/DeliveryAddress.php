<?php

/**
 * This is the model class for table "delivery_address".
 *
 * The followings are the available columns in table 'delivery_address':
 * @property string $id
 * @property string $clientId
 * @property integer $cityId
 * @property string $address
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property City $city
 */
class DeliveryAddress extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DeliveryAddress the static model class
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
		return 'delivery_address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('address', 'required'),
			array('address', 'length', 'max'=>511),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, clientId, cityId, address', 'safe', 'on'=>'search'),
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
			'client' => array(self::BELONGS_TO, 'Client', 'clientId'),
			'city' => array(self::BELONGS_TO, 'City', 'cityId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'clientId' => 'Client',
			'cityId' => '城市',
			'address' => '地址',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('clientId',$this->clientId,true);
		$criteria->compare('cityId',$this->cityId);
		$criteria->compare('address',$this->address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function isExist($addressId)
	{
		$address = DeliveryAddress::model()->findByPk($addressId);
		if(is_null($address))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Get the string representation of the delivery address
	 *
	 */
	public function toString()
	{
		return ($this->city->name . '市 ' . $this->address);
	}
}