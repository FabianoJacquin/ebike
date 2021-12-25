<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Size;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        $sizes = $this->entityManager->getRepository(Size::class)->findAll();

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'sizes' => $sizes
        ]);
    }

    #[Route('/search', name: 'search')]
    public function search(Request $request): Response
    {
        $parameters = $request->request->all();

        $products = $this->entityManager->getRepository(Product::class)->findWithSearch($parameters);

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);

    }
}
