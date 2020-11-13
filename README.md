# stack docker symple

- serveur web : nginx 
    - http://localhost:8181
    
 ## Formation 
 
 ### 1. route
 
mise en place sur pojet, mise en place de plusieurs bundel 

- pour avoir un beau système de route 
```
composer require altorouter/autorouter:1.2.0
```
- pour avoir le système de debug de symfony
```
composer require symfony/var-dumper
```
- pour avoir un jolie système de debug php sur le sitre
```
composer require symfony/var-dumper
```

 ## 2.remplir la bd 
 
 utiliser de faker pour générer des donner aléatoire dans différents formats
 
```
composer require fzaninotto/faker:1.8.0
```
On supprimer intégralement la bas de donner 

Et on géner des donner aléatoirement avec des boucles

## 3. Listing des articles

on a vu comment crée notre propre système de route 

On a vu aussi comment mettre une limite de text sur un acticle 

Mettre des information dans la base de donner dans un liens

Comment definir des élément des la basse de donner 


## 4. Pagination

On a vu comment mettre en plage une pagination, ainsi que bloquer une url ou de la retunée, 
et mise en place de la pagination sur la index.php

 
## 5. Revu de la logique de la pagination 

on a revu la logique de la pagination pour alleger l'index.php, donc nous avons crée des fonction 
pour les réutiliser plus part dans l'application
 
## 6. Page post

on a vu comment mettre afficher  un seul post sur une page, avec url qui a pour paramettre 
un slug et un id, puis on a afficher les catégorie relier au post


## 7. Page category post

Listing dans des catégory sur la page (pas grand choses de nouveau par rapport au listing de post)

## 8. Revu de la pagination 

gros refont de la pafination, crée un controller avec tout les fonction de la pagination(
on a fais quelque choses de propre)

## 9. Ajout des noms de category dans les card

on a vu comment importer les noms des category sur les cads de posts. Et nous avons aléger le code 


## 10. Création de class

Nous avons ceée des controller pour allerger notre code, et ainsi réutiliser les tables un px partout sur notre 
site internet 


## 11. Administation

Nous avons lister des articles et mise en place le button delete pour supprimer un acticle, 
prepare les page pour crée un article


## 12. Edition d'un article

Nous avons vu comment editer un article (partie un px complique beaucoup de choses a retenir) aussi nous avons vu comment
mettre une router en GET et POST et nous avons aussi utiliser un bundel pour allèger notre validation 
```
composer require vlucas/valitron:1.4.5
``` 


## 13. Gestion des formulaires

Nous avons crée plusieurs champs pour mosdier l'article et nous avons un controller pour la gestion des formulaire 
et nous avons aussi changer la requet SQL pour update


## 14. Validée les donnée 

Nous avons vu comment simplifier le code pour validé notre formulaire

## 15. création d'un article

Nous avons vu comment crée un article en modifiant la requet sql et nous avons aussi mit un boutons sur la page des
listing

## 15. Gestion des catégories
Nous avons realiser la partie pour la gestion des categories, rien de trés compliqer nous avons deja eux en plusieurs 
etapes 

## 16. Authentification

Nous avons vu comment mettre une restrition pour les personne non admin et une page loyout