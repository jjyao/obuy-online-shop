<?php

class ProductController extends Controller
{
	public function actionView()
	{
		if(isset($_GET['id']) && Product::is_exist($_GET['id']))
		{
			$productId = $_GET['id'];
			$product = Product::model()->findByAttributes(array('id'=>$productId, 'isOnSale'=>Product::ON_SALE));
			
			$this->render('view', array('product'=>$product));
		}
		else
		{
			throw new CHttpException(404, '商品不存在');
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