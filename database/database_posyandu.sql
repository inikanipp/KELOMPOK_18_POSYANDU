-- ======================== TABLE =============================

CREATE DATABASE db_posnew

USE db_posnew;

CREATE TABLE admin (
  username varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  id_admin int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id_admin)
);


CREATE TABLE balita (
  id_balita int NOT NULL AUTO_INCREMENT,
  nama_balita varchar(100) DEFAULT NULL,
  tgl_lahir date DEFAULT NULL,
  jenis_kelamin enum('Laki-laki','Perempuan') DEFAULT NULL,
  id_ortu int DEFAULT NULL,
  PRIMARY KEY (id_balita),
  KEY fk_idortu_balita_idortu_orangtua (id_ortu),
  CONSTRAINT fk_idortu_balita_idortu_orangtua FOREIGN KEY (id_ortu) REFERENCES orang_tua (id_ortu) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE imunisasi_balita (
  id_imunisasi_balita int NOT NULL AUTO_INCREMENT,
  id_balita int DEFAULT NULL,
  id_imunisasi int DEFAULT NULL,
  tanggal_pemberian date DEFAULT NULL,
  status enum('Belum','Sudah') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Belum',
  PRIMARY KEY (id_imunisasi_balita),
  KEY fk_idbalita_imunisasi_idbalita_balita (id_balita),
  KEY fk_idimunisasi_imunisasi_id_imunisasi_jenis_imunisasi (id_imunisasi),
  CONSTRAINT fk_idbalita_imunisasi_idbalita_balita FOREIGN KEY (id_balita) REFERENCES balita (id_balita) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_idimunisasi_imunisasi_id_imunisasi_jenis_imunisasi FOREIGN KEY (id_imunisasi) REFERENCES jenis_imunisasi (id_imunisasi) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE jenis_imunisasi (
  id_imunisasi int NOT NULL AUTO_INCREMENT,
  nama_imunisasi varchar(100) DEFAULT NULL,
  usia_pemberian int DEFAULT NULL,
  keterangan text,
  PRIMARY KEY (id_imunisasi)
);

CREATE TABLE kader (
  id_kader int NOT NULL AUTO_INCREMENT,
  nama_kader varchar(100) DEFAULT NULL,
  jabatan varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  no_hp varchar(20) DEFAULT NULL,
  byk_anak int DEFAULT '0',
  username varchar(50) DEFAULT NULL,
  pw varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  status_kader varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (id_kader)
);

CREATE TABLE kunjungan_posyandu (
  id_kunjungan int NOT NULL AUTO_INCREMENT,
  id_balita int DEFAULT NULL,
  id_kader int DEFAULT NULL,
  tanggal_kunjungan date DEFAULT NULL,
  berat_badan decimal(5,2) DEFAULT NULL,
  tinggi_badan decimal(5,2) DEFAULT NULL,
  status_gizi enum('Baik','Kurang','Buruk','Lebih') DEFAULT 'Baik',
  id_imunisasi_balita int DEFAULT NULL,
  PRIMARY KEY (id_kunjungan),
  KEY fk_idbalita_kunjungan_idbalita_balita (id_balita),
  KEY fk_idkader_kunjungan_idkader_kader (id_kader),
  KEY fk_id_imunisasi_balita_kunjungan (id_imunisasi_balita),
  CONSTRAINT fk_id_imunisasi_balita_kunjungan FOREIGN KEY (id_imunisasi_balita) REFERENCES imunisasi_balita (id_imunisasi_balita) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_idbalita_kunjungan_idbalita_balita FOREIGN KEY (id_balita) REFERENCES balita (id_balita) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_idkader_kunjungan_idkader_kader FOREIGN KEY (id_kader) REFERENCES kader (id_kader) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE orang_tua (
  id_ortu int NOT NULL AUTO_INCREMENT,
  nama_ibu varchar(100) DEFAULT NULL,
  nama_ayah varchar(100) DEFAULT NULL,
  alamat text,
  no_hp varchar(20) DEFAULT NULL,
  username varchar(50) DEFAULT NULL,
  password varchar(50) DEFAULT NULL,
  PRIMARY KEY (id_ortu)
);

-- ======================== TRIGGER =============================

-- Tabel balita
DELIMITER //
DROP TRIGGER IF EXISTS before_insert_balita //
CREATE TRIGGER before_insert_balita BEFORE INSERT ON balita FOR EACH ROW
BEGIN
    IF NEW.nama_balita = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nama tidak boleh kosong';
    END IF;
END //
DROP TRIGGER IF EXISTS after_insert_balita //
CREATE TRIGGER after_insert_balita AFTER INSERT ON balita FOR EACH ROW
BEGIN
    INSERT INTO imunisasi_balita (id_balita, id_imunisasi, tanggal_pemberian)
    VALUES (NEW.id_balita, 1, NEW.tgl_lahir + INTERVAL 1 YEAR);
END //
DROP TRIGGER IF EXISTS after_update_balita //
CREATE TRIGGER after_update_balita AFTER UPDATE ON balita FOR EACH ROW
BEGIN
    UPDATE imunisasi_balita
    SET tanggal_pemberian = NEW.tgl_lahir + INTERVAL 1 YEAR
    WHERE id_balita = OLD.id_balita;
END //
DROP TRIGGER IF EXISTS before_delete_balita //
CREATE TRIGGER before_delete_balita BEFORE DELETE ON balita FOR EACH ROW
BEGIN
    IF OLD.id_balita IN (
        SELECT id_balita
        FROM imunisasi_balita
        WHERE tanggal_pemberian = OLD.tgl_lahir + INTERVAL 1 YEAR
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Minimal 1 tahun imunisasi bos';
    END IF;
END //
DELIMITER ;

-- Tabel Kader
DELIMITER //
DROP TRIGGER IF EXISTS before_insert_kader //
CREATE TRIGGER before_insert_kader BEFORE INSERT ON kader FOR EACH ROW
BEGIN
    IF NEW.username IS NULL OR TRIM(NEW.username) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Username harus diisi!';
    END IF;
    IF NEW.pw IS NULL OR TRIM(NEW.pw) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Password harus diisi!';
    END IF;
    IF NEW.nama_kader IS NULL OR TRIM(NEW.nama_kader) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nama kader harus diisi!';
    END IF;
    IF NEW.jabatan IS NULL OR TRIM(NEW.jabatan) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jabatan harus diisi!';
    END IF;
    IF NEW.byk_anak IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Banyak anak harus diisi!';
    END IF;
    IF NEW.no_hp IS NULL OR TRIM(NEW.no_hp) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No HP harus diisi!';
    END IF;
    IF NEW.status_kader IS NULL OR TRIM(NEW.status_kader) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Status harus diisi!';
    END IF;
END //
DROP TRIGGER IF EXISTS before_update_kader //
CREATE TRIGGER before_update_kader BEFORE UPDATE ON kader FOR EACH ROW
BEGIN
    IF NEW.username IS NULL OR TRIM(NEW.username) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Username harus diisi!';
    END IF;
    IF NEW.pw IS NULL OR TRIM(NEW.pw) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Password harus diisi!';
    END IF;
    IF NEW.nama_kader IS NULL OR TRIM(NEW.nama_kader) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nama kader harus diisi!';
    END IF;
    IF NEW.jabatan IS NULL OR TRIM(NEW.jabatan) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jabatan harus diisi!';
    END IF;
    IF NEW.byk_anak IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Banyak anak harus diisi!';
    END IF;
    IF NEW.no_hp IS NULL OR TRIM(NEW.no_hp) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No HP harus diisi!';
    END IF;
    IF NEW.status_kader IS NULL OR TRIM(NEW.status_kader) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Status harus diisi!';
    END IF;
END //
DELIMITER ;

-- Tabel Kunjungan Posyandu
DELIMITER //
DROP TRIGGER IF EXISTS after_insert_kunjungan //
CREATE TRIGGER after_insert_kunjungan AFTER INSERT ON kunjungan_posyandu FOR EACH ROW
BEGIN
    DECLARE v_id_balita INT;
    DECLARE v_tgl_lahir DATE;
    DECLARE v_id_imunisasi INT;
    DECLARE v_byk_anak INT;

    UPDATE imunisasi_balita
    SET STATUS = 'Sudah'
    WHERE id_imunisasi_balita = NEW.id_imunisasi_balita;

    SELECT id_balita, id_imunisasi
    INTO v_id_balita, v_id_imunisasi
    FROM imunisasi_balita
    WHERE id_imunisasi_balita = NEW.id_imunisasi_balita
    LIMIT 1;

    SELECT tgl_lahir
    INTO v_tgl_lahir
    FROM balita
    WHERE id_balita = v_id_balita
    LIMIT 1;

    INSERT INTO imunisasi_balita (id_balita, id_imunisasi, tanggal_pemberian, STATUS)
    VALUES (v_id_balita, v_id_imunisasi + 1, v_tgl_lahir + INTERVAL 1 YEAR, 'Belum');

    SELECT byk_anak INTO v_byk_anak FROM kader WHERE id_kader = NEW.id_kader;
    UPDATE kader SET byk_anak = v_byk_anak + 1 WHERE id_kader = NEW.id_kader;
END //
DELIMITER ;


-- ======================== STORED PROCEDURE =============================

-- Stored Procedure
-- add balita
DELIMITER //
DROP PROCEDURE IF EXISTS addBalita //
CREATE PROCEDURE addBalita (
    IN p_nama_balita VARCHAR(50),
    IN p_id_ortu INT,
    IN p_date DATE,
    IN p_jenis_kelamin VARCHAR(40)
)
BEGIN 
    INSERT INTO balita (nama_balita, tgl_lahir, jenis_kelamin, id_ortu)
    VALUES (p_nama_balita, p_date, p_jenis_kelamin, p_id_ortu);
END //
DELIMITER ;

-- add kunjungan
DELIMITER //
DROP PROCEDURE IF EXISTS add_kunjungan //
CREATE PROCEDURE add_kunjungan (
    IN p_id_balita INT,
    IN p_id_kader INT,
    IN p_tgl_kjg DATE,
    IN p_bb DECIMAL(5,2),
    IN p_tb DECIMAL(5,2),
    IN p_status_gizi VARCHAR(50)
)
BEGIN
    INSERT INTO kunjungan_posyandu (
        id_balita, id_kader, tanggal_kunjungan, berat_badan, tinggi_badan, status_gizi
    )
    VALUES (p_id_balita, p_id_kader, p_tgl_kjg, p_bb, p_tb, p_status_gizi);
END //
DELIMITER ;

-- add_kunjungan_kader
DELIMITER //
DROP PROCEDURE IF EXISTS add_kunjungan_kader //
CREATE PROCEDURE add_kunjungan_kader (
    IN p_id_balita INT,
    IN p_id_kader INT,
    IN p_tanggal_kunjungan DATE,
    IN p_bb DECIMAL(5,2),
    IN p_tb DECIMAL(5,2),
    IN p_status VARCHAR(50)
)
BEGIN
    DECLARE v_id_imunisasi_balita INT;

    SELECT id_imunisasi_balita
    INTO v_id_imunisasi_balita
    FROM imunisasi_balita
    WHERE id_balita = p_id_balita AND STATUS = 'Belum'
    LIMIT 1;

    INSERT INTO kunjungan_posyandu (
        id_balita, id_kader, tanggal_kunjungan, berat_badan, tinggi_badan, status_gizi, id_imunisasi_balita
    )
    VALUES (
        p_id_balita, p_id_kader, p_tanggal_kunjungan, p_bb, p_tb, p_status, v_id_imunisasi_balita
    );
END //
DELIMITER ;

-- cek perbaris
DELIMITER //
DROP PROCEDURE IF EXISTS cek_perbaris //
CREATE PROCEDURE cek_perbaris (OUT p_jumlah INT)
BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE jumlah INT DEFAULT 0;
    DECLARE id_kunjungan INT;

    DECLARE cur CURSOR FOR
        SELECT id_kunjungan
        FROM kunjungan_posyandu
        WHERE tanggal_kunjungan BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE();

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur;
    loop_cek: LOOP
        FETCH cur INTO id_kunjungan;
        IF done THEN 
            LEAVE loop_cek;
        END IF;
        SET jumlah = jumlah + 1;
    END LOOP;
    CLOSE cur;

    SET p_jumlah = jumlah;
END //
DELIMITER ;

-- daftar ortu
DELIMITER //
DROP PROCEDURE IF EXISTS daftar_ortu //
CREATE PROCEDURE daftar_ortu (
    IN p_nama_ibu VARCHAR(50),
    IN p_nama_ayah VARCHAR(50),
    IN p_alamat TEXT,
    IN p_no_hp VARCHAR(14),
    IN p_username VARCHAR(50),
    IN p_password VARCHAR(50)
)
BEGIN
    INSERT INTO orang_tua (nama_ibu, nama_ayah, alamat, no_hp, username, PASSWORD)
    VALUES (p_nama_ibu, p_nama_ayah, p_alamat, p_no_hp, p_username, p_password);
END //
DELIMITER ;

-- delete balita
DELIMITER //
DROP PROCEDURE IF EXISTS delete_balita //
CREATE PROCEDURE delete_balita (
    IN p_id_balita INT
)
BEGIN
    DELETE FROM balita WHERE id_balita = p_id_balita;
END //
DELIMITER ;


-- kunjungan sebulan

DELIMITER $$

CREATE PROCEDURE `kunjungan_sebulan`()
BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE v_id_kunjungan INT;
    DECLARE v_id_balita INT;
    DECLARE v_id_kader INT;
    DECLARE v_tanggal_kunjungan DATE;
    DECLARE v_berat_badan DECIMAL(5,2);
    DECLARE v_tinggi_badan DECIMAL(5,2);
    DECLARE v_status_gizi ENUM('Baik','Kurang','Buruk','Lebih');
    -- cursor
    DECLARE cur CURSOR FOR
        SELECT id_kunjungan, id_balita, id_kader, tanggal_kunjungan, berat_badan, tinggi_badan, status_gizi
        FROM kunjungan_posyandu
        WHERE tanggal_kunjungan BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()
        ORDER BY id_kunjungan;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
    -- cek data
    IF (SELECT COUNT(*) FROM kunjungan_posyandu WHERE tanggal_kunjungan BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()) = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Tidak ada kunjungan posyandu dalam 1 bulan terakhir.';
    ELSE
        OPEN cur;
        read_loop: LOOP
            FETCH cur INTO v_id_kunjungan, v_id_balita, v_id_kader, v_tanggal_kunjungan, v_berat_badan, v_tinggi_badan, v_status_gizi;
            IF done THEN
                LEAVE read_loop;
            END IF;
            SELECT 
                v_id_kunjungan AS 'ID Kunjungan',
                v_id_balita AS 'ID Balita',
                v_id_kader AS 'ID Kader',
                v_tanggal_kunjungan AS 'Tanggal Kunjungan',
                v_berat_badan AS 'Berat Badan',
                v_tinggi_badan AS 'Tinggi Badan',
                v_status_gizi AS 'Status Gizi';
        END LOOP;
        CLOSE cur;
    END IF;
END$$

DELIMITER ;


-- kunjungan sebulan terakhir

DELIMITER $$

CREATE PROCEDURE `kunjungan_sebulan_terakhir`()
BEGIN
    IF (SELECT COUNT(*) FROM kunjungan_posyandu WHERE tanggal_kunjungan BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()) = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Tidak ada kunjungan posyandu dalam 1 bulan terakhir.';
    ELSE
        SELECT 
            kp.id_kunjungan AS 'ID Kunjungan',
            kp.id_balita AS 'ID Balita',
            b.jenis_kelamin AS 'Jenis Kelamin',
            kp.id_kader AS 'ID Kader',
            kp.tanggal_kunjungan AS 'Tanggal Kunjungan',
            kp.berat_badan AS 'Berat Badan',
            kp.tinggi_badan AS 'Tinggi Badan',
            kp.status_gizi AS 'Status Gizi'
        FROM kunjungan_posyandu kp
        JOIN balita b ON kp.id_balita = b.id_balita
        WHERE kp.tanggal_kunjungan BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()
        ORDER BY kp.id_kunjungan;
    END IF;
END$$

DELIMITER ;


-- sp_update_kader

DELIMITER $$

CREATE PROCEDURE `sp_update_kader`(
    IN p_id_kader INT,
    IN p_nama_kader VARCHAR(255),
    IN p_jabatan VARCHAR(255),
    IN p_byk_anak INT,
    IN p_no_hp VARCHAR(20),
    IN p_username VARCHAR(100),
    IN p_pw VARCHAR(100),
    IN p_status_kader ENUM('Aktif', 'Nonaktif')
)
BEGIN
    UPDATE kader 
    SET nama_kader = p_nama_kader, jabatan = p_jabatan, byk_anak = p_byk_anak, no_hp = p_no_hp,
    username = p_username, pw = p_pw, status_kader = p_status_kader
    WHERE id_kader = p_id_kader;
END$$

DELIMITER ;


-- update balita

DELIMITER $$

CREATE PROCEDURE `update_balita`(
	IN p_nama_balita VARCHAR(50),
	IN p_tgl_lahir DATE,
	IN p_jenis VARCHAR(50),
	IN p_id_balita INT

)
BEGIN
	UPDATE balita SET nama_balita = p_nama_balita, tgl_lahir = p_tgl_lahir, jenis_kelamin = p_jenis
		WHERE id_balita = p_id_balita; 

END$$

DELIMITER ;


-- ================================================= VIEW ==================================================================

-- View kunjungan posyandu
CREATE VIEW view_kunjungan_posyandu AS
SELECT
    kp.tanggal_kunjungan,
    b.nama_balita,
    b.jenis_kelamin,
    b.tgl_lahir,
    kp.berat_badan,
    kp.tinggi_badan,
    kp.status_gizi,
    ot.nama_ibu,
    ot.nama_ayah,
    ot.alamat,
    ot.no_hp
FROM kunjungan_posyandu kp
JOIN balita b ON kp.id_balita = b.id_balita
JOIN orang_tua ot ON b.id_ortu = ot.id_ortu;
SELECT * FROM view_kunjungan_posyandu;

-- View gizi buruk
CREATE VIEW view_balita_gizi_buruk AS
SELECT
    b.nama_balita,
    b.jenis_kelamin,
    b.tgl_lahir,
    kp.tanggal_kunjungan,
    kp.berat_badan,
    kp.tinggi_badan,
    kp.status_gizi
FROM balita b
JOIN kunjungan_posyandu kp ON b.id_balita = kp.id_balita
WHERE kp.status_gizi = 'Buruk';
SELECT * FROM view_balita_gizi_buruk;

-- View rekap imunisasi
CREATE VIEW view_rekap_imunisasi AS
SELECT
    b.nama_balita,
    b.jenis_kelamin,
    b.tgl_lahir,
    kp.tanggal_kunjungan,
    ji.nama_imunisasi,
    ib.tanggal_pemberian,
    ji.usia_pemberian
FROM imunisasi_balita ib
JOIN balita b ON ib.id_balita = b.id_balita
JOIN kunjungan_posyandu kp ON kp.id_balita = b.id_balita
JOIN jenis_imunisasi ji ON ib.id_imunisasi = ji.id_imunisasi;
SELECT * FROM view_rekap_imunisasi;


-- view imunisasi balita  	

CREATE VIEW view_imunisasi_balita AS
SELECT kps.id_balita, jim.nama_imunisasi, kps.tanggal_kunjungan, kps.berat_badan, kps.tinggi_badan FROM kunjungan_posyandu kps JOIN
	imunisasi_balita imb ON kps.id_imunisasi_balita = imb.id_imunisasi_balita
	JOIN jenis_imunisasi jim ON imb.id_imunisasi = jim.id_imunisasi;

-- view belum imunisasi

CREATE VIEW view_belum_imunisasi AS
SELECT jim.nama_imunisasi, blt.nama_balita, imb.id_balita, imb.status FROM imunisasi_balita imb JOIN balita blt ON 
	imb.id_balita = blt.id_balita JOIN jenis_imunisasi jim 
	ON imb.id_imunisasi = jim.id_imunisasi
	WHERE STATUS="Belum";
	
DROP VIEW view_belum_imunisasi
SELECT * FROM view_belum_imunisasi


-- view tampilan daftar balita kader
CREATE VIEW daftar_balita_kader AS
SELECT kps.id_balita,blt.jenis_kelamin, kps.id_kader, blt.nama_balita, kps.tanggal_kunjungan,
	kps.berat_badan, kps.tinggi_badan, status_gizi, blt.tgl_lahir, jim.nama_imunisasi FROM balita blt JOIN kunjungan_posyandu kps
	ON blt.id_balita = kps.id_balita JOIN imunisasi_balita imb 
	ON kps.id_imunisasi_balita = imb.id_imunisasi_balita 
	JOIN jenis_imunisasi jim ON imb.id_imunisasi = jim.id_imunisasi
	
-- start view umur balita

CREATE VIEW view_umur_balita AS
SELECT id_balita, nama_balita, tgl_lahir, id_ortu, jenis_kelamin,
       TIMESTAMPDIFF(MONTH, tgl_lahir, NOW()) AS umur
FROM balita;

DROP VIEW view_umur_balita





