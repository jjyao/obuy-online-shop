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
			array('price', 'match', 'pattern'=>'/^[0-9]+(\.[0-9][0-9]?)?$/', 'message'=>'价格格式不对，请参见Tips'),
			array('isOnSale', 'statusCheck'),
			array('imagePackageFile', 'unsafe'),
			array('imagePackageFile', 'file',
				  'types'=>'zip', 'maxSize'=>1024*1024*1, 'allowEmpty' => false, 'message'=>'图片包未上传', 'on'=>'create'), // now only support zip package
			array('imagePackageFile', 'file',
				  'types'=>'zip', 'maxSize'=>1024*1024*1, 'allowEmpty' => true, 'on'=>'update'), // now only support zip package
			array('imagePackageFile', 'fileValidationCheck', 'skipOnError'=> true),
			array('description, howToUse, additionalSpec', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, price, publishTime, isOnSale', 'safe', 'on'=>'search'),
		);
	}

	public function statusCheck($attribute, $params)
	{
		if($this->isOnSale != Product::ON_SALE && $this->isOnSale != Product::NOT_ON_SALE)
		{
			$this->addError('isOnSale', '该状态不存在');
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
			'isOnSale' => '是否上架',
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

		$criteria = new CDbCriteria;

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

	public function statusLabels()
	{
		return array(
			Product::ON_SALE => '上架',
			Product::NOT_ON_SALE => '未上架',
		);
	}

	public function getStatusLabel($index)
	{
		$temp = $this->statusLabels();
		return $temp[$index];
	}

	public function fileValidationCheck($attribute, $params)
	{
		if($this->scenario == 'create' || 
			($this->scenario == 'update' && isset($this->imagePackageFile) && $this->imagePackageFile->tempName != ''))
		{
			if(!$this->isValidImagePackage($this->imagePackageFile))
			{
				$this->addError('imagePackageFile', '图片包中含有非图片文件');
			}
		}
	}

	public function saveImages()
	{
		// set image
		if($this->scenario == 'create' || 
			($this->scenario == 'update' && isset($this->imagePackageFile) && $this->imagePackageFile->tempName != ''))
		{
			$this->imageFoldPath = Yii::app()->basePath . DIRECTORY_SEPARATOR. 'data' . DIRECTORY_SEPARATOR . 'product_image' . DIRECTORY_SEPARATOR . $this->id;
			$this->extractPackageTo($this->imagePackageFile, $this->imageFoldPath);
			$this->save(false);
		}
	}

	/**
	 *	Determine whether the compressed package only contains jpg, png
	 *  Now only support zip file
	 *  @param $sourceFile a instance of CUploadFile
	 */
	private function isValidImagePackage($sourceFile)
	{
		$filePath = $sourceFile->tempName;
		$zipFile = zip_open($filePath);
		if(is_resource($zipFile))
		{
			while($zip_entry = zip_read($zipFile))
			{
				$imageFilePath = zip_entry_name($zip_entry);
				$extension = pathinfo($imageFilePath, PATHINFO_EXTENSION);
				if($extension != 'jpeg' && $extension != 'jpg' && $extension != 'png')
				{
					zip_close($zipFile);
					return false;
				}
			}
			zip_close($zipFile);
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Extract compressed package to the given fold
	 * Now only support zip file
	 *  @param $sourceFile a instance of CUploadFile
	 * @param $targetFold
	 */
	private function extractPackageTo($sourceFile, $targetFold)
	{
		// remove target fold if exists and create an empty one
		if(is_dir($targetFold))
		{
			$handle = opendir($targetFold);
			while($file = readdir($handle))
			{
				if($file != '.' && $file != '..')
				{
					unlink($targetFold . DIRECTORY_SEPARATOR . $file);
				}
			}
			rmdir($targetFold);
			closedir($handle);
		}	
		mkdir($targetFold, 0777, true);

		$zipFile = zip_open($sourceFile->tempName);
		if(is_resource($zipFile))
		{
			while($zip_entry = zip_read($zipFile))
			{
				$zip_entry_name = zip_entry_name($zip_entry);
				$targetFile = $targetFold . DIRECTORY_SEPARATOR . basename($zip_entry_name);
				touch($targetFile);
				$openFile = fopen($targetFile, 'w+');
				fwrite($openFile, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
				fclose($openFile);
			}
			zip_close($zipFile);
		}
	}

	public static function is_exist($productId, $isOnSale = Product::ON_SALE)
	{
		$product = Product::model()->findByAttributes(array('id'=>$productId, 'isOnSale'=>$isOnSale));
		if(is_null($product))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * @return an array of image file name
	 */
	public function getImages()
	{
		$images = array();
		$dir = opendir($this->imageFoldPath);
		while(($file = readdir($dir)) !== false)
		{
			if($file != '.' && $file != '..' && !in_array($file, $images))
			{
				$images[] = $file;
			}
		}

		return $images;
	}

	/**
	 * image triples is an array of images for preview, contains ['tiny'], ['small'], ['large']
	 * @return an array of image triples
	 */
	public function getImageTriples()
	{
		$result = array();
		$images = $this->getImages();
		foreach($images as $image)
		{
			$base = pathinfo($image, PATHINFO_FILENAME);
			$extension = pathinfo($image, PATHINFO_EXTENSION);
			if(preg_match('/(.*)_tiny$/', $base, $matches))
			{
				if(in_array($matches[1] . '_small.' . $extension, $images) && 
				   in_array($matches[1] . '_large.' . $extension, $images))
				{
					$triple = array();
					$triple['tiny'] = $matches[1] . '_tiny.' . $extension;
					$triple['small'] = $matches[1] . '_small.' . $extension;
					$triple['large'] = $matches[1] . '_large.' . $extension;

					$result[] = $triple;
				}
			}
		}

		return $result;
	}


	/**
     *	@return base url for product image fold
     */
	public function getImageBaseUrl()
	{
		$baseUrl = Yii::app()->request->baseUrl . '/protected/data/product_image/' . $this->id;
		return $baseUrl;
	}
}