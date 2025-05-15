"use strict";

// Class definition
var KTCreateCampaign = function () {
	// Elements
	/* var modal;
	var modalEl;
 */
	var stepper;
	var form;
	var formSubmitButton;
	var formContinueButton;

	// Variables
	var stepperObj;
	var validations = [];

	// Private Functions
	var initStepper = function () {
		// Initialize Stepper
		stepperObj = new KTStepper(stepper);

		// Stepper change event(handle hiding submit button for the last step)
		stepperObj.on('kt.stepper.changed', function (stepper) {
			if (stepperObj.getCurrentStepIndex() === 4) {
				formSubmitButton.classList.remove('d-none');
				formSubmitButton.classList.add('d-inline-block');
				formContinueButton.classList.add('d-none');
			} else if (stepperObj.getCurrentStepIndex() === 5) {
				formSubmitButton.classList.add('d-none');
				formContinueButton.classList.add('d-none');
			} else {
				formSubmitButton.classList.remove('d-inline-block');
				formSubmitButton.classList.remove('d-none');
				formContinueButton.classList.remove('d-none');
			}
		});

		// Validation before going to next page
		stepperObj.on('kt.stepper.next', function (stepper) {
			console.log('stepper.next');

			// Validate form before change stepper step
			var validator = validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');
					//status.preventDefault();
					if (status == 'Valid') {
						stepper.goNext();
						//form.submit();
						//KTUtil.scrollTop();
					} else {
						// Show error message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
						Swal.fire({
							text: "Sorry, looks like there are some errors detected, please try again.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-light"
							}
						}).then(function () {
							//KTUtil.scrollTop();
						});
					}
				});
			} else {
				stepper.goNext();

				KTUtil.scrollTop();
			}
		});

		// Prev event
		stepperObj.on('kt.stepper.previous', function (stepper) {
			console.log('stepper.previous');

			stepper.goPrevious();
			KTUtil.scrollTop();
		});

		formSubmitButton.addEventListener('click', function (e) {
			
				// Validate form before change stepper step
			var validator = validations[3]; // get validator for last form

			validator.validate().then(function (status) {
				console.log('validated!');

				if (status == 'Valid') {
			// Prevent default button action
			e.preventDefault();

			// Disable button to avoid multiple click 
			formSubmitButton.disabled = true;

			// Show loading indication
			formSubmitButton.setAttribute('data-kt-indicator', 'on');
			///form.submit();
			//var result = test();
			//
			// Simulate form submission
			setTimeout(function () {
				// Hide loading indication
				formSubmitButton.removeAttribute('data-kt-indicator');

				// Enable button
				formSubmitButton.disabled = false;

				stepperObj.goNext();
				//KTUtil.scrollTop();
			}, 2000);
			//return result;
		 } else {
					Swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-light"
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});
		});
	}

	// Init form inputs
	var initForm = function () {
	
		$("#kt_dob").flatpickr({
    	onReady: function () {
        this.jumpToDate("01/01/2000")
   		},
    	dateFormat: "d/m/Y",
    	disable: [
    	    {
    	        from: "01/01/2010",
    	        to: "01/12/2025"
    	    }/* ,
    	    {
    	        from: "2025-02-03",
    	        to: "2025-02-15"
    	    } */
    	]
		});

		// Init dropzone
		/* var myDropzone = new Dropzone("#kt_modal_create_campaign_files_upload", {
			url: "https://keenthemes.com/scripts/void.php", // Set the url for your upload script location
			paramName: "file", // The name that will be used to transfer the file
			maxFiles: 10,
			maxFilesize: 10, // MB
			addRemoveLinks: true,
			accept: function(file, done) {
				if (file.name == "wow.jpg") {
					done("Naha, you don't.");
				} else {
					done();
				}
			}
		});

		*/

		// Handle create new campaign button
		/* const restartButton = document.querySelector('#kt_modal_create_campaign_create_new');
		restartButton.addEventListener('click', function () {
			form.reset();
			stepperObj.goTo(1);
		}); */
	}

	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					firstname: {
						validators: {
							notEmpty: {
								message: 'Firstname is required'
							}
						}
					},
					
					email: {
						validators: {
							notEmpty: {
								message: 'Email Address is required'
							}
						}
					},
					gender: {
						validators: {
							notEmpty: {
								message: 'Gender is required'
							}
						}
					},
					dob: {
						validators: {
							notEmpty: {
								message: 'Date of Birth is required'
							}
						}
					},
					religion: {
						validators: {
							notEmpty: {
								message: 'religion is required'
							}
						}
					},
					state_id: {
						validators: {
							notEmpty: {
								message: 'State is required'
							}
						}
					},
					local_government_id: {
						validators: {
							notEmpty: {
								message: 'LGA is required'
							}
						}
					},
					tob: {
						validators: {
							notEmpty: {
								message: 'Home Town is required'
							}
						}
					},
					current_address: {
						validators: {
							notEmpty: {
								message: 'Current Address is required'
							}
						}
					},
					permanent_address: {
						validators: {
							notEmpty: {
								message: 'Permenent Address is required'
							}
						}
					},
					
					file: {
						validators: {
							file: {
								extension: 'png,jpg,jpeg',
								type: 'image/jpeg,image/png',
								message: 'Please choose a png, jpg or jpeg files only',
							}/* ,
							notEmpty: {
								message: 'Passport Photograph is required'
							} */
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.col',
						eleInvalidClass: '',
						eleValidClass: ''
					})
				}
			}
		));
		// Step 2
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					guardian_name: {
						validators: {
							notEmpty: {
								message: 'Guardian Name is required'
							}
						}
					},
					guardian_relation: {
						validators: {
							notEmpty: {
								message: 'Relation is required'
							}
						}
					},
					guardian_phone: {
						validators: {
							notEmpty: {
								message: 'Guardian Phone Num is required'
							}
						}
					},
					guardian_address: {
						validators: {
							notEmpty: {
								message: 'Guardian Address is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.col',
                        eleInvalidClass: '',
                        eleValidClass: ''
					})
				}
			}
		));
		// Step 3
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					
					primary_school: {
						validators: {
							notEmpty: {
								message: 'Primary School is required'
							}
						}
					},
					primary_school_year: {
						validators: {
							notEmpty: {
								message: 'Primary School graduation year is required'
							}
						}
					},
					secondary_school: {
						validators: {
							notEmpty: {
								message: 'Secondary School is required'
							}
						}
					},
					secondary_school_year: {
						validators: {
							notEmpty: {
								message: 'Secondary School graduation year is required'
							}
						}
					},
					sitting: {
						validators: {
							notEmpty: {
								message: 'Number of Exams sittings is required'
							}
						}
					},
					title: {
						validators: {
							notEmpty: {
								message: 'Exams title is required'
							}
						}
					},
					exam_year: {
						validators: {
							notEmpty: {
								message: 'Exams year is required'
							}
						}
					},
					exam_no: {
						validators: {
							notEmpty: {
								message: 'Exams Num is required'
							}
						}
					},
					subject: {
						validators: {
							notEmpty: {
								message: 'Subject is required'
							}
						}
					},
					
					subject2: {
						validators: {
							notEmpty: {
								message: 'Subject 2 is required'
							}
						}
					},
					subject3: {
						validators: {
							notEmpty: {
								message: 'Subject 3 is required'
							}
						}
					},
					subject4: {
						validators: {
							notEmpty: {
								message: 'Subject 4 is required'
							}
						}
					},
					subject5: {
						validators: {
							notEmpty: {
								message: 'Subject 5 is required'
							}
						}
					},
					subject6: {
						validators: {
							notEmpty: {
								message: 'Subject 6 is required'
							}
						}
					},
					subject7: {
						validators: {
							notEmpty: {
								message: 'Subject 7 is required'
							}
						}
					},
					subject8: {
						validators: {
							notEmpty: {
								message: 'Subject 8 is required'
							}
						}
					},
					subject9: {
						validators: {
							notEmpty: {
								message: 'Subject 9 is required'
							}
						}
					},
					grade: {
						validators: {
							notEmpty: {
								message: 'Grade is required'
							}
						}
					},
					grade2: {
						validators: {
							notEmpty: {
								message: 'Grade is required'
							}
						}
					},
					grade3: {
						validators: {
							notEmpty: {
								message: 'Grade is required'
							}
						}
					},
					grade4: {
						validators: {
							notEmpty: {
								message: 'Grade is required'
							}
						}
					},
					grade5: {
						validators: {
							notEmpty: {
								message: 'Grade is required'
							}
						}
					},
					grade6: {
						validators: {
							notEmpty: {
								message: 'Grade is required'
							}
						}
					},
					grade7: {
						validators: {
							notEmpty: {
								message: 'Grade is required'
							}
						}
					},
					grade8: {
						validators: {
							notEmpty: {
								message: 'Grade is required'
							}
						}
					},
					grade9: {
						validators: {
							notEmpty: {
								message: 'Grade is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.col',
                        eleInvalidClass: '',
                        eleValidClass: ''
					})
				}
			}
		));
			// Step 4
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					school_id: {
						validators: {
							notEmpty: {
								message: 'School is required'
							}
						}
					},
					department_id: {
						validators: {
							notEmpty: {
								message: 'Department is required'
							}
						}
					},
					course_id: {
						validators: {
							notEmpty: {
								message: 'course is required'
							}
						}
					},
					school_id2: {
						validators: {
							notEmpty: {
								message: 'School is required'
							}
						}
					},
					department_id2: {
						validators: {
							notEmpty: {
								message: 'Department is required'
							}
						}
					},
					course_id2: {
						validators: {
							notEmpty: {
								message: 'course is required'
							}
						}
					}
				},

				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.col',
                        eleInvalidClass: '',
                        eleValidClass: ''
					})
				}
			}
		));

	}

	return {
		// Public Functions
		init: function () {
			// Elements
			/* modalEl = document.querySelector('#kt_modal_create_campaign');

			if (!modalEl) {
				return;
			}

			modal = new bootstrap.Modal(modalEl); */

			stepper = document.querySelector('#kt_modal_create_campaign_stepper');
			form = document.querySelector('#kt_modal_create_campaign_stepper_form');
			formSubmitButton = stepper.querySelector('[data-kt-stepper-action="submit"]');
			formContinueButton = stepper.querySelector('[data-kt-stepper-action="next"]');

			initStepper();
			initForm();
			initValidation();
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTCreateCampaign.init();
});

/* 
					
					 */

