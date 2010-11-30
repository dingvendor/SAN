<?php

class models_Account {
	private $_forms;
	
	public function __construct()
	{
		$this->_forms = array();
	}
		
	/***
	 * @param name form name to get
	 */
	public function getForm($name, $options = null)
	{
		$form = 'forms_'.$name;
		$this->forms[$name] = new $form($options);
		return $this->forms[$name];

	}
	
	public function login($username, $password)
	{
		$db = Zend_Registry::get('db');
		$adapter = new Zend_Auth_Adapter_DbTable(
                                $db,
                                'account',
                                'username',
                                'passwd',
                                '?'
                                );
                            $adapter->setIdentity($username);
                            $adapter->setCredential($this->encryptPassword($password));
                            $auth = Zend_Auth::getInstance();
                            $result = $auth->authenticate($adapter);
                        if ($result->isValid()) {
				$data = array('lastip' => new Zend_Db_Expr("INET_ATON('".$_SERVER['REMOTE_ADDR']."')"));
				$where = $db->quoteInto("username=?", $username);
				var_dump($data);
				var_dump($where);
				$db->update('account', $data, $where);
				//var_dump($this->_db->update('account', array('lastip' => 'INET_ATON('.$_SERVER['REMOTE_ADDR'].')'), 'username='.$this->_db->quoteInto($username)));
				// die("update");
				
                                $storage = $auth->getStorage();
                                // store the identity as an object where the password column has
                                // been omitted
                                $storage->write($adapter->getResultRowObject(
                                                null,
                                                'passwd'));
                                //$this->_helper->FlashMessenger('Successful Login');
                                //$this->_helper->redirector('index','my');
                                return true;
                            }
			else
			{
				return false;
			}
	}

	public function register($data)
	{
		// Account data
		$account['email'] = $data['email'];
		$account['regip'] = $_SERVER['REMOTE_ADDR'];
		$account['valstr'] = $this->generateValstr();
				
		// Add information to database
		$db = Zend_Registry::get('db');
		$updateQuery = $db->query("INSERT INTO account(email, regip,valstr) VALUES( ? ,INET_ATON( ? ), ? )", array($account['email'], $account['regip'], $account['valstr']));
		//$updateQuery->execute()
		 

		$account['valurl'] = '/account/validate/id/'.$db->lastInsertId().'/val/'.$account['valstr'];

		// Send Validation Email
		$this->sendValidationEmail($account);
	}

	private function sendValidationEmail($data = null)
	{
		if($data == null)
		{
			exit;
		}
		$db = Zend_Registry::get('db');

		$stmt = $db->query("SELECT subject, html, text FROM template_email WHERE id=?",1);
		$template = $stmt->fetchObject();
		
		$template->html = str_replace(array('{regip}','{valurl}'),array($data['regip'], $data['valurl']), $template->html);
		$template->text = str_replace(array('{regip}','{valurl}'),array($data['regip'], $data['valurl']), $template->text);

		// 

		$mail = new Zend_Mail();
		$mail->setBodyText($template->text);
		$mail->setBodyHtml($template->html);
		$mail->setFrom('no-reply@arkroyal.org', 'SGMS');
		$mail->addTo($data['email']);
		$mail->setSubject($template->subject);
		// Don't send emails
		$mail->send();
	}

	/**
         * Completes the registration process, sets the username
         * sets account to confirmed
         *
         */
	public function completeRegistration($data)
	{
		// var_dump($data);
		$password = $this->generatePassword();
		$data['passwd'] = $password['encrypted']; // Finalising the account needs the encrypted password

		$db = Zend_Registry::get('db');
		$email = $db->quoteInto('email=?', $data['email']);
		$dirtyemail = $data['email'];
		unset($data['email']);
		unset($data['controller']);
		unset($data['action']);
		unset($data['module']);
		unset($data['complete']);
		unset($data['usernameok']);
		$data['confirmed'] = 1;
		$data['role'] = 'user';
		// var_dump($data);
		$db->update('account', $data, $email);
		// Substitute for plain text password now
		$data['passwd'] = $password['plain'];
		$this->sendNewPassword($dirtyemail, $data);

		return true;
	}	


	private function generatePassword($length = 8)
	{	
		$password['plain'] = '';
		for($i = 0; $i < $length; $i++)
		{
			$password['plain'] .= chr(rand(33,126));
		}
		//$password['plain'] = $new_password;
		$password['encrypted'] = $this->encryptPassword($password['plain']);

		return $password;
	}

