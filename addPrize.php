<?php
// connect to DB
require_once 'php/connectTosql.php';
if (isset($_SESSION['organizerID'])) {
  $orgID     = $_SESSION['organizerID'];
  $query     = mysqli_query($con, "SELECT * FROM event WHERE organizer_ID = '$orgID'") or die(mysqli_error($con));
  $eventId   = "";
  $prizeName = "";
  if (isset($_POST['add'])) {
    $eventId    = $_POST['eventId']; // clear code this not acceptable
    $prizeName  = $_POST['prizeName'];
    $numOfPrize = $_POST['prizeNum'];
    $subeventId    = $_POST['subEventId']==''? null:$_POST['subEventId'];
//if($eventId != 0)

    $sql = mysqli_query($con, "INSERT INTO prize(Prize_ID,namePrize,numOfPrize,event_ID,subevent_ID)
     VALUES ('','$prizeName','$numOfPrize','$eventId','$subeventId')") or die(mysqli_error($con));

    if ($sql) {
      header("location:managePrize.php");
      exit;
    } else {
      echo " <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
         <strong> فشل</strong>  لم تتم عملية الاضافة بنجاح يرجى التحقق
       </div> ";
    }
  }

}

?>




<!DOCTYPE html>
<html lang="ar">

<head>
  <title>إضافة جائزة </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">





  <link rel='stylesheet' href='http://fonts.googleapis.com/earlyaccess/notonastaliqurdudraft.css' type='text/css' />
  <link rel='stylesheet' href='http://fonts.googleapis.com/earlyaccess/notokufiarabic.css' type='text/css' />
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
  <div id="includedContent"></div>
  <div id="includedContent2"></div>
  <div class="mainContent">
    <div class="container">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4 class="panelTitle"> إضافة جائزة </h4>
        </div>
        <div class="panel-body">

          <form action="" class="formDivAddPrize" method="post">

           <div class="col-md-12">
              <div class="form-group form-group-lg">
                <label for="eventName" class="control-label"> اسم الحدث</label>
                <select class="form-control" id="eventName" name="eventId" >
                <option value=""> اختيار </option >
                  <?php
while ($row = mysqli_fetch_array($query)):
  echo "<option value='" . $row['event_ID'] . "'>" . $row['name_Event'] . "</option>";
  ?>
	                  <?php endwhile;?>

                </select>
              </div>
            </div>

             <div class="col-md-12">
              <div class="form-group form-group-lg">
                 <label for="subEventName" class="control-label"> اسم الحدث الفرعي</label>
                <select class="form-control" id="subEventName" name="subEventId" >
                 <option value=""> اختيار </option >
                </select>
              </div>
            </div>

            <div class="col-md-12">
                <div class="form-group form-group-lg">
                <label for="prizeName" class="control-label"> اسم الجائزة</label>
                <input type="text" class="form-control" id="prizeName"  name="prizeName"
                  >
              </div>
            </div>

          <div class="col-md-12">
              <div class="form-group form-group-lg">
                   <label  class="control-label"> عدد الجوائز</label>
                 <input type="number" class="form-control" id="prizeNum"  name="prizeNum"
                  >
                  </div>
                 </div>

           <a  href="/tactic/managePrize.php"  class="bodyform btn btn-nor-danger btn-sm">رجوع</a>
            <input type="submit" value="إضافة" name="add" class="btn btn-nor-primary btn-lg enable-overlay">


        </form>

      </div>
    </div>
  </div>
  </div>



  <!-- end of  register inputs -->
        <script src="js/jquery.min.js"></script>
	    <script src="js/jquery.validate.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/appjs/prize.js"></script>
        <script src="js/appjs/common.js"></script>
  <script>
  // this part for call navBar
    $(function () {
      $("#includedContent").load("php/TopNav.php");
      $("#includedContent2").load("HTML/rightNav.html");
    });
  </script>

</body>
</html>