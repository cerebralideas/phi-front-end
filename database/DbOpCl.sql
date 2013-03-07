DROP TABLE IF EXISTS opCl;
CREATE TABLE opCl
(
    opClDetailsOpClId int unsigned not null,
    opClDetailsOpSbId int unsigned not null,
    opClDetailsBillTo varchar(255) null,
    opClDetailsRefNum varchar(255) null,
    opClDetailsResubCode varchar(255) null,
    opClDetailsOrigRefNum varchar(255) null,
    createdBy int unsigned not null,
    createdDate datetime not null,
    modifiedBy int unsigned not null,
    modifiedDate datetime not null,
    PRIMARY KEY(opClDetailsOpClId)
);
DROP TABLE IF EXISTS opCl_working;
CREATE TABLE opCl_working
(
    opClWorkingId int unsigned auto_increment not null,
    opClDetailsOpClId int unsigned not null,
    opClDetailsOpSbId int unsigned not null,
    opClDetailsBillTo varchar(255) null,
    opClDetailsRefNum varchar(255) null,
    opClDetailsResubCode varchar(255) null,
    opClDetailsOrigRefNum varchar(255) null,
    createdBy int unsigned not null,
    createdDate datetime not null,
    modifiedBy int unsigned not null,
    modifiedDate datetime not null,
    PRIMARY KEY(opClWorkingId)
);




