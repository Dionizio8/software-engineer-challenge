<?php

class AccessEndpointTest extends TestCase
{
    public function testAccessPageIndex()
    {
        $this->get('/');

        $this->assertResponseStatus(200);
    }

    public function testAccessPageIndexPost()
    {
        $this->post('/');

        $this->assertResponseStatus(405);
    }

    public function testNotFoundEndPoint()
    {
        $this->get('/test-not-found-endpoint');

        $this->assertResponseStatus(404);
    }
}
