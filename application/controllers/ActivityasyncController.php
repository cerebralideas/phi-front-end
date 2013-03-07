<?php
class ActivityasyncController extends Zend_Controller_Action
{
    private $auth;
    private $storage;
    private $userId;

    public function init()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->auth = Zend_Auth::getInstance();
        $this->storage = $this->auth->getStorage();
        $this->userId = $this->storage->read()->id;
        $this->activityService = new Service_Activity();
    }

    public function getlistbytypeAction()
    {
        $subtype = $this->_request->getParam('subtype');
        echo $this->activityService->getListByType( $subtype );
    }

    public function getsubmissionAction()
    {

        $subId = $this->_request->getParam('subId');
        $subtype = $this->_request->getParam('subtype');
        echo $this->activityService->getSubmission( $subId, $subtype );

    }

    public function insertsubmissioncommentAction()
    {
        $subId = $this->_request->getParam('subId');
        $comment = $this->_request->getParam('comment');
        $this->activityService->insertSubmissionComment($subId, $comment);
    }

    public function changesubmissionstatusAction()
    {
        $subId = $this->_request->getParam('subId');
        $subStatus = $this->_request->getParam('subStatus');
        $this->activityService->changeSubmissionStatus($subId, $subStatus);
    }

    public function getauthorcommentsAction()
    {
        $subId = $this->_request->getParam('subId');
        echo $this->activityService->getAuthorComments($subId);
    }
    public function getreviewercommentsAction()
    {
        $subId = $this->_request->getParam('subId');
        echo $this->activityService->getReviewerComments($subId);
    }
    public function getcommentsAction()
    {
        $subId = $this->_request->getParam('subId');
        echo $this->activityService->getComments($subId);
    }
}