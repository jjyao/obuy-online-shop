set storage_engine = InnoDB;
set names UTF8;

drop database if exists obuy_mall;
create database if not exists obuy_mall CHARACTER SET utf8 COLLATE utf8_general_ci;

use obuy_mall;

drop table if exists website;
create table if not exists website(  -- store website's basic info
	id integer(1) primary key auto_increment,
	name varchar(255) not null -- website name
);

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
	foreign key (clientId) references client(id) on delete cascade
);

drop table if exists delivery_address;
create table if not exists delivery_address(
	id bigint(10) primary key auto_increment,
	clientId bigint(10) not null,
	cityId integer(10) not null,
	address varchar(511) not null,
	foreign key (clientId) references client(id) on delete cascade,
	foreign key (cityId) references city(id) on delete restrict
);

drop table if exists category;
create table if not exists category(
	id bigint(10) primary key auto_increment,
	name varchar(511) not null,
	parentCategoryId bigint(10) default null, -- null stands for top level category
	foreign key (parentCategoryId) references category(id) on delete cascade
);

drop table if exists product;
create table if not exists product(
	id bigint(10) primary key auto_increment,
	name varchar(511) not null, -- name should be unique
	price decimal(10, 2) not null,
	imageFoldPath varchar(511) not null, -- relative path to the web root, may contain images of different size
	categoryId bigint(10) not null,
	description text,
	howToUse text,
	additionalSpec text, -- additional specification
	publishTime timestamp default current_timestamp, -- the time that the product became on sale
	isOnSale integer(2) not null,
	foreign key (categoryId) references category(id) on delete restrict
);

drop table if exists order_record;
create table if not exists order_record(
	id bigint(10) primary key auto_increment,
	clientId bigint(10) not null,
	time timestamp default current_timestamp, -- order time
	deliveryAddress varchar(511) not null, 
	status integer(5) not null, -- the order's status like submit, delivery, payment
	foreign key (clientId) references client(id) on delete cascade
);

drop table if exists order_item;
create table if not exists order_item(
	id bigint(10) primary key auto_increment,
	orderRecordId bigint(10) not null,
	productId bigint(10) not null,
	count integer(10) not null,
	unitPrice decimal(10, 2) not null, -- product unit price when the client placed the order
	isEvaluated integer(5) not null, -- evaluate the product or not
	foreign key (productId) references product(id) on delete cascade,
	foreign key (orderRecordId) references order_record(id) on delete cascade
);

drop table if exists shopcart_item;
create table if not exists shopcart_item(
	id bigint(10) primary key auto_increment,
	clientId bigint(10) not null,
	productId bigint(10) not null,
	count integer(10) default 1, -- default client add one product to shopcart
	time timestamp default current_timestamp, -- the time that client add product to shopcart
	foreign key (clientId) references client(id) on delete cascade,
	foreign key (productId) references product(id) on delete cascade
);

drop table if exists evaluation;
create table if not exists evaluation(
	id bigint(10) primary key auto_increment,
	score integer(2) not null, -- score can be 1, 2, 3, 4, 5
	comment text not null,
	time timestamp default current_timestamp,
	clientId bigint(10) not null,
	productId bigint(10) not null,
	orderId bigint(10),
	foreign key (clientId) references client(id) on delete cascade,
	foreign key (productId) references product(id) on delete cascade,
	foreign key (orderId) references order_item(id) on delete set null
);

drop table if exists announcement;
create table if not exists announcement(
	id bigint(10) primary key auto_increment,
	title varchar(100) not null,
	content text not null,
	time timestamp default current_timestamp, -- the time that the announcement is published
	isActive integer(2) not null
);

drop table if exists feedback;
create table if not exists feedback(
	id bigint(10) primary key auto_increment,
	clientId bigint(10) not null,
	content text not null,
	time timestamp default current_timestamp,
	foreign key (clientId) references client(id) on delete cascade
);

grant all on obuy_mall.* to 'obuyer'@'localhost' identified by 'obuyer';

-- init data
insert website (name) values('买么事');

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

-- category fake data
insert into category (name, parentCategoryId) values ('电子产品', null);
insert into category (name, parentCategoryId) values ('图书', null);
insert into category (name, parentCategoryId) values ('家用电器', null);
insert into category (name, parentCategoryId) values ('个护化妆', null);
insert into category (name, parentCategoryId) values ('儿童用户', null);
insert into category (name, parentCategoryId) values ('运动健康', null);
insert into category (name, parentCategoryId) values ('保健食品', null);
insert into category (name, parentCategoryId) values ('家装建材', null);
insert into category (name, parentCategoryId) values ('办公用品', null);
insert into category (name, parentCategoryId) values ('电脑', 1);
insert into category (name, parentCategoryId) values ('手机', 1);
insert into category (name, parentCategoryId) values ('平板', 1);
insert into category (name, parentCategoryId) values ('戴尔', 4);
insert into category (name, parentCategoryId) values ('联想', 4);
insert into category (name, parentCategoryId) values ('华硕', 4);
insert into category (name, parentCategoryId) values ('洗衣机', 3);
insert into category (name, parentCategoryId) values ('冰箱', 3);
insert into category (name, parentCategoryId) values ('电视机', 3);
insert into category (name, parentCategoryId) values ('烘干机', 3);
insert into category (name, parentCategoryId) values ('吸尘器', 3);
insert into category (name, parentCategoryId) values ('加湿器', 3);
insert into category (name, parentCategoryId) values ('消毒柜', 3);
insert into category (name, parentCategoryId) values ('音响', 3);
-- product fake data
insert into product (name, price, imageFoldPath, categoryId, description, howToUse, additionalSpec, isOnSale) values('格力空调', '149.0', 'L:\My courses\Current Courses\Web Computing\ObuyMall\protected\data\product_image\1', 3, 'good', 'good', 'good', 1);
insert into product (name, price, imageFoldPath, categoryId, description, howToUse, additionalSpec, isOnSale) values('Gree空调', '159.0', 'L:\My courses\Current Courses\Web Computing\ObuyMall\protected\data\product_image\2', 3, 'good', 'good', 'good', 1);

-- order fake data
insert into order_item (clientId, productId, count, unitPrice, deliveryAddress, status) values (1, 1, 2, '149.0', 'Suzhou', 1);
insert into order_item (clientId, productId, count, unitPrice, deliveryAddress, status) values (1, 2, 1, '149.0', 'Suzhou', 1);

-- announcement fake data
insert into announcement (title, content, isActive) values ('回馈新老顾客', '回馈新老顾客', 1);
insert into announcement (title, content, isActive) values ('化妆品促销季', '化妆品促销季', 1);
insert into announcement (title, content, isActive) values ('商场三折酬宾', '商场三折酬宾', 1);
insert into announcement (title, content, isActive) values ('回馈新老顾客', '回馈新老顾客', 1);
insert into announcement (title, content, isActive) values ('回馈新老顾客', '回馈新老顾客', 1);
insert into announcement (title, content, isActive) values ('化妆品促销季', '化妆品促销季', 1);
insert into announcement (title, content, isActive) values ('回馈新老顾客', '回馈新老顾客', 1);
insert into announcement (title, content, isActive) values ('回馈新老顾客', '回馈新老顾客', 1);
insert into announcement (title, content, isActive) values ('商场三折酬宾', '商场三折酬宾', 1);
insert into announcement (title, content, isActive) values ('回馈新老顾客', '回馈新老顾客', 1);
insert into announcement (title, content, isActive) values ('回馈新老顾客', '回馈新老顾客', 1);	