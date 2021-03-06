<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $id
 * @property string $name
 * @property string $parentCategoryId
 *
 * The followings are the available model relations:
 * @property Product[] $products
 * @property Category $parentCategory
 * @property Category[] $subCategories
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>511),
			array('parentCategoryId', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, parentCategoryId', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Product', 'categoryId'),
			'parentCategory' => array(self::BELONGS_TO, 'Category', 'parentCategoryId'),
			'subCategories' => array(self::HAS_MANY, 'Category', 'parentCategoryId'),
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
			'parentCategoryId' => 'Parent Category',
		);
	}

	/**
	 * This function get all sub categories id
	 * @param $categoryId the root category
	 * @return an array of category id
	 */
	public static function getSubCategories($categoryId)
	{
		$result = array();
		if(Category::isExist($categoryId))
		{
			$category = Category::model()->findByAttributes(array('id'=>$categoryId));
			foreach($category->subCategories as $subCategory)
			{
				$result[] = $subCategory->id;
				$result = array_merge($result, Category::getSubCategories($subCategory->id));
			}
		}
		return $result;
	}

	/**
	 * Determine whether a given category exists
	 */
	public static function isExist($id)
	{
		$category = Category::model()->findByAttributes(array('id'=>$id));
		if(is_null($category))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Get the menu representation of this category
	 * Example: <li><a href="#">XXX</a></li>
	 */
	public function getMenuRepresent()
	{
		$result = '<li><a href="' . Yii::app()->createUrl("category/view", array('id'=>$this->id)) . '">' . $this->name .'</a>';
		if(count($this->subCategories) > 0)
		{
			$result = $result . '<ul>';
			foreach($this->subCategories as $category)
			{
				$result = $result . $category->getMenuRepresent();
			}
			$result = $result . '</ul>';
		}
		$result = $result . '</li>';

		return $result;
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
		$criteria->compare('parentCategoryId',$this->parentCategoryId,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}