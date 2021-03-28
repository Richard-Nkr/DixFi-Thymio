# Bienvenue sur [les DixFi de Thymio](https://thymio.tech/) !

## Qui sommes-nous ? 

Nous sommes un groupe de 4 étudiants en 3ème année de licence MIAGE à Paris 1. 
Notre groupe est composé de :

+ [Madeleine SCHMIT](https://github.com/Madde24)
+ [Rebecca GRENET](https://github.com/Rbk98)
+ [Michael NAMET](https://github.com/Michael-Namet)
+ [Richard NAKARMI](https://github.com/Richard-Nkr)

## C'est quoi les Dix'Fi de Thymio ?

C'est une application web destinée à tous ceux qui aimeraient découvrir le monde de la programmation à travers des défis à réaliser avec un petit robot, nommé Thymio !

![Le Robot Thymio](thymio-colors.jpg)  

L'application a été conçue pour les enseignants qui souhaitent initier leurs élèves à la programmation, notamment à l'aide de Scratch. En effet, l'objectif était de faire apprendre à des enfants (8 à 13 ans), à travers un aspect ludique, la logique du code durant tout une semaine, appelée "la semaine des Dix’Fi de Thymio".  Pour ce faire, nous avons mis à disposition une brochure pour les professeurs, les élèves mais aussi les parents, proposant un programme à suivre lors de cette semaine. 

![La Semaine des Dix'Fi de  Thymio](La_semaine_des_dixfi_thymio.jpg)   

L'objectif est donc de réaliser les 10 défis (d'où le nom Dix'Fi :wink: ) ou plus si l'enseignant décide de créer ses défis soi-même !   
Les apprenants pourront alors repartir avec ce diplôme ci-dessous : 

![Certificat Thymio](certificatThymio.jpg)

## Pré-requis et installation   

+ <ins>Installation du logiciel Thymio Suite :</ins>

Pour pouvoir programmer les défis Thymio en Scrach, il faut installer le logiciel [Thymio Suite 2.1.5](https://www.thymio.org/fr/programmer/)  
et puis suivre les étapes [ici](https://www.thymio.org/fr/programmer/scratch/) pour utiliser l'interface Scratch.

+ <ins>Création d'un VirtualHost pour lancer le projet :</ins>

Pour que l'application fonctionne correctement en local, il faut obligatoirement lancer le projet à l'aide d'un VirtualHost.
Suivez [ces étapes](https://blog.smarchal.com/creer-un-virtualhost-avec-wampserver) pour créer un VirtualHost avec Wamp.

+ <ins>Installation de Node.js et yarn : </ins>

Installez [ici](https://nodejs.org/en/download/) Node.js. 

Lancez dans un terminal les commandes suivantes :

npm install --force
npm install -g yarn 

yanr encore dev
yarn encore production

+ <ins>Installation de l'extension mongodb : </ins>

Téléchargez le fichier php_mongodb.dll [ici](https://pecl.php.net/package/mongodb/1.8.1/windows) adapté à la version de votre PHP.

Extrayez l'archive et placez php_mongodb.dll dans votre répertoire d'extension PHP ("ext" par défaut).

Ajoutez la ligne suivante à votre fichier php.ini (clic gauche logo WAMP --> PHP --> php.ini) :

extension = php_mongodb.dll

+ <ins>Pré-requis permettant l'utilisation de l'API Youtube : </ins>

Ajouter (ce fichier)[https://drive.google.com/file/d/1eoHCGP9ofuyZGrciW6Wp5BpqdsRLHjRT/view?usp=sharing] dans le fichier ssl ("C:\wamp64\bin\php\php7.4.9\extras\ssl")  
Allez dans le php.ini (clic gauche logo WAMP --> PHP --> php.ini) dans 'Dynamic Extensions' et inserez cette ligne : extension=curl

+ <ins>Importation de la base de donnée MySQL</ins>

Téléchargez la BDD [ici](https://drive.google.com/file/d/1XgWPCdTJ3rO4SHRHwd8R9bW9eQFDBAmx/view?usp=sharing)
Allez sur phpMyAdmin et créer une nouvelle base de données dans laquelle vous devez importer le fichier téléchargé précédemment.

Ouvrez le projet DixFi-Thymio dans votre IDE, et accédez au fichier .env, et ajoutez cette ligne avec vos identifiants MySQL et le nom de la base de donnée :

DATABASE_URL="mysql://mysql://db_user:db_password@127.0.0.1:numeor_de_port/nom_de_la_base_de_donnee?serverVersion=5.7" 

+ <ins>Compte administrateur</ins>

Pour accéder à l'administration, connectez-vous avec ces identifiants : 

ID : 22  
Mot de passe : azeaze1

Puis dans l'URL, ajoutez "/admin".

## Langages et technos web utilisés ?

+ HTML5, CSS3, Sass, Bootsrap, JavaScript 
+ Twig
+ PHP (framework Symfony), ORM Doctrine, phpMyAdmin / MySQL, WAMP

## Présentation à l'aide de Prezi

Voici une [présentation](https://prezi.com/p/edit/grrifcavqgra/) vous permettant de comprendre davantage l'objectif que nous avons souhaité vous transmettre !

## Diagramme de classe

![diagram_class](diagram_class_DixFi.png)

