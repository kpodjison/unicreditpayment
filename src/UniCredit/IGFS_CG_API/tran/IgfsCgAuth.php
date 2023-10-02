<?php
namespace src\UniCredit\IGFS_CG_API\tran;
use App\UniCredit\IGFS_CG_API\tran\BaseIgfsCg;
use App\UniCredit\IGFS_CG_API\tran\Entry;
use App\UniCredit\IGFS_CG_API\tran\Exception;
use App\UniCredit\IGFS_CG_API\tran\IgfsMissingParException;
use App\UniCredit\IGFS_CG_API\tran\IgfsUtils;
use App\UniCredit\IGFS_CG_API\tran\SimpleXMLElement;
use src\UniCredit\IGFS_CG_API\tran\BaseIgfsCgTran;
use const App\UniCredit\IGFS_CG_API\tran\i;

require_once("IGFS_CG_API/tran/BaseIgfsCgTran.php");
require_once("IGFS_CG_API/Level3Info.php");
require_once("IGFS_CG_API/Entry.php");

class IgfsCgAuth extends BaseIgfsCgTran {

	public $shopUserRef;
	public $shopUserName;
	public $shopUserAccount;
	public $shopUserMobilePhone;
	public $shopUserIMEI;
	public $shopUserIP;
	public $trType = "AUTH";
	public $amount;
	public $currencyCode;
	public $langID;
	public $callbackURL;
	public $pan;
	public $payInstrToken;
	public $billingID;
	public $payload;
	public $regenPayInstrToken;
	public $keepOnRegenPayInstrToken;
	public $payInstrTokenExpire;
	public $payInstrTokenUsageLimit;
	public $payInstrTokenAlg;
	public $cvv2;
	public $expireMonth;
	public $expireYear;
	public $accountName;
	public $enrStatus;
	public $authStatus;
	public $cavv;
	public $xid;
	public $eci;
	public $threeDSProtocolVersion;
	public $dsTransID;
	public $level3Info;
	public $description;
	public $paymentReason;
	public $topUpID;
	public $firstTopUp;
	public $payInstrTokenAsTopUpID;
	public $scaExemptionType;
	public $txIndicatorType;
	public $traceChainId;
	public $promoCode;
	public $payPassData;
	public $userAgent;
	public $fingerPrint;
	public $validityExpire;

	public $paymentID;
	public $authCode;
	public $brand;
	public $acquirerID;
	public $maskedPan;
	public $additionalFee;
	public $status;
	public $nssResult;
	public $payloadContent;
	public $payloadContentType;
	public $payTraceData;
	public $payAddData;
	public $payUserRef;

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
		$this->shopUserIP = NULL;
		$this->trType = "AUTH";
		$this->amount = NULL;
		$this->currencyCode = NULL;
		$this->langID = NULL;
		$this->callbackURL = NULL;
		$this->pan = NULL;
		$this->payInstrToken = NULL;
		$this->billingID = NULL;
		$this->payload = NULL;
		$this->regenPayInstrToken = NULL;
		$this->keepOnRegenPayInstrToken = NULL;
		$this->payInstrTokenExpire = NULL;
		$this->payInstrTokenUsageLimit = NULL;
		$this->payInstrTokenAlg = NULL;
		$this->cvv2 = NULL;
		$this->expireMonth = NULL;
		$this->expireYear = NULL;
		$this->accountName = NULL;
		$this->enrStatus = NULL;
		$this->authStatus = NULL;
		$this->cavv = NULL;
		$this->xid = NULL;
		$this->eci = NULL;
		$this->threeDSProtocolVersion = NULL;
		$this->dsTransID = NULL;
		$this->level3Info = NULL;
		$this->description = NULL;
		$this->paymentReason = NULL;
		$this->topUpID = NULL;
		$this->firstTopUp = NULL;
		$this->payInstrTokenAsTopUpID = NULL;
		$this->scaExemptionType = NULL;
		$this->txIndicatorType = NULL;
		$this->traceChainId = NULL;
		$this->promoCode = NULL;
		$this->payPassData = NULL;
		$this->userAgent = NULL;
		$this->fingerPrint = NULL;
		$this->validityExpire = NULL;

