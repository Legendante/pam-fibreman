CREATE TABLE IF NOT EXISTS errorlog
(
errorid INT NOT NULL AUTO_INCREMENT,
errormsg VARCHAR(200),
moreinfo VARCHAR(1000),
filename VARCHAR(200),
functionname VARCHAR(50),
linenum INT(11),
errordate DATETIME DEFAULT CURRENT_TIMESTAMP,
sessioninfo VARCHAR(1000),
PRIMARY KEY(errorid)
);

CREATE TABLE userdetails
(
userid INT NOT NULL AUTO_INCREMENT,
username VARCHAR(100),
userpass VARCHAR(100),
firstname VARCHAR(100),
surname VARCHAR(100),
dateregistered DATETIME,
lastlogin DATETIME,
lastaction DATETIME,
lastupdate DATETIME ON UPDATE CURRENT_TIMESTAMP,
customerid INT,
cellnumber VARCHAR(20),
telnumber VARCHAR(20),
inactive INT DEFAULT 0,
shoesize VARCHAR(4),
pantsize VARCHAR(4),
shirtsize VARCHAR(4),
PRIMARY KEY(userid)
);

INSERT INTO userdetails(username, userpass, firstname, surname, dateregistered, lastlogin, lastaction) VALUES ("InValid", "", "Invalid", "User", NOW(), NOW(), NOW());
INSERT INTO userdetails(username, userpass, firstname, surname, dateregistered, lastlogin, lastaction) VALUES ("test@example.com", "$2y$14$08kWizHyWQFY7LOxLU3Xm.59oFZruVjDsHHxGjjpWwJ8Ge6t0K7kq", "Test", "Example", NOW(), NOW(), NOW());

CREATE TABLE systemprivileges
(
privilegeid INT NOT NULL AUTO_INCREMENT,
privilegename VARCHAR(50),
PRIMARY KEY(privilegeid)
);

INSERT INTO systemprivileges(privilegename) VALUES ('View Splice Projects');
INSERT INTO systemprivileges(privilegename) VALUES ('Edit Splice Projects');
INSERT INTO systemprivileges(privilegename) VALUES ('In Field');
INSERT INTO systemprivileges(privilegename) VALUES ('View Clients');
INSERT INTO systemprivileges(privilegename) VALUES ('Finance');
INSERT INTO systemprivileges(privilegename) VALUES ('View Staff');
INSERT INTO systemprivileges(privilegename) VALUES ('View Users');
INSERT INTO systemprivileges(privilegename) VALUES ('Edit Users');

CREATE TABLE userprivileges
(
userid INT NOT NULL,
privilegeid INT NOT NULL
);

INSERT INTO userprivileges(userid, privilegeid) SELECT 2, privilegeid FROM systemprivileges;

CREATE TABLE publicholidays
(
holidayname VARCHAR(30),
holidaydate DATE
);

INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-01-01", "New Years Day");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-01-02", "Public Holiday");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-03-21", "Human Rights Day");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-04-14", "Good Friday");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-04-17", "Family Day");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-04-27", "Freedom Day");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-05-01", "Workers Day");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-06-16", "Youth Day");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-08-09", "National Women's Day");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-09-24", "Heritage Day");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-09-25", "Public Holiday");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-12-16", "Day of Reconciliation");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-12-25", "Christmas Day");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2017-12-26", "Day Of Goodwill");
INSERT INTO publicholidays(holidaydate, holidayname) VALUES ("2018-01-01", "New Years Day");

CREATE TABLE core_splice_project
(
id INT NOT NULL AUTO_INCREMENT,
project_name VARCHAR(50),
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
way_leave VARCHAR(50),
contractor VARCHAR(50),
proj_manager VARCHAR(50),
site_manager VARCHAR(50),
planned_start_date DATETIME,
planned_end_date DATETIME,
actual_start_date DATETIME,
actual_end_date DATETIME,
client_id INT NOT NULL,
PRIMARY KEY(id)
);

