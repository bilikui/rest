<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\Debug\Exception\OutOfMemoryException;

class ApiRestController extends FOSRestController
{
    /**
     * @Route("/fizzbuzz/{min}/{max}")
     */
    public function indexAction($min, $max)
    {
        $data = array();

        // If the minimum and maximum are integers and maximum is greater than or equal to the minimum
        if ($this->isInteger($min) && $this->isInteger($max) && $max >= $min) {
            // I prevent with the parameter "maximum difference value between min and max", the out of memory error
            if ($max - $min <= $this->getParameter('maximum_difference_value_between_min_max')) {
                for ($i = $min; $i <= $max; $i++) {
                    if ($i == 0) {
                        $data[] = (int) $i;
                    } elseif ($i % 3 == 0 && $i % 5 == 0) {
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
        }

        $view = $this->view($data);
        return $this->handleView($view);
    }

    private function isInteger($value)
    {
        return is_numeric($value) && is_int(abs($value)) ? true : false;
    }
}
