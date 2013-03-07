ALTER TABLE  `pt` ADD  `insPrimaryTypeOfCoverage` VARCHAR( 255 ) NULL AFTER  `insPrimaryNotSelfEmployerPhone`;
ALTER TABLE  `pt_working` ADD  `insPrimaryTypeOfCoverage` VARCHAR( 255 ) NULL AFTER  `insPrimaryNotSelfEmployerPhone`;
ALTER TABLE  `pt_submission` ADD  `insPrimaryTypeOfCoverage` VARCHAR( 255 ) NULL AFTER  `insPrimaryNotSelfEmployerPhone`;

ALTER TABLE  `pt` ADD  `insSecondaryTypeOfCoverage` VARCHAR( 255 ) NULL AFTER  `insSecondaryNotSelfEmployerPhone`;
ALTER TABLE  `pt_working` ADD  `insSecondaryTypeOfCoverage` VARCHAR( 255 ) NULL AFTER  `insSecondaryNotSelfEmployerPhone`;
ALTER TABLE  `pt_submission` ADD  `insSecondaryTypeOfCoverage` VARCHAR( 255 ) NULL AFTER  `insSecondaryNotSelfEmployerPhone`;

ALTER TABLE  `pt` ADD  `insTertiaryTypeOfCoverage` VARCHAR( 255 ) NULL AFTER  `insTertiaryNotSelfEmployerPhone`;
ALTER TABLE  `pt_working` ADD  `insTertiaryTypeOfCoverage` VARCHAR( 255 ) NULL AFTER  `insTertiaryNotSelfEmployerPhone`;
ALTER TABLE  `pt_submission` ADD  `insTertiaryTypeOfCoverage` VARCHAR( 255 ) NULL AFTER  `insTertiaryNotSelfEmployerPhone`;
