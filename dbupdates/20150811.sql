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
