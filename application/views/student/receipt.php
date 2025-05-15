<!DOCTYPE html>
<html lang="en">
<page backtop="7mm" backbottom="7mm" footer="page">

	<body>
		<div id="bg">
			<img class="bg" src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>">
		</div>
		<!-- <div class="invoice-ribbon">
			<?php if ($payment['status'] == 'paid' || $payment['status'] == 'PAID') { ?>
				<div class="ribbon-inner" style="background-color: #66c591;">PAID</div>
			<?php } else { ?>
				<div class="ribbon-inner" style="background-color: red;">UNPAID</div>
			<?php } ?>
		</div> -->
		<div class="invoice-box">
			<table>
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" alt="College logo" height="100px" />
									<h6 style="text-transform: uppercase;"> <?= get_settings('system_name'); ?></h6>
								</td>

								<td>
									<?php
									$a = $rrr;
									$b = array('-', '-');
									$c = array(
										4, 8
									);

									for ($i = count($c) - 1; $i >= 0; $i--) {
										$a = substr_replace($a, $b[$i], $c[$i], 0);
									}
									?>
									<span class="rrr">RRR: <?= $a ?></span><br />
									Transaction No: <?= $payment['txn'] ?><br />
									Payment Date: <?= $payment['date'] ?><br />
									Status: <?php if ($payment['status'] == 'paid') { ?>

										<span class="badge"><b style="text-transform:uppercase; font-size:16; background-color: green;"><?php echo $payment['status']; ?></b></span> <?php } else { ?>
										<span class="badge"><b style="text-transform:uppercase; font-size:16; background-color: red;"><?php echo $payment['status']; ?></b></span>
									<?php } ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									<p class="text-capitalize">NAME: <?php echo $payment['firstname'] . " " . $payment['lastname'] . " " . $payment['middlename']; ?></p>
									<p class="text-capitalize">PHONE NO: <?php echo $payment['phone']; ?></p>
									<p class="text-capitalize">EMAIL: <?php echo $payment['email']; ?></p>
									<p class="text-capitalize">COURSE: <?php echo $payment['course']; ?></p>

								</td>

								<td>

								</td>
							</tr>
						</table>
					</td>
				</tr>

				<?php if ($payment['type'] == 'semester') { ?>
					<table>
						<thead>
							<tr class="heading">
								<td>S/N</td>
								<td style="text-align: left;">Item</td>
								<td style="text-align: right;">Amount</td>
							</tr>
						</thead>
						<tbody>

							<?php
							$itemlist = $this->db->get_where('payment_items', array('payment_type' => 'semester', 'course_id' => $payment['course_id'], 'class_id' => $payment['class_id'], 'indigene' => $payment['student_type'], 'semester_id' => $payment['semester_id']))->result();

							$num = 1;
							foreach ($itemlist as $value) { ?>
								<tr class="item" style="margin: 0px; padding:0px;">
									<td class="">
										<P><?= $num++ ?>.</P>
									</td>
									<td style="text-align: left;" class="">

										<P style="text-align: left;"><?= $value->name ?></P>
									</td>
									<td style="text-align: right;" class="">
										<P>&#8358; <?= number_format($value->amount) ?></P>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>

				<?php } else { ?>
					<tr class="heading">
						<td>Item</td>

						<td>Price</td>
					</tr>
					<tr class="item">
						<td><?= $payment['descr'] ?></td>

						<td>&#8358; <?= number_format($payment['amount']) ?></td>
					</tr>
					<tr class="item">
						<td><?= 'Remita Charges' ?></td>

						<td>&#8358; <?= number_format(322.50) ?></td>
					</tr>
				<?php } ?>


				<tr class="total">
					<td></td>

					<td>Total: &#8358; <?= number_format($payment['amount'] + 322.50) ?></td>
				</tr>
				<br>
				<tr class="heading">
					<td>Payment Method</td>

					<td> #</td>
				</tr>

				<tr class="details">
					<td style="text-transform: uppercase;"><img src="<?php echo base_url(); ?>assets/img/logo/remita.png" height="60px" width="280px" alt="Remita">
					</td>

					<td style="text-transform: uppercase;"><?= $payment['method'] ?></td>
				</tr>
			</table>
		</div>
	</body>
</page>

</html>