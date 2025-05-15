<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Students extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->library('session');
		$this->load->library('upload');
		/*cache control*/
		//$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		//$this->output->set_header('Pragma: no-cache');

		$this->user_model->check_session_data('admin');
	}


	function index()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('students');

		$page_data['page_name'] = "students/create";
		/* $school_result = $this->school_model->get();
		$page_data['schoollist'] = $school_result; */
		$state = $this->crud_model->getstate();
		$page_data['statelist'] = $state;
		$school = $this->school_model->get();
		$page_data['schoollist'] = $school;
		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$religionList = $this->customlib->getReligion();
		$page_data['religionList'] = $religionList;
		$maritalStatus = $this->customlib->getMaritalStatus();
		$page_data['maritalStatus'] = $maritalStatus;
		$page_data['page_title'] = site_phrase('students');
		$this->load->view('admin/index',  $page_data);
	}

	function search()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}

		// CHECK ACCESS PERMISSION
		check_permission('students');
		$page_data['page_name'] = "students/search";
		$school = $this->school_model->get();
		$page_data['schoollist'] = $school;
		$department_result = $this->department_model->get();
		$page_data['departmentlist'] = $department_result;
		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$page_data['page_title'] = site_phrase('students');
		$this->load->view('admin/index',  $page_data);
	}
	public function search_ajax()
	{

		$department = $this->input->post('department_id');
		$course = $this->input->post('course_id');
		$class = $this->input->post('class_id');
		$search_text = $this->input->post('search_text');
		$this->data['searchby'] = "filter";
		$this->data['department_id'] = $department;
		$this->data['course_id'] = $course;
		$this->data['class_id'] = $class;
		$this->data['result'] = $this->student_model->searchByDepartmentCourseClass($department, $course, $class);
		$ret['render'] = $this->load->view('admin/students/search_ajax', $this->data, true);
		$ret['status'] = true;
		echo json_encode($ret);
		exit;
	}
	function reg_students()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}

		// CHECK ACCESS PERMISSION
		check_permission('students');
		$page_data['page_name'] = "students/reg_student_search";
		$school = $this->school_model->get();
		$page_data['schoollist'] = $school;
		$department_result = $this->department_model->get();
		$page_data['departmentlist'] = $department_result;
		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$page_data['page_title'] = site_phrase('students');
		$this->load->view('admin/index',  $page_data);
	}
	public function reg_student_search_ajax()
	{

		$department = $this->input->post('department_id');
		$course = $this->input->post('course_id');
		$class = $this->input->post('class_id');
		$search_text = $this->input->post('search_text');
		$this->data['searchby'] = "filter";
		$this->data['department_id'] = $department;
		$this->data['course_id'] = $course;
		$this->data['class_id'] = $class;
		$this->data['result'] = $this->student_model->searchRegStudentByDepartmentCourseClass($department, $course, $class);
		$ret['render'] = $this->load->view('admin/students/reg_student_search_ajax', $this->data, true);
		$ret['status'] = true;
		echo json_encode($ret);
		exit;
	}
	function adm_students()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}

		// CHECK ACCESS PERMISSION
		check_permission('students');
		$page_data['page_name'] = "students/adm_student_search";
		$school = $this->school_model->get();
		$page_data['schoollist'] = $school;
		$department_result = $this->department_model->get();
		$page_data['departmentlist'] = $department_result;

		$page_data['page_title'] = site_phrase('students');
		$this->load->view('admin/index',  $page_data);
	}
	public function adm_student_search_ajax()
	{

		$department = $this->input->post('department_id');
		$course = $this->input->post('course_id');

		$search_text = $this->input->post('search_text');
		$this->data['searchby'] = "filter";
		$this->data['department_id'] = $department;
		$this->data['course_id'] = $course;

		$this->data['result'] = $this->student_model->searchAdmStudent($department, $course);
		$ret['render'] = $this->load->view('admin/students/adm_student_search_ajax', $this->data, true);
		$ret['status'] = true;
		echo json_encode($ret);
		exit;
	}
	public function searchText_ajax()
	{

		$search_text = $this->input->post('search_text');
		$this->data['searchby'] = "filter";
		$this->data['result'] = $this->student_model->searchFullText($search_text);
		$ret['render'] = $this->load->view('admin/students/search_ajax', $this->data, true);
		$ret['status'] = true;
		echo json_encode($ret);
		exit;
	}
	public function reg_student_searchText_ajax()
	{

		$search_text = $this->input->post('search_text');
		$this->data['searchby'] = "filter";
		$this->data['result'] = $this->student_model->reg_student_searchFullText($search_text);
		$ret['render'] = $this->load->view('admin/students/reg_student_search_ajax', $this->data, true);
		$ret['status'] = true;
		echo json_encode($ret);
		exit;
	}
	public function adm_student_searchText_ajax()
	{

		$search_text = $this->input->post('search_text');
		$this->data['searchby'] = "filter";
		$this->data['result'] = $this->student_model->adm_student_searchFullText($search_text);
		$ret['render'] = $this->load->view('admin/students/adm_student_search_ajax', $this->data, true);
		$ret['status'] = true;
		echo json_encode($ret);
		exit;
	}
	function create()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('students');

		$page_data['page_name'] = "students/create";
		$department_result = $this->department_model->get();
		$page_data['departmentlist'] = $department_result;
		$state = $this->crud_model->getstate();
		$page_data['statelist'] = $state;
		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$religionList = $this->customlib->getReligion();
		$page_data['religionList'] = $religionList;
		$maritalStatus = $this->customlib->getMaritalStatus();
		$page_data['maritalStatus'] = $maritalStatus;
		$page_data['page_title'] = site_phrase('students');
		$this->load->view('admin/index',  $page_data);
	}

	function bulk()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('students');
		$page_data['page_name'] = "students/bulk";
		$department_result = $this->department_model->get();
		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$page_data['departmentlist'] = $department_result;
		$page_data['page_title'] = 'Bulk';
		$this->load->view('admin/index',  $page_data);
	}

	function add_bulk_users()
	{
		$response = $this->student_model->bulk_student_create();
		echo json_encode($response);
	}

	function add_excel()
	{
		$response = $this->student_model->excel_create();
		echo json_encode($response);
	}

	function exportformat()
	{
		$this->load->helper('download');
		$filepath = "./assets/import/import_student_sample_file.csv";
		$data = file_get_contents($filepath);
		$name = 'import_student_sample_file.csv';

		force_download($name, $data);
	}
	function import()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('students');

		$page_data['page_name'] = "students/bulk";

		$session = $this->setting_model->getCurrentSession();
		$class = $this->class_model->get();
		$data['classlist'] = $class;
		$userdata = $this->customlib->getUserData();
		$sch_id = $userdata['school_id'];
		$admin_id = $userdata['role_id'];
		$data['admin_id'] = $admin_id;
		if ($admin_id == 2) {
			$school = $this->school_model->get($sch_id);
		} else {
			$school = $this->school_model->get();
		}
		$data['schoollist'] = $school;

		//$category = $this->category_model->get();


		$fields = array('reg_no', 'jamb_no', 'firstname', 'lastname', 'middlename', 'gender', 'state', 'mobileno');


		$data["fields"] = $fields;
		// $data['categorylist'] = $category;
		$this->form_validation->set_rules('school_id', 'School', 'trim|required|xss_clean');
		$this->form_validation->set_rules('course_id', 'Course', 'trim|required|xss_clean');
		$this->form_validation->set_rules('class_id', 'Level', 'trim|required|xss_clean');

		$this->form_validation->set_rules('file', 'File');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('layout/header', $data);
			$this->load->view('admin/student/import', $data);
			$this->load->view('layout/footer', $data);
		} else {


			$setting_result = $this->setting_model->get();
			// $student_categorize = $setting_result[0]["student_categorize"];

			$school_id = $this->input->post('school_id');
			$course_id = $this->input->post('course_id');
			$class_id = $this->input->post('class_id');


			$session = $this->setting_model->getCurrentSession();
			if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
				$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				if ($ext == 'csv') {
					$file = $_FILES['file']['tmp_name'];
					$this->load->library('CSVReader');
					$result = $this->csvreader->parse_file($file);
					if (!empty($result)) {
						$rowcount = 0;
						for ($i = 1; $i <= count($result); $i++) {

							$student_data[$i] = array();
							$n = 0;
							foreach ($result[$i] as $key => $value) {

								$student_data[$i][$fields[$n]] = $this->encoding_lib->toUTF8($result[$i][$key]);
								$student_data[$i]['course_id'] = $course_id;
								$student_data[$i]['school_id'] = $school_id;
								$student_data[$i]['is_active'] = 'yes';

								$n++;
							}


							$adm_no = $student_data[$i]["reg_no"];
							$state = $student_data[$i]["state"];

							if ($state == 'Bauchi' || $state == 'BAUCHI' || $state == 'bauchi') {
								$indigene = 'Indigene';
							} else {
								$indigene = 'Non-Indigene';
							};

							if ($this->form_validation->is_unique($adm_no, 'students.reg_no')) {

								if (!empty($roll_no)) {

									if ($this->student_model->check_rollno_exists($adm_no, 0, $class_id)) {

										$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Record already exists.</div>');
										$insert_id = "";
									} else {

										$insert_id = $this->student_model->addForStaff($student_data[$i]);
									}
								} else {
									$insert_id = $this->student_model->addForStaff($student_data[$i]);
								}
							} else {
								$insert_id = "";
							}


							if (!empty($insert_id)) {
								$data = array(
									'id' => $insert_id,
									'student_type' => $indigene
								);
								$this->student_model->add($data);
								$data_new = array(
									'student_id' => $insert_id,
									'class_id' => $class_id,
									'session_id' => $session,
									// 'semester_id' => $semester
								);
								$this->student_model->add_student_session($data_new);

								$user_password = 'password';
								//$this->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
								$data_student_login = array(
									'username' => $adm_no,
									'password' => $user_password,
									'user_id' => $insert_id,
									'role' => 'student'
								);
								$this->user_model->add($data_student_login);
								//$sender_details = array('student_id' => $insert_id, 'contact_no' => $mobile_no, 'email' => $email);
								//$this->mailsmsconf->mailsms('student_admission', $sender_details);
								//$student_login_detail = array('id' => $insert_id, 'credential_for' => 'student', 'username' => $adm_no, 'password' => $user_password, 'contact_no' => $mobile_no, 'email' => $email);
								//$this->mailsmsconf->mailsms('login_credential', $student_login_detail);
								$data['csvData'] = $result;
								$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="Students imported successfully." data-type="success"></div>');
								$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Students imported successfully</div>');
								$rowcount++;

								$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Total ' . count($result) . " records found in CSV file. Total " . $rowcount . ' records imported successfully.</div>');
							} else {
								$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Records already exists.." data-type="danger"></div>');
								$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Records already exists.</div>');
							}
						}
					} else {
						$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="No Data was found." data-type="danger"></div>');
						$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">No Data was found.</div>');
					}
				} else {
					$this->session->set_flashdata('toast', '<div class="toast" data-title="Warning! "data-message="Please upload CSV file only." data-type="warning"></div>');
					$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Please upload CSV file only.</div>');
				}
			}
			redirect('admin/student/import');
		}
	}

	function view($id)
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('students');

		$page_data['page_name'] = "students/show";

		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$student = $this->student_model->get($id);
		$page_data['student'] = $student;
		//$paymentStatus = $this->customlib->getpaymentStatus();
		//$data['paymentStatus'] = $paymentStatus;
		$student = $this->student_model->get($id);
		$login = $this->user_model->getStudentLoginDetails($id);
		$page_data['username'] = $login->username;
		$page_data['password'] = $student['open_p'];
		$fee = $this->payment_model->getStudentFees($id);
		$page_data['fee'] = $fee;
		$student_total = $this->payment_model->gettotal($student['class_id'], $student['school_id'], $student['student_type']);
		$page_data['student_total'] = $student_total;
		$page_data['deposit'] = $this->payment_model->getSum($id, $student['class_id']);

		$payment = $this->payment_model->getSemesterAmount($student['class_id'], $student['school_id'], $student['student_type']);
		$amount = $payment->amount;
		$paid = $this->payment_model->getSum($id, $student['class_id']);
		$balance = $amount - $paid->amount;
		$page_data['balance'] = $balance;
		$page_data['amount'] = $amount;
		$page_data['student'] = $student;
		$page_data['page_title'] = site_phrase('students');
		$this->load->view('admin/index',  $page_data);
	}

	function edit($id)
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('students');

		$page_data['page_name'] = "students/edit";

		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$department_result = $this->department_model->get();
		$page_data['departmentlist'] = $department_result;
		$state = $this->crud_model->getstate();
		$page_data['statelist'] = $state;
		$religionList = $this->customlib->getReligion();
		$page_data['religionList'] = $religionList;
		$maritalStatus = $this->customlib->getMaritalStatus();
		$page_data['maritalStatus'] = $maritalStatus;
		$student = $this->student_model->get($id);
		$page_data['id'] = $id;
		$page_data['student'] = $student;
		$page_data['page_title'] = site_phrase('edit_student_profile');
		$this->load->view('admin/index',  $page_data);
	}

	function add()
	{
		$response = $this->student_model->add_details();
		echo json_encode($response);
	}

	function update()
	{
		$response = $this->student_model->update_details();
		echo json_encode($response);
	}

	function getByLocal()
	{
		$state_id = $this->input->get('state_id');
		$data = $this->crud_model->getStateByLocal($state_id);
		echo json_encode($data);
	}
	public function form_PDF($stylesheet = NULL, $data = NULL, $viewpath = NULL, $course_id = NULL, $class_id = NULL, $mode = 'view', $pagesize = 'a4', $pagetype = 'portrait')
	{
		$this->data['panel_title'] = 'Student List';
		$course = $this->db->get_where('courses', array('id' => $course_id))->row()->name;
		$level = $this->db->get_where('classes', array('id' => $class_id))->row()->class;

		$html = $this->load->view($viewpath, $this->data, true);

		$this->load->library('mhtml2pdf');

		$this->mhtml2pdf->folder('uploads/report/');
		$this->mhtml2pdf->filename($course . " " . $level);
		$this->mhtml2pdf->paper($pagesize, $pagetype);
		$this->mhtml2pdf->html($html);

		if (!empty($stylesheet)) {
			$stylesheet = file_get_contents(base_url('assets/reports/' . $stylesheet));
			return $this->mhtml2pdf->create($this->data['panel_title'], $stylesheet, $mode);
		} else {
			return $this->mhtml2pdf->create($this->data['panel_title'], $mode);
		}
	}
	function getListOfStudentsPDF($course_id, $class_id)
	{
		$students = $this->student_model->getStudentList($course_id, $class_id);
		$this->data['course_id'] = $course_id;
		$this->data['class_id'] = $class_id;
		$this->data['students'] = $students;
		$this->form_PDF('studentlistreport.css', $this->data, 'admin/students/studentlistpdf', $course_id, $class_id);
	}
	function getRegListOfStudentsPDF($course_id, $class_id)
	{
		$students = $this->student_model->getRegStudentList($course_id, $class_id);
		$this->data['course_id'] = $course_id;
		$this->data['class_id'] = $class_id;
		$this->data['students'] = $students;
		$this->form_PDF('studentlistreport.css', $this->data, 'admin/students/regstudentlistpdf', $course_id, $class_id);
	}

	function passreset()
	{
		$id = $this->input->post('st_id');
		//$result = $this->student_model->passreset($id);
		$password = "password";
		$encryp_password = sha1($password);
		$student_data = array('open_p' => $password);
		$userdata = array('password' => $encryp_password);
		$this->db->where("id", $id)->update("students", $student_data);
		$query = $this->db->where("user_id", $id)->update("users", $userdata);
		//return true;
		//if ($result) {
		return json_encode(array('status' => 1, 'msg' => 'success'));

		/* if ($result) {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="Password Updated Successfully, Thank You." data-type="success"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Password updated successfully</div>');
			redirect('admin/students/view/' . $id);
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Error." data-type="danger"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Error!</div>');
			redirect('admin/students/view/' . $id);
		} */
	}
	function delete()
	{
		$id = $this->input->post('id');
		$this->db->where('id', $id)->delete('students');
		$this->db->where('student_id', $id)->delete('student_session');
		$query = $this->db->where('user_id', $id)->delete('users');
		return json_encode(array('status' => 1, 'msg' => 'success'));
	}




	/* public function bulk_upload()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'xlsx|xls';
		$config['max_size'] = 10000;

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());
			echo json_encode($error);
		} else {
			$data = $this->upload->data();
			$filePath = $data['full_path'];
			//$this->load->library('phpexcel'); // or 'phpspreadsheet'

			$department_id = 	html_escape($this->input->post('department_id'));
			$course_id = 		html_escape($this->input->post('course_id'));
			$class_id = 		html_escape($this->input->post('class_id'));
			//$state_id = 		html_escape($this->input->post('state_id'));

			$school = $this->db->get_where('
			    courses', array(
				'id' => $course_id
			))->row();
			try {
				// Load the spreadsheet
				$fileType = IOFactory::identify($filePath);
				$reader = IOFactory::createReader($fileType);
				$spreadsheet = $reader->load($filePath);
				$sheet = $spreadsheet->getActiveSheet();

				$data = [];
				foreach ($sheet->getRowIterator() as $row) {
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);
					$rowData = [];
					foreach ($cellIterator as $cell) {
						$rowData[] = $cell->getValue();
					}
					// Skip header row
					if ($row->getRowIndex() == 1) {
						continue;
					}
					$sheetData[] = $rowData;
				}

				$existingStudents = [];
				$insertedStudents = [];

				foreach ($sheetData as $row) {

					$state = $row[5];

					if ($state == 'Bauchi' || $state == 'BAUCHI' || $state == 'bauchi' || $state == 'Bau' || $state == 'BAU' || $state == 'bau') {
						$indigene = 'Indigene';
					} else {
						$indigene = 'Non-Indigene';
					};

					//$phone = "0" . $user_data[$i]["phone"];

					if ($class_id == 0) {
						$role = 'pre';
						$role_id = '5';
					} else {
						$role = 'student';
						$role_id = '4';
					}
					$studentData = [
						'reg_no' => $row[1],
						'firstname' => $row[2],
						'lastname' => $row[3],
						'middlename' => $row[4],
						'state' => $row[5],
						'school_id' => 				$school->school_id,
						'course_id' =>				$course_id,
						'department_id' =>			$department_id,
						'admission_date' => 			date('d/m/Y'),
						'is_active' => 'yes',
					];

					$result = $this->Student_model->insert_student($studentData);

					if ($result['status'] == 'exists') {
						$existingStudents[] = $result['data'];
					} else {
						$insertedStudents[] = $result['data'];
					}
				}

				$response = array(
					'status' => 'success',
					'inserted' => $insertedStudents,
					'existing' => $existingStudents,
				);

				echo json_encode($response);
			} catch (Exception $e) {
				echo json_encode(array('error' => $e->getMessage()));
			}
		}
	} */

	public function bulk_upload()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = 10000;

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());
			echo json_encode($error);
		} else {
			$data = $this->upload->data();
			$file_path = './uploads/' . $data['file_name'];

			if ($this->process_csv($file_path)) {
				echo json_encode(array('success' => true));
			} else {
				echo json_encode(array('error' => 'Error processing the CSV file'));
			}
		}
	}

	private function process_csv($file_path)
	{
		$department_id = 	html_escape($this->input->post('department_id'));
		$course_id = 		html_escape($this->input->post('course_id'));
		$class_id = 		html_escape($this->input->post('class_id'));
		$school = $this->db->get_where('
			    courses', array(
			'id' => $course_id
		))->row();
		if ($class_id == 0) {
			$role = 'pre';
			$role_id = '5';
		} else {
			$role = 'student';
			$role_id = '4';
		}
		$file = fopen($file_path, 'r');
		while (($line = fgetcsv($file)) !== FALSE) {
			// Assuming CSV columns: id, name, email, age
			$state = $line[4];

			if (
				$state == 'Bauchi' || $state == 'BAUCHI' || $state == 'bauchi' || $state == 'Bau' || $state == 'BAU' || $state == 'bau'
			) {
				$indigene = 'Indigene';
			} else {
				$indigene = 'Non-Indigene';
			};

			//$phone = "0" . $user_data[$i]["phone"];


			$data = array(
				'reg_no' => $line[0],
				'firstname' => $line[1],
				'lastname' => $line[2],
				'middlename' => $line[3],
				'state' => $line[4],
				'school_id' => 				$school->school_id,
				'course_id' =>				$course_id,
				'department_id' =>			$department_id,
				'admission_date' => 			date('d/m/Y'),
				'is_active' => 'yes',
			);
			$insert_id = $this->student_model->addForStaff($data);
			if (!empty($insert_id)) {
				$user_password = sha1('password');
				$data = array(
					'id' => $insert_id,
					'student_type' => $indigene,
					'open_p' => 'password'
				);
				$this->add($data);
				$data_new = array(
					'student_id' => $insert_id,
					'class_id' => $class_id,
					'session_id' => current_session(),
					'role' => $role
					// 'semester_id' => $semester
				);
				$this->student_model->add_student_session($data_new);

				// $sibling_id = $this->input->post('sibling_id');
				$data_student_login = array(
					'user_id' => $insert_id,
					'firstname' => 				$line[1],
					'lastname' => 				$line[2] . " " . $line[3],
					'username' => $line[0],
					'password' => $user_password,
					'role_id' => $role_id,
					'role' => $role,
					//'phone' => 				$user_data[$i]["phone"],
					'date_added' => date('d/m/Y'),
					'status' => '1'
				);
				$this->db->insert('users', $data_student_login);
			}
		}
		fclose($file);
		return true;
	}

	// Load the view for XLS upload
	public function upload_xls()
	{
		$this->load->view('admin/students/upload_csv');
	}

	public function process_xls()
	{
		if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			if (in_array($ext, ['xls', 'xlsx'])) {
				$file = $_FILES['file']['tmp_name'];
				try {
					$spreadsheet = IOFactory::load($file);
					$data = $spreadsheet->getActiveSheet()->toArray();

					// Process the data and get the result
					$processed_data = $this->student_model->process_xls_file($data);

					// Load the result into the view for display
					$this->load->view('admin/students/processed_data', ['processed_data' => $processed_data]);
				} catch (Exception $e) {
					$this->session->set_flashdata('error', 'Error reading Excel file: ' . $e->getMessage());
					redirect('admin/students/upload_csv');
				}
			} else {
				$this->session->set_flashdata('error', 'Please upload an Excel file only (.xls or .xlsx).');
				redirect('admin/students/upload_csv');
			}
		} else {
			$this->session->set_flashdata('error', 'No file uploaded.');
			redirect('admin/students/upload_csv');
		}
	}


	// Load the view for XLS upload
	public function upload_xls_for_change()
	{
		$this->load->view('admin/students/upload_xls_for_change');
	}

	// Load the view for XLS upload
	public function upload_xls_for_change_class()
	{
		$this->load->view('admin/students/upload_xls_for_class');
	}

	public function process_xls_for_change()
	{
		if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			if (in_array($ext, ['xls', 'xlsx'])) {
				$file = $_FILES['file']['tmp_name'];
				try {
					$spreadsheet = IOFactory::load($file);
					$data = $spreadsheet->getActiveSheet()->toArray();

					// Process the data and get the result
					$processed_data = $this->student_model->process_xls_file_for_change($data);

					// Load the result into the view for display
					$this->load->view('admin/students/processed_data', ['processed_data' => $processed_data]);
				} catch (Exception $e) {
					$this->session->set_flashdata('error', 'Error reading Excel file: ' . $e->getMessage());
					redirect('admin/students/upload_xls_for_change');
				}
			} else {
				$this->session->set_flashdata('error', 'Please upload an Excel file only (.xls or .xlsx).');
				redirect('admin/students/upload_xls_for_change');
			}
		} else {
			$this->session->set_flashdata('error', 'No file uploaded.');
			redirect('admin/students/upload_xls_for_change');
		}
	}
	public function process_xls_for_change_class()
	{
		if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			if (in_array($ext, ['xls', 'xlsx'])) {
				$file = $_FILES['file']['tmp_name'];
				try {
					$spreadsheet = IOFactory::load($file);
					$data = $spreadsheet->getActiveSheet()->toArray();

					// Process the data and get the result
					$processed_data = $this->student_model->upload_xls_level_change($data);

					// Load the result into the view for display
					$this->load->view('admin/students/processed_data', ['processed_data' => $processed_data]);
				} catch (Exception $e) {
					$this->session->set_flashdata('error', 'Error reading Excel file: ' . $e->getMessage());
					redirect('admin/students/upload_xls_for_class');
				}
			} else {
				$this->session->set_flashdata('error', 'Please upload an Excel file only (.xls or .xlsx).');
				redirect('admin/students/upload_xls_for_class');
			}
		} else {
			$this->session->set_flashdata('error', 'No file uploaded.');
			redirect('admin/students/upload_xls_for_class');
		}
	}
	function admission_pdf($id)
	{
		$student_id = $id;
		$student = $this->student_model->get($id);

		$this->data['student'] = $student;
		$this->admission_PDF_format($student_id, 'admissionreport.css', $this->data, 'student/admission');
	}

	public function admission_PDF_format($student_id, $stylesheet = NULL, $data = NULL, $viewpath = NULL, $mode = 'view', $pagesize = 'a4', $pagetype = 'portrait')
	{

		$student = $this->student_model->get($student_id);
		$this->data['panel_title'] = 'Admission Form';
		$html = $this->load->view($viewpath, $this->data, true);

		$this->load->library('mhtml2pdf');

		$this->mhtml2pdf->folder('uploads/report/');
		$this->mhtml2pdf->filename($student['reg_no']);
		$this->mhtml2pdf->paper($pagesize, $pagetype);
		$this->mhtml2pdf->html($html);

		if (!empty($stylesheet)) {
			$stylesheet = file_get_contents(base_url('assets/reports/' . $stylesheet));
			return $this->mhtml2pdf->create($this->data['panel_title'], $stylesheet, $mode);
		} else {
			return $this->mhtml2pdf->create($this->data['panel_title'], $mode);
		}
	}
}
