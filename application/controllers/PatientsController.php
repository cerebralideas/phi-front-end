<?php

class PatientsController extends Zend_Controller_Action {

	public function indexAction() {

		$this->_redirect('/patients/search/');
        die();
	}

    public function searchAction() {

        $searchName = $this->_request->getParam('searchName', '');
        $searchSSN = $this->_request->getParam('searchSSN', '');
        $showResults = 0;

        $url = '/patients/patient?patientId={{pt
        .uniqueId}}&origin=search&data=patient-info&searchTerms={{searchTerms}}';
        $this->view->url = $url;

        $origin = $this->_getParam('origin', '');
        $this->view->origin = $origin;

        $data = $this->_getParam('data', '');
        $this->view->data = $data;

        $stage = $this->_getParam('stage', '');
        $this->view->stage = $stage;

        $searchTerms = $this->_getParam('searchTerms', '');
        $this->view->searchTerms = $searchTerms;

        $mainPanelWidth = "span8";
        $this->view->mainPanelWidth = $mainPanelWidth;

        $supportPanelWidth = "span4";
        $this->view->supportPanelWidth = $supportPanelWidth;

        $this->view->searchName = $searchName;
        $this->view->searchSSN = $searchSSN;
        $this->view->showResults = $showResults;
    }

    public function patientAction() {

        $patientId = $this->_getParam('patientId', '0');
        $this->view->patientId = $patientId;

        $origin = $this->_getParam('origin', '');
        $this->view->origin = $origin;

        $data = $this->_getParam('data', '');
        $this->view->data = $data;

        $stage = $this->_getParam('stage', '');
        $this->view->stage = $stage;

        $searchTerms = $this->_getParam('searchTerms', '');
        $this->view->searchTerms = $searchTerms;

        $mainPanelWidth = "span8";
        $this->view->mainPanelWidth = $mainPanelWidth;

        $supportPanelWidth = "span4";
        $this->view->supportPanelWidth = $supportPanelWidth;

    }

    public function newAction() {

        $origin = $this->_getParam('origin', '');
        $this->view->origin = $origin;

        $data = $this->_getParam('data', '');
        $this->view->data = $data;

        $stage = $this->_getParam('stage', '');
        $this->view->stage = $stage;

        $searchTerms = $this->_getParam('searchTerms', '');
        $this->view->searchTerms = $searchTerms;

        $mainPanelWidth = "span8";
        $this->view->mainPanelWidth = $mainPanelWidth;

        $supportPanelWidth = "span4";
        $this->view->supportPanelWidth = $supportPanelWidth;
    }

    public function appointmentsAction() {

        $urlEdit = '/patients/appointments?patientId={{pt.uniqueId}}&aptId={{apt.aptId}}&origin=search&data=appointment&searchTerms={{searchTerms}}&stage=edit';
        $this->view->urlEdit = $urlEdit;

        $urlNew = '/patients/appointments?patientId={{pt.uniqueId}}&origin=search&data=appointment&searchTerms={{searchTerms}}&stage=new';
        $this->view->urlNew = $urlNew;

        $patientId = $this->_getParam('patientId', '0');
        $this->view->patientId = $patientId;

        $aptId = $this->_getParam('aptId', '0');
        $this->view->aptId = $aptId;

        $origin = $this->_getParam('origin', '');
        $this->view->origin = $origin;

        $data = $this->_getParam('data', '');
        $this->view->data = $data;

        $stage = $this->_getParam('stage', '');
        $this->view->stage = $stage;

        $searchTerms = $this->_getParam('searchTerms', '');
        $this->view->searchTerms = $searchTerms;

        $mainPanelWidth = "span8";
        $this->view->mainPanelWidth = $mainPanelWidth;

        $supportPanelWidth = "span4";
        $this->view->supportPanelWidth = $supportPanelWidth;
    }

    public function admissionsAction() {

        $urlEdit = '/patients/admissions?patientId={{pt.uniqueId}}&admId={{adm.admId}}&origin=search&data=admission&searchTerms={{searchTerms}}&stage=edit';
        $this->view->urlEdit = $urlEdit;

        $urlNew = '/patients/admissions?patientId={{pt.uniqueId}}&origin=search&data=admission&searchTerms={{searchTerms}}&stage=new';
        $this->view->urlNew = $urlNew;

        $patientId = $this->_getParam('patientId', '0');
        $this->view->patientId = $patientId;

        $admId = $this->_getParam('admId', '0');
        $this->view->admId = $admId;

        $origin = $this->_getParam('origin', '');
        $this->view->origin = $origin;

        $data = $this->_getParam('data', '');
        $this->view->data = $data;

        $stage = $this->_getParam('stage', '');
        $this->view->stage = $stage;

        $searchTerms = $this->_getParam('searchTerms', '');
        $this->view->searchTerms = $searchTerms;

        $mainPanelWidth = "span8";
        $this->view->mainPanelWidth = $mainPanelWidth;

        $supportPanelWidth = "span4";
        $this->view->supportPanelWidth = $supportPanelWidth;
    }

    public function opSuperbillsAction() {

        $urlSbEdit = '/patients/op-superbills?patientId={{pt.uniqueId}}&aptId={{opSb.aptId}}&opSbId={{opSb
        .opSbId}}&origin=search&data=superbill&searchTerms={{searchTerms}}&stage=edit';
        $this->view->urlSbEdit = $urlSbEdit;

        $urlSbNew = '/patients/op-superbills?patientId={{pt
        .uniqueId}}&origin=search&data=superbill&searchTerms={{searchTerms}}&stage=new';
        $this->view->urlSbNew = $urlSbNew;

        // Ignore the below and use the url found in ctrlr-patient.js
        // $urlNewApt = '/patients/ip-billing?patientId={{pt
        // .uniqueId}}&origin=search&data=appointment&data2=superbill&searchTerms={{searchTerms}}&stage=new';
        // $this->view->urlNewApt = $urlNewApt;

        $patientId = $this->_getParam('patientId', '0');
        $this->view->patientId = $patientId;

        $aptId = $this->_getParam('aptId', '0');
        $this->view->aptId = $aptId;

        $opSbId = $this->_getParam('opSbId', '0');
        $this->view->opSbId = $opSbId;

        $origin = $this->_getParam('origin', '');
        $this->view->origin = $origin;

        $data = $this->_getParam('data', '');
        $this->view->data = $data;

        $stage = $this->_getParam('stage', '');
        $this->view->stage = $stage;

        $searchTerms = $this->_getParam('searchTerms', '');
        $this->view->searchTerms = $searchTerms;

        $mainPanelWidth = "span8";
        $this->view->mainPanelWidth = $mainPanelWidth;

        $supportPanelWidth = "span4";
        $this->view->supportPanelWidth = $supportPanelWidth;
    }

	public function opClaimsAction() {

		$urlClEdit = '/patients/op-claims?patientId={{pt.uniqueId}}&aptId={{opCl.aptId}}&opSbId={{opCl
        .opSbId}}&opClId={{opCl.opClId}}&origin=search&data=claim&searchTerms={{searchTerms}}&stage=edit';
		$this->view->urlClEdit = $urlClEdit;

		$urlClNew = '/patients/op-claims?patientId={{pt
        .uniqueId}}&origin=search&data=claim&searchTerms={{searchTerms}}&stage=new';
		$this->view->urlClNew = $urlClNew;

		$patientId = $this->_getParam('patientId', '0');
		$this->view->patientId = $patientId;

		$aptId = $this->_getParam('aptId', '0');
		$this->view->aptId = $aptId;

		$opSbId = $this->_getParam('opSbId', '0');
		$this->view->opSbId = $opSbId;

		$opClId = $this->_getParam('opClId', '0');
		$this->view->opClId = $opClId;

		$origin = $this->_getParam('origin', '');
		$this->view->origin = $origin;

		$data = $this->_getParam('data', '');
		$this->view->data = $data;

		$stage = $this->_getParam('stage', '');
		$this->view->stage = $stage;

		$searchTerms = $this->_getParam('searchTerms', '');
		$this->view->searchTerms = $searchTerms;

		$mainPanelWidth = "span8";
		$this->view->mainPanelWidth = $mainPanelWidth;

		$supportPanelWidth = "span4";
		$this->view->supportPanelWidth = $supportPanelWidth;
	}

	public function accountAction() {

		$urlAccItemEdit = '/patients/account?patientId={{pt.uniqueId}}&accItemId={{accItem.id}}&origin=search&data=accItem&searchTerms={{searchTerms}}&stage=edit';
		$this->view->urlAccItemEdit = $urlAccItemEdit;

		$urlAccItemNew = '/patients/account?patientId={{pt
        .uniqueId}}&origin=search&data=accItem&searchTerms={{searchTerms}}&stage=new';
		$this->view->urlAccItemNew = $urlAccItemNew;

		$patientId = $this->_getParam('patientId', '0');
		$this->view->patientId = $patientId;

		$accItemId = $this->_getParam('accItemId', '0');
		$this->view->accItemId = $accItemId;

		$origin = $this->_getParam('origin', '');
		$this->view->origin = $origin;

		$data = $this->_getParam('data', '');
		$this->view->data = $data;

		$stage = $this->_getParam('stage', '');
		$this->view->stage = $stage;

		$searchTerms = $this->_getParam('searchTerms', '');
		$this->view->searchTerms = $searchTerms;

		$mainPanelWidth = "span8";
		$this->view->mainPanelWidth = $mainPanelWidth;

		$supportPanelWidth = "span4";
		$this->view->supportPanelWidth = $supportPanelWidth;
	}
}
