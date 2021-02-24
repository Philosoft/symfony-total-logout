<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordController extends AbstractController
{
    /**
     * @Route("/password", name="password", methods={"GET"})
     */
    public function index(): Response
    {
        $this->getCurrentUser();

        return $this->render('password/index.html.twig', [
            'controller_name' => 'PasswordController',
        ]);
    }

    /**
     * @Route("/change", name="change_password", methods={"POST"})
     */
    public function change(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        Request $request
    ): Response {
        $newPassword = $request->request->get('newPassword', '');
        if ($newPassword === '') {
            throw new BadRequestException('no new password provided');
        }

        $currentUser = $this->getCurrentUser();
        $currentUser->setPassword($passwordEncoder->encodePassword($currentUser, $newPassword));
        $entityManager->persist($currentUser);
        $entityManager->flush();

        return new RedirectResponse($this->generateUrl('password'));
    }

    private function getCurrentUser(): User
    {
        /** @var User|null $currentUser */
        $currentUser = $this->getUser();
        if ($currentUser === null) {
            throw new AccessDeniedHttpException('Only authenticated users can do that');
        }

        return $currentUser;
    }
}
