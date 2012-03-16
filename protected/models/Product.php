<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property string $id
 * @property string $name
 * @property string $price
 * @property string $categoryId
 * @property string $imageFoldPath
 * @property string $description
 * @property string $howToUse
 * @property string $additionalSpec
 * @property string $publishTime
 * @property integer $isOnSale
 *
 * The followings are the available model relations:
 * @property Category $category
 * @property Evaluation[] $evaluations
 * @property OrderItem[] $orderItems
 * @property ShopcartItem[] $shopcartItems
 */
class Product extends CActiveRecord
{
	const ON_SALE = 1;
	const NOT_ON_SALE = 2;
	
	public $imagePackageFile; // contain a compressed package with many files

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
			array('name, price, categoryId', 'required'),
			array('name', 'unique'),
			array('name', 'length', 'max'=>511),
			array('price', 'length', 'max'=>10),
			array('price', 'type', 'type'=>'float'),
			array('price', 'match', 'pattern'=>'/[0-9]+(\.[0-9][0-9]?)?/', 'message'=>'价格格式不对，请参见Tips'),
			array('imagePackageFile', 'unsafe'),
			array('imagePackageFile', 'file',
				  'types'=>'zip', 'maxSize'=>1024*1024*1, 'allowEmpty' => false, 'message'=>'图片包未上传'), // now only support zip package
			array('description, howToUse, additionalSpec', 'safe'),
			array('publishTime, id, isOnSale', 'safe', 'on'=>'search'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, price, imageFoldPath, description, howToUse, additionalSpec, publishTime, isOnSale', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'Category', 'categoryId'),
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
			'name' => '名称',
			'price' => '价格',
			'category' => '分类',
			'categoryId' => '分类',
			'imagePackageFile' => '商品图片',
			'description' => '描述',
			'howToUse' => '使用说明',
			'additionalSpec' => '附加说明',
			'publishTime' => '上架时间',
			'isOnSale' => '是否下架',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('publishTime',$this->publishTime,true);
		$criteria->compare('isOnSale',$this->isOnSale);

		$categories = array();
		if(Category::isExist($this->categoryId))
		{		
			$categories = Category::getSubCategories($this->categoryId);
			$categories[] = $this->categoryId;
			$criteria->addInCondition('categoryId', $categories);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'publishTime DESC',
			),
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
	}
}