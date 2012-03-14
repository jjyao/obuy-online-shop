set storage_engine = InnoDB;

drop database if exists obuy_mall;
create database if not exists obuy_mall CHARACTER SET utf8 COLLATE utf8_general_ci;

use obuy_mall;

drop table if exists city;
create table if not exists city(
	id integer(10) primary key auto_increment,
	name varchar(255) not null,
	provinceName varchar(255) not null,
	unique(name)
);

drop table if exists client;
create table if not exists client(
	id bigint(10) primary key auto_increment,
	name varchar(255) not null,
	email varchar(255) not null, 
	password varchar(511) not null,
	isActive integer(2) not null default 0, -- record whether this client removed his or her account
	unique(email)
);

drop table if exists admin;
create table if not exists admin(
	id integer(10) primary key auto_increment,
	clientId bigint(10),
	foreign key (clientId) references client(id)
);

drop table if exists delivery_address;
create table if not exists delivery_address(
	id bigint(10) primary key auto_increment,
	clientId bigint(10) not null,
	cityId integer(10) not null,
	address varchar(511) not null,
	foreign key (clientId) references client(id),
	foreign key (cityId) references city(id)
);

grant all on obuy_mall.* to 'obuyer'@'localhost' identified by 'obuyer';

-- init data
insert city (name, provinceName) values ('苏州' ,'江苏');
insert city (name, provinceName) values ('常州' ,'江苏');
insert city (name, provinceName) values ('扬州' ,'江苏');
insert city (name, provinceName) values ('无锡' ,'江苏');
insert city (name, provinceName) values ('徐州' ,'江苏');
insert city (name, provinceName) values ('南通' ,'江苏');
insert city (name, provinceName) values ('湛江', '广东');
insert city (name, provinceName) values ('温州', '浙江');

-- fake data
insert into client (name, email, password) values ('obuyer', 'obuyer@gmail.com', 'f357205e9e74045c029e0f211bd06943');
insert into admin (clientId) values (1);	