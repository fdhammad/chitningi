<div class="card">

    <div class="col-md-12">
        <div class="card-body">
            <?= form_open_multipart(base_url('admin/exams/import_marks'), ['id' => 'importMarksForm']) ?>
            <input type="hidden" name="course_id" value="<?php echo $subject_id; ?>"> <!-- Assuming $subject_id is the course_id -->
            <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
            <input type="hidden" name="semester_id" value="<?php echo $semester_id; ?>">
            <input type="hidden" name="session_id" value="<?php echo $session_id; ?>">
            <div class="form-group">
                <label for="file">Upload Excel/CSV File</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="button" id="uploadButton" class="btn btn-primary">Upload</button>
            <?= form_close() ?>
        </div>
    </div>
</div>