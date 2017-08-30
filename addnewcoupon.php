<div id="add_coupons_modal" class="modal fade" role="dialog">
	<div class="container">
		<div class="modal-dialog">

			<div class="modal-content">	
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Coupons</h4>
				</div>

				<?php echo form_open('',array('class'=>'form-horizontal formTop','role'=>'form','id'=>'add_new_coupons'));?> 

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">						
					<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-3" for="course_id"> Course Id:
					</label>
					<div class=" col-lg-9 col-md-9 col-sm-9 col-xs-9">
						<?php echo form_input(['type'  => 'text','name'=> 'course_id','id'=> 'course_id', 'class' => 'form-control','placeholder' => 'Enter course Id']);
						?>
					</div>
				</div>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">					
					<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-3" for="coupon_code"> Coupon Code:
					</label>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 "> 
						<?php echo form_input(['type' =>'text','name' =>'coupon_code','id'=> 'coupon_code','class' => 'form-control','placeholder' => 'Enter Coupon Code']);?>
					</div>
				</div>		

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
					<label class="control-label col-lg-3 col-md-3 col-sm-3  col-xs-3  " for="is_coupon_active"> Coupon Active:</label>
					<div class="radio col-lg-7 col-md-7 col-sm-7 col-xs-7"> 
						<label class="radio-inline padding-4-top-height"> 
							<?php echo form_input(['type' =>'radio','name' =>'is_coupon_active','id'    => 'yes_active','value' => 'Yes']);?> Yes

						</label>
						<label class="radio-inline padding-4-top-height"> 
							<?php echo form_input(['type' => 'radio','name' => 'is_coupon_active','id'    => 'no_active','value' =>'No']);?> No
						</label>
					</div>
				</div>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-3" for="amount"> Amount:</label>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"> 
						<?php echo form_input(['type' => 'text','name' => 'amount','id'=> 'amount', 'class' => 'form-control','placeholder' => 'Enter amount']);?>
					</div>
				</div>	


			<!-- 	<div class="form-group"> 
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default" id="submit_newcoupon" name="submit_newcoupon">Submit</button>
					</div>
				</div> -->
				<div class="modal-footer dialog-footer">
				<button type="submit" class="btn btn-default" id="submit_newcoupon" name="submit_newcoupon"><i class="fa fa-plus fa-fw"></i>Add</button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>