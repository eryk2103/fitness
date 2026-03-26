<?php

namespace App\Controller;

use App\Entity\DailyLog;
use App\Entity\ProductEntry;
use App\Entity\User;
use App\Form\ProductEntryType;
use App\Repository\DailyLogRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('daily-logs')]
class DailyLogController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(Request $request, #[CurrentUser] $user, DailyLogRepository $dailyLogRepo, EntityManagerInterface $em): Response
    {
        $date = $this->parseDateParam($request->query->get('date'));
        $dailyLog = $dailyLogRepo->findOneBy(['owner' => $user, 'date' => $date]);

        if($dailyLog == null) {
            $newDailyLog = new DailyLog();
            $newDailyLog->setOwner($user)
                ->setDate($date)
                ->setCaloriesGoal(0);

            $em->persist($newDailyLog);
            $em->flush();
            $dailyLog = $newDailyLog;
        }

        $caloriesSum = 0.0;
        foreach($dailyLog->getProductEntries() as $entry) {
            $calories = $entry->getProduct()->getCalories();
            $quantity = $entry->getQuantity();
            
            $caloriesSum += $calories * $quantity / 100;
        }

        return $this->render('daily-log/index.html.twig', ['dailyLog' => $dailyLog, 'calories' => $caloriesSum]);
    }

    #[Route('/new-entry', methods: ['GET', 'POST'])]
    public function newEntry(#[CurrentUser] User $user, Request $request, EntityManagerInterface $em, DailyLogRepository $dailyLogRepo): Response
    {
        $date = $this->parseDateParam($request->query->get('date'));

        $entry = new ProductEntry();
        $form = $this->createForm(ProductEntryType::class, $entry);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dailyLog = $dailyLogRepo->findOneBy(['owner' => $user, 'date' => $date]);
            if($dailyLog == null) {
                throw new NotFoundHttpException('Invalid date');
            }
            $entry->setDailyLog($dailyLog);
            $em->persist($entry);
            $em->flush();

            return $this->redirectToRoute('app_dailylog_index', ['date' => $date->format('Y-m-d')]);
        }

        return $this->render('daily-log/new-entry.html.twig', ['form' => $form]);
    }

    private function parseDateParam(?string $dateStr): DateTimeImmutable {
        $date = new DateTimeImmutable();
        if($dateStr) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d', $dateStr);
            if($date === false) {
                $date = new DateTimeImmutable();
            }
        }
        return $date;
    }
}