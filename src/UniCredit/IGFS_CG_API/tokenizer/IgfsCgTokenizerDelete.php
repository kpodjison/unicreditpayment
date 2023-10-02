<?php
namespace src\UniCredit\IGFS_CG_API\tokenizer;
use src\UniCredit\IGFS_CG_API\IgfsMissingParException;
use src\UniCredit\IGFS_CG_API\IgfsUtils;
use src\UniCredit\IGFS_CG_API\tokenizer\BaseIgfsCgTokenizer;

class IgfsCgTokenizerDelete extends BaseIgfsCgTokenizer {

	public $payInstrToken;
	public $billingID;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->payInstrToken = NULL;
		$this->billingID = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->payInstrToken == NULL)
			throw new IgfsMissingParException("Missing payInstrToken");
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		$request = $this->replaceRequest($request, "{payInstrToken}", $this->payInstrToken);
		if ($this->billingID != NULL)
			$request = $this->replaceRequest($request, "{billingID}", "<billingID><![CDATA[" . $this->billingID . "]]></billingID>");
		else
			$request = $this->replaceRequest($request, "{billingID}", "");

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
				$this->payInstrToken); // PAYINSTRTOKEN
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields);
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"));// ERRORDESC
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORDESC
		return $this->getSignature($this->kSig, // KSIGN
				$fields);
	}

	protected function getFileName() {
		return "IGFS_CG_API/tokenizer/IgfsCgTokenizerDelete.request";
	}

}

?>
