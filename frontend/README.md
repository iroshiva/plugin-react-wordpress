
# Plugin pour ajout d'une appli React à Wordpress via un shortcode

## Déroulé de la créatio step by step

https://sidoine.org/how-to-use-react-inside-a-wordpress-application/

## my-react-app.php

Initialisation du plugin :
- gère les assets de l'app react avec wp
- créer le shortcode à mettre dans wp pour brancher l'app react

## Dossier frontend

Contient l'application react

### initialisation

```sh
$ yarn install && yarn start
```

### librairie craco

https://craco.js.org/docs/

Permet notamment : 
- d'ajouter / enlever des plugin à la config webpack de base
- de modifier / overrider la configuration des plugins webpack de base

Ont été ajouté : 
- TerserPlugin : minification du js
- OptimizeCssAssetsPlugin : minification du css


## Configuration pour le build prod

```sh
$ yarn build
```

### problématique

En buildant l'app
- création de chunks par webpack avec des hash qui changent à chaque build
- pose un pb pour enregistrer les assets dans wordpress avec wp_register_script et wp_register_style

### solutions

- utilisation du fichier asset-manifest.json généré par le plugin webpack WebpackManifestPlugin
- création d'une fonction dans my-react-app.php qui va charger ce fichier et chercher le nom du fichier avec le hash pour le wp_register_script et wp_register_style