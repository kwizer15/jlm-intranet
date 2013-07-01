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
ALTER TABLE contracts CHANGE complete complete TINYINT(1) NOT NULL, CHANGE contract_option contract_option TINYINT(1) NOT NULL;
ALTER TABLE askmethods CHANGE text name VARCHAR(255) NOT NULL;
ALTER TABLE shifting_interventions ADD bill_id INT DEFAULT NULL, ADD billNumber VARCHAR(255) DEFAULT NULL, ADD mustBeBilled TINYINT(1) DEFAULT NULL;
ALTER TABLE shifting_interventions ADD CONSTRAINT FK_291B3FA21A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id);
CREATE UNIQUE INDEX UNIQ_291B3FA21A8C12F5 ON shifting_interventions (bill_id);
ALTER TABLE shift_technician CHANGE begin begin DATETIME NOT NULL;
ALTER TABLE shifting_fixing DROP order_number;
ALTER TABLE shifting_works ADD order_id INT DEFAULT NULL;
ALTER TABLE shifting_works ADD CONSTRAINT FK_57D2710B8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id);
CREATE UNIQUE INDEX UNIQ_57D2710B8D9F6D38 ON shifting_works (order_id)
ALTER TABLE bill ADD intervention_id INT DEFAULT NULL;
ALTER TABLE bill ADD CONSTRAINT FK_7A2119E38EAE3863 FOREIGN KEY (intervention_id) REFERENCES shifting_interventions (id);
CREATE UNIQUE INDEX UNIQ_7A2119E38EAE3863 ON bill (intervention_id);
ALTER TABLE shifting_interventions DROP FOREIGN KEY FK_291B3FA21A8C12F5;
DROP INDEX UNIQ_291B3FA21A8C12F5 ON shifting_interventions;
ALTER TABLE shifting_interventions DROP bill_id, DROP billNumber
ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE58639EAE;
ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEDB805178;
DROP INDEX IDX_E52FFDEEDB805178 ON orders;
DROP INDEX IDX_E52FFDEE58639EAE ON orders;
ALTER TABLE orders ADD work_id INT DEFAULT NULL, DROP door_id, DROP quote_id, DROP place;
ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEBB3453DB FOREIGN KEY (work_id) REFERENCES shifting_works (id);
CREATE UNIQUE INDEX UNIQ_E52FFDEEBB3453DB ON orders (work_id);
ALTER TABLE quote_variant ADD work_id INT DEFAULT NULL;
ALTER TABLE quote_variant ADD CONSTRAINT FK_1EAC1729BB3453DB FOREIGN KEY (work_id) REFERENCES shifting_works (id);
CREATE UNIQUE INDEX UNIQ_1EAC1729BB3453DB ON quote_variant (work_id);
ALTER TABLE shifting_works DROP INDEX IDX_57D2710BDB805178, ADD UNIQUE INDEX UNIQ_57D2710BDB805178 (quote_id);
ALTER TABLE shifting_works DROP FOREIGN KEY FK_57D2710B8D9F6D38;
DROP INDEX UNIQ_57D2710B8D9F6D38 ON shifting_works;
ALTER TABLE shifting_works DROP order_id
ALTER TABLE askquote DROP INDEX IDX_6B83768A8EAE3863, ADD UNIQUE INDEX UNIQ_6B83768A8EAE3863 (intervention_id);
ALTER TABLE shifting_interventions ADD contact_customer TINYINT(1) NOT NULL;
ALTER TABLE shifting_works ADD intervention_id INT DEFAULT NULL;
ALTER TABLE shifting_works ADD CONSTRAINT FK_57D2710B8EAE3863 FOREIGN KEY (intervention_id) REFERENCES shifting_interventions (id);
CREATE UNIQUE INDEX UNIQ_57D2710B8EAE3863 ON shifting_works (intervention_id)
ALTER TABLE shifting_interventions CHANGE contact_customer contact_customer TINYINT(1) DEFAULT NULL
ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E38EAE3863;
DROP INDEX UNIQ_7A2119E38EAE3863 ON bill;
ALTER TABLE bill DROP intervention_id;
ALTER TABLE shifting_interventions ADD bill_id INT DEFAULT NULL;
ALTER TABLE shifting_interventions ADD CONSTRAINT FK_291B3FA21A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id);
CREATE UNIQUE INDEX UNIQ_291B3FA21A8C12F5 ON shifting_interventions (bill_id)
ALTER TABLE askquote DROP FOREIGN KEY FK_6B83768A8EAE3863;
DROP INDEX UNIQ_6B83768A8EAE3863 ON askquote;
ALTER TABLE askquote DROP intervention_id;
ALTER TABLE shifting_interventions ADD work_id INT DEFAULT NULL, ADD askQuote_id INT DEFAULT NULL;
ALTER TABLE shifting_interventions ADD CONSTRAINT FK_291B3FA2BB3453DB FOREIGN KEY (work_id) REFERENCES shifting_works (id);
ALTER TABLE shifting_interventions ADD CONSTRAINT FK_291B3FA27E4135B1 FOREIGN KEY (askQuote_id) REFERENCES askquote (id);
CREATE UNIQUE INDEX UNIQ_291B3FA2BB3453DB ON shifting_interventions (work_id);
CREATE UNIQUE INDEX UNIQ_291B3FA27E4135B1 ON shifting_interventions (askQuote_id);
ALTER TABLE shifting_works DROP FOREIGN KEY FK_57D2710B8EAE3863;
DROP INDEX UNIQ_57D2710B8EAE3863 ON shifting_works;
ALTER TABLE shifting_works DROP intervention_id
ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEBB3453DB;
DROP INDEX UNIQ_E52FFDEEBB3453DB ON orders;
ALTER TABLE orders DROP work_id;
ALTER TABLE shifting_works ADD order_id INT DEFAULT NULL;
ALTER TABLE shifting_works ADD CONSTRAINT FK_57D2710B8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id);
CREATE UNIQUE INDEX UNIQ_57D2710B8D9F6D38 ON shifting_works (order_id)
ALTER TABLE shifting_interventions DROP FOREIGN KEY FK_291B3FA2BB3453DB;
DROP INDEX UNIQ_291B3FA2BB3453DB ON shifting_interventions;
ALTER TABLE shifting_interventions DROP work_id;
ALTER TABLE shifting_works ADD intervention_id INT DEFAULT NULL;
ALTER TABLE shifting_works ADD CONSTRAINT FK_57D2710B8EAE3863 FOREIGN KEY (intervention_id) REFERENCES shifting_interventions (id);
CREATE UNIQUE INDEX UNIQ_57D2710B8EAE3863 ON shifting_works (intervention_id)
ALTER TABLE shifting_interventions ADD work_id INT DEFAULT NULL;
ALTER TABLE shifting_interventions ADD CONSTRAINT FK_291B3FA2BB3453DB FOREIGN KEY (work_id) REFERENCES shifting_works (id);
CREATE UNIQUE INDEX UNIQ_291B3FA2BB3453DB ON shifting_interventions (work_id);
ALTER TABLE shifting_works DROP FOREIGN KEY FK_57D2710B8EAE3863;
DROP INDEX UNIQ_57D2710B8EAE3863 ON shifting_works;
ALTER TABLE shifting_works DROP intervention_id
