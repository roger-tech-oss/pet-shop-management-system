<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php if($_settings->chk_flashdata('error')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('error') ?>",'error')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Delivery Partners</h3>
		<!-- <div class="card-tools">
			<a href="?page=order/manage_order" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div> -->
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="10%">
					<col width="20%">
					<col width="30%">
					<col width="20%">
					<col width="20%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Partner Code</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT concat(`first_name`, ' ',`last_name`) as `name`, `email`, `phone`, `id`, `partner_code` FROM `delivery_partners` order by `name` asc");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['name'] ?></td>
							<td><?php echo $row['email'] ?></td>
							<td class="text-right"><?php echo $row['phone'] ?></td>
							<td><?php echo $row['partner_code'] ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		
		$('.table').dataTable();
	})
	
	function delete_order($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_order",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>