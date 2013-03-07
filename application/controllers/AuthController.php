<?php

class AuthController extends Zend_Controller_Action
{
	private $_auth;
	private $_storage;
	private $_config;
	private $_layout;
	private $_db;

	public function init()
	{
		$this->_auth = Zend_Auth::getInstance();
		$this->_storage = $this->_auth->getStorage();
		$this->_config = Zend_Registry::get('configuration');
		$this->_layout = Zend_Layout::getMvcInstance();
		$this->_db = Zend_Db::factory($this->_config->database);
	}

	public function indexAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_redirect('/auth/login/');
	}


	public function loginAction()
	{
		$this->_layout->setLayout('login');

		if ($this->getRequest()->isPost())
		{
			$uName = $this->getRequest()->getParam('uName', false);
			$uPassword = $this->getRequest()->getParam('uPassword', false);


			if ($uName != '' && $uPassword != '')
			{
				$users = new Model_Users();
				$this->_auth = Zend_Auth::getInstance();
				$licenseType = 'individual';
                $receiptsToActivate = false;

				if ($users->validateCredentials($uName, $uPassword))
				{
					$user = $users->getByCredentials($uName, $uPassword);
					$orgId = $user['organization_id'];
					$orgModel = new Model_Organizations();
					$licenseType = $orgModel->getLicenseType($orgId);

                    // check to see if user has any receipts that need to be activated
                    $receiptsModel = new Model_Receipts();
                    $receiptsWhere = $receiptsModel->getAdapter()->quoteInto('x_cust_id = ? AND activation_date IS NULL AND x_response_code = 1', $user['id']);
                    $receipts = $receiptsModel->fetchAll($receiptsWhere);


                    if ( count($receipts) > 0 )
                        $receiptsToActivate = true;
				}



                // If production environment, only allow beta users by restricting login to organizationId of 144
                if ( strcasecmp(APPLICATION_ENVIRONMENT, 'production') == 0 )
                {
                    if ($licenseType == 'institution' || $receiptsToActivate) {
                        $authAdapter = new Zend_Auth_Adapter_DbTable(
                            $this->_db,
                            'users',
                            'ehr_username',
                            'ehr_password',
                            '? AND active = 1 AND organization_id IN (144, 151, 156, 126, 145)');
                    }
                    else
                    {
                        $authAdapter = new Zend_Auth_Adapter_DbTable(
                            $this->_db,
                            'users',
                            'ehr_username',
                            'ehr_password',
                            '? AND active = 1 AND organization_id IN (144, 151, 156, 126, 145) AND (role = \'ai_admin\' OR role = \'org_admin\' OR role = \'org_faculty\'  OR (role = \'org_student\' AND license_expiration >= NOW()))');
                    }

                }
                else
                {
                    if ($licenseType == 'institution' || $receiptsToActivate) {
                        $authAdapter = new Zend_Auth_Adapter_DbTable(
                            $this->_db,
                            'users',
                            'ehr_username',
                            'ehr_password',
                            '? AND active = 1');
                    }
                    else
                    {
                        $authAdapter = new Zend_Auth_Adapter_DbTable(
                            $this->_db,
                            'users',
                            'ehr_username',
                            'ehr_password',
                            '? AND active = 1 AND (role = \'ai_admin\' OR role = \'org_admin\' OR role = \'org_faculty\'  OR (role = \'org_student\' AND license_expiration >= NOW()))');
                    }

                }


				$authAdapter->setIdentityColumn('ehr_username')
							  ->setCredentialColumn('ehr_password');

				$authAdapter->setIdentity($uName)
							->setCredential($uPassword);

				$result = $this->_auth->authenticate($authAdapter);
                //Zend_Debug::dump($result);
                //die();
				// Start & record session regardless of whether or not authentication fails
				session_name("AuthToken");
				session_start();

				if ( $result->isValid() )
				{

					$this->_storage = new Zend_Auth_Storage_Session();
					$this->_storage->write($authAdapter->getResultRowObject(null, array('password', 'agreement_date')));

					// Retrive current user
					$cUser = $users->getByCredentials($uName, $uPassword);

					// Update last login date
					$users->updateLastLoginDate($cUser['id']);

					if ( $cUser['agreement_date'] === "" || $cUser['agreement_date'] == null)
					{
						// redirect user to end user agreement acceptance page
						//$this->_redirect('/auth/acceptance/?location=' . urlencode($data['location']));
						//TODO: Add Acceptace Agreement
					}

                    $activationService = new Service_Activation();
                    $activationService->activate();

					$this->_redirect('/patients');

				}
				else
				{
					// Authentication has failed
					//check for invalid user
					$cUser = $users->getByCredentials($uName, $uPassword);
                    //Zend_Debug::dump($cUser);
                    //die();
					if($cUser)
					{
						if ($cUser['active'] != 1)
						{
							$this->view->errorMessage = "Your account is no longer active. Please contact your school administrator.";
						}
						elseif ($licenseType == 'individual' && $cUser['role'] == 'org_student' && strtotime($cUser['license_expiration']) < time())
						{
							$this->view->errorMessage = 'Your subscription has expired.<br>
								<a href="http://www.neehrperfect.com/subscribe">Click here to renew your subscription.</a>';
						}
						else
						{
							$this->view->errorMessage = "There is a problem with your Access Code &amp; Verify Code. Please contact Technical Support."; //this condition should never occur.
						}
					}
					else
					{
						$this->view->errorMessage = "Invalid Access Code or Verify Code.";
					}

				} // end else authentication has failed
			} // end form is valid
		} // end request isPost
	} // end function

	public function logoutAction()
	{
		$this->_storage = new Zend_Auth_Storage_Session();
		$this->_storage->clear();
		$this->_redirect('/auth/login/');
	}


}