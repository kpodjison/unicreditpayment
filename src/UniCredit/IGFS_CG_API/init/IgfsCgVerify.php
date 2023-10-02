<?php
namespace src\UniCredit\IGFS_CG_API\init;
//use App\IGFS_CG_API\init\BaseIgfsCgInit;
use src\UniCredit\IGFS_CG_API\BaseIgfsCg;
use src\UniCredit\IGFS_CG_API\IgfsMissingParException;
use src\UniCredit\IGFS_CG_API\IgfsUtils;
use src\UniCredit\IGFS_CG_API\init\BaseIgfsCgInit;
use src\UniCredit\IGFS_CG_API\Level3Info;
use src\UniCredit\IGFS_CG_API\Entry;
use Exception;
use SimpleXMLElement;

class IgfsCgVerify extends BaseIgfsCgInit {

	public $paymentID;
	public $refTranID;

	public $tranID;
	public $authCode;
	public $enrStatus;
	public $authStatus;
	public $brand;
	public $acquirerID;
	public $maskedPan;
	public $addInfo1;
	public $addInfo2;
	public $addInfo3;
	public $addInfo4;
	public $addInfo5;
	public $payInstrToken;
	public $expireMonth;
	public $expireYear;
	public $level3Info;
	public $additionalFee;
	public $status;
	public $accountName;
	public $nssResult;
	public $topUpID;
	public $payloadContent;
	public $payloadContentType;
	public $payTraceData;
	public $payAddData;
	public $payUserRef;
	public $shopUserMobilePhone;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->paymentID = NULL;
		$this->refTranID = NULL;

		$this->tranID = NULL;
		$this->authCode = NULL;
		$this->enrStatus = NULL;
		$this->authStatus = NULL;
		$this->brand = NULL;
		$this->acquirerID = NULL;
		$this->maskedPan = NULL;
		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;
		$this->payInstrToken = NULL;
		$this->expireMonth = NULL;
		$this->expireYear = NULL;
		$this->level3Info = NULL;
		$this->additionalFee = NULL;
		$this->status = NULL;
		$this->accountName = NULL;
		$this->nssResult = NULL;
		$this->topUpID = NULL;
		$this->payloadContent = NULL;
		$this->payloadContentType = NULL;
		$this->payTraceData = NULL;
		$this->payAddData = NULL;
		$this->payUserRef = NULL;
		$this->shopUserMobilePhone = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->paymentID == NULL || "" == $this->paymentID)
			throw new IgfsMissingParException("Missing paymentID");
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		$request = $this->replaceRequest($request, "{paymentID}", $this->paymentID);

		if ($this->refTranID != NULL)
			$request = $this->replaceRequest($request, "{refTranID}", "<refTranID><![CDATA[" . $this->refTranID . "]]></refTranID>");
		else
			$request = $this->replaceRequest($request, "{refTranID}", "");

		return $request;
	}

	protected function setRequestSignature($request) {
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->merID, // MERID
				$this->payInstr, // PAYINSTR
				$this->shopID, // SHOPID
				$this->paymentID, // PAYMENTID
				$this->refTranID);
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|PAYMENTID
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields);
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->tranID = IgfsUtils::getValue($response, "tranID");
		// Opzionale
		$this->authCode = IgfsUtils::getValue($response, "authCode");
		// Opzionale
		$this->enrStatus = IgfsUtils::getValue($response, "enrStatus");
		// Opzionale
		$this->authStatus = IgfsUtils::getValue($response, "authStatus");
		// Opzionale
		$this->brand = IgfsUtils::getValue($response, "brand");
		// Opzionale
		$this->acquirerID = IgfsUtils::getValue($response, "acquirerID");
		// Opzionale
		$this->maskedPan = IgfsUtils::getValue($response, "maskedPan");
		// Opzionale
		$this->addInfo1 = IgfsUtils::getValue($response, "addInfo1");
		// Opzionale
		$this->addInfo2 = IgfsUtils::getValue($response, "addInfo2");
		// Opzionale
		$this->addInfo3 = IgfsUtils::getValue($response, "addInfo3");
		// Opzionale
		$this->addInfo4 = IgfsUtils::getValue($response, "addInfo4");
		// Opzionale
		$this->addInfo5 = IgfsUtils::getValue($response, "addInfo5");
		// Opzionale
		$this->payInstrToken = IgfsUtils::getValue($response, "payInstrToken");
		// Opzionale
		$this->expireMonth = IgfsUtils::getValue($response, "expireMonth");
		// Opzionale
		$this->expireYear = IgfsUtils::getValue($response, "expireYear");
		// Opzionale
		$this->level3Info = Level3Info::fromXml(IgfsUtils::getValue($response, "level3Info"), "level3Info");
		// Opzionale
		$this->additionalFee = IgfsUtils::getValue($response, "additionalFee");
		// Opzionale
		$this->status = IgfsUtils::getValue($response, "status");
		// Opzionale
		$this->accountName = IgfsUtils::getValue($response, "accountName");
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
		} catch(\Exception $e) {
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
				IgfsUtils::getValue($response, "paymentID"),// PAYMENTID
				IgfsUtils::getValue($response, "tranID"),// ORDERID
				IgfsUtils::getValue($response, "authCode"),// AUTHCODE
				IgfsUtils::getValue($response, "enrStatus"),// ENRSTATUS
				IgfsUtils::getValue($response, "authStatus"));// AUTHSTATUS
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORDESC|PAYMENTID|REDIRECTURL
		return $this->getSignature($this->kSig, // KSIGN
				$fields);
	}

	protected function getFileName() {
		return __DIR__."/IgfsCgVerify.request";
	}

}

?>
