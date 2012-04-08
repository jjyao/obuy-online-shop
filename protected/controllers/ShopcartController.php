<?php

class ShopcartController extends Controller
{
	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionView()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('clientId', Yii::app()->user->id, false);
		$dataProvider = new CActiveDataProvider('ShopcartItem', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'time DESC',
			),
		));
		$this->render('view', array('dataProvider'=>$dataProvider));
	}

	public function actionAdd()
	{
		if(isset($_GET['product']) && Product::is_exist($_GET['product']))
		{
			$shopcartItem = new ShopcartItem();
			$shopcartItem->clientId = Yii::app()->user->id;
			$shopcartItem->productId = $_GET['product'];
			$shopcartItem->count = 1;
			$shopcartItem->save(false);

			$this->redirect(Yii::app()->createUrl('shopcart/view'));
		}
		else
		{
			throw new CHttpException(404, '商品不存在');
		}
	}

	public function actionDelete()
	{
		if(isset($_GET['id']) && ShopcartItem::isExist($_GET['id']))
		{
			$shopcartItem = ShopcartItem::model()->findByPk($_GET['id']);
			if($shopcartItem->clientId == Yii::app()->user->id)
			{
				$shopcartItem->delete();
				$this->redirect(Yii::app()->createUrl('shopcart/view'));
			}
			else
			{
				throw new CHttpException(403, '该购物车不属于您');
			}
		}
		else
		{
			throw new CHttpException(404, '该条目不存在');
		}
	}

	public function actionEmpty()
	{
		ShopcartItem::model()->deleteAllByAttributes(array('clientId'=>Yii::app()->user->id));
		$this->redirect(Yii::app()->createUrl('shopcart/view'));
	}

	/**
	 * Modify product number
	 */
	public function actionModify()
	{
		// only respond to ajax request
		if(Yii::app()->request->isAjaxRequest)
		{
			$shopCartItemId = $_POST['shopcartItemId'];
			if(isset($shopCartItemId) && ShopcartItem::isExist($shopCartItemId))
			{
				if(intval($_POST['productNumber']) >= 1)
				{
					$shopcartItem = ShopcartItem::model()->findByPk($shopCartItemId);
					$shopcartItem->count = intval($_POST['productNumber']);
					$shopcartItem->save();

					$sum = 0;
					$shopcartItems = ShopcartItem::model()->findAllByAttributes(array('clientId'=>Yii::app()->user->id));
					foreach($shopcartItems as $item)
					{
						$sum = $sum + $item->product->price * $item->count;
					}

					$result = array();
					$result['productUnitPrice'] = number_format($shopcartItem->product->price, 2);
					$result['productSumPrice'] = number_format($shopcartItem->product->price * $shopcartItem->count, 2);
					$result['moneySummary'] = number_format($sum, 2);
					echo json_encode($result);
				}
				else
				{
					header("HTTP/1.0 400 Product Number Invalid");
				}
			}
			else
			{
				header("HTTP/1.0 404 Shopcart Item Not Found");
			}
		}
	}

	public function actionOrder()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('clientId', Yii::app()->user->id, false);
		$dataProvider = new CActiveDataProvider('ShopcartItem', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'time DESC',
			),
		));
		if($dataProvider->totalItemCount = 0)
		{
			$this->redirect(Yii::app()->createUrl('shopcart/view'));
		}
		else
		{
			$this->render('order', array('dataProvider'=>$dataProvider));
		}
	}

	public function actionPurchase()
	{
		if(isset($_GET['address']) && DeliveryAddress::isExist($_GET['address']))
		{
			$address = DeliveryAddress::model()->findByPk($_GET['address']);
			if($address->clientId == Yii::app()->user->id)
			{
				$shopcartItems = ShopcartItem::model()->findAllByAttributes(array('clientId'=>Yii::app()->user->id));
				if(empty($shopcartItems))
				{
					$this->redirect(Yii::app()->createUrl('shopcart/view'));
				}
				else
				{	
					$orderRecord = new OrderRecord();
					$orderRecord->clientId = Yii::app()->user->id;
					$orderRecord->deliveryAddress = $address->city->name . '市 ' . $address->address;
					$orderRecord->status = OrderRecord::SUBMIT;

					$orderRecord->save(false);

					foreach($shopcartItems as $shopcartItem)
					{
						$orderItem = new OrderItem();
						// populate order item
						$orderItem->orderRecordId = $orderRecord->id;
						$orderItem->productId = $shopcartItem->productId;
						$orderItem->count = $shopcartItem->count;
						$orderItem->unitPrice = $shopcartItem->product->price;
						$orderItem->isEvaluated = OrderItem::NOT_EVALUATED;

						$orderItem->save(false);
						$shopcartItem->delete();
					}

					$this->render('purchase');
				}
			}
			else
			{
				throw new CHttpException(403, '操作被拒绝');
			}
		}
		else
		{
			throw new CHttpException(400, '没有提供足够的信息');
		}
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('view', 'delete', 'empty', 'modify', 'order', 'purchase', 'add'),
				'users'=>array('@'),
			),
			array('deny',
				'actions'=>array('view', 'delete', 'empty', 'modify', 'order', 'purchase', 'add'),
				'users'=>array('*'),
			),
		);
	}
}