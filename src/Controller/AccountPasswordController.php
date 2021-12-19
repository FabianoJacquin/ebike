<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    /**
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/account/change_password', name: 'account_password')]
    public function index(Request $request): Response
    {
        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $old_pwd = $form->get('old_password')->getData();
            $hash = $user->getPassword();

            if(password_verify($old_pwd, $hash)){

                $new_pwd = $form->get('new_password')->getData();
                $password = password_hash($new_pwd,PASSWORD_DEFAULT);
                $user->setPassword($password);
                $this->entityManager->flush();

                $notification = 'La password è stata aggiornata';

            } else {

                $notification = 'La password attuale non è corretta';

            }

        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
