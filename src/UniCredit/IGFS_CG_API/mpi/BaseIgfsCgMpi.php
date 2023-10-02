<?php
namespace src\UniCredit\IGFS_CG_API\mpi;
use src\UniCredit\IGFS_CG_API\BaseIgfsCg;
use src\UniCredit\IGFS_CG_API\IgfsMissingParException;
use src\UniCredit\IGFS_CG_API\IgfsUtils;

abstract class BaseIgfsCgMpi extends BaseIgfsCg {

	public $shopID; // chiave messaggio

	public $xid;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->shopID = NULL;

		$this->xid = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->shopID == NULL || "" == $this->shopID)
			throw new IgfsMissingParException("Missing shopID");
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		$request = $this->replaceRequest($request, "{shopID}", $this->shopID);
		return $request;
	}

	protected function getServicePort() {
		return "MPIGatewayPort";
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->xid = IgfsUtils::getValue($response, "xid");
	}

}

?>
