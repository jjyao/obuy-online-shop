<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$path = Yii::getPathOfAlias('application.data.auth').'.php';
		$this->layout = '//layouts/main_with_header';

		// get newest products, hotest products and recommended products
		// TODO fake data
		$recommendedProducts = array();
		$newestProducts = Product::model()->findAllByAttributes(array('isOnSale'=>Product::ON_SALE),
			array(
				'order'=>'publishTime DESC',
				'limit'=>8,
			)
		);

		$hotestProductsId = array();
		$result = Yii::app()->db->createCommand(
			"SELECT productId FROM order_item GROUP BY productId ORDER BY count(id) DESC LIMIT 8")->query();
		$hotestProducts = array();
		foreach($result as $row)
		{
			$hotestProducts[] = Product::model()->findByPk($row['productId']);
		}

		$recommendedProductsId = array();
		$result = Yii::app()->db->createCommand(
			"SELECT productId FROM evaluation GROUP BY productId ORDER BY avg(score) DESC LIMIT 8")->query();
		$recommendedProducts = array();
		foreach($result as $row)
		{
			$recommendedProducts[] = Product::model()->findByPk($row['productId']);
		}
		
		$this->render('index', array('newestProducts'=>$newestProducts, 
									 'hotestProducts'=>$hotestProducts,
									 'recommendedProducts'=>$recommendedProducts));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	    	{
	    		$this->layout = '//layouts/main';
	    		if($error['code'] == 404)
	    		{
	    			$this->render('404', $error);
	    		}
	    		else
	    		{
	        		$this->render('error', $error);
	        	}
	        }
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->layout = '//layouts/main';
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login_form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}

		// display the login form
		$this->layout = '//layouts/main';
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Display the register page
	 */
	public function actionRegister()
	{
		$model = new RegisterForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='register_form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['RegisterForm']))
		{
			$model->attributes=$_POST['RegisterForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate())
			{
				//create a new user in the database and the related delivery address
				$client = new Client;
				$deliveryAddress = new DeliveryAddress;

				$client->name = $model->username;
				$client->email = $model->email;
				$client->password = $client->encrypt($model->password);
				$client->isActive = Client::ACTIVE;
				$client->save(false);

				$deliveryAddress->clientId = $client->id;
				$deliveryAddress->cityId = $model->city->id;
				$deliveryAddress->address = $model->address;
				$deliveryAddress->save(false);
				
				// auto login
				$userIdentity = new UserIdentity($model->email, $model->password);
				$userIdentity->authenticate();
				Yii::app()->user->login($userIdentity, 0);

				// TODO go to the success page
				$this->redirect(Yii::app()->createUrl('site/index'));
			}
		}

		// display the login form
		$this->layout = '//layouts/main';
		$this->render('register',array('model'=>$model));
	}

	public function actionSearch()
	{
		$condition = array();
		$params = array();

		$condition[] = 'isOnSale = :isOnSale';
		$condition[] = '(name LIKE :query OR price LIKE :query OR description LIKE :query OR
						 howToUse LIKE :query OR additionalSpec LIKE :query)';

		$params[':query'] = $_GET['query'];
		// escape % and _ 
		str_replace('%', '\%', $params[':query']);
		str_replace('_', '\_', $params[':query']);
		// not exact match
		$params[':query'] = "%" . $params[':query'] . "%";
		$params['isOnSale'] = Product::ON_SALE;

		$criteria = new CDbCriteria;
		$criteria->condition = implode(' AND ', $condition);
		$criteria->params = $params;

		$dataProvider = new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>10,
			),
		));

		$this->render('search', array('dataProvider'=>$dataProvider));
	}
}