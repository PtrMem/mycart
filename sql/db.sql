create database book_sc;

use book_sc;

create table customers
(
  customerid int unsigned not null auto_increment primary key,
  name char(60) not null,
  address char(80) not null,
  city char(30) not null,
  state char(20),
  phone char(11),
)default charset=utf8 auto_increment=1;

create table orders
(
  orderid int unsigned not null auto_increment primary key,
  user_id int unsigned not null,
  amount float(6,2),
  date date not null,
  order_status char(10),
  ship_name char(60) not null,
  ship_address char(80) not null,
  ship_city char(30) not null,
  ship_state char(20),
  ship_phone char(11) not null,
)default charset=utf8 auto_increment=1;

create table books
(
   isbn char(13) not null primary key,
   author char(80),
   title char(100),
   catid int unsigned,
   price float(4,2) not null,
   description varchar(255)
)default charset=utf8;

create table categories
(
  catid int unsigned not null auto_increment primary key,
  catname char(60) not null
)default charset=utf8 auto_increment=1;

create table order_items
(
  orderid int unsigned not null,
  isbn char(13) not null,
  item_price float(4,2) not null,
  quantity tinyint unsigned not null,
  primary key (orderid, isbn)
)default charset=utf8;

create table user
(
  user_id int(10) unsigned not null auto_increment primary key,
  username char(16) not null primary key,
  password char(40) not null,
  email char(255) not null
)default charset=utf8 auto_increment=1;

