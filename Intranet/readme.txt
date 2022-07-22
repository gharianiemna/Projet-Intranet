Projet Intranet

pour executer le projet :
composer install
(verifier si node.js est déja existant dans les variables d'environement systéme sinon il faut l'ajouter )
nmp install 
npm run watch 
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate 
php bin/console doctrine:fixtures:load
php bin/console server:run

-------
pour faie la migration de table CV 
php  bin/console doctrine:migrations:execute DoctrineMigrations\Version20220718082313
pour ce connecter en tant que admin:  admin@talan.com  + admin123
pour ce connecter en tant que user:   emna@talan.com + emna123 // habib@talan.com +  habib123 // rania@talan.com + rania123 //
kenza@talan.com + kenza123 // samar@talan.com +samar 123
