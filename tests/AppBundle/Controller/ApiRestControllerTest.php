<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiRestControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();

        $client->request('GET', '/fizzbuzz/-15/15');

        // Check code 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Check the format is a json
        $this->assertTrue($client->getResponse()->headers->contains(
            'Content-Type',
            'application/json'
        ));

        // Check the expected result
        $result = '["FizzBuzz",-14,-13,"Fizz",-11,"Buzz","Fizz",-8,-7,"Fizz","Buzz",-4,"Fizz",-2,-1,0,1,2,"Fizz",4,"Buzz","Fizz",7,8,"Fizz","Buzz",11,"Fizz",13,14,"FizzBuzz"]';
        $this->assertEquals($client->getResponse()->getContent(), $result);
    }

    public function testIndexErrorsAction()
    {
    	$result = '[]';

        $client = static::createClient();

        $client->request('GET', '/fizzbuzz/15/1');

        $this->assertEquals($client->getResponse()->getContent(), $result);

        $client->request('GET', '/fizzbuzz/aa/bb');

        $this->assertEquals($client->getResponse()->getContent(), $result);

        $client->request('GET', '/fizzbuzz/1.5/10.25');

        $this->assertEquals($client->getResponse()->getContent(), $result);

        $client->request('GET', '/fizzbuzz/0/9999999999999');

        $this->assertEquals($client->getResponse()->getContent(), $result);
    }
}
