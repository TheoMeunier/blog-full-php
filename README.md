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

