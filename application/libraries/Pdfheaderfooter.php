 <?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ini_set("display_errors", 1);
require_once('tcpdf/tcpdf.php');
//require_once('tcpdf/tcpdi.php');

class Pdfheaderfooter extends TCPDF {
 
  //Page header
  public function Header() {
    // $arial = TCPDF_FONTS::addTTFfont('./assets/ARIALBD.ttf','TrueTypeUnicode', '', 32);
    
 // ob_end_clean();  
   // $this->Cell(100, 0, 'Hal '.$this->getAliasNumPage().' dari '.$this->getAliasNbPages().' hal', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    //$this->SetFontSize(8);
    // $html .= '<table style:="width:100">
    //         <tr>            
    //         <td colspan="3" style="text-align:center"><b style="font-size:16pt">PT SUCOFINDO (PERSERO)</b><br><b style="font-size:14pt">Job Description</b></td>
    //         <td><img src="./assets/images/sucofindo_logo.png" width="80" height ="50"></td>
    //         </tr>
    //         </table>';
    //  // $this->WriteHTML($html, false, 0, false, 0);
    // $this->WriteHTML($html, true, false, false, false, '');

    // $this->SetAutoPageBreak(true, 20);
    // get the current page break margin
        // $bMargin = $this->getBreakMargin();
        // // get current auto-page-break mode
        // $auto_page_break = $this->AutoPageBreak;
        // // disable auto-page-break
        // $this->SetAutoPageBreak(false, 0);
        // // set bacground image
        // // $img_file = K_PATH_IMAGES.'image_demo.jpg';
        // // $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // // restore auto-page-break status
        // $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // // set the starting point for the page content
        // $this->setPageMark();
        
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        // Title
        // $this->Cell(100, 150, 'PT SUCOFINDO', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(100, 1, 'PT COMPANY', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(8);
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(100, 1, 'Job Description', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $image_file = K_PATH_IMAGES.'sucofindo_logo.png';
        // $this->setImageScale(2.00);
        $this->Image($image_file, 140, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(50, 0, 0)));
  }
 
  // Page footer
  public function Footer() {
    // Position at 15 mm from bottom
    $this->SetY(-20);
    $html = '<div style="width:100%;border-top: 1px solid #000"></div><table>'
            .'<tr>'
            .'<td>FOR/SCI-SDM/03'
            .'</td>'
            .'<td>Rev. 00'
            .'</td>'
            .'<td>Berlaku tgl : ...........'
            .'</td>'
            .'<td>Hal '.$this->getAliasNumPage().' dari '.$this->getAliasNbPages().' hal'
            .'</td>'
            .'</tr>'
            .'</table>';
    $this->SetFont('helvetica','', 8);
        // Page number
     $this->WriteHTML($html, true, false, false, false, '');
 // ob_end_clean();  
   // $this->Cell(100, 0, 'Hal '.$this->getAliasNumPage().' dari '.$this->getAliasNbPages().' hal', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    //$this->SetFontSize(8);
  } 
}

/* End of file Pdfheaderfooter.php */