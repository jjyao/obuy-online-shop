<?php

class FeedbackController extends AdminController
{
	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionIndex()
	{
		$feedback = new Feedback('search');
		if(isset($_GET['Feedback']))
		{
			$feedback->attributes = $_GET['Feedback'];
		}
		if(isset($_GET['id']))
		{
			$feedback->id = $_GET['id'];
		}
		$this->render('index', array('feedback'=>$feedback));
	}

	public function actionDelete()
	{
		$feedbackId = $_GET['id'];
		if(isset($feedbackId) && (Feedback::isExist($feedbackId))){
			$feedback = Feedback::model()->findByPk($feedbackId);
			$feedback->delete();
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