ALTER TABLE  `pt` ADD  `ptMedRecNum` VARCHAR( 255 ) NOT NULL AFTER  `ptUniqueId`;
ALTER TABLE  `pt` ADD  `insPrimaryPlanType` VARCHAR( 255 ) NOT NULL AFTER  `insPrimaryComp`;
ALTER TABLE  `pt` ADD  `insPrimaryMemberId` VARCHAR( 255 ) NOT NULL AFTER  `insPrimaryPlanType`;
ALTER TABLE  `pt` ADD  `insPrimaryPlanDetails` VARCHAR( 255 ) NOT NULL AFTER  `insPrimaryMemberId`;
ALTER TABLE  `pt` ADD  `insSecondaryPlanType` VARCHAR( 255 ) NOT NULL AFTER  `insSecondaryComp`;
ALTER TABLE  `pt` ADD  `insSecondaryMemberId` VARCHAR( 255 ) NOT NULL AFTER  `insSecondaryPlanType`;
ALTER TABLE  `pt` ADD  `insSecondaryPlanDetails` VARCHAR( 255 ) NOT NULL AFTER  `insSecondaryMemberId`;
ALTER TABLE  `pt` ADD  `insTertiaryPlanType` VARCHAR( 255 ) NOT NULL AFTER  `insTertiaryComp`;
ALTER TABLE  `pt` ADD  `insTertiaryMemberId` VARCHAR( 255 ) NOT NULL AFTER  `insTertiaryPlanType`;
ALTER TABLE  `pt` ADD  `insTertiaryPlanDetails` VARCHAR( 255 ) NOT NULL AFTER  `insTertiaryMemberId`;

ALTER TABLE  `pt_working` ADD  `ptMedRecNum` VARCHAR( 255 ) NOT NULL AFTER  `ptUniqueId`;
ALTER TABLE  `pt_working` ADD  `insPrimaryPlanType` VARCHAR( 255 ) NOT NULL AFTER  `insPrimaryComp`;
ALTER TABLE  `pt_working` ADD  `insPrimaryMemberId` VARCHAR( 255 ) NOT NULL AFTER  `insPrimaryPlanType`;
ALTER TABLE  `pt_working` ADD  `insPrimaryPlanDetails` VARCHAR( 255 ) NOT NULL AFTER  `insPrimaryMemberId`;
ALTER TABLE  `pt_working` ADD  `insSecondaryPlanType` VARCHAR( 255 ) NOT NULL AFTER  `insSecondaryComp`;
ALTER TABLE  `pt_working` ADD  `insSecondaryMemberId` VARCHAR( 255 ) NOT NULL AFTER  `insSecondaryPlanType`;
ALTER TABLE  `pt_working` ADD  `insSecondaryPlanDetails` VARCHAR( 255 ) NOT NULL AFTER  `insSecondaryMemberId`;
ALTER TABLE  `pt_working` ADD  `insTertiaryPlanType` VARCHAR( 255 ) NOT NULL AFTER  `insTertiaryComp`;
ALTER TABLE  `pt_working` ADD  `insTertiaryMemberId` VARCHAR( 255 ) NOT NULL AFTER  `insTertiaryPlanType`;
ALTER TABLE  `pt_working` ADD  `insTertiaryPlanDetails` VARCHAR( 255 ) NOT NULL AFTER  `insTertiaryMemberId`;


ALTER TABLE  `pt_submission` ADD  `ptMedRecNum` VARCHAR( 255 ) NOT NULL AFTER  `ptUniqueId`;
ALTER TABLE  `pt_submission` ADD  `insPrimaryPlanType` VARCHAR( 255 ) NOT NULL AFTER  `insPrimaryComp`;
ALTER TABLE  `pt_submission` ADD  `insPrimaryMemberId` VARCHAR( 255 ) NOT NULL AFTER  `insPrimaryPlanType`;
ALTER TABLE  `pt_submission` ADD  `insPrimaryPlanDetails` VARCHAR( 255 ) NOT NULL AFTER  `insPrimaryMemberId`;
ALTER TABLE  `pt_submission` ADD  `insSecondaryPlanType` VARCHAR( 255 ) NOT NULL AFTER  `insSecondaryComp`;
ALTER TABLE  `pt_submission` ADD  `insSecondaryMemberId` VARCHAR( 255 ) NOT NULL AFTER  `insSecondaryPlanType`;
ALTER TABLE  `pt_submission` ADD  `insSecondaryPlanDetails` VARCHAR( 255 ) NOT NULL AFTER  `insSecondaryMemberId`;
ALTER TABLE  `pt_submission` ADD  `insTertiaryPlanType` VARCHAR( 255 ) NOT NULL AFTER  `insTertiaryComp`;
ALTER TABLE  `pt_submission` ADD  `insTertiaryMemberId` VARCHAR( 255 ) NOT NULL AFTER  `insTertiaryPlanType`;
ALTER TABLE  `pt_submission` ADD  `insTertiaryPlanDetails` VARCHAR( 255 ) NOT NULL AFTER  `insTertiaryMemberId`;