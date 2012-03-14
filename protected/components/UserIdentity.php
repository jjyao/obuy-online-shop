<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public $email;
	private $_id;

	public function __construct($email, $password)
	{
		parent::__construct('', $password);
		$this->email = $email;
	}

	/**
	 * Authenticates a user.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$client = Client::model()->findByAttributes(array('email'=>$this->email, 'isActive'=>Client::ACTIVE));
		if(is_null($client))
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else
		{
			if($client->password !== $client->encrypt($this->password))
			{
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			}
			else
			{
				$this->_id = $client->id;
				$this->username = $client->name;
				$this->errorCode = self::ERROR_NONE;

				// store email
				$this->setState('email', $this->email);

				// check if current user is admin
				$adminId = Yii::app()->db->createCommand()->select('id')->from('admin')->where('clientId=:clientId', array(':clientId'=>$client->id))->queryRow();
				if($adminId === false)
				{
					$this->setState('isAdmin', false);
				}
				else
				{
					$this->setState('isAdmin', true);
				}
			}
		}
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}