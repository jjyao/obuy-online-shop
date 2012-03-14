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

drop table if exists product;
create table if not exists product(
	id bigint(10) primary key auto_increment,
	name varchar(511) not null,
	price decimal(10, 2) not null,
	iconFoldPath varchar(511) not null, -- category page show product icon, a product can have icons with different size
	imageFoldPath varchar(511) not null, -- relative path to the web root, product page show product image
	description text,
	howToUse text,
	additionalSpec text, -- additional specification
	publishTime timestamp default current_timestamp, -- the time that the product became on sale
	isOnSale integer(2) not null
);

drop table if exists category;
create table if not exists category(
	id bigint(10) primary key auto_increment,
	name varchar(511) not null,
	parentCategoryId bigint(10) default null, -- null stands for top level category
	foreign key (parentCategoryId) references category(id) on delete set null
);

drop table if exists evaluation;
create table if not exists evaluation(
	id bigint(10) primary key auto_increment,
	score integer(2) default 1, -- score can be 1, 2, 3, 4, 5
	comment text not null,
	time timestamp default current_timestamp,
	clientId bigint(10) not null,
	productId bigint(10) not null,
	foreign key (clientId) references client(id) on delete cascade,
	foreign key (productId) references product(id) on delete cascade
);

drop table if exists order_item;
create table if not exists order_item(
	id bigint(10) primary key auto_increment,
	clientId bigint(10) not null,
	productId bigint(10) not null,
	count integer(10) default 1, -- default client buy one product
	unitPrice decimal(10, 2) not null, -- product unit price when the client placed the order
	time timestamp default current_timestamp, -- order time
	status integer(5) not null, -- the order's status like wait, delivery, payment, evaluation 
	foreign key (clientId) references client(id) on delete cascade,
	foreign key (productId) references product(id) on delete cascade
);

drop table if exists shopcart_item;
create table if not exists shopcart_item(
	id bigint(10) primary key auto_increment,
	clientId bigint(10) not null,
	productId bigint(10) not null,
	count integer(10) default 1, -- default client add one product to shopcart
	tiem timestamp default current_timestamp, -- the time that client add product to shopcart
	foreign key (clientId) references client(id) on delete cascade,
	foreign key (productId) references product(id) on delete cascade
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
insert into admin (clientId) values (1); -- obuyer is admin
