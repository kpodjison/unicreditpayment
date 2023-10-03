<?php

namespace Kpodjison\Unicreditpayment\Payment\UniCreditPay;
use Kpodjison\Unicreditpayment\Payment\Payer;
use Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\init\IgfsCgInit;


class UniCredit implements Payer
{
    public $init;   /* UniCredit Payment object */

    public function __construct($paymentDetails)
    {
        $this->init = new IgfsCgInit();
        $this->init->serverURL = env('SERVER_URL');
        $this->init->timeout = env('TIIMEOUT');
        $this->init->tid = env('TID');
        $this->init->kSig = env('KSIG');
        $this->init->trType = env('TR_TYPE');
        $this->init->currencyCode = env('CURRENCY_CODE');
        $this->init->langID = env('LANG_ID');
        $this->init->notifyURL = env('NOTIFY_URL');
        $this->init->errorURL = env('ERROR_URL');

        //Dynamic data
        $this->init->shopID = $paymentDetails['shop_id'];
        $this->init->shopUserRef = $paymentDetails['email'];
        $this->init->amount = $paymentDetails['amount'];
        $this->init->AddInfo1 = $paymentDetails['info1'];
        $this->init->AddInfo2 = $paymentDetails['info2'];
        $this->init->AddInfo3 = $paymentDetails['info3'];
        $this->init->AddInfo4 = $paymentDetails['info4'];
    }

    //Method to Execute payment -- returns redirectUrl,paymentID,shopID to be used for payment verification
    public function pay()
    {
       $this->init->execute(); // execute payment
       return [
                'redirectUrl' => $this->init->redirectURL,
                'paymentID' =>  $this->init->paymentID,
                'shopID' => $this->init->shopID
             ];
    }

}
