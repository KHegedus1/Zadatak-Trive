<?php

class Controller
{
    //Kontroler koji provjerava je li korisnik upisao cijeli broj.

    public function provjeraInteger(
        $message,
        $error = 'Unos mora biti cijeli broj.Unos mora biti veci od 0.')
    {
        $app = fopen('php://stdin', 'r');
        while (true) {
            echo $message . PHP_EOL;
            $Input = (int) fgets($app);

            if ($Input > 0){
                return $Input;
            }
            echo $error . PHP_EOL;
        }
    }

    //Kontroler koji provjerava je li korisnik upisao string koji nije prazan

    public  function provjeraString(
        $message, 
        $error = 'Molimo Vas upisite naziv proizvoda.Naziv proizvoda ne smije ostati prazan.')
    {
        $app = fopen('php://stdin', 'r');
        while (true) {
             echo $message . PHP_EOL;
            $Input = fgets($app);
            $Input = str_replace(' ', '', $Input);
            
            if (strlen($Input) > 0){
                return $Input;
            }
            echo $error . PHP_EOL;
        }
    }

    //Kontroler koji provjerava je li korisnik upisao decimalni broj

    public  function provjeraDecimal(
        $message,
        $error='Unos mora biti u decimalnom obliku.')
    {
        $app = fopen('php://stdin','r');
        while (true) {
            echo $message;
            $Input = (float) fgets($app);
            if($Input!=0){
                return $Input;
            }
            echo $error . PHP_EOL;
        }
    }
}