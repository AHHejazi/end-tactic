<?php
require_once('php/connectTosql.php');
$eventName="";
$location="";
$startDate="";
$endDate="";
if(isset($_GET['attendeeID'])){
$attendeeID =$_GET['attendeeID'];
$query = mysqli_query($con,"SELECT event_ID , form FROM attendee WHERE Attendee_ID = '$attendeeID'");
$row =mysqli_fetch_array($query);
$eventID= $row[0];
$token = $row[1];
$query2 = mysqli_query($con,"SELECT * FROM event WHERE event_ID = '$eventID'");
while ($row =mysqli_fetch_array($query2)){
$eventName=$row[1];
$location=$row[5];
$startDate=$row[3];
$endDate=$row[4];
}
}


?>
<!DOCTYPE html>
<html lang="ar">
<head>
<title>شكرا لتسجيلك</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link href='http://fonts.googleapis.com/earlyaccess/notonastaliqurdudraft.css' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/earlyaccess/notokufiarabic.css' rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">

<link rel="stylesheet" href="css/layouts/custom.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/icon.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/main-rtl.css">
<link rel="shortcut icon" href="image/logo.ico" type="image/x-icon" />

</head>
<body>
  <div class="mainContent">
    <div class="container">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4 class="panelTitle"> شكرا لتسجيلك في <?php echo $eventName; ?> </h4>
        </div>
        <div class="panel-body">
			<div class="col-md-12">
            
<pre>
<h5>اسم الحدث : <mark><?php echo $eventName; ?></mark></h5>
<h5>موقع الحدث : <mark> <?php echo $location; ?></mark> </h5>
<h5>تاريخ بداية الحدث : <mark> <?php echo $startDate; ?></mark></h5>
<h5>تاريخ نهاية الحدث : <mark><?php echo $startDate; ?></mark></h5>
</pre>
<pre>
<h5>الباركود الخاص بك :</h5>
<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo $attendeeID;?>&choe=UTF-8' />
</pre>
			
<a href='Form.php?token=<?php echo $token; ?>' class="btn btn-nor-primary btn-lg enable-overlay">تسجيل أخر </a>
 <a href="#" class="btn btn-nor-primary btn-lg enable-overlay">
      <span class="glyphicon glyphicon-print"></span> طباعة 
    </a>				
            			
             
            </div>

	
 
 </div>  
 </div>
	  </div></div>


  <!-- end of  register inputs -->
 <script src="js/jquery.min.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/appjs/event.js"></script>
  <script src="js/appjs/common.js"></script>


</body>

</html>