CREATE TABLE core_splice_project_costbreakdown
(
id INT NOT NULL AUTO_INCREMENT,
item_name VARCHAR(50),
item_unit VARCHAR(50),
item_cost_default DECIMAL(7,2),
PRIMARY KEY(id)
);

INSERT INTO core_splice_project_costbreakdown(item_name, item_unit, item_cost_default) VALUES ("Dome Prep", "per dome", "500");
INSERT INTO core_splice_project_costbreakdown(item_name, item_unit, item_cost_default) VALUES ("Splice", "per splice", "85");

CREATE TABLE core_splice_project_costs
(
project_id INT NOT NULL,
cost_id INT NOT NULL,
item_cost DECIMAL(7,2)
);

CREATE TABLE core_splice_sections
(
id INT NOT NULL AUTO_INCREMENT,
section_name VARCHAR(50),
project_id INT NOT NULL,
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
planned_start_date DATETIME,
planned_end_date DATETIME,
actual_start_date DATETIME,
actual_end_date DATETIME,
PRIMARY KEY(id)
);

CREATE TABLE core_splice_sections_polygon
(
id INT NOT NULL AUTO_INCREMENT,
section_id INT NOT NULL,
project_id INT NOT NULL,
point_coord_lat DECIMAL(9,6),
point_coord_lon DECIMAL(9,6),
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(id)
);

CREATE TABLE core_splice_joins
(
id INT NOT NULL AUTO_INCREMENT,
join_name VARCHAR(50),
section_id INT NOT NULL,
project_id INT NOT NULL,
join_type VARCHAR(1),
num_splices INT NOT NULL DEFAULT 0,
num_domes INT NOT NULL DEFAULT 0,
join_coord_lat DECIMAL(9,6),
join_coord_lon DECIMAL(9,6),
manhole_number VARCHAR(10),
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
planned_start_date DATETIME,
planned_end_date DATETIME,
actual_start_date DATETIME,
actual_end_date DATETIME,
address VARCHAR(255),
join_status INT DEFAULT 0,
po_number VARCHAR(15),
po_id INT DEFAULT NULL,
PRIMARY KEY(id)
);

CREATE TABLE core_splice_join_techs
(
userid INT NOT NULL,
join_id INT NOT NULL
);

CREATE TABLE core_splice_diary
(
id INT NOT NULL AUTO_INCREMENT,
theday DATE,
userid INT NOT NULL,
join_id INT NOT NULL,
section_id INT NOT NULL,
project_id INT NOT NULL,
num_splices_completed INT NOT NULL DEFAULT 0,
num_domes_completed INT NOT NULL DEFAULT 0,
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(id)
);

INSERT INTO core_splice_diary(theday, userid, join_id, section_id, project_id, num_splices_completed) VALUES ("2017-08-23", 1, 1,1,1,10);
INSERT INTO core_splice_diary(theday, userid, join_id, section_id, project_id, num_splices_completed) VALUES ("2017-08-23", 1, 2,2,1,10);
INSERT INTO core_splice_diary(theday, userid, join_id, section_id, project_id, num_splices_completed) VALUES ("2017-08-24", 1, 1,1,1,10);
INSERT INTO core_splice_diary(theday, userid, join_id, section_id, project_id, num_splices_completed) VALUES ("2017-08-24", 1, 2,2,1,10);
INSERT INTO core_splice_diary(theday, userid, join_id, section_id, project_id, num_splices_completed) VALUES ("2017-08-25", 1, 1,1,1,10);
INSERT INTO core_splice_diary(theday, userid, join_id, section_id, project_id, num_splices_completed) VALUES ("2017-08-25", 1, 2,2,1,10);
INSERT INTO core_splice_diary(theday, userid, join_id, section_id, project_id, num_splices_completed) VALUES ("2017-08-26", 1, 1,1,1,10);
INSERT INTO core_splice_diary(theday, userid, join_id, section_id, project_id, num_splices_completed) VALUES ("2017-08-26", 1, 2,2,1,10);


