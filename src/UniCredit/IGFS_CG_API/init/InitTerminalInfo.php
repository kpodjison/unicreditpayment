<?php
namespace Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\init;
class InitTerminalInfo {

	public $tid;
	public $payInstrToken;
	public $billingID;

    function __construct() {
	}

	public function toXml($tname) {
		$sb = "";
		$sb .= "<" . $tname . ">";
		if ($this->tid != NULL) {
			$sb .= "<tid><![CDATA[";
			$sb .= $this->tid;
			$sb .= "]]></tid>";
		}
		if ($this->payInstrToken != NULL) {
			$sb .= "<payInstrToken><![CDATA[";
			$sb .= $this->payInstrToken;
			$sb .= "]]></payInstrToken>";
		}
		if ($this->billingID != NULL) {
			$sb .= "<billingID><![CDATA[";
			$sb .= $this->billingID;
			$sb .= "]]></billingID>";
		}
		$sb .= "</" . $tname . ">";
		return $sb;
	}

}
?>
