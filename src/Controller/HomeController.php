<?php

namespace App\Controller;

use App\Entity\CarteTodo;
use App\Form\AddCarteFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {

        // Afficher les infos

        $cartes = $this->entityManager->getRepository(CarteTodo::class);
        $cartes = $cartes->findAll();

        // Afficher le formulaire

        $carteTodo = new CarteTodo();
        $form = $this->createForm(AddCarteFormType::class, $carteTodo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $carteTodo = $form->getData();

            $this->entityManager->persist($carteTodo);
            $this->entityManager->flush();

            return $this->redirectToRoute("app_home");
        }
        
        // Afficher le rendu

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'cartes' => $cartes,
        ]);
    }

    
    #[Route('/delete/{id}', name: 'articles_delete')]
    public function deleteAction($id) {

        $req = $this->entityManager->getRepository(CarteTodo::class);
        $article = $this->entityManager->find(CarteTodo::class, $id);

        if (!$article) {
            throw $this->createNotFoundException(
                'There are no articles with the following id: ' . $id
            );
        }

        $req->remove($article);
        $this->entityManager->flush();

        return $this->redirectToRoute("app_home");

    }
}
