CREATE DATABASE db_realisasi;

USE db_realisasi;

CREATE TABLE realisasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    partai VARCHAR(50) NOT NULL,
    pendidikan_politik DECIMAL(5, 2) NOT NULL,
    kesektariatan DECIMAL(5, 2) NOT NULL
);

CREATE TABLE users (
    id VARCHAR(255) PRIMARY KEY,
    email VARCHAR(255),
    username VARCHAR(255),
    password VARCHAR(255)
);

INSERT INTO
    realisasi (
        partai,
        pendidikan_politik,
        kesektariatan
    )
VALUES ('GERINDRA', 60.0, 40.0),
    ('PKS', 55.0, 45.0),
    ('GOLKAR', 70.0, 30.0),
    ('PDIP', 50.0, 50.0),
    ('PKB', 65.0, 35.0),
    ('DEMOKRAT', 40.0, 60.0),
    ('PAN', 45.0, 55.0),
    ('NASDEM', 52.0, 48.0),
    ('PPP', 58.0, 42.0),
    ('PSI', 62.0, 38.0);

INSERT INTO
    users (id, email, username, password)
VALUES (
        'IMP-2200',
        "admin@mail.com",
        "Admin",
        "3c071d3470af343c81ec918b5a63b360643b99f8"
    );