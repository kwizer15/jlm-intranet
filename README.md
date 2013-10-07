JLM Intranet
============
http://jlm-entreprise.fr

Rapatrier le code pour le développement
---------------------------------------
Dans votre dossier projet

	git clone git@gitlab.kw12er.com:kwizer/jlm-intranet.git
	cd jlm-intranet.git
	sudo chmod 777 -R app/cache

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
	
