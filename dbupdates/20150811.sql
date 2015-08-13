CREATE TABLE jlm_product_product_join_supplierpurchaseprice (prooduct_id INT NOT NULL, supplierpurchaseprice_id INT NOT NULL, INDEX IDX_E8B6E2C06AD19828 (prooduct_id), UNIQUE INDEX UNIQ_E8B6E2C0AD5EDB7B (supplierpurchaseprice_id), PRIMARY KEY(prooduct_id, supplierpurchaseprice_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE jlm_product_supplierpurchaseprice (id INT AUTO_INCREMENT NOT NULL, supplier_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, unitPrice NUMERIC(10, 2) NOT NULL, publicPrice NUMERIC(10, 2) NOT NULL, discount SMALLINT NOT NULL, expenseRatio SMALLINT NOT NULL, delivery NUMERIC(10, 2) NOT NULL, INDEX IDX_1821A5472ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE jlm_product_product_join_supplierpurchaseprice ADD CONSTRAINT FK_E8B6E2C06AD19828 FOREIGN KEY (prooduct_id) REFERENCES products (id);
ALTER TABLE jlm_product_product_join_supplierpurchaseprice ADD CONSTRAINT FK_E8B6E2C0AD5EDB7B FOREIGN KEY (supplierpurchaseprice_id) REFERENCES jlm_product_supplierpurchaseprice (id);
ALTER TABLE jlm_product_supplierpurchaseprice ADD CONSTRAINT FK_1821A5472ADD6D8C FOREIGN KEY (supplier_id) REFERENCES suppliers (id)


INSERT INTO `jlm`.`jlm_commerce_textmodel` (`id`, `namespace`, `text`) VALUES
(NULL, 'bill_earlypayment', '0.00% pour paiement antcipé.'),
(NULL, 'bill_penalty', 'pour non respect de la date d\'échéance: 1,3%/mois. Loi n° 92-144 du 31/12/92'),
(NULL, 'bill_property', 'JLM conserve l\'entière propriété des marchandises jusqu\'au complet paiement du prix facturé.'),
(NULL, 'quotevariant_delay', '1 à 15 jours après accord (selon disponibilité des pièces)'),
(NULL, 'quotevariant_delay', '5 à 20 jours après acompte'),
(NULL, 'quotevariant_delay', '1 à 5 semaines après acompte'),
(NULL, 'quotevariant_delay', 'Le matériel sera expédié dès réception du règlement'),
(NULL, 'quotevariant_intro', 'Suite à votre demande, nous vous soumettons notre proposition concernant'),
(NULL, 'quotevariant_intro', 'Suite à la visite d\'entretien, nous vous soumettons notre proposition concernant'),
(NULL, 'quotevariant_intro', 'Suite à notre intervention, nous vous soumettons notre proposition concernant'),
(NULL, 'quotevariant_intro', 'Suite à audit, nous vous soumettons notre proposition concernant'),
(NULL, 'quotevariant_intro', 'Suite à dégradation, nous vous soumettons notre proposition concernant'),
(NULL, 'quotevariant_intro', 'Suite à choc véhicule, nous vous soumettons notre proposition concernant'),
(NULL, 'quotevariant_intro', 'Suite à la visite d\'entretien, le technicien a constaté que le marquage au sol était effacé. Nous vous soumettons donc notre proposition concernant la réfection du marquage au sol.'),
(NULL, 'quotevariant_intro', 'Suite à votre demande, nous vous soumettons notre proposition concernant la fourniture d\'émetteurs parking.'),
(NULL, 'quotevariant_intro', 'Suite à un évenement anormal hors vétusté, nous vous soumettons notre proposition concernant '),
(NULL, 'quotevariant_intro', 'Dans le cadre de la loi sur l\'interdiction des ampoules à incandescence, nous vous soumettons notre proposition concernant le remplacement du feu clignotant par un feu clignotant pouvant accueillir des ampoules à Led (voir devis ci-joint).'),
(NULL, 'quotevariant_payment', 'à réception de la facture'),
(NULL, 'quotevariant_payment', '30% à la commande, le solde fin de travaux'),
(NULL, 'quotevariant_payment', 'à la commande');
DROP TABLE delaymodel
DROP TABLE introbillmodel
DROP TABLE earlypayement
DROP TABLE intromodel
DROP TABLE paymentmodel
DROP TABLE penaltymodel
DROP TABLE propertymodel
