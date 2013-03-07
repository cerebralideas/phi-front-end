<?php
class UserasyncController extends Zend_Controller_Action
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
    }

    public function esigsubmitAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));




        $submissionId = 0;
        $userModel = new Model_Users();

        /* Check for required fields */
        if ( isset( $value['profId'] ) && isset( $value['eSig'] ) && isset( $value['subType'] ) && isset( $value['uniqueId'] ) )
        {
            $validEsignature = $userModel->validateEsignature($this->userId, $value['eSig']);
            if ($validEsignature)
            {
                /* Store submission stub */
                $submissionModel = new Model_Submission();
                $data = array(
                    'submissionType' => $value['subType'],
                    'uniqueId' => $value['uniqueId'],
                    'submissionTo' => $value['profId'],
                    'submissionStatus' => 'Unreviewed'
                );

                $submissionModel->insert( $data );
                $submissionId = $submissionModel->getAdapter()->lastInsertId();

                /* Need to store submission comment */
            }

        }

        echo $submissionId;

    }

    public function getrolejson()
    {
        $userService = new Service_User();
        $role = $userService->getRole();
        $item = array ('role' => $role);
        return Zend_Json_Encoder::encode( $item );
    }


}