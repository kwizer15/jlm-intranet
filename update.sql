ALTER TABLE `doors` CHANGE `transmitter_code` `observations` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE sites ADD lodge_id INT DEFAULT NULL, ADD observations LONGTEXT DEFAULT NULL;
ALTER TABLE sites ADD CONSTRAINT FK_BC00AA63B217AB93 FOREIGN KEY (lodge_id) REFERENCES addresses (id);
CREATE UNIQUE INDEX UNIQ_BC00AA63B217AB93 ON sites (lodge_id);
CREATE TABLE askquote (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
CREATE TABLE askmethods (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE askquote ADD trustee_id INT DEFAULT NULL, ADD site_id INT DEFAULT NULL, ADD method_id INT DEFAULT NULL, ADD person_id INT DEFAULT NULL, ADD intervention_id INT DEFAULT NULL, ADD door_id INT DEFAULT NULL, ADD quote_id INT DEFAULT NULL, ADD creation DATE NOT NULL, ADD maturity DATE NOT NULL, ADD ask LONGTEXT NOT NULL, DROP name;
ALTER TABLE askquote ADD CONSTRAINT FK_6B83768AAFD45F7C FOREIGN KEY (trustee_id) REFERENCES trustees (id);
ALTER TABLE askquote ADD CONSTRAINT FK_6B83768AF6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id);
ALTER TABLE askquote ADD CONSTRAINT FK_6B83768A19883967 FOREIGN KEY (method_id) REFERENCES askmethods (id);
ALTER TABLE askquote ADD CONSTRAINT FK_6B83768A217BBB47 FOREIGN KEY (person_id) REFERENCES persons (id);
ALTER TABLE askquote ADD CONSTRAINT FK_6B83768A8EAE3863 FOREIGN KEY (intervention_id) REFERENCES shifting_interventions (id);
ALTER TABLE askquote ADD CONSTRAINT FK_6B83768A58639EAE FOREIGN KEY (door_id) REFERENCES doors (id);
ALTER TABLE askquote ADD CONSTRAINT FK_6B83768ADB805178 FOREIGN KEY (quote_id) REFERENCES quote (id);
CREATE INDEX IDX_6B83768AAFD45F7C ON askquote (trustee_id);
CREATE INDEX IDX_6B83768AF6BD1646 ON askquote (site_id);
CREATE INDEX IDX_6B83768A19883967 ON askquote (method_id);
CREATE INDEX IDX_6B83768A217BBB47 ON askquote (person_id);
CREATE INDEX IDX_6B83768A8EAE3863 ON askquote (intervention_id);
CREATE INDEX IDX_6B83768A58639EAE ON askquote (door_id);
CREATE INDEX IDX_6B83768ADB805178 ON askquote (quote_id)
ALTER TABLE askquote CHANGE maturity maturity DATE DEFAULT NULL
ALTER TABLE askquote DROP FOREIGN KEY FK_6B83768ADB805178;
DROP INDEX IDX_6B83768ADB805178 ON askquote;
ALTER TABLE askquote DROP quote_id;
ALTER TABLE quote ADD ask_id INT DEFAULT NULL;
ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4B93F8B63 FOREIGN KEY (ask_id) REFERENCES askquote (id);
CREATE INDEX IDX_6B71CBF4B93F8B63 ON quote (ask_id)
