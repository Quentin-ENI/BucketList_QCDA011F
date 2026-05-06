<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('wishes', name: 'wish_')]
final class WishController extends AbstractController
{

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(WishRepository $wishRepository): Response
    {
//        $wishes = $wishRepository->findBy([], ['dateCreated' => 'ASC']);

        $wishes = $wishRepository->findWishesOrderedByDate();

        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes
        ]);
    }

    #[Route('/{id}', name: 'detail', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function detail(
        int $id,
        WishRepository $wishRepository,
    ): Response {
        $wish = $wishRepository->find($id);

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish,
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function create(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish, [
            'action' => $this->generateUrl('wish_create'),
            'method' => 'POST'
        ]);
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            try {
                $wish->setDateCreated(new \DateTime());

                $wish->setAuthor($this->getUser());

                $entityManager->persist($wish);
                $entityManager->flush();

                $this->addFlash('success', 'Le souhait a bien été créé.');

                return $this->redirectToRoute('wish_detail',
                    ['id' => $wish->getId()]
                );
            } catch (Exception $exception) {
                $this->addFlash('danger', "Le souhait n'a pas été créé.");
            }
        }

        return $this->render('wish/create.html.twig', [
            'wishForm' => $wishForm,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function delete(
        int $id,
        WishRepository $wishRepository,
        EntityManagerInterface $entityManager,
    ): Response {
        try {
            $wish = $wishRepository->find($id);

            $isAuthorized =
                ($wish->getAuthor()->getUserIdentifier() === $this->getUser()->getUserIdentifier())
                || $this->isGranted('ROLE_ADMIN');

            if (!$isAuthorized) {
                $this->addFlash('danger', "Vous n'êtes pas autorisé à supprimer le souhait.");
                return $this->redirectToRoute('wish_list');
            }

            if (!($wish === null)) {
                $entityManager->remove($wish);
                $entityManager->flush();
                $this->addFlash('success', 'Le souhait a bien été supprimé.');
            } else {
                $this->addFlash('danger', "Le souhait n'existe pas.");
            }
        } catch (Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }

        return $this->redirectToRoute('wish_list');
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id'=>'\d+'], methods: ['GET', 'POST'])]
    public function update(
        int $id,
        WishRepository $wishRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {

        try {
            $wish = $wishRepository->find($id);

            if ($wish->getAuthor()->getUserIdentifier() != $this->getUser()->getUserIdentifier()) {
                $this->addFlash('danger', "Vous n'êtes pas autorisé à modifier le souhait.");
                return $this->redirectToRoute('wish_list');
            }

            if ($wish === null) {
                $this->addFlash('danger', "Le souhait n'existe pas.");
                return $this->redirectToRoute('wish_list');
            }
        } catch (Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
            return $this->redirectToRoute('wish_list');
        }

        $wishForm = $this->createForm(WishType::class, $wish, [
            'action' => $this->generateUrl('wish_update', ['id' => $wish->getId()]),
            'method' => 'POST'
        ]);
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            try {
                $wish->setDateUpdated(new \DateTime());

                $entityManager->persist($wish);
                $entityManager->flush();

                $this->addFlash('success', "Le souhait a bien été modifié.");

                return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
            } catch (Exception $exception) {
                $this->addFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('wish/update.html.twig', [
            'wishForm' => $wishForm,
        ]);
    }
}
