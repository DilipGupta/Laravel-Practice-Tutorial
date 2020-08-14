<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testHomePageIsworkingCorrectly()
    {
        $response = $this->get('/');

        $response->assertSeeText('Dashboard');
        $response->assertSeeText('You are logged in!');
    }

    public function testContactPageIsworkingCorrectly()
    {
        $response = $this->get('/contact');

        $response->assertSeeText('Contact');
        $response->assertSeeText('Hello this is contact!');
    }
}

