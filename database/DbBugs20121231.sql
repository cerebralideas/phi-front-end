ALTER TABLE  `opSb` ADD  `opSbDetailsPriorAuthNumber` VARCHAR( 255 ) NULL AFTER  `opSbDetailsDateOfInitial`;
ALTER TABLE  `opSb_working` ADD  `opSbDetailsPriorAuthNumber` VARCHAR( 255 ) NULL AFTER  `opSbDetailsDateOfInitial`;
ALTER TABLE  `opSb_submission` ADD  `opSbDetailsPriorAuthNumber` VARCHAR( 255 ) NULL AFTER  `opSbDetailsDateOfInitial`;

ALTER TABLE  `apt` ADD  `ptInfoAutoAccState` VARCHAR( 255 ) NULL AFTER  `ptInfoCondRelatedTo`;
ALTER TABLE  `apt_working` ADD  `ptInfoAutoAccState` VARCHAR( 255 ) NULL AFTER  `ptInfoCondRelatedTo`;
ALTER TABLE  `apt_submission` ADD  `ptInfoAutoAccState` VARCHAR( 255 ) NULL AFTER  `ptInfoCondRelatedTo`;