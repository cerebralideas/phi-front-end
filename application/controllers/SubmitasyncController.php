<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sneese
 * Date: 3/20/12
 * Time: 11:18 AM
 * To change this template use File | Settings | File Templates.
 */
class SubmitasyncController extends Zend_Controller_Action
{
    private $_auth;
    private $_storage;
    private $userId;


    public function init()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_auth = Zend_Auth::getInstance();
        $this->_storage = $this->_auth->getStorage();
        $this->userId = $this->_storage->read()->id;
    }

    public function patientAction()
    {
        $patientId = $this->_getParam('patientId');
        $submitToProvider = $this->_getParam('submitToProvider');
        $signSubmitSig = $this->_getParam('signSubmitSig');
        $signSubmitComments = $this->_getParam('signSubmitComments');
        $userId = $this->_storage->read()->id;


        $userModel = new Model_Users();

        $validEsignature = $userModel->validateEsignature($userId, $signSubmitSig);

        $message = array();
        if ($validEsignature)
        {
            $message = array(
                'success' => '1',
                'message' => ''
            );

            $submissionService = new Service_Submission();
            $submissionService->patientSubmit($patientId, $submitToProvider, $signSubmitComments);
        }
        else
        {
            $message = array(
                'success' => '0',
                'message' => 'Invalid eSignature.'
            );
        }
        $json = Zend_Json::encode($message);

        echo $json;
    }

    public function statuslistAction()
    {
        $statusModel = new Model_SubmissionStatus();
        $query =
            $statusModel->select()
            ->order(array('submission_status_id'))
            ->query();

        $result = $query->fetchAll();
        $json = Zend_Json::encode($result);
        echo $json;
    }

    public function changestatusAction()
    {
        $submissionId = $this->_getParam('submissionId');
        $submissionStatusId = $this->_getParam('submissionStatusId');
        $comment = $this->_getParam('comment');

        if ($submissionStatusId && $submissionId)
        {
            $submissionModel = new Model_Submission();
            $submissionModel->update(
                array('submission_status_id' => $submissionStatusId),
                'submission_id = '.$submissionModel->quote($submissionId));

            // store initial comment if any
            if (trim($comment) != '')
            {
                $submissionCommentData = array(
                    'submission_id' => $submissionId,
                    'comment' => $comment,
                    'created_by' => $this->userId,
                    'created_date' => date('Y-m-d H:i:s'),
                    'modified_by' => $this->userId,
                    'modified_date' => date('Y-m-d H:i:s')
                );

                $submissionCommentModel = new Model_SubmissionComment();
                $submissionCommentModel->insert($submissionCommentData);
            }

            $message = array(
                'success' => '1',
                'message' => ''
            );
        }
        else
        {
            $message = array(
                'success' => '0',
                'message' => 'Error'
            );
        }
        $json = Zend_Json::encode($message);

        echo $json;

    }

}