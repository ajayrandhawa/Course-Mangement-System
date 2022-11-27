<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 

if(isset($_GET['process']))
	{
	$id=$_GET['process'];
}

if(isset($_POST['submit']))
  {
$file = $_FILES['lessionfile']['name'];
$file_loc = $_FILES['lessionfile']['tmp_name'];
$folder="documents/";
$new_size = $file_size/1024;  
$new_file_name = strtolower($file);
$final_file=str_replace(' ','-',$new_file_name);

$courseid=$id;
$lessiontitle=$_POST['lessontitle'];
$lessondesc=$_POST['lessondes'];
$videolink=$_POST['videolink'];
$videoduration=$_POST['vid-duration'];
$lessonfile = "#";
if(move_uploaded_file($file_loc,$folder.$final_file))
	{
		$lessonfile=$final_file;
	}
$sql="INSERT INTO coursecontent(courseid,lessiontitle,lessondesc,videolink,videotime,exdocument) VALUES (:courseid,:lessiontitle,:lessondesc,:videolink,:videoduration,:lessonfile)";
$query = $dbh->prepare($sql);
$query->bindParam(':courseid',$courseid,PDO::PARAM_INT);
$query->bindParam(':lessiontitle',$lessiontitle,PDO::PARAM_STR);
$query->bindParam(':lessondesc',$lessondesc,PDO::PARAM_STR);
$query->bindParam(':videolink',$videolink,PDO::PARAM_STR);
$query->bindParam(':videoduration',$videoduration,PDO::PARAM_STR);
$query->bindParam(':lessonfile',$lessonfile,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Video added successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

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
	
	<title>Add Video</title>

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
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Add Video</h2>
						<a href="add-lecture.php?add=<?php echo htmlentities($id); ?>" class="page-title btn btn-primary"><i  alt="Edit" class="fa fa-reply"> </i>  &nbsp; Back</a>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Basic Info</div>
<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

<div class="panel-body">
<form method="post" class="form-horizontal" enctype="multipart/form-data">

<div class="form-group">
<label class="col-sm-2 control-label">Lesson Title<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="lessontitle" class="form-control" required>
</div>
<label class="col-sm-2 control-label">Video Duration<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="number" name="vid-duration" class="form-control" placeholder="In Mintue" required>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Lesson Description<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="lessondes" ></textarea>
</div>
</div>
<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Video Link</label>
<div class="col-sm-4">
<input type="text" name="videolink" class="form-control">
</div>
<label class="col-sm-2 control-label">Additional Material</label>
<div class="col-sm-4">
<input type="file" name="lessionfile" class="form-control" value="Select Image File">
</div>
</div>




<div class="form-group">
	<div class="col-sm-8 col-sm-offset-2">
		<button class="btn btn-default" type="reset">Cancel</button>
		<button class="btn btn-primary" name="submit" type="submit">Save Changes</button>
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