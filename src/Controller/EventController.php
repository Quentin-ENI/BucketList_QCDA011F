<?php

namespace App\Controller;

use App\Model\EventDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class EventController extends AbstractController
{
    #[Route('/events', name: 'app_event')]
    public function index(
        SerializerInterface $serializer,
    ): Response
    {
        $url = "https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda";

        $content = file_get_contents($url);
        $content = $serializer->deserialize($content, EventDTO::class, 'json');

        $events = $content->getRecords();

        dump($events);

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }
}
