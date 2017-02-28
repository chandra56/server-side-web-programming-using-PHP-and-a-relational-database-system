create table Customers (
   username   varchar(10) primary key,
   password   varchar(32),
   address    varchar(100),
   phone	  varchar(20),
   email      varchar(45)
);

create table ShoppingBasket (
   basketId   varchar(13) primary key,
   username	  varchar(10) references Customers (username)
);
