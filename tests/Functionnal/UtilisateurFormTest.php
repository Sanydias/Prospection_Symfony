<?php

namespace App\Tests\Functionnal;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UtilisateurFormTest extends WebTestCase
{
    public function testSomething(): void
    {
        // $client = static::createClient();
        // $urlgenerator = $client -> getContainer() -> get('router');
        // $crawler = $client->request(Request::METHOD_GET, $urlgenerator -> generate('add_utilisateur'));
        // $form = $crawler -> filter('form[name=categories_form]') -> form([
        //     'categorie_form[nomUtilisateur]' => 'test',
        // ]);
        // $client -> submit($form);
        // $this -> assertResponseStatusCodeSame(Response::HTTP_FOUND);
        // $client -> followRedirect();
        // $this -> assertRouteSame('/compte/list');
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/inscription');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Inscription');
    }
}
