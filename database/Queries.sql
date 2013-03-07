select
    `pt`.`ptUniqueId` AS `itemId`, 
    `pt`.`createdBy` AS `itemAuthor`, 
    CONCAT(`pt`.`ptFirstName`, ' ', `pt`.`ptLastname`) AS `pt`, 
    DATE_FORMAT(NOW(), '%m/%d/%Y') AS `subDate`
from `pt`
