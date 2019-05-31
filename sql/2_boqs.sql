CREATE TABLE IF NOT EXISTS boqtaskunits 
(
unitid INT NOT NULL AUTO_INCREMENT,
unitname VARCHAR(50) DEFAULT NULL,
PRIMARY KEY (unitid)
);

INSERT INTO boqtaskunits(unitname) VALUES ("Meters");
INSERT INTO boqtaskunits(unitname) VALUES ("Each");
INSERT INTO boqtaskunits(unitname) VALUES ("Per fibre");
INSERT INTO boqtaskunits(unitname) VALUES ("Per splice");
INSERT INTO boqtaskunits(unitname) VALUES ("Per label");
INSERT INTO boqtaskunits(unitname) VALUES ("Kilometers");
INSERT INTO boqtaskunits(unitname) VALUES ("Per 100m");
INSERT INTO boqtaskunits(unitname) VALUES ("Per unit");
INSERT INTO boqtaskunits(unitname) VALUES ("Per site");
INSERT INTO boqtaskunits(unitname) VALUES ("Per wayleave");

CREATE TABLE boqcategories
(
categoryid INT NOT NULL AUTO_INCREMENT,
categoryname VARCHAR(100),
sortorder INT NOT NULL,
PRIMARY KEY (categoryid)
);

INSERT INTO boqcategories(categoryname, sortorder) VALUES ("Engineering", 1);
INSERT INTO boqcategories(categoryname, sortorder) VALUES ("Osp Summary", 2);
INSERT INTO boqcategories(categoryname, sortorder) VALUES ("Fibre Build", 3);
INSERT INTO boqcategories(categoryname, sortorder) VALUES ("Aerial", 4);
INSERT INTO boqcategories(categoryname, sortorder) VALUES ("Re Tractanet", 5);
INSERT INTO boqcategories(categoryname, sortorder) VALUES ("Wall Mount", 6);
INSERT INTO boqcategories(categoryname, sortorder) VALUES ("Site Establishment", 7);
INSERT INTO boqcategories(categoryname, sortorder) VALUES ("Camera Build", 8);

CREATE TABLE boqlineitems
(
itemid INT NOT NULL AUTO_INCREMENT,
item_name VARCHAR(100),
unitid INT NOT NULL,
categoryid INT NOT NULL,
defaultcost DECIMAL(8,2),
PRIMARY KEY (itemid)
);

CREATE TABLE IF NOT EXISTS boqlineitems_costing
(
client_item_id INT NOT NULL AUTO_INCREMENT,
item_id INT NOT NULL,
client_id INT NOT NULL,
cost DECIMAL(8,2),
PRIMARY KEY (client_item_id)
);


INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Splices", 4, "85", 1);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Dome preparation", 2, "500", 1);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Cabinet preparation", 2, "500", 1);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("POP preparation", 2, "500", 1);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Collect Material(fixed @ 250km)", 6, "5.12", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Trench_Soil 500mm (incl reinstatement)", 1, "140", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Trench_Pav 500mm (incl reinstatement)", 1, "170", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Road Crossing_HDD Drill Including Sleeve(110mm)", 1, "800", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Road Crossing 130mm Bullet Including 110mm sleeve", 1, "365", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("DrawBox Installation 600x600x600", 2, "1 050", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Handhole_Standard (Installation only)", 2, "2 000", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Supply & Install 12 way Duct", 1, "30", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Supply & Install 7 way Duct", 1, "39", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Supply & Install 4 way Duct", 1, "24", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Supply & Install 2 way Duct", 1, "18", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Supply & Install 110mm Sleeves", 1, "25.50", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Material Handling", 1, "5", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Unit Install Fee", 2, "500", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("New Conduit Build towards Unit 0-20m", 2, "290", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("New Conduit Build towards Unit 20-40m", 2, "580", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Unit Install Fee_Multi Dwelling", 2, "300", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Street Cabinet (plus install)", 2, "5 000", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Fault Finding on existing infrastructure", 7, "1 500", 2);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Fibre Drop Cable FTTH Handling", 1, "2.50", 3);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Fibre Splicing_Fusion + OTDR Test+Power Meter Test", 2, "100", 3);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Fibre Floating_72F", 1, "5", 3);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Installation of Termination  Box", 2, "50", 3);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Preparation of FTTH Dome", 2, "350", 3);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Preparation & Install of Distribution Box", 2, "500", 3);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Supply & install steel pipe galvanised 50mm against building/Wall For Optibox(1.5m)", 2, "154", 3);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Supply & install steel pipe galvanised 50mm against building/Wall", 1, "108", 3);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Labeling in HH(In Each HH where duct/Fibre runs through)", 2, "40", 3);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Installation of ONT", 2, "100", 3);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Excavate and plant pole - Auger / HT", 2, "986", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Supply Wooden Pole - Length = 7.2m Width = 120/140", 2, "525", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Deliver Poles to site", 2, "2 500", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Install Slack bracket", 2, "18.23", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Supply and Install Strut pole + Bracket", 2, "625", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Supply and install Stay Wire with Stay Set(Average of 7m)", 2, "591", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Stay Set ADJ M12", 2, "481", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Stay Bottom Make-Off M12", 2, "56.38", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Stay Top Make-Off M13", 2, "82.43", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Stay Wire M12", 2, "55.90", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Tangent Support 9.4mm", 2, "27.32", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Dead End 9.4mm", 2, "89.12", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Pigtail Bolt M10x280mm", 2, "22.50", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Suspension Hook Single", 2, "20.60", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Suspension Hook Double", 2, "24.73", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Strapping(Per Pole) X 3", 2, "25.93", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Tree Trimming", 1, "7.80", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Installation of Aerial FOC", 1, "8.22", 4);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Installation of Re-tractanet(No Material charge cant be added)", 1, "11", 5);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Window Cut + Installation of Port Box(2/4)", 2, "105", 5);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Road Cut 300mm X 800mm(Including Reinstatement)", 1, "525", 5);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Building Of New Common Chamber(Including Lid)600x600x400", 2, "2 000", 5);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Installation of Boundary Box", 2, "200", 5);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Installation of HDD Cable for Wall Mount", 1, "11", 6);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Installation of Sub Duct", 1, "5", 6);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Preparation and Mounting of FTTH SDC Wall Boxes", 2, "215", 6);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Installation of 9U Cabinet", 2, "925", 6);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("1-20", 2, "1 000", 7);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("21-50", 2, "2 500", 7);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("51-80", 2, "3 500", 7);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("81-120", 2, "5 000", 7);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("121-200", 2, "7 000", 7);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("201-500", 2, "10 000", 7);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("501-1000", 2, "12 500", 7);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Trench_Soil 300mm (incl reinstatement only in the Estate)", 1, "112", 8);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Trench_Pav 300mm (incl reinstatement only in the Estate)", 1, "136", 8);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("New Conduit Build towards Camera Point 0-30m", 2, "420", 8);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Fibre Splicing_Fusion + OTDR Test+Power Meter Test", 2, "100", 8);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Installation of Camera Termination  Box", 2, "95", 8);
INSERT INTO boqlineitems(item_name, unitid, defaultcost, categoryid) VALUES ("Installation of HDD Cable", 1, "11", 8);

CREATE TABLE IF NOT EXISTS boqtemplate
(
templateid INT NOT NULL AUTO_INCREMENT,
template_name VARCHAR(50) DEFAULT NULL,
client_id INT NOT NULL,
PRIMARY KEY (templateid)
);

CREATE TABLE IF NOT EXISTS boqtemplate_items
(
template_item_id INT NOT NULL AUTO_INCREMENT,
templateid INT NOT NULL,
item_id INT NOT NULL,
PRIMARY KEY (template_item_id)
);
