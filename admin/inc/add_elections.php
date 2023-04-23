<?php
	if(isset($_GET['added'])) {

?>
<div class="alert alert-success" role="alert">
	Election has been added successfully!
</div>
<?php
	} else if(isset($_GET['delete_id'])) {
		$d_id = $_GET['delete_id'];
		mysqli_query($db, "DELETE FROM election WHERE id = '".$d_id."' ") or die(mysqli_error($db));

		?>
			<div class="alert alert-danger" role="alert">
	Election has been deleted successfully!
</div>
		<?php
	}
?>
<div class="row my-3">
	<div class="col-4">
		<h3>Add New Election</h3>
		<form action="" method="POST">
			<div class="form-group my-2">
				<input type="text" name="election_topic" placeholder="Election Topic" class="form-control" required>
			</div>
			<div class="form-group my-2">
				<input type="text" name="no_of_candidates" placeholder="No of Candidates" class="form-control" required>
			</div>
			<div class="form-group my-2">
				<input type="text" onfocus="this.type='Date'" name="starting_date" placeholder="Starting Date" class="form-control" required>
			</div>
			<div class="form-group my-2">
				<input type="text" onfocus="this.type='Date'" name="ending_date" placeholder="Ending Date" class="form-control" required>
			</div>
			<input type="submit" value="Add Election" name="addElectionBtn" class="btn btn-success">
		</form>
	</div>

	<div class="col-8">
		<h3>Upcoming Elections</h3>
		<table class="table">
  			<thead>
    			<tr>
      				<th scope="col">ID No.</th>
      				<th scope="col">Election Name</th>
      				<th scope="col"># Candidates</th>
      				<th scope="col">Starting On</th>
      				<th scope="col">Ending On</th>
      				<th scope="col">Status</th>
      				<th scope="col">Action</th>
    			</tr>
			</thead>
  			<tbody>
  				<?php
  					$fetchData = mysqli_query($db, "SELECT * FROM election") or die(mysqli_error($db));
  					$isAnyElectionAdded = mysqli_num_rows($fetchData);

  					if($isAnyElectionAdded > 0)
  					{
  						$sno = 1;
  						while($row = mysqli_fetch_assoc($fetchData))
  						{
  							$election_id = $row['id'];
  						?>
  							<tr>
  								<td><?php echo $sno++; ?></td>
  								<td><?php echo $row['election_topic']; ?></td>
  								<td><?php echo $row['no_of_candidates']; ?></td>
  								<td><?php echo $row['starting_date']; ?></td>
  								<td><?php echo $row['ending_date']; ?></td>
  								<td><?php echo $row['status']; ?></td>
  								<td>
  									<button class="btn btn-sm btn-danger"
  										onclick="DeleteData(<?php echo $election_id; ?>)" 
  									>Delete</button>
  								</td>
  							</tr>
  						<?php
  						}
  					} else {
  						?>
  						<tr>
  							<td colspan="7">No election is added yet.</td>
  						</tr>
  						<?php
  					}
  				?>
  			</tbody>
		</table>
	</div>
</div>


<script>
	const DeleteData = (e_id) => {
		let c = confirm("Are you sure you want to delete this election?");

		if(c == true) {
			location.assign("index.php?addElectionPage=1&delete_id=" + e_id)
		}
	}
</script>


<?php
	if(isset($_POST['addElectionBtn'])) {
		$election_topic = mysqli_real_escape_string($db, $_POST['election_topic']);
		$no_of_candidates = mysqli_real_escape_string($db, $_POST['no_of_candidates']);
		$starting_date = mysqli_real_escape_string($db, $_POST['starting_date']);
		$ending_date = mysqli_real_escape_string($db, $_POST['ending_date']);
		$inserted_by = $_SESSION['su_username'];
		$inserted_on = date("Y-m-d");

		$date1 = date_create($inserted_on);
		$date2 = date_create($starting_date);
		$diff = date_diff($date1, $date2);
		$diff->format("%R%a");

		if((int)$diff->format("%R%a") > 0) {
			$status = "Inactive";
		} else {
			$status = "active";
		}

		mysqli_query($db, "INSERT INTO election (election_topic, no_of_candidates, starting_date, ending_date, status, inserted_by, inserted_on) VALUES ('".$election_topic."', '".$no_of_candidates."', '".$starting_date."', '".$ending_date."', '".$status."', '".$inserted_by."', '".$inserted_on."')") or die(mysqli_error($db));

		?>
			<script>location.assign("index.php?addElectionPage=1&added=1")</script>
		<?php

	}
?>