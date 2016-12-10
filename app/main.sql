DROP TABLE IF EXISTS `referrals`;
DROP TABLE IF EXISTS `project_organizations`;
DROP TABLE IF EXISTS `questionnaire`;
DROP TABLE IF EXISTS `clients`;
DROP TABLE IF EXISTS `referral_agencies`;
DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`zipcode` int(5) UNSIGNED NOT NULL,
`population` int(11) UNSIGNED,
PRIMARY KEY(`id`),
UNIQUE KEY(`name`, `zipcode`)
)ENGINE=InnoDB;

CREATE TABLE `referral_agencies`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL UNIQUE,
`streetNumber` int(10) NOT NULL,
`streetName` varchar(255) NOT NULL,
`cid` int(11) NOT NULL,
PRIMARY KEY(`id`),
FOREIGN KEY(`cid`) REFERENCES `cities` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
)ENGINE=InnoDB;

CREATE TABLE `clients`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`fname` varchar(255) NOT NULL,
`lname` varchar(255) NOT NULL,
`SSN` varchar(11) UNIQUE,
`Sex` char(1) NOT NULL,
`DOB` date,
`AgencyID` int(11) NOT NULL,
PRIMARY KEY(`id`),
FOREIGN KEY(`AgencyID`) REFERENCES `referral_agencies`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE
)ENGINE=InnoDB;

CREATE TABLE `questionnaire`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`cid` int(11) UNIQUE,
`score` int(3) UNSIGNED NOT NULL,
PRIMARY KEY(`id`),
FOREIGN KEY(`cid`) REFERENCES `clients`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE=InnoDB;

CREATE TABLE `project_organizations`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`specialtyArea` varchar(255) NOT NULL,
`fundingAmount` int(11) UNSIGNED,
PRIMARY KEY(`id`)
)ENGINE=InnoDB;

CREATE TABLE `referrals`(
`cid` int(11),
`oid` int(11),
PRIMARY KEY(`cid`, `oid`),
FOREIGN KEY(`cid`) REFERENCES `clients`(`id`) ON UPDATE CASCADE,
FOREIGN KEY(`oid`) REFERENCES `project_organizations`(`id`) ON UPDATE CASCADE
)ENGINE=InnoDB;


INSERT INTO cities (name, zipcode, population) VALUES ('Albany', 12210, 98469);
INSERT INTO cities (name, zipcode, population) VALUES ('Cohoes', 12047, 16168);
INSERT INTO cities (name, zipcode, population) VALUES ('Watervliet', 12189, 10254);
INSERT INTO cities (name, zipcode, population) VALUES ('Colonie', 12047, 81591);
INSERT INTO cities (name, zipcode, population) VALUES ('Guilderland', 12084, 35303);


INSERT INTO referral_agencies (name, streetNumber, streetName, cid) VALUES
    ('Albany Housing Coalition, Inc', 278, 'Clinton Ave.',
    (SELECT id FROM cities WHERE name='Albany'));

INSERT INTO referral_agencies (name, streetNumber, streetName, cid) VALUES
    ('Equinox, Inc', 260, 'Washington Ave.',
    (SELECT id FROM cities WHERE name='Albany'));

INSERT INTO clients (fname, lname, SSN, Sex, DOB, AgencyID) VALUES
    ('Patrick', 'Mendell', '111-11-1234', 'M', '1973-4-24',
    (SELECT id FROM referral_agencies WHERE name='Albany Housing Coalition, Inc'));

INSERT INTO clients (fname, lname, SSN, Sex, DOB, AgencyID) VALUES
    ('Hank', 'Keplin', '234-56-7890', 'M', '1990-3-27',
    (SELECT id FROM referral_agencies WHERE name='Equinox, Inc'));

INSERT INTO clients (fname, lname, SSN, Sex, DOB, AgencyID) VALUES
    ('Kristie', 'Amaral', '611-55-3746', 'F', '1983-6-17',
    (SELECT id FROM referral_agencies WHERE name='Equinox, Inc'));

INSERT INTO clients (fname, lname, SSN, Sex, DOB, AgencyID) VALUES
    ('Jeanna', 'Smith', '413-19-5555', 'F', '1988-7-22',
    (SELECT id FROM referral_agencies WHERE name='Albany Housing Coalition, Inc'));
