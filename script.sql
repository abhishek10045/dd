CREATE DATABASE event_details;

USE event_details;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    college VARCHAR(200) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE event1 (
    id INT UNSIGNED NOT NULL,
    FOREIGN KEY(id) REFERENCES users(id)    
);

CREATE TABLE event2 (
    id INT UNSIGNED NOT NULL,
    FOREIGN KEY(id) REFERENCES users(id)    
);

CREATE TABLE event3 (
    id INT UNSIGNED NOT NULL,
    FOREIGN KEY(id) REFERENCES users(id)    
);

CREATE TABLE event4 (
    id INT UNSIGNED NOT NULL,
    FOREIGN KEY(id) REFERENCES users(id)    
);