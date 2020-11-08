<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testNewTenant()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/tenant/new/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name":"Fabien",
                "nameLastModifier":"15a89a55-e6b0-4f8f-a2ea-2a8bdc877495",
                "lastName":"Delon",
                "birth_date_string":"03-03-1997",
                "phoneNumber":"0345423218",
                "email":"fab.delon@cock.fr"
            }'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testEditTenant()
    {
        $client = static::createClient();

        $client->request(
            'PUT',
            '/api/tenant/edit/5e90efbf-a3e8-4fcf-be8f-31705f7439cc',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name":"Fabidsgfn",
                "nameLastModifier":"15a89a55-e6b0-4f8f-a2ea-2a8bdc877495",
                "lastName":"Delqrzgfdsdn",
                "birth_date_string":"03-03-2007",
                "phoneNumber":"0000000000",
                "email":"fab.delgefdsdson@cock.fr"
            }'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testNewCollection()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/collection/new/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name":"Immeuble Weshh",
                "accountId":"3542d151-b829-4f46-b8d1-234ee62a506a"
            }'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testEditCollection()
    {
        $client = static::createClient();

        $client->request(
            'PUT',
            '/api/collection/edit/088a8149-7015-4f63-93a3-a311b71a7f46',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name":"Immeuble Jolie",
                "accountId":"3542d151-b829-4f46-b8d1-234ee62a506a"
            }'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testNewLodging()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/lodging/new/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "lodging_category_id":"06b45387-1a9d-4f31-a4ac-19749b926e82",
                "lodging_type_id":"1189b38b-c10f-4f2e-be7e-561cc58408e9",
                "lodging_collection_id":"088a8149-7015-4f63-93a3-a311b71a7f46",
                "nameLastModifier":"15a89a55-e6b0-4f8f-a2ea-2a8bdc877495",
                "state":"libre",
                "name":"Appartement 404",
                "price":765
            }'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}