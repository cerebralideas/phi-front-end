
INSERT INTO `opSb`(`sbDetailsSbId`, `sbDetailsAptId`, `sbDetailsMemo`, `sbDetailsRefNum`, `sbDetailsMedNotes`, `sbDetailsBusNotes`, `createdBy`, `createdDate`, `modifiedBy`, `modifiedDate`) 
	VALUES(1, 1, 'This is my memo.', 'My reference num.', 'Med Notes go here.', 'Business Notes', 1, '2012-11-7 13:42:23', 1, '2012-11-7 13:42:23')
GO



select * from opSb



    INSERT INTO `opSbDiagCodes`(`sbDetailsSbId`, `num`, `name`, `description`, `createdBy`, `createdDate`, `modifiedBy`, `modifiedDate`) 
        VALUES(1, 1, '909', 'Name', 1, '2012-11-7 14:15:46', 1, '2012-11-7 14:15:46')
    GO



INSERT INTO `opSbProcCodes`(`sbDetailsSbId`, `num`, `name`, `modifier`, `qty`) 
	VALUES(1, 45, 'Name', 'Modifier', 'qty')
GO


select count(*) from `diagCodes`
go
select count(*) from `procCodes`


update seq
set value = 1
where `service` = 'opSb'
go
truncate table opSb
go
truncate table `opSbDiagCodes`
go
truncate table `opSbProcCodes`
go


    select * from seq
    go
    select * from opSb
    go
    select * from `opSbDiagCodes`
    go
    select * from `opSbProcCodes`
    go


    select * from seq
    go
    select * from opSb_working
    go
    select * from `opSbDiagCodes_working`
    go
    select * from `opSbProcCodes_working`
    go


update `opSb`
set `sbDetailsAptId` = 1
go
update `opSb_working`
set `sbDetailsAptId` = 1


SELECT `sbDetailsSbId`, `sbDetailsAptId`, `sbDetailsMemo`, `sbDetailsRefNum`, `sbDetailsMedNotes`, `sbDetailsAuthNotes`, `sbDetailsBusNotes`, `createdBy`, `createdDate`, `modifiedBy`, `modifiedDate` 
FROM `opSb`
WHERE
    `sbDetailsSbId` NOT IN
    (
            SELECT `sbDetailsSbId` FROM `opSb_working`
            WHERE `createdBy` = 1
    ) AND `sbDetailsAptId` = 1
UNION
SELECT `sbDetailsSbId`, `sbDetailsAptId`, `sbDetailsMemo`, `sbDetailsRefNum`, `sbDetailsMedNotes`, `sbDetailsAuthNotes`, `sbDetailsBusNotes`, `createdBy`, `createdDate`, `modifiedBy`, `modifiedDate` 
	FROM `opSb_working`
WHERE 
    `createdBy` = 1 AND
    `sbDetailsAptId` = 1 
GO


