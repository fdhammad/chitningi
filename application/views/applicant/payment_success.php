<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">


        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <?php if ($this->session->flashdata('toast')) { ?>
                    <?php echo $this->session->flashdata('toast') ?>
                <?php } ?>
                <?php if ($this->session->flashdata('msg')) { ?>
                    <?php echo $this->session->flashdata('msg') ?>
                <?php } ?>
                <?php echo $this->customlib->getCSRF(); ?>
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">

                    <!--begin::Col-->

                    <div class="col-xl-10">
                        <div class="card card-flush pt-3 mb-0">
                            <!--begin::Card header-->
                            <!--end::Notice-->
                            <div class="card-header">

                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Payment Details</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0 fs-6">

                                <!--begin::Seperator-->
                                <div class="separator separator-dashed mb-7"></div>
                                <!--end::Seperator-->
                                <!--begin::Section-->
                                <div class="mb-7">

                                    <!--begin::Details-->
                                    <div class="mb-0">
                                        <!--begin::Plan-->
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Applicant Name</td>
                                                    <td><span class="text-uppercase">
                                                            <?php echo $applicant['firstname'] . ' ' . $applicant['lastname'] . ' ' . $applicant['middlename']; ?>
                                                        </span></td>
                                                </tr>
                                                <tr>
                                                    <td>Applicant Num</td>
                                                    <td><span class="text-uppercase">
                                                            <?php echo $applicant['application_no']; ?>
                                                        </span></td>
                                                </tr>
                                                <tr>
                                                    <td>Amount </td>
                                                    <td>&#8358;<span class="money"><strong>
                                                                <?php echo number_format($amount); ?>
                                                            </strong></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Charges </td>
                                                    <td>&#8358;<span class="money"><strong>
                                                                <?php echo number_format(322.50); ?>
                                                            </strong></span></td>
                                                </tr>

                                                <tr>
                                                    <td>Payment Description </td>
                                                    <td>
                                                        <?php echo $descr ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td>
                                                        <span class="badge badge-success text-capitalize p-3">
                                                            <?php echo $status ?>
                                                        </span>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Transaction Reference</td>
                                                    <td><b style="font-size: 14px;">
                                                            <?php echo $invoice_no; ?>
                                                        </b></td>
                                                </tr>
                                                <tr>
                                                    <td>RRR</td>
                                                    <td><b style="font-size: 20px;">
                                                            <?php echo $RRR; ?>
                                                        </b></td>
                                                </tr>

                                                <tr>

                                                    <td class="">

                                                    </td>
                                                    <td>
                                                        <div class="row mt-4">
                                                            <div class="col-3">

                                                                <a class="btn btn-light-info"
                                                                    href="<?php echo base_url('applicant/dashboard/'); ?>"
                                                                    role="button"><i class="fa fa fa-cross"></i>Goto
                                                                    Dashboard</a>




                                                            </div>
                                                            <div class="col-3">
                                                                <a class="btn btn-success"
                                                                    href="https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/<?= $RRR; ?>/printinvoiceRequest.pdf"
                                                                    role="button" target="_blank"><i
                                                                        class="fa fa fa-print"></i>Remita Receipt</a>
                                                            </div>
                                                            <div class="col-3">
                                                                <a class="btn btn-info"
                                                                    href="<?= base_url('applicant/receipt/' . $RRR) ?>"
                                                                    role="button" target="_blank"><i
                                                                        class="fa fa fa-print"></i>Portal Receipt</a>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <!--end::Details-->
                                </div>
                                <!--end::Section-->

                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                    </div>


                </div>
                <!--end::Row-->


            </div>
            <!--end::Content-->
        </div>
    </div>
</div>