<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: sneese
	 * Date: 3/21/12
	 * Time: 9:41 AM
	 */

class CalendarController extends Zend_Controller_Action {

	public function indexAction() {

        $this->_redirect('/calendar/day?startDate='.date("m/d/Y").'&endDate='.date("m/d/Y"));
        die();
	}

    public function dayAction() {

        $urlEditAdm = '/calendar/day?startDate={{startDate}}&endDate={{endDate}}&admId={{adm.admId}}&origin=day&data=admission&searchTerms={{searchTerms}}&stage=edit&patientId={{adm.uniqueId}}';
        $this->view->urlEditAdm = $urlEditAdm;

        $urlNewAdm = '/calendar/day?startDate={{startDate}}&endDate={{endDate}}&origin=day&data=admission&searchTerms={{searchTerms}}&stage=new';
        $this->view->urlNewAdm = $urlNewAdm;

        $urlEditApt = '/calendar/day?startDate={{startDate}}&endDate={{endDate}}&aptId={{apt.aptId}}&origin=day&data=appointment&searchTerms={{searchTerms}}&stage=edit&patientId={{apt.uniqueId}}';
        $this->view->urlEditApt = $urlEditApt;

        $urlNewApt = '/calendar/day?startDate={{startDate}}&endDate={{endDate}}&origin=day&data=appointment&searchTerms={{searchTerms}}&stage=new';
        $this->view->urlNewApt = $urlNewApt;

        $startDate = $this->_getParam('startDate', '');
        $this->view->startDate = $startDate;

        $endDate = $this->_getParam('endDate', '');
        $this->view->endDate = $endDate;

        $patientId = $this->_getParam('patientId', '');
        $this->view->patientId = $patientId;

        $admId = $this->_getParam('admId', '0');
        $this->view->admId = $admId;

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
}