<?php

    class Zend_View_Helper_StatusUpdates {

        public $view;

        function setView($view) {

            $this->view = $view;
        }

        function statusUpdates() {

            $string =
                    '<div id="statusUpdatesModal" class="modal hide fade">

                        <div class="modal-header">

                            <a data-dismiss="modal" class="close">&#x2612;</a>
                            <h2>Status Updates</h2>
                        </div>

                        <div class="modal-body"
                                ng-include="\'/docs/html/status-updates.html\'">
                        </div>

                    </div>'.PHP_EOL;

            return $string;
        }
    }