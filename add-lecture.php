<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 

if(isset($_GET['add']))
	{
	$id=$_GET['add'];
}
if(isset($_GET['delete']))
	{
	$iddelete=$_GET['delete'];
	$sqldel = "DELETE from  coursecontent where lessonid = (:deleteid)";
	$querydel = $dbh->prepare($sqldel);
	$querydel -> bindParam(':deleteid',$iddelete, PDO::PARAM_STR);
	$querydel -> execute();
	$msg="Deleted successfully";
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
	
	<title>Add Lecture</title>

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
					<?php $sql = "SELECT * from  course where courseid = (:id)";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':id',$id,PDO::PARAM_STR);
                        $query->execute();
                        $resulttemp=$query->fetch(PDO::FETCH_OBJ);         
                    ?>	
						<h2 class="page-title"><?php echo $resulttemp->title?></h2>
						<a href="add-content.php" class="page-title btn btn-primary"><i  alt="Edit" class="fa fa-reply"> </i>  &nbsp; Back</a>
                        <a href="process-content.php?process=<?php echo htmlentities($resulttemp->courseid);?>" class="page-title btn btn-danger"><i  alt="Edit" class="fa fa-plus"> </i>  &nbsp; Add Content</a>
						
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading"><h6>Basic Info</h6></div>
                                    
<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

<div class="panel-body">
<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
                                        <th>#</th>
                                        <th>Lession Title</th>
                                        <th>Lession Description</th>
                                        <th><i class="fa fa-play-circle-o"></i> Video</th>
                                        <th><i class="fa fa-file-pdf-o"></i> Document</th>
                                        <th><i class="fa fa-clock-o"></i> Video Duration</th>
										</tr>
									</thead>
									
									<tbody>

<?php $sql = "SELECT * from  coursecontent where courseid = (:courseid)";
$query = $dbh -> prepare($sql);
$query->bindParam(':courseid',$id,PDO::PARAM_INT);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
										<tr>
                                             <td><?php echo $cnt;?></td>
                                       		 <td width="250px"><?php echo htmlentities($result->lessiontitle);?></td>
                                             <td width="280px"><?php echo htmlentities($result->lessondesc);?></td>
                                             <td><a href="<?php echo htmlentities($result->videolink);?>"> View</a></td>
                                             <td><a href="documents/<?php echo htmlentities($result->exdocument);?>"> View</a></td>
                                             <td><?php echo htmlentities($result->videotime);?> Min</td>
											 <td>
											<a href="edit-lecture.php?editlec=<?php echo htmlentities($result->lessonid);?>" onclick="return confirm('Do you really want Change Information')"><i  alt="Edit" class="fa fa-pencil-square" style="font-size:20px"></i></a> 
											</td>
											<td>
											<a href="add-lecture.php?delete=<?php echo htmlentities($result->lessonid);?>&add=<?php echo htmlentities($result->courseid);?>" onclick="return confirm('Do you really want Delete Information')"><i alt="Delete" class="fa fa-trash" style="font-size:20px; color:red"></i></a> 
											</td>
										</tr>
										<?php $cnt = $cnt + 1; }} ?>
									</tbody>
								</table>
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