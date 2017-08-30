<?php
include("header.php");
?>


<div id="page-wrapper">
	<div class="panel panel-body">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Courses</h1>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
				<div class="alert alert-success alert-dismissable" id="success_entry_courses">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<strong>Success!</strong> A new record has been added .
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
				<div class="alert alert-success alert-dismissable" id="success_entry_courses_edit">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<strong>Success!</strong> A new record has been added Edited .
				</div>
			</div>
			<div class="col-lg-12" style="margin-bottom:20px; ">
				<button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus fa-fw"></i> Add Courses</button>
			</div>

			<?php
			include("addnewcourse.php");
			?>

		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table table-responsive">
				<table id="showCourses" class="display" cellspacing="10" width="100%">  
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Code</th>
							<th>URL</th>
							<th>Image</th>
							<th>Description</th>
							<th>Date</th>
							<th>Edit</th>


						</tr>
					</thead>
					<tbody id="courses_data">  


					</tbody>  
				</table> 
			</div>
		</div>

		<?php
		include("editcourses.php");
		?>
	</div>
</div>
</div>

<script>
	$(document).ready(function(){

		//$('#showCourses').DataTable();

		// $('#showCourses').DataTable({
		// 	"aaSorting": [[ 0, "desc" ]]
		// });
		//$.fn.dataTableExt.sErrMode = 'throw';
		// $('#showCourses').DataTable({
		// 	"aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
		// 	"pageLength": 5,
		// 	"aaSorting": [[ 0, "desc" ]]
		// });


		$.fn.dataTableExt.sErrMode = 'throw';

		var base_url="<?php echo base_url();?>";
		showallcourses();


		$('#success_entry_courses').hide();
		$('#success_entry_courses_edit').hide();

		// $('#myModal').on('hidden.bs.modal', function () {
		// 	$(this).find('form').trigger('reset');
		// });

		$('#myModal')
		.on('hidden.bs.modal', function () {
			$('#course_new_form').bootstrapValidator('resetForm', true);
		});
		$('#editcourse_model')
		.on('hidden.bs.modal', function () {
			$('#editcourse_model').bootstrapValidator('resetForm', true);
		});

		function showallcourses()
		{
			
			$.ajax({

				url: '<?php echo site_url('Courses/GetAllCourses'); ?>',
				type: 'GET',
				dataType: 'json',
				success: function(data) 
				{	
					//console.log(data);	
					html = '';
					if(data!="")
					{						
						for(var i=0;i<data.length;i++)
						{
							//console.log(data[i]);
							html += "<tr>";
							html += "<td>"+data[i].course_id+"</td>";
							html += "<td>"+data[i].course_title+"</td>";
							html += "<td>"+data[i].course_url+"</td>";
							html += "<td>"+data[i].course_code+"</td>";
							html += "<td> <img src= "+base_url+data[i].course_image+" style='width:200px; height:100px;'></td>";
							html += "<td>"+data[i].course_desp+"</td>";
							html += "<td>"+data[i].date_created+"</td>";

							html += "<td style='text-align: center;'><a id="+data[i].course_id+"'<button class='btn btn-danger btn-sm edit-courses' data-toggle='modal' data-target='#editcourse_model'><i class ='fa fa-pencil'></i></button></a></td>";
							html += "</tr>";

						}

						$("#courses_data").html(html);
						$('#showCourses').DataTable( {
							"aLengthMenu": [[5, 10, 15, -1], [5, 10, 50, "All"]],
							"order": [[ 0, "desc" ]],
							"pageLength": 2
						} );
					}
				}
			});
		}

		$('#course_new_form').bootstrapValidator({
			excluded: ':disabled',
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			verbose: false,
			fields: {
				course_name: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},
						stringLength: {
							min: 2,
							max: 100,
							message: 'Name should be between 2 and 100 characters.',
						},
						regexp: {
							regexp: /^[a-zA-Z ]{2,100}$/,
							message: 'Invalid format.'
						}
					}
				},
				course_code: {
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
				course_url: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},
						stringLength: {
							min: 2,
							max: 100,
							message: 'Name should be between 2 and 100 characters.',
						},
						regexp: {
							regexp: /^[a-zA-Z ]{2,100}$/,
							message: 'Invalid format.'
						}
					}
				},
				course_description: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},
						stringLength: {
							min: 10,
							max: 1000,
							message: 'Description should not be less than 10 characters.',
						}
					}
				},
				course_image: {
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},
						file: {
							extension: 'jpeg,jpg,png',
							type: 'image/jpeg,image/png',
							maxSize: 2097152,  
							message: 'The selected file is not valid'
						}
					}
				},
			}

		}).on('success.form.bv', function(e) {

			e.preventDefault();		
			var formData = new FormData(this);					
			$.ajax({
				url: '<?php echo site_url('Courses/AddNewCourse'); ?>',
				type: 'POST',
				cache: false,
				contentType: false,
				processData: false,
				data:formData,					
				dataType: 'json',

				success: function(data) {
					showallcourses();	
					$('#myModal').modal('hide');	
					$('#success_entry_courses').show();
					if(data==true)
					{

						$('#success_entry_courses').html('<strong>Success</strong> A new record has been inserted');
					}
					else
					{
						$('#success_entry_courses').html('<strong>Error</strong> Cannot create new record');

					}
					$("#success_entry_courses").fadeTo(2000, 500).slideUp(500, function(){
						$("#success_entry_courses").slideUp(500);
					});

				}
			});

		});


		$('#editcourse_model').bootstrapValidator({
			excluded: ':disabled',
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			verbose: false,
			fields: {
				edit_course_name: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},
						stringLength: {
							min: 2,
							max: 100,
							message: 'Name should be between 2 and 100 characters.',
						},
						regexp: {
							regexp: /^[a-zA-Z ]{2,100}$/,
							message: 'Invalid format.'
						}
					}
				},
				edit_course_code: {
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
				edit_course_url: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},
						stringLength: {
							min: 2,
							max: 100,
							message: 'Name should be between 2 and 100 characters.',
						},
						regexp: {
							regexp: /^[a-zA-Z ]{2,100}$/,
							message: 'Invalid format.'
						}
					}
				},
				edit_course_description: {
					message: 'Invalid format.',
					validators: {
						notEmpty: {
							message: 'This field is required.'
						},
						stringLength: {
							min: 10,
							max: 1000,
							message: 'Description should not be less than 10 characters.',
						}
					}
				},
			}

		}).on('success.form.bv', function(e) {});

		$('#showCourses tbody').on('click', '.edit-courses',function(){
			var edit_id= $(this).attr("id");				
			$.ajax({
				url: '<?php echo site_url('Courses/SendEditCourseData'); ?>',
				type: 'POST',
				data: {
					value: edit_id
				},
				dataType: 'json',
				success: function(data) {							

					$("#edit_course_name").val(data[0].course_title);
					$("#edit_course_code").val(data[0].course_code);
					$("#edit_course_url").val(data[0].course_url);
					$("#edit_course_description").val(data[0].course_desp);
					$("#edit_id").val(data[0].course_id);
					$("#edit_image").attr("src",base_url+data[0].course_image);


				}
			});

		});

		$('#submit_editcourse').click(function(){


			var edit_key=$("#edit_id").val();
			var update_name =$("#edit_course_name").val();
			var update_code= $("#edit_course_code").val();
			var update_url= $("#edit_course_url").val();
			var update_desp= $("#edit_course_description").val();
			$.ajax({
				url: '<?php echo site_url('Courses/UpdateCourseDataonEdit'); ?>',
				type: 'POST',
				data: {
					value: edit_key,
					send_update_name:update_name,
					send_update_code:update_code,
					send_update_url:update_url,
					send_update_desp:update_desp

				},
				dataType: 'json',
				success: function(data) {					
					showallcourses();
					$('#editcourse_model').modal('hide');
					if(data==true)
					{
						$('#success_entry_courses_edit').html('<strong>Success</strong> A new record has been edited');

					}	
					else
					{
						$('#success_entry_courses_edit').html('<strong>Error</strong> There was an error editing the field');

					}
					$('#success_entry_courses_edit').show();
					$("#success_entry_courses_edit").fadeTo(2000, 500).slideUp(500, function(){
						$("#success_entry_courses_edit").slideUp(500);
					});
				}
			});

		});



	});

</script>



