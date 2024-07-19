<?php

namespace App\Controller;


use App\Entity\Animal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('api/zoo', name: 'app_api_zoo_')]
class ZooController extends AbstractController
{
    #[Route(name: 'new', methods: 'POST')]
    public function new(): Response
    {
        $animal = new Animal();
        $animal->setName(name:'Sophie La Girafe');

    }

    #[Route('/show', name: 'show', methods: 'GET')]
    public function show(): Response
    {
        return $this->json(['message'=> 'animal de ma BDD']);
    }

    #[Route('/', name: 'edit', methods: 'PUT')]
    public function edit(): Response
    {
    }

    #[Route('/', name: 'delete', methods: 'DELETE')]
    public function delete(): Response
    {
    }
}
