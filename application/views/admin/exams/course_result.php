<style>
    .loader {
        border: 4px solid #f3f3f3;
        /* Light grey */
        border-top: 4px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div class="page has-sidebar-left height-full">
    <header class="danger relative">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-list"></i>
                        <?= $page_title; ?>
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
                    <li>
                        <a class="nav-link active" href="<?php echo base_url(); ?>admin/exams/course_result"><i class="icon icon-plus-circle"></i> Course Result</a>
                    </li>
                    <li>
                        <a class="nav-link " href="<?php echo base_url(); ?>admin/exams/program_results"><i class="icon icon-home2"></i>Departmental Result</a>
                    </li>

                    <li>
                        <a class="nav-link " href="<?php echo base_url(); ?>admin/exams/"><i class="icon icon-plus-circle"></i> Add Marks</a>
                    </li>


                    <li>
                        <a class="nav-link" href="<?php echo base_url(); ?>admin/exams/bulk"><i class="icon icon-plus-circle"></i> Import Marks</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <?php if ($this->session->flashdata('toast')) { ?>
            <?php echo $this->session->flashdata('toast') ?>
        <?php } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><i class="icon icon-search"></i> <?php echo get_phrase('select_criteria'); ?>
                            <div class="float-right">
                                <a href="<?php echo site_url('admin/exams/') ?>" class="btn btn-danger btn-sm text-white"><i class="icon icon-upload"></i> <?php echo 'Add Marks'; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?= form_open_multipart(base_url('admin/exams/import_marks'), ['id' => 'importMarksForm']) ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo 'Session'; ?></label> <small class="req"> *</small>
                                            <select autofocus="" id="session_id" name="session_id" class="form-control">
                                                <option value="<?php echo $current_session_id; ?>"><?php echo 'Current Session (' . $current_session_name . ')'; ?></option>
                                                <?php foreach ($sessionlist as $session) { ?>
                                                    <option value="<?php echo $session['id'] ?>" <?php if (set_value('session_id') == $session['id']) echo "selected=selected" ?>><?php echo $session['session'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('session_id'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo 'Semester'; ?></label> <small class="req"> *</small>
                                            <select autofocus="" id="semester_id" name="semester_id" class="form-control">
                                                <option value="<?php echo $current_semester_id; ?>"><?php echo 'Current Semester (' . $current_semester_name . ')'; ?></option>
                                                <?php foreach ($semesterlist as $semester) { ?>
                                                    <option value="<?php echo $semester['id'] ?>" <?php if (set_value('semester_id') == $semester['id']) echo "selected=selected" ?>><?php echo $semester['semester'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('semester_id'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><?php echo 'Departments'; ?></label> <small class="req"> *</small>
                                            <select autofocus="" id="department_id" name="department_id" class="form-control" required>
                                                <option value=""><?php echo get_phrase('select'); ?></option>
                                                <?php foreach ($schoollist as $school) { ?>
                                                    <option value="<?php echo $school['id'] ?>" <?php if (set_value('department_id') == $school['id']) echo "selected=selected" ?>><?php echo $school['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('department_id'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><?php echo 'Courses'; ?></label><small class="req"> *</small>
                                            <select autofocus="" id="course_id" name="course_id" class="form-control">
                                                <option value=""><?php echo get_phrase('select'); ?></option>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('course_id'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><?php echo 'Level'; ?></label> <small class="req"> *</small>
                                            <select autofocus="" id="class_id" name="class_id" class="form-control">
                                                <option value=""><?php echo get_phrase('select'); ?></option>
                                                <?php foreach ($classlist as $class) { ?>
                                                    <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="button" id="show" name="search" value="search_filter" class="btn btn-danger btn-sm pull-right checkbox-toggle">
                                                <i class="icon icon-search"></i> <?php echo get_phrase('search'); ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
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