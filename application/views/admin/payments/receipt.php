<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$a = $deposit['receipt'];
$b = array('-', '-');
$c = array(
    4, 8
);

for ($i = count($c) - 1; $i >= 0; $i--) {
    $a = substr_replace($a, $b[$i], $c[$i], 0);
}
?>

<style>
    .invoice-ribbon {
        width: 85px;
        height: 88px;
        overflow: hidden;
        position: absolute;
        top: -1px;
        right: 14px;
    }

    .ribbon-inner {
        text-align: center;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        position: relative;
        padding: 7px 0;
        left: -5px;
        top: 11px;
        width: 120px;
        background-color: #66c591;
        font-size: 15px;
        color: #fff;
    }

    .ribbon-inner:before,
    .ribbon-inner:after {
        content: "";
        position: absolute;
    }

    .ribbon-inner:before {
        left: 0;
    }

    .ribbon-inner:after {
        right: 0;
    }
</style>
<div class="page has-sidebar-left">
    <header class="my-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="s-24">
                        <i class="icon-pages"></i>
                        Invoice
                    </h1>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="invoice white shadow">


            <div class="p-5">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <div class="invoice-ribbon">
                            <?php if ($deposit['status'] == 'paid' || $deposit['status'] == 'PAID') { ?>
                                <div class="ribbon-inner" style="background-color: #66c591;">PAID</div>
                            <?php } else { ?>
                                <div class="ribbon-inner" style="background-color: red;">UNPAID</div>
                            <?php } ?>
                        </div>
                        <img class="w-120px mb-4" src="<?php echo base_url(); ?>assets/img/logo/logo.png" alt="">

                        <div class="float-right">
                            <?php if ($deposit['status'] == 'paid' || $deposit['status'] == 'PAID') {
                                echo '<h1>PAYMENT RECEIPT</h1>';
                            } else {
                                echo '<h1>PAYMENT INVOICE</h1>';
                                echo '<p style ="font-size:12; font-color: red;">This is an invoice not a receipt</p>';
                            }
                            ?>
                            <h2>RRR NO: <b><?php echo $a; ?></b></h2><br>

                            <table>
                                <tr>
                                    <td class="font-weight-normal">Date:</td>
                                    <td><?php echo date('d-m-Y'); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-normal">Order ID:</td>
                                    <td><?php echo $deposit['txn']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-normal">Payment Due: &nbsp; &nbsp; &nbsp;</td>
                                    <td> <?php echo $deposit['date']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-normal">Status:</td>
                                    <td> <?php if ($deposit['status'] == 'paid') { ?>

                                            <span class="badge badge-success text-uppercase"><?php echo $deposit['status']; ?></span> <?php } else { ?>
                                            <span class="badge badge-warning text-uppercase"><?php echo $deposit['status']; ?></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>

                        </div>

                    </div>
                    <!-- /.col -->
                </div>

                <!-- info row -->
                <div class="row my-3 ">
                    <div class="col-sm-4">
                        From
                        <address>
                            <h4><strong><?php echo $student['firstname'] . " " . $student['middlename'] . " " . $student['lastname']; ?></strong></h4>
                            <h5><b>REG NO :</b> <b><?php echo $student['reg_no']; ?></b></h5>
                            <b>Level :</b> <?php echo $student['class']; ?><br>
                            <b>Course :</b> <?php echo $student['course']; ?><br>
                            <b>Phone: <?php echo $student['mobileno']; ?></b><br>
                            <b>State: <?php echo $student['state']; ?></b>
                        </address>
                    </div>

                    <!-- /.col -->
                    <div class="col-sm-4">

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <?php if ($student['school_id'] == 5 || $student['school_id'] == 4) {
                    $school = 'SCIENCE';
                } else {
                    $school = 'ART';
                };
                if ($student['student_type'] == 'Indigene') {
                    $indigene = 'INDIGENE';
                } else {
                    $indigene = 'NON-INDIGENE';
                }; ?>
                <!-- Table row -->
                <div class="row my-3">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Description</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <h4>REGISTRATION FEE FOR <?php echo $school; ?> STUDENTS - <?php echo $indigene; ?> </h4>
                                    </td>
                                    <td>
                                        <h4><?php echo $currency_symbol . " " . number_format($amount); ?></h4>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-6">
                        <p class="lead">Payment Methods:</p>
                        <img src="<?php echo base_url(); ?>assets/img/logo/remita.png" alt="Remita">
                        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                            This <?php if ($deposit['status'] == 'paid' || $deposit['status'] == 'PAID') {
                                        echo 'PAYMENT RECEIPT';
                                    } else {
                                        echo 'PAYMENT INVOICE';
                                    }
                                    ?> is Generated By <?php echo $this->customlib->getSchoolName(); ?> Student Portal.
                        </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <p class="lead">Amount Due <?php echo $deposit['date']; ?></p>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>
                                            <h4>Total Paid:<h4>
                                        </th>
                                        <td>
                                            <h4><?php echo $currency_symbol . " " . number_format($deposit['amount']); ?></h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-12">
                        <form method="post" action="<?php echo base_url('admin/student/invoice_form') ?>">
                            <input type="hidden" id="receipt" name="receipt" value="<?php echo $deposit['receipt']; ?>">
                            <button id="form" class="btn btn-primary btn-lg float-right mr-2 form" type="button">
                                <i class="icon icon-cloud-download"></i> Generate PDF
                            </button>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- Right Sidebar -->

<script src="<?php echo base_url(); ?>assets/js/app.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.form', function() {
            var receipt = $('#receipt').val();
            $.ajax({
                url: '<?php echo site_url("admin/student/invoice_form") ?>',
                type: 'post',
                dataType: "html",
                data: {
                    //'data': JSON,
                    'receipt': receipt,
                },
                success: function(response) {
                    //alert(response)
                    Popup(response);

                }
            });

        });
    });
</script>


<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';

    function Popup(data) {

        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";

        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'ascoe/dist/css/idcard.css">');

        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function() {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);


        return true;
    }
</script>