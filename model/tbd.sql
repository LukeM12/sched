create table Courses(
		SUBJ text,
		CRSE int,
		SEQ text,
		CATALOG_TITLE text,
		INSTR_TYPE text,
		DAYS int,
		START_TIME int,
		END_TIME int,
		ROOM_CAP int
);
.separator ';'
.import data.csv Courses
select * from Courses;


