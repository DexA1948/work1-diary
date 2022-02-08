DROP TABLE IF EXISTS page_table;

CREATE TABLE page_table (
  id smallint unsigned NOT NULL auto_increment,
  heading varchar(255) NOT NULL,
  content mediumtext,
  photopath1 text,
  photopath2 text,
  last_edited_date varchar(25) NOT NULL,
  PRIMARY KEY (id)
);