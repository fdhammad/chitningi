<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Exams extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        $this->load->helper('log_helper');
        $this->load->library('upload');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        $this->user_model->check_session_data('admin');
        $this->current_semester = current_semester();
        $this->current_session = current_session();
        $this->current_semester_name = current_semester_name();
        $this->current_session_name = current_session_name();
    }


    function index()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('staff/login'), 'refresh');
        }
        // CHECK ACCESS PERMISSION
        check_permission('exams');

        $page_data['page_name'] = "exams/index";
        $class_result = $this->class_model->get();

        $page_data['classlist'] = $class_result;
        $session = $this->session_model->get();
        $course_result = $this->course_model->get();
        $page_data['courselist'] = $course_result;
        $page_data['sessionlist'] = $session;
        $department_result = $this->department_model->get();
        $page_data['schoollist'] = $department_result;
        $semester = $this->semester_model->get();
        $page_data['semesterlist'] = $semester;
        $page_data['current_semester_id'] = $this->current_semester;
        $page_data['current_session_id'] = $this->current_session;
        $page_data['current_semester_name'] = $this->current_semester_name;
        $page_data['current_session_name'] = $this->current_session_name;
        $page_data['page_title'] = site_phrase('exams');
        $this->load->view('admin/index', $page_data);
        $this->load->view('admin/exams/scripts');
    }

    function getByDepartment()
    {
        $department_id = $this->input->get('department_id');
        $data = $this->exam_model->getDepartment($department_id);
        echo json_encode($data);
    }

    public function getSubjectsByCourse()
    {
        $course_id = $this->input->get('course_id');
        $class_id = $this->input->get('class_id');
        $semester_id = $this->input->get('semester_id');

        $subjects = $this->exam_model->getSubjectsByCourseClassSemester($course_id, $class_id, $semester_id);
        echo json_encode($subjects);
    }


    function mark_body()
    {
        $session = $this->input->post('session_id');
        $semester = $this->input->post('semester_id');
        $class = $this->input->post('class_id');
        $course = $this->input->post('course_id');

        $this->data['session_id'] = $session;
        $this->data['semester_id'] = $semester;
        $this->data['class_id'] = $class;
        $this->data['course_id'] = $course;

        $this->data['subjects'] = $this->exam_model->getSubject($course, $class, $semester);

        $ret['render'] = $this->load->view('admin/exams/mark_body', $this->data, true);
        $ret['status'] = true;
        echo json_encode($ret);
        exit;
    }

    function student_mark_body()
    {
        $session_id = $this->input->post('session_id');
        $semester_id = $this->input->post('semester_id');
        $subject_id = $this->input->post('subject_id');

        $this->data['session_id'] = $session_id;
        $this->data['semester_id'] = $semester_id;
        $this->data['subject_id'] = $subject_id;
        $students = $this->exam_model->getAttendance($subject_id, $semester_id, $session_id);
        $this->data['unit'] = $this->exam_model->get_subjectUnit($subject_id);
        $sub = $this->exam_model->getTitleSub($subject_id);
        $this->data['code'] = $sub->code;
        $this->data['name'] = $sub->name;
        //$depart = $this->exam_model->getTitleDp($department_id);
        //$data['dp'] = $depart->name;
        $this->data['students'] = $students;

        $ret['render'] = $this->load->view('admin/exams/student_mark_body', $this->data, true);
        $ret['status'] = true;
        echo json_encode($ret);
        exit;
    }
    /*   public function add()
    {
        if ($_POST) {
            $id = $this->input->post('id');

            $ca = $this->input->post('ca');
            $exam = $this->input->post('exam');
            $totals = $this->input->post('total');
            $grade = $this->input->post('grade');
            $gp = $this->input->post('gp');
            $wgp = $this->input->post('wgp');
            $data = array();
            for ($i = 0; $i < sizeof($id); $i++) {

                $data[] = array(

                    'id' => $id[$i],
                    'ca' => $ca[$i],
                    'exam' => $exam[$i],
                    'total' => $totals[$i],
                    'grade' => $grade[$i],
                    'gp' => $gp[$i],
                    'wgp' => $wgp[$i]
                );
            }
            $this->db->update_batch('course_reg', $data, 'id');
            //$this->exam_model->manual_create($data);
            //print_r($data);

        }
        $this->session->set_flashdata('msg', '<div class="toast" data-title="Success! "data-message="Student Marks added Successfully." data-type="success"></div>');
        redirect('admin/exams/create');
    } */

    public function add()
    {
        // CSRF token validation
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $id = $this->input->post('id');
            $student_id = $this->input->post('student_id');
            $course_id = $this->input->post('course_id');
            $subject_id = $this->input->post('subject_id');
            $semester_id = $this->input->post('semester_id');
            $session_id = $this->input->post('session_id');
            $ca = $this->input->post('ca');
            $exam = $this->input->post('exam');
            $total = $this->input->post('total');
            $grade = $this->input->post('grade');
            $gp = $this->input->post('gp');
            $wgp = $this->input->post('wgp');

            // Log the received data for debugging
            log_message('debug', 'Received data: ' . json_encode($_POST));

            // Ensure all variables are arrays
            if (is_array($id) && is_array($student_id) && is_array($course_id) && is_array($subject_id) && is_array($ca) && is_array($exam) && is_array($total) && is_array($grade) && is_array($gp) && is_array($wgp)) {
                $data = [];
                for ($i = 0; $i < count($id); $i++) {
                    $data[] = [
                        'id' => $id[$i],
                        'student_id' => $student_id[$i],
                        'course_id' => $course_id[$i],
                        'subject_id' => $subject_id[$i],
                        'semester_id' => $semester_id[$i],
                        'session_id' => $session_id[$i],
                        'ca' => $ca[$i],
                        'exam' => $exam[$i],
                        'total' => $total[$i],
                        'grade' => $grade[$i],
                        'gp' => $gp[$i],
                        'wgp' => $wgp[$i]
                    ];
                }

                // Save data using the model
                try {
                    $this->exam_model->save_marks($data);
                    echo json_encode(['status' => 'success']);
                } catch (Exception $e) {
                    log_message('error', 'Error saving marks: ' . $e->getMessage());
                    echo json_encode(['status' => 'error', 'message' => 'Error saving data']);
                }
            } else {
                log_message('error', 'Invalid data provided');
                echo json_encode(['status' => 'error', 'message' => 'Invalid data provided']);
            }
        } else {
            show_404();
        }
    }

    function bulk()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('staff/login'), 'refresh');
        }
        // CHECK ACCESS PERMISSION
        check_permission('exams');
        $page_data['page_name'] = "exams/bulk";
        $department_result = $this->department_model->get();
        $class_result = $this->class_model->get();
        $page_data['classlist'] = $class_result;
        $session = $this->session_model->get();
        $course_result = $this->course_model->get();
        $page_data['courselist'] = $course_result;
        $page_data['sessionlist'] = $session;
        $department_result = $this->department_model->get();
        $page_data['schoollist'] = $department_result;
        $semester = $this->semester_model->get();
        $page_data['semesterlist'] = $semester;
        $page_data['current_semester_id'] = $this->current_semester;
        $page_data['current_session_id'] = $this->current_session;
        $page_data['current_semester_name'] = $this->current_semester_name;
        $page_data['current_session_name'] = $this->current_session_name;
        $page_data['page_title'] = 'Bulk';
        $this->load->view('admin/index',  $page_data);
        $this->load->view('admin/exams/scripts');
    }

    function upload_file_body()
    {
        $session_id = $this->input->post('session_id');
        $semester_id = $this->input->post('semester_id');
        $subject_id = $this->input->post('subject_id');
        $course_id = $this->input->post('course_id');
        $this->data['session_id'] = $session_id;
        $this->data['semester_id'] = $semester_id;
        $this->data['subject_id'] = $subject_id;
        $this->data['course_id'] = $course_id;
        $students = $this->exam_model->getAttendance($subject_id, $semester_id, $session_id);
        $this->data['unit'] = $this->exam_model->get_subjectUnit($subject_id);
        $sub = $this->exam_model->getTitleSub($subject_id);
        $this->data['code'] = $sub->code;
        $this->data['name'] = $sub->name;
        //$depart = $this->exam_model->getTitleDp($department_id);
        //$data['dp'] = $depart->name;
        $this->data['students'] = $students;

        $ret['render'] = $this->load->view('admin/exams/upload_file', $this->data, true);
        $ret['status'] = true;
        echo json_encode($ret);
        exit;
    }
    public function import_marks()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv|xlsx|xls';
        $config['max_size'] = 2048; // 2MB

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            $error = $this->upload->display_errors();
            echo json_encode(['status' => 'error', 'message' => $error]);
            return;
        } else {
            $fileData = $this->upload->data();
            $filePath = './uploads/' . $fileData['file_name'];

            $session_id = $this->input->post('session_id');
            $semester_id = $this->input->post('semester_id');
            $course_id = $this->input->post('course_id');
            $department_id = $this->input->post('department_id');
            $class_id = $this->input->post('class_id');
            $subject_id = $this->input->post('subject_id');
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
                    $data[] = $rowData;
                }

                // Process data
                $marksData = [];
                $regData = [];
                $duplicates = [];
                foreach ($data as $row) {
                    $reg_no = $row[0];
                    $total = $row[1];
                    // $ca = $row[1];
                    // $exam = $row[2];
                    $subject_id = $this->input->post('subject_id');
                    // $total = $ca + $exam;
                    $unit = $this->db->select('unit')->where('id', $subject_id)->get('subjects')->row();
                    $grade = $this->calculate_grade($total);
                    $gp = $this->calculate_gp($grade);
                    $wgp = $this->calculate_wgp($grade, $unit->unit);
                    $studentid = $this->db->select('id')->where('reg_no', $reg_no)->get('students')->row();
                    $student_id = $studentid->id;
                    $mark = [
                        'student_id' => $studentid->id,
                        'subject_id' => $subject_id,
                        'semester_id' => $semester_id,
                        'session_id' => $session_id,
                        'course_id' => $course_id,
                        'department_id' => $department_id,
                        // 'ca' => $ca,
                        //'exam' => $exam,
                        'total' => $total,
                        'grade' => $grade,
                        'gp' => $gp,
                        'wgp' => $wgp // Assuming WGP is the same as GP for this example
                    ];
                    $course_reg = [
                        'student_id' => $studentid->id,
                        'reg_no' => $reg_no,
                        'subject_id' => $subject_id,
                        'semester_id' => $semester_id,
                        'session_id' => $session_id,
                        'department_id' => $department_id,
                        'course_id' => $course_id,
                        'class_id' => $class_id,
                    ];
                    // Check if the student data exists in course_reg table
                    $student_exists = $this->exam_model->check_student_registration($student_id, $subject_id, $session_id);
                    $regData[] = $course_reg;
                    if ($student_exists) {
                        // Student is registered for the course, proceed with saving mark
                        // Check if the mark already exists to avoid duplicates
                        // Check for duplicates
                        if ($this->exam_model->mark_exists($student_id, $subject_id, $semester_id, $session_id)) {
                            $duplicates[] = $mark;
                        } else {
                            $regData[] = $course_reg;
                            $marksData[] = $mark;
                        }
                    } else {
                        echo json_encode(['status' => 'not_registered', 'message' => $reg_no . ' Did not enroll for the Course']);
                        exit;
                    }
                }

                // Check if duplicates exist
                if (!empty($duplicates)) {
                    $this->exam_model->upload_marks($marksData);
                    echo json_encode(['status' => 'confirm', 'duplicates' => $duplicates, 'message' => 'Marks Overwritten Successfully']);
                } else {
                    // $this->exam_model->upload_reg($regData);
                    $this->exam_model->upload_marks($marksData);
                    echo json_encode(['status' => 'success', 'message' => 'Marks imported successfully']);
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Error processing file: ' . $e->getMessage()]);
            }
        }
    }

    private function calculate_grade($total)
    {
        if ($total >= 70 && $total <= 100) {
            return 'A';
        } elseif ($total >= 60 && $total <= 69) {
            return 'B';
        } elseif ($total >= 55 && $total <= 59) {
            return 'C';
        } elseif ($total >= 50 && $total <= 54) {
            return 'D';
        } elseif ($total == 'ABS' || $total == 'AB') {
            return 'F';
        } else {
            return 'F';
        }
    }

    private function calculate_gp($grade)
    {
        switch ($grade) {
            case 'A':
                return 4;
            case 'B':
                return 3;
            case 'C':
                return 2;
            case 'D':
                return 1;
            case 'F':
                return 0;
            default:
                return 0;
        }
    }

    private function calculate_wgp($grade, $unit)
    {
        switch ($grade) {
            case 'A':
                return 4 * $unit;
            case 'B':
                return 3 * $unit;
            case 'C':
                return 2 * $unit;
            case 'D':
                return 1 * $unit;
            case 'F':
                return 0;
            default:
                return 0;
        }
    }

    public function course_result()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('staff/login'), 'refresh');
        }
        // CHECK ACCESS PERMISSION
        check_permission('exams');
        $page_data['page_name'] = "exams/course_result";
        $department_result = $this->department_model->get();
        $class_result = $this->class_model->get();
        $page_data['classlist'] = $class_result;
        $session = $this->session_model->get();
        $course_result = $this->course_model->get();
        $page_data['courselist'] = $course_result;
        $page_data['sessionlist'] = $session;
        $department_result = $this->department_model->get();
        $page_data['schoollist'] = $department_result;
        $semester = $this->semester_model->get();
        $page_data['semesterlist'] = $semester;
        $page_data['current_semester_id'] = $this->current_semester;
        $page_data['current_session_id'] = $this->current_session;
        $page_data['current_semester_name'] = $this->current_semester_name;
        $page_data['current_session_name'] = $this->current_session_name;
        $page_data['page_title'] = 'Results';
        $this->load->view('admin/index',  $page_data);
        $this->load->view('admin/exams/scripts');
    }

    function course_result_body()
    {
        $session = $this->input->post('session_id');
        $semester = $this->input->post('semester_id');
        $class = $this->input->post('class_id');
        $course = $this->input->post('course_id');

        $this->data['session_id'] = $session;
        $this->data['semester_id'] = $semester;
        $this->data['class_id'] = $class;
        $this->data['course_id'] = $course;

        $this->data['subjects'] = $this->exam_model->getSubject($course, $class, $semester);

        $ret['render'] = $this->load->view('admin/exams/course_result_body', $this->data, true);
        $ret['status'] = true;
        echo json_encode($ret);
        exit;
    }

    function course_result_data()
    {
        $session_id = $this->input->post('session_id');
        $semester_id = $this->input->post('semester_id');
        $subject_id = $this->input->post('subject_id');
        $class_id = $this->input->post('class_id');
        $course_id = $this->input->post('course_id');
        $this->data['session_id'] = $session_id;
        $this->data['semester_id'] = $semester_id;
        $this->data['subject_id'] = $subject_id;
        $this->data['course_id'] = $course_id;
        $this->data['class_id'] = $class_id;
        $students = $this->exam_model->getRegStudent($subject_id, $class_id, $semester_id, $session_id);
        //$this->data['unit'] = $this->exam_model->get_subjectUnit($subject_id);
        //$sub = $this->exam_model->getTitleSub($subject_id);
        // $this->data['code'] = $sub->code;
        //$this->data['name'] = $sub->name;
        //$depart = $this->exam_model->getTitleDp($department_id);
        //$data['dp'] = $depart->name;
        $this->data['students'] = $students;

        $ret['render'] = $this->load->view('admin/exams/course_result_data', $this->data, true);
        $ret['status'] = true;
        echo json_encode($ret);
        exit;
    }


    function program_results()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('staff/login'), 'refresh');
        }
        // CHECK ACCESS PERMISSION
        check_permission('exams');
        $page_data['page_name'] = "exams/program_results";
        $department_result = $this->department_model->get();
        $class_result = $this->class_model->get();
        $page_data['classlist'] = $class_result;
        $session = $this->session_model->get();
        $course_result = $this->course_model->get();
        $page_data['courselist'] = $course_result;
        $page_data['sessionlist'] = $session;
        $department_result = $this->department_model->get();
        $page_data['schoollist'] = $department_result;
        $semester = $this->semester_model->get();
        $page_data['semesterlist'] = $semester;
        $page_data['current_semester_id'] = $this->current_semester;
        $page_data['current_session_id'] = $this->current_session;
        $page_data['current_semester_name'] = $this->current_semester_name;
        $page_data['current_session_name'] = $this->current_session_name;
        $page_data['page_title'] = 'Bulk';
        $this->load->view('admin/index',  $page_data);
        $this->load->view('admin/exams/scripts');
    }

    function program_result_body()
    {
        $session = $this->input->post('session_id');
        $semester = $this->input->post('semester_id');
        $class = $this->input->post('class_id');
        $course = $this->input->post('course_id');

        $this->data['session_id'] = $session;
        $this->data['semester_id'] = $semester;
        $this->data['class_id'] = $class;
        $this->data['course_id'] = $course;

        $this->data['subjects'] = $this->exam_model->getSubject($course, $class, $semester);
        $this->data['studentList'] = $this->exam_model->mark_details_semester($course, $semester, $session)->result();

        $ret['render'] = $this->load->view('admin/exams/program_result_body', $this->data, true);
        $ret['status'] = true;
        echo json_encode($ret);
        exit;
    }

    public function student_results()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('staff/login'), 'refresh');
        }
        // CHECK ACCESS PERMISSION
        check_permission('exams');
        $page_data['page_name'] = "exams/student_results";
        $department_result = $this->department_model->get();
        $class_result = $this->class_model->get();
        $page_data['classlist'] = $class_result;
        $session = $this->session_model->get();
        $course_result = $this->course_model->get();
        $page_data['courselist'] = $course_result;
        $page_data['sessionlist'] = $session;
        $department_result = $this->department_model->get();
        $page_data['schoollist'] = $department_result;
        $semester = $this->semester_model->get();
        $page_data['semesterlist'] = $semester;
        $page_data['current_semester_id'] = $this->current_semester;
        $page_data['current_session_id'] = $this->current_session;
        $page_data['current_semester_name'] = $this->current_semester_name;
        $page_data['current_session_name'] = $this->current_session_name;
        $page_data['page_title'] = 'Results';
        $this->load->view('admin/index',  $page_data);
        $this->load->view('admin/exams/scripts');
    }

    function student_result_body()
    {
        $session = $this->input->post('session_id');
        $semester = $this->input->post('semester_id');
        $class = $this->input->post('class_id');
        $course = $this->input->post('course_id');

        $this->data['session_id'] = $session;
        $this->data['semester_id'] = $semester;
        $this->data['class_id'] = $class;
        $this->data['course_id'] = $course;

        $this->data['students'] = $this->exam_model->getRegStudent($course, $class, $semester, $session);

        $ret['render'] = $this->load->view('admin/exams/student_result_body', $this->data, true);
        $ret['status'] = true;
        echo json_encode($ret);
        exit;
    }

    function student_result_data()
    {
        $session_id = $this->input->post('session_id');
        $semester_id = $this->input->post('semester_id');
        $student_id = $this->input->post('student_id');
        $class_id = $this->input->post('class_id');
        $course_id = $this->input->post('course_id');
        $this->data['session'] = $session_id;
        $this->data['semester'] = $semester_id;
        $this->data['id'] = $student_id;
        $this->data['course_id'] = $course_id;
        $this->data['class_id'] = $class_id;
        $student = $this->exam_model->getStudentData($student_id);
        $co = $this->exam_model->get_co($student_id);
        $mark = $this->exam_model->get_semester_result($student_id, $semester_id, $session_id);
        $total_unit = $this->exam_model->get_total_units($student_id, $session_id, $semester_id);
        $total_unit_f = $this->exam_model->get_total_units_f($student_id, $session_id, $semester_id);
        $total_total = $this->exam_model->get_total_total($student_id, $session_id, $semester_id);
        $total_gp = $this->exam_model->get_total_gp($student_id, $session_id, $semester_id);
        $total_wgp = $this->exam_model->get_total_wgp($student_id, $session_id, $semester_id);
        $semester_name = $this->exam_model->get_semester($semester_id);
        $session_name = $this->exam_model->get_session($session_id);
        //$this->data['unit'] = $this->exam_model->get_subjectUnit($subject_id);
        //$sub = $this->exam_model->getTitleSub($subject_id);
        // $this->data['code'] = $sub->code;
        //$this->data['name'] = $sub->name;
        //$depart = $this->exam_model->getTitleDp($department_id);
        //$data['dp'] = $depart->name;
        $this->data['student'] = $student;
        $this->data['mark'] = $mark;
        $this->data['co'] = $co;

        $this->data['semester_name'] = $semester_name;
        $this->data['session_name'] = $session_name;

        $this->data['total_unit'] = $total_unit;
        $this->data['total_unit_f'] = $total_unit_f;
        $this->data['total_total'] = $total_total;
        $this->data['total_gp'] = $total_gp;
        $this->data['total_wgp'] = $total_wgp;

        $ret['render'] = $this->load->view('admin/exams/student_result_data', $this->data, true);
        $ret['status'] = true;
        echo json_encode($ret);
        exit;
    }

    public function reportPDF($stylesheet, $data, $viewpath, $mode = 'view', $pagesize = 'a4', $pagetype = 'portrait')
    {

        $this->data['panel_title'] = 'Exams Attendance Sheet';
        $html = $this->load->view($viewpath, $this->data, true);

        $this->load->library('mhtml2pdf');

        $this->mhtml2pdf->folder('uploads/report/');
        $this->mhtml2pdf->filename('Departmenatal_result_report');
        $this->mhtml2pdf->paper($pagesize, $pagetype);
        $this->mhtml2pdf->html($html);

        if (!empty($stylesheet)) {
            $stylesheet = file_get_contents(base_url('assets/reports/' . $stylesheet));
            return $this->mhtml2pdf->create($this->data['panel_title'], $stylesheet, $mode);
        } else {
            return $this->mhtml2pdf->create($this->data['panel_title'], $mode);
        }
    }

    public function program_result_pdf()
    {

        /* 	if (!$this->rbac->hasPrivilege('exam_result', 'can_view')) {
		access_denied();
		} */

        $course = htmlentities($this->uri->segment(4));
        $class = htmlentities($this->uri->segment(5));
        $semester = htmlentities($this->uri->segment(6));
        $session = htmlentities($this->uri->segment(7));
        $this->data['session_id'] = $session;
        $this->data['semester_id'] = $semester;
        $this->data['class_id'] = $class;
        $this->data['course_id'] = $course;
        //$this->data['department_id'] = $department;
        $this->data['classes'] = $this->class_model->get($class);
        $this->data['courses'] = $this->course_model->get($course);
        $this->data['sessions'] = $this->session_model->get($session);
        $this->data['semesters'] = $this->semester_model->get($semester);
        $this->data['CourseDepartmentSchool'] = $this->exam_model->get_CourseDepartmentSchool($course);
        $this->data['subjects'] = $this->exam_model->getSubject($course, $class, $semester);
        $this->data['studentList'] = $this->exam_model->mark_details_semester($course, $semester, $session)->result();

        $this->reportPDF('departmentalresult.css', $this->data, 'admin/exams/program_pdf', 'view', 'a4', 'l');
        //}
    }

    function weeding_bulk()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('staff/login'), 'refresh');
        }
        // CHECK ACCESS PERMISSION
        check_permission('exams');
        $page_data['page_name'] = "exams/weeding_bulk";
        $department_result = $this->department_model->get();
        $course_result = $this->course_model->get();
        $page_data['courselist'] = $course_result;
        $department_result = $this->department_model->get();
        $page_data['schoollist'] = $department_result;

        $page_data['page_title'] = 'Bulk';
        $this->load->view('admin/index',  $page_data);
        $this->load->view('admin/exams/scripts');
    }

    public function weeding_upload_and_process()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xls|xlsx';
        $config['overwrite'] = true;
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            $data['error'] = $this->upload->display_errors();
            //$this->load->view('weeding_bulk', $data);
            redirect('admin/exams/weeding_bulk', $data);
            return;
        }

        // Process the uploaded file
        $file_data = $this->upload->data();
        $file_path = './uploads/' . $file_data['file_name'];

        try {
            $spreadsheet = IOFactory::load($file_path);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);
            $course_id = $this->input->post('course_id');
            $department_id = $this->input->post('department_id');
            // Extract course codes from the first row (B1 to K1)
            $course_codes = array_slice($data[1], 1);

            // Process student rows (from row 2)
            foreach ($data as $row_num => $row) {
                if ($row_num == 1) continue; // Skip header row

                $matric_num = trim($row['A']);
                $student = $this->student_model->get_by_matric($matric_num);
                if (!$student) continue;

                foreach ($course_codes as $col => $course_code) {
                    $subject = $this->subject_model->get_by_code($course_code);
                    if (!$subject) continue;

                    $mark = trim($row[$col]);
                    if ($mark !== '') {
                        $grade = $this->calculate_grades($mark);
                        $gp = $this->calculate_gps($grade);
                        $wgp = $this->calculate_wgps($grade, $subject['unit']);

                        $this->exam_model->save_result(
                            $student['id'],
                            $subject['id'],
                            $course_id,
                            $department_id,
                            $mark,
                            $grade,
                            $gp,
                            $wgp
                        );
                    }
                }
            }

            unlink($file_path);
            $data['success'] = "Results uploaded successfully!";
        } catch (Exception $e) {
            $data['error'] = 'Error loading file: ' . $e->getMessage();
        }
        redirect('admin/exams/weeding_bulk', $data);
        //$this->load->view('weeding_bulk', $data);
    }

    private function calculate_grades($total)
    {
        if ($total >= 70 && $total <= 100) {
            return 'A';
        } elseif ($total >= 60 && $total <= 69) {
            return 'B';
        } elseif ($total >= 55 && $total <= 59) {
            return 'C';
        } elseif ($total >= 50 && $total <= 54) {
            return 'D';
        } elseif ($total == 'ABS' || $total == 'AB') {
            return 'F';
        } else {
            return 'F';
        }
    }

    private function calculate_gps($grade)
    {
        switch ($grade) {
            case 'A':
                return 4;
            case 'B':
                return 3;
            case 'C':
                return 2;
            case 'D':
                return 1;
            case 'F':
                return 0;
            default:
                return 0;
        }
    }

    private function calculate_wgps($grade, $unit)
    {
        switch ($grade) {
            case 'A':
                return 4 * $unit;
            case 'B':
                return 3 * $unit;
            case 'C':
                return 2 * $unit;
            case 'D':
                return 1 * $unit;
            case 'F':
                return 0;
            default:
                return 0;
        }
    }
}
