<?php
// conect to database
require_once 'php/connectTosql.php';
// to enable write arabic letter in image
include 'phar://ArPHP.phar/Arabic.php';
// the image sourse to display in html
// test image
//$sorce = "image/download.jpg";
// get the value of input

function calculateX($value)
{
 $yposition = strpos($value, "Y");
 $xpostion  = strpos($value, "X");
 $left      = substr($value, $xpostion + 1, $yposition - 1);
 return $left;
}

function calculateY($value)
{
 $yposition = strpos($value, "Y");
 $top       = substr($value, $yposition + 1);
 return $top;
}

function setText($Arabic, $text)
{
 $text = $Arabic->utf8Glyphs($text);
 return $text;
}

// Set Path to Font File
putenv('GDFONTPATH=C:/xampp/htdocs/tactic/css/fonts');
$fontfile = 'C:/xampp/htdocs/tactic/css/fonts/arial.ttf';
// Set Text to Be Printed On Image in arabic
$Arabic = new I18N_Arabic('Glyphs');

$angle          = 0;
$attendeeID =$_POST["attendeeID"];

if ($attendeeID==0){
$visitorName    = $_POST["visitorName"];//position 
$visitorCareer  = $_POST["visitorCareer"];//position
$visitorBarcode = $_POST["barcode"];//position
$color          = $_POST["color"];
$barSize        = $_POST["barSize"];
$fontSize       = $_POST["fontSize"];
$imageName      = $_POST["sorce"];
$eventId        =$_PORST["eventId"];
$visitorNameVal =$_SESSION['OrgName'];//
$visitorCareerVal="منظم فعاليات";
$sorce = "image/" . $imageName;

if (!empty($_FILES["file"]["name"])) {

  $name     = $_FILES['file']['name'];
  $size     = $_FILES['file']['size'];
  $type     = $_FILES['file']['type'];
  $tmp_name = $_FILES['file']['tmp_name'];

  $badgeName=substr($type,6);
  $sorce = "UploadFile/".$eventId."/badge/badge.".$badgeName;
$imageName ="badge.".$badgeName;
  $max_size = 2000000;
  if ($size <= $max_size) {
    // check the type of image
   if ($type == "image/jpg" || $type == "image/JPG" || $type == "image/jpeg" || $type == "image/JPEG") {
   move_uploaded_file($tmp_name, $sorce );
   }
  }
}

}
else{
  $attende = mysqli_query($con, "SELECT *
  FROM ((attendee att INNER JOIN badge b ON att.eventId = b.event_ID)
    INNER JOIN imageinfo img ON img.badgeId = b.badge_ID)
    where att.id='$attendeeID ' ")
    or die(mysqli_error($con));
  
  
  while ($row = mysqli_fetch_array($attende)):
    //i dont thenk you need att id there it يكفي يلي فوق
    //the number is strannge becouce it use * in the quere 
  $visitorNameVal =$row[2];
  $visitorCareerVal=$row[7];
  $visitorName    = $row[28];//position 
  $visitorCareer  = $row[29];//position 
  $visitorBarcode = $row[30];//position 
  $color          = $row[24];
  $barSize        = $row[25];
  $fontSize       = $row[26];
  $eventId        = $row[18];//badge.eventId
  $imageName      = $attendeeID.".jpg";
  $sorce          =$row[22];//badgeTemplateLocation
  endwhile; 
}

// convert barcode to image
$barcode = file_get_contents("https://chart.googleapis.com/chart?chs=$barSize&cht=qr&chl=$attendeeID&choe=UTF-8");
// save image in pc
file_put_contents('UploadFile/'.$eventId .'/barcode/'.$attendeeID.'.png', $barcode);
// Load And Create Image From Source this bacground image
$image = imagecreatefromjpeg($sorce);
// Load the stamp and the photo to apply the watermark to this barcode image
$stamp = imagecreatefrompng('UploadFile/'.$eventId .'/barcode/'.$attendeeID.'.png');
//the url of the result barcod.jpg
//$name="name.jpg";
$output = "UploadFile/".$eventId."/badge/". $imageName;



// Allocate A Color For The Text Enter
switch ($color) {
 case "white":
  $color = imagecolorallocate($image, 255, 255, 255);
  break;
 case "red":
  $color = imagecolorallocate($image, 255, 0, 0);
  break;
 case "black":
  $color = imagecolorallocate($image, 0, 0, 0);
  break;
 default:
  $color = imagecolorallocate($image, 0, 0, 0);
}

// attende Name
$leftName = calculateX($visitorName) ;
$topName  = calculateY($visitorName) ;
///setText($Arabic, $visitorNameVal)

//$text = fagd($visitorNameVal,'fa','nastaligh');
imagettftext($image, $fontSize, $angle, $leftName, $topName, $color, $fontfile, setText($Arabic, $visitorNameVal) );

//attende Career
$leftCareer = calculateX($visitorCareer) ;
$topCareer  = calculateY($visitorCareer) ;
//Print Text On Image
imagettftext($image, $fontSize, $angle, $leftCareer-strlen("مهنة الزائر"), $topCareer, $color, $fontfile, setText($Arabic, $visitorCareerVal));

// attende Barcode

// Set the margins for the stamp and get the height/width of the stamp image
$marge_right  = calculateX($visitorBarcode) ;
$marge_bottom = calculateY($visitorBarcode) ;
$stampx       = imagesx($stamp);
$stampy       = imagesy($stamp);

// Copy the stamp image onto our photo using the margin offsets and the photo put two image togather
// width to calculate positioning of the stamp.
imagecopy($image, $stamp, $marge_right, $marge_bottom, 0, 0, $stampx, $stampy);

// Send Image to Browser
imagejpeg($image, $output);
if($attendeeID !=0){
header("location:confirmRegisterEvent.php?attendeeId=$attendeeID");}
echo json_encode($output);
?>


