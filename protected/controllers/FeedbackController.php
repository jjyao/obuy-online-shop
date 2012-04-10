<?php

class FeedbackController extends Controller
{
	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionIndex()
	{
		$feedback = new Feedback();
		$dataProvider = new CActiveDataProvider('Feedback', array(
			'sort'=>array(
				'defaultOrder'=>'time DESC',
			),
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
		$this->render('index', array('feedback'=>$feedback, 'dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		$feedback = new Feedback();
		if(isset($_POST['Feedback']))
		{
			$feedback->attributes = $_POST['Feedback'];
			$result = array();
			if($feedback->validate())
			{
				$feedback->clientId = Yii::app()->user->id;
				$feedback->save(false);
				$result['result'] = 'success';
				echo json_encode($result);
			}
		}
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'create'),
				'users'=>array('@'),
			),
			array('deny',
				'actions'=>array('index', 'create'),
				'users'=>array('*'),
			),
		);
	}
}