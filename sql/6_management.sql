CREATE TABLE IF NOT EXISTS departments 
(
departmentid INT NOT NULL AUTO_INCREMENT,
departmentname VARCHAR(50) DEFAULT NULL,
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (departmentid)
);

INSERT INTO departments(departmentname) VALUES ("Engineering");
INSERT INTO departments(departmentname) VALUES ("Maintenance - Core");
INSERT INTO departments(departmentname) VALUES ("Maintenance - FTTH");
INSERT INTO departments(departmentname) VALUES ("Floating");
INSERT INTO departments(departmentname) VALUES ("Access Builds");
INSERT INTO departments(departmentname) VALUES ("New Developments");

CREATE TABLE projects
(
id INT NOT NULL AUTO_INCREMENT,
project_name VARCHAR(50),
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
planned_start_date DATE,
planned_end_date DATE,
actual_start_date DATE,
actual_end_date DATE,
client_id INT NOT NULL,
status_id INT NOT NULL DEFAULT 0,
PRIMARY KEY(id)
);

CREATE TABLE project_sections
(
id INT NOT NULL AUTO_INCREMENT,
section_name VARCHAR(50),
project_id INT NOT NULL,
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(id)
);

CREATE TABLE project_tasks
(
id INT NOT NULL AUTO_INCREMENT,
task_name VARCHAR(50),
client_id INT,
section_id INT,
project_id INT,
department_id INT,
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
planned_start_date DATE,
planned_end_date DATE,
actual_start_date DATE,
actual_end_date DATE,
task_status INT DEFAULT 0,
po_id INT DEFAULT NULL,
PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS project_task_boqitems
(
id INT NOT NULL AUTO_INCREMENT,
task_id INT NOT NULL,
item_id INT NOT NULL,
estimated INT,
completed INT,
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS project_task_boqitems_log
(
id INT NOT NULL AUTO_INCREMENT,
task_id INT NOT NULL,
item_id INT NOT NULL,
estimated INT,
completed INT,
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
userid INT NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE task_status
(
id INT NOT NULL AUTO_INCREMENT,
status_name VARCHAR(50),
status_rating INT NOT NULL DEFAULT 0,
quotable INT NOT NULL DEFAULT 1,
PRIMARY KEY(id)
);

INSERT INTO task_status(status_name, status_rating) VALUES ("In Process", 0);
INSERT INTO task_status(status_name, status_rating) VALUES ("To be tested", 1);
INSERT INTO task_status(status_name, status_rating) VALUES ("To be invoiced", 1);
INSERT INTO task_status(status_name, status_rating, quotable) VALUES ("Invoiced", 2, 0);
INSERT INTO task_status(status_name, status_rating) VALUES ("Completed Externally", 3);
INSERT INTO task_status(status_name, status_rating) VALUES ("Problematic", 4);

CREATE TABLE task_file_types
(
id INT NOT NULL AUTO_INCREMENT,
type_name VARCHAR(50),
has_thumbnail INT DEFAULT 0,
PRIMARY KEY(id)
);

INSERT INTO task_file_types(type_name, has_thumbnail) VALUES ("Photos", 1);
INSERT INTO task_file_types(type_name) VALUES ("Splicing Instructions");
INSERT INTO task_file_types(type_name) VALUES ("Floating Instructions");
INSERT INTO task_file_types(type_name) VALUES ("Site Plan");
INSERT INTO task_file_types(type_name) VALUES ("Redline");

CREATE TABLE task_check_groups
(
id INT NOT NULL AUTO_INCREMENT,
group_name VARCHAR(30),
group_order INT,
type_id INT NOT NULL,
PRIMARY KEY(id)
);

CREATE TABLE task_checks
(
id INT NOT NULL AUTO_INCREMENT,
group_id INT NOT NULL,
check_name VARCHAR(50),
check_description VARCHAR(255),
check_order INT,
PRIMARY KEY(id)
);

INSERT INTO task_check_groups(group_name, group_order, type_id) VALUES ("Arrival on site", 1, 1);
SET @GroupID := LAST_INSERT_ID();
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Surroundings", 1);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Closed manhole", 2);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Open manhole", 3);

INSERT INTO task_check_groups(group_name, group_order, type_id) VALUES ("Dome prep completed - internal", 2, 1);
SET @GroupID := LAST_INSERT_ID();
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Oval cable port", 1);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Strength member fix point", 2);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Round cable port", 3);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Kevlar binding fix point", 4);

INSERT INTO task_check_groups(group_name, group_order, type_id) VALUES ("Splicing completed", 2, 1);
SET @GroupID := LAST_INSERT_ID();
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Trays", 1);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Spare fibre coiling tray", 2);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Spare fibre coiling - back", 3);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Spare fibre coiling tray cover", 4);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Splicing tray cover", 5);

INSERT INTO task_check_groups(group_name, group_order, type_id) VALUES ("Dome completed", 2, 1);
SET @GroupID := LAST_INSERT_ID();
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Oval cable port seal", 1);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Round cable port seal", 2);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Labeled", 3);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Cables taped", 4);

INSERT INTO task_check_groups(group_name, group_order, type_id) VALUES ("Departing site", 3, 1);
SET @GroupID := LAST_INSERT_ID();
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Dome holder clipped", 1);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Open manhole", 2);
INSERT INTO task_checks(group_id, check_name, check_order) VALUES (@GroupID, "Closed manhole", 3);

CREATE TABLE task_files
(
id int(11) NOT NULL AUTO_INCREMENT,
userid INT NOT NULL,
task_id INT NOT NULL,
check_id INT,
type_id INT NOT NULL,
filepath varchar(255) NOT NULL,
takendate DATETIME DEFAULT CURRENT_TIMESTAMP,
thumbnail VARCHAR(255),
lat DECIMAL(9,6),
lon DECIMAL(9,6),
acc INT,
PRIMARY KEY (id)
);

CREATE TABLE task_filenotes
(
id INT NOT NULL AUTO_INCREMENT,
fileid INT NOT NULL,
noteval VARCHAR(1000),
PRIMARY KEY (id)
);

CREATE TABLE task_notes
(
id INT NOT NULL AUTO_INCREMENT,
taskid INT NOT NULL,
userid INT NOT NULL,
creationdate DATETIME DEFAULT CURRENT_TIMESTAMP,
noteval VARCHAR(1000),
PRIMARY KEY (id)
);
