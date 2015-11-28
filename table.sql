DROP TABLE Actor;
CREATE TABLE Actor (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(100),
  cname varchar(100),
  party varchar(100),

  CONSTRAINT ac UNIQUE (name, cname, party),
  PRIMARY KEY (id)
) ENGINE = MYISAM;


DROP TABLE Bill;



CREATE TABLE Bill (
    assembly_id       int NOT NULL,
    id                int NOT NULL UNIQUE,
    link_id           varchar(255) NOT NULL UNIQUE,
    title             varchar(255),

    summary           TEXT,

    proposed_date     DATE,
    decision_date     DATE,
    collected_date    DATE,

    withdrawer_count  int,
    actor_count       int,

    proposer_type     varchar(255),
    status            varchar(255),
    status_detail     varchar(255),

    PRIMARY KEY (id)
) ENGINE = MYISAM;

CREATE INDEX all_index ON  Bill (id, title, proposed_date, decision_date, status);



DROP TABLE CoActor;
CREATE TABLE CoActor (
  billid int NOT NULL,
  actorid int NOT NULL,

  is_representer int(1),
  is_proposer int(1),
  is_assentient int(1),
  is_withdrawer int(1),

  FOREIGN KEY (actorid) REFERENCES Actor(id),
  FOREIGN KEY (billid) REFERENCES Bill(id),
  CONSTRAINT cac UNIQUE (billid, actorid, is_representer, is_proposer, is_assentient, is_withdrawer)
) ENGINE = MYISAM;
CREATE INDEX all_index ON  CoActor (billid, actorid, is_representer, is_proposer, is_assentient, is_withdrawer);



DROP TABLE HTML;


CREATE USER 'trend'@'localhost' IDENTIFIED BY 'only!trend!';
GRANT ALL PRIVILEGES ON assembly.* TO 'trend'@'localhost';

CREATE TABLE Bill (
  id  int NOT NULL UNIQUE,
  key varchar(255) NOT NULL UNIQUE,
  title varchar(255),

  proposedby varchar(255),
  result varchar(255),

  summary varchar(1024),

  cdate DATE,
  pdate DATE,

  titleHTML TEXT,
  sumHTML TEXT,
  coActorHTML TEXT,
  billHTML TEXT,

  collected date,
  processed int(1),
  PRIMARY KEY (id)
) ENGINE = MYISAM;
