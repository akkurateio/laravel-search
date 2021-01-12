# Laravel Search

Ce package propose un moteur de recherche pour Akkurate Laravel Boilerplate. 

Par défaut, la recherche s’effectue sur des champs spécifiques de model Eloquent via le package de Spatie [laravel-searchable](https://github.com/spatie/laravel-searchable).

Si c’est insuffisant pour les besoins du projet, ce package permet de mettre en place une indexation dans Elasticsearch.

## Installation

``` bash
composer require akkurate/laravel-search
```

Publier le fichier de configuration :
```bash
php artisan vendor:publish --provider="Akkurate\LaravelSearch\LaravelSearchServiceProvider" --tag="config"
```

Publier les vues :
```bash
php artisan vendor:publish --provider="Akkurate\LaravelSearch\LaravelSearchServiceProvider" --tag="views"
```

Publier le partial du composant Vue pour Elasticsearch :
```bash
php artisan vendor:publish --provider="Akkurate\LaravelSearch\LaravelSearchServiceProvider" --tag="akk4search"
```

Publier les vues des entrées pour la page de résultats :
```bash
php artisan vendor:publish --provider="Akkurate\LaravelSearch\LaravelSearchServiceProvider" --tag="entries"
```

## Eloquent

### Configuration

Dans le fichier de configuration laravel-search, déclarer les models à rechercher et les champs sur lesquels effectuer la recherche :

```php
'eloquent' => [
    'searchable' => [
        [
            'model' => \Akkurate\LaravelCore\Models\Account::class,
            'attributes' => ['name']
        ],
        [
            'model' => \Akkurate\LaravelCore\Models\User::class,
            'attributes' => ['firstname', 'lastname', 'email']
        ],
        [
            'model' => \Akkurate\LaravelBlog\Models\Article::class,
            'attributes' => ['title', 'overview', 'description']
        ],
        [
            'model' => \Akkurate\LaravelCrm\Models\Company::class,
            'attributes' => ['name', 'overview']
        ],
        [
            'model' => \Akkurate\LaravelCrm\Models\Contact::class,
            'attributes' => ['firstname', 'lastname', 'job']
        ],
        [
            'model' => \Akkurate\LaravelCrm\Models\Lead::class,
            'attributes' => ['reference', 'name', 'overview']
        ],
        [
            'model' => \Akkurate\LaravelFaq\Models\Question::class,
            'attributes' => ['title', 'content']
        ],
    ],
],
```

## Elastic

### Configuration

Par défaut, la version Elastic, n’est pas active.

Dans le fichier app.js :

```js
import Akk4Search from 'akk4search_vuejs';
Vue.use(Akk4Search);
```
puis
```shell script
npm run dev
```

Dans le .env :

```
// Akkurare For Search
AKKURATE_SEARCH_ENABLED=true

// Credentials
AKKURATE_SEARCH_KEY=your_api_key

// Activation de l’indexation (pour les modèles de l'écosystème Akkurate) sur le modèle AKKURATE_SEARCH_PACKAGE_MODEL=bool
AKKURATE_SEARCH_ADMIN_USER=true
AKKURATE_SEARCH_ADMIN_ACCOUNT=true
AKKURATE_SEARCH_BLOG_ARTICLE=true
AKKURATE_SEARCH_BLOG_THEMATIC=true
AKKURATE_SEARCH_BOOKMARK_ITEM=true
AKKURATE_SEARCH_BOOKMARK_CATEGORY=true
AKKURATE_SEARCH_CONTACT_ADDRESS=true
AKKURATE_SEARCH_CONTACT_EMAIL=true
AKKURATE_SEARCH_CONTACT_PHONE=true
AKKURATE_SEARCH_CRM_COMPANY=true
AKKURATE_SEARCH_CRM_CONTACT=true
AKKURATE_SEARCH_CRM_LEAD=true
AKKURATE_SEARCH_DOCUMENTATION_=true
AKKURATE_SEARCH_DOCUMENTATION_=true
AKKURATE_SEARCH_FAQ_QUESTION=true
AKKURATE_SEARCH_GLOSSARY_TERM=true
AKKURATE_SEARCH_HELPDESK_CATEGORY=true
AKKURATE_SEARCH_HELPDESK_TICKET=true
AKKURATE_SEARCH_HELPDESK_MEDIA_RESOURCE=true
```

### Ajouter un observer dans le fichier de config

Créer l’observer
```
php artisan search:make:observer Example
```
Par défaut, le model est supposé se trouver dans App\Models.

Il est possible de modifier le chemin en fournissant une option --namespace. Par exemple, si le model Example se trouve dans Package\Models :
```
php artisan search:make:observer Example --namespace=Package\\Models
```

Renseigner dans l’observer le schéma de l’url pour atteindre la ressource (pour générer le lien qui apparaîtra lorsque la ressource remontera dans les résultats de recherche).

Par exemple : 
```
"brain/{uuid}/admin/users/$user->id"
```

Ajouter la déclaration dans le fichier de config
```
'indexable' => [
    'my-custom-observer' => [
        'index' => true,
        'model' => \App\Models\AnyModel::class,
        'where' => [],
        'observer' => \App\Observers\Example::class,
        'route' => 'brain/{uuid}/admin/users'
        'key' => 'uuid'
        'name' => 'title',
        'suggest' => false,
        'env' => ['BACK'],
        'link' => 'show'
    ],
    ...
]
```

index : le model doit-il être indexé ou non.  

**where** : lors de la commande `search:sync`, si on ne souhaite envoyer de base tous les résultats dans la base Elastic, il est possible de renseigner une clause where, pas exemple `['status' => 'active']`.  

**route** : le schéma d’accès à la ressource, pour générer l’url lors de l’utilisation du CLI.  

**key** : le champ défini pour accéder à la ressource. Par défaut 'id' si absent, mais peut être renseigné sur 'uuid' ou 'slug', etc. selon les besoins.  

**name** : le champ du model utilisé pour remplir le champ name dans Elastic.  

**suggest** : sur FALSE l’entrée remonte directement dans les résultats ; sur TRUE l'entrée ne remonte pas dans les résultats mais sert à faire remonter des résultats liés.  

**env** : l’environnement dans lequel les résultats doivent remonter.  

**link** : la vue sur laquelle pointeront les liens pour ce model ('edit' ou 'show').  

### Entities

Une fonction dans le model permet de définir et mettre à jour les entities (relations à indexer) pour un model donné.

```
public function getEntities()
{
    return []; // logique à définir pour chaque model 
}
```

Exemple : définir une entity ACCOUNT sur chaque USER. Sur le model App\Models\User :
```
public function getEntities()
{
    return [
            'uuid' => $this->account->searchable->uuid,
            'name' => $this->account->searchable->name,
        ];
}
```

### CLI

#### Vérifier la connexion avec akk4search
```
php artisan search:check
```

#### Afficher la liste des modèles observés
```
php artisan search:list
```
#### Synchroniser les données avec la base ElasticSearch
```
php artisan search:sync
```
#### Tester une recherche par mot-clé
```
php artisan search:query subvitamine
```
#### Générer un nouvel observer
```
php artisan search:make:observer
```
#### Supprimer des données dans la base Elastic
```
php artisan search:clear
```
Supprime toutes les données elastic des models observés (définis à TRUE dans le .env) + leurs searchables SQL

```
php artisan search:clear --all
```
Supprime toutes les données elastic liées au compte (relatives à la clé renseignée dans le .env) + leurs searchables SQL

```
php artisan search:clear --entities=ADMIN_ACCOUNT --entities=ADMIN_USER
```
Supprime toutes les données elastic liées au(x) doctype(s). Les searchables sont à supprimer manuellement. 
```
php artisan search:clear --sync 
```
Supprime toutes les données elastic des models observés et effectue une synchro
