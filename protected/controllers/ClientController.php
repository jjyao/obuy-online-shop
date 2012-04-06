<?php

class ClientController extends Controller
{
	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionView()
	{
		$client = Client::model()->findByPk(Yii::app()->user->id);
		$this->render('view', array('client'=>$client));
	}

	public function actionLogoff()
	{

	}

	public function actionModifyPassword()
	{
		// only respond to ajax request
		if(Yii::app()->request->isAjaxRequest)
		{
			$oldPassword = $_POST['oldPassword'];
			$newPassword = $_POST['newPassword'];

			$result = array();
			if(isset($oldPassword) && $oldPassword != '' && isset($newPassword) && $newPassword != '')
			{
				$client = Client::model()->findByPk(Yii::app()->user->id);
				if(Client::encrypt($oldPassword) == $client->password)
				{
					$client->password = Client::encrypt($newPassword);
					$client->save(false);

					$result['success'] = 'true';
				}
				else
				{
					$result['success'] = 'false';
					$result['error'] = '初始密码不正确';
				}
			}
			else
			{
				$result['success'] = 'false';
				$result['error'] = '密码不能为空';
			}

			echo json_encode($result);
		}
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('view', 'modify', 'modifyPassword'),
				'users'=>array('@'),
			),
			array('deny',
				'actions'=>array('view', 'modify', 'modifyPassword'),
				'users'=>array('*'),
			),
		);
	}
}