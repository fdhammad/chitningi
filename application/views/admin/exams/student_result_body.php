<style>
    .highlight {
        background-color: yellow;
    }

    .list-group-item {
        cursor: pointer;
    }

    .list-group-item:hover {
        background-color: #f0f0f0;
    }

    .addRow {
        background-color: #ed5564;
        color: white;
    }
</style>

<div class="card shadow">
    <div class="card-header">
        <input type="text" id="studentSearch" placeholder="Search student..." class="form-control">
    </div>
    <ul class="list-group list-group-flush" id="studentList">
        <?php if ($students) {
            foreach ($students as $key => $value) { ?>
                <li id="list-<?php echo $value['id'] ?>" class="list-group-item" onclick="selectstudent(<?php echo $value['id']; ?>);">
                    <i class="icon icon-person text-danger"></i>
                    <strong class="s-12"><?= $value['reg_no'] ?></strong>
                </li>
            <?php }
        } else { ?>
            <li><i class="icon icon-plus text-danger"></i>
                <strong class="s-12 text-red text-center">NO STUDENT REGISTERED TO COURSE IN THIS SEMESTER YET</strong>
            </li>
        <?php } ?>
    </ul>
</div>