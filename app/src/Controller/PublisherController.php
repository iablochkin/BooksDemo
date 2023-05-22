<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Publisher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PublisherController extends AbstractController
{
    #[Route('/publisher/edit/{!id}', name: 'edit_publisher', methods: ['PUT', 'POST'])]
    public function update(Request $request, Publisher $publisher, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = $request->request->all();

        $publisher->setName($data['name']);
        $publisher->setAddress($data['address']);

        if (count($errors) > 0) {
            return $this->json($errors, 422);
        }

        $entityManager->flush();

        return $this->json('Publisher was updated');
    }

    #[Route('/publisher/{!id}', name: 'delete_publisher', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Publisher $publisher): JsonResponse
    {
        $entityManager->remove($publisher);
        $entityManager->flush();

        return $this->json('Publisher was deleted');
    }
}
