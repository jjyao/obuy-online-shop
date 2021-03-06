<?php

/**
 * This is the model class for table "shopcart_item".
 *
 * The followings are the available columns in table 'shopcart_item':
 * @property string $id
 * @property string $clientId
 * @property string $productId
 * @property integer $count
 * @property string $time
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property Product $product
 */
class ShopcartItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShopcartItem the static model class
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
		return 'shopcart_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clientId, productId, time', 'required'),
			array('count', 'numerical', 'integerOnly'=>true),
			array('clientId, productId', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, clientId, productId, count, time', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'clientId' => 'Client',
			'productId' => 'Product',
			'count' => 'Count',
			'time' => 'time',
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
		$criteria->compare('productId',$this->productId,true);
		$criteria->compare('count',$this->count);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function isExist($shopcartItemId)
	{
		$shopcartItem = ShopcartItem::model()->findByPk($shopcartItemId);
		if(is_null($shopcartItem))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}