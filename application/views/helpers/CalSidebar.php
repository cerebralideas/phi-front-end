<?php

class Zend_View_Helper_calSidebar {

    public $view;

    function setView($view) {

        $this->view = $view;
        $this->supportPanelWidth = $this->view->supportPanelWidth;
        $this->controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        $this->action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        $this->origin = Zend_Controller_Front::getInstance()->getRequest()->getParam('origin');
        $this->data = Zend_Controller_Front::getInstance()->getRequest()->getParam('data');
        $this->stage = Zend_Controller_Front::getInstance()->getRequest()->getParam('stage');
        $this->searchTerms = Zend_Controller_Front::getInstance()->getRequest()->getParam('searchTerms');
    }

    function calSidebar() {

        // Build the appropriate sidebar according to the URL parameters

        $header =
            '<section id="supportPanel" class="'.$this->supportPanelWidth.' parent">'.PHP_EOL.

                '<header class="supportPanelHeader">'.PHP_EOL.
                    '<h2>'.PHP_EOL;

                    // Show headers according to sidebar form

                    if (strcasecmp($this->data, 'appointment') == 0 && strcasecmp($this->stage, 'new') == 0) {
                        $header .= 'New Appointment';
                    } elseif (strcasecmp($this->data, 'appointment') == 0 && strcasecmp($this->stage, 'edit') == 0) {
                        $header .= 'Edit Appointment';
                    } elseif (strcasecmp($this->data, 'admission') == 0 && strcasecmp($this->stage, 'new') == 0) {
                        $header .= 'New Admission';
                    } elseif (strcasecmp($this->data, 'admission') == 0 && strcasecmp($this->stage, 'edit') == 0) {
                        $header .= 'Edit Admission';
                    } elseif (strcasecmp($this->origin, 'search') == 0) {
                        $header .= 'Calendar Search';
                    } else {
                        // Default header
                        $header .= 'Calendar Search';
                    }

            $header .=  '</h2>'.PHP_EOL.
                '</header>'.PHP_EOL;

        $tabs = '<nav id="supportNav" class="tabControls" role="navigation">'.PHP_EOL.
                    '<ul class="nav nav-tabs">'.PHP_EOL;

                    // Show tabs only if they are viewing appointment or admissions forms

                    if (strcasecmp($this->data, 'appointment') == 0) {

                        $tabs .=   '<li class="active"><a href="#details" data-toggle="tab">Details</a></li>
                                    <li><a href="#status" data-toggle="tab">Status</a></li>
                                    <li><a href="#notes" data-toggle="tab">Notes</a></li>'.PHP_EOL;

                    } elseif (strcasecmp($this->data, 'admission') == 0) {

                        $tabs .=   '<li class="active"><a href="#details" data-toggle="tab">Details</a></li>
                                    <li><a href="#status" data-toggle="tab">Status</a></li>
                                    <li><a href="#notes" data-toggle="tab">Notes</a></li>'.PHP_EOL;
                    }

                    $tabs .= '</ul>'.PHP_EOL.
                        '</nav>'.PHP_EOL;

                $body = '<div id="supportContent" class="tabContainer">'.PHP_EOL;

                    // Let's test to see if user is wanting to search
                    // while within a patient file.

                    if (strcasecmp($this->origin, 'day') == 0) {

                        // It's seems she does, so let's give her the search sidebar
                        // in addition to preserving the patient file

                        if (strcasecmp($this->data, '') == 0 ||
                            strcasecmp($this->data, 'event-list') == 0) {

                            /*******************\
                             * CALENDAR SEARCH *
                            \*******************/

                            $body .=
                                    '<form class="row-fluid">'.PHP_EOL.
                                        '<p class="formInstructions span12">'.PHP_EOL.

                                            'Use one or more fields below to find a patient.'.PHP_EOL.
                                        '</p>'.PHP_EOL.

                                        '<div class="span12">'.PHP_EOL.

                                            '<label for="searchName">First Name</label>'.PHP_EOL.

                                            '<input id="searchName" type="text" name="searchFirstName"
                                                ng-model="searchFirstName">'.PHP_EOL.
                                        '</div>'.PHP_EOL.

                                        '<div class="span12">'.PHP_EOL.

                                            '<label for="searchName">Last Name</label>'.PHP_EOL.

                                            '<input id="searchName" type="text" name="searchLastName"
                                                ng-model="searchLastName">'.PHP_EOL.
                                        '</div>'.PHP_EOL.

                                        '<div class="span12">'.PHP_EOL.

                                            '<label for="searchName">Social Security #</label>'.PHP_EOL.

                                            '<input id="searchName" type="text" name="searchSsn"
                                                ng-model="searchSsn">'.PHP_EOL.
                                        '</div>'.PHP_EOL.

                                        '<div class="span12">'.PHP_EOL.
                                            '<button id="patientSearchButton" ng-click=\'';

                            strcasecmp($this->action, 'search') == 0 ?
                                    $body .= '$emit("submitQuery", false)' :
                                    $body .= '$emit("submitQuery", true)';

                            $body .= '\'class="btn btn-success">Search</button>'.PHP_EOL.
                                    '</div>'.PHP_EOL.
                                    '</form>'.PHP_EOL;

                        } elseif (strcasecmp($this->data, 'appointment') == 0) {

                            $body .=
                                    '<form name="aptForm" class="tab-content"'.PHP_EOL;

                            $body .= strcasecmp($this->stage, 'new') == 0 ? 'ng-init="newApt()"' : 'ng-init="apt()"';

                            $body .=
                                    '>'.PHP_EOL.

                                        '<warning-required form-check="aptForm"></warning-required>
                                         <warning-pattern form-check="aptForm"></warning-pattern>
                                         <warning-date form-check="aptForm"></warning-date>'.PHP_EOL;

                            $body .= $this->view->partial('/partials/global/apt-form.phtml');

                            $body .=
                                    '<div class="form-actions '.$this->supportPanelWidth.'">'.PHP_EOL.

                                            '<button class="btn btn-cancel btn-large">Cancel</button>'.PHP_EOL.
                                            '<button ng-click=\'save("apt", "aptForm")\' data-toggle="modal"
                                                     ng-disabled="aptForm.$invalid" href="#saveStatusModal"
                                                     class="btn btn-success btn-large">Save</button>'.PHP_EOL;

                            if (strcasecmp($this->data2, 'encounter') == 0) {

                                // leave blank

                            } else {

                                $body .=
                                        '<button class="btn btn-inverse btn-large" data-toggle="modal"
                                    ng-disabled="aptForm.$invalid" href="#signSubmitModal">Submit</button>'.PHP_EOL;
                            }

                            $body .= '</div>'.PHP_EOL.
                                    '</form>'.PHP_EOL;

                        } elseif (strcasecmp($this->data, 'admission') == 0) {

                            $body .=
                                    '<form name="admForm" class="tab-content"'.PHP_EOL;

                            $body .= strcasecmp($this->stage, 'new') == 0 ? 'ng-init="newAdm()"' : 'ng-init="adm()"';

                            $body .=
                                    '>'.PHP_EOL.

                                        '<warning-required form-check="admForm"></warning-required>
                                         <warning-pattern form-check="admForm"></warning-pattern>
                                         <warning-date form-check="admForm"></warning-date>'.PHP_EOL;

                            $body .= $this->view->partial('/partials/global/adm-form.phtml');

                            $body .=
                                    '<div class="form-actions '.$this->supportPanelWidth.'">'.PHP_EOL.

                                            '<button class="btn btn-cancel btn-large">Cancel</button>'.PHP_EOL.
                                            '<button ng-click=\'save("adm", "admForm")\' data-toggle="modal"
                                                    ng-disabled="admForm.$invalid" href="#saveStatusModal"
                                                    class="btn btn-success btn-large">Save</button>'.PHP_EOL;

                            if (strcasecmp($this->data2, 'encounter') == 0) {

                                // leave blank

                            } else {

                                $body .=
                                        '<button class="btn btn-inverse btn-large" data-toggle="modal"
                                        ng-disabled="admForm.$invalid" href="#signSubmitModal">Submit</button>'.PHP_EOL;
                            }


                            $body .=
                                    '</div>'.PHP_EOL.
                                '</form>'.PHP_EOL;

                        }

                    } else {

                        /********************************\
                         * DEFAULT CALENDAR SEARCH FORM *
                        \********************************/

                        $body .=
                                '<form class="row-fluid" name="calendarSearch">'.PHP_EOL.

                                    '<warning-required form-check="calanderSearch"></warning-required>
                                     <warning-pattern form-check="calanderSearch"></warning-pattern>
                                     <warning-date form-check="calanderSearch"></warning-date>'.PHP_EOL.

                                    '<p class="formInstructions span12">'.PHP_EOL.

                                        'Use this form below to search for visits.'.PHP_EOL.
                                    '</p>'.PHP_EOL.

                                    '<p class="required span12">Mandatory Fields</p>'.PHP_EOL.

                                    '<div class="span12 required">'.PHP_EOL.

                                        '<label for="startDate">Start Date/End Date</label>'.PHP_EOL.

                                        '<div class="twoInputs">'.PHP_EOL.

                                            '<date-input
                                                model="searchStartDate" id="searchStartDate" name="Search Start Date"
                                                required="required">
                                            </date-input><date-input
                                                model="searchEndDate" id="searchEndDate" name="Search End Date">
                                            </date-input>'.PHP_EOL.

                                        '</div>'.PHP_EOL.
                                    '</div>'.PHP_EOL.

                                    /*'<div class="span12 required">'.PHP_EOL.

                                        '<label for="startDate">Visit Type</label>'.PHP_EOL.

                                        '<select ng-model="visitType" required>
                                            <option value="">Choose Type</option>
                                            <option value="apt">Appointment</option>
                                            <option value="adm">Admission</option>
                                        </select>'.PHP_EOL.
                                    '</div>'.PHP_EOL.*/

                                    '<div class="span12">'.PHP_EOL.

                                        '<label for="searchName">Patient Last Name</label>'.PHP_EOL.

                                        '<input id="searchName" type="text" name="searchPtName"
                                                ng-model="searchPtName">'.PHP_EOL.
                                    '</div>'.PHP_EOL.

                                    '<div class="span12">'.PHP_EOL.
                                        '<button ng-click=\''.PHP_EOL.

                                                '$emit("submitQuery", true, "visit", $event)'.PHP_EOL.

                                                '\'class="btn btn-success">Search</button>'.PHP_EOL.
                                    '</div>'.PHP_EOL.
                                '</form>'.PHP_EOL;
                    }

                    $footer  =
                        '</div>'.PHP_EOL.
                    '</section>'.PHP_EOL;

        // Now output the build sidebar

        $string  = $header;

        $string .= $tabs;

        $string .= $body;

        $string .= $footer;

        return $string;
    }
}