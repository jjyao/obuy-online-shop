<?php

/**
 * This is the model class for table "order_record".
 *
 * The followings are the available columns in table 'order_record':
 * @property string $id
 * @property string $clientId
 * @property string $time
 * @property string $deliveryAddress
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property OrderItem[] $orderItems
 * @property Client $client
 */
class OrderRecord extends CActiveRecord
{
	const SUBMIT = 1;
	const DELIVERY = 2;
	const PAYMENT = 3;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderRecord the static model class
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
		return 'order_record';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('deliveryAddress, status', 'required', 'on'=>'update'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('clientId', 'length', 'max'=>10),
			array('deliveryAddress', 'length', 'max'=>511),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, clientId, time, deliveryAddress, status', 'safe', 'on'=>'search'),
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
			'orderItems' => array(self::HAS_MANY, 'OrderItem', 'orderRecordId'),
			'client' => array(self::BELONGS_TO, 'Client', 'clientId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'clientId' => '顾客',
			'time' => '下单时间',
			'deliveryAddress' => '送货地址',
			'status' => '订单状态',
		);
	}

	public function statusLabels()
	{
		return array(
			OrderRecord::SUBMIT => '已提交',
			OrderRecord::DELIVERY => '已发送',
			OrderRecord::PAYMENT => '已付款',
		);
	}

	/**
	 * Since PHP 5.4, it is possible to array dereference the result of a function or method call directly. 
	 * Before it was only possible using a temporary variable, so.. you know why I write this function
	 */
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

		$criteria->compare('id',$this->id,false);
		$criteria->compare('clientId',$this->clientId,false);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('deliveryAddress',$this->deliveryAddress,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function isExist($orderRecordId)
	{
		$orderRecord = OrderRecord::model()->findByPk($orderRecordId);
		if(is_null($orderRecord))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}