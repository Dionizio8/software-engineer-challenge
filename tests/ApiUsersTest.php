<?php

class ApiUsersTest extends TestCase
{

    public function testResponseJson()
    {
        $this->get("users?search=Gabriel Dionizio");
        $this->seeStatusCode(200);

        $this->seeJsonStructure(
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
        $response = $this->get('users?search=Ga');
        $response
        ->seeStatusCode(200)
        ->seeJson(['data'=>[]])
        ->seeJson(['total'=>0]);
    }
}
