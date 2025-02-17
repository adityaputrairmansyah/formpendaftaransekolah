CREATE DATABASE formpendaftaransekolah;

USE formpendaftaransekolah;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    nama_lengkap VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role ENUM('admin', 'user') DEFAULT 'user'
);

CREATE TABLE siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_pendaftaran VARCHAR(20) UNIQUE,
    nama_lengkap VARCHAR(100),
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan'),
    agama VARCHAR(20),
    alamat TEXT,
    nama_ortu VARCHAR(100),
    no_hp VARCHAR(15),
    asal_sekolah VARCHAR(100),
    nilai_un DECIMAL(5,2) NULL,
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    nama_lengkap VARCHAR(100)
);

-- Password: admin123 (menggunakan MD5 untuk kemudahan)
INSERT INTO admin (username, password, nama_lengkap) 
VALUES ('admin', MD5('admin123'), 'Administrator');

-- Buat akun admin default
INSERT INTO users (username, password, nama_lengkap, email, role) 
VALUES ('admin', MD5('admin123'), 'Administrator', 'admin@smpn2pujut.sch.id', 'admin'); 