<?php

namespace Akkurate\LaravelSearch\Tests;

// use PHPUnit\Framework\TestCase; apparemment pas la bonne class pour les post https://stackoverflow.com/questions/62987090/how-to-fix-undefined-method-errors-in-laravel-7-x-phpunit
use Illuminate\Foundation\Testing\TestCase;

class SearchControllerTest extends TestCase
{
    /** @test */
    public function it_should_a_find_an_user()
    {
        $response = $this->post(route('search'), [
            'query' => 'user',
            'token' => csrf_token()
        ]);
        dd($response);
    }

    public function createApplication()
    {
        // TODO: Implement createApplication() method.
    }
}
