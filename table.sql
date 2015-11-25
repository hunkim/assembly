CREATE TABLE Actor (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(255),
  cname varchar(255),
  party varchar(255),

  CONSTRAINT ac UNIQUE (name, cname, party),
  PRIMARY KEY (id)
);

CREATE TABLE CoActor (
  billid varchar(255),
  actorid int,
  proposed int,
  FOREIGN KEY (actorid) REFERENCES Actor(id),
  FOREIGN KEY (billid) REFERENCES Bill(id),
  CONSTRAINT cac UNIQUE (billid, actorid, proposed)
);

CREATE TABLE Bill (
  id varchar(255),
  title varchar(255),
  summary varchar(1024),
  create date,
  PRIMARY KEY (id)
);

CREATE USER 'trend'@'localhost' IDENTIFIED BY 'only!trend!';
GRANT ALL PRIVILEGES ON assembly.* TO 'trend'@'localhost';
