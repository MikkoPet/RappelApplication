<?php

namespace App\Controller;

use App\Entity\Rappel;
use App\Form\RappelType;
use App\Repository\RappelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/rappel')]
class RappelController extends AbstractController
{
    #[Route('/', name: 'app_rappel')]
    public function index(RappelRepository $rappelRepository): Response
    {
        return $this->render('rappel/index.html.twig', [
            'rappels' =>  $rappelRepository->findAll(),
        ]);
    }

    #[route('/new', name: 'app_rappel_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $rappel = new Rappel();
        $form = $this->createForm(RappelType::class, $rappel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($rappel);
            $em->flush();

            return $this->redirectToRoute('app_rappel', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rappel/new.html.twig', [
            'rappel' => $rappel,
            'rappelForm' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rappel_show', requirements: ['id' => Requirement::DIGITS])]
    public function show(Rappel $rappel): Response
    {
        return $this->render('rappel/show.html.twig', [
            'rappel' => $rappel
        ]);
    }

    #[route('/edit/{id}', name: 'app_rappel_edit', requirements: ['id' => Requirement::DIGITS])]
    public function edit(Rappel $rappel, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RappelType::class, $rappel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_rappel', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rappel/edit.html.twig', [
            'rappel' => $rappel,
            'rappelForm' => $form
        ]);
    }

    #[route('/delete/{id}', name: 'app_rappel_delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete(Rappel $rappel, EntityManagerInterface $em): Response
    {
            $em->remove($rappel);
            $em->flush();

        return $this->redirectToRoute('app_rappel', [], Response::HTTP_SEE_OTHER);
    }
}
