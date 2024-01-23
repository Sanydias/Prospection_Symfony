<?php

namespace App\Tests\Unit;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UtilisateurTest extends KernelTestCase
{
    public function testSomething(): void
    {
        /* $kernel = */self::bootKernel();
        $container = static::getContainer();
        $utilisateur = new Utilisateur();
        $utilisateur -> setEmail('marie.dumas2002@gmail.com');
        $erreur = $container -> get('validator')->validate($utilisateur);
        $this -> assertCount(0, $erreur);
        //$this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
