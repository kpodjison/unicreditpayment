<?php

namespace Kpodjison\Unicreditpayment\Payment;

class PayManager
{
    public function pay(Payer $payer){
       return $payer->pay();
    }
}
