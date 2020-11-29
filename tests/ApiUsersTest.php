<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Models\User;

class ApiUsersTest extends TestCase
{
    use DatabaseMigrations;

    public function testResponseJson()
    {
        User::factory()->create([
            'name' => 'Gabriel Dionizio',
        ]);

        User::factory()->create([
            'username' => 'gabriel.dionizio',
        ]);

        User::factory()->create([
            'name' => 'Ana Maria',
        ]);

        User::factory()->create([
            'name' => 'Lucas Ribeiro',
        ]);

        $this->get("users?search=Gabriel Dionizio");
        $this->seeStatusCode(200)
            ->seeJson(['total' => 2])
            ->seeJsonStructure(
                [
                    'current_page',
                    'data' => ['*' => ['uuid', 'username', 'name', 'relevance']],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links' => ['*' => ['url', 'label', 'active']],
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total'
                ]
            );
    }

    public function testKeywordMinimumThreeLetters()
    {
        User::factory()->create([
            'name' => 'Gabriel Dionizio',
        ]);

        $response = $this->get('users?search=Ga');
        $response->seeStatusCode(200)
            ->seeJson(['data' => []])
            ->seeJson(['total' => 0]);
    }
}
