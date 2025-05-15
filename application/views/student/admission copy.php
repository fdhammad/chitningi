<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
</head>
<page backtop="7mm" backbottom="7mm" footer="page">
    <?php $system_name = $this->db->get_where('settings', array('key' => 'system_name'))->row()->value; ?>
    <?php $system_address = $this->db->get_where('settings', array('key' => 'address'))->row()->value; ?>
    <?php $system_website = $this->db->get_where('settings', array('key' => 'website'))->row()->value; ?>
    <?php
    $admission_year = $this->db->get_where('settings', array('key' => 'admission_session'))->row()->value;
    $adm_session = $this->db->get_where('sessions', array('id' => $admission_year))->row()->session;
    ?>
    <?php
    if ($student['year'] == "2") {
        $year = 'Two';
    } elseif ($student['year'] == "3") {
        $year = 'Three';
    }
    ?>

    <body>
        <page_header>

            <div id="bg">
                <img class="bg" src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>">
            </div>
            <div class=" mainstudentsessionreport">
                <div class="studentsession-headers">
                    <div class="studentsession-logo">
                        <img src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" alt="" width="120" height="120">
                    </div>
                    <div class="school-name">
                        <h2 style="text-transform: uppercase;"><?= $system_name; ?> </h2>
                        <h4 style="font-size: 12px; line-height: 5px;"><?= $system_address; ?></h4>
                        <h4 style="font-size: 12px; line-height: 5px; color: blue;"><u><?= $system_website; ?></u></h4>
                    </div>

                </div>
        </page_header>
        <div class="studentsession-contents studentsessionreporttable">
            <p style=" font-size: 15px; line-height: 30px;"><b>Ref: <?= $student['reg_no'] ?></b></br></p>
            <p style=" font-size: 15px; line-height: 30px;"><b style="text-transform: uppercase;"> NAME OF STUDENT: <?= $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'] ?></b></br></p>
            <p style=" font-size: 15px; line-height: 30px;"><b> Dear Sir/Madam,</b></br></p>
            </p>

            <div class="">
                <h3 style=" font-size: 16px; line-height: 20px;text-align: center;">OFFER OF PROVISIONAL ADMISSION <?= $adm_session; ?></h3>
            </div>
            <br>
            <div class="class">
                <p style=" font-size: 14px; line-height: 25px;">
                    I am pleased to inform you that you have been offered provisional Admission to pursue <?= $year; ?> (<?= $student['year'] ?>) years academic programs leading to the award of <b><?= $student['course']; ?> (<?= $student['code']; ?>)</b> with effect from <b>2023/2024</b> Academic Session.
                </p>
                <div class="" style=" padding-top:20px;">
                    <b style=" font-size: 14px; line-height: 20px;">The offer is subjected to the following:</b>
                </div>
                <ol type="a">
                    <li style=" font-size: 14px; line-height: 25px;">That you will be registered only after presenting your original credentials for verification and that all particulars provided on your application forms are correct.</li>
                    <li style="font-size: 14px; line-height: 25px;">That at the time of registration, during or after course of your studies, it is discovered that you do not satisfy the minimum requirements prescribed because the qualification you claimed to possess are found to be insufficient, incorrect, or intentionally misquoted or altered or that any other information you provided is false, you will be asked to withdraw/forfeit the certificates as the case may be.</li>
                    <li style="font-size: 14px; line-height: 25px;">That if you provided with accommodation on the campus, you will undertake to be of good behaviour and abide by the rules and regulations of the college. However accommodation is on the basis of first come, first serve.</li>
                    <li style="font-size: 14px; line-height: 25px;">That you are found to be physically and mentally fit by a government or recognized medical officer.</li>
                    <li style="font-size: 14px; line-height: 25px;">That you settle in full all registration charges before you are registered.</li>
                    <li style="font-size: 14px; line-height: 25px;">That you produce evidence of sponsorship from your employer before you are registered (In Service). </li>.<br> <b style="font-size: 14px; line-height: 25px;">N.B: Students indexing fees are not included in the attached registration charges, however students will be asked to make such payment after receiving instructions from their respective regulatory bodies.</b></li>
                </ol>
            </div>
            <div class="" style=" padding-top:20px;">
                <p style=" font-size: 14px; line-height: 20px; text-align:right"><b> Aliyu Hassan</b></p>
                <p style=" font-size: 14px; line-height: 20px; text-align:right"><b>Registrar</b></p>
            </div>

        </div>
        <!-- 	<div class="diidol">
			Powered By Diidol
		</div> -->
        <div id="pageFooter"></div>
        </div>


    </body>

</page>