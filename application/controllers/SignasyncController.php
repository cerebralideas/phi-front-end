<?php
class SignasyncController extends Zend_Controller_Action
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

    public function submitAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));

        $submissionId = 0;
        $userModel = new Model_Users();

        /* Check for required fields */
        if ( isset( $value[0]['profId'] ) && isset( $value[0]['eSig'] ) && isset( $value[0]['subType'] ) && isset( $value[0]['uniqueId'] ) )
        {
            $validEsignature = $userModel->validateEsignature($this->userId, $value[0]['eSig']);
            if ($validEsignature)
            {
                /* Store submission stub */
                $submissionModel = new Model_Submission();
                $data = array(
                    'submissionType' => $value[0]['subType'],
                    'uniqueId' => $value[0]['uniqueId'],
                    'submissionTo' => $value[0]['profId'],
                    'submissionStatus' => 'unreviewed'
                );

                $submissionModel->insert( $data );
                $submissionId = $submissionModel->getAdapter()->lastInsertId();

                /* Sign & Submit Patient Registration Info */
                if ( strcasecmp( $value[0]['subType'], 'reg' ) == 0 )
                {
                    $ptService = new Service_Pt();

                    /* Update Working Copy */
                    $ptService->updateJson( $value[1] );

                    /* Store Submission Details */
                    $ptService->submitJson( $value[1], $submissionId);
                }
                /* Sign & Submit Apt Info */
                elseif ( strcasecmp( $value[0]['subType'], 'apt' ) == 0 )
                {
                    $aptService = new Service_Apt();

                    /* Update Working Copy */
                    $aptService->updateJson( $value[1] );

                    /* Store Submission Details */
                    $aptService->submitJson( $value[1], $submissionId);
                }
                /* Sign & Submit Adm Info */
                elseif ( strcasecmp( $value[0]['subType'], 'adm' ) == 0 )
                {
                    $admService = new Service_Adm();

                    /* Update Working Copy */
                    $admService->updateJson( $value[1] );

                    /* Store Submission Details */
                    $admService->submitJson( $value[1], $submissionId);
                }
                /* Sign & Submit Op Sb Info */
                elseif ( strcasecmp( $value[0]['subType'], 'opsb' ) == 0 )
                {
                    $opSbService = new Service_OpSb();

                    /* Update Working Copy */
                    $opSbService->updateJson( $value[1] );

                    /* Store Submission Details */
                    $opSbService->submitJson( $value[1], $submissionId);
                }
                /* Sign & Submit Op Cl Info */
                elseif ( strcasecmp( $value[0]['subType'], 'opcl' ) == 0 )
                {
                    $opClService = new Service_OpCl();

                    /* Update Working Copy */
                    $opClService->updateJson( $value[1] );

                    /* Store Submission Details */
                    $opClService->submitJson( $value[1], $submissionId);
                }

                /* Need to store submission comment */
                if ( $value[0]['comment'] )
                {
                    $activityService = new Service_Activity();
                    $activityService->insertSubmissionComment($submissionId, $value[0]['comment']);
                }

            }

        }

        echo $submissionId;

    }

}