CREATE TABLE core_splice_check_groups
(
id INT NOT NULL AUTO_INCREMENT,
group_name VARCHAR(30),
group_order INT,
PRIMARY KEY(id)
);

CREATE TABLE core_splice_checks
(
id INT NOT NULL AUTO_INCREMENT,
group_id INT NOT NULL,
check_name VARCHAR(50),
check_description VARCHAR(255),
check_order INT,
PRIMARY KEY(id)
);

INSERT INTO core_splice_check_groups(group_name, group_order) VALUES ("Arrival on site", 1);
SET @GroupID := LAST_INSERT_ID();
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Surroundings", 1);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Closed manhole", 2);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Open manhole", 3);

INSERT INTO core_splice_check_groups(group_name, group_order) VALUES ("Dome prep completed - internal", 2);
SET @GroupID := LAST_INSERT_ID();
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Oval cable port", 1);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Strength member fix point", 2);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Round cable port", 3);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Kevlar binding fix point", 4);

INSERT INTO core_splice_check_groups(group_name, group_order) VALUES ("Splicing completed", 2);
SET @GroupID := LAST_INSERT_ID();
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Trays", 1);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Spare fibre coiling tray", 2);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Spare fibre coiling - back", 3);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Spare fibre coiling tray cover", 4);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Splicing tray cover", 5);

INSERT INTO core_splice_check_groups(group_name, group_order) VALUES ("Dome completed", 2);
SET @GroupID := LAST_INSERT_ID();
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Oval cable port seal", 1);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Round cable port seal", 2);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Labeled", 3);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Cables taped", 4);

INSERT INTO core_splice_check_groups(group_name, group_order) VALUES ("Departing site", 3);
SET @GroupID := LAST_INSERT_ID();
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Dome holder clipped", 1);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Open manhole", 2);
INSERT INTO core_splice_checks(group_id, check_name, check_order) VALUES (@GroupID, "Closed manhole", 3);

CREATE TABLE core_splice_join_photos
(
id int(11) NOT NULL AUTO_INCREMENT,
userid INT NOT NULL,
join_id INT NOT NULL,
check_id INT,
photopath varchar(255) NOT NULL,
takendate DATETIME DEFAULT CURRENT_TIMESTAMP,
thumbnail VARCHAR(255),
lat DECIMAL(9,6),
lon DECIMAL(9,6),
acc INT,
PRIMARY KEY (id)
);

CREATE TABLE core_splice_join_photonotes
(
id INT NOT NULL AUTO_INCREMENT,
photoid INT NOT NULL,
noteval VARCHAR(1000),
PRIMARY KEY (id)
);

CREATE TABLE manhole_points
(
id INT NOT NULL AUTO_INCREMENT,
join_name VARCHAR(50),
join_coord_lat DECIMAL(9,6),
join_coord_lon DECIMAL(9,6),
manhole_number VARCHAR(10),
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
address VARCHAR(255),
PRIMARY KEY(id)
);

CREATE TABLE dome_types
(
id INT NOT NULL AUTO_INCREMENT,
typename VARCHAR(50),
numtrays INT,
numsplices INT,
PRIMARY KEY(id)
);

INSERT INTO dome_types(typename) VALUES ("MMJ");
INSERT INTO dome_types(typename) VALUES ("FOSC 400");

CREATE TABLE manhole_domes
(
id INT NOT NULL AUTO_INCREMENT,
manhole_id INT NOT NULL,
dome_id INT NOT NULL,
PRIMARY KEY(id)
);

