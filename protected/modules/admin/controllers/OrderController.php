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
		$order = new OrderRecord('search');
		if(isset($_GET['OrderRecord']))
		{
			$order->attributes = $_GET['OrderRecord'];
		}
		if(isset($_GET['id']))
		{
			$order->id = $_GET['id'];
		}
		$this->render('index', array('order'=>$order));
	}

	public function actionView()
	{
		$this->redirect(Yii::app()->createUrl('admin/order/update', array('id'=>$_GET['id'])));
	}

	public function actionUpdate()
	{
		$orderId = $_GET['id'];
		if(isset($orderId) && OrderRecord::isExist($orderId))
		{
			$order = OrderRecord::model()->findByAttributes(array('id'=>$orderId));
			$order->scenario = 'update';

			if(isset($_POST['OrderRecord']))
			{
				$order->attributes = $_POST['OrderRecord'];

				if($order->validate())
				{
					$order->save(false);
					Yii::app()->user->setFlash('order_update_success', '订单更新成功');
				}
			}
			
			$this->render('update', array('order'=>$order));
		}
		else
		{
			throw new CHttpException(404, '订单不存在');
		}
	}

	public function actionDelete()
	{
		$orderId = $_GET['id'];
		if(isset($orderId) && OrderRecord::isExist($orderId))
		{
			$order = OrderRecord::model()->findByAttributes(array('id'=>$orderId));
			$order->delete();
		}
		else
		{
			throw new CHttpException(404, '订单不存在');
		}
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'view', 'update', 'delete'),
				'roles'=>array('admin'),
			),
			array('deny',
				'actions'=>array('index', 'view', 'update', 'delete'),
				'users'=>array('*'),
			),
		);
	}
}