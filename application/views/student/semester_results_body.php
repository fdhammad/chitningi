<?php
$selected_session = $this->db->get_where('sessions', array('id' => $session_id))->row()->session;
$selected_semester = $this->db->get_where('semesters', array('id' => $semester_id))->row()->semester;

if (!empty($marks)) {
?>
    <div class="card">
        <div class="card-header text-center">
            <h4 class=" fw-bold card-title">
                <?= $selected_session . ' / ' . $selected_semester; ?>
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-10 col-md-10 col-sm-12 col-12 mx-auto">
                    <div class="table-responsive mb-4">

                        <div class="float-right">

                        </div>

                        <table width="648" border="0" cellpadding="5" cellspacing="5" class="table table-bordered table-striped">
                            <tr>
                                <th colspan="4" style="font-size: 12px; text-align: left;" scope="row"><?php echo $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'] ?> (<?php echo $student['reg_no'] ?>) - <?php echo $student['course'] ?></th>
                            </tr>

                            <tr>
                                <th colspan="4" style="font-size: 12px" scope="row">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <th width="150" align="left" scope="row">Course Code</th>
                                            <th width="150" align="left" scope="row">Status</th>
                                            <th width="150" align="left" scope="row">Unit</th>
                                            <th width="150" align="left" scope="row">Grade</th>
                                            <th width="150" align="left" scope="row">GP</th>
                                            <th width="150" align="left" scope="row">Unit * GP</th>
                                            <th width="150" align="left" scope="row">Score</th>
                                        </tr>
                                    </table>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4" style="font-size: 12px; font-family: Verdana, Geneva, sans-serif;" scope="row">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <?php
                                        $count = 1;
                                        $total = 0;
                                        $unit = 0;
                                        $gp = 0;
                                        foreach ($marks as $mark) {
                                            $total += $mark['wgp'];
                                            $unit += $mark['unit'];
                                            $gp = $total / $unit;
                                        ?>
                                            <tr>
                                                <td width="150" align="left" scope="row"><strong><?php echo $mark['code']; ?></strong></td>
                                                <td width="150" align="left"><strong><?php echo $mark['status']; ?></strong></td>
                                                <td width="150" align="left"><strong><?php echo $mark['unit']; ?></strong></td>
                                                <td width="150" align="left"><strong><?php echo $mark['grade']; ?></strong></td>
                                                <td width="150" align="left" class="tot"><strong><?php echo $mark['gp']; ?></strong></td>
                                                <td width="150" align="left"><strong><?php echo $mark['wgp']; ?></strong></td>
                                                <td width="150" align="left"><strong><?php echo $mark['total']; ?></strong></td>
                                            </tr>
                                        <?php }; ?>
                                    </table>
                                </th>
                            </tr>
                            <tr>
                                <th width="229" style="font-size: 12px" scope="row">&nbsp;</th>
                                <th width="1" style="font-size: 12px" scope="row">&nbsp;</th>
                                <th style="font-size: 12px" scope="row">&nbsp;</th>
                                <th style="font-size: 12px" scope="row">&nbsp;</th>
                            </tr>
                            <tr>
                                <th colspan="3" bgcolor="#FFFFFF" style="font-size: 12px; color: #000000;" scope="row"><span class="style5">

                                        Cummulative Unit (CU) : <?php echo round($unit, 2); ?><br />
                                        Cummulative Product (CP) : <?php echo round($total, 2); ?><br />
                                        Grade Point Average(GPA) : <?php echo round($gp, 2);
                                                                    /*number_format((float) $gp, 2, '.', '');*/ ?>
                                    </span></span></th>
                                <th width="206" style="font-size: 12px" scope="row">&nbsp;</th>
                            </tr>
                            <tr>
                                <th colspan="4" style="font-size: 12px; color: #F00; text-align: left;" scope="row"><span class="red">Outstanding Course(s):</span>
                                    (<?php if ($co != Null) {
                                            foreach ($co as $value) {
                                                echo $value['code'] . ',';
                                            }
                                        } else {
                                            echo 'None';
                                        }; ?><b>)</th>
                            </tr>
                            <tr>
                                <th colspan="3" style="font-size: 9px; color: #F00; font-family: 'Comic Sans MS', cursive; text-align: center;" scope="row"><span style="font-size: 12px; color: #FFF;">
                                    </span></th>
                                <th style="font-size: 9px; color: #F00; font-family: 'Comic Sans MS', cursive; text-align: center;" scope="row">&nbsp;</th>
                            </tr>
                            <tr>
                                <th colspan="3" style="font-size: 10px; color: #00F; font-family: 'Comic Sans MS', cursive; text-align: center;" scope="row">Note: More results may still be awaited! Also, this is a provisional result subject to Senate Approval. Thanks</th>
                                <th style="font-size: 9px; color: #F00; font-family: 'Comic Sans MS', cursive; text-align: center;" scope="row">&nbsp;</th>
                            </tr>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
<?php
} else {
?>
    <div class="card">
        <div class="card-header">
            <h4 class=" fw-bold card-title text-center">
                <?= $selected_session . ' / ' . $selected_semester; ?>
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8 col-md-8 col-sm-12 col-12 mx-auto">

                    <table width="648" border="0" cellpadding="5" cellspacing="5" class="table table-bordered table-striped">
                        <tr>
                            <th colspan="4" style="font-size: 12px; text-align: center; color:red" scope="row">No Record Found</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php };
?>