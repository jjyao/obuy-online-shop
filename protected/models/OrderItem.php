<?php

/**
 * This is the model class for table "order_item".
 *
 * The followings are the available columns in table 'order_item':
 * @property string $id
 * @property string $orderRecordId
 * @property string $productId
 * @property integer $count
 * @property string $unitPrice
 * @property integer $isEvaluated
 *
 * The followings are the available model relations:
 * @property OrderRecord $orderRecord
 * @property Product $product
 */
class OrderItem extends CActiveRecord
{
	const EVALUATED = 0;
	const NOT_EVALUATED = 1;

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
			array('count, isEvaluated, unitPrice', 'required', 'on'=>'update'),
			array('count, isEvaluated', 'numerical', 'integerOnly'=>true),
			array('unitPrice', 'length', 'max'=>10),
			array('unitPrice', 'match', 'pattern'=>'/^[0-9]+(\.[0-9][0-9]?)?$/', 'message'=>'价格格式不对'),
			array('isEvaluated', 'in', 'allowEmpty'=>false, 'range'=>array_keys($this->statusLabels())),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, productId, count, unitPrice, time, isEvaluated', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'productId'),
			'orderRecord' => array(self::BELONGS_TO, 'OrderRecord', 'orderRecordId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '订单号',
			'productId' => '商品',
			'orderRecordId' => '订单号',
			'count' => '数量',
			'unitPrice' => '单价',
			'isEvaluated' => '是否评论',
		);
	}

	public function statusLabels()
	{
		return array(
			OrderItem::NOT_EVALUATED => '未评价',
			OrderItem::EVALUATED => '已评价',
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
		$criteria->compare('orderRecordId',$this->orderRecordId,false);
		$criteria->compare('productId',$this->productId,false);
		$criteria->compare('count',$this->count, false);
		$criteria->compare('unitPrice',$this->unitPrice,false);
		$criteria->compare('isEvaluated',$this->isEvaluated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
	}

	public function isExist($orderItemId)
	{
		$orderItem = OrderItem::model()->findByPk($orderItemId);
		if(is_null($orderItem))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}