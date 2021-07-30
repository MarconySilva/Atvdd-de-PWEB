create database banco_de_usuarios;

CREATE TABLE usuario (
  id int auto_increment primary key,
  nome varchar(50),
  email varchar(60) unique key,
  usuario varchar(40) unique key,
  senha varchar(100)
);
