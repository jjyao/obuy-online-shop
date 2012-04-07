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
		$product = new Product('create');

		if(isset($_POST['Product']))
		{
			// massive assignment
			$product->attributes = $_POST['Product'];

			// TODO for the rich text editor, should strip some harmful tags with php strip_tags

			$product->imagePackageFile = CUploadedFile::getInstance($product, 'imagePackageFile');
			if($product->validate())
			{
				$product->isOnSale = Product::ON_SALE;
				$product->imageFoldPath = "";
				$product->save(false);
				$product->saveImages();

				Yii::app()->user->setFlash('product_create_success', '商品创建成功');
				$this->redirect(array('product/create'));
			}
		}

		$this->render('create', array('product'=>$product));
	}

	public function actionUpdate()
	{
		$productId = $_GET['id'];
		if(isset($productId) && (Product::is_exist($productId, Product::ON_SALE) ||
			Product::is_exist($productId, Product::NOT_ON_SALE)))
		{
			if(isset($_POST['Product']))
			{

			}
			else
			{

			}
		}
		else
		{
			throw new CHttpException(404, '商品不存在');
		}
	}

	public function actionDelete()
	{

	}

	

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'create', 'update', 'delete'),
				'roles'=>array('admin'),
			),
			array('deny',
				'actions'=>array('index', 'create', 'update', 'delete'),
				'users'=>array('*'),
			),
		);
	}
}