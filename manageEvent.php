<?php
//connect to database
require_once 'php/connectTosql.php';
$organizerID  = $_SESSION['organizerID'];

if (isset($_GET['eventName']) && $_GET['eventName'] != '') {
 $eventName = $_GET['eventName'];
 $mainQuery = mysqli_query($con, "SELECT * FROM event WHERE organizer_ID = '$organizerID ' AND  name_Event like '%$eventName%' ") or die(mysqli_error($con));
} else {
 $mainQuery = mysqli_query($con, "SELECT * FROM event WHERE organizer_ID = '$organizerID '") or die(mysqli_error($con));
}

///delete event
if (isset($_GET['isDeleteAction']) && $_GET['isDeleteAction'] != '') {
if (isset($_GET['eventId']) && $_GET['eventId'] != '') {
//retreive the hidden id in modal
 $eventId = $_GET['eventId'];
 $sql     = "delete from  event  WHERE  event_ID = '$eventId'";
 $query   = mysqli_query($con, $sql) or die(mysqli_error($con));
 //succsess to retreive id
 if ($query) {
  $retVal = true;
  echo json_encode($retVal); //convert value to client side jQ
  exit;
 } else {
  $retVal = false;
  echo json_encode($retVal);
  exit;
 }
}else  {
   echo " <div class='alert alert-danger alert-dismissible'>
           <button type='button' class='close' data-dismiss='alert'>&times;</button>
            عملية حذف خاطئة الرجاء اختيار الحدث الفرعي  المراد حذفها
					</div> ";
 }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">


<!-- lobrary of icon  fa fa- --->
<title>إدارة الأحداث</title>

<link href='http://fonts.googleapis.com/earlyaccess/notonastaliqurdudraft.css' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/earlyaccess/notokufiarabic.css' rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">

<link rel="stylesheet" href="css/layouts/custom.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/icon.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/main-rtl.css">

<link rel="shortcut icon" href="image/logo.ico" type="image/x-icon" />


<!-------------------------------------------------------------------------->

</head>

<body>


  <div class="mainContent">

    <div class="container">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4 class="panelTitle">إدارة الأحداث</h4>
        </div>
        <div class="panel-body">

          <form action="manageEvent.php" class="manageEventFrm" method="Get">

            <div class="col-md-12">
              <div class="form-group form-group-lg">
                <label for="eventName" class="control-label"> اسم الحدث</label>
                <input type="text" class="form-control" id="txtEventName" name="eventName" placeholder="بحث باسم الحدث  ..." >
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group form-group-lg">
                 <input type="submit" value="بحث" name="update" class="btn btn-nor-primary btn-sm">
                 <a class="btn btn-nor-primary btn-sm" href="addEvent.php"> إضافة حدث</a>

              </div>
            </div>
          </form>
        </div>
      </div>


    <table class="table table-striped">
      <tr>
        <th>اسم الحدث</th>
        <th> اسم الشركة المنظمة </th>
        <th> تاريخ بداية الحدث </th>
        <th> تاريخ نهاية الحدث </th>
        <th> خيارات </th>
      </tr>

      <?php
while ($row = mysqli_fetch_array($mainQuery)):
 echo "<tr>";
 echo "<td><a  href='eventDetails.php?eventid=" . $row['event_ID'] . "'>" . $row['name_Event'] . "</a></td>";
 echo "<td>" . $row['organization_name_Event'] . "</td>";
 echo "<td>" . $row['sartDate_Event'] . "</td>";
 echo "<td>" . $row['endDate_Event'] . "</td>";
 echo "<td> <a id='aEditEvent' href='editEvent.php?eventid=" . $row['event_ID'] . "'><span class='fa fa-edit' style='font-size:24px;'></span></a>
				        <a href='#' id='aDeletEvent' class='adelete' data-id=" . $row['event_ID'] . "><span  class=' fa fa-trash' style='font-size:24px;color:red;  '></span> </a></td>
				      </tr>";
 ?>
			      <?php endwhile;?>


    </table>
 </div>


<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">حذف حدث</h4>
      </div>
      <div class="modal-body">
        <p>هل انت متأكد من حذف الحدث</p>
        <input type="hidden" id="hdEventId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
        <button type="button" id="btnConfirmDelete" class="btn btn-primary">تأكيد الحذف</button>
      </div>
    </div>
  </div>
</div>

 <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/appjs/event.js"></script>
    <script src="js/appjs/common.js"></script>

    <script>
      $(function () {
        $("#includedContent").load("php/TopNav.php");
        $("#includedContent2").load("HTML/rightNav.html");
      });
    </script>

</body>

</html>