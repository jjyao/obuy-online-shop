<?php

class AnnouncementController extends AdminController
{
	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionIndex()
	{
		$announcement = new Announcement('search');
		if(isset($_GET['Announcement']))
		{
			$announcement->attributes = $_GET['Announcement'];
		}
		if(isset($_GET['id']))
		{
			$announcement->id = $_GET['id'];
		}
		$this->render('index', array('announcement'=>$announcement));
	}

	public function actionCreate()
	{
		$announcement = new Announcement();

		if(isset($_POST['Announcement']))
		{
			// massive assignment
			$announcement->attributes = $_POST['Announcement'];
			$announcement->isActive = Announcement::ACTIVE;

			if($announcement->validate())
			{
				$announcement->save(false);
				Yii::app()->user->setFlash('announcement_create_success', '公告创建成功');
				$this->redirect(array('announcement/create'));
			}
		}

		$this->render('create', array('announcement'=>$announcement));
	}

	public function actionDelete()
	{
		$announcementId = $_GET['id'];
		if(isset($announcementId) && (Announcement::isExist($announcementId)))
		{
			$announcement = Announcement::model()->findByPk($announcementId);
			$announcement->delete();
		}
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'create', 'delete'),
				'roles'=>array('admin'),
			),
			array('deny',
				'actions'=>array('index', 'create', 'delete'),
				'users'=>array('*'),
			),
		);
	}
}