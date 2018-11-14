create table if not exists todos
(
	id bigint auto_increment
		primary key,
	username varchar(255) not null,
	email varchar(255) not null,
	title varchar(255) not null,
	text text not null,
	complete tinyint default '0' null,
	image varchar(255) null
)
;
