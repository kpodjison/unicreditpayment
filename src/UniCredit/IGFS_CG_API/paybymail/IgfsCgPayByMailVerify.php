<?php
namespace src\UniCredit\IGFS_CG_API\paybymail;
//use App\IGFS_CG_API\paybymail\BaseIgfsCgPayByMail;

use src\UniCredit\IGFS_CG_API\IgfsMissingParException;
use src\UniCredit\IGFS_CG_API\IgfsUtils;
use src\UniCredit\IGFS_CG_API\paybymail\BaseIgfsCgPayByMail;

class IgfsCgPayByMailVerify extends BaseIgfsCgPayByMail {

	public $mailID;

	public $tranID;
	public $status;
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
		$this->mailID = NULL;

		$this->tranID = NULL;
		$this->status = NULL;
		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->mailID == NULL || "" == $this->mailID)
			throw new IgfsMissingParException("Missing mailID");
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		$request = $this->replaceRequest($request, "{mailID}", $this->mailID);

		return $request;
	}

	protected function setRequestSignature($request) {
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->merID, // MERID
				$this->payInstr, // PAYINSTR
				$this->shopID, // SHOPID
				$this->mailID); // MAILID
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|MAILID
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
		$this->status = IgfsUtils::getValue($response, "status");
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
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "mailID"),// MAILID
				IgfsUtils::getValue($response, "tranID"),// ORDERID
				IgfsUtils::getValue($response, "status"));// STATUS
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORDESC|MAILID|STATUS
		return $this->getSignature($this->kSig, // KSIGN
				$fields);
	}

	protected function getFileName() {
		return "IGFS_CG_API/paybymail/IgfsCgPayByMailVerify.request";
	}

}

?>
