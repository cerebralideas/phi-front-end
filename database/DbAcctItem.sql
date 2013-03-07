/*
INSERT INTO `seq`(`service`, `value`)
VALUES('accItem', 1)
GO
*/
DROP TABLE IF EXISTS accItem
GO
CREATE TABLE accItem
(
    `accItemAccItemId` INT UNSIGNED NOT NULL,
    `accItemPostDate` VARCHAR( 255 ) NOT NULL, 
    `accItemPostType` VARCHAR( 255 ) NOT NULL, 
    `accItemClaimNum` VARCHAR( 255 ) NOT NULL, 
    `accItemPayor` VARCHAR( 255 ) NOT NULL, 
    `accItemDebit` VARCHAR( 255 ) NOT NULL, 
    `accItemAdjustment` VARCHAR( 255 ) NOT NULL, 
    `accItemCredit` VARCHAR( 255 ) NOT NULL, 
    `accItemPaymentType` VARCHAR( 255 ) NOT NULL, 
    `accItemAdjustmentType` VARCHAR( 255 ) NOT NULL, 
    `accItemRefundType` VARCHAR( 255 ) NOT NULL, 
    `accItemReferenceNumber` VARCHAR( 255 ) NOT NULL, 
    `accItemTotalProcedures` VARCHAR( 255 ) NOT NULL, 
    `accItemPostComment` VARCHAR( 255 ) NOT NULL, 
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY(`accItemAccItemId`)
)
GO
DROP TABLE IF EXISTS accItem_working
GO
CREATE TABLE accItem_working
(
    `accItemWorkingId` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `accItemAccItemId` INT UNSIGNED NOT NULL,
    `accItemPostDate` VARCHAR( 255 ) NOT NULL, 
    `accItemPostType` VARCHAR( 255 ) NOT NULL, 
    `accItemClaimNum` VARCHAR( 255 ) NOT NULL, 
    `accItemPayor` VARCHAR( 255 ) NOT NULL, 
    `accItemDebit` VARCHAR( 255 ) NOT NULL, 
    `accItemAdjustment` VARCHAR( 255 ) NOT NULL, 
    `accItemCredit` VARCHAR( 255 ) NOT NULL, 
    `accItemPaymentType` VARCHAR( 255 ) NOT NULL, 
    `accItemAdjustmentType` VARCHAR( 255 ) NOT NULL, 
    `accItemRefundType` VARCHAR( 255 ) NOT NULL, 
    `accItemReferenceNumber` VARCHAR( 255 ) NOT NULL, 
    `accItemTotalProcedures` VARCHAR( 255 ) NOT NULL, 
    `accItemPostComment` VARCHAR( 255 ) NOT NULL, 
    `createdBy` int(10) unsigned NULL,
    `createdDate` datetime NULL,
    `modifiedBy` int(10) unsigned NULL,
    `modifiedDate` datetime NULL,
    PRIMARY KEY(`accItemWorkingId`)
)
GO