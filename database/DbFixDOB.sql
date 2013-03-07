select * from `pt`
go
select * from pt_working




select 
    STR_TO_DATE(concat(ptDateOfBirth, '/', YEAR(NOW())), '%m/%d/%Y'), 
    REPLACE(ptAge, ' years', ''),
    DATE_FORMAT(DATE_ADD(STR_TO_DATE(concat(ptDateOfBirth, '/', YEAR(NOW())), '%m/%d/%Y'),  INTERVAL - REPLACE(ptAge, ' years', '') YEAR), '%m/%d/%Y')
from `pt`


update `pt`
set `ptDateOfBirth` = DATE_FORMAT(DATE_ADD(STR_TO_DATE(concat(ptDateOfBirth, '/', YEAR(NOW())), '%m/%d/%Y'),  INTERVAL - REPLACE(ptAge, ' years', '') YEAR), '%m/%d/%Y')


go
select * from pt_working