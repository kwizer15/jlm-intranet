INSERT INTO `vat` (`id`, `rate`) VALUES
(1, 0.196),
(2, 0.070);

INSERT INTO `countries` (`code`, `name`) VALUES
('FR', 'France');

INSERT INTO `action_types` (`id`, `name`) VALUES
(1, 'Dépannage'),
(2, 'Entretien'),
(3, 'Travaux');

INSERT INTO `door_types` (`id`, `name`) VALUES
(1, 'Barrière levante'),
(2, 'Portail battant à 2 ventaux'),
(3, 'Portail battant à 1 ventail'),
(4, 'Portail coulissant'),
(5, 'Porte accordéon'),
(6, 'Porte basculante'),
(7, 'Portillon'),
(8, 'Porte pivotante à 1 ventail'),
(9, 'Porte pivotante à 2 ventaux');

INSERT INTO `persons` (`id`, `title`, `firstName`, `lastName`, `fixedPhone`, `mobilePhone`, `fax`, `email`, `discr`) VALUES
(1, 'M.', 'Jean-Louis', 'Martinez', '8000', '0609103969', NULL, 'jean-louis.martinez@jlm-entreprise.fr', 'person'),
(2, 'Mme', 'Nadine', 'Martinez', '8002', '0608494350', NULL, 'nadine.martinez@jlm-entreprise.fr', 'person'),
(3, 'M.', 'Yohann', 'Martinez', '8001', '0626066410', NULL, 'yohann.martinez@jlm-entreprise.fr', 'person'),
(4, 'M.', 'Oscar', 's', '8004', '0689536095', NULL, NULL, 'technician'),
(5, 'M.', 'Christophe', 'Vairreto', '8005', '0684789430', NULL, NULL, 'technician'),
(6, 'M.', 'Cyrille', 'Frelat', '8006', '0682533537', NULL, NULL, 'technician'),
(7, 'M.', 'Emmanuel', 'Bernaszuk', NULL, '0678354065', NULL, 'emmanuel.bernaszuk@jlm-entreprise.fr', 'person'),
(8, 'Mlle', 'Aurélie', 'Costalat', NULL, '0637046093', NULL, 'aurelie.costalat@jlm-entreprise.fr', 'person');

INSERT INTO `technicians` (`id`, `internalPhone`) VALUES
(4, '8004'),
(5, '8005'),
(6, '8006');

INSERT INTO `users` (`id`, `person_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(1, 7, 'kwizer', 'kwizer', 'emmanuel.bernaszuk@jlm-entreprise.fr', 'emmanuel.bernaszuk@jlm-entreprise.fr', 1, 'lxodjjrzhmo0soo4o48w4c8wcckc408', '3Vnn3P7Rh5pYnvJ44rn6NLkM1o7LtWmeyYG191MS0oiwytalyFt7xRXgCszFbUJSjWjGmRN11n4UkXuTU/Ti4Q==', '2012-11-23 09:40:11', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 0, NULL);


