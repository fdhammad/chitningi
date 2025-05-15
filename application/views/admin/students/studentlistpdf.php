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
    $course = $this->db->get_where('courses', array('id' => $course_id))->row()->name;
    $level = $this->db->get_where('classes', array('id' => $class_id))->row()->class;

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
                        <h4 style="font-size: 12px; line-height: 8px;"><?= $system_address; ?></h4>
                        <h4 style="font-size: 12px; line-height: 5px; color: blue;"><u><?= $system_website; ?></u></h4>
                    </div>
                    <div class="school-name">
                        <h2 style="text-transform: uppercase;"> STUDENT LIST <?= $adm_session ?> ACADEMIC SESSION </h2>

                        <h3 style="font-size: 14px; line-height: 5px;">COURSE: <?= $course; ?> </h3>
                        <h3 style="font-size: 14px; line-height: 5px;">LEVEL: <?= $level; ?></h3>
                    </div>

                </div>
        </page_header>
        <table width='100'>
            <tbody>

                <tr>
                    <th>S/No</th>
                    <th>REG NO </th>
                    <th>STUDENT NAME</th>
                    <th>STATE</th>

                </tr>

                <?php
                $count = 1;
                if (customCompute($students)) {
                    foreach ($students as $std) {    ?>
                        <tr>
                            <td style="text-align: center;"><?= $count++ ?></td>
                            <td><?= $std['reg_no'] ?></td>
                            <td><?= $std['firstname'] . ' ' . $std['lastname'] . ' ' . $std['middlename'] ?></td>
                            <td style="text-align: center;"><?= $std['state'] ?></td>

                        </tr>

                <?php
                    }
                } ?>



            </tbody>
        </table>
    </body>
</page>