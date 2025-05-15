<div class="page has-sidebar-left  height-full">
    <header class="red accent-3 relative">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-database"></i>
                        <?php echo $page_title; ?>
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="<?php echo base_url(); ?>admin/student/search"><i class="icon icon-home2"></i>Search Students</a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?php echo base_url(); ?>admin/student/create"><i class="icon icon-plus-circle"></i> Add New Student</a>
                    </li>
                    <li>
                        <a class="nav-link active" href="<?php echo base_url(); ?>admin/student/bulk"><i class="icon icon-documents3"></i>Bulk Upload</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid animatedParent animateOnce">
        <div class="animated fadeInUpShort">
            <?php if ($this->session->flashdata('toast')) { ?> <?php echo $this->session->flashdata('toast') ?> <?php } ?>
            <div class="row my-3">
                <div id="response"></div>
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('msg')) { ?> <?php echo $this->session->flashdata('msg') ?> <?php } ?>
                    <div id="message" class=""></div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="float-right">
                                    <a href="<?php echo site_url('admin/student/exportformat') ?>">
                                        <button class="btn btn-danger btn-sm float-right"><i class="fa fa-download"></i> <?php echo get_phrase('dl_sample_import'); ?></button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card-body">
                                <br />
                                1. Your CSV data should be in the format below. The first line of your CSV file should be the column headers as in the table example. Also make sure that your file is UTF-8 to avoid unnecessary encoding problems.<br />
                                2. Duplicate "College Number" (unique) rows will not be imported.<br />
                                3. For student "Gender" use Male, Female value.<br />


                                <hr />
                            </div>
                            <!--  <div class="card-body table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="sampledata">
                                    <thead>
                                        <tr>
                                            <?php foreach ($fields as $key => $value) {

                                                if ($value == 'reg_no') {
                                                    $value = "reg_no";
                                                }
                                                if ($value == 'jamb_no') {
                                                    $value = "jamb_no";
                                                }
                                                if ($value == 'firstname') {
                                                    $value = "first_name";
                                                }
                                                if ($value == 'lastname') {
                                                    $value = "last_name";
                                                }
                                                if ($value == 'middlename') {
                                                    $value = "middlename";
                                                }
                                                if ($value == 'gender') {
                                                    $value = "gender";
                                                }
                                                if ($value == 'state') {
                                                    $value = "state";
                                                }
                                                if ($value == 'mobileno') {
                                                    $value = "mobile_no";
                                                }
                                                $add = "";
                                                if (($value == "reg_no")  || ($value == "jamb_no") || ($value == "firstname") || ($value == "lastname") || ($value == "middlename")  || ($value == "gender") || ($value == "state")  || ($value == "mobileno")) {
                                                    $add = "<span class=text-red>*</span>";
                                                }
                                            ?>
                                                <th><?php echo $add . "<span>" . get_phrase($value) . "</span>"; ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php foreach ($fields as $key => $value) {
                                            ?>
                                                <td><?php echo "Sample Data" ?></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>

                                </table>
                            </div> -->
                            <hr />
                            <form method="POST" id="uploadForm" class="col-md-12 ajaxSubmit" action="<?php echo base_url('admin/students/add_excel'); ?>" enctype="multipart/form-data">
                                <div class="card-body">
                                    <?php echo $this->customlib->getCSRF(); ?>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><?php echo get_phrase('department'); ?></label> <small class="req"> *</small>
                                                <select autofocus="" id="department_id" name="department_id" class="form-control">
                                                    <option value=""><?php echo get_phrase('select'); ?></option>
                                                    <?php
                                                    foreach ($departmentlist as $department) {
                                                    ?>
                                                        <option value="<?php echo $department['id'] ?>" <?php if (set_value('department_id') == $department['id']) echo "selected=selected" ?>><?php echo $department['name'] ?></option>
                                                    <?php

                                                    }
                                                    ?>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('department_id'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><?php echo 'Course'; ?></label><small class="req"> *</small>
                                                <select id="course_id" name="course_id" class="form-control">
                                                    <option value=""><?php echo get_phrase('select'); ?></option>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('course_id'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo 'Level'; ?></label><small class="req"> *</small>
                                                <select autofocus="" id="class_id" name="class_id" class="form-control">
                                                    <option value=""><?php echo get_phrase('select'); ?></option>
                                                    <option value="0"><?php echo 'Pre-Weeding'; ?></option>
                                                    <?php
                                                    foreach ($classlist as $class) {
                                                    ?>
                                                        <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
                                                    <?php
                                                        // $count++;
                                                    }
                                                    ?>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile"><?php echo get_phrase('select_csv_file'); ?></label><small class="req"> *</small>
                                                <div><input class="filestyle form-control" type='file' name='file' id="file" required accept=".csv" size='20' />
                                                    <span class="text-danger"><?php echo form_error('file'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br>
                                            <br>
                                            <button type="submit" id="import" class="btn btn-danger"><?php echo get_phrase('import_student'); ?></button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#sampledata").DataTable({
            searching: false,
            ordering: false,
            paging: false,
            bSort: false,
            info: false,
        });

    });
</script>