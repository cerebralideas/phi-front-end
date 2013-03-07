DROP TABLE IF EXISTS `submission_comment`;
CREATE TABLE `submission_comment` (
  `submissionCommentId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `submissionId` int(10) unsigned NOT NULL,
  `comment` text NOT NULL,
  `createdBy` int(10) unsigned NOT NULL,
  `createdDate` datetime NOT NULL,
  `modifiedBy` int(10) unsigned NOT NULL,
  `modifiedDate` datetime NOT NULL,
  PRIMARY KEY (`submissionCommentId`)
);
DROP TABLE IF EXISTS `submission_history`;
CREATE TABLE `submission_history` (
  `submissionHistoryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `submissionId` int(10) unsigned NOT NULL,
  `submissionStatus` varchar(20) NOT NULL,
  `createdBy` int(10) unsigned NOT NULL,
  `createdDate` datetime NOT NULL,
  `modifiedBy` int(10) unsigned NOT NULL,
  `modifiedDate` datetime NOT NULL,
  PRIMARY KEY (`submissionHistoryId`)
);