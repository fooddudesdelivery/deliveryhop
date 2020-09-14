<?php
require('includes/restaurant_login/tcpdf/tcpdf.php');
include_once dirname(__FILE__) . '/../../../db_config.php';
 class Custom_PDF extends TCPDF {
    protected $footer_text;
	
	public function setFooterText($ftxt='') {
		$this->footer_text = $ftxt;
	}
	public function getFooterText() {
		return $this->footer_text;
	}
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 10);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages().' '.$this->getFooterText(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
	
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo.png';
        $this->Image($image_file, 10, 15, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', '', 11);
        // Title
		
		
		/*$this->Write(0, '(800) 599-5770  Tel', '', 0, 'R', true, 0, false, false, 0);
		$this->Write(0, '(800) 599-2974 Fax', '', 0, 'R', true, 0, false, false, 0);
		$this->Write(0, 'service@staging.fooddudesdelivery.com', '', 0, 'R', true, 0, false, false, 0);*/

        $this->Write(0, _PDF_SERVICE_PHONE, '', 0, 'R', true, 0, false, false, 0);
        $this->Write(0, _PDF_SERVICE_FAX, '', 0, 'R', true, 0, false, false, 0);
        $this->Write(0, _PDF_SERVICE_EMAIL, '', 0, 'R', true, 0, false, false, 0);


    }
}


?>