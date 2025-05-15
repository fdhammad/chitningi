<div class="container-fluid">
    <div class="row my-3">
        <div class="col-12 col-xl-12">
            <div class="card shadow">
                <div class="card-header danger text-white text-uppercase text-center download_label">
                    <h4><?php echo  'RESULTS'; ?></h4>
                    <div class="row justify-content-end">
                        <div class="col">
                            <ul id="myTab4" role="tablist" class="nav nav-tabs card-header-tabs nav-material nav-material-white float-left">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="tab1" data-toggle="tab" href="#v-pills-tab1" role="tab" aria-controls="tab1" aria-expanded="true" aria-selected="true">List</a>
                                </li>


                            </ul>
                            <div class="float-right">
                                <a href="<?php echo base_url('admin/exams/program_result_pdf/' . $course_id . '/' . $class_id . '/' . $semester_id . '/' . $session_id) ?>" class="btn btn-sm btn-primary pdfurl mb-3 float-right" target="_blank"><i class="icon-download"></i> Print Result</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1">

                            <div class="table-responsive">
                                <table id="basic" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th rowspan="2">
                                                <?= 'S/N' ?>
                                            </th>
                                            <th rowspan="2">
                                                <?= 'Reg no' ?>
                                            </th>

                                            <?php if ($subjects) {
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
                                            <?php if ($subjects) {
                                                foreach ($subjects as $key => $subject) { ?>

                                                    <th>
                                                        <?= $subject['unit']; ?>
                                                    </th>

                                            <?php }
                                            } ?>

                                        </tr>

                                    </thead>

                                    <tbody>
                                        <?php
                                        if (empty($studentList)) {
                                        ?>
                                            <tr>
                                                <td colspan="12" class="text-danger text-center"><?php echo get_phrase('no_record_found'); ?></td>
                                            </tr>
                                            <?php
                                        } else {
                                            $studentCount = [];
                                            $count = 1;
                                            if ($studentList) {
                                                foreach ($studentList as $student) {
                                                    //$std_data = $this->db->get_where('students', array('id' => $student->student_id))->row_array();
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
                                                            <?php echo $student->reg_no; //$std_data['firstname'] . " " . $std_data['middlename'] . " " . $std_data['lastname']; 
                                                            ?>
                                                        </td>
                                                        <?php if ($subjects) {
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
                                                            <td><b class="text-bold" style="font-size: 12px;">
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

                                                        <?php } ?>




                                                    </tr>
                                        <?php }
                                            }
                                        } ?>
                                    </tbody>

                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>