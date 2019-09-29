<?php
    include_once 'classes.php';
    $pdo = Tools::connect();
    $role = "create table roles(
        id int not null auto_increment primary key,
        role varchar(25) not null unique
    ) default charset ='utf8'";

    $customer = "create table customers(
        id int not null auto_increment primary key,
        login varchar(25) not null unique,
        password varchar(32) not null,
        role_id int, foreign key(role_id) references roles(id) on update cascade,
        discount int,
        image_path varchar(255)
    ) default charset ='utf8'";

    $room = "create table rooms(
        id int not null auto_increment primary key,
        number int not null,
        size int not null
    ) default charset='utf8'";
    

    $consult = "create table consults(
        id int not null auto_increment primary key,
        room_id int not null,
        foreign key (room_id) references rooms(id) on update cascade,
        customer_id int not null,
        foreign key (customer_id) references customers(id) on update cascade,
        date date not null,
        pare int not null,
        students int not null,
        info varchar(255) not null,
        approved bit(1) not null
    ) default charset='utf8'";

    $pdo->exec($role);
    $pdo->exec($customer);
    $pdo->exec($room);
    $pdo->exec($consult);
    
    // for ($i=1; $i < 16; $i++) { 
    //     $size = rand(12, 24);
    //     $room = new Room($i, $size);
    //     $room->intoDb();
    // }
?>