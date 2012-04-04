<?php

class CategoryController extends Controller
{
	public function actionView()
	{
		if(isset($_GET['id']) && Category::isExist($_GET['id']))
		{
			$categoryId = $_GET['id'];
			$category = Category::model()->findByAttributes(array('id'=>$categoryId));

			// get newest products, hotest products and recommended products in current category
			// TODO fake data
			$newestProducts = array();
			$hotestProducts = array();
			$recommendedProducts = array();
			$product = Product::model()->findByAttributes(array('id'=>12));	
			for($i = 0; $i < 8; $i++)
			{
				$newestProducts[] = $product;
			}
			$hotestProducts = $newestProducts;
			$recommendedProducts = $newestProducts;

			$this->render('view', array(
										'category'=>$category,
										'newestProducts'=>$newestProducts, 
									 	'hotestProducts'=>$hotestProducts,
									 	'recommendedProducts'=>$recommendedProducts,
									));
		}
		else
		{
			throw new CHttpException(404, '分类不存在');
		}
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