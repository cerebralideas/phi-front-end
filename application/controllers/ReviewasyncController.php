<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sneese
 * Date: 3/20/12
 * Time: 11:18 AM
 * To change this template use File | Settings | File Templates.
 */
class ReviewasyncController extends Zend_Controller_Action
{
    private $_auth;
    private $_storage;

    public function init()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_auth = Zend_Auth::getInstance();
        $this->_storage = $this->_auth->getStorage();

    }

    public function patientAction()
    {
        $submissionStatusId = $this->_getParam('submissionStatusId', '1');
        $submissionService = new Service_Submission();

        $message = $submissionService->getSubmissions('1', $submissionStatusId);

        $json = Zend_Json::encode($message);

        echo $json;
    }


}

