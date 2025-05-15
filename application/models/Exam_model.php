<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->current_session = current_session();
        $this->current_semester = current_semester();
    }
    public function getSubject($course_id, $class_id, $semester_id)
    {
        $this->db->select('subjects.name as `name`,subjects.id as `id`,subjects.code as `code`,subjects.unit as `unit`');
        $this->db->from('subjects');
        $this->db->where('course_id', $course_id);

        $this->db->where('class_id', $class_id);

        $this->db->where('semester_id', $semester_id);
        $this->db->order_by('code');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_subjectUnit($id)
    {
        return $this->db->select('subjects.unit as `unit`')
            ->from('subjects')
            ->where('id', $id)
            ->get()
            ->row();
    }
    public function getTitleSub($id)
    {
        $this->db->select('subjects.*');
        $this->db->from('subjects');
        $this->db->where('subjects.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function getTitleDp($id)
    {
        $this->db->select('departments.*');
        $this->db->from('departments');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function getTitleCs($id)
    {
        $this->db->select('courses.*');
        $this->db->from('courses');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function getClass($id)
    {
        $this->db->select('classes.*');
        $this->db->from('classes');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function getSession($id)
    {
        $this->db->select('sessions.*');
        $this->db->from('sessions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getSemester($id)
    {
        $this->db->select('semesters.*');
        $this->db->from('semesters');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getDepartment($department_id = null)
    {

        $this->db->select('*');
        $this->db->from('courses');

        $this->db->where('department_id', $department_id);
        $this->db->order_by('courses.name');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getSubjectsByCourseClassSemester($course_id, $class_id, $semester_id)
    {
        $this->db->select('id, name,code');
        $this->db->from('subjects');
        $this->db->where('course_id', $course_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('semester_id', $semester_id);
        $this->db->order_by('code', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function getAttendance($subject_id = null, $semester_id = null, $session_id = null)
    {
        $this->db->select('course_reg.*,students.firstname as `firstname`,students.id as `student_id`, students.middlename as `middlename`, students.lastname as `lastname`,students.image as `image`, students.reg_no as `reg_no`');
        $this->db->from('course_reg');
        $this->db->join('students', 'course_reg.student_id = students.id', 'left');

        // $this->db->where('course_reg.semester_id', $semester_id);
        //$this->db->where('course_reg.session_id', $session_id);
        //$this->db->where('course_reg.course_id', $course_id);
        $this->db->where('course_reg.subject_id', $subject_id);
        $this->db->order_by('students.reg_no', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_mark($student_id, $subject_id, $semester_id, $session_id)
    {
        $this->db->select();
        $this->db->from('marks');

        $this->db->where('marks.student_id', $student_id);
        $this->db->where('marks.subject_id', $subject_id);
        $this->db->where('marks.session_id', $session_id);
        $this->db->where('marks.semester_id', $semester_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function save_marks($data)
    {
        foreach ($data as $mark) {
            try {
                // Check if the mark ID is present to determine if it's an update or an insert
                if (empty($mark['id'])) {
                    // Insert new record
                    $this->db->insert('marks', [
                        'student_id' => $mark['student_id'],
                        'course_id' => $mark['course_id'],
                        'subject_id' => $mark['subject_id'],
                        'semester_id' => $mark['semester_id'],
                        'session_id' => $mark['session_id'],
                        'ca' => $mark['ca'],
                        'exam' => $mark['exam'],
                        'total' => $mark['total'],
                        'grade' => $mark['grade'],
                        'gp' => $mark['gp'],
                        'wgp' => $mark['wgp']
                    ]);
                } else {
                    // Update existing record
                    $this->db->where('id', $mark['id']);
                    $this->db->update('marks', [
                        'student_id' => $mark['student_id'],
                        'course_id' => $mark['course_id'],
                        'subject_id' => $mark['subject_id'],
                        'semester_id' => $mark['semester_id'],
                        'session_id' => $mark['session_id'],
                        'ca' => $mark['ca'],
                        'exam' => $mark['exam'],
                        'total' => $mark['total'],
                        'grade' => $mark['grade'],
                        'gp' => $mark['gp'],
                        'wgp' => $mark['wgp']
                    ]);
                }
            } catch (Exception $e) {
                log_message('error', 'Database error: ' . $e->getMessage());
                throw $e;
            }
        }
    }



    public function upload_marks($marksData)
    {
        foreach ($marksData as $mark) {
            // Check if the mark already exists to avoid duplicates
            $this->db->where('student_id', $mark['student_id']);
            $this->db->where('subject_id', $mark['subject_id']);
            $this->db->where('semester_id', $mark['semester_id']);
            $this->db->where('session_id', $mark['session_id']);

            $query = $this->db->get('marks');

            if ($query->num_rows() > 0) {
                // Update existing record
                $this->db->where('student_id', $mark['student_id']);
                $this->db->where('subject_id', $mark['subject_id']);
                $this->db->where('semester_id', $mark['semester_id']);
                $this->db->where('session_id', $mark['session_id']);

                $this->db->update('marks', $mark);
            } else {
                // Insert new record
                $this->db->insert('marks', $mark);
            }
        }
    }

    public function upload_reg($regData)
    {
        foreach ($regData as $course_reg) {
            // Check if the course_reg already exists to avoid duplicates
            $this->db->where('student_id', $course_reg['student_id']);
            $this->db->where('subject_id', $course_reg['subject_id']);
            $this->db->where('semester_id', $course_reg['semester_id']);
            $this->db->where('session_id', $course_reg['session_id']);

            $query = $this->db->get('course_reg');

            if ($query->num_rows() > 0) {
                // Update existing record
                $this->db->where('student_id', $course_reg['student_id']);
                $this->db->where('subject_id', $course_reg['subject_id']);
                $this->db->where('semester_id', $course_reg['semester_id']);
                $this->db->where('session_id', $course_reg['session_id']);

                $this->db->update('course_reg', $course_reg);
            } else {
                // Insert new record
                $this->db->insert('course_reg', $course_reg);
            }
        }
    }

    public function mark_exists($student_id, $subject_id, $semester_id, $session_id)
    {
        $this->db->where('student_id', $student_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('semester_id', $semester_id);
        $this->db->where('session_id', $session_id);
        $query = $this->db->get('marks');

        return $query->num_rows() > 0;
    }
    public function check_student_registration($student_id, $subject_id, $session_id)
    {
        $this->db->where('student_id', $student_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('session_id', $session_id);
        $query = $this->db->get('course_reg');

        return $query->num_rows() > 0;
    }

    public function getRegStudent($subject_id, $class_id, $semester_id, $session_id)
    {
        $this->db->select('students.id as `id`,students.reg_no')->from('course_reg');
        $this->db->join('students', 'students.id = course_reg.student_id', 'left');
        $this->db->where('course_reg.subject_id', $subject_id);
        $this->db->where('course_reg.class_id', $class_id);
        $this->db->where('course_reg.semester_id', $semester_id);
        $this->db->where('course_reg.session_id', $session_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function mark_details_semester($course_id, $semester_id,  $session_id)
    {
        $this->db->distinct();
        $this->db->select('course_reg.student_id,students.reg_no');
        //$this->db->where('student_id', $student_id);
        $this->db->join('students', 'students.id=course_reg.student_id', 'LEFT');

        $this->db->where('students.course_id', $course_id);


        // $this->db->where('course_reg.class_id', $class_id);

        $this->db->where('course_reg.semester_id', $semester_id);
        $this->db->where('course_reg.session_id', $session_id);
        $this->db->order_by('course_reg.reg_no', 'ASC');
        $query = $this->db->get('course_reg');
        return $query;
    }

    public function get_all_total_units_e($student_id)
    {
        $this->db->select_sum('subjects.unit');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where('course_reg.class_id', $class_id);
        //$this->db->where('course_reg.session_id', $session_id);
        // $this->db->where('course_reg.grade != "F"');
        //$this->db->where('course_reg.total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_all_total_units($student_id)
    {
        $this->db->select_sum('subjects.unit');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where('course_reg.class_id', $class_id);
        //$this->db->where('course_reg.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_all_total_wgp($student_id)
    {
        $this->db->select_sum('marks.wgp');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where('course_reg.class_id', $class_id);
        //$this->db->where('course_reg.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_co($student_id)
    {
        $this->db->select('*,subjects.name as `subject`, subjects.code as `code`, subjects.unit as `unit`, subjects.status as `status`');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where_in('marks.grade="F"');
        $grade = array('F', NULL, 'F/A', 'AB', 'ABS', '');
        $this->db->where_in('marks.grade', $grade);
        //$this->db->where_in()
        //$this->db->where('marks.class_id', $class_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getStudentData($student_id)
    {
        $this->db->select('id,reg_no,firstname,lastname,middlename,image,phone, email')->from('students')->where('id', $student_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_semester_result($student_id, $semester_id, $session_id)
    {
        $this->db->select('marks.*,subjects.name as `subject`, subjects.code as `code`, subjects.unit as `unit`, subjects.status as `status`');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where('marks.class_id', $class_id);
        //$this->db->where('marks.session_id', $session_id);
        //$this->db->where('marks.semester_id', $semester_id);
        $this->db->order_by('subjects.code', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_total_units($student_id, $session_id, $semester_id)
    {
        $this->db->select_sum('subjects.unit');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        $this->db->where('marks.semester_id', $semester_id);
        $this->db->where('marks.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_total_units_f($student_id, $session_id, $semester_id)
    {
        $this->db->select_sum('subjects.unit');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        $this->db->where('marks.semester_id', $semester_id);
        $this->db->where('marks.session_id', $session_id);
        $this->db->where('marks.total != "F/A"');
        $this->db->where('marks.grade != "F"');
        //$this->db->or_where('marks.total != ""');
        //$this->db->or_where('marks.total != null');

        $query = $this->db->get();
        return $query->row();
    }
    public function get_total_total($student_id, $session_id, $semester_id)
    {
        $this->db->select_sum('marks.total');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        $this->db->where('marks.semester_id', $semester_id);
        $this->db->where('marks.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_total_wgp($student_id, $session_id, $semester_id)
    {
        $this->db->select_sum('marks.wgp');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        $this->db->where('marks.semester_id', $semester_id);
        $this->db->where('marks.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_total_gp($student_id, $session_id, $semester_id)
    {
        $this->db->select_sum('marks.gp');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        $this->db->where('marks.semester_id', $semester_id);
        $this->db->where('marks.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_session_total_units($student_id, $session_id)
    {
        $this->db->select_sum('subjects.unit');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where('marks.class_id', $class_id);
        $this->db->where('marks.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_session_total_units_f($student_id, $session_id)
    {
        $this->db->select_sum('subjects.unit');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where('marks.class_id', $class_id);
        $this->db->where('marks.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $this->db->where('marks.grade != "F"');
        $this->db->where('marks.total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }


    public function get_session_total_total($student_id, $session_id)
    {
        $this->db->select_sum('marks.total');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where('marks.class_id', $class_id);
        $this->db->where('marks.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_session_total_wgp($student_id, $session_id)
    {
        $this->db->select_sum('marks.wgp');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where('marks.class_id', $class_id);
        $this->db->where('marks.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_session_total_gp($student_id, $session_id)
    {
        $this->db->select_sum('marks.gp');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where('marks.class_id', $class_id);
        $this->db->where('marks.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_all_total_gp($student_id)
    {
        $this->db->select_sum('marks.gp');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where('marks.class_id', $class_id);
        //$this->db->where('marks.session_id', $session_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_gp_total($student_id, $session_id, $semester_id)
    {
        $this->db->select_sum('wgp');
        $this->db->from('marks');

        $this->db->where('student_id', $student_id);
        //$this->db->where('marks.class_id', $class_id);
        $this->db->where('session_id', $session_id);
        $this->db->where('semester_id', $semester_id);
        $this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_gp_unit($student_id, $session_id, $semester_id)
    {
        $this->db->select_sum('subjects.unit');
        $this->db->from('marks');
        $this->db->join('subjects', 'subjects.id = marks.subject_id');
        $this->db->where('marks.student_id', $student_id);
        //$this->db->where('marks.class_id', $class_id);
        $this->db->where('marks.session_id', $session_id);
        $this->db->where('marks.semester_id', $semester_id);
        //$this->db->where('total != "F/A"');
        $query = $this->db->get();
        return $query->row();
    }
    public function get_session($session)
    {
        $this->db->select('')->from('sessions')->where('id', $session);
        $query = $this->db->get();
        return $query->row();
    }
    public function get_semester($semester)
    {
        $this->db->select('')->from('semesters')->where('id', $semester);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_CourseDepartmentSchool($course_id)
    {
        $this->db->select('courses.name as `course`, departments.name as `department`, schools.school as `school`')->from('courses')->where('courses.id', $course_id);
        $this->db->join('departments', 'departments.id = courses.department_id');
        $this->db->join('schools', 'schools.id = courses.school_id');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function save_result($student_id, $subject_id, $course_id, $department_id, $mark, $grade, $gp, $wgp)
    {
        $data = [
            'student_id' => $student_id,
            'subject_id' => $subject_id,
            'course_id' => $course_id,
            'department_id' => $department_id,
            'total' => $mark,
            'grade' => $grade,
            'gp' => $gp,
            'wgp' => $wgp,
            'semester_id' => $this->current_semester,
            'session_id' => $this->current_session,
            'level' => 0,

        ];
        $this->db->insert('marks', $data);
    }
}
