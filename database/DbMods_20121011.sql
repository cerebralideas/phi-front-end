ALTER TABLE  `apt` CHANGE  `clinicServiceLocation`  `aptDetailsServiceLocation` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE  `apt_working` CHANGE  `clinicServiceLocation`  `aptDetailsServiceLocation` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE  `apt_submission` CHANGE  `clinicServiceLocation`  `aptDetailsServiceLocation` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE  `apt` CHANGE  `clinicMd`  `mdClinic` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE  `apt_working` CHANGE  `clinicMd`  `mdClinic` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE  `apt_submission` CHANGE  `clinicMd`  `mdClinic` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE  `apt` ADD  `mdReferring` VARCHAR( 255 ) NULL AFTER  `mdClinic` ,
ADD  `mdReferringId` VARCHAR( 255 ) NULL AFTER  `mdReferring`;
ALTER TABLE  `apt_working` ADD  `mdReferring` VARCHAR( 255 ) NULL AFTER  `mdClinic` ,
ADD  `mdReferringId` VARCHAR( 255 ) NULL AFTER  `mdReferring`;
ALTER TABLE  `apt_submission` ADD  `mdReferring` VARCHAR( 255 ) NULL AFTER  `mdClinic` ,
ADD  `mdReferringId` VARCHAR( 255 ) NULL AFTER  `mdReferring`;
ALTER TABLE  `apt` ADD  `ptInfoCondRelatedTo` VARCHAR( 255 ) NULL AFTER  `ptInfoAptNum`;
ALTER TABLE  `apt_working` ADD  `ptInfoCondRelatedTo` VARCHAR( 255 ) NULL AFTER  `ptInfoAptNum`;
ALTER TABLE  `apt_submission` ADD  `ptInfoCondRelatedTo` VARCHAR( 255 ) NULL AFTER  `ptInfoAptNum`;
ALTER TABLE  `adm` CHANGE  `mdPrimary`  `mdReferring` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE  `adm_working` CHANGE  `mdPrimary`  `mdReferring` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE  `adm_submission` CHANGE  `mdPrimary`  `mdReferring` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE  `adm` ADD  `mdReferringId` VARCHAR( 255 ) NULL AFTER  `mdReferring`;
ALTER TABLE  `adm_working` ADD  `mdReferringId` VARCHAR( 255 ) NULL AFTER  `mdReferring`;
ALTER TABLE  `adm_submission` ADD  `mdReferringId` VARCHAR( 255 ) NULL AFTER  `mdReferring`;