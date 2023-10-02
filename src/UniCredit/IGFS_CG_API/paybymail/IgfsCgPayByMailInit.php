<?php
namespace src\UniCredit\IGFS_CG_API\paybymail;
//use App\IGFS_CG_API\paybymail\BaseIgfsCgPayByMail;
use src\UniCredit\IGFS_CG_API\IgfsMissingParException;
use src\UniCredit\IGFS_CG_API\IgfsUtils;
use src\UniCredit\IGFS_CG_API\Level3Info;
use src\UniCredit\IGFS_CG_API\paybymail\BaseIgfsCgPayByMail;
use const App\UniCredit\IGFS_CG_API\paybymail\i;

class IgfsCgPayByMailInit extends BaseIgfsCgPayByMail {

	public $shopUserRef;
	public $shopUserName;
	public $shopUserAccount;
	public $shopUserMobilePhone;
	public $shopUserIMEI;
	public $trType = "AUTH";
	public $linkType = "MAIL";
	public $amount;
	public $currencyCode;
	public $langID = "EN";
	public $callbackURL;
	public $addInfo1;
	public $addInfo2;
	public $addInfo3;
	public $addInfo4;
	public $addInfo5;
	public $accountName;
	public $level3Info;
	public $description;
	public $paymentReason;

	public $mailID;
	public $linkURL;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->shopUserRef = NULL;
		$this->shopUserName = NULL;
		$this->shopUserAccount = NULL;
		$this->shopUserMobilePhone = NULL;
		$this->shopUserIMEI = NULL;
		$this->trType = "AUTH";
		$this->linkType = "MAIL";
		$this->amount = NULL;
		$this->currencyCode = NULL;
		$this->langID = "EN";
		$this->callbackURL = NULL;
		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;
		$this->accountName = NULL;
		$this->level3Info = NULL;
		$this->description = NULL;
		$this->paymentReason = NULL;

