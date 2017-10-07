
<?php 

class DatabaseQueries extends CI_Model 
{
	public function ShowAllCourses()

	{		
		$query = $this->db->query("SELECT * FROM courses ");
		return $query->result(); 
	}

	public function InsertCourses($data)
	{
		$this->db->insert('courses', $data);
		return $this->db->affected_rows() > 0;
	}

	public function DisplayEditCourseData($edit_key)
	{
		$query = $this->db->get_where('courses', array('course_id' => $edit_key));
		return $query->result();
	}

	public function UpdateCourseData($edit_id,$update_data)
	{



		$query=$this->db->where('course_id',$edit_id)
		->update('courses',$update_data);
		return $this->db->affected_rows() > 0;
		

		
	}
	public function AddNewCoupons ($new_coupons)
	{
		if($this->db->insert('coupons', $new_coupons))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function ShowAllCoupons()
	{
		$query = $this->db->query("SELECT * FROM coupons");
		return $query->result(); 
	}

	public function ShowEditCouponsData($key)
	{
		$query = $this->db->get_where('coupons', array('cp_id' => $key));
		return $query->result();
	}
	public function UpdateCouponDetails($edit_coupon_details,$edit_key)
	{
		$this->db->where('cp_id',$edit_key)
		->update('coupons',$edit_coupon_details);
		return $this->db->affected_rows() > 0;
	}

	public function Is_Login_Valid($username,$password)
	{
		$sql = "SELECT * FROM admin_login WHERE username = ? AND password = ?";
		$query=$this->db->query($sql, array($username, $password));
		return $query->result_array();
	}

	

	public function AddGoogleSecret($update_secret,$id_user)
	{
		$this->db->where('id', $id_user)
		->update('admin_login', $update_secret); 
		return $this->db->affected_rows() > 0;
	}

	public function IsCodeScanned($name,$password)
	{
		$query = $this->db->get_where('admin_login', array('username' => $name,'password'=>$password));
		return $query->result_array();
	}

	public function UpdateCodeScanned($name,$password,$data_update)
	{
		$this->db->where('username', $name,'password', $password)
		

		->update('admin_login', $data_update); 
		return $this->db->affected_rows() > 0;
	}
	public function CheckValidCode($code)
	{
		$query=$this->db->get_where('courses', array('course_code' => $code));
		return $query->result(); 

	}

	public function InsertNewOrder($insert_order)
	{
		$this->db->insert('orders',$insert_order);
		return $this->db->affected_rows() > 0;	
	}

	public function ShowAllOrders()
	{
		$query = $this->db->query("SELECT * FROM orders");
		return $query->result(); 
	}

	public function getCouponcode($course_code)
	{
		$active="Yes";
		$sql = "SELECT * FROM coupons WHERE c_id = ? AND is_active=? ";
		$query=$this->db->query($sql, array($course_code,$active));
		return $query->result_array();
	}
	public function isAvaliableCouponCode($couponcode)
	{
		$sql = "SELECT coupon_code FROM coupons WHERE coupon_code = ?";
		$query=$this->db->query($sql, array($couponcode ));
		return $query->result_array();
	}
	public function getUrl($course_code)
	{
		
		$sql = "SELECT course_url,course_image FROM courses WHERE course_code= ?";
		$query=$this->db->query($sql, array($course_code));
		return $query->result_array();
	}
	public function EditisAvaliableCouponCode($edit_coupon_code)
	{
		$sql = "SELECT coupon_code FROM coupons WHERE coupon_code = ?";
		$query=$this->db->query($sql, array($edit_coupon_code ));
		return $query->result_array();
	}
	public function isAvaliableCourseCode($course_id)
	{
		$sql = "SELECT course_code FROM courses WHERE course_code = ?";
		$query=$this->db->query($sql, array($course_id ));
		return $query->result_array();
	}

	public function checkActiveCoupons()
	{
		$activeCoupon="Yes";
		$query = $this->db->get_where('coupons', array('is_active' => $activeCoupon));
		return $query->result();
	}

	public function checkDeActiveCoupons()
	{
		$activeCoupon="No";
		$query = $this->db->get_where('coupons', array('is_active' => $activeCoupon));
		return $query->result();
	}
	public function makeCouponInactive($coupon_code)
	{
		$value="No";
		$this->db->set('is_active', $value);  
		$this->db->where('c_id', $coupon_code);  
		$this->db->update('coupons'); 
	}

	public function deleteCourseDatabase($id)
	{
		$this->db->where('course_id', $id)
		->delete('courses');
		return $this->db->affected_rows() > 0;	

	}

	public function deleteCouponDatabase($id)
	{
		$this->db->where('cp_id', $id)
		->delete('coupons');
		return $this->db->affected_rows() > 0;	

	}

	public function getCourseName($course_id)
	{
		$sql = "SELECT course_title FROM courses WHERE course_code = ?";
		$query=$this->db->query($sql, array($course_id ));
		return $query->result();
	}
	public function getTotalPurchase($startDate,$endDate)
	{
		$this->db->select('*')
		->where('date_order >=', $startDate)
		->where('date_order <=', $endDate);
		$query=$this->db->get('orders');
		return $query->result();
	}
	public  function updatePasswordAndUsername($username,$oldpassword,$newpassword)
	{
		$id=1;
		if($this->db->query("UPDATE admin_login SET password='$newpassword' WHERE ID='$id' AND username='$username'"))
		{
			return true;
		}	
		else
		{
			return false;
		}

		
	}
	public function checkEnteredPassword($password)
	{
		//echo $password;
		$query = $this->db->get_where('admin_login', array('password' => $password));
		return $query->result();
	}

	public function checkEnteredUsername($username)
	{
		//echo $password;
		$query = $this->db->get_where('admin_login', array('username' => $username));
		return $query->result();
	}



}