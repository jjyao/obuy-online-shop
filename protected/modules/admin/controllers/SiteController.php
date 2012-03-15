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

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index'),
				'roles'=>array('admin'),
			),
			array('deny',
				'actions'=>array('index'),
				'users'=>array('*'),
			),
		);
	}
}