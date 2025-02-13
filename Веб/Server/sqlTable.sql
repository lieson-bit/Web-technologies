select * from audioeditor
right join developer on audioeditor.id_developer = developer.id_developer;
delete from tableOne where id_tableOne > 0;
delete from tableTwo where id_tableTwo > 0;

drop table tableTwo;
drop table tableOne;