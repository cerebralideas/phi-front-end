/*
INSERT INTO `seq`(`service`, `value`) 
	VALUES('opSb', 1);
*/
DROP TABLE IF EXISTS `opSb`;
CREATE TABLE `opSb`
(
    `opSbDetailsOpSbId` INT UNSIGNED NOT NULL,
    `opSbDetailsAptId` INT UNSIGNED NULL,
    `opSbDetailsMemo` VARCHAR(255) NULL,
    `opSbDetailsRefNum` VARCHAR(255) NULL,
    `opSbDetailsMedNotes` VARCHAR(255) NULL,
    `opSbDetailsAuthNotes` VARCHAR(255) NULL,
    `opSbDetailsBusNotes` VARCHAR(255) NULL,
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY (`opSbDetailsOpSbId`)
);
DROP TABLE IF EXISTS `opSb_working`;
CREATE TABLE `opSb_working`
(
    `opSbWorkingId` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `opSbDetailsOpSbId` INT UNSIGNED NOT NULL,
    `opSbDetailsAptId` INT UNSIGNED NULL,
    `opSbDetailsMemo` VARCHAR(255) NULL,
    `opSbDetailsRefNum` VARCHAR(255) NULL,
    `opSbDetailsMedNotes` VARCHAR(255) NULL,
    `opSbDetailsAuthNotes` VARCHAR(255) NULL,
    `opSbDetailsBusNotes` VARCHAR(255) NULL,
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY (`opSbWorkingId`)
);
DROP TABLE IF EXISTS `opSb_submission`;
CREATE TABLE `opSb_submission`
(
    `submissionId` int(10) unsigned NULL,
    `opSbDetailsOpSbId` INT UNSIGNED NOT NULL,
    `opSbDetailsAptId` INT UNSIGNED NULL,
    `opSbDetailsMemo` VARCHAR(255) NULL,
    `opSbDetailsRefNum` VARCHAR(255) NULL,
    `opSbDetailsMedNotes` VARCHAR(255) NULL,
    `opSbDetailsAuthNotes` VARCHAR(255) NULL,
    `opSbDetailsBusNotes` VARCHAR(255) NULL,
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY (`submissionId`)
);
DROP TABLE IF EXISTS `opSbDiagCodes`;
CREATE TABLE `opSbDiagCodes`
(
    `opSbDiagCodeId` int(10) unsigned not null AUTO_INCREMENT,
    `opSbDetailsOpSbId` int(10) unsigned not null,
    `order` int(10) unsigned not null,
    `num` int(10) unsigned not null,
    `name` varchar(255) null,
    `description` varchar(3000) null,
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY (`opSbDiagCodeId`)
);
DROP TABLE IF EXISTS `opSbDiagCodes_working`;
CREATE TABLE `opSbDiagCodes_working`
(
    `opSbDiagCodeId` int(10) unsigned not null AUTO_INCREMENT,
    `opSbDetailsOpSbId` int(10) unsigned not null,
    `order` int(10) unsigned not null,
    `num` int(10) unsigned not null,
    `name` varchar(255) null,
    `description` varchar(3000) null,
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY (`opSbDiagCodeId`)
);
DROP TABLE IF EXISTS `opSbDiagCodes_submission`;
CREATE TABLE `opSbDiagCodes_submission`
(
	`opSbDiagCodesSubmissionId` int(10) unsigned not null AUTO_INCREMENT,
    `submissionId` int(10) unsigned NULL,
    `opSbDiagCodeId` int(10) unsigned not null,
    `opSbDetailsOpSbId` int(10) unsigned not null,
    `order` int(10) unsigned not null,
    `num` int(10) unsigned not null,
    `name` varchar(255) null,
    `description` varchar(3000) null,
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY (`opSbDiagCodesSubmissionId`)
);
DROP TABLE IF EXISTS `opSbProcCodes`;
CREATE TABLE `opSbProcCodes`
(
    `opSbProcCodeId` int(10) unsigned not null AUTO_INCREMENT,
    `opSbDetailsOpSbId` int(10) unsigned not null,
    `num` int(10) unsigned not null,
    `name` varchar(255) null,
    `description` varchar(3000) null,
    `modifier` varchar(255) null,
    `qty` varchar(255) null,
    `charge` double(11,4) null,
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY (`opSbProcCodeId`)
);
DROP TABLE IF EXISTS `opSbProcCodes_working`;
CREATE TABLE `opSbProcCodes_working`
(
    `opSbProcCodeId` int(10) unsigned not null AUTO_INCREMENT,
    `opSbDetailsOpSbId` int(10) unsigned not null,
    `num` int(10) unsigned not null,
    `name` varchar(255) null,
    `description` varchar(3000) null,
    `modifier` varchar(255) null,
    `qty` varchar(255) null,
    `charge` double(11,4) null,
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY (`opSbProcCodeId`)
);
DROP TABLE IF EXISTS `opSbProcCodes_submission`;
CREATE TABLE `opSbProcCodes_submission`
(
	`opSbProcCodesSubmissionId` int(10) unsigned not null AUTO_INCREMENT,
    `submissionId` int(10) unsigned NULL,
    `opSbProcCodeId` int(10) unsigned not null,
    `opSbDetailsOpSbId` int(10) unsigned not null,
    `num` int(10) unsigned not null,
    `name` varchar(255) null,
    `description` varchar(3000) null,
    `modifier` varchar(255) null,
    `qty` varchar(255) null,
    `charge` double(11,4) null,
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY (`opSbProcCodesSubmissionId`)
);
/*
ALTER TABLE  `procCodes` ADD  `charge` DOUBLE( 11, 4 ) NOT NULL DEFAULT  '0';
*/
