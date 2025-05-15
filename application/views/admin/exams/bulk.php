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
                        <a class="nav-link active" href="<?php echo base_url(); ?>admin/exams/bulk"><i class="icon icon-plus-circle"></i> Import Marks</a>
                    </li>
                    <li>
                        <a class="nav-link " href="<?php echo base_url(); ?>admin/exams/"><i class="icon icon-plus-circle"></i> Add Marks</a>
                    </li>
                    <li>
                        <a class="nav-link " href="<?php echo base_url(); ?>admin/exams/program_results"><i class="icon icon-home2"></i>Departmental Result</a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?php echo base_url(); ?>admin/exams/course_result"><i class="icon icon-plus-circle"></i> Course Result</a>
                    </li>

                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid animatedParent animateOnce">
        <div class="animated fadeInUpShort">
            <?php if ($this->session->flashdata('toast')) { ?> <?php echo $this->session->flashdata('toast') ?> <?php } ?>
            <div class="row my-3">

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

                            <hr />
                            <?= form_open_multipart(base_url('admin/exams/import_marks'), ['id' => 'importMarksForm']) ?>
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo 'Session'; ?></label> <small class="req"> *</small>
                                        <select id="session_id" name="session_id" class="form-control">
                                            <option value="<?php echo $current_session_id; ?>"><?php echo 'Current Session (' . $current_session_name . ')'; ?></option>
                                            <?php foreach ($sessionlist as $session) : ?>
                                                <option value="<?php echo $session['id'] ?>"><?php echo $session['session'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('session_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo 'Semester'; ?></label> <small class="req"> *</small>
                                        <select id="semester_id" name="semester_id" class="form-control">
                                            <option value="<?php echo $current_semester_id; ?>"><?php echo 'Current Semester (' . $current_semester_name . ')'; ?></option>
                                            <?php foreach ($semesterlist as $semester) : ?>
                                                <option value="<?php echo $semester['id'] ?>"><?php echo $semester['semester'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('semester_id'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo 'Departments'; ?></label> <small class="req"> *</small>
                                        <select id="department_id" name="department_id" class="form-control" required>
                                            <option value=""><?php echo get_phrase('select'); ?></option>
                                            <?php foreach ($schoollist as $school) : ?>
                                                <option value="<?php echo $school['id'] ?>"><?php echo $school['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('department_id'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo 'Courses'; ?></label><small class="req"> *</small>
                                        <select id="course_id" name="course_id" class="form-control">
                                            <option value=""><?php echo get_phrase('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('course_id'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo 'Level'; ?></label> <small class="req"> *</small>
                                        <select id="class_id" name="class_id" class="form-control">
                                            <option value=""><?php echo get_phrase('select'); ?></option>
                                            <?php foreach ($classlist as $class) : ?>
                                                <option value="<?php echo $class['id'] ?>"><?php echo $class['class'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo 'Subjects'; ?></label><small class="req"> *</small>
                                        <select id="subject_id" name="subject_id" class="form-control">
                                            <option value=""><?php echo get_phrase('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('subject_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="file">Upload Excel/CSV File</label>
                                        <input type="file" name="file" id="file" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" id="uploadButton" name="search" value="search_filter" class="btn btn-primary btn-sm pull-right checkbox-toggle">
                                            <i class="icon icon-search"></i> <?php echo get_phrase('search'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?= form_close() ?>


                        </div>
                    </div>

                    <br>
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-md-3">

                                <div id="response"></div>
                            </div>
                            <div class="col-md-9">
                                <div id="result"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>