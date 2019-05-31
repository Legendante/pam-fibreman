CREATE TABLE cost_centre
(
id INT NOT NULL AUTO_INCREMENT,
centrename VARCHAR(50),
PRIMARY KEY (id)
);

INSERT INTO cost_centre(centrename) VALUES ("Machinery");
INSERT INTO cost_centre(centrename) VALUES ("Petrol");
INSERT INTO cost_centre(centrename) VALUES ("Stationary");
INSERT INTO cost_centre(centrename) VALUES ("Tools");
INSERT INTO cost_centre(centrename) VALUES ("Entertainment");
INSERT INTO cost_centre(centrename) VALUES ("Medical");
INSERT INTO cost_centre(centrename) VALUES ("Cellphone");
INSERT INTO cost_centre(centrename) VALUES ("Data");

CREATE TABLE supplier
(
id INT NOT NULL AUTO_INCREMENT,
suppliername VARCHAR(50),
supplierbalance DECIMAL(10,2),
costcentre_id INT,
PRIMARY KEY (id)
);

INSERT INTO supplier(suppliername, supplierbalance, costcentre_id) VALUES ("Petrol", "0.00", 2);
INSERT INTO supplier(suppliername, supplierbalance, costcentre_id) VALUES ("Lambda Test Equipment", "0.00", 1);
INSERT INTO supplier(suppliername, supplierbalance, costcentre_id) VALUES ("Stationary", "0.00", 3);
INSERT INTO supplier(suppliername, supplierbalance, costcentre_id) VALUES ("Tools", "0.00", 4);
INSERT INTO supplier(suppliername, supplierbalance, costcentre_id) VALUES ("Entertainment", "0.00", 5);


