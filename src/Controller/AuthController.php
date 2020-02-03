<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $email = $request->request->get('email');
        
        $user = new User();

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($encoder->encodePassword($user, $password));
        
        $em->persist($user);
        $em->flush();
        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }
  
    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
}