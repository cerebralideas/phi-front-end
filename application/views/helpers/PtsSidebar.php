<?php

class Zend_View_Helper_ptsSidebar {

    public $view;

    function setView($view) {

        $this->view = $view;
        $this->supportPanelWidth = $this->view->supportPanelWidth;
        $this->controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        $this->action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        $this->origin = Zend_Controller_Front::getInstance()->getRequest()->getParam('origin');
        $this->data = Zend_Controller_Front::getInstance()->getRequest()->getParam('data');
        $this->data2 = Zend_Controller_Front::getInstance()->getRequest()->getParam('data2');
        $this->stage = Zend_Controller_Front::getInstance()->getRequest()->getParam('stage');
        $this->searchTerms = Zend_Controller_Front::getInstance()->getRequest()->getParam('searchTerms');
    }

    function ptsSidebar() {

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
                        } elseif (strcasecmp($this->data, 'accItem') == 0 && strcasecmp($this->stage, 'new') == 0) {
                            $header .= 'Post Account Item';
                        } elseif (strcasecmp($this->data, 'accItem') == 0 && strcasecmp($this->stage, 'edit') == 0) {
                            $header .= 'Edit Account Item';
                        } elseif (strcasecmp($this->origin, 'register') == 0) {
                            $header .= 'Register New Patient';
                        } elseif (strcasecmp($this->origin, 'search') == 0) {
                            $header .= 'Patient Search';
                        } else {
                            // Default header
                            $header .= 'Patient Search';
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

                        if (strcasecmp($this->origin, 'search') == 0) {

                            // It's seems she does, so let's give her the search sidebar
                            // in addition to preserving the patient file

                            if (strcasecmp($this->data, '') == 0 ||
                                strcasecmp($this->data, 'patient-info') == 0 ||
                                strcasecmp($this->data, 'appointment-list') == 0 ||
                                strcasecmp($this->data, 'admissions-list') == 0 ||
                                strcasecmp($this->data, 'op-superbills-list') == 0 ||
                                strcasecmp($this->data, 'op-claims-list') == 0 ||
                                strcasecmp($this->data, 'superbill') == 0 ||
                                strcasecmp($this->data, 'claim') == 0 ||
                                strcasecmp($this->data, 'account') == 0) {

                                /*******************************************\
                                 * PATIENT SEARCH FROM WITHIN PATIENT FILE *
                                \*******************************************/

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
                                                    $body .= '$emit("submitQuery", false, "pt")' :
                                                    $body .= '$emit("submitQuery", true, "pt")';

                                        $body .= '\'class="btn btn-success">Search</button>'.PHP_EOL.
                                    '</div>'.PHP_EOL.
                                '</form>'.PHP_EOL;

                            } elseif (strcasecmp($this->data, 'appointment') == 0) {

                                /**********************************************\
                                 * PATIENT APPOINTMENT FROM WITHIN PATIENT FILE*
                                \**********************************************/

                                $body .=
                                '<form name="aptForm" class="tab-content"'.PHP_EOL;

                                strcasecmp($this->stage, 'new') == 0 ? $body .= 'ng-init="newApt()"' : $body .= '';

                                $body .=
                                '>'.PHP_EOL.

                                    '<warning-required form-check="aptForm"></warning-required>
                                     <warning-pattern form-check="aptForm"></warning-pattern>
                                     <warning-date form-check="aptForm"></warning-date>'.PHP_EOL;

                                $body .= $this->view->partial('/partials/global/apt-form.phtml');

                                $body .=
                                '<div class="form-actions '.$this->supportPanelWidth.'">'.PHP_EOL.

                                    '<button class="btn btn-cancel btn-large">Cancel</button>'.PHP_EOL;

                                if (strcasecmp($this->data2, 'superbill') == 0) {

                                    $body .=
                                    '<button ng-click=\'save("apt", "aptForm", true)\' data-toggle="modal"
                                             ng-disabled="aptForm.$invalid" href="#saveStatusModal"
                                             class="btn btn-success btn-large">Save</button>'.PHP_EOL;

                                } else {

                                    $body .=
                                    '<button ng-click=\'save("apt", "aptForm")\' data-toggle="modal"
                                             ng-disabled="aptForm.$invalid" href="#saveStatusModal"
                                             class="btn btn-success btn-large">Save</button>'.PHP_EOL.
                                    '<button class="btn btn-inverse btn-large" data-toggle="modal"
                                            ng-disabled="aptForm.$invalid" href="#signSubmitModal">
                                        Submit
                                    </button>'.PHP_EOL;
                                }

                                $body .= '</div>'.PHP_EOL.
                                    '</form>'.PHP_EOL;

                            } elseif (strcasecmp($this->data, 'admission') == 0) {

                                /*********************************************\
                                 * PATIENT ADMISSION FROM WITHIN PATIENT FILE*
                                \*********************************************/

                                $body .=
                                '<form name="admForm" class="tab-content"'.PHP_EOL;

                                strcasecmp($this->stage, 'new') == 0 ? $body .= 'ng-init="newAdm()"' : '';

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

                            } elseif (strcasecmp($this->data, 'accItem') == 0) {

                                /**********************************************\
                                 * PATIENT POST ACCOUNT ITEM FROM WITHIN PATIENT FILE*
                                \**********************************************/

                                $body .=
                                        '<form name="accItemForm" class="tab-content"'.PHP_EOL;

                                strcasecmp($this->stage, 'new') == 0 ? $body .= 'ng-init="newAccItem()"' : $body .= '';

                                $body .=
                                        '>'.PHP_EOL.

                                            '<warning-required form-check="accItemForm"></warning-required>
                                             <warning-pattern form-check="accItemForm"></warning-pattern>
                                             <warning-date form-check="accItemForm"></warning-date>'.PHP_EOL;

                                $body .= $this->view->partial('/partials/global/acc-item-form.phtml');

                                $body .=
                                        '<div class="form-actions '.$this->supportPanelWidth.'">'.PHP_EOL.

                                            '<button class="btn btn-cancel btn-large">Cancel</button>'.PHP_EOL;

                                    $body .=
                                        '<button ng-click=\'save("accItem", "accItemForm")\' data-toggle="modal"
                                                 ng-disabled="accItemForm.$invalid" href="#saveStatusModal"
                                                 class="btn btn-success btn-large">Save</button>'.PHP_EOL.
                                        '<!-- <button class="btn btn-inverse btn-large" data-toggle="modal"
                                                ng-disabled="accItemForm.$invalid" href="#signSubmitModal">
                                            Submit
                                        </button> -->'.PHP_EOL;

                                $body .= '</div>'.PHP_EOL.
                                        '</form>'.PHP_EOL;
                            }

                        } elseif (strcasecmp($this->origin, 'register') == 0) {

                            // It seem she does, so let's give her the appropriate sidebar

                            if (strcasecmp($this->stage, 'new') == 0) {

                                /*****************************\
                                 * PATIENT REGISTRATION FORM *
                                \*****************************/

                                $body .='<form class="row-fluid" name="newReg">'.PHP_EOL;

                                $body .= $this->view->partial('/patients/templates/patient-reg-starter.html');

                                $body .=
                                        '<div class="form-actions '.$this->supportPanelWidth.'">'.PHP_EOL.

                                            '<button class="btn btn-cancel btn-large" >Cancel</button>'.PHP_EOL.
                                            '<button ng-click="register(\'reg\',
                                            \'newReg\')" ng-disabled="newReg.$invalid" class="btn btn-success
                                            btn-large">Save</button>'
                                                .PHP_EOL.
                                        '</div>'.PHP_EOL;

                                $body .='</form>'.PHP_EOL;

                            // Have they completed the registration?

                            } elseif (strcasecmp($this->stage, 'edit') == 0) {

                                /*****************************************\
                                 * PRESENT BUTTON FOR AFTER REGISTRATION *
                                \*****************************************/

                                $body .=
                                '<form class="row-fluid">'.PHP_EOL.
                                    '<p class="formInstructions span12">'.PHP_EOL.
                                        'Use the form to the right to complete your patient, or register a new patient by clicking the button below.'.PHP_EOL.
                                    '</p>'.PHP_EOL.
                                    '<div class="registerActions">'.PHP_EOL.
                                        '<a href="/patients/new?origin=register&stage=new" class="btn btn-success marginBottom">Register Another Patient</a>'.PHP_EOL.
                                    '</div>'.PHP_EOL.
                                '</form>'.PHP_EOL;

                            }

                        // This is the fallback and what is presented to the user at initial login
                        // or if they just entered the patient section

                        } else {

                            /*******************************\
                             * DEFAULT PATIENT SEARCH FORM *
                            \*******************************/

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
                                    $body .= '$emit("submitQuery", false, "pt")' :
                                    $body .= '$emit("submitQuery", true, "pt")';

                            $body .= '\'class="btn btn-success">Search</button>'.PHP_EOL.
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