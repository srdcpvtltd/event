<?php

include_once 'includes/connection.php';

require "vendor/PHPExcel-1.8/Classes/PHPExcel.php";
require "vendor/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel5.php"; 

$event_id=$_GET['event_id'];

function get_event_info($event,$field_name) 
{
  global $mysqli;

  $qry_user="SELECT * FROM tbl_events WHERE id='".$event."'";
  $query1=mysqli_query($mysqli,$qry_user);
  $row_user = mysqli_fetch_array($query1);

  $num_rows1 = mysqli_num_rows($query1);
  
  if ($num_rows1 > 0)
  {     
    return $row_user[$field_name];
  }
  else
  {
    return "";
  }
} 

function get_total_booking($event_id)
{ 
  global $mysqli;   

  $qry_songs="SELECT SUM(`total_ticket`) as num FROM tbl_event_booking WHERE event_id='".$event_id."'";
   
  $total_item = mysqli_fetch_array(mysqli_query($mysqli,$qry_songs));
  $total_item = $total_item['num'];
   
  return $total_item;

}

function get_user_info($user_id,$field_name) 
{
  global $mysqli;

  $qry_user="SELECT * FROM tbl_users WHERE id='".$user_id."'";
  $query1=mysqli_query($mysqli,$qry_user);
  $row_user = mysqli_fetch_array($query1);

  $num_rows1 = mysqli_num_rows($query1);
  
  if ($num_rows1 > 0)
  {     
    return $row_user[$field_name];
  }
  else
  {
    return "";
  }
}

function clean($string) {
   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '_', $string); // Removes special chars.

   return ucfirst(preg_replace('/-+/', '_', $string)); // Replaces multiple hyphens with single one.
}

$sql="SELECT tbl_event_booking.*, tbl_events.`event_title` FROM tbl_event_booking
      LEFT JOIN tbl_events ON tbl_event_booking.`event_id`=tbl_events.`id`
      WHERE tbl_event_booking.`event_id`='$event_id'
      ORDER BY tbl_event_booking.`id` DESC";  


$result=mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

ob_clean();

$objPHPExcel = new PHPExcel();

$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FF0000'),
        'size'  => 14
    ));

$styleArray2 = array(
    'font'  => array(
        'bold'  => true
    ));


$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:H1');
$objPHPExcel->getActiveSheet()
    ->getCell('A1')
    ->setValue(get_event_info($event_id,'event_title'));

$objPHPExcel->getActiveSheet()
    ->getStyle('A1')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A2:D2');
$objPHPExcel->getActiveSheet()
    ->getCell('A2')
    ->setValue('Start Date: '.date('d-m-Y',get_event_info($event_id,'event_start_date')));

$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray2);

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('E2:H2');
$objPHPExcel->getActiveSheet()
    ->getCell('E2')
    ->setValue('End Date: '.date('d-m-Y',get_event_info($event_id,'event_end_date')));

$objPHPExcel->getActiveSheet()
    ->getStyle('A2')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()
    ->getStyle('E2')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($styleArray2);

// for total and remain tickets

$total_booked=get_total_booking($event_id);
$remain_tickets=get_event_info($event_id,'event_ticket')-$total_booked;

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A3:D3');
$objPHPExcel->getActiveSheet()
    ->getCell('A3')
    ->setValue('Total Tickets: '.get_event_info($event_id,'event_ticket'));

$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($styleArray2);

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('E3:H3');
$objPHPExcel->getActiveSheet()
    ->getCell('E3')
    ->setValue('Remain Tickets: '.$remain_tickets);

$objPHPExcel->getActiveSheet()
    ->getStyle('A3')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()
    ->getStyle('E3')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleArray2);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Sr.')
            ->setCellValue('B4', 'Ticket No.')
            ->setCellValue('C4', 'Name')
            ->setCellValue('D4', 'Email')
            ->setCellValue('E4', 'Phone')
            ->setCellValue('F4', 'Total Tickets')
            ->setCellValue('G4', 'Booked By')
            ->setCellValue('H4', 'Date');

$objPHPExcel->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Miscellaneous glyphs, UTF-8
$no=1;
$rowCount=5;

$event_title='';

while($row = mysqli_fetch_assoc($result)){

      $event_title=$row['event_title'];

      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['ticket_no']);
      $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['user_name']);
      $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['user_email']);
      $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['user_phone']);
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row['total_ticket']);
      $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, get_user_info($row['user_id'],'name'));
      $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, date('d-m-Y',$row['created_at']));
      $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':H'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $rowCount++;
}


if(!isset($_GET['file_name']))
  $filename=clean($event_title).'_'.date('d_m_y').'.xls';  
else
  $filename=$_GET['file_name'];

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Booking List');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment;filename="'.$filename);
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// $objWriter->save(str_replace(__FILE__,'excels/'.$filename,__FILE__));

$objWriter->save('php://output');

?>