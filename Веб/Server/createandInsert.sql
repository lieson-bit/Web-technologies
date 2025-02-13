use web;
create table developer
(
	id_developer int(11)  not null AUTO_INCREMENT,
    typeCompany varchar(45) not null,
    developer_name varchar(45) not null,
    headquarter varchar(45) not null,
    dateOfFoundation varchar(45) not null,
    keyPeople varchar(45) not null,
    primary key(id_developer)
);

create table audioEditor
(
	id_audioEditor int(11)  not null AUTO_INCREMENT,
    audioEditor_Name varchar(45) not null,
    licence varchar(45) not null,
    Windows varchar(10) not null,
    MacOS varchar(10) not null,
    Linux varchar(10) not null,
    id_developer INT not null,
    primary key(id_audioEditor),
    constraint id_developer foreign key(id_developer) references developer(id_developer)
); 
INSERT INTO developer(typeCompany, developer_name, headquarter, dateOfFoundation, keyPeople)
values ('GmbH','Magix','Берлин',"1994","Клаус Шмидт"),
('GmbH','Steinberg','Гамбург',"1984","Андреас Стеллинг"),
('AG','Ableton','Берлин',"1999","Герхард Белес"),
('Public','Apple','Купертино',"1976","Стив Джобс");

INSERT INTO audioEditor(audioEditor_Name, licence, Windows, MacOS, Linux, id_developer)
values ('ACID Pro','Собственный','Да',"Нет","Нет",1),
('Samplitude','Собственный','Да',"Нет","Нет",1),
('Cubase','Собственное','Да',"Да","Нет",2),
('Nuendo','Собственный','Да',"Да","Нет",2),
('Live','Собственный','Да',"Нет","Нет",3),
('Logic Pro','Proprietary','Нет',"Да","Нет",4);

ALTER TABLE audioEditor AUTO_INCREMENT = 1;
ALTER TABLE developer AUTO_INCREMENT = 1;
