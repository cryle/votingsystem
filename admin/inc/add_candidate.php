<?php
if (isset($_GET['added'])) {

?>
	<div class="alert alert-success" role="alert">
		Candidate has been added successfully!
	</div>
<?php
} else if (isset($_GET['largeFile'])) {
?>
	<div class="alert alert-danger" role="alert">
		Candidate image is too large! (5mb or lower only)
	</div>
<?php
} else if (isset($_GET['invalidFile'])) {
?>
	<div class="alert alert-danger" role="alert">
		Invalid file format!
	</div>
<?php
} else if(isset($_GET['delete_id'])) {
		$d_id = $_GET['delete_id'];
		mysqli_query($db, "DELETE FROM candidate_details WHERE id = '".$d_id."' ") or die(mysqli_error($db));

		?>
			<div class="alert alert-danger" role="alert">
	Candidate has been deleted successfully!
</div>
		<?php
	}
?>
<div class="row my-3">
	<div class="col-4">
		<h3>Add New Candidate</h3>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group my-2">
				<select class="form-control" name="election_id" required>
					<option value="">Select Election</option>
					<?php
					$fetchingElections = mysqli_query($db, "SELECT * FROM election") or die(mysqli_error($db));
					$isAnyElectionAdded = mysqli_num_rows($fetchingElections);

					if ($isAnyElectionAdded > 0) {
						while ($row = mysqli_fetch_assoc($fetchingElections)) {
							$election_id = $row['id'];
							$election_name = $row['election_topic'];
							$allowed_candidates = $row['no_of_candidates'];

							$fetchingCandidate = mysqli_query($db, "SELECT * FROM candidate_details WHERE election_id = '".$election_id."'") or die(mysqli_error($db));
							$added_candidates = mysqli_num_rows($fetchingCandidate);

							if($added_candidates < $allowed_candidates) {
							?>
								<option value="<?php echo $election_id; ?>"><?php echo $election_name; ?></option>
							<?php
							}
						}
					} else {
						?>
						<option value="">There is no currently election</option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="form-group my-2">
				<input type="text" name="candidate_name" placeholder="Candidate Name" class="form-control" required>
			</div>
			<div class="form-group my-2">
				<input type="file" name="candidate_photo" class="form-control">
			</div>
			<div class="form-group my-2">
				<input type="text" name="candidate_details" placeholder="Candidate Details" class="form-control" required>
			</div>
			<input type="submit" value="Add Candidate" name="addCandidateBtn" class="btn btn-success">
		</form>
	</div>

	<div class="col-8">
		<h3>Candidate Details</h3>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">ID No.</th>
					<th scope="col">Photo</th>
					<th scope="col">Name</th>
					<th scope="col">Details</th>
					<th scope="col">Election</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$fetchData = mysqli_query($db, "SELECT * FROM candidate_details") or die(mysqli_error($db));
				$isAnyCandidateAdded = mysqli_num_rows($fetchData);

				if ($isAnyCandidateAdded > 0) {
					$sno = 1;
					while ($row = mysqli_fetch_assoc($fetchData)) {

						$election_id = $row['election_id'];
				        $fetchingElectionName = mysqli_query($db, "SELECT * FROM election WHERE id = '".$election_id."' ") or die(mysqli_error($db));
				        $exeFetchingElectionNameQuery = mysqli_fetch_assoc($fetchingElectionName);
				        $candidate_photo = $row['candidate_photo'];
				        if ($exeFetchingElectionNameQuery !== null) {
				            $election_name = $exeFetchingElectionNameQuery['election_topic'];
				        } else {
				            $election_name = "Unknown Election";
				        }
				?>
						<tr>
							<td><?php echo $sno++; ?></td>
							<td><img class="candidate_photo" src="<?php echo $row['candidate_photo']; ?>"></td>
							<td><?php echo $row['candidate_name']; ?></td>
							<td><?php echo $row['candidate_details']; ?></td>
							<td><?php echo $election_name; ?></td>
							<td>
								<button class="btn btn-sm btn-danger"
  										onclick="DeleteData(<?php echo $row['id']; ?>)" 
  									>Delete</button>
							</td>
						</tr>
					<?php
					}
				} else {
					?>
					<tr>
						<td colspan="7">There is no candidate yet.</td>
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
			location.assign("index.php?addCandidatePage=1&delete_id=" + e_id)
		}
	}
</script>

<?php
if (isset($_POST['addCandidateBtn'])) {
	$election_id = mysqli_real_escape_string($db, $_POST['election_id']);
	$candidate_name = mysqli_real_escape_string($db, $_POST['candidate_name']);
	$candidate_details = mysqli_real_escape_string($db, $_POST['candidate_details']);
	$inserted_by = $_SESSION['su_username'];
	$inserted_on = date("Y-m-d");

	$targeted_folder = "../assets/images/candidate_photos/";
	$candidate_photo = $targeted_folder . rand(111, 999) . "_" . rand(111, 999) . "_" . $_FILES['candidate_photo']['name'];
	$candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];
	$candidate_photo_type = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));
	$allowed_types = array("jpg", "png", "jpeg");

	$image_size = $_FILES['candidate_photo']['size'];

	if (in_array($candidate_photo_type, $allowed_types)) {
		if (move_uploaded_file($candidate_photo_tmp_name, $candidate_photo)) {
			mysqli_query($db, "INSERT INTO candidate_details 
					(election_id, candidate_name, candidate_photo, candidate_details, inserted_by, inserted_on) 
					VALUES 
					('" . $election_id . "', '" . $candidate_name . "', '" . $candidate_photo . "', '" . $candidate_details . "', '" . $inserted_by . "', '" . $inserted_on . "')") or die(mysqli_error($db));

			echo "<script>location.assign('index.php?addCandidatePage=1&added=1')</script>";
		} else {
			echo "<script>location.assign('index.php?addCandidatePage=1&failed=1')</script>";
		}
	} else {
		echo "<script>location.assign('index.php?addCandidatePage=1&invalidFile=1')</script>";
	}
?>

<?php

}
?>