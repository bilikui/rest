<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;

class ApiRestController extends FOSRestController
{
    /**
     * @Route("/fizzbuzz/{min}/{max}")
     */
    public function indexAction($min, $max)
    {
        $data = array();

        if (is_numeric($min) && is_numeric($max) && $max >= $min) {
            for ($i = $min; $i <= $max; $i++) {
                if ($i % 3 == 0 && $i % 5 == 0) {
                    $data[] = 'FizzBuzz';
                } elseif ($i % 3 == 0) {
                    $data[] = 'Fizz';
                } elseif ($i % 5 == 0) {
                    $data[] = 'Buzz';
                } else {
                    $data[] = (int) $i;
                }
            }
        }

        $view = $this->view($data);
        return $this->handleView($view);
    }
}
