<?php

class NeehrPerfect_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract 
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		if (Zend_Auth::getInstance()->hasIdentity())
		{
			// Retrive current user
			//$userModel = new Model_Users();
			//$cUser = $userModel->getByUserId(Zend_Auth::getInstance()->getStorage()->read()->id);
            //$cUser = $userModel->getByUserId(1);

            //Zend_Debug::dump(Zend_Auth::getInstance()->getStorage()->read());
            //die();
			//if ( $cUser['agreement_date'] === "" || $cUser['agreement_date'] == null)
			//{
			//	$role = 'guest';
			//}
			//else
			//{
			$role = Zend_Auth::getInstance()->getStorage()->read()->role;
			//}
			
		}
		else
		{
			$role = 'guest';
		}
		
		$acl = new NeehrPerfect_Acl();
		
		if (!$acl->isAllowed(
			$role,
			$request->getControllerName(),
			$request->getActionName()
		))
		{
			// Access Denied!
			throw new Zend_Exception('Access Denied', '401');
		}
		
	}
}