create table ec_users (
  id int not null auto_increment primary key,
  name text not null,
  password text not null,
  created_at datetime not null,
  updated_at datetime not null,
  admin boolean not null default false
);

insert into ec_users 
(name, password, created_at, updated_at, admin) 
values ('admin', 'admin', now(), now(), true);

create table ec_buys (
  id int not null auto_increment primary key,
  user_id int not null,
  item_id int not null,
  amount int not null,
  created_at datetime not null
);