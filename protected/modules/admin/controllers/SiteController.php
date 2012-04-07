<?php

class SiteController extends AdminController
{
	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionModify()
	{
		$website = Website::model()->findAll();
		$website = $website[0];

		if(isset($_POST['Website']))
		{
			// massive assignment
			$website->attributes = $_POST['Website'];
			if($website->validate())
			{
				$website->save(false);

				Yii::app()->user->setFlash('website_modify_success', '商店信息修改成功');
				$this->redirect(array('site/modify'));
			}
		}
		$this->render('modify', array('website'=>$website));
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'modify'),
				'roles'=>array('admin'),
			),
			array('deny',
				'actions'=>array('index', 'modify'),
				'users'=>array('*'),
			),
		);
	}
}