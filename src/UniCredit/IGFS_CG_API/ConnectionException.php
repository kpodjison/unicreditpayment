<?php

namespace src\UniCredit\IGFS_CG_API;

use src\UniCredit\IGFS_CG_API\IOException;

class ConnectionException extends IOException {
    public function __construct($url, $message) {
        parent::__construct("[" . $url . "] " . $message);
    }
}
