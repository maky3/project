<?php

namespace App\Travel\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TravelCalculatorService;

class TravelController extends AbstractController
{
    /**
     * @Route("/calculate", methods={"POST"})
     */
    public function calculate(Request $request, TravelCalculatorService $calculator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $basePrice = $data['base_price'];
        $childAge = $data['child_age'];
        $travelStartDate = new \DateTime($data['travel_start_date']);
        $paymentDate = new \DateTime($data['payment_date']);

        $totalPrice = $calculator->calculateTotalPrice($basePrice, $childAge, $travelStartDate, $paymentDate);

        return new JsonResponse(['total_price' => $totalPrice]);
    }
}