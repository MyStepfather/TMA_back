<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
	public function generate(string $data) {
        $qrCode = QrCode::size(120)->encoding('UTF-8')->generate($data);
        
        return $qrCode;    
    }
}