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
    id int NOT NULL AUTO_INCREMENT,
    assembly_id       int NOT NULL,
    bill_id           varchar(50) NOT NULL UNIQUE,
    link_id           varchar(50) NOT NULL UNIQUE,
    title             varchar(255),

    summary           TEXT,

    proposed_date     DATE,
    decision_date     DATE,
    collected_date    DATE,

    withdrawer_count  int,
    actor_count       int,

    proposer_type     varchar(20),
    status            varchar(20),
    status_detail     varchar(20),

    PRIMARY KEY (id)
) ENGINE = MYISAM;



DROP TABLE CoActor;
CREATE TABLE CoActor (
  billid int NOT NULL,
  actorid int NOT NULL,

  is_representative int(1),
  is_proposer int(1),
  is_assentient int(1),
  is_withdrawer int(1),

  FOREIGN KEY (actorid) REFERENCES Actor(id),
  FOREIGN KEY (billid) REFERENCES Bill(id),
  CONSTRAINT cac UNIQUE (billid, actorid, is_representative, is_proposer, is_assentient, is_withdrawer)
) ENGINE = MYISAM;


CREATE INDEX id_title_index ON  Bill (title, proposer_type, proposed_date, decision_date, status, status_detail);
CREATE INDEX all_index ON  CoActor (billid, actorid, is_representative, is_proposer, is_assentient, is_withdrawer);



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



"select b.id, b.link_id, title, proposed_date, decision_date, status, status_detail, actor_count from Bill b where INNER JOIN CoActor c on c.billid = b.id where c.actorid=? ";
$sql .= " order by proposed_date desc limit 500";


"select b.id, b.link_id, title, proposed_date, decision_date, status, status_detail, actor_count from CoActor c where c.actorid=36 INNER JOIN Bill b on c.billid = b.id";
$sql .= " order by proposed_date desc limit 500";
