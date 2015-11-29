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


CREATE INDEX all_index ON  Bill (proposer_type, proposed_date, decision_date, status, status_detail);
CREATE INDEX all_index ON  CoActor (billid, actorid, is_representative, is_proposer, is_assentient, is_withdrawer);