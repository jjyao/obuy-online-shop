<?php
return array(
	'authenticated' => array(
		'type'=>CAuthItem::TYPE_ROLE,
		'description'=>'anyone who login',
		'bizRule'=>'return !Yii::app()->user->isGuest;',
		'data'=>'',
	),
	
	'admin' => array(
		'type'=>CAuthItem::TYPE_ROLE,
		'description'=>'administrator',
		'bizRule'=>'return (!Yii::app()->user->isGuest && Yii::app()->user->isAdmin);',
		'data'=>'',
	),
);