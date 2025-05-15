<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Applicants extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->library('session');
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

		$this->user_model->check_session_data('admin');
	}


	function index()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		$page_data['page_name'] = "applicants/search";
		$school = $this->school_model->get();
		$page_data['schoollist'] = $school;
		$department_result = $this->department_model->get();
		$page_data['departmentlist'] = $department_result;
		$page_data['page_title'] = site_phrase('Applicants');
		$this->load->view('admin/index',  $page_data);
	}

	public function search_ajax()
	{

		$department = $this->input->post('department_id');
		$course = $this->input->post('course_id');
		$search_text = $this->input->post('search_text');
		$this->data['searchby'] = "filter";
		$this->data['department_id'] = $department;
		$this->data['course_id'] = $course;
		$this->data['result'] = $this->applicant_model->searchByDepartmentCourse($department, $course)->result_array();
		$ret['render'] = $this->load->view('admin/applicants/search_ajax', $this->data, true);
		$ret['status'] = true;
		echo json_encode($ret);
		exit;
	}

	function ajax()
	{
		$this->data['result'] = $this->applicant_model->searchAll()->result_array();
		$ret['render'] = $this->load->view('admin/applicants/search_ajax', $this->data, true);
		$ret['status'] = true;
		echo json_encode($ret);
		exit;
	}

	function view($id)
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		$page_data['page_name'] = "applicants/view";
		$page_data['page_title'] = site_phrase('Applicant Profile');
		$applicant = $this->applicant_model->getAll($id)->row_array();
		$waec = $this->applicant_model->getWaec($id);
		$page_data['waecs'] = $waec;
		$neco = $this->applicant_model->getNeco($id);
		$page_data['neco'] = $neco;
		$choice1 = $this->applicant_model->get_1choice($id);
		$page_data['choice1'] = $choice1->course;
		$choice2 = $this->applicant_model->get_2choice($id);
		$page_data['choice2'] = $choice2->course;
		$applicant_acad = $this->applicant_model->getapplicantacad($id);
		$page_data['applicant_acad'] = $applicant_acad;
		$page_data['applicant'] = $applicant;
		$this->load->view('admin/index',  $page_data);
	}

	function admit($id)
	{

		$applicant = $this->applicant_model->getAll($id)->row_array();
		$data['applicant'] = $applicant;
		$choice1 = $this->applicant_model->get_1choice($id);
		$course_id = $choice1->course_id;
		$department_id = $choice1->department_id;
		$school_id = $choice1->school_id;
		//$school_id = $this->applicant_model->get_sch_id($course_id);
		$data = array(
			'status' => 'admitted'
		);
		$data = $this->security->xss_clean($data);
		$admit = $this->applicant_model->update($data, $id, 'applicants');

		$state_id = $applicant['state_id'];
		if ($state_id == 5) {
			$indigene = 'Indigene';
		} else {
			$indigene = 'Non-Indigene';
		};
		$data_new = array(
			'form_no' => $applicant['application_no'],
			'firstname' => $applicant['firstname'],
			'lastname' => $applicant['lastname'],
			'middlename' => $applicant['middlename'],
			'phone' => $applicant['phone'],
			'email' => $applicant['email'],
			'image' => $applicant['image'],
			'gender' => $applicant['gender'],
			'state_id' => $state_id,
			'local_government_id' => $applicant['local_government_id'],
			'student_type' => $indigene,
			'disability' => $applicant['disability'],
			'religion' => $applicant['religion'],
			'dob' => $applicant['dob'],
			'department_id' => $department_id,
			'school_id' => $school_id,
			'course_id' => $course_id,
			'admission_date' => date('d/m/Y'),
			'is_active' => 'yes'
		);
		$insert_id = $this->student_model->addForStaff($data_new);
		$data_ss = array(
			'student_id' => $insert_id,
			'department_id' => $department_id,
			'school_id' => $school_id,
			'course_id' => $course_id,
			'class_id' => '0',
			'role' => 'pre',
			'session_id' => current_session(),
		);
		$this->student_model->add_student_session($data_ss);

		$user_password = sha1("password");
		$data_student_login = array(
			'firstname' => $applicant['firstname'],
			'lastname' => $applicant['lastname'],
			'username' => $applicant['application_no'],
			'phone' => $applicant['phone'],
			'email' => $applicant['email'],
			'password' => $user_password,
			'user_id' => $insert_id,
			'date_added' => date('d/m/Y'),
			'role_id' => '5',
			'role' => 'pre',
			'status' => '1'
		);
		$admit = $this->student_model->add_user($data_student_login);
		if ($admit) {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="Applicant has been Admitted Successfully." data-type="success"></div>');

			$this->session->set_flashdata('msg', '<div class="alert alert-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Applicant has been Admitted Successfully</div>');
			redirect(base_url('admin/applicant/view/' . $id));
			$response = array(
				'status' => true,
				'notification' => 'Success'
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => 'Unknown Error'
			);
		}

		echo json_encode($response);
	}



	public function applicant_pdf_sorted()
	{

		$this->data['departments'] = $this->applicant_model->get_Department();
		$this->data['department_applicants'] = $this->applicant_model->get_department_student_count();
		$this->data['total_applicants'] = $this->applicant_model->get_total_student_count();

		$this->reportPDF('feesreport.css', $this->data, 'admin/applicants/enroll_pdf');
	}

	public function reportPDF($stylesheet = NULL, $data = NULL, $viewpath = NULL, $mode = 'view', $pagesize = 'a4', $pagetype = 'portrait')
	{

		$this->data['panel_title'] = 'Payment Report';
		$html = $this->load->view($viewpath, $this->data, true);

		$this->load->library('mhtml2pdf');

		$this->mhtml2pdf->folder('uploads/report/');
		$this->mhtml2pdf->filename('Report');
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
