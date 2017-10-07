<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Coupons extends CI_Controller {  

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('DatabaseQueries');
		if(!$this->session->userdata('username') && !$this->session->userdata('password'))
		{

			redirect('Login');


		}else{

			
		}
	}
	
	public function index() {

		$coupon_all['coupons_data']=$this->DatabaseQueries->ShowAllCoupons();
		$data=$this->DatabaseQueries->ShowAllCourses();
		//echo "<pre>";
		//print_r($data);
		$sizeCourses= sizeof($data);
		for ($i=0; $i <$sizeCourses ; $i++) 
		{ 
			$course_code_array[]=$data[$i]->course_code;
			$course_name_array[]=$data[$i]->course_title;

		}	
		$showCourseCode=array(

			'codeCourse'=>$course_code_array,
			'nameCourse'=>$course_name_array

			);
		//print_r($showCourseCode);
		$this->session->set_userdata($showCourseCode);
		$this->load->view('coupons',$coupon_all);
	} 

	public function GetAllCoupons()
	{

		$coupon_all=$this->DatabaseQueries->ShowAllCoupons();
		echo json_encode($coupon_all);
		//print_r($coupon_all);

	}

	public function AddNewCoupon()
	{
		$course_id=$this->input->post('course_key');
		$course_name=$this->DatabaseQueries->getCourseName($course_id);
		//print_r($course_name);
		$course_name= $course_name[0]->course_title;
		//$course_name
		//exit();

		$insert_coupon = array(
			'c_id' => $this->input->post('course_key'),
			'coupon_code' => $this->input->post('coupon_code'),
			'is_active' => $this->input->post('is_coupon_valid'),
			'course_name'=>$course_name	
			);

		$value=$this->DatabaseQueries->AddNewCoupons($insert_coupon);
		echo $value;
		
	}

	public function EditCouponData()
	{
		$key=$this->input->post('value');
		$edit_data=$this->DatabaseQueries->ShowEditCouponsData($key);
		$data=$this->DatabaseQueries->ShowAllCourses();
		//echo "<pre>";
		//print_r($data);
		$sizeCourses= sizeof($data);
		for ($i=0; $i <$sizeCourses ; $i++) 
		{ 
			$course_code_array[]=$data[$i]->course_code;
			$course_name_array[]=$data[$i]->course_title;

		}	
		$showCourseCode=array(

			'codeCourse'=>$course_code_array,
			'nameCourse'=>$course_name_array

			);
		//print_r($showCourseCode);
		$this->session->set_userdata($showCourseCode);

		echo json_encode($edit_data);
	}
	public function EditCouponDataDetails()
	{
		$edit_key=$this->input->post('edit_key');
		$id =$this->input->post('edit_course_key');
		$course_name=$this->DatabaseQueries->getCourseName($id);
		$course_name= $course_name[0]->course_title;

		$edit_coupon_details = array(			
			'c_id' => $this->input->post('edit_course_key'),
			'coupon_code' => $this->input->post('edit_coupon_code'),
			'is_active' => $this->input->post('edit_is_coupon_valid'),
			'course_name'=>$course_name	
			);
		//print_r($edit_coupon);
		$edit_return_data=$this->DatabaseQueries->UpdateCouponDetails($edit_coupon_details,$edit_key);
		echo json_encode($edit_return_data);
	}
	public function checkCouponCode()
	{
		$couponcode=$this->input->post('coupon_code');
		//echo $couponcode;
		$is_Present=$this->DatabaseQueries->isAvaliableCouponCode($couponcode);
		//print_r($is_Present);
		if(empty($is_Present))
		{
			$isAvailable = TRUE;
		}
		else
		{
			$isAvailable = FALSE;

		}
		echo json_encode(
			array(
				'valid' => $isAvailable
				)
			);

	}

	public function EditcheckCouponCode()
	{
		$couponcode=$this->input->post('edit_coupon_code');
		$is_Present=$this->DatabaseQueries->EditisAvaliableCouponCode($couponcode);
		if(empty($is_Present))
		{
			$isAvailable = TRUE;
		}
		else
		{
			$isAvailable = FALSE;

		}
		echo json_encode(
			array(
				'valid' => $isAvailable
				)
			);

	}
	public function isCourseIdAvaliabe()
	{
		$course_id=$this->input->post('course_id');
		$is_Present=$this->DatabaseQueries->isAvaliableCourseCode($course_id);
		if(empty($is_Present))
		{
			$isAvailable = FALSE;
		}
		else
		{
			$isAvailable = TRUE;
		}
		echo json_encode(
			array(
				'valid' => $isAvailable
				)
			);	
	}
	public function isEditCourseIdAvaliabe()
	{
		$course_id=$this->input->post('edit_course_id');
		$is_Present=$this->DatabaseQueries->isAvaliableCourseCode($course_id);
		if(empty($is_Present))
		{
			$isAvailable = FALSE;
		}
		else
		{
			$isAvailable = TRUE;

		}
		echo json_encode(
			array(
				'valid' => $isAvailable
				)
			);	
	}
	public function deleteCoupon()
	{
		$id=$this->input->post("id");
		$response=$this->DatabaseQueries->deleteCouponDatabase($id);
		echo json_encode($response);

	}

} 
?>	