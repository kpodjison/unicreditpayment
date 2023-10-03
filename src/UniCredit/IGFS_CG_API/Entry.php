<?php
namespace Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API;
use SimpleXMLElement;
use Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\IgfsUtils;

class Entry {

	public $key;
	public $value;

    function __construct() {
	}

	public static function fromXml($xml, $tname) {

		if ($xml=="" || $xml==NULL) {
			return;
		}

		$dom = new SimpleXMLElement($xml, LIBXML_NOERROR, false);
		if (count($dom)==0) {
			return;
		}

		$response = IgfsUtils::parseResponseFields($dom);
		$entry = NULL;
		if (isset($response) && count($response)>0) {
			$entry = new Entry();
			$entry->key = (IgfsUtils::getValue($response, "key"));
			$entry->value = (IgfsUtils::getValue($response, "value"));
		}
		return $entry;
	}

	public function toXml($tname) {
		$sb = "";
		$sb .= "<" . $tname . ">";
		if ($this->key != NULL) {
			$sb .= "<key><![CDATA[";
			$sb .= $this->key;
			$sb .= "]]></key>";
		}
		if ($this->value != NULL) {
			$sb .= "<value><![CDATA[";
			$sb .= $this->value;
			$sb .= "]]></value>";
		}
		$sb .= "</" . $tname . ">";
		return $sb;
	}

}
?>
