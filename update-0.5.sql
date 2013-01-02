ALTER TABLE shifting_interventions ADD rest LONGTEXT DEFAULT NULL, ADD otherAction_id INT DEFAULT NULL;
ALTER TABLE shifting_interventions ADD CONSTRAINT FK_291B3FA27514471B FOREIGN KEY (otherAction_id) REFERENCES task (id);
CREATE UNIQUE INDEX UNIQ_291B3FA27514471B ON shifting_interventions (otherAction_id)
