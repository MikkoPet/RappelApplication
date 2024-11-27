<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    #[Route('/categorie', methods: ['POST'])]
    public function createCategorie(Request  $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode(json: $request->getContent(), associative: true);

        $categorie = new Categorie();
        $categorie->setNom(Nom: $data['nom'] ?? '');
        $categorie->setDescription(Description: $data['description'] ?? '');
        
        $entityManager->persist($categorie);
        $entityManager->flush();

        return $this->json(['id' => $categorie->getId(),
                            'nom' => $categorie->getNom(),
                            'description' => $categorie->getDescription() ],
                            201);
    }

    #[Route('/categorie', methods: ['GET'])]
    public function showAllCategorie(EntityManagerInterface $entityManager): JsonResponse 
    {
        $categories = $entityManager->getRepository(categorie::class)->findAll();

        if(!$categories) {
            throw $this->createNotFoundException(
                'No teams found'
            );
        }

        return $this->json(['teams' => array_map(callback:function($categorie): array {
            return[
                'id' => $categorie->getId(),
                'nom' => $categorie->getNom(),
                'description' => $categorie->getDescription()
            ];
        }, array: $categories),
        201]) ;
    }

    #[Route('/categorie/{id}', methods: ['GET'])]
    public function  show(EntityManagerInterface $entityManager, int $id): JsonResponse 
    {
        $team = $entityManager->getRepository(categorie::class)->find($id);

        if(!$categorie) {
            throw $this->createNotFoundException(
                'No teams found'
            );
        }

        return $this->json(['id' => $categorie->getId(),
                            'nom' => $categorie->getNom(),
                            'description' => $categorie->getDescription() ],
                            201);
    }

    #[Route('/categorie/{id}', methods: ['PUT'])]
    public function update( Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $data = json_decode(json: $request->getContent(), associative: true);

        $categorie = $entityManager->getRepository(categorie::class)->find($id);

        if(!$categorie) {
            throw $this->createNotFoundException(
                'No team found for id'.$id
            );
        }

        $categorie->setNom(Nom: $data['nom'] ?? '');
        $categorie->setDescription(Description: $data['description'] ?? '');

        $entityManager->flush();

        return $this->json(['id' => $categorie->getId(),
                            'nom' => $categorie->getNom(),
                            'description' => $categorie->getDescription()],
                            201);
    }

    #[Rotue('/categorie/{id}', methods: ['DELETE'])]
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
