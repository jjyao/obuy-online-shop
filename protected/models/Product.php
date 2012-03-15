<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property string $id
 * @property string $name
 * @property string $price
 * @property string $iconFoldPath
 * @property string $imageFoldPath
 * @property string $description
 * @property string $howToUse
 * @property string $additionalSpec
 * @property string $publishTime
 * @property integer $isOnSale
 *
 * The followings are the available model relations:
 * @property Evaluation[] $evaluations
 * @property OrderItem[] $orderItems
 * @property ShopcartItem[] $shopcartItems
 */
class Product extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
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
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, price, iconFoldPath, imageFoldPath, publishTime, isOnSale', 'required'),
			array('isOnSale', 'numerical', 'integerOnly'=>true),
			array('name, iconFoldPath, imageFoldPath', 'length', 'max'=>511),
			array('price', 'length', 'max'=>10),
			array('description, howToUse, additionalSpec', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, price, iconFoldPath, imageFoldPath, description, howToUse, additionalSpec, publishTime, isOnSale', 'safe', 'on'=>'search'),
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
			'evaluations' => array(self::HAS_MANY, 'Evaluation', 'productId'),
			'orderItems' => array(self::HAS_MANY, 'OrderItem', 'productId'),
			'shopcartItems' => array(self::HAS_MANY, 'ShopcartItem', 'productId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'price' => 'Price',
			'iconFoldPath' => 'Icon Fold Path',
			'imageFoldPath' => 'Image Fold Path',
			'description' => 'Description',
			'howToUse' => 'How To Use',
			'additionalSpec' => 'Additional Spec',
			'publishTime' => 'Publish Time',
			'isOnSale' => 'Is On Sale',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('iconFoldPath',$this->iconFoldPath,true);
		$criteria->compare('imageFoldPath',$this->imageFoldPath,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('howToUse',$this->howToUse,true);
		$criteria->compare('additionalSpec',$this->additionalSpec,true);
		$criteria->compare('publishTime',$this->publishTime,true);
		$criteria->compare('isOnSale',$this->isOnSale);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}