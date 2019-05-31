CREATE TABLE IF NOT EXISTS complexdetails 
(
complexid INT(11) NOT NULL AUTO_INCREMENT,
complexname VARCHAR(100),
numunits INT(11) DEFAULT 1,
shortcode VARCHAR(10),
complexaddress1 VARCHAR(50),
complexaddress2 VARCHAR(50),
complexaddress3 VARCHAR(50),
complexaddress4 VARCHAR(50),
complexaddress5 VARCHAR(50),
complexstatus INT(11) NOT NULL DEFAULT 0,
dateregistered DATETIME DEFAULT CURRENT_TIMESTAMP,
clientid INT(11),
lat DECIMAL(9,6),
lon DECIMAL(9,6),
PRIMARY KEY (complexid)
);

CREATE TABLE complexfiles
(
id int(11) NOT NULL AUTO_INCREMENT,
userid INT NOT NULL,
complex_id INT NOT NULL,
filename varchar(255) NOT NULL,
filepath varchar(255) NOT NULL,
takendate DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS complexunits 
(
unitid INT(11) NOT NULL AUTO_INCREMENT,
complexid INT(11) NOT NULL,
unitname VARCHAR(100),
firstname VARCHAR(50),
lastname VARCHAR(50),
email VARCHAR(100),
cell VARCHAR(30),
tel VARCHAR(30),
altfirstname VARCHAR(50),
altlastname VARCHAR(50),
altemail VARCHAR(100),
altcell VARCHAR(30),
alttel VARCHAR(30),
fsannum VARCHAR(30),
PRIMARY KEY (unitid)
);