<?php
namespace Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API;
use Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\Exception;
use DateTime;
use function Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\parseXMLGregorianCalendarDT;
use function Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\parseXMLGregorianCalendarTZ;
use const Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\format;

class IgfsUtils {

	public static function getSignature($ksig, $fields) {
		$data = "";
		foreach ($fields as $value) {
			$data .= $value;
		}

		return base64_encode(hash_hmac('sha256', $data, $ksig, true));
	}

	public static function getValue($map, $key) {
    	return isset($map[$key]) ? $map[$key] : NULL;
	}

	public static function getUniqueBoundaryValue() {
		return uniqid();
	}

	public static function parseResponseFields($nodes) {
		$fields = array();
		foreach ($nodes->children() as $item) {
			if (count($item) == 0) {
				$fields[$item->getName()] = (string)$item;
			} else {
				$fields[$item->getName()] = (string)$item->asXML();
			}
		}
		return $fields;
	}

	public static function startsWith($haystack,$needle,$case=true) {
	    if($case){return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);}
	    return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
	}

	public static function endsWith($haystack,$needle,$case=true) {
	    if($case){return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);}
	    return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
	}

	public static function formatXMLGregorianCalendar($odt) {
	    try {
		$format1 = date("Y-m-d", $odt);
		// FIX MILLISECOND
		// CXF FORMATTA I MS senza 0 in coda
		$format2 = date("H:i:s", $odt);
		$format3 = date("P", $odt);
		$sb = "";
		$sb .= $format1;
		$sb .= "T";
		$sb .= $format2;
		$sb .= $format3;
		return $sb;
	    } catch (\Exception $e) {
	    }
	    return NULL;
	}

	public static function parseXMLGregorianCalendar($text) {
		if ($text == null)
			return NULL;
		$date = parseXMLGregorianCalendarTZ($text, "j-M-Y H:i:s.000P");
		if ($date == NULL)
			$date = parseXMLGregorianCalendarTZ($text, "j-M-Y H:i:s.00P");
		if ($date == NULL)
			$date = parseXMLGregorianCalendarTZ($text, "j-M-Y H:i:s.0P");
		if ($date == NULL)
			$date = parseXMLGregorianCalendarTZ($text, "j-M-Y H:i:sP");
		if ($date == NULL)
			$date = parseXMLGregorianCalendarDT($text, "j-M-Y H:i:s.000");
		if ($date == NULL)
			$date = parseXMLGregorianCalendarDT($text, "j-M-Y H:i:s.00");
		if ($date == NULL)
			$date = parseXMLGregorianCalendarDT($text, "j-M-Y H:i:s.0");
		if ($date == NULL)
			$date = parseXMLGregorianCalendarDT($text, "j-M-Y H:i:s");
		return $date;
	}

	private static function parseXMLGregorianCalendarTZ($text, $format) {
	    $count=1;
	    try {
	    $tmp = str_replace("T"," ",$text,$count);
	    return DateTime::createFromFormat(format, $tmp);
	    } catch (\Exception $e) {
	    }
	    return NULL;
	}

	private static function parseXMLGregorianCalendarDT($text, $format) {
	    $count=1;
	    try {
	    $tmp = str_replace("T"," ",$text,$count);
	    return DateTime::createFromFormat(format, $tmp);
	    } catch (Exception $e) {
	    }
	    return NULL;
	}

}


