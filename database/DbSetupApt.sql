DROP TABLE IF EXISTS `apt`;

CREATE TABLE `apt` (
    `aptDetailsAptId` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ptInfoUniqueId` INT UNSIGNED NOT NULL, 
    `ptInfoNewPt` VARCHAR( 255 ) NOT NULL, 
    `ptInfoCurrentIns` VARCHAR( 255 ) NOT NULL, 
    `ptInfoAptNum` VARCHAR( 255 ) NOT NULL, 
    `clinicServiceLocation` VARCHAR( 255 ) NOT NULL, 
    `clinicMd` VARCHAR( 255 ) NOT NULL, 
    `aptDetailsStartDate` VARCHAR( 255 ) NOT NULL, 
    `aptDetailsStartTime` VARCHAR( 255 ) NOT NULL, 
    `aptDetailsLength` VARCHAR( 255 ) NOT NULL, 
    `aptDetailsAptType` VARCHAR( 255 ) NOT NULL, 
    `aptDetailsReason` VARCHAR( 255 ) NOT NULL, 
    `statusPtStatus` VARCHAR( 255 ) NOT NULL, 
    `statusCheckInDate` VARCHAR( 255 ) NOT NULL, 
    `statusCheckInTime` VARCHAR( 255 ) NOT NULL, 
    `statusCheckOutDate` VARCHAR( 255 ) NOT NULL, 
    `statusCheckOutTime` VARCHAR( 255 ) NOT NULL, 
    `statusStatusNotes` VARCHAR( 255 ) NOT NULL, 
    `notesAuthorization` VARCHAR( 255 ) NOT NULL, 
    `notesReminderNotes` VARCHAR( 255 ) NOT NULL, 
    `notesEquipment` VARCHAR( 255 ) NOT NULL, 
    `notesFacility` VARCHAR( 255 ) NOT NULL, 
    `notesStaff` VARCHAR( 255 ) NOT NULL
);