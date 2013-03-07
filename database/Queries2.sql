TRUNCATE TABLE `pt`
GO
TRUNCATE TABLE `pt_working`
GO
TRUNCATE TABLE `pt_submission`
GO
TRUNCATE TABLE `submission`
GO
TRUNCATE TABLE `apt`
GO
TRUNCATE TABLE `adm`
GO
update `seq`
set value = 1
GO

select * from pt
go
select * from pt_working
go
select * from `submission`
go
select * from pt_submission
go
select * from seq
go

select * from apt
go
select * from adm
go


select * from `pt_working` where `createdBy` = 1 and `ptUniqueId` = 1



select * from submission
go
select * from pt_submission
go

