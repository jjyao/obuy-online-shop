<?php

class OrderController extends AdminController
{
	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionIndex()
	{
		$order = new OrderItem('search');
		if(isset($_GET['OrderItem']))
		{
			$order->attributes = $_GET['OrderItem'];
		}
		$this->render('index', array('order'=>$order));
	}

	public function actionUpdate()
	{
		// only	respond to ajax request
		if(Yii::app()->request->isAjaxRequest)
		{
			$orderId = $_POST['OrderItem']['id'];
			if($this->is_exist($orderId))
			{
				$order = OrderItem::model()->findByAttributes(array('id'=>$orderId));
				$order->scenario = 'update';
				// TODO use massive assignment is not a good idea because it is not safe. 
				// But it is clean, so I still choose massive assignment for this homework
				$order->attributes = $_POST['OrderItem'];

				$result = array();
				if($order->validate())
				{
					$order->save();
					$result['result'] = 'success';
				}
				else
				{
					$errors = $order->getErrors();
					$result['result'] = 'failure';
					$result['errors'] = $errors;
				}

				echo json_encode($result);
				Yii::app()->end();
			}
			else
			{
				header("HTTP/1.0 404 Order Not Found ");
			}
		}
	}

	public function actionDelete()
	{
		// only	respond to ajax request
		if(Yii::app()->request->isAjaxRequest)
		{
			$orderId = $_POST['id'];
			if($this->is_exist($orderId))
			{
				$order = OrderItem::model()->findByAttributes(array('id'=>$orderId));
				$order->delete();
			}
			else
			{
				header("HTTP/1.0 404 Order Not Found ");
			}
		}
	}

	private function is_exist($orderId)
	{
		$order = OrderItem::model()->findByAttributes(array('id'=>$orderId));
		if(is_null($order))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'update', 'delete'),
				'roles'=>array('admin'),
			),
			array('deny',
				'actions'=>array('index', 'update', 'delete'),
				'users'=>array('*'),
			),
		);
	}
}