<?php

namespace Akkurate\LaravelSearch\Tests;

use Akkurate\LaravelAccountSubmodule\LaravelAccountSubmoduleServiceProvider;
use Akkurate\LaravelBackComponents\LaravelBackComponentsServiceProvider;
use Akkurate\LaravelSearch\LaravelSearchServiceProvider;
use Akkurate\LaravelSearch\Tests\Fixtures\Account;
use Akkurate\LaravelSearch\Tests\Fixtures\Language;
use Akkurate\LaravelSearch\Tests\Fixtures\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();

        $this->createUser();

        $this->user = User::first();
        auth()->login($this->user);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelBackComponentsServiceProvider::class,
            LaravelSearchServiceProvider::class,
            PermissionServiceProvider::class,
            LaravelAccountSubmoduleServiceProvider::class,
        ];
    }

    protected function setUpDatabase()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default('');
            $table->string('label')->nullable();
            $table->string('locale');
            $table->string('locale_php');
            $table->integer('priority')->nullable()->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_default')->default(0);
            $table->timestamps();
        });

        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('preferenceable_id');
            $table->string('preferenceable_type');
            $table->enum('target', ['both', 'b2c', 'b2b'])->nullable()->default('both');
            $table->integer('pagination')->nullable()->default(30);
            $table->foreignId('language_id')->nullable()->constrained('languages');
            $table->timestamps();
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default('');
            $table->string('name');
            $table->string('slug');
            $table->string('email')->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default('');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::create('admin_account_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
        });

        include_once __DIR__. '/../vendor/spatie/laravel-permission/database/migrations/create_permission_tables.php.stub';

        (new \CreatePermissionTables())->up();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function createUser()
    {
        Language::create([
            'label' => 'français',
            'locale' => 'fr',
            'locale_php' => 'fr_FR',
            'is_default' => 1
        ]);

        $account = Account::create([
            'name' => 'Account',
            'slug' => 'account',
            'email' => 'account@email.com',
        ]);

        $user = User::forceCreate([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => 'test',
            'account_id' => $account->id,
        ]);

        $user->preference()->create([
            'language_id' => 1
        ]);
    }
}
