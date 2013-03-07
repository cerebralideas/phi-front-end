/*
truncate table `adm`
go
truncate table `adm_working`
go
truncate table `adm_submission`
go
update seq
set `value` = 1
where `service` = 'adm'
go
*/

select * from pt


// patientId = 9

select * from adm
go
select * from adm_working
where ptInfoUniqueId = 9 AND createdBy = 1
go
select * from adm_submission
go
select * from seq
where `service` = 'adm'



select * from neehr.users
where id = 1419


select * from `submission`
where createdBy = 1 or submissionTo = 1

where `submissionId` = 49
Go
select * from `submission_comment`
where `submissionId` = 49
go