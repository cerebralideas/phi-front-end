<?php

    class Zend_View_Helper_UserControls
    {
        public $view;

        function setView($view)
        {
            $this->view = $view;
        }

        function UserControls()
        {
            $auth = Zend_Auth::getInstance();

            if ($auth->hasIdentity())
            {
                $storage = $auth->getStorage();

                $string =
                        '<nav class="ng-class:instrMode; userControls">'.PHP_EOL.
                            '<ul class="unstyled inline-list">'.PHP_EOL.
                                // Show for admins to toggle user mode
                                '<li ng-show="admin" class="dropdown">'.PHP_EOL.

                                    '<a class="dropdown-toggle" data-toggle="dropdown">'.PHP_EOL.
                                        '<i>Hello, {{userFirstName}} ({{userRole}})</i>'.PHP_EOL.
                                        '&nbsp;<span class="icon-card icon-large"></span>'.PHP_EOL.
                                    '</a>'.PHP_EOL.

                                    '<div class="dropdown-menu pull-right dropdown-medium">'.PHP_EOL.
                                        '<p>'.PHP_EOL.
                                            '<span class="icon-warning"></span>'.PHP_EOL.
                                            'Warning: Using the "Instructor Mode" will allow you to overwrite master data.'.PHP_EOL.
                                        '</p>'.PHP_EOL.

                                        '<label>'.PHP_EOL.
                                            '<input type="radio" ng-model="userMode" value="1" ng-change="toggleUserMode()">'.PHP_EOL.
                                            'Instructor Mode'.PHP_EOL.
                                        '</label>'.PHP_EOL.

                                        '<label>'.PHP_EOL.
                                            '<input type="radio" ng-model="userMode" value="0" ng-change="toggleUserMode()">'.PHP_EOL.
                                            'Student Mode'.PHP_EOL.
                                        '</label>'.PHP_EOL.
                                    '</div>'.PHP_EOL.
                                // Show for students and faculty for simple hello
                                '</li><li ng-hide="admin">'.PHP_EOL.

                                    '<span>'.PHP_EOL.
                                        'Hello, {{userFirstName}} ({{userRole}})'.PHP_EOL.
                                        '&nbsp;<span class="icon-card icon-large"></span>'.PHP_EOL.
                                    '</span>'.PHP_EOL.

                                '</li><li>'.PHP_EOL.
                                    '<a href="#statusUpdatesModal" data-toggle="modal">Status Updates</a>'.PHP_EOL.
                                '</li><li>'.PHP_EOL.
                                    '<a href="/auth/logout/">Logout</a>'.PHP_EOL.
                                '</li>'.PHP_EOL.
                            '</ul>'.PHP_EOL.
                        '</nav>'.PHP_EOL;
            }
            else
            {
                $string = '';
            }

            return $string;
        }
    }