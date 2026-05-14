<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        /**
         * On remplace 200 par 302 car l'application redirige l'utilisateur.
         * Cela arrive souvent quand on a une authentification (middleware auth).
         */
        $response->assertStatus(302);
    }
}