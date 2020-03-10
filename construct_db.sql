CREATE DATABASE familyho_db CHARACTER SET utf8 COLLATE utf8_spanish_ci;

CREATE TABLE level_access (
	id_level_access INTEGER AUTO_INCREMENT,
	level_access_name VARCHAR(32),
	CONSTRAINT pk_level_access PRIMARY KEY (id_level_access)
) ENGINE=INNODB;

CREATE TABLE system_config (
	contact_email VARCHAR(128) NOT NULL UNIQUE,
	background_image_url VARCHAR(128) NOT NULL UNIQUE
) ENGINE=INNODB;

CREATE TABLE carrousel_images (
	id_image INTEGER AUTO_INCREMENT,
	image_url VARCHAR(256) NOT NULL,
	image_title VARCHAR(128) NOT NULL,
	image_subtitle VARCHAR(128),
	image_show BOOLEAN NOT NULL DEFAULT TRUE,
	CONSTRAINT pk_carrousel_images PRIMARY KEY (id_image)
) ENGINE=INNODB;

CREATE TABLE user (
	id_user INTEGER AUTO_INCREMENT,
	username VARCHAR(128) NOT NULL,
	email_access VARCHAR(128) NOT NULL UNIQUE,
	pass_hash VARCHAR(255) NOT NULL,
	id_level_access INTEGER NOT NULL,
	CONSTRAINT pk_user PRIMARY KEY (id_user),
	CONSTRAINT fk_level_access_user FOREIGN KEY (id_level_access) REFERENCES level_access(id_level_access)
) ENGINE=INNODB;

CREATE TABLE promotion (
	id_promotion INTEGER AUTO_INCREMENT,
	promotion_title VARCHAR(64) NOT NULL,
	promotion_content TEXT NOT NULL,
	promotion_reg_day DATE NOT NULL,
	promotion_start_day DATE,
	promotion_end_day DATE,
	promotion_created_by INTEGER,
	CONSTRAINT pk_promotion PRIMARY KEY (id_promotion),
	CONSTRAINT fk_promotion_created_by FOREIGN KEY (promotion_created_by) REFERENCES user(id_user)
) ENGINE=INNODB;

CREATE TABLE site_configuration (
	phone_contact_1 VARCHAR(32),
	phone_contact_2 VARCHAR(32),
	email_contact VARCHAR(64),
	contact_form_enable BOOLEAN NOT NULL DEFAULT TRUE,
	email_form_destination VARCHAR(64) NOT NULL
) ENGINE=INNODB;

INSERT INTO site_configuration (phone_contact_1, phone_contact_2, email_contact, contact_form_enable, email_form_destination) 
VALUES ("+00 0 0000 0000","+00 0 0000 0000","example@example.com",TRUE,"example@example.com");

INSERT INTO level_access (id_level_access, level_access_name) VALUES (1, "Administrador");
INSERT INTO level_access (id_level_access, level_access_name) VALUES (2, "Usuario");

INSERT INTO system_config (contact_email,background_image_url) VALUES ("example@example.com","/assets/images/bg/background.png");

INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('1.jpg','','',1);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('2.jpg','','',2);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('3.jpg','','',3);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('4.jpg','','',4);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('5.jpg','','',5);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('6.jpg','','',6);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('7.jpg','','',7);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('8.jpg','','',8);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('9.jpg','','',9);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('10.jpg','','',10);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('11.jpg','','',11);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('12.jpg','','',12);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('13.jpg','','',13);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('14.jpg','','',14);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('15.jpg','','',15);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('16.jpg','','',16);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('17.jpg','','',17);
INSERT INTO carrousel_images (image_url,image_title,image_subtitle,image_show) VALUES ('18.jpg','','',18);

-- Password: Sp7Lz6d3b0
INSERT INTO user (id_user, username, email_access, pass_hash, id_level_access) VALUES (1, "Administrador", "admin@admin.com","$2y$13$oWeHRz8fB4GeajOWn3u73OuvlgikUYm9NS1cvALdWex.YOjyN7nwm", 1);