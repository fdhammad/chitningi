<div class="page  has-sidebar-left height-full">
    <header class="red relative">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-cogs"></i>
                        System Switches
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
                    <li>
                        <a class="nav-link active" id="v-pills-all-tab" data-toggle="pill" href="#v-pills-all" role="tab" aria-controls="v-pills-all"><i class="icon icon-cogs"></i>All Switches</a>
                    </li>

                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <?php if ($this->session->flashdata('toast')) { ?>
            <?php echo $this->session->flashdata('toast') ?>
        <?php } ?>
        <?php if ($this->session->flashdata('msg')) { ?>
            <?php echo $this->session->flashdata('msg') ?>
        <?php } ?>
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header red text-white">
                        <h5 class="card-title">Switches</h5>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover " cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo get_phrase('name'); ?></th>

                                    <th class="text-right"><?php echo get_phrase('action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!empty($switchlist)) {
                                    $count = 1;
                                    foreach ($switchlist as $switch) {
                                ?>
                                        <tr>
                                            <td><?php echo $switch['name']; ?></td>


                                            <td>
                                                <div class="material-switch float-right">

                                                    <input id="student<?php echo $switch['id'] ?>" name="someSwitchOption001" type="checkbox" data-role="student" class="chk" data-rowid="<?php echo $switch['id'] ?>" value="checked" <?php if ($switch['is_active'] == 1) echo "checked='checked'"; ?> />
                                                    <label for="student<?php echo $switch['id'] ?>" class="bg-success"></label>
                                                </div>

                                            </td>
                                        </tr>
                                <?php
                                        $count++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery  -->
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', '.chk', function() {
            var checked = $(this).is(':checked');
            var rowid = $(this).data('rowid');
            var role = $(this).data('role');
            if (checked) {
                if (!confirm('Are you sure you active switch?')) {
                    $(this).removeAttr('checked');
                } else {
                    var status = "1";
                    changeStatus(rowid, status, role);


                }
            } else if (!confirm('Are you sure you deactive switch?')) {
                $(this).prop("checked", true);
            } else {
                var status = "0";
                changeStatus(rowid, status, role);

            }
        });
    });

    function changeStatus(rowid, status, role) {


        var base_url = '<?php echo base_url() ?>';

        $.ajax({
            type: "POST",
            url: base_url + "admin/switches/changeStatus",
            data: {
                'id': rowid,
                'status': status,
                'role': role
            },
            dataType: "json",
            success: function(data) {
                data.toast;
                window.location.reload(true);
            }
        });
    }
</script>