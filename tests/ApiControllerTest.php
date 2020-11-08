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
                "nameLastModifier":"1e9b5d1d-484e-4fd6-bd4e-9546360cb94d",
                "lastName":"Delon",
                "birth_date_string":"03-03-1997",
                "phoneNumber":"0345423218",
                "email":"fab.delon@cock.fr"
            }'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}