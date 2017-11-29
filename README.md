jaya-site
=========

A Symfony project created on November 28, 2017, 3:23 pm.

Addresse par docker : `jaya-site.dev:81/app_dev.php`
ou `jaya-site.dev:81/app.php`

phpMyAdmin: `jaya-site.dev:8181`

#Commandes pour docker :

Sur ubuntu: 

make run : lance docker

make down: arrete le docker

make stop: met en pause le docker

make php : donne accès au conteneur php de docker

make db : donne accès au conteneur mysql de docker

Sur windows:

run:

	docker-compose up -d

stop:	
	docker-compose stop
	
start:
	docker-compose up -d
	
down:
	docker-compose down
 
db:
	docker exec -it jaya_db_1 bash
	
php: 
	docker exec -it jaya_php_1 bash



docker-compose exec php chmod 777 -R var/cache/ var/logs/ : donne les droits sur les dossiers cache et logs

####Remarque: dans le cas de docker sur une vm de type unix penser à préciser sudo avant l'execution d'une commande
