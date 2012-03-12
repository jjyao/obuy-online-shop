<?php

/**
 * RegisterForm class
 * RegisterForm is the data structure for keeping user register form data
 * It is used by the 'register' action of 'SiteController'
 */ 
class RegisterForm extends CFormModel
{
	public $email;
	public $password;
	public $confirmPassword;
	public $username;
	public $cityname;
	public $address;

	// city object
	public $city;

	public function attributeLabels()
	{
		return array(
			'email'=>'邮箱',
			'password'=>'密码',
			'confirmPassword'=>'确认密码',
			'username'=>'用户名',
			'address'=>'地址',
			'cityname'=>'市',
		);
	}

	public function rules()
	{
		return array(
			array('email, password, confirmPassword, username, cityname, address', 'required'),
			array('email, password, confirmPassword, username, cityname', 'length', 'max' => 255),
			array('password', 'length', 'min' => 6),
			array('address', 'length', 'max' => 511),
			array('email', 'email', 'checkMX'=>true),
			array('confirmPassword', 'compare', 'compareAttribute'=>'password'),
			array('cityname', 'cityExistCheck'),
			array('email', 'unique', 'className'=>'Client', 'message'=>'该邮箱已被使用'),
		);
	}

	/**
	 * This function validator check whether city is valid
	 * A city is valid only if it exists in database
	 */
	public function cityExistCheck($attribute, $params)
	{
		$this->city = City::model()->findByAttributes(array('name'=>$this->cityname));
		if(is_null($this->city)) // no such city
		{
			$this->addError('address', '该城市不存在');
		}
	}
}