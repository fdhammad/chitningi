<div class="card shadow">

    <ul class="list-group list-group-flush">

        <?php
        if ($subjects) {
            foreach ($subjects as $key => $value) { ?>
                <li id="list-<?php echo $value['id'] ?>" class="list-group-item" onclick="selectsubject(<?php echo $value['id']; ?>);"><i class="icon icon-pencil text-primary"></i><strong class="s-12"><?= $value['code'] ?></strong> </li>
            <?php }
        } else { ?>
            <li><i class="icon icon-plus text-danger"></i><strong class="s-12 text-red text-center">NO COURSE ASSIGN TO YOU IN THIS SEMESTER</strong> </li>

        <?php     }    ?>


    </ul>
</div>