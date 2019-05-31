CREATE TABLE clientuserdetails
(
userid INT NOT NULL AUTO_INCREMENT,
username VARCHAR(100),
userpass VARCHAR(100),
firstname VARCHAR(100),
surname VARCHAR(100),
dateregistered DATETIME DEFAULT CURRENT_TIMESTAMP,
lastlogin DATETIME,
lastaction DATETIME,
lastupdate DATETIME ON UPDATE CURRENT_TIMESTAMP,
customerid INT,
cellnumber VARCHAR(20),
telnumber VARCHAR(20),
inactive INT DEFAULT 0,
PRIMARY KEY(userid)
);

CREATE TABLE clientuserdepartments
(
userid INT NOT NULL,
departmentid INT NOT NULL
);