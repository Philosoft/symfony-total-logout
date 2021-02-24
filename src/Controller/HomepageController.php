<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();
        if ($user === null) {
            $user = new User();
            $user->setUsername('anon');
        }

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'user' => $user,
            'status' => $user->getUsername() === 'anon' ? 'unknown' : 'well-known',
        ]);
    }
}
