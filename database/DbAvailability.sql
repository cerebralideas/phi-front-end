DROP TABLE IF EXISTS `location`;
CREATE TABLE `location`
(
    `locationId` INT UNSIGNED NOT NULL,
    `locationDay` VARCHAR(3) NOT NULL,
    `locationName` VARCHAR(255) NOT NULL,
    `locationStartTime` VARCHAR(255) NOT NULL,
    `locationEndTime` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`locationId`, `locationDay`)
);
INSERT INTO `location`(`locationId`, `locationDay`, `locationName`, `locationStartTime`, `locationEndTime`)
VALUES(0, 'Mon', 'General Medical Clinic', '0900', '1600');
INSERT INTO `location`(`locationId`, `locationDay`, `locationName`, `locationStartTime`, `locationEndTime`)
VALUES(0, 'Tue', 'General Medical Clinic', '0900', '1600');
INSERT INTO `location`(`locationId`, `locationDay`, `locationName`, `locationStartTime`, `locationEndTime`)
VALUES(0, 'Wed', 'General Medical Clinic', '0900', '1600');
INSERT INTO `location`(`locationId`, `locationDay`, `locationName`, `locationStartTime`, `locationEndTime`)
VALUES(0, 'Thu', 'General Medical Clinic', '0900', '1600');
INSERT INTO `location`(`locationId`, `locationDay`, `locationName`, `locationStartTime`, `locationEndTime`)
VALUES(0, 'Fri', 'General Medical Clinic', '0900', '1600');
INSERT INTO `location`(`locationId`, `locationDay`, `locationName`, `locationStartTime`, `locationEndTime`)
VALUES(1, 'Mon', 'Pediatric Clinic', '0800', '1700');
INSERT INTO `location`(`locationId`, `locationDay`, `locationName`, `locationStartTime`, `locationEndTime`)
VALUES(1, 'Tue', 'Pediatric Clinic', '0900', '1700');
INSERT INTO `location`(`locationId`, `locationDay`, `locationName`, `locationStartTime`, `locationEndTime`)
VALUES(1, 'Wed', 'Pediatric Clinic', '0800', '1700');
INSERT INTO `location`(`locationId`, `locationDay`, `locationName`, `locationStartTime`, `locationEndTime`)
VALUES(1, 'Thu', 'Pediatric Clinic', '0900', '1700');
INSERT INTO `location`(`locationId`, `locationDay`, `locationName`, `locationStartTime`, `locationEndTime`)
VALUES(1, 'Fri', 'Pediatric Clinic', '0800', '1700');
INSERT INTO `location`(`locationId`, `locationDay`, `locationName`, `locationStartTime`, `locationEndTime`)
VALUES(1, 'Sat', 'Pediatric Clinic', '0900', '1300');

DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff`
(
    `staffId` INT UNSIGNED NOT NULL,
    `staffDay` VARCHAR(255) NOT NULL,
    `staffName` VARCHAR(255) NOT NULL,
    `staffStartTime` VARCHAR(255) NOT NULL,
    `staffEndTime` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`staffId`, `staffDay`)
);
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(0, 'Mon', 'Dr. One', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(0, 'Tue', 'Dr. One', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(0, 'Wed', 'Dr. One', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(0, 'Thu', 'Dr. One', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(0, 'Fri', 'Dr. One', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(1, 'Mon', 'Dr. Two', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(1, 'Tue', 'Dr. Two', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(1, 'Wed', 'Dr. Two', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(1, 'Thu', 'Dr. Two', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(1, 'Fri', 'Dr. Two', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(2, 'Mon', 'NP One', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(2, 'Tue', 'NP One', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(2, 'Wed', 'NP One', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(2, 'Thu', 'NP One', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(2, 'Fri', 'NP One', '0800', '1700');
INSERT INTO `staff`(`staffId`, `staffDay`, `staffName`, `staffStartTime`, `staffEndTime`)
VALUES(2, 'Sat', 'NP One', '0900', '1300');

DROP TABLE IF EXISTS `staffBusy`;
CREATE TABLE `staffBusy`
(
    `staffBusyId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `staffId` INT UNSIGNED NOT NULL,
    `staffName` VARCHAR(255) NOT NULL,
    `busyDay` VARCHAR(3) NOT NULL,
    `busyStartTime` VARCHAR(255) NOT NULL,
    `busyEndTime` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`staffBusyId`)
);
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Mon', '0800', '1000');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Mon', '1100', '1400');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Mon', '1500', '1700');

INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(1, 'Dr. Two', 'Mon', '0900', '1200');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(1, 'Dr. Two', 'Mon', '1400', '1700');

INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(2, 'NP One', 'Mon', '0800', '1200');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(2, 'NP One', 'Mon', '1400', '1700');

INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Tue', '0930', '1000');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Tue', '1130', '1400');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Tue', '1515', '1700');

INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(1, 'Dr. Two', 'Tue', '0830', '1245');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(1, 'Dr. Two', 'Tue', '1400', '1700');

INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(2, 'NP One', 'Tue', '0800', '1200');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(2, 'NP One', 'Tue', '1430', '1700');


INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Wed', '0815', '1015');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Wed', '1100', '1430');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Wed', '1530', '1700');

INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(1, 'Dr. Two', 'Wed', '0900', '1245');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(1, 'Dr. Two', 'Wed', '1300', '1700');

INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(2, 'NP One', 'Wed', '0800', '1200');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(2, 'NP One', 'Wed', '1400', '1700');


INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Thu', '0800', '1000');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Thu', '1100', '1600');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Thu', '1630', '1645');

INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(1, 'Dr. Two', 'Thu', '0900', '1000');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(1, 'Dr. Two', 'Thu', '1200', '1700');

INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(2, 'NP One', 'Thu', '0845', '1245');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(2, 'NP One', 'Thu', '1400', '1700');


INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Fri', '0830', '1045');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Fri', '1145', '1345');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(0, 'Dr. One', 'Fri', '1400', '1600');

INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(1, 'Dr. Two', 'Fri', '0830', '1130');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(1, 'Dr. Two', 'Fri', '1230', '1430');

INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(2, 'NP One', 'Fri', '0830', '1115');
INSERT INTO `staffBusy`(`staffId`, `staffName`, `busyDay`, `busyStartTime`, `busyEndTime`)
VALUES(2, 'NP One', 'Fri', '1215', '1515');