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
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property Product $product
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
			array('comment, time, clientId, productId', 'required'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'score' => 'Score',
			'comment' => 'Comment',
			'time' => 'Time',
			'clientId' => 'Client',
			'productId' => 'Product',
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
		$criteria->compare('score',$this->score);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('clientId',$this->clientId,true);
		$criteria->compare('productId',$this->productId,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}