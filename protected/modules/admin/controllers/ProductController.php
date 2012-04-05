<?php

class ProductController extends AdminController
{
	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionIndex()
	{
		$product = new Product('search');
		if(isset($_GET['Product']))
		{
			$product->attributes = $_GET['Product'];
		}
		$this->render('index', array('product'=>$product));
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

					$product->imageFoldPath = Yii::app()->basePath . DIRECTORY_SEPARATOR. 'data' . DIRECTORY_SEPARATOR . 'product_image' . DIRECTORY_SEPARATOR . $product->id;
					$this->extractPackageTo($product->imagePackageFile, $product->imageFoldPath);
					$product->save(false);

					// TODO
					Yii::app()->user->setFlash('product_create_success', '商品创建成功');
					$this->redirect(array('product/create'));
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
				'actions'=>array('index, create'),
				'roles'=>array('admin'),
			),
			array('deny',
				'actions'=>array('index, create'),
				'users'=>array('*'),
			),
		);
	}
}