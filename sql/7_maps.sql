CREATE TABLE mapdetails
(
id INT NOT NULL AUTO_INCREMENT,
map_name VARCHAR(50),
sort_order INT,
PRIMARY KEY(id)
);

CREATE TABLE mappointstypes
(
id INT NOT NULL AUTO_INCREMENT,
type_name VARCHAR(50),
sort_order INT,
PRIMARY KEY(id)
);

INSERT INTO mappointstypes(type_name, sort_order) VALUES ("Manhole - Through", 1);
INSERT INTO mappointstypes(type_name, sort_order) VALUES ("Manhole - Dome", 2);
INSERT INTO mappointstypes(type_name, sort_order) VALUES ("Street Cabinet", 3);
INSERT INTO mappointstypes(type_name, sort_order) VALUES ("POP", 4);
INSERT INTO mappointstypes(type_name, sort_order) VALUES ("Complex", 5);
INSERT INTO mappointstypes(type_name, sort_order) VALUES ("Data Centre", 6);

CREATE TABLE mappoints
(
id INT NOT NULL AUTO_INCREMENT,
point_name VARCHAR(50),
type_id INT NOT NULL,
map_id INT NOT NULL,
lat DECIMAL(9,6),
lon DECIMAL(9,6),
acc INT,
PRIMARY KEY(id)
);

CREATE TABLE mapdatafields
(
id INT NOT NULL AUTO_INCREMENT,
field_name VARCHAR(50),
sort_order INT,
PRIMARY KEY(id)
);

INSERT INTO mapdatafields(field_name, sort_order) VALUES ('Num Cables', 1);
INSERT INTO mapdatafields(field_name, sort_order) VALUES ('Slack - Line 1', 2);
INSERT INTO mapdatafields(field_name, sort_order) VALUES ('Slack - Line 2', 3);
INSERT INTO mapdatafields(field_name, sort_order) VALUES ('Slack - Line 3', 4);
INSERT INTO mapdatafields(field_name, sort_order) VALUES ('Slack - Line 4', 5);
INSERT INTO mapdatafields(field_name, sort_order) VALUES ('Manhole size', 6);
INSERT INTO mapdatafields(field_name, sort_order) VALUES ('Dome Type', 7);

CREATE TABLE mapdatatypefields
(
id INT NOT NULL AUTO_INCREMENT,
type_id INT NOT NULL,
field_id INT NOT NULL,
PRIMARY KEY(id)
);

INSERT INTO mapdatatypefields(type_id, field_id) VALUES (1,2);
INSERT INTO mapdatatypefields(type_id, field_id) VALUES (1,6);
INSERT INTO mapdatatypefields(type_id, field_id) VALUES (2,1);
INSERT INTO mapdatatypefields(type_id, field_id) VALUES (2,2);
INSERT INTO mapdatatypefields(type_id, field_id) VALUES (2,3);
INSERT INTO mapdatatypefields(type_id, field_id) VALUES (2,4);
INSERT INTO mapdatatypefields(type_id, field_id) VALUES (2,5);
INSERT INTO mapdatatypefields(type_id, field_id) VALUES (2,6);
INSERT INTO mapdatatypefields(type_id, field_id) VALUES (2,7);
INSERT INTO mapdatatypefields(type_id, field_id) VALUES (3,1);
INSERT INTO mapdatatypefields(type_id, field_id) VALUES (4,1);
INSERT INTO mapdatatypefields(type_id, field_id) VALUES (6,1);

CREATE TABLE mappointsdata
(
id INT NOT NULL AUTO_INCREMENT,
point_id INT NOT NULL,
field_id INT NOT NULL,
data_val VARCHAR(50),
PRIMARY KEY(id)
);