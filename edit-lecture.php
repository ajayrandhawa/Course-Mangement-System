<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 

if(isset($_GET['editlec']))
	{
    $lecid=$_GET['editlec'];
}

if(isset($_POST['submitup']))
  {
$file = $_FILES['lessiondoc']['name'];
$file_loc = $_FILES['lessiondoc']['tmp_name'];
$folder="documents/";
$new_size = $file_size/1024;  
$new_file_name = strtolower($file);
$final_file=str_replace(' ','-',$new_file_name);

$lessonid=$_POST['lid'];
$courseid=$_POST['courseid'];
$lessontitle=$_POST['lessontitle'];
$lessondesc=$_POST['lessondes'];
$videolink=$_POST['videolink'];
$videoduration=$_POST['vid-duration'];
$lessondoc = $_POST['lessiondoc'];
if(move_uploaded_file($file_loc,$folder.$final_file))
		{
			$lessondoc=$final_file;
		}

$sql="UPDATE coursecontent SET lessiontitle=(:title), lessondesc=(:lessondesc), videolink=(:videolink), videotime=(:videodur), exdocument=(:lessondoc) WHERE lessonid=(:editid)";
$query = $dbh->prepare($sql);
$query->bindParam(':title',$lessontitle,PDO::PARAM_STR);
$query->bindParam(':lessondesc',$lessondesc,PDO::PARAM_STR);
$query->bindParam(':videolink',$videolink,PDO::PARAM_STR);
$query->bindParam(':videodur',$videoduration,PDO::PARAM_STR);
$query->bindParam(':lessondoc',$lessondoc,PDO::PARAM_STR);
$query->bindParam(':editid',$lessonid,PDO::PARAM_INT);
$query->execute();
$msg="Your Information Change successfully";

}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Edit Lecture</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">

	<script type= "text/javascript" src="../vendor/countries.js"></script>

  <style>
.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
	background: #dd3d36;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
	background: #5cb85c;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head>

<body>

<?php $sqltemp = "SELECT * from coursecontent where lessonid = (:id)";
                        $querytemp = $dbh -> prepare($sqltemp);
                        $querytemp->bindParam(':id',$lecid,PDO::PARAM_STR);
                        $querytemp->execute();
                        $resulttemp=$querytemp->fetch(PDO::FETCH_OBJ);         
                    ?>

	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Edit Info</h2>
						<a href="add-lecture.php?add=<?php echo htmlentities($resulttemp->courseid); ?>" class="page-title btn btn-primary"><i  alt="Edit" class="fa fa-reply"> </i>  &nbsp; Back</a>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Basic Info</div>
<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

<div class="panel-body">
<form method="post" class="form-horizontal" enctype="multipart/form-data">

<div class="form-group">
<label class="col-sm-2 control-label">Lesson ID<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="lid" class="form-control" required value="<?php echo htmlentities($resulttemp->lessonid); ?>" readonly>
</div>

<label class="col-sm-2 control-label">Course ID<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="courseid" class="form-control" required value="<?php echo htmlentities($resulttemp->courseid); ?>" readonly>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Lesson Title<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="lessontitle" class="form-control" required value="<?php echo htmlentities($resulttemp->lessiontitle); ?>">
</div>

<label class="col-sm-2 control-label">Video Duration<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="number" name="vid-duration" class="form-control" placeholder="In Mintue" required value="<?php echo htmlentities($resulttemp->videotime); ?>">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Lesson Description<span style="color:red">*</span></label>
<div class="col-sm-10">
<input type="text" class="form-control" name="lessondes" value="<?php echo htmlentities($resulttemp->lessondesc); ?>"></input>
</div>
</div>
<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Video Link</label>
<div class="col-sm-4">
<input type="text" name="videolink" class="form-control" value="<?php echo htmlentities($resulttemp->videolink); ?>">
</div>
<label class="col-sm-2 control-label">Additional Material</label>
<div class="col-sm-4">
<input type="file" name="lessiondoc" class="form-control">
<input type="hidden" name="lessiondoc" value="<?php echo htmlentities($resulttemp->exdocument);?>">
<label class="control-label"><?php echo htmlentities($resulttemp->exdocument); ?></label>
</div>
</div>

<div class="form-group">
	<div class="col-sm-8 col-sm-offset-2">
		<button class="btn btn-primary" name="submitup" type="submit">Update Changes</button>
	</div>
</div>

										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
<?php } ?>