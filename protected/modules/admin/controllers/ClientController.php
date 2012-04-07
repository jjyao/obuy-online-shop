<?php

class ClientController extends AdminController
{
	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionIndex()
	{
		$client = new Client('search');
		if(isset($_GET['Client']))
		{
			$client->attributes = $_GET['Client'];
		}
		$this->render('index', array('client'=>$client));
	}

	public function actionDelete()
	{
		if(isset($_GET['id']) && Client::isExist($_GET['id']))
		{
			$client = Client::model()->findByPk($_GET['id']);
			$client->isActive = Client::IN_ACTIVE;
			$client->save(false);
		}
	}

	public function actionUpdate()
	{
		// only	respond to ajax request
		if(Yii::app()->request->isAjaxRequest)
		{
			$clientId = $_POST['Client']['id'];
			if(isset($clientId) && Client::isExist($clientId))
			{
				$client = Client::model()->findByPk($clientId);
				$client->scenario = 'update';
				$client->attributes = $_POST['Client'];
				if($_POST['Client']['password'] != '')
				{
					$client->password = $_POST['Client']['password'];
				}

				$result = array();
				if($client->validate())
				{
					if($_POST['Client']['password'] != '')
					{
						$client->password = Client::encrypt($client->password);
					}
					$client->save(false);
					$result['result'] = 'success';
				}
				else
				{
					$errors = $client->getErrors();
					$result['result'] = 'failure';
					$result['errors'] = $errors;
				}

				echo json_encode($result);
				Yii::app()->end();
			}
			else
			{
				throw new CHttpException(404, '用户不存在');
			}
		}
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'delete', 'update'),
				'roles'=>array('admin'),
			),
			array('deny',
				'actions'=>array('index', 'delete', 'update'),
				'users'=>array('*'),
			),
		);
	}
}