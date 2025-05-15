<div class="container-fluid">
    <div class="row my-3">
        <div class="col-12 col-xl-12">
            <div class="card shadow">
                <div class="card-header bg-danger text-white text-uppercase text-center download_label">
                    <h4><?php echo  'RESULTS'; ?></h4>
                    <div class="row justify-content-end">
                        <div class="col">
                            <ul id="myTab4" role="tablist" class="nav nav-tabs card-header-tabs nav-material nav-material-white float-left">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="tab1" data-toggle="tab" href="#v-pills-tab1" role="tab" aria-controls="tab1" aria-expanded="true" aria-selected="true">List</a>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1">

                            <table id="basic" class="table table-bordered table-hover">
                                <div class="table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>REG NO</th>
                                            <th>TOTAL</th>
                                            <th>GRADE</th>
                                            <th>GP</th>
                                            <th>REMARK</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if (empty($students)) {
                                        ?>
                                            <tr>
                                                <td colspan="12" class="text-danger text-center"><?php echo get_phrase('no_record_found'); ?></td>
                                            </tr>
                                            <?php
                                        } else {
                                            $count = 1;
                                            foreach ($students as $student) {
                                                $marks = $this->db->get_where('marks', array('student_id' => $student['id'], 'subject_id' => $subject_id, 'semester_id' => $semester_id, 'session_id' => $session_id))->row_array();
                                                if ($marks['grade'] != 'F') {
                                                    $remark = 'PASS';
                                                } else {
                                                    $remark = 'FAIL';
                                                }
                                            ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td><?php echo $student['reg_no']; ?></td>
                                                    <td><?php echo $marks['total']; ?></td>
                                                    <td><?php echo $marks['grade']; ?></td>
                                                    <td><?php echo $marks['gp']; ?></td>
                                                    <td><?php echo $remark; ?></td>
                                                </tr>
                                        <?php }
                                        }; ?>
                                    </tbody>

                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>