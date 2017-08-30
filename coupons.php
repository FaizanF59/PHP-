<?php
include("header.php");
?>


<div id="page-wrapper">

	<div class="panel panel-body">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Coupons</h1>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >

				<div class="alert alert-success alert-dismissable" id="success_entry">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<strong>Success!</strong> A new record has been added .
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >

				<div class="alert alert-success alert-dismissable" id="success_entry_edit">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<strong>Success!</strong> Record has been edited .
				</div>
			</div>

			<div class="col-lg-12" style="margin-bottom:20px; ">
				<button class="btn btn-primary" data-toggle="modal" data-target="#add_coupons_modal"><i class="fa fa-plus fa-fw"></i> Add Coupons</button>
			</div>
			
			<?php
			include("addnewcoupon.php");
			?>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table table-responsive">
				<table id="showCoupons" class="display" cellspacing="0" width="100%">  
					<thead>
						<tr>
							<th>Id</th>
							<th>Course Code</th>
							<th>CouponCode</th>
							<th>Active</th>
							<th>Amount</th>
							<th>Edit</th>

						</tr>
					</thead>
					<tbody id="coupon_data">  

					</tbody>  
				</table> 
			</div>
		</div>

		<?php
		include("editcoupons.php");
		?>
	</div>

</div>
</div>



