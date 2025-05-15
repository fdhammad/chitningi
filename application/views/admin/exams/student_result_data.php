<div class="container-fluid">
    <div class="row my-3">
        <div class="col-12 col-xl-12">
            <div class="card shadow">
                <div class="card-header bg-danger text-white text-uppercase text-center download_label">
                    <h4><?php echo  'STUDENT SEMESTER RESULT'; ?></h4>
                    <div class="row justify-content-end">
                        <div class="col">
                            <ul id="myTab4" role="tablist" class="nav nav-tabs card-header-tabs nav-material nav-material-white float-left">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="tab1" data-toggle="tab" href="#v-pills-tab1" role="tab" aria-controls="tab1" aria-expanded="true" aria-selected="true">Semester</a>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
                <div id="result" class="card-body result">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1">

                            <table id="basic" class="table table-bordered table-hover">
                                <div class="table-responsive">

                                    <tbody>
                                        <center>
                                            <tr>
                                                <td colspan="6" style="display: table-cell; border: 1px solid #fff;">
                                                    <table width="920">
                                                        <tbody>
                                                            <tr class="">
                                                                <th colspan="2" class=""><?= $student['reg_no']; ?></th>
                                                                <th colspan="5" class=""><?= $student['firstname'] . ' ' . $student['middlename'] . ' ' . $student['lastname']; ?></th>
                                                            </tr>
                                                            <tr class="">
                                                                <th colspan="2" class="">SEMESTER: <?= $semester_name->semester; ?></th>
                                                                <th colspan="5" class="">SESSION: <?= $session_name->session; ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>S/No</th>
                                                                <th>Course code </th>
                                                                <th>Course Title</th>
                                                                <th>Credit</th>
                                                                <!-- <th>Total Score</th> -->
                                                                <th>Grade </th>
                                                                <th>GP</th>
                                                                <th>Remark </th>

                                                            </tr>
                                                            <?php
                                                            $count = 1;
                                                            $total = 0;
                                                            $unit = 0;
                                                            $gp = 0;
                                                            foreach ($mark as $reg) {
                                                                /* $total += $reg['wgp'];
													$unit += $reg['unit'];
													$gp = $total / $unit; */
                                                            ?>
                                                                <tr>

                                                                    <td><?php echo $count ?></td>
                                                                    <td><?php echo $reg['code'] ?></td>
                                                                    <td><?php echo $reg['subject'] ?></td>
                                                                    <td><?php echo $reg['unit'] ?></td>
                                                                    <!-- 	<td><?php echo $reg['total'] ?></td> -->
                                                                    <td><?php echo $reg['grade'] ?></td>
                                                                    <td><?php echo $reg['gp'] ?></td>
                                                                    <td><?php if ($reg['grade'] == "A" || $reg['grade'] == "B" || $reg['grade'] == "C" || $reg['grade'] == "D" || $reg['grade'] == "E") : ?>
                                                                            Pass<?php elseif ($reg['grade'] == "F") : ?> Fail<?php endif; ?></td>
                                                                </tr>
                                                            <?php

                                                                $count++;
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>

                                                    <p style="color:red;">
                                                        <?php $gpa = $total_wgp->wgp / $total_unit->unit; ?>
                                                        Remark: <b><?php if (!empty($co)) {
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
                                                                    } ?><b>
                                                    </p>

                                                </td>

                                            </tr>
                                        </center>
                                        <tr>
                                            <?php if ($semester == 1) :                                # code...
                                            ?>
                                                <th colspan="2" height="8px" style="display: table-cell;border: 1px solid #fff;">
                                                    <p style="font-size:14px; text-align: left;">
                                                        <?php $gpa = $total_wgp->wgp / $total_unit->unit; ?>
                                                        <b>Current</b><br />
                                                        CUR : <?php echo round($total_unit->unit, 2); ?><br />
                                                        CUE : <?php echo round($total_unit_f->unit, 2); ?><br />
                                                        WGP : <?php echo round($total_wgp->wgp, 2); ?><br />
                                                        GPA : <?php echo round($gpa, 2); ?><br />

                                                    </p>
                                                </th>
                                                <th colspan="2" height="8px" style="display: table-cell;border: 1px solid #fff;">
                                                    <p style="font-size:14px; text-align: left;">
                                                        <b>Previous</b><br />
                                                        CUR : <?php echo round($unit, 2); ?><br />
                                                        CUE : <?php echo round($total, 2); ?><br />
                                                        WGP : <?php echo round($total, 2); ?><br />
                                                        GPA : <?php echo round($gp, 2); ?><br />
                                                    </p>
                                                </th>
                                                <th colspan="2" height="8px" style="display: table-cell;border: 1px solid #fff;">
                                                    <p style="font-size:14px; text-align: left;">

                                                        <b>Cummulative</b><br />
                                                        CUR : <?php echo round($total_unit->unit, 2); ?><br />
                                                        CUE : <?php echo round($total_unit_f->unit, 2); ?><br />
                                                        WGP : <?php echo round($total_wgp->wgp, 2); ?><br />
                                                        GPA : <?php echo round($gpa, 2); ?><br />

                                                    </p>
                                                </th>

                                            <?php elseif ($semester == 2) : ?>
                                                <th colspan="2" height="8px" style="display: table-cell;border: 1px solid #fff;">
                                                    <p style="font-size:14px; text-align: left;">
                                                        <?php $gpa = $total_wgp->wgp / $total_unit->unit; ?>
                                                        <b>Current</b><br />
                                                        CUR : <?php echo round($total_unit->unit, 2); ?><br />
                                                        CUE : <?php echo round($total_unit_f->unit, 2); ?><br />
                                                        WGP : <?php echo round($total_wgp->wgp, 2); ?><br />
                                                        GPA : <?php echo round($gpa, 2); ?><br />

                                                    </p>
                                                </th>
                                                <th colspan="2" height="8px" style="display: table-cell;border: 1px solid #fff;">
                                                    <p style="font-size:14px; text-align: left;">
                                                        <?php

                                                        $p_semester = $semester - 1;
                                                        $p_total_unit = $this->exam_model->get_total_units($id, $session, $p_semester);
                                                        $p_total_unit_f = $this->exam_model->get_total_units_f($id, $session, $p_semester);
                                                        $p_total_total = $this->exam_model->get_total_total($id, $session, $p_semester);
                                                        $p_total_gp = $this->exam_model->get_total_gp($id, $session, $p_semester);
                                                        $p_total_wgp = $this->exam_model->get_total_wgp($id, $session, $p_semester);
                                                        $p_gpa = $p_total_wgp->wgp / $p_total_unit->unit;

                                                        ?>
                                                        <b>Previous</b><br />

                                                        CUR : <?php echo round($p_total_unit->unit, 2); ?><br />
                                                        CUE : <?php echo round($p_total_unit_f->unit, 2); ?><br />
                                                        WGP : <?php echo round($p_total_wgp->wgp, 2); ?><br />
                                                        GPA : <?php echo round($p_gpa, 2); ?><br />
                                                    </p>
                                                </th>
                                                <th colspan="2" height="8px" style="display: table-cell;border: 1px solid #fff;">
                                                    <p style="font-size:14px; text-align: left;">
                                                        <?php $tgpa = $gpa + $p_gpa ?>
                                                        <?php $cgp = $tgpa / 2 ?>
                                                        <b>Cummulative</b><br />
                                                        CUR : <?php echo round($total_unit->unit + $p_total_unit->unit, 2); ?><br />
                                                        CUE : <?php echo round($total_unit_f->unit + $p_total_unit_f->unit, 2); ?><br />
                                                        WGP : <?php echo round($total_wgp->wgp + $p_total_wgp->wgp, 2); ?><br />
                                                        CGPA : <?php echo round($cgp, 2); ?><br />

                                                    </p>
                                                </th>

                                            <?php endif; ?>
                                        </tr>

                                    </tbody>


                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>