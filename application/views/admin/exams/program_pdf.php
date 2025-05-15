<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>

    <?php $system_name = $this->db->get_where('settings', array('key' => 'system_name'))->row()->value; ?>
    <?php $system_address = $this->db->get_where('settings', array('key' => 'address'))->row()->value;

    ?>


    <div class="col-sm-12">
        <div class="reportPage-header">
            <span class="header"><img class="logo" src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>"></span>';

            <p class="title"><?php echo $system_name; ?></p>
            <p class="title"><?php echo $system_address; ?></p>
            <div class="reportPage-header">
                <p class="title">
                    <?php echo $CourseDepartmentSchool['school']; ?>
                </p>
                <p class="title">
                    <?php echo $CourseDepartmentSchool['department']; ?>
                </p>
                <p class="title">
                    <?php echo $semesters['semester'] . ' (' . $sessions['session'] . ') RESULT SHEET'; ?>
                </p>
            </div>
        </div>


        <!--  <div class="box-header bg-gray">
        <h3 class="box-title text-navy"><i class="fa fa-clipboard"></i>
            <?= 'Termly'; ?> -
            <?= 'Report Sheet'; ?>
        </h3>
    </div> --><!-- /.box-header -->
        <!--  <div class="col-sm-12">
        <h5 class="pull-left">
            <?php
            echo $this->lang->line('class') . " : ";
            if ($class_id == null) {
                echo 'All Classes';
            } else {
                echo $classes['class'];
            }
            ?>
        </h5>
        <h5 class="pull-right">
            <?php
            echo $this->lang->line('Course') . " : ";
            if ($course_id == null) {
                echo 'All Courses';
            } else {
                echo $departments['name'];
            }
            ?>
        </h5>
    </div> -->
        <?php if (customCompute($studentList)) { ?>
            <div class="maintabulationsheetreport">
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">
                                <?= 'S/N' ?>
                            </th>
                            <th rowspan="2">
                                <?= 'Reg no' ?>
                            </th>

                            <?php if (customCompute($subjects)) {
                                foreach ($subjects as $key => $subject) { ?>
                                    <th class="text-center">
                                        <?= $subject['code'] ?>
                                    </th>
                            <?php }
                            } ?>
                            <th rowspan="2">
                                <?= 'TCUR' ?>
                            </th>
                            <th rowspan="2">
                                <?= 'CU*GP' ?>
                            </th>

                            <th rowspan="2">
                                <?= 'GP' ?>
                            </th>
                            <th rowspan="2">
                                <?= 'Remark' ?>
                            </th>
                            <!-- <th rowspan="2"><?= 'AVG' ?></th> -->
                            <!--   <th rowspan="2">
                                                        <?= 'POS' ?>
                                                    </th> -->

                        </tr>

                        <tr>
                            <?php if (customCompute($subjects)) {
                                foreach ($subjects as $key => $subject) { ?>

                                    <th>
                                        <?= $subject['unit']; ?>
                                    </th>

                            <?php }
                            } ?>

                        </tr>
                    </thead>

                    <tbody>
                        <?php $studentCount = [];
                        $count = 1;
                        if (customCompute($studentList)) {
                            foreach ($studentList as $student) {
                                $std_data = $this->db->get_where('students', array('id' => $student->student_id))->row_array();
                                $totalGrade = 0;
                                $co = $this->exam_model->get_co($student->student_id);
                                $total_wgp = $this->exam_model->get_all_total_wgp($student->student_id);
                                $total_unit = $this->exam_model->get_all_total_units($student->student_id);
                                $gpa = $total_wgp->wgp / $total_unit->unit;
                                $total_gp = $this->exam_model->get_all_total_units_e($student->student_id);

                                //$total = $this->exam_model->total($student->id, $class_id, $semester_id, $session_id);
                                // $average = $this->exam_model->average($student->student_id, $class_id, $semester_id, $session_id);
                                // $rank = $this->exam_model->class_rank($student->student_id, $section_id, $class_id, $semester_id, $session_id)->row();
                        ?>

                                <tr>

                                    <td class="text-left">
                                        <?php echo $count++; //$std_data['firstname'] . " " . $std_data['middlename'] . " " . $std_data['lastname']; 
                                        ?>
                                    </td>

                                    <td class="text-left">
                                        <?php echo $std_data['reg_no']; //$std_data['firstname'] . " " . $std_data['middlename'] . " " . $std_data['lastname']; 
                                        ?>
                                    </td>
                                    <?php if (customCompute($subjects)) {
                                        foreach ($subjects as $subject) {
                                            $subjectTotal = 0;
                                            $mark = $this->db->get_where('marks', array('student_id' => $student->student_id, 'subject_id' => $subject['id'], 'semester_id' => $semester_id, 'session_id' => $session_id))->row_array();
                                    ?>


                                            <td>
                                                <?php if (!empty($mark)) {
                                                    echo $mark['total'];
                                                } else {
                                                    echo 'Nil';
                                                }; ?>

                                            </td>



                                        <?php } ?>



                                    <?php } ?>
                                    <td><b class="text-bold">
                                            <?php if (!empty($total_gp)) {
                                                echo round($total_gp->unit);
                                            } else {
                                                echo '0';
                                            }; ?>
                                        </b>
                                    </td>
                                    <td><b class="text-bold">
                                            <?php if (!empty($total_wgp)) {
                                                echo round($total_wgp->wgp);
                                            } else {
                                                echo '0';
                                            }; ?>
                                        </b>
                                    </td>
                                    <td><b class="text-bold">
                                            <?php if (!empty($gpa)) {
                                                echo round($gpa, 2);
                                            } else {
                                                echo '0';
                                            }; ?>
                                        </b>
                                    </td>
                                    <td style="text-align:left;"><b class="" style=" text-align:left; font-size: 8px;">
                                            <?php if (!empty($co)) {
                                                if ($gpa <= 1) {
                                                    echo "PROBATION";
                                                } else {
                                                    if ($co > 1) {
                                                        foreach ($co as $value) {
                                                            if ($co > 1) {
                                                                echo $value['code'] . ' | ';
                                                            } else {
                                                                echo $value['code'];
                                                            }
                                                        }
                                                    } else {
                                                        echo $co;
                                                    }
                                                }
                                            } else {
                                                echo "PASS";
                                            } ?>
                                        </b>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="notfound">
                <?php echo 'Data Not Found'; ?>
            </div>
        <?php } ?>
        <div class="col-sm-12 text-center footerAll">
            <div class="footer">
                <img class="flogo" style="width:30px" src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>">
                <p class="copyright">Copyright @ <?= date('Y') ?> <?= $system_name; ?> </p>
            </div>
        </div>
</body>

</html>