<?php

namespace src\Payment;

class PayManager
{
    public function pay(Payer $payer){
       return $payer->pay();
    }
}
