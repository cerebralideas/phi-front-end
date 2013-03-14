/*
INSERT INTO `seq`(`service`, `value`)
VALUES('accItem', 1);
*/
ALTER TABLE  `opCl` ADD  `opClDetailsTotalCharges` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `opClDetailsOrigRefNum`;

ALTER TABLE  `opCl_working` ADD  `opClDetailsTotalCharges` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `opClDetailsOrigRefNum`;

ALTER TABLE  `opCl_submission` ADD  `opClDetailsTotalCharges` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `opClDetailsOrigRefNum`;

ALTER TABLE  `opCl` ADD  `opClDetailsClaimNum` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `opClDetailsTotalCharges`;

ALTER TABLE  `opCl_working` ADD  `opClDetailsClaimNum` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `opClDetailsTotalCharges`;

ALTER TABLE  `opCl_submission` ADD  `opClDetailsClaimNum` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `opClDetailsTotalCharges`;

DROP TABLE IF EXISTS accItem;
CREATE TABLE accItem
(
    `accItemId` INT UNSIGNED NOT NULL,
    `uniqueId` INT UNSIGNED,
	`opClId` INT UNSIGNED,
    `postDate` VARCHAR( 255 ) NOT NULL, 
    `postType` VARCHAR( 255 ) NOT NULL, 
    `claimNum` VARCHAR( 255 ) NOT NULL, 
    `payor` VARCHAR( 255 ) NOT NULL, 
    `debit` VARCHAR( 255 ) NOT NULL, 
    `adjustment` VARCHAR( 255 ) NOT NULL, 
    `credit` VARCHAR( 255 ) NOT NULL, 
    `paymentType` VARCHAR( 255 ) NOT NULL, 
    `adjustmentType` VARCHAR( 255 ) NOT NULL, 
    `refundType` VARCHAR( 255 ) NOT NULL, 
    `referenceNumber` VARCHAR( 255 ) NOT NULL, 
    `totalProcedures` VARCHAR( 255 ) NOT NULL, 
    `postComment` VARCHAR( 255 ) NOT NULL, 
    `accItemBalance` VARCHAR( 255 ) NOT NULL,
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY(`accItemId`)
);
DROP TABLE IF EXISTS accItem_working;
CREATE TABLE accItem_working
(
    `accItemWorkingId` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `accItemId` INT UNSIGNED NOT NULL,
    `uniqueId` INT UNSIGNED,
	`opClId` INT UNSIGNED,
    `postDate` VARCHAR( 255 ) NOT NULL, 
    `postType` VARCHAR( 255 ) NOT NULL, 
    `claimNum` VARCHAR( 255 ) NOT NULL, 
    `payor` VARCHAR( 255 ) NOT NULL, 
    `debit` VARCHAR( 255 ) NOT NULL, 
    `adjustment` VARCHAR( 255 ) NOT NULL, 
    `credit` VARCHAR( 255 ) NOT NULL, 
    `paymentType` VARCHAR( 255 ) NOT NULL, 
    `adjustmentType` VARCHAR( 255 ) NOT NULL, 
    `refundType` VARCHAR( 255 ) NOT NULL, 
    `referenceNumber` VARCHAR( 255 ) NOT NULL, 
    `totalProcedures` VARCHAR( 255 ) NOT NULL, 
    `postComment` VARCHAR( 255 ) NOT NULL, 
    `accItemBalance` VARCHAR( 255 ) NOT NULL,
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY(`accItemWorkingId`)
);
