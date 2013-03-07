<?php
    /**
     * Created by JetBrains PhpStorm.
     * User: sneese
     * Date: 3/21/12
     * Time: 9:41 AM
     */

    class ActivityController extends Zend_Controller_Action {

        public function indexAction() {

            $this->_redirect('/activity/registrations');
        }

        public function statuspanelAction() {

            // Disable layout as this will load via JQuery
            $this->_helper->layout()->disableLayout();

            $submissionId = $this->_getParam('submissionId');

            $submissionService = new Service_Submission();
            $statusHistory = $submissionService->getSubmissionHistory($submissionId);
            $statusComments = $submissionService->getSubmissionComment($submissionId);
            $submission = $submissionService->getSubmission($submissionId);
            $patient = $submissionService->getPatientSubmission($submissionId);

            //Zend_Debug::dump($statusHistory);
            //Zend_Debug::dump($statusComments);
            //Zend_Debug::dump($submission);
            //die();

            $this->view->statusHistory = $statusHistory;
            $this->view->statusComments = $statusComments;
            $this->view->submission = $submission;
            $this->view->firstName = stripslashes($patient['fname']);
            $this->view->lastName = stripslashes($patient['lname']);
            $this->view->submissionId = $submissionId;
            $this->view->submittedBy = stripslashes($patient['submitted_by']);
            $this->view->submittedDate = date('m/d/Y H:i', strtotime($patient['submitted_date']));


        }

        public function reportpanelAction() {

            // Disable layout as this will load via JQuery
            $this->_helper->layout()->disableLayout();

            $submissionId = $this->_getParam('submissionId');
            $submissionService = new Service_Submission();
            $patient = $submissionService->getPatientSubmission($submissionId);


            Zend_Debug::dump($patient);
            //die();
            // Get sex abbreviation
            if ($patient['sex_id'] != '')
            {
                $sexModel = new Model_Sex();
                $sexAbbr = $sexModel->getAbbrBySexId($patient['sex_id']);
            }
            else
            {
                $sexAbbr = 'Unk';
            }

            // Calculate age
            $diff = abs(strtotime(date('m/d/Y')) - strtotime($patient['dob']));
            $age = floor($diff / (365*60*60*24));



            $this->view->patientId = stripslashes($patient['id']);
            $this->view->firstName = stripslashes($patient['fname']);
            $this->view->lastName = stripslashes($patient['lname']);
            $this->view->middleName = stripslashes($patient['mname']);
            $this->view->dateOfBirth = date('m/d/Y', strtotime($patient['dob']));
            $this->view->age = $age;
            $this->view->Sex = $patient['sex_id'];
            $this->view->ssn = substr($patient['ssn'],0,3)."-".substr($patient['ssn'],3,2)."-".substr($patient['ssn'],5,4);
            $this->view->sexAbbr = $sexAbbr;
            $this->view->streetAddress = stripslashes($patient['address1']);
            $this->view->apptNum = stripslashes($patient['address2']);
            $this->view->city = stripslashes($patient['city']);
            $this->view->State = stripslashes($patient['state']);
            $this->view->zip = stripslashes($patient['zip']);
            $this->view->homePhone = stripslashes($patient['hphone']);
            $this->view->workPhone = stripslashes($patient['wphone']);
            $this->view->cellPhone = stripslashes($patient['cphone']);
            $this->view->email = stripslashes($patient['email']);
            $this->view->nationality = stripslashes($patient['nationality']);
            $this->view->MaritalStatus = stripslashes($patient['marital_status_id']);
            $this->view->patientComments = stripslashes($patient['comments']);
            $this->view->contactFullName = stripslashes($patient['ec_fullname']);
            $this->view->contactPhoneNumber = stripslashes($patient['ec_mphone']);
            $this->view->contactAddress = stripslashes($patient['ec_full_address']);
            $this->view->primaryCareProvider = stripslashes($patient['primary_care_provider_id']);
            $this->view->referringProvider = stripslashes($patient['referring_provider_id']);
            $this->view->renderingProvider = stripslashes($patient['rendering_provider_id']);
            $this->view->serviceLocation = stripslashes($patient['service_location_id']);
            $this->view->guarantorName = stripslashes($patient['guarantor_name']);
            $this->view->guarantorRelationship = stripslashes($patient['guarantor_relationship_id']);
            $this->view->guarantorStreetAddress = stripslashes($patient['guarantor_address1']);
            $this->view->guarantorApptNum = stripslashes($patient['guarantor_address2']);
            $this->view->guarantorCity = stripslashes($patient['guarantor_city']);
            $this->view->guarantorState = stripslashes($patient['guarantor_state']);
            $this->view->guarantorZip = stripslashes($patient['guarantor_zip']);
            $this->view->primaryInsurance = stripslashes($patient['insurance1_id']);
            $this->view->toHolder1Relationship = stripslashes($patient['insurance1_relationship_id']);
            $this->view->groupNumber1 = stripslashes($patient['insurance1_group_number']);
            $this->view->effectiveDate1 = date('m/d/Y', strtotime($patient['insurance1_effective_date']));
            $this->view->expirationDate1 = date('m/d/Y', strtotime($patient['insurance1_expiration_date']));
            $this->view->policyNumber1 = stripslashes($patient['insurance1_policy_number']);
            $this->view->planName1 = stripslashes($patient['insurance1_plan_name']);
            $this->view->active1 = stripslashes($patient['insurance1_active']);
            $this->view->verified1 = stripslashes($patient['insurance1_verified']);
            $this->view->firstName1 = stripslashes($patient['insurance1_fname']);
            $this->view->lastName1 = stripslashes($patient['insurance1_lname']);
            $this->view->insurance1Sex = stripslashes($patient['insurance1_sex_id']);
            $this->view->dateOfBirth1 = date('m/d/Y', strtotime($patient['insurance1_dob']));
            $this->view->socialSecurityNumber1 = stripslashes($patient['insurance1_ssn']);
            $this->view->homePhone1 = stripslashes($patient['insurance1_hphone']);
            $this->view->streetAddress1 = stripslashes($patient['insurance1_address1']);
            $this->view->apptNumber1 = stripslashes($patient['insurance1_address2']);
            $this->view->city1 = stripslashes($patient['insurance1_city']);
            $this->view->insurance1State = stripslashes($patient['insurance1_state']);
            $this->view->zip1 = stripslashes($patient['insurance1_zip']);
            $this->view->secondaryInsurance = stripslashes($patient['insurance2_id']);
            $this->view->toHolder2Relationship = stripslashes($patient['insurance2_relationship_id']);
            $this->view->groupNumber2 = stripslashes($patient['insurance2_group_number']);
            $this->view->effectiveDate2 = date('m/d/Y', strtotime($patient['insurance2_effective_date']));
            $this->view->expirationDate2 = date('m/d/Y', strtotime($patient['insurance2_expiration_date']));
            $this->view->policyNumber2 = stripslashes($patient['insurance2_policy_number']);
            $this->view->planName2 = stripslashes($patient['insurance2_plan_name']);
            $this->view->active2 = stripslashes($patient['insurance2_active']);
            $this->view->verified2 = stripslashes($patient['insurance2_verified']);
            $this->view->firstName2 = stripslashes($patient['insurance2_fname']);
            $this->view->lastName2 = stripslashes($patient['insurance2_lname']);
            $this->view->insurance2Sex = stripslashes($patient['insurance2_sex_id']);
            $this->view->dateOfBirth2 = date('m/d/Y', strtotime($patient['insurance2_dob']));
            $this->view->socialSecurityNumber2 = stripslashes($patient['insurance2_ssn']);
            $this->view->homePhone2 = stripslashes($patient['insurance2_hphone']);
            $this->view->streetAddress2 = stripslashes($patient['insurance2_address2']);
            $this->view->apptNumber2 = stripslashes($patient['insurance2_address2']);
            $this->view->city2 = stripslashes($patient['insurance2_city']);
            $this->view->insurance2State = stripslashes($patient['insurance2_state']);
            $this->view->zip2 = stripslashes($patient['insurance2_zip']);
            $this->view->tertiaryInsurance = stripslashes($patient['insurance3_id']);
            $this->view->toHolder3Relationship = stripslashes($patient['insurance3_relationship_id']);
            $this->view->groupNumber3 = stripslashes($patient['insurance3_group_number']);
            $this->view->effectiveDate3 = date('m/d/Y', strtotime($patient['insurance3_effective_date']));
            $this->view->expirationDate3 = date('m/d/Y', strtotime($patient['insurance3_expiration_date']));
            $this->view->policyNumber3 = stripslashes($patient['insurance3_policy_number']);
            $this->view->planName3 = stripslashes($patient['insurance3_plan_name']);
            $this->view->active3 = stripslashes($patient['insurance3_active']);
            $this->view->verified3 = stripslashes($patient['insurance3_verified']);
            $this->view->firstName3 = stripslashes($patient['insurance3_fname']);
            $this->view->lastName3 = stripslashes($patient['insurance3_lname']);
            $this->view->insurance3Sex = stripslashes($patient['insurance3_sex_id']);
            $this->view->dateOfBirth3 = date('m/d/Y', strtotime($patient['insurance3_dob']));
            $this->view->socialSecurityNumber3 = stripslashes($patient['insurance3_ssn']);
            $this->view->homePhone3 = stripslashes($patient['insurance3_hphone']);
            $this->view->streetAddress3 = stripslashes($patient['insurance3_address3']);
            $this->view->apptNumber3 = stripslashes($patient['insurance3_address3']);
            $this->view->city3 = stripslashes($patient['insurance3_city']);
            $this->view->insurance3State = stripslashes($patient['insurance3_state']);
            $this->view->zip3 = stripslashes($patient['insurance3_zip']);
            $this->view->submissionId = stripslashes($patient['submission_id']);
            $this->view->submittedBy = stripslashes($patient['submitted_by']);
            $this->view->submittedDate = date('m/d/Y H:i', strtotime($patient['submitted_date']));


        }

        public function registrationsAction() {

            $urlReview = '/activity/registrations?itemId={{itemId}}&data=review';
            $this->view->urlReview = $urlReview;

            $itemId = $this->_getParam('itemId', '0');
            $this->view->itemId = $itemId;

            $data = $this->_getParam('data', '');
            $this->view->data = $data;

            $mainPanelWidth = "span8";
            $this->view->mainPanelWidth = $mainPanelWidth;

            $supportPanelWidth = "span4";
            $this->view->supportPanelWidth = $supportPanelWidth;
        }

        public function appointmentsAction() {

            $urlReview = '/activity/appointments?itemId={{itemId}}&data=review';
            $this->view->urlReview = $urlReview;

            $itemId = $this->_getParam('itemId', '0');
            $this->view->itemId = $itemId;

            $data = $this->_getParam('data', '');
            $this->view->data = $data;

            $mainPanelWidth = "span8";
            $this->view->mainPanelWidth = $mainPanelWidth;

            $supportPanelWidth = "span4";
            $this->view->supportPanelWidth = $supportPanelWidth;
        }

        public function superbillsAction() {

            $urlReview = '/activity/superbills?itemId={{itemId}}&data=review';
            $this->view->urlReview = $urlReview;

            $itemId = $this->_getParam('itemId', '0');
            $this->view->itemId = $itemId;

            $data = $this->_getParam('data', '');
            $this->view->data = $data;

            $mainPanelWidth = "span8";
            $this->view->mainPanelWidth = $mainPanelWidth;

            $supportPanelWidth = "span4";
            $this->view->supportPanelWidth = $supportPanelWidth;
        }

        public function claimsAction() {

            $urlReview = '/activity/claims?itemId={{itemId}}&data=review';
            $this->view->urlReview = $urlReview;

            $itemId = $this->_getParam('itemId', '0');
            $this->view->itemId = $itemId;

            $data = $this->_getParam('data', '');
            $this->view->data = $data;

            $mainPanelWidth = "span8";
            $this->view->mainPanelWidth = $mainPanelWidth;

            $supportPanelWidth = "span4";
            $this->view->supportPanelWidth = $supportPanelWidth;
        }

        public function admissionsAction() {

            $urlReview = '/activity/admissions?itemId={{itemId}}&data=review';
            $this->view->urlReview = $urlReview;

            $itemId = $this->_getParam('itemId', '0');
            $this->view->itemId = $itemId;

            $data = $this->_getParam('data', '');
            $this->view->data = $data;

            $mainPanelWidth = "span8";
            $this->view->mainPanelWidth = $mainPanelWidth;

            $supportPanelWidth = "span4";
            $this->view->supportPanelWidth = $supportPanelWidth;
        }

        public function testAction()
        {
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();

            $activityService = new Service_Activity();
            //$activityService->insertSubmissionComment( 1, "This is also my comment");
            //$activityService->changeSubmissionStatus( 1, "Reviewed");

            echo $activityService->getAuthorComments(1);

            echo $activityService->getReviewerComments(1);
        }
    }