<script>
	$(document).ready(function(){
		//$('#showCoupons').DataTable();
		$('.showCoupons').DataTable({
			"scrollY": 200,
			"paging": false,
			"bFilter": false,
			"ordering": false,
			"info": false,
			"sScrollX":true
		});

		get_all_data();
		$('#success_entry').hide();
		$('#success_entry_edit').hide();


		$('#add_coupons_modal').on('hidden.bs.modal', function () {
			$(this).find('form').trigger('reset');
		});

		$('#add_coupons_modal')
		.on('hidden.bs.modal', function () {
			$('#add_coupons_modal').bootstrapValidator('resetForm', true);
		});

		$('#edit_coupons_modal')
		.on('hidden.bs.modal', function () {
			$('#edit_coupons_modal').bootstrapValidator('resetForm', true);
		});

		function get_all_data(argument) {
			
			$.ajax({
				url: '<?php echo site_url('Coupons/GetAllCoupons'); ?>',
				type: 'GET',
				dataType: 'json',
				success: function(data) {									
					html = '';
					if(data!="")
					{						
						for(var i=0;i<data.length;i++)
						{
							//console.log(data[i]);
							html += "<tr>";
							html += "<td>"+data[i].cp_id+"</td>";
							html += "<td>"+data[i].c_id+"</td>";
							html += "<td>"+data[i].coupon_code+"</td>";
							html += "<td>"+data[i].is_active+"</td>";
							html += "<td>"+data[i].amount+"</td>";
							html += "<td style='text-align: center;'><a id="+data[i].cp_id+"'<button class='btn btn-danger btn-sm edit-coupons' data-toggle='modal' data-target='#edit_coupons_modal'><i class ='fa fa-pencil'></i></button></a></td>";
							html += "</tr>";

						}
						$("#coupon_data").html(html);
						$('#showCoupons').DataTable();

					}
				}
			});
		}


		$('#add_coupons_modal').bootstrapValidator({
			excluded: ':disabled',
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			verbose: false,
			fields: {
				course_id: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},
						stringLength: {
							min: 2,
							max: 100,
							message: 'Only characters and numbers are allowed.',
						},
						regexp: {
							regexp: /^[a-zA-Z0-9_.-]*$/,
							message: 'Invalid format.'
						},
						remote: {
							headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
							type: 'POST',
							url: 'Coupons/isCourseIdAvaliabe',
							message: 'The Course Id is not Avaliable.'
						}
					}
				},
				coupon_code: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},
						stringLength: {
							min: 2,
							message: 'Course code should be minimum 2 characters.',
						},
						remote: {
							headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
							type: 'POST',
							url: 'Coupons/checkCouponCode',
							message: 'This Coupon Code has already been Entered.'
						}
					}
				},
				amount: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},								
						regexp: {
							regexp: /^[ 0-9%]*$/,
							message: 'Invalid format.'
						}
					}
				},
				is_coupon_active: {
					message: 'This field is required..',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},

					}
				},										

			}

		}).on('success.form.bv', function(e) {
			e.preventDefault();

			var course_key=$("#course_id").val();
			var is_coupon_valid= $('input[name=is_coupon_active]:checked').val();
			var coupon_code =$("#coupon_code").val();			
			var amount= $("#amount").val();
			$.ajax({
				url: '<?php echo site_url('Coupons/AddNewCoupon'); ?>',
				type: 'POST',
				data: {
					course_key: course_key,
					coupon_code:coupon_code,
					is_coupon_valid:is_coupon_valid,
					amount:amount
				},
				dataType: 'json',
				success: function(data) {
					get_all_data();	
					$('#add_coupons_modal').modal('hide');
					if(data==true)
					{
						$('#success_entry').html('<strong>Success</strong> A new record has been inserted');

					}	
					else
					{
						$('#success_entry').html('<strong>Error</strong> Cannot create new record');

					}
					$('#success_entry').show();
					$("#success_entry").fadeTo(2000, 500).slideUp(500, function(){
						$("#success_entry").slideUp(500);
					});

				}
			});
		});


		$('#showCoupons tbody').on('click', '.edit-coupons',function(){

			var edit_id= $(this).attr("id");	
			//alert(edit_id);
			$.ajax({
				url: '<?php echo site_url('Coupons/EditCouponData'); ?>',
				type: 'POST',
				data: {
					value: edit_id
				},
				dataType: 'json',
				success: function(data) {

					$("#edit_course_id").val(data[0].c_id);
					$("#edit_coupon_code").val(data[0].coupon_code);
					$("#edit_amount").val(data[0].amount);
					$("#key_value").val(data[0].cp_id);

					var value_of_status= data[0].is_active;					
					if(value_of_status=='Yes')
					{
						$("#edit_yes_active").prop("checked", true);
					}
					else
					{
						$("#edit_no_active").prop("checked", true);

					}
				}
			});
		});

		$('#edit_coupons_modal').bootstrapValidator({
			excluded: ':disabled',
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			verbose: false,
			fields: {
				edit_course_id: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},
						stringLength: {
							min: 2,
							max: 100,
							message: 'Only characters and numbers are allowed.',
						},
						regexp: {
							regexp: /^[a-zA-Z0-9_.-]*$/,
							message: 'Invalid format.'
						},
						remote: {
							headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
							type: 'POST',
							url: 'Coupons/isEditCourseIdAvaliabe',
							message: 'This Course Id is not Avaliable.'
						}
					}
				},
				edit_coupon_code: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},
						stringLength: {
							min: 2,
							message: 'Course code should be minimum 2 characters.',
						}
					}
				},
				edit_amount: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},								
						regexp: {
							regexp: /^[ 0-9%]*$/,
							message: 'Invalid format.'
						}
					}
				},
				edit_is_coupon_active: {
					message: 'This field is required..',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},

					}
				},										

			}

		}).on('success.form.bv', function(e) {
			e.preventDefault();

			var edit_coupon_key=$("#key_value").val();
			var edit_course_key=$("#edit_course_id").val();
			var edit_is_coupon_valid= $('input[name=edit_is_coupon_active]:checked').val();
			var edit_coupon_code =$("#edit_coupon_code").val();			
			var edit_amount= $("#edit_amount").val();
			$.ajax({
				url: '<?php echo site_url('Coupons/EditCouponDataDetails'); ?>',
				type: 'POST',
				data: {
					edit_course_key: edit_course_key,
					edit_coupon_code:edit_coupon_code,
					edit_is_coupon_valid:edit_is_coupon_valid,
					edit_amount:edit_amount,
					edit_key:edit_coupon_key
				},
				dataType: 'json',
				success: function(data) {
					$('#edit_coupons_modal').modal('hide');			
					get_all_data();	
					if(data==true)
					{
						$('#success_entry').html('<strong>Success</strong> Record has been edited');
					}	
					else
					{
						$('#success_entry').html('<strong>Error</strong> Cannot edit  record');
					}
					$('#success_entry_edit').show();
					$("#success_entry_edit").fadeTo(2000, 500).slideUp(500, function(){
						$("#success_entry_edit").slideUp(500);
					});
				}
			});
		});


	});

</script>