		$this->mailID = NULL;
		$this->linkURL = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->trType == NULL)
			throw new IgfsMissingParException("Missing trType");
		if ($this->langID == NULL)
			throw new IgfsMissingParException("Missing langID");
		if ($this->shopUserRef == NULL)
			throw new IgfsMissingParException("Missing shopUserRef");

		if ($this->level3Info != NULL) {
			$i = 0;
			if ($this->level3Info->product != NULL) {
				foreach ($this->level3Info->product as $product) {
					if ($product->productCode == NULL)
						throw new IgfsMissingParException("Missing productCode[" . i . "]");
					if ($product->productDescription == NULL)
						throw new IgfsMissingParException("Missing productDescription[" . i . "]");
				}
				$i++;
			}
		}
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		if ($this->shopUserRef != NULL)
			$request = $this->replaceRequest($request, "{shopUserRef}", "<shopUserRef><![CDATA[" . $this->shopUserRef . "]]></shopUserRef>");
		else
			$request = $this->replaceRequest($request, "{shopUserRef}", "");
		if ($this->shopUserName != NULL)
			$request = $this->replaceRequest($request, "{shopUserName}", "<shopUserName><![CDATA[" . $this->shopUserName . "]]></shopUserName>");
		else
			$request = $this->replaceRequest($request, "{shopUserName}", "");
		if ($this->shopUserAccount != NULL)
			$request = $this->replaceRequest($request, "{shopUserAccount}", "<shopUserAccount><![CDATA[" . $this->shopUserAccount . "]]></shopUserAccount>");
		else
			$request = $this->replaceRequest($request, "{shopUserAccount}", "");
		if ($this->shopUserMobilePhone != NULL)
			$request = $this->replaceRequest($request, "{shopUserMobilePhone}", "<shopUserMobilePhone><![CDATA[" . $this->shopUserMobilePhone . "]]></shopUserMobilePhone>");
		else
			$request = $this->replaceRequest($request, "{shopUserMobilePhone}", "");
		if ($this->shopUserIMEI != NULL)
			$request = $this->replaceRequest($request, "{shopUserIMEI}", "<shopUserIMEI><![CDATA[" . $this->shopUserIMEI . "]]></shopUserIMEI>");
		else
			$request = $this->replaceRequest($request, "{shopUserIMEI}", "");

		$request = $this->replaceRequest($request, "{trType}", $this->trType);

		if ($this->linkType != NULL)
			$request = $this->replaceRequest($request, "{linkType}", "<linkType><![CDATA[" . $this->linkType . "]]></linkType>");
		else
			$request = $this->replaceRequest($request, "{linkType}", "");

		if ($this->amount != NULL)
			$request = $this->replaceRequest($request, "{amount}", "<amount><![CDATA[" . $this->amount . "]]></amount>");
		else
			$request = $this->replaceRequest($request, "{amount}", "");
		if ($this->currencyCode != NULL)
			$request = $this->replaceRequest($request, "{currencyCode}", "<currencyCode><![CDATA[" . $this->currencyCode . "]]></currencyCode>");
		else
			$request = $this->replaceRequest($request, "{currencyCode}", "");

		$request = $this->replaceRequest($request, "{langID}", $this->langID);
		if ($this->callbackURL != NULL)
			$request = $this->replaceRequest($request, "{callbackURL}", "<callbackURL><![CDATA[" . $this->callbackURL . "]]></callbackURL>");
		else
			$request = $this->replaceRequest($request, "{callbackURL}", "");

		if ($this->addInfo1 != NULL)
			$request = $this->replaceRequest($request, "{addInfo1}", "<addInfo1><![CDATA[" . $this->addInfo1 . "]]></addInfo1>");
		else
			$request = $this->replaceRequest($request, "{addInfo1}", "");
		if ($this->addInfo2 != NULL)
			$request = $this->replaceRequest($request, "{addInfo2}", "<addInfo2><![CDATA[" . $this->addInfo2 . "]]></addInfo2>");
		else
			$request = $this->replaceRequest($request, "{addInfo2}", "");
		if ($this->addInfo3 != NULL)
			$request = $this->replaceRequest($request, "{addInfo3}", "<addInfo3><![CDATA[" . $this->addInfo3 . "]]></addInfo3>");
		else
			$request = $this->replaceRequest($request, "{addInfo3}", "");
		if ($this->addInfo4 != NULL)
			$request = $this->replaceRequest($request, "{addInfo4}", "<addInfo4><![CDATA[" . $this->addInfo4 . "]]></addInfo4>");
		else
			$request = $this->replaceRequest($request, "{addInfo4}", "");
		if ($this->addInfo5 != NULL)
			$request = $this->replaceRequest($request, "{addInfo5}", "<addInfo5><![CDATA[" . $this->addInfo5 . "]]></addInfo5>");
		else
			$request = $this->replaceRequest($request, "{addInfo5}", "");

		if ($this->accountName != NULL)
			$request = $this->replaceRequest($request, "{accountName}", "<accountName><![CDATA[" . $this->accountName . "]]></accountName>");
		else
			$request = $this->replaceRequest($request, "{accountName}", "");

		if ($this->level3Info != NULL)
			$request = $this->replaceRequest($request, "{level3Info}", $this->level3Info->toXml("level3Info"));
		else
			$request = $this->replaceRequest($request, "{level3Info}", "");
		if ($this->description != NULL)
			$request = $this->replaceRequest($request, "{description}", "<description><![CDATA[" . $this->description . "]]></description>");
		else
			$request = $this->replaceRequest($request, "{description}", "");
		if ($this->paymentReason != NULL)
			$request = $this->replaceRequest($request, "{paymentReason}", "<paymentReason><![CDATA[" . $this->paymentReason . "]]></paymentReason>");
		else
			$request = $this->replaceRequest($request, "{paymentReason}", "");

		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|SHOPUSERREF|SHOPUSERNAME|SHOPUSERACCOUNT|SHOPUSERMOBILEPHONE|SHOPUSERIMEI|TRTYPE|AMOUNT|CURRENCYCODE|LANGID|NOTIFYURL|ERRORURL|CALLBACKURL
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->merID, // MERID
				$this->payInstr, // PAYINSTR
				$this->shopID, // SHOPID
				$this->shopUserRef, // SHOPUSERREF
				$this->shopUserName, // SHOPUSERNAME
				$this->shopUserAccount, // SHOPUSERACCOUNT
				$this->shopUserMobilePhone, //SHOPUSERMOBILEPHONE
				$this->shopUserIMEI, //SHOPUSERIMEI
				$this->trType,// TRTYPE
				$this->amount, // AMOUNT
				$this->currencyCode, // CURRENCYCODE
				$this->langID, // LANGID
				$this->callbackURL, // CALLBACKURL
				$this->addInfo1, // UDF1
				$this->addInfo2, // UDF2
				$this->addInfo3, // UDF3
				$this->addInfo4, // UDF4
				$this->addInfo5);
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields);
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->mailID = IgfsUtils::getValue($response, "mailID");
		// Opzionale
		$this->linkURL = IgfsUtils::getValue($response, "linkURL");
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "mailID"),// MAILID
				IgfsUtils::getValue($response, "linkURL"));
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORDESC|MAILID
		return $this->getSignature($this->kSig, // KSIGN
				$fields);
	}

	protected function getFileName() {
		return "IGFS_CG_API/paybymail/IgfsCgPayByMailInit.request";
	}

}

?>
