<?php

class OrderController extends Controller
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
		$criteria->with = array('orderRecord');
		$criteria->compare('orderRecord.clientId', Yii::app()->user->id, false);
		
		$dataProvider = new CActiveDataProvider('OrderItem', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'attributes'=>array(
					'time'=>array(
						'asc'=>'orderRecord.time',
						'desc'=>'orderRecord.time DESC',
					),
					'status'=>array(
						'asc'=>'orderRecord.status',
						'desc'=>'orderRecord.status DESC',
					),
					'unitPrice'=>array(
						'asc'=>'unitPrice',
						'desc'=>'unitPrice DESC',
					),
					'count'=>array(
						'asc'=>'count',
						'desc'=>'count DESC',
					),
					'productId'=>array(
						'asc'=>'productId',
						'desc'=>'productId DESC',
					),
					'orderRecordId'=>array(
						'asc'=>'orderRecordId',
						'desc'=>'orderRecordId DESC',
					),
				),
				'defaultOrder'=>'orderRecordId DESC',
				'multiSort'=>true,
			),
			'pagination'=>array(
				'pageSize'=>5,
			),
		));
		$this->render('view', array('dataProvider'=>$dataProvider));
	}

	public function actionCancel()
	{
		// only respond to ajax request
		if(Yii::app()->request->isAjaxRequest)
		{
			$orderItemId = $_POST['orderItemId'];
			if(isset($orderItemId) && OrderItem::isExist($orderItemId))
			{
				$orderItem = OrderItem::model()->findByPk($_POST['orderItemId']);
				if($orderItem->orderRecord->status != OrderRecord::SUBMIT)
				{
					header("HTTP/1.0 403 Forbidden");
					Yii::app()->end();
				}
				if($orderItem->orderRecord->clientId != Yii::app()->user->id)
				{
					header("HTTP/1.0 403 Permission denied");
					Yii::app()->end();
				}

				// everything is valid
				$orderRecord = $orderItem->orderRecord;
				$orderItem->delete();
				if(count($orderRecord->orderItems) == 0)
				{
					$orderRecord->delete();
				}
			}
			else
			{
				header("HTTP/1.0 404 Order Item Not Found");
			}
		}
	}

	public function actionEvaluate()
	{
		// only respond to ajax request
		if(Yii::app()->request->isAjaxRequest)
		{
			$orderItemId = $_POST['orderItemId'];
			if(isset($orderItemId) && OrderItem::isExist($orderItemId))
			{
				// validation score and comment
				if(1 <= intval($_POST['productScore']) && intval($_POST['productScore']) <= 5)
				{
					if($_POST['productComment'] == '')
					{
						header("HTTP/1.0 400 Invalid value");
						Yii::app()->end();
					}

					$orderItem = OrderItem::model()->findByPk($_POST['orderItemId']);
					if($orderItem->orderRecord->status != OrderRecord::PAYMENT || $orderItem->isEvaluated != OrderItem::NOT_EVALUATED)
					{
						header("HTTP/1.0 400 Invalid value");
						Yii::app()->end();
					}
					if($orderItem->orderRecord->clientId != Yii::app()->user->id)
					{
						header("HTTP/1.0 403 Permission denied");
						Yii::app()->end();
					}
					
					// everything is valid
					$evaluation = new Evaluation();
					$evaluation->score = $_POST['productScore'];
					$evaluation->comment = $_POST['productComment'];
					$evaluation->clientId = Yii::app()->user->id;
					$evaluation->productId = $orderItem->productId;
					$evaluation->orderId = $orderItem->id;
					$evaluation->save(false);

					$orderItem->isEvaluated = OrderItem::EVALUATED;
					$orderItem->save(false);
				}
				else
				{
					header("HTTP/1.0 400 Invalid value");
					Yii::app()->end();
				}
			}
			else
			{
				header("HTTP/1.0 404 Order Item Not Found");
			}
		}
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('view', 'evaluate', 'cancel'),
				'users'=>array('@'),
			),
			array('deny',
				'actions'=>array('view', 'evaluate', 'cancel'),
				'users'=>array('*'),
			),
		);
	}
}