<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registrable_course_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->current_session = current_session();
        $this->current_semester = current_semester();
    }

    public function get($course_id, $class_id = null, $semester_id)
    {
        $this->db->select('registrable_courses.id as id,registrable_courses.course_id,registrable_courses.subject_id as `subject_id`,subjects.name as `subject`,subjects.status as `status`,subjects.unit as `unit`,subjects.code as `code`,classes.class as `class`,semesters.semester as `semester`');
        $this->db->from('registrable_courses');
        $this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
        $this->db->join('classes', 'classes.id = registrable_courses.class_id', 'left');
        $this->db->join('semesters', 'semesters.id = registrable_courses.semester_id');
        if ($class_id != null) {
            $this->db->where('registrable_courses.class_id', $class_id);
        }
        $this->db->where('registrable_courses.course_id', $course_id);
        $this->db->where('registrable_courses.semester_id', $semester_id);
        $this->db->order_by('subjects.code', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_sug_id($course_id, $class_id = null, $semester_id)
    {
        $this->db->select('registrable_courses.id as `id`,registrable_courses.subject_id as `subject_id');
        //$this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
        $this->db->where('registrable_courses.course_id', $course_id);
        if ($class_id != null) {
            $this->db->where('registrable_courses.class_id', $class_id);
        }
        $this->db->where('registrable_courses.semester_id', $semester_id);
        $query = $this->db->get('registrable_courses');
        $array = array();
        foreach ($query->result() as $key => $row) {
            $array[] = $row->subject_id; // add each user id to the array
        }
        return $array;
    }

    public function checkSuggestExist($data)
    {
        $course_id = $this->input->post('course_id');
        $class_id = $this->input->post('class_id');
        $semester_id = $this->input->post('semester_id');
        //$student = $this->student_model->get($student_id);
        $this->db->where('subject_id', $data);
        $this->db->where('course_id', $course_id);
        $this->db->where('semester_id', $semester_id);
        $query = $this->db->get('registrable_courses');
        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function sug($subject_id)
    {
        $this->db->trans_begin();


        $sections_array = array();
        foreach ($subject_id as $vec_key => $vec_value) {

            $vehicle_array = array(
                'class_id' => $this->input->post('class_id'),
                'semester_id' => $this->input->post('semester_id'),
                'course_id' => $this->input->post('course_id'),
                'subject_id' => $vec_value->subject_id,
            );

            $sections_array[] = $vehicle_array;
        }
        $this->db->insert_batch('registrable_courses', $sections_array);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }
    public function sug_drop($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('registrable_courses');
    }

    /* public function get($id = null)
	{
		$this->db->select()->from('registrable_courses');
		if ($id != null) {
			$this->db->where('id', $id);
		} else {
			$this->db->order_by('id');
		}
		$query = $this->db->get();
		if ($id != null) {
			return $query->row_array();
		} else {
			return $query->result_array();
		}
	}
 */

    public function teachersjubject($id = null)
    {
        $this->db->select()->from('teacher_subjects');
        if ($id != null) {
            $this->db->where('teacher_id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function remove($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->delete('registrable_courses');
        return $result;
    }

    public function deleteBatch($ids, $class_semester_id)
    {



        $this->db->where('class_semester_id', $class_semester_id);
        $this->db->where_not_in('id', $ids);
        $this->db->delete('registrable_courses');
    }
    public function getDetailbyClassSemester($class_id, $semester_id)
    {
        $this->db->select('class_semesters.*,classes.class,semesters.semester')->from('class_semesters');
        $this->db->where('class_id', $class_id);
        $this->db->where('semester_id', $semester_id);
        $this->db->join('classes', 'classes.id = class_semesters.class_id');
        $this->db->where('class_semesters.class_id', $class_id);
        $this->db->join('semesters', 'semesters.id = class_semesters.semester_id');
        $this->db->where('class_semesters.semester_id', $semester_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function add($data)
    {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('registrable_courses', $data);
        } else {
            $this->db->insert('registrable_courses', $data);
            return $this->db->insert_id();
        }
    }
    public function addStatus($data)
    {
        $this->db->where('session_id', $data['session_id']);
        //$this->db->where('class_id', $data['class_id']);
        $this->db->where('semester_id', $data['semester_id']);
        $this->db->where('student_id', $data['student_id']);
        $q = $this->db->get('regcourses');
        if ($q->num_rows() > 0) {
            $rec = $q->row_array();
            $this->db->where('id', $rec['id']);
            $this->db->update('regcourses', $data);
        } else {
            $this->db->insert('regcourses', $data);
            return $this->db->insert_id();
        }
    }
    public function UpdateStatus($student_id, $class_id, $course_id)
    {
        $this->db->set('status', 'Approved');
        $this->db->where('student_id', $student_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('course_id', $course_id);
        $this->db->where('semester_id', $this->current_semester);
        $this->db->where('session_id', $this->current_session);
        $this->db->update('regcourses');
    }
    public function addReg($data)

    {
        $this->db->insert('course_reg', $data);
        return $query = $this->db->insert_id();
    }
    public function add2($data, $sections)
    {
        $this->db->trans_begin();
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('registrable_courses', $data);
            $id = $data['id'];
        } else {
            $this->db->insert('registrable_courses', $data);
            $id = $this->db->insert_id();
        }


        $sections_array = array();
        foreach ($sections as $vec_key => $vec_value) {

            $vehicle_array = array(
                'class_id' => $this->input->post('class_id'),
                'semester_id' => $this->input->post('semester_id'),
                'course_id' => $this->input->post('course_id'),
                'subject_id' => $vec_value,
            );

            $sections_array[] = $vehicle_array;
        }
        $this->db->insert_batch('registrable_courses', $sections_array);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }
    function fetch_co($ncecourse)
    {
        $this->db->select('subjects.id as `id`,subjects.name as `name`, subjects.code as `code`')->from('registrable_courses');
        $this->db->join('courses', 'courses.id = registrable_courses.course_id');
        $this->db->join('semesters', 'semesters.id = registrable_courses.semester_id');
        $this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
        $this->db->where('registrable_courses.course_id', $ncecourse);
        $this->db->where('registrable_courses.semester_id', $this->current_semester);
        $this->db->order_by('subjects.code', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_co_ds($ncecourse)
    {
        $this->db->select('subjects.id as `id`,subjects.name as `name`, subjects.code as `code`')->from('registrable_courses');
        $this->db->join('courses', 'courses.id = registrable_courses.course_id');
        $this->db->join('semesters', 'semesters.id = registrable_courses.semester_id');
        $this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
        $this->db->where('registrable_courses.course_id', $ncecourse);
        $this->db->where('registrable_courses.semester_id', $this->current_semester);
        $this->db->order_by('subjects.code', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    public function getDetailByclassAndSemester($class_semester_id)
    {
        $this->db->select()->from('registrable_courses');
        $this->db->where('class_semester_id', $class_semester_id);
        $query = $this->db->get();

        return $query->result_array();
    }
    public function getDetailByLecture($department_id, $class_semester_id)
    {
        $this->db->select()->from('teacher_subjects');
        $this->db->where('class_semester_id', $class_semester_id);
        $this->db->where('department_id', $department_id);
        //$this->db->where('teacher_subjects.session_id', $this->current_session);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getCount($class_id, $course_id)
    {
        $this->db->select('sum(subjects.unit) as unit')->from('registrable_courses');
        $this->db->join('courses', 'courses.id = registrable_courses.course_id');
        $this->db->join('classes', 'classes.id = registrable_courses.class_id');
        $this->db->join('semesters', 'semesters.id = registrable_courses.semester_id');
        $this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
        $this->db->where('registrable_courses.class_id', $class_id);
        $this->db->where('registrable_courses.course_id', $course_id);
        $this->db->where('registrable_courses.semester_id', $this->current_semester);
        $query = $this->db->query();

        return $query->row()->unit;
    }
    public function getCount_ds($class_id, $course_id)
    {
        $this->db->select('sum(subjects.unit) as unit')->from('registrable_courses');
        $this->db->join('courses', 'courses.id = registrable_courses.course_id');
        $this->db->join('classes', 'classes.id = registrable_courses.class_id');
        $this->db->join('semesters', 'semesters.id = registrable_courses.semester_id');
        $this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
        $this->db->where('registrable_courses.class_id', $class_id);
        $this->db->where('registrable_courses.course_id', $course_id);
        $this->db->where('registrable_courses.semester_id', $this->current_semester_ds + 1);
        $query = $this->db->query();

        return $query->row()->unit;
    }
    public function getCounts($class_id, $course_id)
    {
        $sql = "SELECT sum(subjects.unit) as unit FROM `registrable_courses` LEFT JOIN `subjects` ON subjects.id = registrable_courses.subject_id WHERE registrable_courses.class_id= $class_id AND registrable_courses.semester_id=$this->current_session AND registrable_courses.course_id= $course_id   ";
        $result = $this->db->query($sql);
        return $result->row()->unit;
    }

    public function getSum($class_id, $course_id)
    {


        $this->db->select_sum('subjects.unit');
        $this->db->from('registrable_courses');
        $this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
        $this->db->where('registrable_courses.course_id', $course_id);
        $this->db->where('registrable_courses.class_id', $class_id);
        $this->db->where('registrable_courses.semester_id', $this->current_semester);
        $query = $this->db->get();
        return $query->row();
    }
    public function getSumReg($student_id, $class_id, $course_id)
    {


        $this->db->select_sum('subjects.unit');
        $this->db->from('course_reg');
        $this->db->join('subjects', 'subjects.id = course_reg.subject_id');
        //$this->db->where('course_reg.course_id', $course_id);
        $this->db->where('course_reg.student_id', $student_id);
        //$this->db->where('course_reg.class_id', $class_id);
        $this->db->where('course_reg.semester_id', $this->current_semester);
        $this->db->where('course_reg.session_id', $this->current_session);
        $query = $this->db->get();
        return $query->row()->unit;
    }
    public function getStatus($student_id, $class_id, $course_id)
    {
        $this->db->select('*');
        $this->db->from('regcourses');
        // $this->db->join('subjects', 'subjects.id = course_reg.subject_id');
        //$this->db->where('regcourses.course_id', $course_id);
        $this->db->where('regcourses.student_id', $student_id);
        //$this->db->where('regcourses.class_id', $class_id);
        $this->db->where('regcourses.semester_id', $this->current_semester);
        $this->db->where('regcourses.session_id', $this->current_session);
        $query = $this->db->get();
        return $query->row()->status;
    }


    public function getSum_ds($class_id, $course_id)
    {


        $this->db->select_sum('subjects.unit');
        $this->db->from('registrable_courses');
        $this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
        $this->db->where('registrable_courses.course_id', $course_id);
        $this->db->where('registrable_courses.class_id', $class_id);
        $this->db->where('registrable_courses.semester_id', $this->current_semester);
        $query = $this->db->get();
        return $query->row();
    }
    public function getSumReg_ds($student_id, $class_id, $course_id)
    {


        $this->db->select_sum('subjects.unit');
        $this->db->from('course_reg');
        $this->db->join('subjects', 'subjects.id = course_reg.subject_id');
        //$this->db->where('course_reg.course_id', $course_id);
        $this->db->where('course_reg.student_id', $student_id);
        //$this->db->where('course_reg.class_id', $class_id);
        $this->db->where('course_reg.semester_id', $this->current_semester);
        $this->db->where('course_reg.session_id', $this->current_session);
        $query = $this->db->get();
        return $query->row()->unit;
    }
    public function getStatus_ds($student_id, $class_id, $course_id)
    {
        $this->db->select('*');
        $this->db->from('regcourses');
        // $this->db->join('subjects', 'subjects.id = course_reg.subject_id');
        //$this->db->where('regcourses.course_id', $course_id);
        $this->db->where('regcourses.student_id', $student_id);
        //$this->db->where('regcourses.class_id', $class_id);
        $this->db->where('regcourses.semester_id', $this->current_semester);
        $this->db->where('regcourses.session_id', $this->current_session);
        $query = $this->db->get();
        return $query->row()->status;
    }



    public function getDetailbyClsandSection($class_id, $section_id, $exam_id)
    {
        $query = $this->db->query("SELECT teacher_subjects.*,exam_schedules.date_of_exam,exam_schedules.start_to,exam_schedules.end_from,exam_schedules.room_no,exam_schedules.full_marks,exam_schedules.passing_marks,subjects.name,
            subjects.type FROM `teacher_subjects` LEFT JOIN `exam_schedules` ON exam_schedules.teacher_subject_id=teacher_subjects.id AND exam_schedules.exam_id = " . $this->db->escape($exam_id) . "  INNER JOIN subjects
            ON teacher_subjects.subject_id = subjects.id INNER JOIN class_sections
            ON teacher_subjects.class_section_id = class_sections.id WHERE class_sections.class_id =" . $this->db->escape($class_id) . " and class_sections.section_id=" . $this->db->escape($section_id));

        return $query->result_array();
    }

    public function getSubjectByClsandSection($class_id, $section_id, $classteacher = 'yes')
    {


        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];

        if (isset($role_id) && ($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
            $cquery = $this->db->select("classes.*")->join("classes", "class_teacher.class_id = classes.id")->where("class_teacher.staff_id", $userdata["id"])->where("classes.id", $class_id)->get("class_teacher");
            if ($cquery->num_rows() > 0) {

                $classteacher = 'no';
            } else {
                $classteacher = 'yes';
            }

            if ($classteacher == 'yes') {

                //   $this->db->where("teacher_subjects.teacher_id",$userdata["id"]);
                $where = " and teacher_subjects.teacher_id = " . $userdata["id"];
            } else {
                $where = " ";
            }
        } else {
            $where = " ";
        }


        $sql = "SELECT teacher_subjects.*,staff.name as `teacher_name`, staff.surname, subjects.name,subjects.type,subjects.code FROM `teacher_subjects` INNER JOIN subjects ON teacher_subjects.subject_id = subjects.id INNER JOIN class_sections ON teacher_subjects.class_section_id = class_sections.id INNER JOIN staff ON staff.id = teacher_subjects.teacher_id  WHERE class_sections.class_id =" . $this->db->escape($class_id) . " and class_sections.section_id=" . $this->db->escape($section_id) . " and teacher_subjects.session_id=" . $this->db->escape($this->current_session) . " " . $where;

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function getTeacherClassSubjects($teacher_id)
    {
        $this->db->select('teacher_subjects.*,subjects.name,classes.class,sections.section');
        $this->db->from('teacher_subjects');
        $this->db->join('subjects', 'subjects.id = teacher_subjects.subject_id');
        $this->db->join('class_sections', 'class_sections.id = teacher_subjects.class_section_id');
        $this->db->join('classes', 'classes.id = class_sections.class_id');
        $this->db->join('sections', 'sections.id = class_sections.section_id');
        $this->db->where('teacher_subjects.teacher_id', $teacher_id);
        $this->db->where('teacher_subjects.session_id', $this->current_session);
        $query = $this->db->get();
        return $query->result();
    }
    public function getDetailByclassSemesterAndncecourse($class_id, $semester_id, $course_id)
    {
        $this->db->select()->from('registrable_courses');
        $this->db->where('registrable_courses.class_id', $class_id);
        $this->db->where('registrable_courses.semester_id', $semester_id);
        $this->db->where('registrable_courses.course_id', $course_id);
        $query = $this->db->get();

        return $query->result_array();
    }
    public function getByID($id = null)
    {
        $this->db->select('registrable_courses.id,courses.code as `code`,classes.class as `class`,semesters.semester as `semester`,subjects.name as `subject`,subjects.code as `sub_code`')->from('registrable_courses');
        $this->db->join('courses', 'courses.id = registrable_courses.course_id');
        $this->db->join('classes', 'classes.id = registrable_courses.class_id');
        $this->db->join('semesters', 'semesters.id = registrable_courses.semester_id');
        $this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');

        if ($id != null) {
            $this->db->where('registrable_courses.id', $id);
        } else {
            $this->db->order_by('registrable_courses.id', 'DESC');
        }

        $query = $this->db->get();
        if ($id != null) {
            $vehicle_routes = $query->result_array();

            $array = array();
            if (!empty($vehicle_routes)) {
                foreach ($vehicle_routes as $vehicle_key => $vehicle_value) {
                    $vec_route = new stdClass();
                    $vec_route->id = $vehicle_value['id'];


                    $vec_route->route_id = $vehicle_value['code'];
                    $vec_route->vehicles = $this->getVechileByRoute($vehicle_value['id']);
                    $array[] = $vec_route;
                }
            }
            return $array;
        } else {
            $vehicle_routes = $query->result_array();
            $array = array();
            if (!empty($vehicle_routes)) {
                foreach ($vehicle_routes as $vehicle_key => $vehicle_value) {

                    $vec_route = new stdClass();
                    $vec_route->id = $vehicle_value['id'];
                    $vec_route->course = $vehicle_value['code'];
                    $vec_route->class = $vehicle_value['class'];
                    $vec_route->semester = $vehicle_value['semester'];
                    $vec_route->subject = $vehicle_value['sub_code'];


                    $vec_route->vehicles = $this->getVechileByRoute($vehicle_value['id']);
                    $array[] = $vec_route;
                }
            }
            return $array;
        }
    }
    public function getVechileByRoute($route_id)
    {
        $this->db->select('registrable_courses.id as c_comb_id,registrable_courses.course_id,registrable_courses.subject_id,subjects.*,subjects.name as `subject`,subjects.code as `code`,classes.class as `class`,semesters.semester as `semester`')->from('registrable_courses');
        $this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
        $this->db->join('classes', 'classes.id = registrable_courses.class_id');
        $this->db->join('semesters', 'semesters.id = registrable_courses.semester_id');


        $this->db->where('registrable_courses.course_id', $route_id);
        $this->db->order_by('registrable_courses.id', 'asc');
        $query = $this->db->get();
        return $vehicle_routes = $query->result();
    }
    public function getCourseForReg($course_id, $class_id = null)
    {
        $this->db->select('registrable_courses.id as c_comb_id,registrable_courses.course_id,registrable_courses.subject_id as `subject_id`,subjects.*,subjects.name as `subject`,subjects.status as `status`,subjects.unit as `unit`,subjects.code as `code`,classes.class as `class`,semesters.semester as `semester`');
        $this->db->from('registrable_courses');
        $this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
        $this->db->join('classes', 'classes.id = registrable_courses.class_id', 'left');
        $this->db->join('semesters', 'semesters.id = registrable_courses.semester_id');
        $this->db->where('registrable_courses.course_id', $course_id);
        if ($class_id != null) {
            $this->db->where('registrable_courses.class_id', $class_id);
        }
        $this->db->where('registrable_courses.semester_id', $this->current_semester);
        $this->db->order_by('subjects.code', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function getRegistered($student_id, $course_id, $class_id)
    {
        return $this->db->select('course_reg.id as `id`,course_reg.course_id,course_reg.subject_id as `subject_id`,subjects.name as `subject`,subjects.status as `status`,subjects.unit as `unit`,subjects.code as `code`,classes.class as `class`,semesters.semester as `semester`')
            ->from('course_reg')
            ->join('students', 'students.id = course_reg.student_id')
            ->join('subjects', 'subjects.id = course_reg.subject_id')
            ->join('classes', 'classes.id = course_reg.class_id', 'left')
            ->join('semesters', 'semesters.id = course_reg.semester_id')
            ->join('sessions', 'sessions.id = course_reg.session_id')
            //->where('course_reg.course_id', $course_id)
            //->where('course_reg.class_id', $class_id)
            ->where('course_reg.student_id', $student_id)
            ->where('course_reg.semester_id', $this->current_semester)
            ->where('course_reg.session_id', $this->current_session)
            ->order_by('subjects.code', 'asc')
            ->get()
            ->result();
    }
    public function get_reg_id($student_id, $course_id, $class_id)
    {
        $this->db->select('course_reg.id as `id`,course_reg.subject_id as `subject_id');
        $this->db->join('subjects', 'subjects.id = course_reg.subject_id');
        //$this->db->where('course_reg.course_id', $course_id);
        //$this->db->where('course_reg.class_id', $class_id);
        $this->db->where('course_reg.student_id', $student_id);
        $this->db->where('course_reg.semester_id', $this->current_semester);
        $this->db->where('course_reg.session_id', $this->current_session);
        $this->db->order_by('subjects.code', 'asc');
        $query = $this->db->get('course_reg');
        $array = array();

        foreach ($query->result() as $key => $row) {
            $array[] = $row->subject_id; // add each user id to the array
        }

        return $array;
    }
    public function getCourseForReg_ds($course_id, $class_id = null)
    {
        $this->db->select('registrable_courses.id as c_comb_id,registrable_courses.course_id,registrable_courses.subject_id as `subject_id`,subjects.*,subjects.name as `subject`,subjects.status as `status`,subjects.unit as `unit`,subjects.code as `code`,classes.class as `class`,semesters.semester as `semester`');
        $this->db->from('registrable_courses');
        $this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
        $this->db->join('classes', 'classes.id = registrable_courses.class_id', 'left');
        $this->db->join('semesters', 'semesters.id = registrable_courses.semester_id');
        $this->db->where('registrable_courses.course_id', $course_id);
        if ($class_id != null) {
            $this->db->where('registrable_courses.class_id', $class_id);
        }
        $this->db->where('registrable_courses.semester_id', $this->current_semester);
        $this->db->order_by('subjects.code', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function getRegistered_ds($student_id, $course_id, $class_id)
    {
        return $this->db->select('course_reg.id as `id`,course_reg.course_id,course_reg.subject_id as `subject_id`,subjects.name as `subject`,subjects.status as `status`,subjects.unit as `unit`,subjects.code as `code`,classes.class as `class`,semesters.semester as `semester`')
            ->from('course_reg')
            ->join('students', 'students.id = course_reg.student_id')
            ->join('subjects', 'subjects.id = course_reg.subject_id')
            ->join('classes', 'classes.id = course_reg.class_id', 'left')
            ->join('semesters', 'semesters.id = course_reg.semester_id')
            ->join('sessions', 'sessions.id = course_reg.session_id')
            //->where('course_reg.course_id', $course_id)
            //->where('course_reg.class_id', $class_id)
            ->where('course_reg.student_id', $student_id)
            ->where('course_reg.semester_id', $this->current_semester)
            ->where('course_reg.session_id', $this->current_session)
            ->order_by('subjects.code', 'asc')
            ->get()
            ->result();
    }
    public function get_reg_id_ds($student_id, $course_id, $class_id)
    {
        $this->db->select('course_reg.id as `id`,course_reg.subject_id as `subject_id');
        $this->db->join('subjects', 'subjects.id = course_reg.subject_id');
        //$this->db->where('course_reg.course_id', $course_id);
        //$this->db->where('course_reg.class_id', $class_id);
        $this->db->where('course_reg.student_id', $student_id);
        $this->db->where('course_reg.semester_id', $this->current_semester);
        $this->db->where('course_reg.session_id', $this->current_session);
        $this->db->order_by('subjects.code', 'asc');
        $query = $this->db->get('course_reg');
        $array = array();

        foreach ($query->result() as $key => $row) {
            $array[] = $row->subject_id; // add each user id to the array
        }

        return $array;
    }
    public function get_Prereg_id($student_id, $course_id)
    {
        $this->db->select('pre_course_reg.id as `id`,pre_course_reg.subject_id as `subject_id');
        $this->db->join('pre_subjects', 'pre_subjects.id = pre_course_reg.subject_id');
        $this->db->where('pre_course_reg.course_id', $course_id);
        $this->db->where('pre_course_reg.student_id', $student_id);
        $this->db->where('pre_course_reg.semester_id', $this->current_semester);
        $this->db->where('pre_course_reg.session_id', $this->current_session);
        $this->db->order_by('pre_subjects.code', 'asc');
        $query = $this->db->get('pre_course_reg');
        $array = array();

        foreach ($query->result() as $key => $row) {
            $array[] = $row->subject_id; // add each user id to the array
        }

        return $array;
    }
    public function checkStudentCourseExist($data)
    {
        $student_id = $this->input->post('student_id');
        //$student = $this->student_model->get($student_id);
        $this->db->where('subject_id', $data);
        $this->db->where('student_id', $student_id);
        $this->db->where('course_reg.session_id', $this->current_session);
        $query = $this->db->get('course_reg');
        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }
    public function checkStudentCourseExist_ds($data)
    {
        $student_id = $this->input->post('student_id');
        //$student = $this->student_model->get($student_id);
        $this->db->where('subject_id', $data);
        $this->db->where('student_id', $student_id);
        $this->db->where('course_reg.session_id', $this->current_session);
        $query = $this->db->get('course_reg');
        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }
    public function drop($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('course_reg');
    }

    public function reg($subject_id)
    {
        $this->db->trans_begin();


        $sections_array = array();
        foreach ($subject_id as $vec_key => $vec_value) {

            $vehicle_array = array(
                'student_id' => $this->input->post('student_id'),
                'session_id' => $this->input->post('session_id'),
                'reg_no' => $this->input->post('reg_no'),
                'school_id' => $this->input->post('school_id'),
                'class_id' => $this->input->post('class_id'),
                'semester_id' => $this->input->post('semester_id'),
                'course_id' => $this->input->post('course_id'),
                'subject_id' => $vec_value->subject_id,
            );

            $sections_array[] = $vehicle_array;
        }
        $this->db->insert_batch('course_reg', $sections_array);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }
    public function count_students($class_id, $section_id)
    {

        $query = $this->db->select("*")->join("student_session", "students.id = student_session.student_id")->where(array('student_session.class_id' => $class_id, 'student_session.section_id' => $section_id, 'students.is_active' => "yes"))->group_by("student_session.student_id")->get("students");

        return $query->num_rows();
    }




    public function remov($course_id, $array)
    {

        $this->db->where('course_id', $course_id);
        $this->db->where_in('dept_id', $array);
        $this->db->delete('c_comb');
    }
}
