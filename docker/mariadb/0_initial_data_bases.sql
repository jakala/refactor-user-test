CREATE DATABASE technical_test;

USE technical_test;

CREATE TABLE user
(
    id    varchar(36)  not null,
    name  varchar(100) not null,
    phone varchar(9)   not null,
    constraint pk_user primary key (id)
);