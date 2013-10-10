CREATE TABLE door_stops (id INT AUTO_INCREMENT NOT NULL, door_id INT DEFAULT NULL, begin DATETIME NOT NULL, end DATETIME NOT NULL, reason VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_C82F338758639EAE (door_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE door_stops ADD CONSTRAINT FK_C82F338758639EAE FOREIGN KEY (door_id) REFERENCES doors (id);
ALTER TABLE door_stops CHANGE end end DATETIME DEFAULT NULL;
INSERT INTO `jlm`.`door_stops` (`id`, `door_id`, `begin`, `end`, `reason`, `state`) VALUES (NULL, '198', '2011-02-22 00:00:00', NULL, 'À définir', 'À définir');
INSERT INTO `jlm`.`door_stops` (`id`, `door_id`, `begin`, `end`, `reason`, `state`) VALUES (NULL, '434', '2011-05-13 00:00:00', NULL, 'À définir', 'À définir');
INSERT INTO `jlm`.`door_stops` (`id`, `door_id`, `begin`, `end`, `reason`, `state`) VALUES (NULL, '221', '2013-02-19 00:00:00', NULL, 'À définir', 'À définir');
INSERT INTO `jlm`.`door_stops` (`id`, `door_id`, `begin`, `end`, `reason`, `state`) VALUES (NULL, '16', '2013-09-04 11:52:00', NULL, 'porte mise a l’arrêt à la demande d\'un responsable sur place car une procédure est en cours (porte doit rester ouverte jusqu’à la procédure)', 'À définir');
INSERT INTO `jlm`.`door_stops` (`id`, `door_id`, `begin`, `end`, `reason`, `state`) VALUES (NULL, '619', '2013-09-13 17:17:00', NULL, 'tablier à changer suite à un choc véhicule', 'Devis envoyé');
INSERT INTO `jlm`.`door_stops` (`id`, `door_id`, `begin`, `end`, `reason`, `state`) VALUES (NULL, '542', '2013-09-26 17:31:00', NULL, 'portail mis à l\'arrêt suite à dégradation
à changer (prendre rdv sur place pour les travaux à prévoir) :
- revoir câblage barre palpeuse
- repositionner potelet interieur des cellules
- butée au sol
- renforcer système verrouillage portail
- feux clignotant', 'Devis en saisie');
INSERT INTO `jlm`.`door_stops` (`id`, `door_id`, `begin`, `end`, `reason`, `state`) VALUES (NULL, '5', '2013-09-24 14:38:00', NULL, 'tablier à changer suite à un choc véhicule', 'Devis accordé');
INSERT INTO `jlm`.`door_stops` (`id`, `door_id`, `begin`, `end`, `reason`, `state`) VALUES (NULL, '10', '2013-09-24 16:06:00', NULL, 'portail mis à l\'arrêt suite à un défaut de pose d\'origine.
- Poteau int. gauche à remplacer car risque de tomber
- support arrière des 2 moteurs FAAC 400CBAC cassés
- support poteau qui s\'arrache du mur
- BP droite et gauche HS
- Butée au sol à prévoir
- marquage au sol à refaire', 'Devis accordé');
INSERT INTO `jlm`.`door_stops` (`id`, `door_id`, `begin`, `end`, `reason`, `state`) VALUES (NULL, '393', '2013-10-02 16:43:00', NULL, '- platine rigel 4 à remplacer par une rigel 5
- moteur berma SAR à remplacer ', 'Devis envoyé');
INSERT INTO `jlm`.`door_stops` (`id`, `door_id`, `begin`, `end`, `reason`, `state`) VALUES (NULL, '498', '2013-10-04 16:57:00', NULL, 'bras moteur intérieur droit (cassé)', 'Devis à faire');


