<?php

namespace MyQRCode;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "phpqrcode" . DIRECTORY_SEPARATOR . "qrlib.php";
use QRcode;

class MyQRCode {
    private $toencode;
    private $file;
    
    public function __construct($toencode, $file) {
        $this->toencode = $toencode;
        $this->file = $file;
    }
    
    public function encode(){
        if(isset($this->toencode) && isset($this->file))
            QRcode::png($this->toencode, $this->file, QR_ECLEVEL_L, 3);
    }
}
