<div class="row my-3">
	<div class="col-12">
		<h3>Elections</h3>
		<table class="table">
  			<thead>
    			<tr>
      				<th scope="col">ID No.</th>
      				<th scope="col">Election Name</th>
      				<th scope="col"># Candidates</th>
      				<th scope="col">Starting On</th>
      				<th scope="col">Ending On</th>
      				<th scope="col">Status</th>
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
  							$election_id = $row['id']

  						?>
  							<tr>
  								<td><?php echo $sno++; ?></td>
  								<td><?php echo $row['election_topic']; ?></td>
  								<td><?php echo $row['no_of_candidates']; ?></td>
  								<td><?php echo $row['starting_date']; ?></td>
  								<td><?php echo $row['ending_date']; ?></td>
  								<td><?php echo $row['status']; ?></td>
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