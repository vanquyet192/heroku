<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Order;
use App\Repository\OrderRepository;



class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $registry->getManager();
    }
    
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
{
    $products = $productRepository->findBy([], [], 8); 
    $macbookProducts = $this->getProductsByCategory('Macbook', 4);
    $iphoneProducts = $this->getProductsByCategory('Iphone', 4);
    $ipadProducts = $this->getProductsByCategory('IPad', 4);
    $aProducts = $this->getProductsByCategory('Airpods', 4);
    $sProducts = $this->getProductsByCategory('Smart watch', 4);
    return $this->render('home/index.html.twig', [
        'products' => $products,
        'macbookProducts' => $macbookProducts,
        'iphoneProducts' => $iphoneProducts,
        'ipadProducts' => $ipadProducts,
        'aProducts' => $aProducts,
        'sProducts' => $sProducts,
    ]);
}
private function getProductsByCategory(string $categoryName): array
{
    $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => $categoryName]);
    if (!$category) {
        return []; // Return an empty array if category not found
    }

    return $this->entityManager->getRepository(Product::class)->findBy(['category' => $category]);
}
    #[Route('/home1', name: 'app_home_all')]
    public function index2(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();  // Lấy 6 sản phẩm từ repository

        return $this->render('home/index.html1.twig', [
            'products' => $products,
        ]);
    }


    #[Route('/airpods', name: 'app_airpods')]
    public function airpodsIndex(ProductRepository $productRepository): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'AirPods']);
        $products = $productRepository->findBy(['category' => $category]);

        return $this->render('home/airpods/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/search', name: 'search')]
    public function search(Request $request, ProductRepository $productRepository): Response
    {
        $keyword = $request->query->get('keyword');

        $products = $productRepository->searchByKeyword($keyword);

        return $this->render('result/index.html.twig', [
            'products' => $products,
            'keyword' => $keyword,
        ]);
    }

    #[Route('/ipad', name: 'app_ipad')]
    public function ipadIndex(ProductRepository $productRepository): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'IPad']);
        $products = $productRepository->findBy(['category' => $category]);

        return $this->render('home/ipad/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/ipad/{id}', name: 'app_ipad_product_detail')]
    public function ipadProductDetail(Product $product): Response
    {
        return $this->render('product_detail/index.html.twig', [
            'product' => $product,
        ]);
    }
    #[Route('/iphone', name: 'app_iphone')]

    public function iphoneindex(ProductRepository $productRepository): Response
    {
        // Lấy danh sách sản phẩm của category "macbook"
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'Iphone']);
        $products = $productRepository->findBy(['category' => $category]);

        return $this->render('home/iphone/index.html.twig', [
            'products' => $products,
        ]);
    }
    #[Route('/macbook', name: 'app_macbook')]

    public function macbookindex(ProductRepository $productRepository): Response
    {
        // Lấy danh sách sản phẩm của category "macbook"
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'Macbook']);
        $products = $productRepository->findBy(['category' => $category]);

        return $this->render('home/macbook/index.html.twig', [
            'products' => $products,
        ]);
    }
    #[Route('/watch', name: 'app_watch')]

    public function watchindex(ProductRepository $productRepository): Response
    {
        // Lấy danh sách sản phẩm của category "macbook"
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'Smart watch']);
        $products = $productRepository->findBy(['category' => $category]);

        return $this->render('home/watch/index.html.twig', [
            'products' => $products,
        ]);
    }
}
