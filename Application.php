<?php

//Glavni dio aplikacije

class Application
{
    private $cart;
    private $inventory;

    //Pozdravna poruka
    private function pozdrav()
    {
        echo 'Dobrodosli!'    . PHP_EOL;
        echo '°°°°°°°°°°°°°°' . PHP_EOL; 
        $this->inventoryMenu();
    }

    //Stvaranje niza za kosaricu i inventar


    public function __construct()
    {
        $this->inventory = [];
        $this->cart = [];
        $this->pozdrav();
    }

    //Glavni izbornik - 1. faza aplikacije

    private function inventoryMenu()
    {
        echo '1. ADD - Dodajte novi proizvod u inventar'                      . PHP_EOL; //addProduct metoda

        echo '2. END - Zatvorite ovaj izbornik-otvorite izbornik za kosaricu' . PHP_EOL; //prelazak u sljedecu fazu rada
        $choice = 0;
        while(true){
            $choice = Controller::provjeraInteger('Izaberite redni broj: ','Vas unos mora biti cijeli broj. ');
            if($choice < 1 || $choice > 2){
                echo 'Molimo Vas izaberite jednu od ponudjenih opcija.' . PHP_EOL;
                continue;
            }
            break;
        }
        switch($choice){
            case 1:
                $this->addProduct();
                break;
            case 2:
                $this->cartMenu();
                break;
        }
        
       
    }

    private function addProduct()
    {
        //Dodavanje novog proizvoda,set metode,controlleri
        $product = new Product();

        $product->setSku(Controller::provjeraInteger('Unesite SKU broj: '));

        $product->setName(Controller::provjeraString('Unesite naziv proizvoda: '));

        $product->setQuantity(Controller::provjeraInteger('Unesite iznos: '));

        $product->setPrice(Controller::provjeraDecimal('Unesite cijenu: '));
        
        $this->inventory[] = $product;

        echo PHP_EOL . 'Proizvod je dodan u Vas inventar.' . PHP_EOL;

        $this->inventoryMenu();
    }

    //Upravljanje kosaricom,checkout- 2. faza aplikacije

    private function cartMenu()
    {

        echo '1. ADD - Dodajte novi proizvod u kosaricu' . PHP_EOL;

        echo '2. REMOVE  - Uklonite proizvod iz kosarice' . PHP_EOL;

        echo '3. CHECKOUT - Prikaz kosarice' . PHP_EOL;

        echo '4. END - Kraj rada' . PHP_EOL;


        $choice = 0;
        while(true){
            $choice = Controller::provjeraInteger('Izaberite redni broj: ','Vas unos mora biti cijeli broj.');
            if($choice < 1 || $choice > 4){
                echo 'Molimo Vas izaberite jednu od ponudjenih opcija.' . PHP_EOL;
                continue;
            }
            break;
        }
        switch($choice){
            case 1:
                $this->addToCart();
                break;
            case 2:
                $this->removeFromCart();
                break;
            case 3:
                $this->checkout();
                break;
            case 4:
                echo PHP_EOL . 'Kraj rada' . PHP_EOL;
        }
    }

    //Dodavanje proizvoda iz inventara u kosaricu 

    private function addToCart()
    {
        $cartItem = new Item();

        for($i=0;$i<count($this->inventory);$i++){
            echo $this->inventory[$i]->getSku() . '. ' . $this->inventory[$i]->getName() 
            . ' ' . $this->inventory[$i]->getQuantity() 
            . ' komada ' . $this->inventory[$i]->getPrice() 
            . '$' . PHP_EOL;
        }

        while (true) {
            $input = (Controller::provjeraInteger('Unesite SKU broj : '));
            foreach ($this->inventory as $product) {
                if ($input == $product->getSku()) {
                    $cartItem->setSku($input);
                }
            }
            if (null !== ($cartItem->getSku())) {
                break;
            }
            echo 'Taj SKU broj ne postoji.' . PHP_EOL;
            continue;
        }

        while (true) {
            $input = (Controller::provjeraInteger('kolicina: ', 'kolicina mora biti veca od 0'));
            foreach ($this->inventory as $product) {
                if ($cartItem->getSku() == $product->getSku()) {
                    if ($input <= $product->getQuantity()) {
                        $cartItem->setQuantity($input);
                        $cartItem->setName($product->getName());
                        $cartItem->setPrice($product->getPrice());
                        $this->cart[] = $cartItem;
                        $product->setQuantity($product->getQuantity()-$input);
                        echo PHP_EOL . 'Proizvod je dodan u kosaricu.' . PHP_EOL;
                    } else {
                        echo 'Imate ' . $product->getQuantity() . ' ' . $product->getName() . ' u inventaru.' . PHP_EOL;
                    }
                }
            }
            if (null !== ($cartItem->getQuantity())) {
                break;
            }
            continue;
        }

        $this->cartMenu();
    }
    
    //Uklanjanje iz kosarice

    private function removeFromCart()
    {
        for($i=0;$i<count($this->cart);$i++){
            echo $this->cart[$i]->getSku() . '. ' . $this->cart[$i]->getName() 
            . ' ' . $this->cart[$i]->getQuantity() 
            . ' komada x ' . $this->cart[$i]->getQuantity()
            . '$' . PHP_EOL;
        }
        $delete = Controller::provjeraInteger('Unesite SKU broj proizvoda kojeg zelite ukloniti iz kosarice: ');
        
        array_splice($this->cart,$delete-1,1);

        echo 'Proizvod je uklonjen iz kosarice.' . PHP_EOL;
        $this->cartMenu();
    }
    //Checkout-prikaz stanja u kosarici
    private function checkout()
    {
        $total = 0;

        echo 'Checkout' . PHP_EOL;  
        foreach($this->cart as $check){
            $price = $check->getPrice() * $check->getQuantity();
            $total += $price;
            echo $check->getName() . ' ' . $check->getQuantity() . ' x ' . $check->getPrice() . ' = ' . $price . PHP_EOL;
            echo 'Ukupno = ' . $total . PHP_EOL;
            $this->cart = [];
            $this->cartMenu();
        }
    }
}