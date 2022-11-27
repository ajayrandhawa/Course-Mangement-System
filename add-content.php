<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 

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
	
	<title>Add Content</title>

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
						<h2 class="page-title">Courses</h2>
                            <div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">All Course</div>
<div class="panel-body">

<?php 
$sql = "SELECT * from course";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{?>	

<div class="row">
<div class="col-md-3">
<div class="card" style="border:1px solid #DFDFDF;padding:10px;">
  <img class="card-img-top" src="courseimage/<?php echo htmlentities($result->courseimg);?>" style="width:100%; height:150px;">
  <hr>
  <div class="card-body" style="height:70px;">
  <h5 class="card-title"><b>Title : </b><?php echo htmlentities($result->title);?></h5> 
	<?php
		$sqlctn = "SELECT count(courseid) as countlec from coursecontent where courseid = (:id)";
		$queryctn = $dbh -> prepare($sqlctn);
		$queryctn->bindParam(':id',$result->courseid,PDO::PARAM_STR);
		$queryctn->execute();
		$resultsctn=$queryctn->fetch(PDO::FETCH_OBJ);
	?>
	<h5 class="card-title"><b>Total Lecture : </b><?php echo htmlentities($resultsctn->countlec);?></h5>
	<h5 class="card-title"><b>Course ID : </b><?php echo htmlentities($result->courseid);?></h5>
  </div>
  <hr>
  <a href="add-lecture.php?add=<?php echo htmlentities($result->courseid);?>" onclick="return confirm('Do you really want Add Lecture')" class="btn btn-primary">Go To Course</a>
  </div>
</div>

<?php }} ?>
</div>

										
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