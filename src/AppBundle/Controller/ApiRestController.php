<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Symfony\Bridge\Monolog\Logger;

class ApiRestController extends FOSRestController
{
    private $logger;

    /**
     * @Route("/fizzbuzz/{min}/{max}")
     */
    public function indexAction($min, $max)
    {
        $data = array();

        $this->initLogger();

        // If the minimum and maximum are integers
        if ($this->isInteger($min) && $this->isInteger($max)) {
            // Maximum is greater than or equal to the minimum
            if ($max >= $min) {
                // I prevent with the parameter "maximum difference value between min and max", the out of memory error
                if ($max - $min <= $this->getParameter('maximum_difference_value_between_min_max')) {
                    $indexLog = 0;
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

                        $this->logger->info("Number: $i - value: {$data[$indexLog]}");
                        $indexLog++;
                    }
                } else {
                    $message = 'The difference between the minimum and the maximum [' . ($max - $min) . '] exceeds ' . $this->getParameter('maximum_difference_value_between_min_max');
                    $this->logger->info($message);
                }
            } else {
                $this->logger->info('The minimum cannot be greater than the maximum');
            }
        } else {
            $this->logger->info('The minimum or maximum is not an integer');
        }

        $view = $this->view($data);
        return $this->handleView($view);
    }

    private function initLogger()
    {
        $this->logger = new Logger('apirest');

        $monologFormat = "[%datetime%] %message%\n";

        $dateFormat = "d/m/Y H:i:s";
        $monologLineFormat = new LineFormatter($monologFormat, $dateFormat);

        $streamHandler = new StreamHandler($this->getParameter('restapi_log_path'), Logger::INFO);
        $streamHandler->setFormatter($monologLineFormat);

        $this->logger->pushHandler($streamHandler);
    }

    private function isInteger($value)
    {
        return is_numeric($value) && is_int(abs($value)) ? true : false;
    }
}
