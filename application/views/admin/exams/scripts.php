<?php if ($page_name == 'exams/index') { ?>

    <script type="text/javascript">
        $(document).ready(function() {
            var department_id = $('#department_id').val();
            var initial_course_id = '<?php echo set_value('course_id') ?>';

            // Function to populate courses based on department
            function getSectionByClass(department_id, course_id) {
                if (department_id !== "") {
                    var base_url = '<?php echo base_url() ?>';
                    var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
                    $.ajax({
                        type: "GET",
                        url: base_url + "admin/exams/getByDepartment",
                        data: {
                            'department_id': department_id
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $('#course_id').addClass('dropdownloading');
                        },
                        success: function(data) {
                            console.log("Courses data received:", data); // Debug: Check courses data
                            $.each(data, function(i, obj) {
                                var sel = (course_id == obj.id) ? "selected" : "";
                                div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
                            });
                            $('#course_id').html(div_data); // Set the options to the dropdown
                        },
                        complete: function() {
                            $('#course_id').removeClass('dropdownloading');
                        }
                    });
                }
            }

            getSectionByClass(department_id, initial_course_id);

            // When department changes, update the course list
            $(document).on('change', '#department_id', function(e) {
                var department_id = $(this).val();
                getSectionByClass(department_id, "");
            });

            $("#show").click(function() {
                var session_id = $('#session_id').val();
                var course_id = $('#course_id').val();
                var semester_id = $('#semester_id').val();
                var class_id = $('#class_id').val();
                var department_id = $('#department_id').val();

                // Debug: Check values before AJAX call
                console.log("Session ID:", session_id);
                console.log("Course ID before AJAX:", course_id);
                console.log("Semester ID:", semester_id);
                console.log("Class ID:", class_id);
                console.log("Department ID:", department_id);
                // Disable button and show loader
                $("#show").attr("disabled", true);
                $("#show").html('<div class="loader"></div> Loading...');
                if (course_id === "" || course_id === undefined) {
                    alert("Please select a course");
                    return;
                }

                $.ajax({
                    url: '<?php echo base_url('admin/exams/mark_body'); ?>',
                    type: 'post',
                    data: {
                        'session_id': session_id,
                        'semester_id': semester_id,
                        'class_id': class_id,
                        'department_id': department_id,
                        'course_id': course_id
                    },
                    beforeSend: function() {
                        console.log("Before sending AJAX request, Course ID:", course_id);
                        $("#response").hide();
                    },
                    success: function(data) {
                        var response = JSON.parse(data);
                        $("#response").show();
                        renderLoder(response);
                    },
                    complete: function() {
                        // Re-enable button and remove loader
                        $("#show").attr("disabled", false);
                        $("#show").html('<i class="icon icon-search"></i> <?php echo get_phrase('search'); ?>');
                    }
                });
            });
        });


        function getSectionByClass(department_id, course_id) {
            if (department_id != "" && course_id != "") {
                var base_url = '<?php echo base_url() ?>';
                var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
                $.ajax({
                    type: "GET",
                    url: base_url + "admin/exams/getByDepartment",
                    data: {
                        'department_id': department_id
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#course_id').addClass('dropdownloading');
                    },
                    success: function(data) {
                        console.log("getSectionByClass data:", data); // Debug: Check courses data
                        $.each(data, function(i, obj) {
                            var sel = "";
                            if (course_id == obj.id) {
                                sel = "selected";
                            }
                            div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
                        });
                        $('#course_id').append(div_data);
                    },
                    complete: function() {
                        $('#course_id').removeClass('dropdownloading');
                    }
                });
            }
        }


        function renderLoder(response) {
            $('#response').html(response.render);

        }

        function selectsubject(subject_id) {
            var session_id = $('#session_id').val();
            var semester_id = $('#semester_id').val();
            var department_id = $('#department_id').val();
            console.log(session_id);
            console.log(semester_id);
            console.log(subject_id);
            console.log(department_id);
            $(".list-group-item").removeClass("addRow"); // remove active class from all
            $('#list-' + subject_id).addClass("addRow"); // add active class to clicked element

            $.ajax({
                url: '<?php echo base_url('admin/exams/student_mark_body'); ?>',
                type: 'post',
                data: {
                    'session_id': session_id,
                    'semester_id': semester_id,
                    'subject_id': subject_id,
                    'department_id': department_id,

                },
                beforeSend: function() {
                    // Show image container
                    $("#result").hide();
                    $("#loader").show();

                },
                success: function(data) {

                    var response = JSON.parse(data);
                    $("#loader").hide();
                    $("#result").show();
                    renderMark(response);
                },
                complete: function(data) {

                    // Hide image container
                    //$("#loader").hide();
                    //$("#result").show();
                    //$("#v-pills-tabContent").hide();
                }
            });

            function renderMark(response) {
                $('#result').html(response.render);
                $(document).on("keyup", ".mark", function() {
                    if (parseInt($(this).val())) {
                        var val = parseInt($(this).val());
                        var minMark = parseInt($(this).attr('min'));
                        var maxMark = parseInt($(this).attr('max'));
                        if (minMark > val || val > maxMark) {
                            $(this).val('');
                        }
                    } else {
                        if ($(this).val() == '0') {} else {
                            $(this).val('');
                        }
                    }
                });

                $(".mark").on('keyup change', calculateSum);

            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.attendance', function() {
                var subject_id = $('#subject_id').val();
                var department_id = $('#department_id').val();
                //var class_id = $('#class_id').val();
                $.ajax({
                    url: '<?php echo site_url("admin/exams/attendance") ?>',
                    type: 'post',
                    dataType: "html",
                    data: {
                        //'data': JSON,
                        'subject_id': subject_id,
                        'department_id': department_id,
                        //'class_id': class_id,
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
        $(document).ready(function() {
            $(document).on('click', '.addmark', function() {
                var array_to_print = [];
                var $input = $(this);
                var $row = $input.closest('tr');
                var sum = 0;
                var id = $('#id').val();
                var student_id = $('#student_id').val();
                var class_id = $('#class_id').val();
                var session_id = $('#session_id').val();
                var semester_id = $('#semester_id').val();
                var department_id = $('#department_id').val();
                var school_id = $('#school_id').val();
                var subject_id = $('#subject_id').val();
                var ca = $('#ca').val();
                var exam = $('#exam').val();
                var total = $('#total').val();
                var grade = $('#grade').val();
                var gp = $('#gp').val();
                var wgp = $('#wgp').val();
                var $input = $(this);
                var $row = $input.closest('tr');
                $.each($(".tr"), function() {
                    //		var subjectId = $(this).data('subject_id');


                    $row.find(".mark").each(function() {
                        sum += parseFloat(this.value) || 0;
                    });

                    $row.find(".total").val(sum);
                    item = {}
                    item["id"] = id;
                    item["student_id"] = student_id;
                    item["class_id"] = class_id;
                    item["session_id"] = session_id;
                    item["semester_id"] = semester_id;
                    item["department_id"] = department_id;
                    item["school_id"] = school_id;
                    item["ca"] = ca;
                    item["exam"] = exam;
                    item["total"] = total;
                    item["grade"] = grade;
                    item["gp"] = gp;
                    item["wgp"] = wgp;
                    item["subject_id"] = subject_id;
                    array_to_print.push(item);

                    console.log()
                });
                /* if (array_to_print.length == 0) {
                	alert('No Course Selected');
                } else { */
                $.ajax({
                    url: '<?php echo site_url("admin/exams/markstore") ?>',
                    type: 'post',
                    dataType: "html",
                    data: {
                        'data': JSON.stringify(array_to_print),
                        /* 	'student_id': student_id,
                        	'class_id': class_id,
                        	'session_id': session_id,
                        	'semester_id': semester_id,
                        	'school_id': school_id,
                        	'course_id': course_id */

                    },
                    success: function(response) {
                        //alert('Course Added Successfully');
                        console.log(response);
                        //window.location.reload();
                    }
                });
                //	}
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
<?php } elseif ($page_name == 'exams/course_result') { ?>

    <style>
        .removeRow {
            background-color: #FF0000;
            color: #FFFFFF;
        }

        .addRow {
            background-color: #bbfaca;
            color: #000;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function() {
            var department_id = $('#department_id').val();
            var initial_course_id = '<?php echo set_value('course_id') ?>';

            // Function to populate courses based on department
            function getSectionByClass(department_id, course_id) {
                if (department_id !== "") {
                    var base_url = '<?php echo base_url() ?>';
                    var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
                    $.ajax({
                        type: "GET",
                        url: base_url + "admin/exams/getByDepartment",
                        data: {
                            'department_id': department_id
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $('#course_id').addClass('dropdownloading');
                        },
                        success: function(data) {
                            console.log("Courses data received:", data); // Debug: Check courses data
                            $.each(data, function(i, obj) {
                                var sel = (course_id == obj.id) ? "selected" : "";
                                div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
                            });
                            $('#course_id').html(div_data); // Set the options to the dropdown
                        },
                        complete: function() {
                            $('#course_id').removeClass('dropdownloading');
                        }
                    });
                }
            }

            getSectionByClass(department_id, initial_course_id);

            // When department changes, update the course list
            $(document).on('change', '#department_id', function(e) {
                var department_id = $(this).val();
                getSectionByClass(department_id, "");
            });

            $("#show").click(function() {
                var session_id = $('#session_id').val();
                var course_id = $('#course_id').val();
                var semester_id = $('#semester_id').val();
                var class_id = $('#class_id').val();

                // Debug: Check values before AJAX call
                console.log("Session ID:", session_id);
                console.log("Course ID before AJAX:", course_id);
                console.log("Semester ID:", semester_id);
                console.log("Class ID:", class_id);

                if (course_id === "" || course_id === undefined) {
                    alert("Please select a course");
                    return;
                }

                // Disable button and show loader
                $("#show").attr("disabled", true);
                $("#show").html('<div class="loader"></div> Loading...');

                $.ajax({
                    url: '<?php echo base_url('admin/exams/course_result_body'); ?>',
                    type: 'post',
                    data: {
                        'session_id': session_id,
                        'semester_id': semester_id,
                        'class_id': class_id,
                        'course_id': course_id
                    },
                    beforeSend: function() {
                        console.log("Before sending AJAX request, Course ID:", course_id);
                        $("#response").hide();
                    },
                    success: function(data) {
                        var response = JSON.parse(data);
                        $("#response").show();
                        renderLoder(response);
                    },
                    complete: function() {
                        // Re-enable button and remove loader
                        $("#show").attr("disabled", false);
                        $("#show").html('<i class="icon icon-search"></i> <?php echo get_phrase('search'); ?>');
                    }
                });
            });
        });


        function renderLoder(response) {
            $('#response').html(response.render);

        }

        function selectsubject(subject_id) {
            var session_id = $('#session_id').val();
            var semester_id = $('#semester_id').val();
            var class_id = $('#class_id').val();
            var course_id = $('#course_id').val();
            console.log("Session ID:", session_id);
            console.log("Course ID:", course_id);
            console.log("Semester ID:", semester_id);
            console.log("Class ID:", class_id);
            $(".list-group-item").removeClass("addRow"); // remove active class from all
            $('#list-' + subject_id).addClass("addRow"); // add active class to clicked element

            $.ajax({
                url: '<?php echo base_url('admin/exams/course_result_data'); ?>',
                type: 'post',
                data: {
                    'session_id': session_id,
                    'semester_id': semester_id,
                    'subject_id': subject_id,
                    'class_id': class_id,
                    'course_id': course_id,

                },
                beforeSend: function() {
                    // Show image container
                    //$("#loader").show();
                    $("#result").hide();
                },
                success: function(data) {

                    var response = JSON.parse(data);
                    //$("#loader").hide();
                    $("#result").show();
                    renderMark(response);
                },
                /* complete: function(data) {

                	// Hide image container
                	$("#loader").hide();
                	$("#response").show();
                	//$("#v-pills-tabContent").hide();
                } */
            });

            function renderMark(response) {
                $('#result').html(response.render);
                $('#basic').DataTable({
                    "aaSorting": [],

                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    pageLength: 100,
                    //responsive: 'true',
                    //paging: false,
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
                            text: '<i class="icon icon-file-excel-o"></i>Excel',
                            titleAttr: 'Excel',

                            title: $('.download_label').html(),
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },

                        /* 	{
                        		extend: 'csv',
                        		text: '<i class="icon icon-file-code-o"></i>',
                        		titleAttr: 'CSV',
                        		title: $('.download_label').html(),
                        		exportOptions: {
                        			columns: 'th:not(:last-child)'
                        		}
                        	}, */

                        /* 	{
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
                            customize: function(win) {
                                $(win.document.body)
                                    .css('font-size', '10pt');

                                $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');

                            },
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },



                        /* 	{
                        		extend: 'pageLength',
                        		//text: '<i class="icon-columns"></i>',
                        		titleAttr: 'Number of Rows',
                        		className: 'selectTable'
                        	} */
                    ]
                })
            }
        }
    </script>
<?php } elseif ($page_name == 'exams/program_results') { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var department_id = $('#department_id').val();
            var initial_course_id = '<?php echo set_value('course_id') ?>';

            // Function to populate courses based on department
            function getSectionByClass(department_id, course_id) {
                if (department_id !== "") {
                    var base_url = '<?php echo base_url() ?>';
                    var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
                    $.ajax({
                        type: "GET",
                        url: base_url + "admin/exams/getByDepartment",
                        data: {
                            'department_id': department_id
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $('#course_id').addClass('dropdownloading');
                        },
                        success: function(data) {
                            console.log("Courses data received:", data); // Debug: Check courses data
                            $.each(data, function(i, obj) {
                                var sel = (course_id == obj.id) ? "selected" : "";
                                div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
                            });
                            $('#course_id').html(div_data); // Set the options to the dropdown
                            // Trigger subject dropdown update if initial_course_id is set
                            if (course_id) {
                                getSubjectsByCourse(course_id, $('#class_id').val(), $('#semester_id').val(), '<?php echo set_value('subject_id') ?>');
                            }
                        },
                        complete: function() {
                            $('#course_id').removeClass('dropdownloading');
                        }
                    });
                }

                $("#show").click(function() {
                    var session_id = $('#session_id').val();
                    var course_id = $('#course_id').val();
                    var semester_id = $('#semester_id').val();
                    var class_id = $('#class_id').val();

                    // Debug: Check values before AJAX call
                    console.log("Session ID:", session_id);
                    console.log("Course ID before AJAX:", course_id);
                    console.log("Semester ID:", semester_id);
                    console.log("Class ID:", class_id);

                    if (course_id === "" || course_id === undefined) {
                        alert("Please select a course");
                        return;
                    }
                    // Disable button and show loader
                    $("#show").attr("disabled", true);
                    $("#show").html('<div class="loader"></div> Loading...');
                    $("#response").html('<div class="loader"></div> Loading...');
                    $.ajax({
                        url: '<?php echo base_url('admin/exams/program_result_body'); ?>',
                        type: 'post',
                        data: {
                            'session_id': session_id,
                            'semester_id': semester_id,
                            'class_id': class_id,
                            'course_id': course_id
                        },
                        beforeSend: function() {
                            console.log("Before sending AJAX request, Course ID:", course_id);
                            $("#response").hide();
                        },
                        success: function(data) {
                            var response = JSON.parse(data);
                            $("#response").show();
                            renderLoder(response);
                        },
                        complete: function() {
                            // Re-enable button and remove loader
                            $("#show").attr("disabled", false);
                            $("#show").html('<i class="icon icon-search"></i> <?php echo get_phrase('search'); ?>');
                        }
                    });
                });
            }
            getSectionByClass(department_id, initial_course_id);

            // When department changes, update the course list
            $(document).on('change', '#department_id', function(e) {
                var department_id = $(this).val();
                getSectionByClass(department_id, "");
            });

            function renderLoder(response) {
                $('#response').html(response.render);

            }
        });
    </script>
<?php } elseif ($page_name == 'exams/student_results') { ?>


    <script type="text/javascript">
        $(document).ready(function() {
            var department_id = $('#department_id').val();
            var initial_course_id = '<?php echo set_value('course_id') ?>';

            // Function to populate courses based on department
            function getSectionByClass(department_id, course_id) {
                if (department_id !== "") {
                    var base_url = '<?php echo base_url() ?>';
                    var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
                    $.ajax({
                        type: "GET",
                        url: base_url + "admin/exams/getByDepartment",
                        data: {
                            'department_id': department_id
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $('#course_id').addClass('dropdownloading');
                        },
                        success: function(data) {
                            console.log("Courses data received:", data); // Debug: Check courses data
                            $.each(data, function(i, obj) {
                                var sel = (course_id == obj.id) ? "selected" : "";
                                div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
                            });
                            $('#course_id').html(div_data); // Set the options to the dropdown
                            // Trigger subject dropdown update if initial_course_id is set
                            if (course_id) {
                                getSubjectsByCourse(course_id, $('#class_id').val(), $('#semester_id').val(), '<?php echo set_value('subject_id') ?>');
                            }
                        },
                        complete: function() {
                            $('#course_id').removeClass('dropdownloading');
                        }
                    });
                }


            }
            getSectionByClass(department_id, initial_course_id);

            // When department changes, update the course list
            $(document).on('change', '#department_id', function(e) {
                var department_id = $(this).val();
                getSectionByClass(department_id, "");
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $("#show").click(function() {
                var session_id = $('#session_id').val();
                var course_id = $('#course_id').val();
                var semester_id = $('#semester_id').val();
                var class_id = $('#class_id').val();

                // Debug: Check values before AJAX call
                console.log("Session ID:", session_id);
                console.log("Course ID before AJAX:", course_id);
                console.log("Semester ID:", semester_id);
                console.log("Class ID:", class_id);

                if (course_id === "" || course_id === undefined) {
                    alert("Please select a course");
                    return;
                }
                // Disable button and show loader
                $("#show").attr("disabled", true);
                $("#show").html('<div class="loader"></div> Loading...');
                $.ajax({
                    url: '<?php echo base_url('admin/exams/student_result_body'); ?>',
                    type: 'post',
                    data: {
                        'session_id': session_id,
                        'semester_id': semester_id,
                        'class_id': class_id,
                        'course_id': course_id
                    },
                    beforeSend: function() {
                        console.log("Before sending AJAX request, Course ID:", course_id);
                        $("#response").hide();
                    },
                    success: function(data) {
                        var response = JSON.parse(data);
                        $("#response").show();
                        renderLoder(response);
                    },
                    complete: function() {
                        // Re-enable button and remove loader
                        $("#show").attr("disabled", false);
                        $("#show").html('<i class="icon icon-search"></i> <?php echo get_phrase('search'); ?>');
                    }
                });
            });

            function renderLoder(response) {
                $('#response').html(response.render);
                $("#studentSearch").on("keyup", function() {
                    console.log('Its responding');
                    var searchTerm = $(this).val().toLowerCase();
                    $("#studentList li").each(function() {
                        var studentRegNo = $(this).text().toLowerCase();
                        if (studentRegNo.includes(searchTerm)) {
                            $(this).html(highlightText($(this).text(), searchTerm));
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });
            }

            function highlightText(text, searchTerm) {
                var regex = new RegExp(`(${searchTerm})`, 'gi');
                return text.replace(regex, "<span class='highlight'>$1</span>");
            }

            function selectstudent(student_id) {
                var session_id = $('#session_id').val();
                var semester_id = $('#semester_id').val();
                var class_id = $('#class_id').val();
                var course_id = $('#course_id').val();
                console.log(session_id);
                console.log(semester_id);
                console.log(student_id);
                console.log(class_id);
                $(".list-group-item").removeClass("addRow"); // remove active class from all
                $('#list-' + student_id).addClass("addRow"); // add active class to clicked element

                $.ajax({
                    url: '<?php echo base_url('admin/exams/student_result_data'); ?>',
                    type: 'post',
                    data: {
                        'session_id': session_id,
                        'semester_id': semester_id,
                        'student_id': student_id,
                        'class_id': class_id,
                        'course_id': course_id,

                    },
                    beforeSend: function() {
                        // Show image container
                        //$("#loader").show();
                        $("#result").hide();
                    },
                    success: function(data) {
                        var response = JSON.parse(data);
                        //$("#loader").hide();
                        $("#result").show();
                        renderMark(response);
                        document.getElementById('result').scrollIntoView({
                            behavior: 'smooth'
                        });
                    },

                });

                function renderMark(response) {
                    $('#result').html(response.render);
                }
            }

            // Attach click handler to dynamically created elements
            $(document).on('click', '.list-group-item', function() {
                var studentId = $(this).attr('id').split('-')[1];
                selectstudent(studentId);
            });
        });
    </script>

<?php } else { ?>
    <style>
        .removeRow {
            background-color: #FF0000;
            color: #FFFFFF;
        }

        .addRow {
            background-color: #bbfaca;
            color: #000;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            var department_id = $('#department_id').val();
            var initial_course_id = '<?php echo set_value('course_id') ?>';

            // Function to populate courses based on department
            function getSectionByClass(department_id, course_id) {
                if (department_id !== "") {
                    var base_url = '<?php echo base_url() ?>';
                    var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
                    $.ajax({
                        type: "GET",
                        url: base_url + "admin/exams/getByDepartment",
                        data: {
                            'department_id': department_id
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $('#course_id').addClass('dropdownloading');
                        },
                        success: function(data) {
                            console.log("Courses data received:", data); // Debug: Check courses data
                            $.each(data, function(i, obj) {
                                var sel = (course_id == obj.id) ? "selected" : "";
                                div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
                            });
                            $('#course_id').html(div_data); // Set the options to the dropdown
                            // Trigger subject dropdown update if initial_course_id is set
                            if (course_id) {
                                getSubjectsByCourse(course_id, $('#class_id').val(), $('#semester_id').val(), '<?php echo set_value('subject_id') ?>');
                            }
                        },
                        complete: function() {
                            $('#course_id').removeClass('dropdownloading');
                        }
                    });
                }
            }

            // Function to populate subjects based on course, class, and semester
            function getSubjectsByCourse(course_id, class_id, semester_id, subject_id) {
                if (course_id !== "" && class_id !== "" && semester_id !== "") {
                    var base_url = '<?php echo base_url() ?>';
                    var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
                    $.ajax({
                        type: "GET",
                        url: base_url + "admin/exams/getSubjectsByCourse",
                        data: {
                            'course_id': course_id,
                            'class_id': class_id,
                            'semester_id': semester_id
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $('#subject_id').addClass('dropdownloading');
                        },
                        success: function(data) {
                            console.log("Subjects data received:", data); // Debug: Check subjects data
                            $.each(data, function(i, obj) {
                                var sel = (subject_id == obj.id) ? "selected" : "";
                                div_data += "<option value=" + obj.id + " " + sel + ">" + obj.code + " - " + obj.name + "</option>";
                            });
                            $('#subject_id').html(div_data); // Set the options to the dropdown
                        },
                        complete: function() {
                            $('#subject_id').removeClass('dropdownloading');
                        }
                    });
                }
            }

            getSectionByClass(department_id, initial_course_id);

            // When department changes, update the course list
            $(document).on('change', '#department_id', function(e) {
                var department_id = $(this).val();
                getSectionByClass(department_id, "");
            });

            // When course, class, or semester changes, update the subject list
            $(document).on('change', '#course_id, #class_id, #semester_id', function(e) {
                var course_id = $('#course_id').val();
                var class_id = $('#class_id').val();
                var semester_id = $('#semester_id').val();
                getSubjectsByCourse(course_id, class_id, semester_id, "");
            });
        });
        $(document).ready(function() {
            $('#uploadButton').click(function() {

                var formData = new FormData($('#importMarksForm')[0]);

                $.ajax({
                    url: $('#importMarksForm').attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var result = JSON.parse(response);
                        console.log(result);
                        if (result.status === 'confirm') {
                            if (confirm('This Course has been Marked already. Do you want to overwrite existing marks?')) {
                                var confirmFormData = new FormData($('#importMarksForm')[0]);
                                confirmFormData.append('confirm', true);
                                $.ajax({
                                    url: $('#importMarksForm').attr('action'),
                                    type: 'POST',
                                    data: confirmFormData,
                                    processData: false,
                                    contentType: false,
                                    success: function(finalResponse) {
                                        var finalResult = JSON.parse(finalResponse);
                                        console.log(finalResult);
                                        if (finalResult.status === 'success') {

                                            toastr.success('Marks imported successfully');
                                            // form.trigger("reset"); // Reset the form
                                            // $('#course_id').html('<option value=""><?php echo get_phrase('select'); ?></option>');
                                            // $('#subject_id').html('<option value=""><?php echo get_phrase('select'); ?></option>');
                                        } else {

                                            toastr.warning(finalResult.message);

                                        }
                                    }
                                });
                            }
                        } else if (result.status === 'success') {

                            toastr.success('Marks imported successfully');
                            redirect('<?php echo base_url('admin/exams/bulk'); ?>');
                        } else {
                            //alert(result.message);
                            toastr.warning(result.message);
                        }
                    },
                    error: function() {

                        toastr.error('Error occurred while processing the file.');
                    }
                });
            });
        });



        function renderLoder(response) {
            $('#response').html(response.render);

        }

        function selectsubject(subject_id) {
            var session_id = $('#session_id').val();
            var semester_id = $('#semester_id').val();
            var class_id = $('#class_id').val();
            var department_id = $('#department_id').val();
            console.log(session_id);
            console.log(semester_id);
            console.log(subject_id);
            console.log(class_id);
            console.log(department_id);
            $(".list-group-item").removeClass("addRow"); // remove active class from all
            $('#list-' + subject_id).addClass("addRow"); // add active class to clicked element

            $.ajax({
                url: '<?php echo base_url('admin/exams/upload_file_body'); ?>',
                type: 'post',
                data: {
                    'session_id': session_id,
                    'semester_id': semester_id,
                    'subject_id': subject_id,
                    'class_id': class_id,
                    'department_id': department_id,

                },
                beforeSend: function() {
                    // Show image container
                    //$("#loader").show();
                    $("#result").hide();
                },
                success: function(data) {

                    var response = JSON.parse(data);
                    //$("#loader").hide();
                    $("#result").show();
                    renderMark(response);
                },
                /* complete: function(data) {

                // Hide image container
                $("#loader").hide();
                $("#response").show();
                //$("#v-pills-tabContent").hide();
                } */
            });

            function renderMark(response) {
                $('#result').html(response.render);
                $('#basic').DataTable({
                    "aaSorting": [],

                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    pageLength: 100,
                    //responsive: 'true',
                    //paging: false,
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
                            text: '<i class="icon icon-file-excel-o"></i>Excel',
                            titleAttr: 'Excel',

                            title: $('.download_label').html(),
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },

                        /* 	{
                        		extend: 'csv',
                        		text: '<i class="icon icon-file-code-o"></i>',
                        		titleAttr: 'CSV',
                        		title: $('.download_label').html(),
                        		exportOptions: {
                        			columns: 'th:not(:last-child)'
                        		}
                        	}, */

                        /* 	{
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
                            customize: function(win) {
                                $(win.document.body)
                                    .css('font-size', '10pt');

                                $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');

                            },
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },



                        /* 	{
                        		extend: 'pageLength',
                        		//text: '<i class="icon-columns"></i>',
                        		titleAttr: 'Number of Rows',
                        		className: 'selectTable'
                        	} */
                    ]
                })


            }
        }
    </script>
<?php } ?>