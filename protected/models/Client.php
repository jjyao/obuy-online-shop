<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $isActive
 *
 * The followings are the available model relations:
 * @property DeliveryAddress[] $deliveryAddresses
 * @property Evaluation[] $evaluations
 * @property OrderItem[] $orderItems
 * @property ShopcartItem[] $shopcartItems
 */
class Client extends CActiveRecord
{
	const ACTIVE = 0;
	const IN_ACTIVE = 1;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Client the static model class
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
		return 'client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, password', 'required', 'on'=>'update'),
			array('name, email', 'length', 'max'=>255, 'on'=>'update'),
			array('password', 'length', 'min' => 6, 'on'=>'update'),
			array('password', 'length', 'max'=>512, 'on'=>'update'),
			array('password', 'unsafe', 'on'=>'update'),
			array('email', 'email', 'checkMX'=>false, 'on'=>'update'),
			array('email', 'emailUniqueCheck', 'on'=>'update'),
			array('isActive', 'statusCheck', 'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, isActive', 'safe', 'on'=>'search'),
		);
	}

	public function emailUniqueCheck($attribute, $params)
	{
		if(Client::model()->exists("email = :email", array(':email'=>$this->email)))
		{
			$client = Client::model()->findByAttributes(array('email'=>$this->email));
			if($client->id != $this->id)
			{
				$this->addError('email', '该邮箱已被使用');
			}
		}
	}

	public function statusCheck($attribute, $params)
	{
		if($this->isActive != Client::ACTIVE && $this->isActive != Client::IN_ACTIVE)
		{
			$this->addError('isActive', '该状态不存在');
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'deliveryAddresses' => array(self::HAS_MANY, 'DeliveryAddress', 'clientId'),
			'evaluations' => array(self::HAS_MANY, 'Evaluation', 'clientId'),
			'orderItems' => array(self::HAS_MANY, 'OrderItem', 'clientId'),
			'shopcartItems' => array(self::HAS_MANY, 'ShopcartItem', 'clientId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '用户编号',
			'name' => '用户名',
			'email' => '邮箱',
			'password' => '密码',
			'isActive' => '是否注销',
		);
	}

	public function statusLabels()
	{
		return array(
			Client::ACTIVE => '未注销',
			Client::IN_ACTIVE => '注销',
		);
	}

	public function getStatusLabel($index)
	{
		$temp = $this->statusLabels();
		return $temp[$index];
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('isActive', $this->isActive);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Return the encrypted password
	 * This function encapsulate the encryption method
	 * @param string $password
	 * @return encrypted password
	 */
	public static function encrypt($password)
	{
		return md5($password);
	}

	public static function isExist($clientId)
	{
		$client = Client::model()->findByPk($clientId);
		if(is_null($client))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}