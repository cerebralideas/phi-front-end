<?php

    class Zend_View_Helper_SaveStatus {

        public $view;

        function setView($view) {

            $this->view = $view;
        }

        function saveStatus() {

        $string =
                '<div id="saveStatusModal" class="modal hide fade in">'.PHP_EOL.

                    '<div ng-show="isSaving" class="modal-header all-round">'.PHP_EOL.
                        '<a data-dismiss="modal" class="close">&#x2612;</a>'.PHP_EOL.
                        '<h2>Saving Data …</h2>'.PHP_EOL.
                    '</div>'.PHP_EOL.

                    '<div ng-show="isSaved" class="modal-header all-round">'.PHP_EOL.
                        '<a data-dismiss="modal" class="close">&#x2612;</a>'.PHP_EOL.
                        '<h2>Data Saved</h2>'.PHP_EOL.
                    '</div>'.PHP_EOL.
                '</div>'.PHP_EOL;

        return $string;
    }
}