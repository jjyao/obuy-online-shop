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
		// lazy delete
		$client = Client::model()->findByPk(Yii::app()->user->id);
		$client->isActive = Client::IN_ACTIVE;
		$client->save(false);

		$this->redirect(Yii::app()->createUrl('site/logout'));
	}

	public function actionModify()
	{
		// only respond to ajax request
		if(Yii::app()->request->isAjaxRequest)
		{
			$email = $_POST['email'];
			$name = $_POST['name'];
			$city = $_POST['city'];
			$address = $_POST['address'];

			$result = array();
			$result['success'] = 'true';
			$result['email'] = '';
			$result['name'] = '';
			$result['address'] = '';
			$client = Client::model()->findByPk(Yii::app()->user->id);

			// server validation
			if(!isset($email) || 
				!preg_match("/^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/", $email))
			{
				$result['success'] = 'false';
				$result['email'] = '不是有效的电子邮件地址';
			}
			if($email != $client->email && Client::model()->exists("email = :email", array(':email'=>$email)))
			{
				$result['success'] = 'false';
				$result['email'] = '该邮件地址已被使用';
			}

			if(!isset($name) || $name == '')
			{
				$result['success'] = 'false';
				$result['name'] = '用户名不能为空白';
			}

			if(!isset($city) || $city == '' || !isset($address) || $address == '')
			{
				$result['success'] = 'false';
				$result['address'] = '地址不能为空白';
			}
			$city = City::model()->findByAttributes(array('name'=>$city));
			if(is_null($city))
			{
				$result['success'] = 'false';
				$result['address'] = '该城市不存在';
			}

			if($result['success'] == 'true')
			{
				$client->email = $email;
				$client->name = $name;
				$client->deliveryAddresses[0]->address = $address;
				$client->deliveryAddresses[0]->cityId = $city->id;

				$client->save(false);
				$client->deliveryAddresses[0]->save(false);
			}

			echo json_encode($result);
		}
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