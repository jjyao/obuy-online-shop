set storage_engine = InnoDB;

set names UTF8;

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
