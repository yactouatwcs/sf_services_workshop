<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CurrencyConverterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private function updateProductDollarPrice(Product $product, CurrencyConverterService $currencyConverterService) {
        $product->setDollarPrice(
            $currencyConverterService->convertEurToDollar(
                $product->getPrice()
            )
        );
        return $product;
    }

    private function updateProductYenPrice(Product $product, CurrencyConverterService $currencyConverterService) {
        $product->setYenPrice(
            $currencyConverterService->convertEurToYen(
                $product->getPrice()
            )
        );
        return $product;
    }

    #[Route('/product', name: 'app_product')]
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository, CurrencyConverterService $currencyConverterService): Response
    {
        $products = $productRepository->findAll();
        foreach ($products as $product) {
            $product = $this->updateProductDollarPrice($product, $currencyConverterService);
        }
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_details')]
    public function show(Product $product, CurrencyConverterService $currencyConverterService): Response
    {
        $product = $this->updateProductDollarPrice($product, $currencyConverterService);
        $product = $this->updateProductYenPrice($product, $currencyConverterService);
        return $this->render('product/details.html.twig', [
            'product' => $product,
            'dollar_price' => $product->getDollarPrice(),
            'yen_price' =>  $product->getYenPrice(),
        ]);
    }
}
