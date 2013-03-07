select * from `opCl`
go
select * from `opCl_working`
where opClDetailsOpClId = 6
go
--select * from `opCl_submission`
--go

select * from opClDiagCodes
go
select * from opClDiagCodes_working
go
select * from opClProcCodes
go
select * from opClProcCodes_working
go


select * from submission
where submissionId > 63
go
select * from opCl_submission
where submissionId > 63
go
select * from opClDiagCodes_submission
go
select * from opClProcCodes_submission
go

update neehr.users
set `ehr_username` = 'JDEETS01', `ehr_password` = 'JDEETS01'
where id = 6
