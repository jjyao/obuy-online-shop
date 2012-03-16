<?php

/**
 * This is the model class for table "order_item".
 *
 * The followings are the available columns in table 'order_item':
 * @property string $id
 * @property string $clientId
 * @property string $productId
 * @property integer $count
 * @property string $unitPrice
 * @property string $time
 * @property string $deliveryAddress
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property Product $product
 */
class OrderItem extends CActiveRecord
{
	const SUBMIT = 1;
	const DELIVERY = 2;
	const PAYMENT = 3;
	const EVALUATION = 4;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderItem the static model class
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
		return 'order_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clientId, productId, unitPrice, time, status', 'required'),
			array('count, status', 'numerical', 'integerOnly'=>true),
			array('clientId, productId, unitPrice', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, clientId, productId, count, unitPrice, time, status', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'productId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '订单号',
			'clientId' => '顾客',
			'productId' => '产品',
			'count' => '数量',
			'unitPrice' => '单价',
			'time' => '下单时间',
			'status' => '状态',
		);
	}

	public function statusLabels()
	{
		return array(
			OrderItem::SUBMIT => '已提交',
			OrderItem::DELIVERY => '已发货',
			OrderItem::PAYMENT => '已付款',
			OrderItem::EVALUATION => '已评价',
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
		$criteria->compare('clientId',$this->clientId,true);
		$criteria->compare('productId',$this->productId,true);
		$criteria->compare('count',$this->count);
		$criteria->compare('unitPrice',$this->unitPrice,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}