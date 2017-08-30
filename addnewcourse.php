	<div id="myModal" class="modal fade" role="dialog">
		<div class="container">
			<div class="modal-dialog">

				<div class="modal-content">	
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Courses</h4>
					</div>
					<!-- 	<form role="form" id="course_new_form" class="form-horizontal formTop" enctype="multipart/form-data" method="POST" id="addnewCourse"> -->
					<?php echo form_open_multipart('',array('id' => 'course_new_form',
					'class'=>'form-horizontal formTop','role'=>'form'));?> 

					<div class="form-group">
						<label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2" for="course_name">  Name:</label>
						<div class=" col-xs-8 col-sm-8 col-sm-8 col-md-8 col-lg-8">
							<input type="text" class="form-control" id="course_name" name="course_name"  placeholder="Enter Course Name">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2" for="course_code">Code:</label>
						<div class="col-xs-8 col-sm-8 col-sm-8 col-md-8 col-lg-8"> 
							<input type="text" class="form-control" id="course_code" name="course_code" placeholder="Enter Course Code">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2" for="course_url"> URL:</label>
						<div class="col-xs-8 col-sm-8 col-sm-8 col-md-8 col-lg-8"> 
							<input type="text" class="form-control" id="course_url" name="course_url" placeholder="Enter Course Url">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2" for="course_image"> Image:</label>
						<div class="col-xs-8 col-sm-8 col-sm-8 col-md-8 col-lg-8"> 
							<input type="file" class="form-control" id="course_image" name="course_image" placeholder="Enter Course Url">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2" for="course_description"> Description:</label>
						<div class="col-xs-8 col-sm-8 col-sm-8 col-md-8 col-lg-8"> 
							<textarea rows="3" class="form-control" id="course_description" name="course_description" placeholder="Enter Course Url"> </textarea>
						</div>
					</div>

					<div class="modal-footer dialog-footer">
						<button type="submit" class="btn btn-default" id="submit_newcourse" name="submit_newcourse"><i class="fa fa-plus fa-fw"></i> Add</button>
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>