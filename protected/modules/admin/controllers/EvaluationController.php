<?php

class EvaluationController extends AdminController
{

	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionIndex()
	{
		$evaluation = new Evaluation('search');
		if(isset($_GET['Evaluation']))
		{
			$evaluation->attributes = $_GET['Evaluation'];
		}
		if(isset($_GET['id']))
		{
			$evaluation->id = $_GET['id'];
		}
		$this->render('index', array('evaluation'=>$evaluation));
	}

	public function actionDelete()
	{
		if(isset($_GET['id']) && Evaluation::isExist($_GET['id']))
		{
			$evaluation = Evaluation::model()->findByPk($_GET['id']);
			$evaluation->delete();
		}
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'delete'),
				'roles'=>array('admin'),
			),
			array('deny',
				'actions'=>array('index', 'delete'),
				'users'=>array('*'),
			),
		);
	}
}