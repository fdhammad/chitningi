$(document).ready(function () {
	var table = $('#basic').DataTable({
		"aaSorting": [],

		rowReorder: {
			selector: 'td:nth-child(2)'
		},
		//pageLength: 100,
		responsive: 'true',
		paging: false,
		dom: "Bfrtip",
		buttons: [

			/* {
				extend: 'copy',
				text: '<i class="icon icon-copy"></i>',
				titleAttr: 'Copy',
				title: $('.download_label').html(),
				exportOptions: {
					columns: 'th:not(:last-child)'
				}
			}, */

			{
				extend: 'excel',
				text: '<i class="icon icon-file-excel-o"></i> Excel',
				titleAttr: 'Excel',

				title: $('.download_label').html(),
				/* exportOptions: {
					columns: 'th:not(:last-child)'
				} */
			},

			/* {
				extend: 'csv',
				text: '<i class="icon icon-file-code-o"></i>',
				titleAttr: 'CSV',
				title: $('.download_label').html(),
				exportOptions: {
					columns: 'th:not(:last-child)'
				}
			}, */

			/* {
				extend: 'pdf',
				text: '<i class="icon icon-file-pdf-o"></i>',
				titleAttr: 'PDF',
				title: $('.download_label').html(),
				exportOptions: {
					columns: 'th:not(:last-child)'

				}
			}, */

			{
				extend: 'print',
				text: '<i class="icon icon-print"></i>Print',
				titleAttr: 'Print',
				title: $('.download_label').html(),
				customize: function (win) {
					$(win.document.body)
						.css('font-size', '10pt');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');

				},
				/* exportOptions: {
					columns: 'th:not(:last-child)'
				} */
			},



			/* 	{
					extend: 'pageLength',
					//text: '<i class="icon-columns"></i>',
					titleAttr: 'Number of Rows',
					className: 'selectTable'
				} */
		]
	});
	/*--nprogress--*/
	/* $('body').show();
	$('.version').text(NProgress.version);
	NProgress.start();
	setTimeout(function () {
		NProgress.done();
		$('.fade').removeClass('out');
	}, 1000); */
	/*--nprogress--*/
});