DROP TABLE IF EXISTS opCl_submission;
CREATE TABLE opCl_submission
(
    submissionId int unsigned not null,
    opClDetailsOpClId int unsigned not null,
    opClDetailsOpSbId int unsigned not null,
    opClDetailsBillTo varchar(255) null,
    opClDetailsRefNum varchar(255) null,
    opClDetailsResubCode varchar(255) null,
    opClDetailsOrigRefNum varchar(255) null,
    createdBy int unsigned not null,
    createdDate datetime not null,
    modifiedBy int unsigned not null,
    modifiedDate datetime not null,
    PRIMARY KEY(submissionId)
);
DROP TABLE IF EXISTS opClDiagCodes;
CREATE TABLE `opClDiagCodes`  ( 
	`opClDiagCodeId`   	int(10) UNSIGNED AUTO_INCREMENT NOT NULL,
	`opClDetailsOpClId`	int(10) UNSIGNED NOT NULL,
    `order`             varchar(255) NULL,
    `num`               varchar(255) NULL,
	`name`             	varchar(255) NULL,
	`description`      	varchar(3000) NULL,
	`createdBy`        	int(10) UNSIGNED NULL,
	`createdDate`      	datetime NULL,
	`modifiedBy`       	int(10) UNSIGNED NULL,
	`modifiedDate`     	datetime NULL,
	PRIMARY KEY(`opClDiagCodeId`)
);
DROP TABLE IF EXISTS opClDiagCodes_working;
CREATE TABLE `opClDiagCodes_working`  ( 
	`opClDiagCodeId`   	int(10) UNSIGNED AUTO_INCREMENT NOT NULL,
	`opClDetailsOpClId`	int(10) UNSIGNED NOT NULL,
    `order`             varchar(255) NULL,
    `num`               varchar(255) NULL,
	`name`             	varchar(255) NULL,
	`description`      	varchar(3000) NULL,
	`createdBy`        	int(10) UNSIGNED NULL,
	`createdDate`      	datetime NULL,
	`modifiedBy`       	int(10) UNSIGNED NULL,
	`modifiedDate`     	datetime NULL,
	PRIMARY KEY(`opClDiagCodeId`)
);
DROP TABLE IF EXISTS opClDiagCodes_submission;
CREATE TABLE `opClDiagCodes_submission`  ( 
	`opClDiagCodesSubmissionId`	int(10) UNSIGNED AUTO_INCREMENT NOT NULL,
	`submissionId`             	int(10) UNSIGNED NULL,
	`opClDiagCodeId`           	int(10) UNSIGNED NOT NULL,
	`opClDetailsOpClId`        	int(10) UNSIGNED NOT NULL,
    `order`             varchar(255) NULL,
    `num`               varchar(255) NULL,
	`name`                     	varchar(255) NULL,
	`description`              	varchar(3000) NULL,
	`createdBy`                	int(10) UNSIGNED NULL,
	`createdDate`              	datetime NULL,
	`modifiedBy`               	int(10) UNSIGNED NULL,
	`modifiedDate`             	datetime NULL,
	PRIMARY KEY(`opClDiagCodesSubmissionId`)
);
DROP TABLE IF EXISTS opClProcCodes;
CREATE TABLE `opClProcCodes`  ( 
	`opClProcCodeId`   	int(10) UNSIGNED AUTO_INCREMENT NOT NULL,
	`opClDetailsOpClId`	int(10) UNSIGNED NOT NULL,
	`num`              	int(10) UNSIGNED NOT NULL,
    `name` varchar(255) null,
    `description` varchar(255) null,
    `modifier` varchar(255) null,
    `charge` varchar(255) null,
    `qty` varchar(255) null,
    `primaryIcd` varchar(255) null,
    `secondaryIcd` varchar(255) null,
    `tertiaryIcd` varchar(255) null,
    `quaternaryIcd` varchar(255) null,
	`createdBy`        	int(10) UNSIGNED NULL,
	`createdDate`      	datetime NULL,
	`modifiedBy`       	int(10) UNSIGNED NULL,
	`modifiedDate`     	datetime NULL,
	PRIMARY KEY(`opClProcCodeId`)
);
DROP TABLE IF EXISTS opClProcCodes_working;
CREATE TABLE `opClProcCodes_working`  ( 
	`opClProcCodeId`   	int(10) UNSIGNED AUTO_INCREMENT NOT NULL,
	`opClDetailsOpClId`	int(10) UNSIGNED NOT NULL,
	`num`              	int(10) UNSIGNED NOT NULL,
    `name` varchar(255) null,
    `description` varchar(255) null,
    `modifier` varchar(255) null,
    `charge` varchar(255) null,
    `qty` varchar(255) null,
    `primaryIcd` varchar(255) null,
    `secondaryIcd` varchar(255) null,
    `tertiaryIcd` varchar(255) null,
    `quaternaryIcd` varchar(255) null,
	`createdBy`        	int(10) UNSIGNED NULL,
	`createdDate`      	datetime NULL,
	`modifiedBy`       	int(10) UNSIGNED NULL,
	`modifiedDate`     	datetime NULL,
	PRIMARY KEY(`opClProcCodeId`)
);
DROP TABLE IF EXISTS opClProcCodes_submission;
CREATE TABLE `opClProcCodes_submission`  ( 
    `opClProcCodeIdSubmissionId`	int(10) UNSIGNED AUTO_INCREMENT NOT NULL,
	`submissionId`             	int(10) UNSIGNED NULL,
	`opClProcCodeId`   	int(10) UNSIGNED NOT NULL,
	`opClDetailsOpClId`	int(10) UNSIGNED NOT NULL,
	`num`              	int(10) UNSIGNED NOT NULL,
    `name` varchar(255) null,
    `description` varchar(255) null,
    `modifier` varchar(255) null,
    `charge` varchar(255) null,
    `qty` varchar(255) null,
    `primaryIcd` varchar(255) null,
    `secondaryIcd` varchar(255) null,
    `tertiaryIcd` varchar(255) null,
    `quaternaryIcd` varchar(255) null,
	`createdBy`        	int(10) UNSIGNED NULL,
	`createdDate`      	datetime NULL,
	`modifiedBy`       	int(10) UNSIGNED NULL,
	`modifiedDate`     	datetime NULL,
	PRIMARY KEY(`opClProcCodeIdSubmissionId`)
);

INSERT INTO `seq`(`service`, `value`) 
	VALUES('opCl', 1);
ALTER TABLE  `opSb` ADD  `opSbDetailsDateOfInitial` VARCHAR( 255 ) NULL AFTER  `opSbDetailsBusNotes`;
ALTER TABLE  `opSb_working` ADD  `opSbDetailsDateOfInitial` VARCHAR( 255 ) NULL AFTER  `opSbDetailsBusNotes`;
ALTER TABLE  `opSb_submission` ADD  `opSbDetailsDateOfInitial` VARCHAR( 255 ) NULL AFTER  `opSbDetailsBusNotes`;
