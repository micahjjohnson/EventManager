SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS event_manager;
CREATE DATABASE event_manager;
USE event_manager;

GRANT SELECT, INSERT, DELETE, UPDATE
ON event_manager.*
TO app_user@localhost
IDENTIFIED BY 'pa55word';

-- ^^^ READ THIS!!
-- ^^^
-- ^^^ The part above this comment section should ONLY be run for LOCAL development, NOT on the web server host ---
-- ^^^
-- ^^^
-- The part below is fine for production

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id`                      int(11) NOT NULL AUTO_INCREMENT,
  `name`                    varchar(50) NOT NULL,
  `date`                    date NOT NULL,
  `start_time`              time NOT NULL,
  `end_time`                time NOT NULL,
  `description`             varchar(200) DEFAULT NULL,
  `line1`                   varchar(100)  NOT NULL,
  `line2`                   varchar(75) DEFAULT NULL,
  `city`                    varchar(50)  NOT NULL,
  `state_abbr`              varchar(2) NOT NULL,
  `postal`                  int(10) NOT NULL,
  `last_updated`            date DEFAULT NULL,
  `status_id`               int(11) NOT NULL,
  `chapter_id`              int(11) NOT NULL,
  `coordinator_employee_id` varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

/* We do a bulk upload of placeholder events elsewhere */

DROP TABLE IF EXISTS `event_expenses`;
CREATE TABLE `event_expenses` (
  `id`           int(10) NOT NULL AUTO_INCREMENT,
  `expense_name` varchar(50) NOT NULL,
  `expense_date` date NOT NULL,	
  `event_id`     int(10) NOT NULL,
  `total`        int(5) DEFAULT 0,
  `description`  varchar(100) DEFAULT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS `locations`;
-- are we using this?
CREATE TABLE `locations` (
  `id`            int(11) NOT NULL AUTO_INCREMENT,
  `name`          varchar(75) NOT NULL,
  `line1`         varchar(100) NOT NULL,
  `line2`         varchar(50) DEFAULT NULL,
  `city`          varchar(30) NOT NULL,
  `state_code`    int(10) NOT NULL,
  `postal`        varchar(5) NOT NULL,
  `country_code`  int(10) NOT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS `us_states`;
-- lookup table, we will not be building any management screen for this
CREATE TABLE `us_states` (
  `id`            int(11) NOT NULL AUTO_INCREMENT,
  `name`          varchar(75)  NOT NULL,
  `abbreviation`  varchar(2) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO `us_states` (`id`, `name`, `abbreviation`) VALUES
(1, 'Alabama', 'AL'),
(2, 'Alaska', 'AK'),
(3, 'Arizona', 'AZ'),
(4, 'Arkansas', 'AR'),
(5, 'California', 'CA'),
(6, 'Colorado', 'CO'),
(7, 'Connecticut', 'CN'),
(8, 'Deleware', 'DE'),
(9, 'Florida', 'FL'),
(10, 'Georgia', 'GA'),
(11, 'Hawaii', 'HI'),
(12, 'Idaho', 'ID'),
(13, 'Illinois', 'IL'),
(14, 'Indiana', 'IN'),
(15, 'Iowa', 'IA'),
(16, 'Kansas', 'KS'),
(17, 'Kentucky', 'KY'),
(18, 'Louisana', 'LA'),
(19, 'Maine', 'ME'),
(20, 'Maryland', 'MD'),
(21, 'Massachusetts', 'MA'),
(22, 'Michigan', 'MI'),
(23, 'Minnesota', 'MN'),
(24, 'Mississippi', 'MS'),
(25, 'Missouri', 'MO'),
(26, 'Montana', 'MT'),
(27, 'Nebraska', 'NE'),
(28, 'Nevada', 'NV'),
(29, 'New Hampshire', 'NH'),
(30, 'New Jersey', 'NJ'),
(31, 'New Mexico', 'NM'),
(32, 'New York', 'NY'),
(33, 'North Carolina', 'NC'),
(34, 'North Dakota', 'ND'),
(35, 'Ohio', 'OH'),
(36, 'Oklahoma', 'OK'),
(37, 'Oregon', 'OR'),
(38, 'Pennsylvania', 'PA'),
(39, 'Rhode Island', 'RI'),
(40, 'South Carolina', 'SC'),
(41, 'South Dakota', 'SD'),
(42, 'Tennessee', 'TN'),
(43, 'Texas', 'TX'),
(44, 'Utah', 'UT'),
(45, 'Vermont', 'VT'),
(46, 'Virginia', 'VA'),
(47, 'Washington', 'WA'),
(48, 'West Virginia', 'WV'),
(49, 'Wisconsin', 'WI'),
(50, 'Wyoming', 'WY');


DROP TABLE IF EXISTS `employees`;
CREATE TABLE employees (
  `id`                 INT(11)        NOT NULL   AUTO_INCREMENT,
  `company_emp_id`     VARCHAR(50)    NOT NULL   UNIQUE,
  `first_name`         VARCHAR(50)    NOT NULL,
  `last_name`          VARCHAR(50)    NOT NULL,
  `title`              VARCHAR(50)    NOT NULL,
  `active`             INT(1)         DEFAULT 1,
  `email`              VARCHAR(100)  NOT NULL,
  `pword`              VARCHAR(1050) NOT NULL,
  `salt`               VARCHAR(100)  NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO employees (email, salt, pword, company_emp_id, first_name, last_name, title) VALUES ('james@company.com','','$2y$10$iGNQjtO3XNFq2Xxyyl8H8OlUqinidQfWk.pEk3KT8SZrxZEAsrTf2', 'jallen1','James','Allen','App Developer');
INSERT INTO employees (email, salt, pword, company_emp_id, first_name, last_name, title) VALUES ('micah@company.com','','$2y$10$.msn.ybHAQRv5QzQ9rrw2ebYN2MeW79HJYICR1CrAMr70ibgtpb.m', 'mjohnson1','Micah','Johnson','App Developer');
INSERT INTO employees (email, salt, pword, company_emp_id, first_name, last_name, title) VALUES ('zach@company.com','','$2y$10$DKX3q4TtTiaMw/BY7ehTVe/stwaQidF12BBhekdUc6nlVJOhWSrva', 'zgoodwin1','Zach','Goodwin','Infosec Specialist');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Lydia', 'Felder', 'Systems Administrator III', 'Lydia@company.com', 'Felder1', '$2y$10$M6CPqsiBFnpmVfhCvxzaHegmsSnxbaRzdANL97aNPG6a7oqvqQaci', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Friedrick', 'Nevitt', 'Actuary', 'Friedrick@company.com', 'Nevitt9', '$2y$10$tUDcaXDMvctlvf6ibwdj/u9EsmdhVFz2q9UlWJM4Z9JJNq/K/wzvK', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Rowland', 'Redler', 'Compensation Analyst', 'Rowland@company.com', 'Redler6', '$2y$10$f3Dn8x1ObNSfhL4Y5HDvQ.8g1CfLI1SqSQSaYVdf83ut7.m65A712', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Pepi', 'Moorwood', 'Compensation Analyst', 'Pepi@company.com', 'Moorwood8', '$2y$10$Dv02jgLeeV4tMqdqEVxMauwZY9/pBCGwRI8PYKaekE2zL0zFvJVJO', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Cynthy', 'Curtoys', 'Registered Nurse', 'Cynthy@company.com', 'Curtoys7', '$2y$10$rc26XZCnBzZ04jeaZxBayuTATjBZhDQ96JMlqgFEZT7BGZ4EsnPbu', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Nelle', 'Cardenoza', 'VP Quality Control', 'Nelle@company.com', 'Cardenoza5', '$2y$10$eM/lBu6y0mQLcCq9DX.l1u9zAUd6Ls2oKCyqXEZ/.aDOfEa.i/Ff6', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Marie-jeanne', 'Dimmne', 'Community Outreach Specialist', 'Marie-jeanne@company.com', 'Dimmne4', '$2y$10$bmFb5JYJbdLykmIbPxjvaeAWnqBM.B1wCH8toUPYcTpz1W9suaiBy', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Westley', 'Harcase', 'Account Executive', 'Westley@company.com', 'Harcase1', '$2y$10$.g4avZiXvK/EuAnkgP0r1uvte8CwYtVivg6M1D7HUGAZlMt8KOB7u', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Jemima', 'Cottage', 'Structural Analysis Engineer', 'Jemima@company.com', 'Cottage6', '$2y$10$cFxuJYkGXL82Dqh64kqqHebwmF1Kqnh4Et2IRiE/BWEwEOtcV2IqC', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Carolee', 'Cuerda', 'Paralegal', 'Carolee@company.com', 'Cuerda9', '$2y$10$1nrZbYPNOT25GwOMUU/7M.RY2OhHcGcJEGuIHh1IJO4jJ1zANyAXq', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Rustie', 'Hucker', 'Systems Administrator IV', 'Rustie@company.com', 'Hucker8', '$2y$10$ScdcGLasw/pVIPJ1ZN44t.VqetE7hCJ7atI.IfAfkEP/loywRrQAy', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Stephie', 'MacAskill', 'Technical Writer', 'Stephie@company.com', 'MacAskill1', '$2y$10$X7cUaJA1KXhxiKkXyzd.keSKB4NiOkSEqiEUDPgd25ndoafTh2vlq', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Eward', 'Sumers', 'Senior Editor', 'Eward@company.com', 'Sumers3', '$2y$10$gEAdTpLhbf79NJGhwZmn1O1ka9wcw.25YeU4KCK8oT9IfcgMII9.2', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Joleen', 'Bytheway', 'Senior Developer', 'Joleen@company.com', 'Bytheway6', '$2y$10$aOJdzpSEcCpORJukrH3CS.Pmc6EDNKP2kyfDBM/PDXJrPq5jR4IOe', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Eugenius', 'Holehouse', 'Director of Sales', 'Eugenius@company.com', 'Holehouse1', '$2y$10$89MHsjzgd.fPDrMUEasnWelfdV/A4F8cfhYCWggtNOKSO.8lqVGxm', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Ollie', 'Quarless', 'Nurse', 'Ollie@company.com', 'Quarless9', '$2y$10$cFxuJYkGXL82Dqh64kqqHebwmF1Kqnh4Et2IRiE/BWEwEOtcV2IqC', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Seline', 'Hawlgarth', 'Nuclear Power Engineer', 'Seline@company.com', 'Hawlgarth6', '$2y$10$mnAGwlVY90VJg8r7aDMyKeZsy8EU9fsGAKDat8o3je0IwRoBaeHyS', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Keir', 'Dahmke', 'Quality Control Specialist', 'Keir@company.com', 'Dahmke9', '$2y$10$ScdcGLasw/pVIPJ1ZN44t.VqetE7hCJ7atI.IfAfkEP/loywRrQAy', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Shaina', 'Strand', 'Physical Therapy Assistant', 'Shaina@company.com', 'Strand9', '$2y$10$89MHsjzgd.fPDrMUEasnWelfdV/A4F8cfhYCWggtNOKSO.8lqVGxm', '');
insert into employees (first_name, last_name, title, email, company_emp_id, pword, salt) values ('Nariko', 'McHugh', 'Account Coordinator', 'Nariko@company.com', 'McHugh2', '$2y$10$gEAdTpLhbf79NJGhwZmn1O1ka9wcw.25YeU4KCK8oT9IfcgMII9.2', '');

DROP TABLE IF EXISTS `chapters`;
CREATE TABLE chapters (  
  `id`              INT(11)        NOT NULL   AUTO_INCREMENT,  
  `name`            varchar(75)    NOT NULL,  
  `description`     varchar(100)   NOT NULL, 
  `short_name`      varchar(100)   NOT NULL,  
  PRIMARY KEY (id)
);

insert into chapters (name, description, short_name) values ('Initech Women of Chicago', 'Chicago Women\'s Chapter', 'WmCh');
insert into chapters (name, description, short_name) values ('Initech Chicago Nosotros Latinos', 'Chicago Latino Chapter', 'LatCh');
insert into chapters (name, description, short_name) values ('Initech African Americans of Chicago', 'Chicago African American Chapter', 'AfrAmCh');
insert into chapters (name, description, short_name) values ('Initech Women of Cincinnati', 'Cincinnati Women\'s Chapter', 'WmCin');
insert into chapters (name, description, short_name) values ('Initech African Americans of Cincinnati', 'Cincinnati African American Chapter', 'AfrAmCin');
insert into chapters (name, description, short_name) values ('Initech Veterans of Cincinnati', 'Cincinnati Veterans Chapter', 'VetCin');
insert into chapters (name, description, short_name) values ('Initech Women of Denver', 'Denver Women\'s Chapter', 'WmDen');
insert into chapters (name, description, short_name) values ('Initech Denver Nosotros Latinos', 'Denver Latino Chapter', 'LatDen');
insert into chapters (name, description, short_name) values ('Initech African Americans of Denver', 'Denver African American Chapter', 'AfrAmDen');
insert into chapters (name, description, short_name) values ('Initech Women of Minneapolis', 'Minneapolis Women\'s Chapter', 'WmMinn');
insert into chapters (name, description, short_name) values ('Initech African Americans of Minneapolis', 'Minneapolis African American Chapter', 'AfrAmMinn');
insert into chapters (name, description, short_name) values ('Initech Veterans of Minneapolis', 'Minneapolis Veterans Chapter', 'VetMinn');
insert into chapters (name, description, short_name) values ('Initech Women of Indianapolis', 'Indianapolis Women\'s Chapter', 'WmIndy');
insert into chapters (name, description, short_name) values ('Initech African Americans of Indianapolis', 'Indianapolis African American Chapter', 'AfrAmIndy');
insert into chapters (name, description, short_name) values ('Initech Veterans of Indianapolis', 'Indianapolis Veterans Chapter', 'VetIndy');
insert into chapters (name, description, short_name) values ('Initech Women of Portland', 'Portland Women\'s Chapter', 'WmPort');
insert into chapters (name, description, short_name) values ('Initech Portland Nosotros Latinos', 'Portland Latino Chapter', 'LatPort');
insert into chapters (name, description, short_name) values ('Initech African Americans of Portland', 'Portland African American Chapter', 'AfrAmPort');




DROP TABLE IF EXISTS `chapter_leaders`;
-- shows which chapter an employee is a leader in
-- they will need to be a follower in that chapter too
CREATE TABLE chapter_leaders (
  `id`                INT(11)        NOT NULL   AUTO_INCREMENT,   -- database row id
  `company_emp_id`    VARCHAR(50)    CHARACTER SET utf8 NOT NULL,
  `chapter_id`        INT(11)        NOT NULL,
  `active` 	          INT(1)         DEFAULT 1,
  PRIMARY KEY (id)
);

insert into chapter_leaders (company_emp_id, chapter_id) values ('mjohnson1', 1);
insert into chapter_leaders (company_emp_id, chapter_id) values ('mjohnson1', 2);
insert into chapter_leaders (company_emp_id, chapter_id) values ('mjohnson1', 3);
insert into chapter_leaders (company_emp_id, chapter_id) values ('mjohnson1', 4);


DROP TABLE IF EXISTS `program_managers`;
-- shows which employees are program managers
-- we will need to update later if we add more than 1 company
CREATE TABLE program_managers (
  `id`               INT(11)        NOT NULL   AUTO_INCREMENT,
  `company_emp_id`    VARCHAR(50)    CHARACTER SET utf8 NOT NULL   UNIQUE,
  PRIMARY KEY (id)
);

insert into program_managers (company_emp_id) values ('jallen1');
insert into program_managers (company_emp_id) values ('Nevitt9');
insert into program_managers (company_emp_id) values ('Moorwood8');


DROP TABLE IF EXISTS `chapter_employee`;
-- creates a link, shows which chapter(s) an employee following
CREATE TABLE chapter_employee (
  `id`               INT(11)        NOT NULL   AUTO_INCREMENT,
  `employee_id`       INT(11)        NOT NULL,
  `chapter_id`        INT(11)        NOT NULL,
  PRIMARY KEY (id)
);

insert into chapter_employee (employee_id, chapter_id) values (5,1);
insert into chapter_employee (employee_id, chapter_id) values (6,2);
insert into chapter_employee (employee_id, chapter_id) values (7,3);
insert into chapter_employee (employee_id, chapter_id) values (8,4);
insert into chapter_employee (employee_id, chapter_id) values (10,1);
insert into chapter_employee (employee_id, chapter_id) values (11,1);
insert into chapter_employee (employee_id, chapter_id) values (12,1);
insert into chapter_employee (employee_id, chapter_id) values (13,1);
insert into chapter_employee (employee_id, chapter_id) values (14,2);
insert into chapter_employee (employee_id, chapter_id) values (15,2);
insert into chapter_employee (employee_id, chapter_id) values (16,2);
insert into chapter_employee (employee_id, chapter_id) values (17,2);
insert into chapter_employee (employee_id, chapter_id) values (18,3);
insert into chapter_employee (employee_id, chapter_id) values (19,3);
insert into chapter_employee (employee_id, chapter_id) values (20,3);
insert into chapter_employee (employee_id, chapter_id) values (4,3);
insert into chapter_employee (employee_id, chapter_id) values (5,4);


DROP TABLE IF EXISTS `eventstatus`;
CREATE TABLE eventstatus (
  `id`               INT(11)        NOT NULL   AUTO_INCREMENT,
  `status`           VARCHAR(30)    NOT NULL   UNIQUE,
  `shortcode`        VARCHAR(4)     NOT NULL   UNIQUE,
  PRIMARY KEY (id)
);

insert into eventstatus (status, shortcode) values ('Pending',  'PEND');
insert into eventstatus (status, shortcode) values ('Approved' ,'APPR');
insert into eventstatus (status, shortcode) values ('Finalized','FNLZ');
insert into eventstatus (status, shortcode) values ('Closed'   ,'CLSD');


DROP TABLE IF EXISTS `event_attendance`;
CREATE TABLE event_attendance (  
  `id`                  INT(11)        NOT NULL   AUTO_INCREMENT,  
  `event_id`            INT(11)        NOT NULL,  
  `company_emp_id`      varchar(50)   CHARACTER SET utf8 NOT NULL,  
  PRIMARY KEY (id));

insert into event_attendance (event_id, company_emp_id) values (3, 'mjohnson1');
insert into event_attendance (event_id, company_emp_id) values (2, 'mjohnson1');


DROP TABLE IF EXISTS `volunteer_submissions`;
CREATE TABLE volunteer_submissions (  
  `id`                  INT(11)        NOT NULL   AUTO_INCREMENT,  
  `company_emp_id`      VARCHAR(50)   CHARACTER SET utf8 NOT NULL,  
  `date`      DATE   NOT NULL,  
  `hours`      INT(2)   NOT NULL,  
  `name`      VARCHAR(50)   CHARACTER SET utf8 NOT NULL,  
  `supervisor`      VARCHAR(50)   CHARACTER SET utf8 NOT NULL,  
  `phone`      VARCHAR(10)  CHARACTER SET utf8 NOT NULL,  
  `description`      VARCHAR(150)   CHARACTER SET utf8 NOT NULL,  
  `status`      VARCHAR(20)   DEFAULT 'submitted' NOT NULL,  
  `approved_by`      VARCHAR(50)   CHARACTER SET utf8 NULL,  
  PRIMARY KEY (id));

insert into volunteer_submissions (company_emp_id, date, hours, name, supervisor, phone, description) values ('mjohnson1', '2019-02-04', '2', 'Woody Nursing Home', 'Glen Turner', '5135554678', 'This is the description of my duties.');


DROP TABLE IF EXISTS `event_rsvps`;
CREATE TABLE event_rsvps (  
  `id`                  INT(11)        NOT NULL   AUTO_INCREMENT,  
  `company_emp_id`      VARCHAR(50)   CHARACTER SET utf8 NOT NULL,  
  `event_id`      INT(11)    NOT NULL, 
  `guests`      INT(11)    NOT NULL, 
  `time`      DATE NOT NULL,  
  `email_reminder` VARCHAR(3) CHARACTER SET utf8 NOT NULL,  
  `cancelled`      BOOLEAN  DEFAULT false NULL,  
  PRIMARY KEY (id));

insert into event_rsvps (company_emp_id, event_id, guests, time, email_reminder) values ('mjohnson1', '2', '3', '2019-02-01', 'NO');
insert into event_rsvps (company_emp_id, event_id, guests, time, email_reminder) values ('jallen1', '5', '1', '2019-02-01', 'NO');
insert into event_rsvps (company_emp_id, event_id, guests, time, email_reminder) values ('jallen1', '2', '2',  '2019-02-01', 'YES');


DROP TABLE IF EXISTS `employee_event_follow`;
CREATE TABLE  employee_event_follow (  
  `id`                  INT(11)        NOT NULL   AUTO_INCREMENT,  
  `company_emp_id`      VARCHAR(50)   CHARACTER SET utf8 NOT NULL,  
  `event_id`      INT(11)    NOT NULL, 
  PRIMARY KEY (id));

insert into employee_event_follow (company_emp_id, event_id) values ('jallen1', '2');
insert into employee_event_follow (company_emp_id, event_id) values ('jallen1', '6');

DROP TABLE IF EXISTS `employee_chapter_follow`;
CREATE TABLE  employee_chapter_follow (  
  `id`                  INT(11)        NOT NULL   AUTO_INCREMENT,  
  `company_emp_id`      VARCHAR(50)   CHARACTER SET utf8 NOT NULL,  
  `chapter_id`      INT(11)    NOT NULL, 
  PRIMARY KEY (id));

insert into employee_chapter_follow (company_emp_id, chapter_id) values ('jallen1', '1');
insert into employee_chapter_follow (company_emp_id, chapter_id) values ('jallen1', '4');
insert into employee_chapter_follow (company_emp_id, chapter_id) values ('mjohnson1', '1');