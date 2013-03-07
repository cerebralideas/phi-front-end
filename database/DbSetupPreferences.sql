DROP TABLE IF EXISTS `preferences`;
CREATE TABLE `preferences`
(
    `userId` INT UNSIGNED NOT NULL,
    `masterData` INT UNSIGNED NOT NULL,
    PRIMARY KEY(`userId`)
);