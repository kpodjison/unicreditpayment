<?php

namespace Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API;

use Kpodjison\Unicreditpayment\UniCredit\IGFS_CG_API\IOException;

class ConnectionException extends IOException {
    public function __construct($url, $message) {
        parent::__construct("[" . $url . "] " . $message);
    }
}
