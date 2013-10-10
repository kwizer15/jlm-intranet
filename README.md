JLM Intranet
============
http://jlm-entreprise.fr

Petit mode d'emploi de GitLab
-----------------------------
GitLab permet de suivre le fil du développement d'un (ou plusieurs) projet(s)
Vous pouvez :

  * Signaler des bugs (issues)

  * Suggérer des outils à développer

  * Commenter, apporter des informations

  * Suivre le cours du développement du projet

### Signaler un bug ou un outil à développer

  * Aller dans la section "Issues" (barre de navigation en haut)

  * Vérifier rapidement que rien de similaire n'a été signalé

  * Cliquer sur le bouton vert "New Issues" en haut à droite

  * Subject : sujet (décrire rapidement le bug)

  * Assign to : mettre Emmanuel Bernaszuk

  * Milestone : si le bug est en rapport avec un des "Milestone", le séléctionner

  * Label : me permet de classer les issues par thème

  * Description : si y en a plus à dire...

  * On valide avec le bouton "Submit new issue"
  

Rapatrier le code pour le développement
---------------------------------------
Dans votre dossier projet

	git clone git@gitlab.kw12er.com:kwizer/jlm-intranet.git
	cd jlm-intranet.git
	sudo chmod 777 -R app/cache
	sudo chmod 777 -R app/logs

Procédure de mise à jour
------------------------
Connection au serveur

	ssh jlm@jlm-entreprise.fr

On va dans le dossier

	cd intranet/jlm-intranet
	
Mise à jour du code

	git pull
	
On met à jour le cache

	sudo chmod 777 -R app/cache
	php app/console cache:clear
	sudo chmod 777 -R app/cache
	
