<?php

namespace Akkurate\LaravelSearch\Tests;

use Akkurate\LaravelSearch\Tests\Fixtures\Account;
use Akkurate\LaravelSearch\Tests\Fixtures\User;
use Illuminate\Support\Facades\Route;

class SearchControllerTest extends TestCase
{
    /** @test */
    public function it_should_a_find_an_user()
    {

        $user = auth()->user();

        config()->set('laravel-search.eloquent.searchable', [
            [
                'model' => User::class,
                'attributes' => ['name', 'email']
            ]
        ]);

        $response = $this->post(route('search', ['uuid' => $user->account->slug]), [
            'query' => 'user',
            'token' => csrf_token()
        ]);

        dd($response);
    }
}
