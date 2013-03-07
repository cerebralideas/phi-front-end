<?php

class ErrorController extends Zend_Controller_Action
{
	public function errorAction()
	{
		
		$errors = $this->_getParam('error_handler');
		switch ($errors->type)
		{
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				// 404 error -- controller or action not found
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->message = 'Page not found';
				break;
			//case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER:
			//	// 401 error -- controller or action not found
			//	$this->_helper->layout()->disableLayout();
			//	$this->getResponse()->setHttpResponseCode(401);
			//	$this->view->message = 'Access Denied';
			//	$this->_redirect('/auth/login/');
			//	break;
			default:
				// application error
				$this->_helper->layout()->disableLayout();
				$this->getResponse()->setHttpResponseCode(500);
				$this->view->message = 'Application error'.$errors->type;
				break;
		}
		$this->view->env = $this->getInvokeArg('env');
		
		$this->view->exception = $errors->exception;
		
		$this->view->request = $errors->request;
	}
}