drop database if exists jig;
create database jig;
use jig;

create table usuario (
id int primary key auto_increment not null unique,
nombre varchar (255),
contrasena varchar (255),
email varchar (255) unique,
telefono varchar (255),
imagen text,
rol varchar(10)
);


create table producto (
idProducto int primary key auto_increment not null,
nombre varchar (255),
descripcion text,
imagen text,
precio varchar(10)
);

insert into usuario (nombre, contrasena, email, telefono, imagen, rol) values ("pesca", "$2y$10$LQJJ3HQKXHSQrSY0CK351.qOG8etP1dIVQkX46o8BhxDrGhwu3fzC", "pesca@gmail.com", "622096089", "../IMG/usuarios/1.jpg", "admin");

insert into producto (nombre, descripcion, imagen, precio) values
("Proteina Whey", "Lorem ipsum dolor sit amet consectetur adipisicing elit. At vet suscipit ipsa temporibus incidunt a laudantium nam aspernatur ipsam. Inventore harum cum ex velit iure.", "../IMG/productos/1.jpg", "54,99"),
("Batido de proteinas", "Lorem ipsum dolor sit amet consectetur adipisicing elit. At vet suscipit ipsa temporibus incidunt a laudantium nam aspernatur ipsam. Inventore harum cum ex velit iure.", "../IMG/productos/2.jpg", "3,99"),
("Proteina Keto", "Lorem ipsum dolor sit amet consectetur adipisicing elit. At vet suscipit ipsa temporibus incidunt a laudantium nam aspernatur ipsam. Inventore harum cum ex velit iure.", "../IMG/productos/3.jpg", "69,99"),
("Proteina Isolada", "Lorem ipsum dolor sit amet consectetur adipisicing elit. At vet suscipit ipsa temporibus incidunt a laudantium nam aspernatur ipsam. Inventore harum cum ex velit iure.", "../IMG/productos/4.jpg", "84,99"),
("Zapatillas halterofilia", "Lorem ipsum dolor sit amet consectetur adipisicing elit. At vet suscipit ipsa temporibus incidunt a laudantium nam aspernatur ipsam. Inventore harum cum ex velit iure.", "../IMG/productos/5.jpg", "154,99"),
("Zapatillas deportivas", "Lorem ipsum dolor sit amet consectetur adipisicing elit. At vet suscipit ipsa temporibus incidunt a laudantium nam aspernatur ipsam. Inventore harum cum ex velit iure.", "../IMG/productos/6.jpg", "124,99"),
("Zapatillas deportivas", "Lorem ipsum dolor sit amet consectetur adipisicing elit. At vet suscipit ipsa temporibus incidunt a laudantium nam aspernatur ipsam. Inventore harum cum ex velit iure.", "../IMG/productos/7.jpg", "99,99"),
("Proteina Whey", "Lorem ipsum dolor sit amet consectetur adipisicing elit. At vet suscipit ipsa temporibus incidunt a laudantium nam aspernatur ipsam. Inventore harum cum ex velit iure.", "../IMG/productos/8.jpg", "49,99");

select * from usuario;