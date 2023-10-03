<?php

namespace Kpodjison\Unicreditpayment\Payment\UniCreditPay;
use src\UniCredit\IGFS_CG_API\init\IgfsCgVerify;

class Verify
{
    public $verify; /* UniCredit Verify object */

    public function __construct($paymentDetails)
    {
        $this->verify = new IgfsCgVerify();
        $this->verify->serverURL = env('SERVER_URL');;
        $this->verify->timeout = env('TIIMEOUT');
        $this->verify->tid = env('TID');
        $this->verify->kSig = env('KSIG');
        $this->verify->esitoURL =  env('ESITO_URL');
        $this->verify->errorURL =  env('ERROR_URL');

        //Dynamic data
        $this->verify->shopID = $paymentDetails['shop_id'];
        $this->verify->paymentID = $paymentDetails['payment_id'];
    }


    //Method to Verify payment
    public function verifyPay(){

        $this->verify->execute(); // execute verification

        //Error URL
        if (!$this->verify->execute()) {
           return $this->verify->errorURL."?rc=" . $this->verify->rc . "&errorDesc=" . $this->verify->errorDesc;
        }
        // Success URL
        return $this->verify->esitoURL."?esito=OK&rc=" . $this->verify->rc . "&tranID=" .$this->verify->tranID .
            "&enrStatus=" . $this->verify->enrStatus . "&authStatus=".$this->verify->authStatus;
    }

}
