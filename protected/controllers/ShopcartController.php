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
					header("HTTP/1.0 403 Product Number Invalid");
				}
			}
			else
			{
				header("HTTP/1.0 404 Shopcart Item Not Found");
			}
		}
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('view, delete, empty, modify'),
				'users'=>array('@'),
			),
			array('deny',
				'actions'=>array('view, delete, empty, modify'),
				'users'=>array('*'),
			),
		);
	}
}