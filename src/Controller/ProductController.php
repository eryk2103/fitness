<?php 

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('products')]
class ProductController extends AbstractController 
{
    #[Route('', methods: ['GET'])]
    public function index(#[CurrentUser] User $user, ProductRepository $productRepo): Response
    {
        $products = $productRepo->findBy(['createdBy' => $user, 'archived' => false]);

        return $this->render('product/index.html.twig', ['products' => $products]);
    }

    #[Route('/new', methods: ['GET', 'POST'])]
    public function new(#[CurrentUser] User $user, Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedBy($user)
                ->setIsVerified(false)
                ->setArchived(false);

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('app_product_index');
        }

        return $this->render('product/new.html.twig', ['form' => $form]);
    }

    #[Route('/delete/{id}', methods: ['POST'])]
    public function delete(int $id, #[CurrentUser] User $user, Request $request, EntityManagerInterface $em, ProductRepository $productRepo): Response
    {
        $token = $request->request->get('_token');

        $product = $productRepo->findOneBy(['createdBy' => $user, 'id' => $id]);
        if($product === null) {
            $this->addFlash('error', 'Product not found');
        } 
        elseif($this->isCsrfTokenValid('delete-product'.$product->getId(), $token)) {
            if($product->isVerified()) {
                $product->setArchived(true);
                $em->persist($product);
                $em->flush();
            }
            else {
                $em->remove($product);
                $em->flush();
            }
            
            $this->addFlash('success', 'Product deleted successfully.');
        } else {
            $this->addFlash('error', 'Invalid CSRF token.');
        }

        return $this->redirectToRoute('app_product_index');
    }
}