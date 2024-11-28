<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Team;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    #[Route('/categorie_add', methods: ['POST', 'GET'], name: "categorie.add")]
    public function createCategorie(Request  $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);

        if ($form->isSubmitted()) {
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('categorie.all');
        }

        return $this->render('categorie/add.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/categories', methods: ['GET'], name:'categorie.all')]
    public function showAllCategorie(EntityManagerInterface $entityManager): Response 
    {
        $categories = $entityManager->getRepository(categorie::class)->findAll();

        if(!$categories) {
            throw $this->createNotFoundException(
                'No categories found'
            );
        }
        return $this->render('categorie/categories.html.twig', ['categories' => $categories]);
    }

    #[Route('/categorie/{id}', methods: ['GET'], name: "categorie")]
    public function  show(EntityManagerInterface $entityManager, int $id): Response 
    {
        $categorie = $entityManager->getRepository(categorie::class)->find($id);

        if(!$categorie) {
            throw $this->createNotFoundException(
                'No teams found'
            );
        }

        return $this->render('categorie/categorie.html.twig', [
            'id' => $categorie->getId(),
            'nom' => $categorie->getNom(),
            'description' => $categorie->getDescription()
        ]);
    }

    #[Route('/categorie/edit/{id}', name: 'categorie.edit')]
    public function update( Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
                
        $categorie = $entityManager->getRepository(categorie::class)->find($id);
        
        if(!$categorie) {
            throw $this->createNotFoundException(
                'No team found for id'.$id
            );
        }

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager->flush();
            return $this->redirectToRoute('categorie.all');
        }

        return $this->render('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form
        ]);
    }

    #[Route('/categorie/{id}', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse 
    {
        $categorie = entityManager->getRepository(team::class)->find($id);

        if(!$categorie) {
            throw $this->createNotFoundException(
                'No category found for id '.$id
            );
        }

        try {
            $entityManager->remove($categorie);
            $entityManager->flush();

            return $this->json(['message' => 'Successfully deleted category '.$categorie->getNom()], 200);
        } catch (\Exception $e) {
            return $this->json(['message' => 'Couldnt dete category '.$categorie->getNom()] , 500);
        }
    }
}
