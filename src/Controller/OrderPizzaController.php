<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Pizza;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class OrderPizzaController extends AbstractController
{
  /**
   * @Route("/orders", name="list_orders")
   * @IsGranted("ROLE_ADMIN")
   */
  public function index(Request $request): Response
  {
    $repository =  $this->getDoctrine()
      ->getRepository(Order::class);
    if ($request->query->get('archive')) {
      $order = $repository->find($request->query->get('archive'));
      if ($order) {
        $order->setIsArchived(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();
      }
    }

    $orders = $repository->findBy(['isArchived' => false]);
    return $this->render('order_pizza/index.html.twig', [
      'orders' => $orders,
    ]);
  }

  /**
   * @Route("/order", name="order_pizza")
   */
  public function order(Request $request): Response
  {
    $repository =  $this->getDoctrine()
      ->getRepository(Pizza::class);

    $pizzas = $repository->findAll();

    $user = $this->getUser();

    $postParams = $request->request->all();

    $address = $request->request->get('address');
    $zipcode = $request->request->get('zipcode');
    $city = $request->request->get('city');

    $errors = [
      "address" => "",
      "zipcode" => "",
      "city" => "",
      "pizza" => "",
    ];

    if (empty($address) && count($postParams)) {
      $errors["address"] = "L'adresse est nécessaire";
    }

    if (empty($zipcode) && count($postParams)) {
      $errors["zipcode"] = "Le code postal est nécessaire";
    }

    if (empty($city) && count($postParams)) {
      $errors["city"] = "La ville est requise";
    }

    unset($postParams["address"]);
    unset($postParams["zipcode"]);
    unset($postParams["city"]);


    $numberOfPizza = array_reduce(array_values($postParams), function($acc, $val) {
      $acc = empty($val) ? $acc : $acc + (int)$val;

      return $acc;
    }, 0);

    if ($numberOfPizza < 1) {
      $errors["pizza"] = "Choisissez une pizza";
    }

    if (empty($address) || empty($zipcode) || empty($city) || !count($postParams)) {
      return $this->render('order_pizza/order.html.twig', [
        'pizzas' => $pizzas,
        'user' => $user,
        'errors' => $errors,
      ]);
    }

    $order = new Order();
    $order->setAddress($address);
    $order->setCity($city);
    $order->setZipCode($zipcode);
    $order->setUser($user);
    $order->setIsArchived(false);

    foreach ($postParams as $key => $value) {
      $tmp = array_filter($pizzas, function($pizza) use ($key) {
        return $pizza->getName() == $key;
      });
      $pizzaToAdd = !empty($tmp) ? array_values($tmp)[0] : null;
      for ($i=0; $i < $value; $i++) { 
        if($pizzaToAdd) {
          $order->addPizza($pizzaToAdd);
        }
      }
    }

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($order);
    $entityManager->flush();
    
    return $this->redirectToRoute('order_done');
  }

  /**
   * @Route("/order/success", name="order_done")
   */

  public function orderDone(): Response
  {
    return $this->render('order_pizza/success.html.twig');
  }
}