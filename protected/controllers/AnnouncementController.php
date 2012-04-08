<?php

class AnnouncementController extends Controller
{
	public function actionView()
	{
		if(isset($_GET['id']) && Announcement::isExist($_GET['id']))
		{
			$announcement = Announcement::model()->findByPk($_GET['id']);
			$this->render('view', array('announcement'=>$announcement));
		}
		else
		{
			throw new CHttpException(404, '公告不存在');
		}
	}
}