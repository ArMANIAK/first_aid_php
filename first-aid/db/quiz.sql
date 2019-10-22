CREATE DATABASE quiz;
USE quiz;
CREATE TABLE registrants (time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, username varchar(24) NOT NULL, course_type char(9) DEFAULT 'work-shop', contact_data varchar(64) NOT NULL, completed smallint DEFAULT 0, PRIMARY KEY (username));
CREATE TABLE users (username varchar(24) NOT NULL, pass_hash varchar(255), moderator smallint NOT NULL DEFAULT 0 ,easy integer DEFAULT 0 ,medi integer DEFAULT 0 ,hard integer DEFAULT 0,  PRIMARY KEY(username));
CREATE TABLE questions (difficulty char(4), question varchar(255), right_ans varchar(255), wrong1 varchar(255), wrong2 varchar(255), wrong3 varchar(255));