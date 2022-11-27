<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

	if(isset($_REQUEST['delete']))
		{
	$aeid=intval($_GET['delete']);

	$sqldel = "DELETE from users WHERE userid=:aeid";
	$querydel = $dbh->prepare($sqldel);
	$querydel-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
	$querydel -> execute();
	$msg="Deleted Sucessfully";
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
	
	<title>Users</title>

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

						<h2 class="pull-left">Users</h2>
						<a style="margin:10px 20px 0 0;" href="add-user.php" class="pull-right btn btn-danger"><i  alt="Edit" class="	fa fa-user-plus"> </i>  &nbsp; Add User</a>
						<a style="margin:10px 20px 0 0;" href="add-lecture.php?add=<?php echo htmlentities($resulttemp->courseid); ?>" class="pull-right btn btn-primary"><i  alt="Edit" class="fa fa-download"> </i>  &nbsp; Download List</a>
						<div class="clearfix"></div>
						<hr>
						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">Users Info</div>
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>#</th>
										    <th>UserID</th>
											<th>Password</th>
											<th>Name</th>
											<th>Mobile No</th>
											<th>DOB</th>
											<th>City</th>
											<th>School</th>
										</tr>
									</thead>		
								<tbody>

<?php 
$sql = "SELECT * FROM users ORDER BY userid DESC";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($result->userid);?></td>
											<td><?php echo htmlentities($result->password);?></td>
											<td><?php echo htmlentities($result->fullname);?></td>
											<td><?php echo htmlentities($result->mobilenumber);?></td>
											<td><?php echo htmlentities($result->dob);?></td>
											<td><?php echo htmlentities($result->city);?></td>
											<td><?php echo htmlentities($result->school);?></td>									

											<td>
											<a href="user-list.php?delete=<?php echo htmlentities($result->userid);?>" onclick="return confirm('Do you really want Change Information')"><i alt="Delete" class="fa fa-trash" style="font-size:20px; color:red"></i></a> 
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
