<?php
require_once 'php/connectTosql.php';
$organizerid = $_SESSION['organizerID'];

// to update badge record after user update the form : type post
if (isset($_POST['update'])) {

 $badgeId     = $_GET['badgeId'];
 $eventId     = $_POST['eventID'];
 $badgeTypeId = $_POST['badgeTypeId'];
 $fileDeatils = '';

//to prevent user add more than item from same badge type with event
 $checkQuery = mysqli_query($con, "SELECT * FROM badge WHERE event_ID='$eventId' and
 BadgeTypeId='$badgeTypeId' and badge_ID!='$badgeId'") or die(mysqli_error());

 if (mysqli_num_rows($checkQuery) > 0) {
  echo "<div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        <strong> فشل</strong>  الحدث مرتبط ببطاقة مسبقا لا يمكن اتمام العملية
        </div> ";
 } else {
  // in case user upload new file we need to process it or i don't want to check anything about file
  // when error=UPLOAD_ERR_OK this mean file upload without any error
  if ($_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {

   $name     = $_FILES['fileToUpload']['name'];
   $size     = $_FILES['fileToUpload']['size'];
   $type     = $_FILES['fileToUpload']['type'];
   $tmp_name = $_FILES['fileToUpload']['tmp_name'];

   $location = "UploadFile/badges/";

   $max_size = 100000;
   if ($size <= $max_size) {
    if (move_uploaded_file($tmp_name, $location . $name)) {

     $fileDeatils = " ,badgeTemplateName='$name',
                            badgeTemplateSize='$size',
                            badgeTemplateType='$type',
                            badgeTemplateLocation='$location$name' ";

    } else {
     // file saved in files directory
     echo " <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        <strong> فشل</strong>  يوجد خطأ في حفظ الملف
        </div> ";

    }
   } else // for check the size of image
   {
    echo " <div class='alert alert-danger alert-dismissible'>
           <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong> يرجى</strong>  أكبر حجم للملف هو 10 ميغا
          </div> ";
   }
  } // end if file exist

  $sql = " UPDATE badge SET  BadgeTypeId='$badgeTypeId',
                            event_ID='$eventId'
                             $fileDeatils
                            WHERE badge_ID ='$badgeId' ";

  $sql = mysqli_query($con, $sql) or die(mysqli_error($con));
  if ($sql) {
   header("location: /tactic/manageBadge.php");
   exit;
  } else {
   echo " <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
         <strong> فشل</strong>  لم تتم عملية الاضافة بنجاح يرجى التحقق
       </div> ";
  }
 }
}

// for get the recoed of badge when page load // get type
if (isset($_GET['badgeId'])) {

 $badgeId = $_GET['badgeId'];
 // to fill drop down list of events
 $eventQuery = mysqli_query($con, "SELECT * FROM event where organizer_ID=  '$organizerid'") or die(mysqli_error($con));
// to fill drop down list of badge type
 $badgeTypeQuery = mysqli_query($con, "SELECT * FROM BadgeType ") or die(mysqli_error($con));
// to get the record of badge that already added from add page
 $badgeQuery = mysqli_query($con, "SELECT * FROM badge where badge_ID=$badgeId") or die(mysqli_error($con));

 $row = mysqli_fetch_row($badgeQuery);

 $badgeTypeId           = $row[1];
 $eventId               = $row[2];
 $badgeTemplateLocation = $row[6];

}

?>
<!DOCTYPE html>
<html>

<head>
  <title>تعديل بطاقة تعريفية </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- lobrary of icon  fa fa- --->


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
          <h4 class="panelTitle" >تعديل بطاقة تعريفية </h4>
        </div>
        <div class="panel-body">

          <form action="" class="formDivEditBadge" method="post" enctype="multipart/form-data">
 <div class="col-md-12">
              <div class="form-group form-group-lg">
                <label for="eventID" class="control-label"> اسم الحدث<label style="color:red">*&nbsp; </label></label>
                <select class="form-control" id="eventID" name="eventID" >
                  <?php
echo '<option  value=" ">اختيار</option>';

while ($row = mysqli_fetch_array($eventQuery)):
 echo '<option  value="' . $row['event_ID'] . '" ' . ($eventId == $row['event_ID'] ? ' selected="selected"' : '') . '>' . $row['name_Event'] . '</option>';
 ?>

									                  <?php endwhile;?>

                </select>
              </div>
            </div>

 <div class="col-md-12">
              <div class="form-group form-group-lg">
                <label for="badgeType" class="control-label"> نوع البطاقة</label>
                <select class="form-control" id="badgeType" name="badgeTypeId" >
                  <?php
echo '<option  value=" ">الرجاء الاختيار</option>';

while ($row = mysqli_fetch_array($badgeTypeQuery)):
 echo '<option  value="' . $row['Id'] . '" ' . ($badgeTypeId == $row['Id'] ? ' selected="selected"' : '') . '>' . $row['Name'] . '</option>';
 ?>
									                  <?php endwhile;?>

                </select>
              </div>
            </div>


            <div class="col-md-12">
              <div class="form-group form-group-lg">
                <label for="fileToUpload" class="control-label"> ارفاق قالب البطاقة<label style="color:red">*&nbsp; </label></label>
                <input type="file" class="form-control" id="fileToUpload"  name="fileToUpload"  >
               <?php echo "
               <div class='download-file-container'><p class='UploaderNotes'>في حال لم تقم بإرفاق ملف سيتم المحافظة على الملف القديم</p><p><a title='تحميل الملف'
                href='download.php?file=" . $badgeTemplateLocation . "' data-id=" . $badgeId . ">تحميل الملف</a></p></div>"
?>
              </div>
            </div>



            <a  href="/tactic/manageBadge.php"  class="bodyform btn btn-nor-danger btn-sm">عودة</a>
             <input type="submit" value="تعديل" name = "update" class="btn btn-nor-primary btn-lg enable-overlay">


          </form>
</div>
        </div>
      </div>
    </div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/appjs/badge.js"></script>
  <script src="js/appjs/common.js"></script>

  <script>
    $(function () {
      $("#includedContent").load("php/TopNav.php");
      $("#includedContent2").load("HTML/rightNav.html");
    });
  </script>

</body>

</html>