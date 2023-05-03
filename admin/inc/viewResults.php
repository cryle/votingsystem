<?php
	require_once("inc/header.php");
	require_once("inc/navigation.php");
?>

	<div class="row my-3">
		<div class="col-12">
			<h3>Election Results</h3>
			<?php
				$fetchingActiveElections = mysqli_query($db, "SELECT * FROM election WHERE status = 'Active'") or die(mysqli_error($db));
				$totalActiveElections = mysqli_num_rows($fetchingActiveElections);

				if($totalActiveElections > 0)
				{
					while($data = mysqli_fetch_assoc($fetchingActiveElections)) {
						$election_id = $data['id'];
						$election_topic = $data['election_topic'];
					?>
						<table class="table">
							<thead>
								<tr class="bg-green">
									<th colspan="4" class="text-white"><h5>ELECTION NAME: <?php echo strtoupper($election_topic); ?></h5></th>
								</tr>
								<tr>
									<th>Photo</th>
									<th>Candidate Details</th>
									<th>Number of Votes</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$fetchingCandidates = mysqli_query($db, "SELECT * FROM candidate_details WHERE election_id = '".$election_id."'") or die(mysqli_error($db));

									while($candidateData = mysqli_fetch_assoc($fetchingCandidates))
									{	
										$candidate_id = $candidateData['id'];
										$candidate_photo = $candidateData['candidate_photo'];

										$fetchingVotes = mysqli_query($db, "SELECT * FROM votings WHERE candidate_id = '".$candidate_id."' ") or die(mysqli_error($db));
										$totalVotes = mysqli_num_rows($fetchingVotes);


									?>
										<tr>
											<td><img class="candidate_photo" src="<?php echo $candidate_photo; ?>"></td>
											<td><?php echo "<b>" . $candidateData['candidate_name'] . "</b><br />" . $candidateData['candidate_details']; ?></td>
											<td><?php echo $totalVotes; ?></td>

										</tr>
									<?php
									}
								?>
							</tbody>
						</table>
					<?php
					}
				} else {
					echo "There is currently no election";
				}
			?>
		</div>
	</div>

<?php
	require_once("inc/footer.php");
?>