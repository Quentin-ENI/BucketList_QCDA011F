<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WishController extends AbstractController
{
    private $wishesDB = [
        'chaer' => 'Voyager à Quimperlé',
        'alexis' => 'Aller sur la lune',
        'gurvan' => 'Revenir de la lune',
        'pierre' => 'Apprendre le russe',
        'chrysantheme' => 'Voir une aurore boréale',
        'julien' => 'Faire un safari',
        'cyril' => 'Gagner à l\'euromillions',
        'youri' => 'Retourner au cercle polaire'
    ];

    #[Route('/wishes', name: 'wish_list', methods: ['GET'])]
    public function list(): Response
    {
        // Simulation
        $wishes = $this->wishesDB;

        $keys = array_flip(array_keys($wishes));

        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes,
            'keys' => $keys
        ]);
    }

    #[Route('/wishes/{id}', name: 'wish_detail', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function detail(int $id): Response {
        // Simulation
        $wishes = $this->wishesDB;

        $keys = array_keys($wishes);
        $firstName = $keys[$id];

        $wish = $this->wishesDB[$firstName];

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish,
        ]);
    }
}
