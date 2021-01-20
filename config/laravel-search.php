<?php

return [

    'middleware' => ['web', 'auth'],
    'prefix' => 'brain/{uuid}',
    'pagination' => 20,
    'eloquent' => [
        'searchable' => [
            [
                'model' => accountClass(),
                'attributes' => ['name']
            ],
            [
                'model' => userClass(),
                'attributes' => ['firstname', 'lastname', 'email']
            ],
//            [
//                'model' => \Akkurate\LaravelBlog\Models\Article::class,
//                'attributes' => ['title', 'overview', 'description']
//            ],
//            [
//                'model' => \Akkurate\LaravelCrm\Models\Company::class,
//                'attributes' => ['name', 'overview']
//            ],
//            [
//                'model' => \Akkurate\LaravelCrm\Models\Contact::class,
//                'attributes' => ['firstname', 'lastname', 'job']
//            ],
//            [
//                'model' => \Akkurate\LaravelCrm\Models\Lead::class,
//                'attributes' => ['reference', 'name', 'overview']
//            ],
//            [
//                'model' => \Akkurate\LaravelFaq\Models\Question::class,
//                'attributes' => ['title', 'content']
//            ],
        ],
    ],
    'elastic' => [
        'enabled' => env('AKKURATE_SEARCH_ENABLED', false),
        'credentials' => [
            'key' => env('AKKURATE_SEARCH_KEY', null),
            'username' => env('AKKURATE_SEARCH_USERNAME', null),
            'password' => env('AKKURATE_SEARCH_PASSWORD', null)
        ],
        'indexable' => [
            // Add any custom observer
//        'ANOTHER_DOCYTYPE' => [
//            'index' => true,
//            'model' => \App\Models\AnyModel::class,
//            'where' => [],
//            'observer' => \App\Observers\MyCustomObserver::class,
//            'route' => 'brain/{uuid}/app/examples',
//            'name' => 'title',
//            'suggest' => true,
//            'env' => ['BACK'],
//            'link' => 'show'
//        ],
            // Package Laravel Admin
            'ADMIN_ACCOUNT' => [
                'index' => env('AKKURATE_SEARCH_ADMIN_ACCOUNT', false),
                'model' => \Akkurate\LaravelCore\Models\Account::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Admin\AccountObserver::class,
                'name' => 'name',
                'suggest' => true,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            'ADMIN_USER' => [
                'index' => env('AKKURATE_SEARCH_ADMIN_USER', false),
                'model' => \App\Models\User::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Admin\UserObserver::class,
                'route' => 'brain/{uuid}/admin/users',
                'name' => 'fullname',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'edit'
            ],
            // Package Laravel Blog
            'BLOG_THEMATIC' => [
                'index' => env('AKKURATE_SEARCH_BLOG_THEMATIC', false),
                'model' => \Akkurate\LaravelBlog\Models\Thematic::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Blog\ThematicObserver::class,
                'route' => 'brain/{uuid}/blog/thematics',
                'key' => 'slug',
                'name' => 'title',
                'suggest' => true,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            'BLOG_ARTICLE' => [
                'index' => env('AKKURATE_SEARCH_BLOG_ARTICLE', false),
                'model' => \Akkurate\LaravelBlog\Models\Article::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Blog\ArticleObserver::class,
                'route' => 'brain/{uuid}/blog/articles',
                'key' => 'slug',
                'name' => 'title',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'edit'
            ],
            // Package Laravel Bookmark
            'BOOKMARK_CATEGORY' => [
                'index' => env('AKKURATE_SEARCH_BOOKMARK_CATEGORY', false),
                'model' => \Akkurate\LaravelBookmark\Models\Category::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Bookmark\CategoryObserver::class,
                'route' => 'brain/{uuid}/bookmark/categories',
                'name' => 'name',
                'suggest' => true,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            'BOOKMARK_ITEM' => [
                'index' => env('AKKURATE_SEARCH_BOOKMARK_ITEM', false),
                'model' => \Akkurate\LaravelBookmark\Models\Item::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Bookmark\ItemObserver::class,
                'route' => 'brain/{uuid}/bookmark/items',
                'name' => 'name',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            // Package Laravel Contact
            'CONTACT_ADDRESS' => [
                'index' => env('AKKURATE_SEARCH_CONTACT_ADDRESS', false),
                'model' => \Akkurate\LaravelContact\Models\Address::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Contact\AddressObserver::class,
                'route' => 'brain/{uuid}/contact/addresses',
                'name' => 'name',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            'CONTACT_EMAIL' => [
                'index' => env('AKKURATE_SEARCH_CONTACT_EMAIL', false),
                'model' => \Akkurate\LaravelContact\Models\Email::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Contact\EmailObserver::class,
                'route' => 'brain/{uuid}/contact/emails',
                'name' => 'name',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            'CONTACT_PHONE' => [
                'index' => env('AKKURATE_SEARCH_CONTACT_PHONE', false),
                'model' => \Akkurate\LaravelContact\Models\Phone::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Contact\PhoneObserver::class,
                'route' => 'brain/{uuid}/contact/phones',
                'name' => 'name',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            // Package Laravel CRM
            'CRM_COMPANY' => [
                'index' => env('AKKURATE_SEARCH_CRM_COMPANY', false),
                'model' => \Akkurate\LaravelCrm\Models\Company::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Crm\CompanyObserver::class,
                'route' => 'brain/{uuid}/crm/companies',
                'name' => 'name',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            'CRM_CONTACT' => [
                'index' => env('AKKURATE_SEARCH_CRM_CONTACT', false),
                'model' => \Akkurate\LaravelCrm\Models\Contact::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Crm\ContactObserver::class,
                'route' => 'brain/{uuid}/crm/contacts',
                'name' => 'lastname',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            'CRM_LEAD' => [
                'index' => env('AKKURATE_SEARCH_CRM_LEAD', false),
                'model' => \Akkurate\LaravelCrm\Models\Lead::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Crm\LeadObserver::class,
                'route' => 'brain/{uuid}/crm/leads',
                'name' => 'name',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            // Package Laravel Documentation
            'DOCUMENTATION_PAGE' => [
                'index' => env('AKKURATE_SEARCH_DOCUMENTATION_PAGE', false),
                'model' => \Akkurate\LaravelDocumentation\Models\Page::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Documentation\PageObserver::class,
                'route' => 'brain/{uuid}/documentation/pages',
                'name' => 'title',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            'DOCUMENTATION_SECTION' => [
                'index' => env('AKKURATE_SEARCH_DOCUMENTATION_SECTION', false),
                'model' => \Akkurate\LaravelDocumentation\Models\Section::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Documentation\SectionObserver::class,
                'route' => 'brain/{uuid}/documentation/sections',
                'name' => 'title',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            // Package Laravel Faq
            'FAQ_QUESTION' => [
                'index' => env('AKKURATE_SEARCH_FAQ_QUESTION', false),
                'model' => \Akkurate\LaravelFaq\Models\Question::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Faq\QuestionObserver::class,
                'route' => 'brain/{uuid}/faq/questions',
                'name' => 'title',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            // Package Laravel Glossary
            'GLOSSARY_TERM' => [
                'index' => env('AKKURATE_SEARCH_GLOSSARY_TERM', false),
                'model' => \Akkurate\LaravelGlossary\Models\Term::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Glossary\TermObserver::class,
                'route' => 'brain/{uuid}/glossary/terms',
                'name' => 'name',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'edit'
            ],
            // Package Laravel Helpdesk
            'HELPDESK_CATEGORY' => [
                'index' => env('AKKURATE_SEARCH_HELPDESK_CATEGORY', false),
                'model' => \Akkurate\LaravelHelpdesk\Models\Category::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Helpdesk\CategoryObserver::class,
                'route' => 'brain/{uuid}/helpdesk/categories',
                'name' => 'name',
                'suggest' => true,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            'HELPDESK_TICKET' => [
                'index' => env('AKKURATE_SEARCH_HELPDESK_TICKET', false),
                'model' => \Akkurate\LaravelHelpdesk\Models\Ticket::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Helpdesk\TicketObserver::class,
                'route' => 'brain/{uuid}/helpdesk/tickets',
                'name' => 'subject',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
            // Package Laravel Media
            'MEDIA_RESOURCE' => [
                'index' => env('AKKURATE_SEARCH_MEDIA_RESOURCE', false),
                'model' => \Akkurate\LaravelMedia\Models\Resource::class,
                'observer' => \Akkurate\LaravelSearch\Observers\Media\ResourceObserver::class,
                'route' => 'brain/{uuid}/media/resources',
                'name' => 'name',
                'suggest' => false,
                'env' => ['BACK'],
                'link' => 'show'
            ],
        ],
    ],
];
