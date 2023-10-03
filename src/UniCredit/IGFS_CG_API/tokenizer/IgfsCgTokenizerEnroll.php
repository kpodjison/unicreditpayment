<?php
namespace Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\tokenizer;
use Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\IgfsMissingParException;
use Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\IgfsUtils;
use Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\tokenizer\BaseIgfsCgTokenizer;

class IgfsCgTokenizerEnroll extends BaseIgfsCgTokenizer {

	public $shopUserRef;
	public $pan;
	public $expireMonth;
	public $expireYear;
	public $accountName;
	public $payInstrToken;
	public $billingID;
	public $regenPayInstrToken;
	public $keepOnRegenPayInstrToken;
	public $payInstrTokenExpire;
	public $payInstrTokenUsageLimit;
	public $payInstrTokenAlg;
	public $addInfo1;
	public $addInfo2;
	public $addInfo3;
	public $addInfo4;
	public $addInfo5;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->shopUserRef = NULL;
		$this->pan = NULL;
		$this->expireMonth = NULL;
		$this->expireYear = NULL;
		$this->accountName = NULL;
		$this->payInstrToken = NULL;
		$this->billingID = NULL;
		$this->regenPayInstrToken = NULL;
		$this->keepOnRegenPayInstrToken = NULL;
		$this->payInstrTokenExpire = NULL;
		$this->payInstrTokenUsageLimit = NULL;
		$this->payInstrTokenAlg = NULL;
		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->pan == NULL || $this->pan == "")
			throw new IgfsMissingParException("Missing pan");
		if ($this->expireMonth == NULL)
			throw new IgfsMissingParException("Missing expireMonth");
		if ($this->expireYear == NULL)
			throw new IgfsMissingParException("Missing expireYear");
		if ($this->payInstrToken != NULL) {
			// Se è stato impostato il payInstrToken verifico...
			if ($this->payInstrToken == "")
				throw new IgfsMissingParException("Missing payInstrToken");
		}
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		if ($this->shopUserRef != NULL)
			$request = $this->replaceRequest($request, "{shopUserRef}", "<shopUserRef><![CDATA[" . $this->shopUserRef . "]]></shopUserRef>");
		else
			$request = $this->replaceRequest($request, "{shopUserRef}", "");

		$request = $this->replaceRequest($request, "{pan}", $this->pan);
		$request = $this->replaceRequest($request, "{expireMonth}", $this->expireMonth);
		$request = $this->replaceRequest($request, "{expireYear}", $this->expireYear);

		if ($this->accountName != NULL)
			$request = $this->replaceRequest($request, "{accountName}", "<accountName><![CDATA[" . $this->accountName . "]]></accountName>");
		else
			$request = $this->replaceRequest($request, "{accountName}", "");
		if ($this->payInstrToken != NULL)
			$request = $this->replaceRequest($request, "{payInstrToken}", "<payInstrToken><![CDATA[" . $this->payInstrToken . "]]></payInstrToken>");
		else
			$request = $this->replaceRequest($request, "{payInstrToken}", "");
		if ($this->billingID != NULL)
			$request = $this->replaceRequest($request, "{billingID}", "<billingID><![CDATA[" . $this->billingID . "]]></billingID>");
		else
			$request = $this->replaceRequest($request, "{billingID}", "");

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
		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|PAYINSTRTOKEN
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->merID, // MERID
				$this->payInstr, // PAYINSTR
				$this->shopID, // SHOPID
				$this->shopUserRef, // SHOPUSERREF
				$this->pan, // PAN
				$this->expireMonth, // EXPIREMONTH
				$this->expireYear, // EXPIREYEAR
				$this->payInstrToken, // PAYINSTRTOKEN
				$this->addInfo1, // UDF1
				$this->addInfo2, // UDF2
				$this->addInfo3, // UDF3
				$this->addInfo4, // UDF4
				$this->addInfo5); // UDF5
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields);
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->payInstrToken = IgfsUtils::getValue($response, "payInstrToken");
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"), // ERRORDESC
				IgfsUtils::getValue($response, "payInstrToken")); // PAYINSTRTOKEN
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORDESC
		return $this->getSignature($this->kSig, // KSIGN
				$fields);
	}

	protected function getFileName() {
		return "IGFS_CG_API/tokenizer/IgfsCgTokenizerEnroll.request";
	}

}

?>
