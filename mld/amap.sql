CREATE TABLE person(
   id_person INT AUTO_INCREMENT,
   firstname VARCHAR(50),
   lastname VARCHAR(50),
   email VARCHAR(50),
   password VARCHAR(50),
   PRIMARY KEY(id_person)
);

CREATE TABLE quarter(
   id_quarter INT AUTO_INCREMENT,
   name_quarter VARCHAR(50),
   start_date DATETIME,
   end_date VARCHAR(50),
   PRIMARY KEY(id_quarter)
);

CREATE TABLE amap_user(
   id_amap_user INT AUTO_INCREMENT,
   id_person INT NOT NULL,
   PRIMARY KEY(id_amap_user),
   UNIQUE(id_person),
   FOREIGN KEY(id_person) REFERENCES person(id_person)
);

CREATE TABLE producer(
   id_producer INT AUTO_INCREMENT,
   producer_name VARCHAR(50),
   id_person INT NOT NULL,
   PRIMARY KEY(id_producer),
   UNIQUE(id_person),
   FOREIGN KEY(id_person) REFERENCES person(id_person)
);

CREATE TABLE distribution(
   id_distribution INT AUTO_INCREMENT,
   address VARCHAR(50),
   id_quarter INT NOT NULL,
   PRIMARY KEY(id_distribution),
   FOREIGN KEY(id_quarter) REFERENCES quarter(id_quarter)
);

CREATE TABLE product(
   id_product INT AUTO_INCREMENT,
   product_name VARCHAR(50),
   id_producer INT NOT NULL,
   PRIMARY KEY(id_product),
   FOREIGN KEY(id_producer) REFERENCES producer(id_producer)
);

CREATE TABLE commitment(
   id_commitment INT AUTO_INCREMENT,
   quantity_commitment INT,
   price_commitment INT,
   id_quarter INT NOT NULL,
   id_product INT NOT NULL,
   PRIMARY KEY(id_commitment),
   FOREIGN KEY(id_quarter) REFERENCES quarter(id_quarter),
   FOREIGN KEY(id_product) REFERENCES product(id_product)
);

CREATE TABLE manage(
   id_amap_user INT,
   id_producer INT,
   PRIMARY KEY(id_amap_user, id_producer),
   FOREIGN KEY(id_amap_user) REFERENCES amap_user(id_amap_user),
   FOREIGN KEY(id_producer) REFERENCES producer(id_producer)
);

CREATE TABLE subscribe(
   id_amap_user INT,
   id_commitment INT,
   payment BOOLEAN,
   quantity VARCHAR(50),
   PRIMARY KEY(id_amap_user, id_commitment),
   FOREIGN KEY(id_amap_user) REFERENCES amap_user(id_amap_user),
   FOREIGN KEY(id_commitment) REFERENCES commitment(id_commitment)
);