CREATE TABLE accounts
(
id INT NOT NULL AUTO_INCREMENT,
accountname VARCHAR(50),
accountbalance DECIMAL(10,2),
accounttype INT NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE account_types
(
id INT NOT NULL AUTO_INCREMENT,
typename VARCHAR(50),
PRIMARY KEY (id)
);

INSERT INTO account_types(typename) VALUES ("Bank");
INSERT INTO account_types(typename) VALUES ("Loan");

INSERT INTO accounts(accountname, accountbalance, accounttype) VALUES ("FNB Cheque", "0.00", 1);
INSERT INTO accounts(accountname, accountbalance, accounttype) VALUES ("FNB Stash", "0.00", 1);
INSERT INTO accounts(accountname, accountbalance, accounttype) VALUES ("Dale", "0.00", 2);
INSERT INTO accounts(accountname, accountbalance, accounttype) VALUES ("Jacques", "0.00", 2);
INSERT INTO accounts(accountname, accountbalance, accounttype) VALUES ("Gareth", "0.00", 2);
INSERT INTO accounts(accountname, accountbalance, accounttype) VALUES ("Paul", "0.00", 2);
INSERT INTO accounts(accountname, accountbalance, accounttype) VALUES ("Malcolm", "0.00", 2);
INSERT INTO accounts(accountname, accountbalance, accounttype) VALUES ("Basil", "0.00", 2);
INSERT INTO accounts(accountname, accountbalance, accounttype) VALUES ("Venda", "0.00", 2);
INSERT INTO accounts(accountname, accountbalance, accounttype) VALUES ("Titi", "0.00", 2);
INSERT INTO accounts(accountname, accountbalance, accounttype) VALUES ("Thursday", "0.00", 2);

CREATE TABLE accounts_log
(
from_id INT,
to_id INT,
invoice_id INT,
expense_id INT,
amount DECIMAL(10,2),
transdate DATE,
logtime DATETIME DEFAULT CURRENT_TIMESTAMP,
userid INT NOT NULL,
description VARCHAR(255)
);

CREATE TABLE expenses
(
id INT NOT NULL AUTO_INCREMENT,
supplier_id INT,
expensesubtotal DECIMAL(10,2),
expensevattotal DECIMAL(10,2),
expensetotal DECIMAL(10,2),
transdate DATE,
logtime DATETIME DEFAULT CURRENT_TIMESTAMP,
exp_status INT DEFAULT 0,
file_path VARCHAR(255),
cost_centre_id INT NOT NULL,
userid INT NOT NULL,
description VARCHAR(255),
PRIMARY KEY (id)
);

CREATE TABLE client_details
(
id INT NOT NULL AUTO_INCREMENT,
clientname VARCHAR(50),
client_short VARCHAR(10),
client_balance DECIMAL(10,2),
client_vat VARCHAR(20),
client_reg varchar(20) DEFAULT NULL,
client_address VARCHAR(200),
client_tel VARCHAR(30),
client_email VARCHAR(100),
PRIMARY KEY (id)
);

INSERT INTO client_details(clientname, client_short, client_balance, client_vat, client_reg, client_address, client_tel, client_email) VALUES ("Metrofibre Networks", "MFN", "0", "4540241066", "2007/024366/07", "Old Pretoria Road, Corporate Park North, 82 Roan Crescent, Midrand, 1685", "0871514000", "");

CREATE TABLE client_balances
(
client_id INT NOT NULL,
balance_date DATETIME DEFAULT CURRENT_TIMESTAMP,
balance_total DECIMAL(10,2)
);

INSERT INTO client_balances(client_id, balance_total, balance_date) SELECT id, "0", "2017-09-01" from client_details;

CREATE TABLE client_invoices
(
id INT NOT NULL AUTO_INCREMENT,
client_id INT,
inv_number INT NOT NULL DEFAULT 1,
invoicesubtotal DECIMAL(10,2),
invoicevattotal DECIMAL(10,2),
invoicetotal DECIMAL(10,2),
cittotal DECIMAL(10,2),
logtime DATETIME DEFAULT CURRENT_TIMESTAMP,
inv_status INT DEFAULT 0,
file_path VARCHAR(255),
inv_name VARCHAR(100),
PRIMARY KEY (id)
);

CREATE TABLE client_statements
(
id INT NOT NULL AUTO_INCREMENT,
client_id INT,
statement_number INT NOT NULL DEFAULT 1,
startdate DATE,
enddate DATE,
logtime DATETIME DEFAULT CURRENT_TIMESTAMP,
file_path VARCHAR(255),
PRIMARY KEY (id)
);

INSERT INTO client_statements(client_id, statement_number) VALUES (1, 1);

CREATE TABLE invoice_items
(
invoice_id INT NOT NULL,
join_id INT NOT NULL,
section_id INT NOT NULL,
project_id INT NOT NULL,
itemtotal DECIMAL(10,2)
);

CREATE TABLE client_quotes
(
id INT NOT NULL AUTO_INCREMENT,
client_id INT,
quote_number INT NOT NULL DEFAULT 1,
quote_subtotal DECIMAL(10,2),
quote_vattotal DECIMAL(10,2),
quote_total DECIMAL(10,2),
logtime DATETIME DEFAULT CURRENT_TIMESTAMP,
quote_status INT DEFAULT 0,
file_path VARCHAR(255),
quote_name varchar(100),
PRIMARY KEY (id)
);

CREATE TABLE quote_items
(
quote_id INT NOT NULL,
join_id INT NOT NULL,
section_id INT NOT NULL,
project_id INT NOT NULL
);

CREATE TABLE client_purchase_orders
(
id INT NOT NULL AUTO_INCREMENT,
client_id INT,
po_number INT NOT NULL DEFAULT 1,
po_subtotal DECIMAL(10,2),
po_vattotal DECIMAL(10,2),
po_total DECIMAL(10,2),
logtime DATETIME DEFAULT CURRENT_TIMESTAMP,
po_status INT DEFAULT 0,
file_path VARCHAR(255),
PRIMARY KEY (id)
);