	private function generateValstr($length = 18)
	{
		$valstr = '';
		for($i = 0; $i < $length; $i++)
		{
			switch(rand(0,2))
			{
				case 2:
					$valstr .= chr(rand(48,57));
					break;
				case 1:
					$valstr .= chr(rand(65, 90));
                                        break;
				case 0:
					$valstr .= chr(rand(97, 122));
                                        break;
			}
		}
		return $valstr;
	}

	/**
	 * Checks to see if an account exists By email
	 * @return bool
	 */
	public function existsByEmail($email)
	{
		$db = Zend_Registry::get('db');
		$stmt = $db->query("SELECT username FROM account WHERE email=?", array($email));
		$result = $stmt->fetchObject();
		print_r($result);
	}
	
	/**
	 * Validates registration from email link
	 *
	 */
	public function validateRegistration($id, $valstr)
	{
		$db = Zend_Registry::get('db');

		$stmt = $db->query("SELECT id, email, confirmed FROM account WHERE id=?
				   AND confirmed=0
				   AND valstr=?", array($id, $valstr));
                $result = $stmt->fetchObject();	
		if(empty($result))
		{
			// as opposed to the traditional way of throwing exceptions
			throw new Zend_Exception('Error validating account', $err_code);
		}
		
		return $result;
	}

	/**
	 * Sends a password reset email to user
	 * asking if they want to reset their
	 * password.
	 *
	 */
	private function sendPasswordReset($email)
	{
		if($data == null)
                {
                        exit;
                }
                $db = Zend_Registry::get('db');

                $stmt = $db->query("SELECT subject, html, text FROM template_email WHERE id=?",1);
                $template = $stmt->fetchObject();

                $template->html = str_replace(array('{regip}','{valurl}'),array($data['regip'], $data['valurl']), $template->html);
                $template->text = str_replace(array('{regip}','{valurl}'),array($data['regip'], $data['valurl']), $template->text);

                $config = Zend_Registry::get('config');

                $mail = new Zend_Mail();
                $mail->setBodyText($template->text);
                $mail->setBodyHtml($template->html);
                $mail->setFrom('no-reply@arkroyal.org', 'SGMS');
                $mail->addTo($data['email']);
                $mail->setSubject($template->subject);
                // Don't send emails
                $mail->send();
	}

	/** 
	 * Sends a randomly generated password to the user.
	 *
	 *
	 */
	public function sendNewPassword($email, $data)
	{
		if($data == null)
                {
                        exit;
                }
                $db = Zend_Registry::get('db');

                $stmt = $db->query("SELECT subject, html, text FROM template_email WHERE id=?",2);
                $template = $stmt->fetchObject();

                $template->html = str_replace(array('{password}'),array($data['passwd']), $template->html);
                $template->text = str_replace(array('{password}'),array($data['passwd']), $template->text);

                $config = Zend_Registry::get('config');

                $mail = new Zend_Mail();
                $mail->setBodyText($template->text);
                $mail->setBodyHtml($template->html);
                $mail->setFrom($config->mailfrom, $config->mailfromwho);
                $mail->addTo($email);
                $mail->setSubject($template->subject);
		// var_dump($mail);
                $mail->send();
	}

	public function encryptPassword($password)
	{
		$config = Zend_Registry::get('config');
		return md5($config->salt.$password);
	}

	public function checkPassword($id, $password)
	{
		$db = Zend_Registry::get('db');
		
		// $db->update('account', array('passwd		
		/*$stmt = $db->query("SELECT id
				    FROM account
				    WHERE passwd=?
				    AND id=?", array($this->encryptPassword($password), $id)); */
		$select = $db->select()
				->from('account', 'id')
				->where("passwd=?", $this->encryptPassword($password))
				->where("id=?", $id);
		// echo $select->__toString();
		$stmt = $select->query();
		$result = $stmt->fetchAll();
		
		if(is_array($result))
		{
			return true;
		}
		else
		{
			return false;
		}

		
	}

	public function setPassword($id, $password)
	{
		$db = Zend_Registry::get('db');
	
		$result = $db->update('account', array('passwd' => $this->encryptPassword($password)), 'id='.$id);

		return $result;
	}
}