CREATE TABLE staff_details
(
id INT NOT NULL AUTO_INCREMENT,
firstname VARCHAR(100),
surname VARCHAR(100),
knownas VARCHAR(100),
idnumber VARCHAR(50),
birthday DATE,
cellnumber VARCHAR(30),
homenumber VARCHAR(30),
email VARCHAR(100),
passportnum VARCHAR(50),
taxnumber VARCHAR(30),
address1 VARCHAR(100),
address2 VARCHAR(100),
address3 VARCHAR(100),
address4 VARCHAR(100),
address5 VARCHAR(100),
address6 VARCHAR(100),
bankname VARCHAR(30),
bankaccnum VARCHAR(30),
bankbranchcode VARCHAR(10),
bankbranch VARCHAR(30),
salary DECIMAL(9,2),
startdate DATE,
dateregistered DATETIME,
lastupdate DATETIME ON UPDATE CURRENT_TIMESTAMP,
inactive INT DEFAULT 0,
shoesize VARCHAR(4),
pantsize VARCHAR(4),
shirtsize VARCHAR(4),
PRIMARY KEY(id)
);

CREATE TABLE staff_filetypes
(
id INT NOT NULL AUTO_INCREMENT,
typename VARCHAR(30),
sortorder INT DEFAULT 0,
PRIMARY KEY(id)
);

INSERT INTO staff_filetypes(typename, sortorder) VALUES ("ID", 1);
INSERT INTO staff_filetypes(typename, sortorder) VALUES ("Drivers", 2);
INSERT INTO staff_filetypes(typename, sortorder) VALUES ("Medical certificate", 3);
INSERT INTO staff_filetypes(typename, sortorder) VALUES ("Fire safety certificate", 4);

CREATE TABLE staff_files
(
id INT NOT NULL AUTO_INCREMENT,
staff_id INT NOT NULL,
filetype_id INT NOT NULL,
filename VARCHAR(100),
filepath VARCHAR(255),
expiry_date DATE DEFAULT NULL,
creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(id)
);

CREATE TABLE boq_units
(
id INT NOT NULL AUTO_INCREMENT,
unit_name VARCHAR(100),
unit_short VARCHAR(10),
PRIMARY KEY(id)
);

INSERT INTO boq_units(unit_name, unit_short) VALUES ("Each", "ea"); -- 1
INSERT INTO boq_units(unit_name, unit_short) VALUES ("Kilometers", "KM"); -- 2
INSERT INTO boq_units(unit_name, unit_short) VALUES ("Meters", "M"); -- 3
INSERT INTO boq_units(unit_name, unit_short) VALUES ("per 100m", "p/100m"); -- 4
INSERT INTO boq_units(unit_name, unit_short) VALUES ("Per fibre", "p/fibre"); -- 5
INSERT INTO boq_units(unit_name, unit_short) VALUES ("Per splice", "p/splice"); -- 6
INSERT INTO boq_units(unit_name, unit_short) VALUES ("Per label", "p/label"); -- 7
INSERT INTO boq_units(unit_name, unit_short) VALUES ("Per unit", "p/unit"); -- 8
INSERT INTO boq_units(unit_name, unit_short) VALUES ("Per site", "p/site"); -- 9

CREATE TABLE boq_items
(
id INT NOT NULL AUTO_INCREMENT,
item_name VARCHAR(100),
unit_id INT NOT NULL,
default_cost DECIMAL(7,2),
PRIMARY KEY(id)
);

CREATE TABLE boq_categories
(
id INT NOT NULL AUTO_INCREMENT,
category_name VARCHAR(100),
PRIMARY KEY(id)
);

INSERT INTO boq_categories(category_name) VALUES ("Dome Joint");
INSERT INTO boq_categories(category_name) VALUES ("Terminations - Street Cabinet");
INSERT INTO boq_categories(category_name) VALUES ("Terminations - POP");
INSERT INTO boq_categories(category_name) VALUES ("Terminations - Business");
INSERT INTO boq_categories(category_name) VALUES ("Fibre Build");
INSERT INTO boq_categories(category_name) VALUES ("Aerial");
INSERT INTO boq_categories(category_name) VALUES ("Re Tractanet");
INSERT INTO boq_categories(category_name) VALUES ("Wall Mount");
INSERT INTO boq_categories(category_name) VALUES ("Site Establishment");
INSERT INTO boq_categories(category_name) VALUES ("Camera Build");

