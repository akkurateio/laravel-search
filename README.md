# Laravel Search

This package provides a search engine for Akkurate Laravel Boilerplate. 

By default, the search is performed on specific fields of the Eloquent model via the Spatie [laravel-searchable](https://github.com/spatie/laravel-searchable) package.

If this is insufficient for the needs of the project, this package allows to set up an indexing in Elasticsearch.

## Installation

``` bash
composer require akkurate/laravel-search
```

Publish the configuration file:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelSearch\LaravelSearchServiceProvider" --tag="config"
```

Publish views:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelSearch\LaravelSearchServiceProvider" --tag="views"
```

Publish the partial of the View component for Elasticsearch:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelSearch\LaravelSearchServiceProvider" --tag="akk4search"
```

Publish entry views for the results page:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelSearch\LaravelSearchServiceProvider" --tag="entries"
```

## Eloquent

### Configuration

In the laravel-search configuration file, declare the models to search and the fields to search on:

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

By default, the Elastic version is not active.
In the app.js:

```js
import Akk4Search from 'akk4search_vuejs';
Vue.use(Akk4Search);
```
then
```shell script
npm run dev
```
In the .env:
```
// Akkurare For Search
AKKURATE_SEARCH_ENABLED=true

// Credentials
AKKURATE_SEARCH_KEY=your_api_key

// Activation of indexing (for Akkurate ecosystem models) on the model AKKURATE_SEARCH_PACKAGE_MODEL=bool
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

### Add an observer in the config file

Create the observer
```
php artisan search:make:observer Example
```
By default, the model is supposed to be in App\Models.

It is possible to change the path by providing a --namespace option. For example, if the model Example is in  Package\Models:
```
php artisan search:make:observer Example --namespace=Package\\Models
```

Fill in the url schema to reach the resource (to generate the link that will appear when the resource goes up in the search results).

For example: 
```
"brain/{uuid}/admin/users/$user->id"
```

Add the declaration in the config file
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

**index**: should the model be indexed or not.  

**where**: in the `search:sync` command, if you don't want to send all the results to the Elastic database, it is possible to fill in a where clause, for example`['status' => 'active']`.  

**route**: the resource access schema, to generate the url when using the CLI.  

**key**: the field defined to access the resource. By default 'id' if absent, but can be set to 'uuid' or 'slug', etc. as needed.  

**name**: the model field used to fill the name field in Elastic.

**suggest**: on FALSE the entry goes directly up in the results; on TRUE the entry does not go up in the results but is used to bring up related results.  

**env**: the environment in which the results are to be reported. 

**link**: the view to which the links for this model will point ('edit' or 'show').  

### Entities

A function in the model allows to define and update the entities (relations to be indexed) for a given model.

```
public function getEntities()
{
    return []; // logic to be defined for each model 
}
```

Example: define an ACCOUNT entity on each USER. On the model App\Models\User :
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

#### Check the connection with akk4search
```
php artisan search:check
```

#### Display the list of observed models
```
php artisan search:list
```
#### Synchronize data with the ElasticSearch database
```
php artisan search:sync
```
#### Test a keyword search
```
php artisan search:query subvitamine
```
#### Generate a new observer
```
php artisan search:make:observer
```
#### Delete data in the Elastic database
```
php artisan search:clear
```
Removes all elastic data of the observed models (set to TRUE in the .env) + their SQL searchables

```
php artisan search:clear --all
```
Removes all the elastic data related to the account (relative to the key filled in the .env) + their SQL searchables.

```
php artisan search:clear --entities=ADMIN_ACCOUNT --entities=ADMIN_USER
```
Removes all elastic data related to the doctype(s). Searchables must be deleted manually. 
```
php artisan search:clear --sync 
```
Removes all elastic data from the observed models and performs a synchronization.
