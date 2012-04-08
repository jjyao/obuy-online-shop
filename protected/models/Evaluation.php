<?php

/**
 * This is the model class for table "evaluation".
 *
 * The followings are the available columns in table 'evaluation':
 * @property string $id
 * @property integer $score
 * @property string $comment
 * @property string $time
 * @property string $clientId
 * @property string $productId
 * @property string $orderId
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property Product $product
 * @property OrderItem $order
 */
class Evaluation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Evaluation the static model class
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
		return 'evaluation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('score, comment, clientId, productId', 'required'),
			array('score', 'numerical', 'integerOnly'=>true),
			array('clientId, productId', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, score, comment, time, clientId, productId', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'OrderItem', 'orderId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'score' => '评分',
			'comment' => '评论',
			'time' => '时间',
			'clientId' => '用户',
			'productId' => '商品',
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

		$criteria->compare('id',$this->id,false);
		$criteria->compare('score',$this->score);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('clientId',$this->clientId,false);
		$criteria->compare('productId',$this->productId,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
	}

	public static function isExist($evaluationId)
	{
		$evaluation = Evaluation::model()->findByPk($evaluationId);
		if(is_null($evaluation))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}