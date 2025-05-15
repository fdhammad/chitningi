<div class="container-fluid">
    <div class="row my-3">
        <div class="col-md-12">
            <div class="card my-3 no-b shadow">
                <H4 class="card-header"><B>General Transactions History</B></H4>
                <div class="card-body">
                    <div class="table-responsive">
                        <button type="button" id="refresh" class="btn btn-outline-primary"> <i class="icon icon-refresh" aria-hidden="true"></i> Refresh</button>


                        <table id="basic" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo 'S/N'; ?></th>
                                    <th><?php echo 'RRR '; ?></th>
                                    <th><?php echo 'Transaction No'; ?></th>
                                    <th><?php echo 'Reg No'; ?></th>
                                    <th><?php echo site_phrase('name'); ?></th>

                                    <th><?php echo 'Date'; ?></th>
                                    <th><?php echo site_phrase('amount'); ?></th>
                                    <th><?php echo 'Status'; ?></th>
                                    <th class="text text-right"><?php echo 'Action'; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $amount = 0;
                                $count = 1;

                                foreach ($feeList as $feeList) {

                                    $a = $feeList['receipt'];
                                    $b = array('-', '-');
                                    $c = array(
                                        4,
                                        8
                                    );

                                    for ($i = count($c) - 1; $i >= 0; $i--) {
                                        $a = substr_replace($a, $b[$i], $c[$i], 0);
                                    }
                                ?>
                                    <tr id="<?= $feeList['receipt'] ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>
                                            <?php echo $a; ?>
                                        </td>
                                        <td>
                                            <?php echo $feeList['txn']; ?>
                                        </td>
                                        <td>
                                            <?php echo $feeList['reg_no']; ?>
                                        </td>

                                        <td>
                                            <?php echo $feeList['firstname'] . " " . $feeList['lastname'] . " " . $feeList['middlename']; ?>
                                        </td>

                                        <td>
                                            <?php echo $feeList['date']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $amount = number_format($feeList['amount']);
                                            echo $amount;
                                            ?>

                                        </td>


                                        <td><?php if ($feeList['status'] == "paid") { ?><span class="badge badge-success">Paid</span><?php } else { ?><span class="badge badge-warning"><?php echo $feeList['status']; ?></span><?php }; ?></td>
                                        <td class="text text-right">
                                            <?php if ($feeList['status'] == 'paid') { ?>
                                            <?php } else { ?>
                                                <form action="<?php echo base_url(); ?>admin/payments/check_payment_status/<?php echo $feeList['student_id']; ?>" method="POST">

                                                    <input id="RRR" name="RRR" value="<?php echo $feeList['receipt']; ?>" type="hidden">

                                                    <input type="submit" class="btn btn-sm r-3 btn-info" name="submit_btn" value="Check Status">
                                                </form>
                                            <?php

                                            }; ?>

                    </div>
                    </td>

                    </tr>
                <?php
                                }
                ?>
                </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>