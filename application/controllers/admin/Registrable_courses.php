<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrable_courses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
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
        check_permission('registerable_courses');

        $page_data['page_name'] = "registerable_courses";
        $subject_result = $this->subject_model->get();
        $page_data['subjectlist'] = $subject_result;
        $course_result = $this->course_model->get();
        $page_data['courselist'] = $course_result;
        $semester_result = $this->semester_model->get();
        $page_data['semesterlist'] = $semester_result;
        $class_result = $this->class_model->get();
        $page_data['classlist'] = $class_result;
        $page_data['page_title'] = site_phrase('registerable courses');

        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('admin/index', $page_data);
        } else {
            $course = $this->input->post('course_id');
            $class = $this->input->post('class_id');
            $search = $this->input->post('search');
            $semester = $this->input->post('semester_id');
            $search_text = $this->input->post('search_text');
            if (isset($search)) {
                if ($search == 'search_filter') {
                    $this->form_validation->set_rules('class_id', 'Level', 'trim|xss_clean');
                    $this->form_validation->set_rules('semester_id', 'Semester', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('course_id', 'Course', 'trim|xss_clean');
                    if ($this->form_validation->run() == FALSE) {
                    } else {
                        $data['searchby'] = "filter";
                        $data['course_id'] = $this->input->post('course_id');
                        $data['class_id'] = $this->input->post('class_id');
                        $data['semester_id'] = $this->input->post('semester_id');
                        $data['search_text'] = $this->input->post('search_text');
                        $subject = $this->subject_model->getSubjectForSug($class, $semester);
                        $data['subject'] = $subject;
                        $resultlist = $this->subject_model->getSubjectByCourseClass($course, $class, $semester);
                        $data['resultlist'] = $resultlist;
                        $registrable_courses = $this->suggestion_model->get($course, $class, $semester);
                        $data['registrable_courses'] = $registrable_courses;
                        $reg = $this->suggestion_model->get_sug_id($course, $class, $semester);
                        $data['reg'] = $reg;
                    }
                }
            }
            $this->load->view('admin/index', $page_data);
        }
    }

    function add()
    {

        $course_id =         html_escape($this->input->post('course_id'));
        $code =         html_escape($this->input->post('code'));
        $check = $this->subject_model->check_subject_duplication($code);
        if ($check != false) {
            $courseDetails = $this->db->get_where('courses', array('id' => $course_id))->row_array();
            $department_id = $courseDetails['department_id'];
            $school_id = $courseDetails['school_id'];
            $data = array(
                'name' =>             html_escape($this->input->post('name')),
                'code' =>             html_escape($this->input->post('code')),
                'status' =>         html_escape($this->input->post('status')),
                'unit' =>             html_escape($this->input->post('unit')),
                'class_id' =>         html_escape($this->input->post('class_id')),
                'semester_id' =>     html_escape($this->input->post('semester_id')),
                'course_id' =>         html_escape($this->input->post('course_id')),
                'department_id' =>     $department_id,
                'school_id' =>         $school_id,
            );
            $result = $this->subject_model->add($data);
            if ($result) {
                $details = $this->subject_model->get_by_id($result);
                $response = array(
                    'status' => true,
                    'notification' => 'Success',
                    'data' => $details
                );
            } else {
                $response = array(
                    'status' => false,
                    'notification' => 'Error'
                );
            }
        } else {
            $response = array(
                'status' => false,
                'notification' => 'Course Already Exist'
            );
        }

        echo json_encode($response);
    }
    function get_by_id()
    {
        $id = $this->input->post('id');

        $data = $this->subject_model->get_by_id($id);

        $arr = array('success' => false, 'data' => '');
        if ($data) {
            $arr = array('success' => true, 'data' => $data);
        }
        echo json_encode($arr);
    }
    public function update()
    {
        //$userdata = $this->customlib->getUserData();
        $modal_id = $this->input->post('modal_id');
        $modal_school_id = $this->input->post('modal_school_id');
        $modal_subject = $this->input->post('modal_name');
        //$status = $this->input->post('status');
        //$staff_id = $userdata['id'];
        //$subject_id = $this->input->post('subject_id');
        //$unit = $this->exams_model->getSubjectid($id)->unit;
        //$coll_call = substr($std_id, 4, 2);

        $data = array(
            'id' => $modal_id,
            'name' => $modal_subject,
            'school_id' => $modal_school_id,

        );

        $status = false;

        //$id = $this->input->post('id');

        if ($modal_subject) {
            $update = $this->subject_model->add($data);
            $status = true;
        }
        $data = $this->subject_model->get_by_id($modal_id);
        echo json_encode(array("status" => $status, 'data' => $data));
    }

    function delete($id)
    {
        //$id = $this->input->post('id'); // get the post data
        $delete = $this->subject_model->delete($id);
        if ($delete) {
            echo true;
            //$this->session->set_flashdata('msg', '<div student="alert alert-success text-left">Course Added Successfully</div>');
        } else {
            echo false;
        }
    }
}
