/*
truncate table `apt`
go
truncate table `apt_working`
go
truncate table `apt_submission`
go
update seq
set `value` = 1
where `service` = 'apt'
go
*/


// patientId = 9

select * from apt
go
select * from apt_working
go
select * from apt_submission
go
select * from seq
where `service` = 'apt'



select * from neehr.users
where `lastname` = 'Annala-Faculty'


select * from `submission`
where `submissionId` = 49
Go
select * from `submission_comment`
where `submissionId` = 49
go