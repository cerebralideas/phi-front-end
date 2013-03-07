<?php

    class Zend_View_Helper_actSidebar {

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

        function actSidebar() {

            // Build the appropriate sidebar according to the URL parameters

            $header =
                '<section id="supportPanel" class="'.$this->supportPanelWidth.' parent">'.PHP_EOL.

                    '<header class="supportPanelHeader">'.PHP_EOL.
                        '<h2>'.PHP_EOL;

                    // Show headers according to sidebar form

                    if (strcasecmp($this->action, 'registrations') == 0) {
                        $header .= 'Registrations';
                    } elseif (strcasecmp($this->action, 'appointments') == 0) {
                        $header .= 'Appointments';
                    } elseif (strcasecmp($this->action, 'admissions') == 0) {
                        $header .= 'Admissions';
                    } elseif (strcasecmp($this->action, 'superbills') == 0) {
                        $header .= 'Superbills';
                    } elseif (strcasecmp($this->action, 'claims') == 0) {
                        $header .= 'Claims';
                    } else {
                        // Default header
                        // leave blank
                    }

                $header .=  '</h2>'.PHP_EOL.
                    '</header>'.PHP_EOL;

            $tabs = '<nav id="supportNav" class="tabControls" role="navigation">'.PHP_EOL.
                        '<ul class="nav nav-tabs">'.PHP_EOL;

                $tabs .=   '<li class="active"><a href="#unreviewed" data-toggle="tab">Unreviewed</a></li>
                            <li><a href="#reviewed" data-toggle="tab">Reviewed</a></li>
                            <li><a href="#archived" data-toggle="tab">Archived</a></li>'.PHP_EOL;

            $tabs .=    '</ul>'.PHP_EOL.
                    '</nav>'.PHP_EOL;

            $body = '<div id="supportContent" class="tabContainer">'.PHP_EOL.

                        '<form name="submitListForm" class="tab-content">'.PHP_EOL.

                            '<div id="unreviewed" class="tab-pane active row-fluid fix-space">'.PHP_EOL.

                                '<button ng-hide="student" ng-click="archive()" class="btn btn-mini btn-inverse">
                                    Archive Item(s)
                                </button>'.PHP_EOL.

                                '<table class="well data-list">
                                    <thead>
                                        <tr>
                                            <th ng-hide="student">
                                                <input
                                                    ng-change="selectAll(\'selectAllUnreviewed\', \'unreviewed\')"
                                                    ng-model="selectAllUnreviewed"
                                                    type="checkbox">
                                            </th>
                                            <th>Student</th>
                                            <th>Patient</th>
                                            <th>Sub. Date</th>
                                        </tr>
                                    </thead>

                                    <tbody id="unreviewedItems" class="availListItems">

                                        <tr class="availItem supportListRow"
                                            ng-repeat=\'item in items | filter:unreviewed | orderBy:"subId":true\'
                                        >

                                            <td ng-hide="student"><input ng-model="item.selected"  type="checkbox"></td>
                                            <td><a ng-click=\'changeRoute(item.subId, item.subtype, $event)\'>{{item.student}}</a></td>
                                            <td><a ng-click=\'changeRoute(item.subId, item.subtype, $event)\'>{{item.pt}}</a></td>
                                            <td><a ng-click=\'changeRoute(item.subId, item.subtype, $event)\'>{{item.subDate}}</a></td>
                                        </tr>
                                    </tbody>
                                </table>'.PHP_EOL.

                            '</div>'.PHP_EOL.

                            '<div id="reviewed" class="tab-pane row-fluid fix-space">'.PHP_EOL.

                                '<button ng-hide="student" ng-click="archive()" class="btn btn-mini btn-inverse">
                                    Archive Item(s)
                                </button>'.PHP_EOL.

                                '<table class="well data-list">

                                    <thead>
                                        <tr>
                                            <th ng-hide="student">
                                                <input
                                                    ng-hide="student"
                                                    ng-change="selectAll(\'selectAllReviewed\', \'reviewed\')"
                                                    ng-model="selectAllReviewed"
                                                    type="checkbox">
                                            </th>
                                            <th>Student</th>
                                            <th>Patient</th>
                                            <th>Sub. Date</th>
                                        </tr>
                                    </thead>

                                    <tbody class="availListItems">

                                        <tr class="availItem supportListRow"
                                            ng-repeat=\'item in items | filter:reviewed | orderBy:"subId":true\'
                                        >
                                            <td ng-hide="student" ><input ng-model="item.selected" type="checkbox"></td>
                                            <td><a ng-click=\'changeRoute(item.subId, item.subtype, $event)\'>{{item.student}}</a></td>
                                            <td><a ng-click=\'changeRoute(item.subId, item.subtype, $event)\'>{{item.pt}}</a></td>
                                            <td><a ng-click=\'changeRoute(item.subId, item.subtype, $event)\'>{{item.subDate}}</a></td>
                                        </tr>
                                    </tbody>
                                </table>'.PHP_EOL.

                            '</div>'.PHP_EOL.

                            '<div id="archived" class="tab-pane row-fluid fix-space">'.PHP_EOL.

                                '<button ng-hide="student" ng-click="unarchive()" class="btn btn-mini btn-inverse">
                                    Unarchive Item(s)
                                </button>'.PHP_EOL.

                                '<table class="well data-list">

                                    <thead>
                                        <tr>
                                            <th ng-hide="student">
                                                <input
                                                    ng-hide="student"
                                                    ng-change="selectAll(\'selectAllArchived\', \'archived\')"
                                                    ng-model="selectAllArchived"
                                                    type="checkbox">
                                            </th>
                                            <th>Student</th>
                                            <th>Patient</th>
                                            <th>Sub. Date</th>
                                        </tr>
                                    </thead>

                                    <tbody class="availListItems">

                                        <tr class="availItem supportListRow"
                                            ng-repeat=\'item in items | filter:archived | orderBy:"subId":true\'
                                        >
                                            <td ng-hide="student"><input ng-model="item.selected"  type="checkbox"></td>
                                            <td><a ng-click=\'changeRoute(item.subId, item.subtype, $event)\'>{{item.student}}</a></td>
                                            <td><a ng-click=\'changeRoute(item.subId, item.subtype, $event)\'>{{item.pt}}</a></td>
                                            <td><a ng-click=\'changeRoute(item.subId, item.subtype, $event)\'>{{item.subDate}}</a></td>
                                        </tr>
                                    </tbody>
                                </table>'.PHP_EOL.

                            '</div>'.PHP_EOL.

                        '</form>'.PHP_EOL;

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