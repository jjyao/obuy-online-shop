<?php

class ProductController extends AdminController
{
	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionCreate()
	{
		$product = new Product;

		if(isset($_POST['Product']))
		{
			// massive assignment
			$product->attributes = $_POST['Product'];

			// TODO for the rich text editor, should strip some harmful tags with php strip_tags

			$product->imagePackageFile = CUploadedFile::getInstance($product, 'imagePackageFile');
			if($product->validate())
			{
				if($this->isValidImagePackage($product->imagePackageFile))
				{
					$product->isOnSale = Product::ON_SALE;
					$product->imageFoldPath = "";
					$product->save(false);

					$product->imageFoldPath = Yii::app()->basePath . DIRECTORY_SEPARATOR. 'data' . DIRECTORY_SEPARATOR . 'product_image' . DIRECTORY_SEPARATOR . $product->id . DIRECTORY_SEPARATOR;
					$this->extractPackageTo($product->imagePackageFile, $product->imageFoldPath);
					$product->save(false);

					// TODO 
					echo "Create product successfully";
					Yii::app()->end();

				}
				else
				{
					$product->addError('imagePackageFile', '图片包中含有非图片文件');
				}
			}
		}

		$this->render('create', array('product'=>$product));
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
			rmdir($targetFold);
		}	
		mkdir($targetFold, 0777, true);

		$zipFile = zip_open($sourceFile->tempName);
		if(is_resource($zipFile))
		{
			while($zip_entry = zip_read($zipFile))
			{
				$zip_entry_name = zip_entry_name($zip_entry);
				$targetFile = $targetFold . basename($zip_entry_name);
				touch($targetFile);
				$openFile = fopen($targetFile, 'w+');
				fwrite($openFile, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
				fclose($openFile);
			}
			zip_close($zipFile);
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

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('create'),
				'roles'=>array('admin'),
			),
			array('deny',
				'actions'=>array('create'),
				'users'=>array('*'),
			),
		);
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}