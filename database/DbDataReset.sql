TRUNCATE TABLE `adm`;
TRUNCATE TABLE `adm_submission`;
TRUNCATE TABLE `adm_working`;
TRUNCATE TABLE `apt`;
TRUNCATE TABLE `apt_submission`;
TRUNCATE TABLE `apt_working`;
TRUNCATE TABLE `pt`;
TRUNCATE TABLE `pt_submission`;
TRUNCATE TABLE `pt_working`;
TRUNCATE TABLE `submission`;
TRUNCATE TABLE `submission_comment`;
TRUNCATE TABLE `submission_history`;
UPDATE seq
SET `value` = 1;