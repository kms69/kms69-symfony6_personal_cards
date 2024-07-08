<?php
/// src/Controller/PersonalCardController.php

namespace App\Controller;

use App\Entity\PersonalCard;
use App\Form\PersonalCardType;
use App\Repository\PersonalCardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Route('/personal_card')]
class PersonalCardController extends AbstractController
{

    #[Route('/', name: 'personal_card_index', methods: ['GET'])]
    public function index(PersonalCardRepository $personalCardRepository): Response
    {
        $personalCards = $personalCardRepository->findAll();

        return $this->render('personal_card/index.html.twig', [
            'personal_cards' => $personalCards,
        ]);
    }

    #[Route('/new', name: 'personal_card_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $personalCard = new PersonalCard();
        $form = $this->createForm(PersonalCardType::class, $personalCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($personalCard);
            $entityManager->flush();

            return $this->redirectToRoute('personal_card_index');
        }

        return $this->render('personal_card/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/personal-card/{id}', name: 'personal_card_show', methods: ['GET'])]
    public function show(int $id, PersonalCardRepository $personalCardRepository): Response
    {
        $personalCard = $personalCardRepository->find($id);

        if (!$personalCard) {
            throw $this->createNotFoundException('Personal card not found');
        }

        return $this->render('personal_card/show.html.twig', [
            'personal_card' => $personalCard,
        ]);
    }

    #[Route('/{id}/edit', name: 'personal_card_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, PersonalCardRepository $personalCardRepository, EntityManagerInterface $entityManager): Response
    {
        $personalCard = $personalCardRepository->find($id); // Fetch the entity using repository

        if (!$personalCard) {
            throw $this->createNotFoundException('Personal card not found');
        }

        $form = $this->createForm(PersonalCardType::class, $personalCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Return a JSON response indicating success
            return new JsonResponse(['success' => true]);
        }

        // If form submission fails or on initial GET request, render the edit form template
        return $this->render('personal_card/edit.html.twig', [
            'form' => $form->createView(),
            'personal_card' => $personalCard,
        ]);
    }

    #[Route('/{id}', name: 'personal_card_delete', methods: ['POST', 'DELETE'])]
    public function delete(Request $request, int $id, PersonalCardRepository $personalCardRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        if ($request->getMethod() === 'POST' && $request->request->get('_method') === 'DELETE') {
            $csrfToken = $request->request->get('_token');

            if ($this->isCsrfTokenValid('delete' . $id, $csrfToken)) {
                $personalCard = $personalCardRepository->find($id);

                if (!$personalCard) {
                    throw $this->createNotFoundException('Personal card not found');
                }

                $entityManager->remove($personalCard);
                $entityManager->flush();

                return new JsonResponse(['success' => true]);
            }

            return new JsonResponse(['success' => false], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(['success' => false], Response::HTTP_METHOD_NOT_ALLOWED);
    }

    #[Route('/export', name: 'personal_card_export_csv', methods: ['GET'])]
    public function exportCsv(PersonalCardRepository $personalCardRepository): Response
    {
        $response = new StreamedResponse(function () use ($personalCardRepository) {
            $handle = fopen('php://output', 'w+');

            // Add the header of the CSV file
            fputcsv($handle, ['Name', 'Family', 'Telephone', 'Address']);

            // Query data from database
            $cards = $personalCardRepository->findAll();

            // Add the data queried from database
            foreach ($cards as $card) {
                fputcsv($handle, [$card->getName(), $card->getFam(), $card->getTel(), $card->getAddr()]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="personal_cards.csv"');

        return $response;
    }
}
