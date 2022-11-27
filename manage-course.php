<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 
	
	if(isset($_GET['delete']))
	{
	$id=$_GET['delete'];
	$sql = "delete from course WHERE courseid=:id";
	$query = $dbh->prepare($sql);
	$query -> bindParam(':id',$id, PDO::PARAM_STR);
	$query -> execute();
	$msg="Course Deleted successfully";

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
	
	<title>Manage Course</title>

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
					
					<h2 class="page-title">Manage Course</h2>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Basic Info</div>
                        <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

<div class="panel-body">
<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>Course ID</th>
                                        <th>Course Picture</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Course Title</th>
                                        <th>Sub Title</th>
                                        <th>Description</th>
                                        <th>Course Price</th>
										</tr>
									</thead>
									
									<tbody>

<?php $sql = "SELECT * from  course";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
										<tr>
											 <td><?php echo htmlentities($result->courseid);?></td>
                                       		 <td><img src="courseimage/<?php echo htmlentities($result->courseimg);?>" width="80px"></td>
                                             <td><?php echo htmlentities($result->class);?></td>
                                             <td><?php echo htmlentities($result->subject);?></td>
                                             <td><?php echo htmlentities($result->title);?></td>
                                             <td><?php echo htmlentities($result->subtitle);?></td>
                                             <td><?php echo htmlentities($result->description);?></td>
                                             <td><?php echo htmlentities($result->price);?> ₹</td>
											 <td>
											<a href="edit-course.php?edit=<?php echo htmlentities($result->courseid);?>" onclick="return confirm('Do you really want Change Information')"><i  alt="Edit" class="fa fa-pencil-square" style="font-size:20px"></i></a> 
											</td>
											<td>
											<a href="manage-course.php?delete=<?php echo htmlentities($result->courseid);?>" onclick="return confirm('Your Course Video is Delete with This!')"><i alt="Delete" class="fa fa-trash" style="font-size:20px; color:red"></i></a> 
											</td>
										</tr>
										<?php $cnt=$cnt+1; }} ?>
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