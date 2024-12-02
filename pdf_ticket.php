<?php
/*
mPDF: Generate PDF from HTML/CSS (Complete Code)
*/
require_once( 'mpdf/mpdf.php'); // Include mdpf
$stylesheet = file_get_contents('assets/css/pdf.css'); // Get css content
$html = '<div id="pdf-content">
              Your PDF Content goes here (Text/HTML)
         </div>';
// Setup PDF
$mpdf = new mPDF('utf-8', 'A4-L'); // New PDF object with encoding & page size
$mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping
$mpdf->setAutoBottomMargin = 'stretch'; // Set pdf bottom margin to stretch to avoid content overlapping
// PDF header content
$mpdf->SetHTMLHeader('<div class="pdf-header">
                          <img class="left" src="assets/img/pdf_header.png"/>                      
                      </div>'); 
// PDF footer content                      
$mpdf->SetHTMLFooter('<div class="pdf-footer">
                        <a href="http://www.lubus.in">www.lubus.in</a>
                      </div>'); 
 
$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
$mpdf->WriteHTML($html); // Writing html to pdf
// FOR EMAIL
$content = $mpdf->Output('', 'S'); // Saving pdf to attach to email 

$mpdf->Output('lubus_mdpf_demo.pdf','D'); // For Download
exit;
?>