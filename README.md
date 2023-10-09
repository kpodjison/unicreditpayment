# UnicreditPayment
Library for implementing UniCredit online payment

## Installation
```

composer require kpodjison/unicreditpayment

```
Add the following credentials to .env file of project root directory
```env
SERVER_URL = "https://testeps.netswgroup.it/UNI_CG_SERVICES/services"
TIMEOUT = 15000
TID = "UNI_ECOM"
KSIG = "UNI_TESTKEY"
TR_TYPE = "PURCHASE"
CURRENCY_CODE = "EUR"
LANG_ID = "EN"
NOTIFY_URL = "http://127.0.0.1:8000/your-notify-url"
ESITO_URL = "http://127.0.0.1:8000/your-project/notify"
ERROR_URL = "http://127.0.0.1:8000/your-project/error"

```
📍**NB**: The credentials above are for testing. Remember to change them during production.

**💡**: [API DOCUMENTATION](https://pagamenti.unicredit.it/UNI_CG_BRANDING/UNI/doc/api_manual_EN.pdf)

## Implementation
  ### Make Payment
```php
    $payManager = new PayManager;
    $uni = new UniCredit([
        'shop_id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'amount' =>100,
        'shopUserRef' => 'abc@gmail.com',
        "info1" => 'paymentinfo1',  //optional parameter
        "info2" => 'paymentinfo2',  //optional parameter
        "info3" => 'paymentinfo3',  //optional parameter
        "info4" => 'paymentinfo4',  //optional parameter
    ]);
    return response()->json($payManager->pay($uni)); //returns redirectUrl,paymentID,shopID to be used for payment verification

```

 ### Verify Payment
 ```php
  $verify = new Verify([
            'shop_id' => 'fa37729dd-737c-4122-b53e-771c8f91a2aa',
            'payment_id' =>"002580908057104525647",
        ]);
        return response()->json($verify->verifyPay()); //return success url
 ```
**💡**: shop_id and payment_id are returned when a payment is successful. Pass shopID and paymentID (returned by pay function) as arguments to create an object of class Verify as showed above

 