		$this->paymentID = NULL;
		$this->authCode = NULL;
		$this->brand = NULL;
		$this->acquirerID = NULL;
		$this->maskedPan = NULL;
		$this->additionalFee = NULL;
		$this->status = NULL;
		$this->nssResult = NULL;
		$this->payloadContent = NULL;
		$this->payloadContentType = NULL;
		$this->payTraceData = NULL;
		$this->payAddData = NULL;
		$this->payUserRef = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->trType == NULL)
			throw new IgfsMissingParException("Missing trType");
		if ($this->trType == "VERIFY") {}
		else {
			if ($this->amount == NULL)
				throw new IgfsMissingParException("Missing amount");
			if ($this->currencyCode == NULL)
				throw new IgfsMissingParException("Missing currencyCode");
		}
		// Disabilitato per pagopoi
		// if ($this->pan == NULL) {
		//	if ($this->payInstrToken == NULL)
		//		throw new IgfsMissingParException("Missing pan");
		// }
		if ($this->pan != NULL) {
			// Se è stato impostato il pan verifico...
			if ($this->pan == "")
				throw new IgfsMissingParException("Missing pan");
		}
		if ($this->payInstrToken != NULL) {
			// Se è stato impostato il payInstrToken verifico...
			if ($this->payInstrToken == "")
				throw new IgfsMissingParException("Missing payInstrToken");
		}
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
		if ($this->shopUserIP != NULL)
			$request = $this->replaceRequest($request, "{shopUserIP}", "<shopUserIP><![CDATA[" . $this->shopUserIP . "]]></shopUserIP>");
		else
			$request = $this->replaceRequest($request, "{shopUserIP}", "");

		$request = $this->replaceRequest($request, "{trType}", $this->trType);
		if ($this->amount != NULL)
			$request = $this->replaceRequest($request, "{amount}", "<amount><![CDATA[" . $this->amount . "]]></amount>");
		else
			$request = $this->replaceRequest($request, "{amount}", "");
		if ($this->currencyCode != NULL)
			$request = $this->replaceRequest($request, "{currencyCode}", "<currencyCode><![CDATA[" . $this->currencyCode . "]]></currencyCode>");
		else
			$request = $this->replaceRequest($request, "{currencyCode}", "");
		if ($this->langID != NULL)
			$request = $this->replaceRequest($request, "{langID}", "<langID><![CDATA[" . $this->langID . "]]></langID>");
		else
			$request = $this->replaceRequest($request, "{langID}", "");

		if ($this->callbackURL != NULL)
			$request = $this->replaceRequest($request, "{callbackURL}", "<callbackURL><![CDATA[" . $this->callbackURL . "]]></callbackURL>");
		else
			$request = $this->replaceRequest($request, "{callbackURL}", "");

		if ($this->pan != NULL)
			$request = $this->replaceRequest($request, "{pan}", "<pan><![CDATA[" . $this->pan . "]]></pan>");
		else
			$request = $this->replaceRequest($request, "{pan}", "");

		if ($this->payInstrToken != NULL)
			$request = $this->replaceRequest($request, "{payInstrToken}", "<payInstrToken><![CDATA[" . $this->payInstrToken . "]]></payInstrToken>");
		else
			$request = $this->replaceRequest($request, "{payInstrToken}", "");
		if ($this->billingID != NULL)
			$request = $this->replaceRequest($request, "{billingID}", "<billingID><![CDATA[" . $this->billingID . "]]></billingID>");
		else
			$request = $this->replaceRequest($request, "{billingID}", "");

		if ($this->payload != NULL)
			$request = $this->replaceRequest($request, "{payload}", "<payload><![CDATA[" . $this->payload . "]]></payload>");
		else
			$request = $this->replaceRequest($request, "{payload}", "");

		if ($this->regenPayInstrToken != NULL)
			$request = $this->replaceRequest($request, "{regenPayInstrToken}", "<regenPayInstrToken><![CDATA[" . $this->regenPayInstrToken . "]]></regenPayInstrToken>");
		else
			$request = $this->replaceRequest($request, "{regenPayInstrToken}", "");
		if ($this->keepOnRegenPayInstrToken != NULL)
			$request = $this->replaceRequest($request, "{keepOnRegenPayInstrToken}", "<keepOnRegenPayInstrToken><![CDATA[" . $this->keepOnRegenPayInstrToken . "]]></keepOnRegenPayInstrToken>");
		else
			$request = $this->replaceRequest($request, "{keepOnRegenPayInstrToken}", "");
		if ($this->payInstrTokenExpire != NULL)
			$request = $this->replaceRequest($request, "{payInstrTokenExpire}", "<payInstrTokenExpire><![CDATA[" . IgfsUtils::formatXMLGregorianCalendar($this->payInstrTokenExpire) . "]]></payInstrTokenExpire>");
		else
			$request = $this->replaceRequest($request, "{payInstrTokenExpire}", "");
		if ($this->payInstrTokenUsageLimit != NULL)
			$request = $this->replaceRequest($request, "{payInstrTokenUsageLimit}", "<payInstrTokenUsageLimit><![CDATA[" . $this->payInstrTokenUsageLimit . "]]></payInstrTokenUsageLimit>");
		else
			$request = $this->replaceRequest($request, "{payInstrTokenUsageLimit}", "");
		if ($this->payInstrTokenAlg != NULL)
			$request = $this->replaceRequest($request, "{payInstrTokenAlg}", "<payInstrTokenAlg><![CDATA[" . $this->payInstrTokenAlg . "]]></payInstrTokenAlg>");
		else
			$request = $this->replaceRequest($request, "{payInstrTokenAlg}", "");

		if ($this->cvv2 != NULL)
			$request = $this->replaceRequest($request, "{cvv2}", "<cvv2><![CDATA[" . $this->cvv2 . "]]></cvv2>");
		else
			$request = $this->replaceRequest($request, "{cvv2}", "");

		if ($this->expireMonth != NULL)
			$request = $this->replaceRequest($request, "{expireMonth}", "<expireMonth><![CDATA[" . $this->expireMonth . "]]></expireMonth>");
		else
			$request = $this->replaceRequest($request, "{expireMonth}", "");
		if ($this->expireYear != NULL)
			$request = $this->replaceRequest($request, "{expireYear}", "<expireYear><![CDATA[" . $this->expireYear . "]]></expireYear>");
		else
			$request = $this->replaceRequest($request, "{expireYear}", "");

		if ($this->accountName != NULL)
			$request = $this->replaceRequest($request, "{accountName}", "<accountName><![CDATA[" . $this->accountName . "]]></accountName>");
		else
			$request = $this->replaceRequest($request, "{accountName}", "");

		if ($this->enrStatus != NULL)
			$request = $this->replaceRequest($request, "{enrStatus}", "<enrStatus><![CDATA[" . $this->enrStatus . "]]></enrStatus>");
		else
			$request = $this->replaceRequest($request, "{enrStatus}", "");
		if ($this->authStatus != NULL)
			$request = $this->replaceRequest($request, "{authStatus}", "<authStatus><![CDATA[" . $this->authStatus . "]]></authStatus>");
		else
			$request = $this->replaceRequest($request, "{authStatus}", "");
		if ($this->cavv != NULL)
			$request = $this->replaceRequest($request, "{cavv}", "<cavv><![CDATA[" . $this->cavv . "]]></cavv>");
		else
			$request = $this->replaceRequest($request, "{cavv}", "");
		if ($this->xid != NULL)
			$request = $this->replaceRequest($request, "{xid}", "<xid><![CDATA[" . $this->xid . "]]></xid>");
		else
			$request = $this->replaceRequest($request, "{xid}", "");
		if ($this->eci != NULL)
			$request = $this->replaceRequest($request, "{eci}", "<eci><![CDATA[" . $this->eci . "]]></eci>");
		else
			$request = $this->replaceRequest($request, "{eci}", "");
		if ($this->threeDSProtocolVersion != NULL)
			$request = $this->replaceRequest($request, "{threeDSProtocolVersion}", "<threeDSProtocolVersion><![CDATA[" . $this->threeDSProtocolVersion . "]]></threeDSProtocolVersion>");
		else
			$request = $this->replaceRequest($request, "{threeDSProtocolVersion}", "");
		if ($this->dsTransID != NULL)
			$request = $this->replaceRequest($request, "{dsTransID}", "<dsTransID><![CDATA[" . $this->dsTransID . "]]></dsTransID>");
		else
			$request = $this->replaceRequest($request, "{dsTransID}", "");

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

		if ($this->topUpID != NULL)
			$request = $this->replaceRequest($request, "{topUpID}", "<topUpID><![CDATA[" . $this->topUpID . "]]></topUpID>");
		else
			$request = $this->replaceRequest($request, "{topUpID}", "");
		if ($this->firstTopUp != NULL)
			$request = $this->replaceRequest($request, "{firstTopUp}", "<firstTopUp><![CDATA[" . $this->firstTopUp . "]]></firstTopUp>");
		else
			$request = $this->replaceRequest($request, "{firstTopUp}", "");
		if ($this->payInstrTokenAsTopUpID != NULL)
			$request = $this->replaceRequest($request, "{payInstrTokenAsTopUpID}", "<payInstrTokenAsTopUpID><![CDATA[" . $this->payInstrTokenAsTopUpID . "]]></payInstrTokenAsTopUpID>");
		else
			$request = $this->replaceRequest($request, "{payInstrTokenAsTopUpID}", "");

		if ($this->scaExemptionType != NULL)
			$request = $this->replaceRequest($request, "{scaExemptionType}", "<scaExemptionType><![CDATA[" . $this->scaExemptionType . "]]></scaExemptionType>");
		else
			$request = $this->replaceRequest($request, "{scaExemptionType}", "");

		if ($this->txIndicatorType != NULL)
			$request = $this->replaceRequest($request, "{txIndicatorType}", "<txIndicatorType><![CDATA[" . $this->txIndicatorType . "]]></txIndicatorType>");
		else
			$request = $this->replaceRequest($request, "{txIndicatorType}", "");
		if ($this->traceChainId != NULL)
			$request = $this->replaceRequest($request, "{traceChainId}", "<traceChainId><![CDATA[" . $this->traceChainId . "]]></traceChainId>");
		else
			$request = $this->replaceRequest($request, "{traceChainId}", "");

		if ($this->promoCode != NULL)
			$request = $this->replaceRequest($request, "{promoCode}", "<promoCode><![CDATA[" . $this->promoCode . "]]></promoCode>");
		else
			$request = $this->replaceRequest($request, "{promoCode}", "");

		if ($this->payPassData != NULL)
			$request = $this->replaceRequest($request, "{payPassData}", "<payPassData><![CDATA[" . $this->payPassData . "]]></payPassData>");
		else
			$request = $this->replaceRequest($request, "{payPassData}", "");

		if ($this->userAgent != NULL)
			$request = $this->replaceRequest($request, "{userAgent}", "<userAgent><![CDATA[" . $this->userAgent . "]]></userAgent>");
		else
			$request = $this->replaceRequest($request, "{userAgent}", "");

		if ($this->fingerPrint != NULL)
			$request = $this->replaceRequest($request, "{fingerPrint}", "<fingerPrint><![CDATA[" . $this->fingerPrint . "]]></fingerPrint>");
		else
			$request = $this->replaceRequest($request, "{fingerPrint}", "");

		if ($this->validityExpire != NULL)
			$request = $this->replaceRequest($request, "{validityExpire}", "<validityExpire><![CDATA[" . IgfsUtils::formatXMLGregorianCalendar($this->validityExpire) . "]]></validityExpire>");
		else
			$request = $this->replaceRequest($request, "{validityExpire}", "");

		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|SHOPUSERREF|SHOPUSERNAME|SHOPUSERACCOUNT|SHOPUSERMOBILEPHONE|SHOPUSERIMEI|SHOPUSERIP|TRTYPE|AMOUNT|CURRENCYCODE|CALLBACKURL|PAN|PAYINSTRTOKEN|PAYLOAD|CVV2|EXPIREMONTH|EXPIREYEAR|UDF1|UDF2|UDF3|UDF4|UDF5
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
				$this->shopUserIP, // SHOPUSERIP
				$this->trType,// TRTYPE
				$this->amount, // AMOUNT
				$this->currencyCode, // CURRENCYCODE
				$this->callbackURL, // CALLBACKURL
				$this->pan, // PAN
				$this->payInstrToken, // PAYINSTRTOKEN
				$this->payload, // PAYLOAD
				$this->cvv2, // CVV2
				$this->expireMonth, // EXPIREMONTH
				$this->expireYear, // EXPIREYEAR
				$this->addInfo1, // UDF1
				$this->addInfo2, // UDF2
				$this->addInfo3, // UDF3
				$this->addInfo4, // UDF4
				$this->addInfo5, // UDF5
				$this->topUpID);
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields);
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->paymentID = IgfsUtils::getValue($response, "paymentID");
		// Opzionale
		$this->authCode = IgfsUtils::getValue($response, "authCode");
		// Opzionale
		$this->brand = IgfsUtils::getValue($response, "brand");
		// Opzionale
		$this->acquirerID = IgfsUtils::getValue($response, "acquirerID");
		// Opzionale
		$this->maskedPan = IgfsUtils::getValue($response, "maskedPan");
		// Opzionale
		$this->payInstrToken = IgfsUtils::getValue($response, "payInstrToken");
		// Opzionale
		$this->additionalFee = IgfsUtils::getValue($response, "additionalFee");
		// Opzionale
		$this->status = IgfsUtils::getValue($response, "status");
		// Opzionale
		$this->nssResult = IgfsUtils::getValue($response, "nssResult");
		// Opzionale
		$this->topUpID = IgfsUtils::getValue($response, "topUpID");
		// Opzionale
		$this->payUserRef = IgfsUtils::getValue($response, "payUserRef");
		// Opzionale
		$this->shopUserMobilePhone = IgfsUtils::getValue($response, "shopUserMobilePhone");
		// Opzionale
		try {
			$this->payloadContent = base64_decode(IgfsUtils::getValue($response, "payloadContent"));
		} catch(Exception $e) {
			$this->payloadContent = NULL;
		}
		// Opzionale
		$this->payloadContentType = IgfsUtils::getValue($response, "payloadContentType");

		try {
			$xml = $response[BaseIgfsCg::$RESPONSE];

			$xml = str_replace("<soap:", "<", $xml);
			$xml = str_replace("</soap:", "</", $xml);
			$dom = new SimpleXMLElement($xml, LIBXML_NOERROR, false);
			if (count($dom)==0) {
				return;
			}

			$tmp = str_replace("<Body>", "", $dom->Body->asXML());
			$tmp = str_replace("</Body>", "", $tmp);
			$dom = new SimpleXMLElement($tmp, LIBXML_NOERROR, false);
			if (count($dom)==0) {
				return;
			}

			$xml_response = IgfsUtils::parseResponseFields($dom->response);
			if (isset($xml_response["payTraceData"])) {
				$payTraceData = array();
				foreach ($dom->response->children() as $item) {
					if ($item->getName() == "payTraceData") {
					    $payTraceData[] = Entry::fromXml($item->asXML(), "payTraceData");
					}
				}
				$this->payTraceData = $payTraceData;
			}
			if (isset($xml_response["payAddData"])) {
				$payAddData = array();
				foreach ($dom->response->children() as $item) {
					if ($item->getName() == "payAddData") {
					    $payAddData[] = Entry::fromXml($item->asXML(), "payAddData");
					}
				}
				$this->payAddData = $payAddData;
			}
		} catch(Exception $e) {
			$this->payTraceData = NULL;
			$this->payAddData = NULL;
		}
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "tranID"), // ORDERID
				IgfsUtils::getValue($response, "date"), // TRANDATE
				IgfsUtils::getValue($response, "paymentID"), // PAYMENTID
				IgfsUtils::getValue($response, "authCode"));// AUTHCODE
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORCODE|ORDERID|PAYMENTID|AUTHCODE
		return $this->getSignature($this->kSig, // KSIGN
				$fields);
	}

	protected function getFileName() {
		return "IGFS_CG_API/tran/IgfsCgAuth.request";
	}

}

?>
