<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>

		<script src="assets/js/bootbox.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/jquery.hotkeys.index.min.js"></script>



		<script src="assets/js/bootstrap-editable.min.js"></script>

		<script src="assets/js/jquery.maskedinput.min.js"></script>
		<script src="assets/js/jquery.validate.min.js"></script>
		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {

				//editables on first profile page
				$.fn.editable.defaults.mode = 'inline';
				$.fn.editableform.loading = "<div class='editableform-loading'><i class='ace-icon fa fa-spinner fa-spin fa-2x light-blue'></i></div>";
			    $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit" name="btn-foto"><i class="ace-icon fa fa-check"></i></button>'+
			                                '<button type="button" class="btn editable-cancel"><i class="ace-icon fa fa-times"></i></button>';

				//editables

				//text editable
			    $('#username')
				.editable({
					type: 'text',
					name: 'username'
			    });



				//select2 editable
				var countries = [];
			    $.each({ "CA": "Canada", "IN": "India", "NL": "Netherlands", "TR": "Turkey", "US": "United States"}, function(k, v) {
			        countries.push({id: k, text: v});
			    });

				var cities = [];
				cities["CA"] = [];
				$.each(["Toronto", "Ottawa", "Calgary", "Vancouver"] , function(k, v){
					cities["CA"].push({id: v, text: v});
				});
				cities["IN"] = [];
				$.each(["Delhi", "Mumbai", "Bangalore"] , function(k, v){
					cities["IN"].push({id: v, text: v});
				});
				cities["NL"] = [];
				$.each(["Amsterdam", "Rotterdam", "The Hague"] , function(k, v){
					cities["NL"].push({id: v, text: v});
				});
				cities["TR"] = [];
				$.each(["Ankara", "Istanbul", "Izmir"] , function(k, v){
					cities["TR"].push({id: v, text: v});
				});
				cities["US"] = [];
				$.each(["New York", "Miami", "Los Angeles", "Chicago", "Wysconsin"] , function(k, v){
					cities["US"].push({id: v, text: v});
				});

				var currentValue = "NL";
			    $('#country').editable({
					type: 'select2',
					value : 'NL',
					//onblur:'ignore',
			        source: countries,
					select2: {
						'width': 140
					},
					success: function(response, newValue) {
						if(currentValue == newValue) return;
						currentValue = newValue;

						var new_source = (!newValue || newValue == "") ? [] : cities[newValue];

						//the destroy method is causing errors in x-editable v1.4.6+
						//it worked fine in v1.4.5
						/**
						$('#city').editable('destroy').editable({
							type: 'select2',
							source: new_source
						}).editable('setValue', null);
						*/

						//so we remove it altogether and create a new element
						var city = $('#city').removeAttr('id').get(0);
						$(city).clone().attr('id', 'city').text('Select City').editable({
							type: 'select2',
							value : null,
							//onblur:'ignore',
							source: new_source,
							select2: {
								'width': 140
							}
						}).insertAfter(city);//insert it after previous instance
						$(city).remove();//remove previous instance

					}
			    });

				$('#city').editable({
					type: 'select2',
					value : 'Amsterdam',
					//onblur:'ignore',
			        source: cities[currentValue],
					select2: {
						'width': 140
					}
			    });



				//custom date editable
				$('#signup').editable({
					type: 'adate',
					date: {
						//datepicker plugin options
						    format: 'yyyy/mm/dd',
						viewformat: 'yyyy/mm/dd',
						 weekStart: 1

						//,nativeUI: true//if true and browser support input[type=date], native browser control will be used
						//,format: 'yyyy-mm-dd',
						//viewformat: 'yyyy-mm-dd'
					}
				})

			    $('#age').editable({
			        type: 'spinner',
					name : 'age',
					spinner : {
						min : 16,
						max : 99,
						step: 1,
						on_sides: true
						//,nativeUI: true//if true and browser support input[type=number], native browser control will be used
					}
				});


			    $('#login').editable({
			        type: 'slider',
					name : 'login',

					slider : {
						 min : 1,
						  max: 50,
						width: 100
						//,nativeUI: true//if true and browser support input[type=range], native browser control will be used
					},
					success: function(response, newValue) {
						if(parseInt(newValue) == 1)
							$(this).html(newValue + " hour ago");
						else $(this).html(newValue + " hours ago");
					}
				});

				$('#about').editable({
					mode: 'inline',
			        type: 'wysiwyg',
					name : 'about',

					wysiwyg : {
						//css : {'max-width':'300px'}
					},
					success: function(response, newValue) {
					}
				});



				// *** editable avatar *** //
				try {//ie8 throws some harmless exceptions, so let's catch'em

					//first let's add a fake appendChild method for Image element for browsers that have a problem with this
					//because editable plugin calls appendChild, and it causes errors on IE at unpredicted points
					try {
						document.createElement('IMG').appendChild(document.createElement('B'));
					} catch(e) {
						Image.prototype.appendChild = function(el){}
					}

					var last_gritter
					$('#avatar').editable({
						type: 'image',
						name: 'avatar',
						value: null,
						//onblur: 'ignore',  //don't reset or hide editable onblur?!
						image: {
							//specify ace file input plugin's options here
							btn_choose: 'Change Avatar',
							droppable: true,
							maxSize: 110000,//~100Kb

							//and a few extra ones here
							name: 'avatar',//put the field name here as well, will be used inside the custom plugin
							on_error : function(error_type) {//on_error function will be called when the selected file has a problem
								if(last_gritter) $.gritter.remove(last_gritter);
								if(error_type == 1) {//file format error
									last_gritter = $.gritter.add({
										title: 'File is not an image!',
										text: 'Please choose a jpg|gif|png image!',
										class_name: 'gritter-error gritter-center'
									});
								} else if(error_type == 2) {//file size rror
									last_gritter = $.gritter.add({
										title: 'File too big!',
										text: 'Image size should not exceed 100Kb!',
										class_name: 'gritter-error gritter-center'
									});
								}
								else {//other error
								}
							},
							on_success : function() {
								$.gritter.removeAll();
							}
						},
					    url: function(params) {
							// ***UPDATE AVATAR HERE*** //
							//for a working upload example you can replace the contents of this function with
							//examples/profile-avatar-update.js

							var deferred = new $.Deferred

							var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
							if(!value || value.length == 0) {
								deferred.resolve();
								return deferred.promise();
							}


							//dummy upload
							setTimeout(function(){
								if("FileReader" in window) {
									//for browsers that have a thumbnail of selected image
									var thumb = $('#avatar').next().find('img').data('thumb');
									if(thumb) $('#avatar').get(0).src = thumb;
								}

								deferred.resolve({'status':'OK'});

								if(last_gritter) $.gritter.remove(last_gritter);
								last_gritter = $.gritter.add({
									title: 'Avatar Updated!',
									text: 'Uploading to server can be easily implemented. A working example is included with the template.',
									class_name: 'gritter-info gritter-center'
								});

							 } , parseInt(Math.random() * 800 + 800))

							return deferred.promise();

							// ***END OF UPDATE AVATAR HERE*** //
						},

						success: function(response, newValue) {
						}
					})
				}catch(e) {}

				/**
				//let's display edit mode by default?
				var blank_image = true;//somehow you determine if image is initially blank or not, or you just want to display file input at first
				if(blank_image) {
					$('#avatar').editable('show').on('hidden', function(e, reason) {
						if(reason == 'onblur') {
							$('#avatar').editable('show');
							return;
						}
						$('#avatar').off('hidden');
					})
				}
				*/

				//another option is using modals
				$('#avatar2').on('click', function(){
					var modal =
					'<div class="modal fade">\
					  <div class="modal-dialog">\
					   <div class="modal-content">\
						<div class="modal-header">\
							<button type="button" class="close" data-dismiss="modal">&times;</button>\
							<h4 class="blue">Change Avatar</h4>\
						</div>\
						\
						<form class="no-margin" action="" method="post">\
						 <div class="modal-body">\
							<div class="space-4"></div>\
							<div style="width:75%;margin-left:12%;"><input type="file" name="file-input" /></div>\
						 </div>\
						\
						 <div class="modal-footer center">\
							<button type="submit" class="btn btn-sm btn-success" name="btn-foto"><i class="ace-icon fa fa-check"></i> Submit</button>\
							<button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancel</button>\
						 </div>\
						</form>\
					  </div>\
					 </div>\
					</div>';


					var modal = $(modal);
					modal.modal("show").on("hidden", function(){
						modal.remove();
					});

					var working = false;

					var form = modal.find('form:eq(0)');
					var file = form.find('input[type=file]').eq(0);
					file.ace_file_input({
						style:'well',
						btn_choose:'Click to choose new avatar',
						btn_change:null,
						no_icon:'ace-icon fa fa-picture-o',
						thumbnail:'small',
						before_remove: function() {
							//don't remove/reset files while being uploaded
							return !working;
						},
						allowExt: ['jpg', 'jpeg', 'png', 'gif'],
						allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
					});

					form.on('submit', function(){
						if(!file.data('ace_input_files')) return false;

						file.ace_file_input('disable');
						form.find('button').attr('disabled', 'disabled');
						form.find('.modal-body').append("<div class='center'><i class='ace-icon fa fa-spinner fa-spin bigger-150 orange'></i></div>");

						var deferred = new $.Deferred;
						working = true;
						deferred.done(function() {
							form.find('button').removeAttr('disabled');
							form.find('input[type=file]').ace_file_input('enable');
							form.find('.modal-body > :last-child').remove();

							modal.modal("hide");

							var thumb = file.next().find('img').data('thumb');
							if(thumb) $('#avatar2').get(0).src = thumb;

							working = false;
						});


						setTimeout(function(){
							deferred.resolve();
						} , parseInt(Math.random() * 800 + 800));

						return false;
					});

				});



				//////////////////////////////
				$('#profile-feed-1').ace_scroll({
					height: '250px',
					mouseWheelLock: true,
					alwaysVisible : true
				});

				$('a[ data-original-title]').tooltip();

				$('.easy-pie-chart.percentage').each(function(){
				var barColor = $(this).data('color') || '#555';
				var trackColor = '#E2E2E2';
				var size = parseInt($(this).data('size')) || 72;
				$(this).easyPieChart({
					barColor: barColor,
					trackColor: trackColor,
					scaleColor: false,
					lineCap: 'butt',
					lineWidth: parseInt(size/10),
					animate:false,
					size: size
				}).css('color', barColor);
				});

				///////////////////////////////////////////

				//right & left position
				//show the user info on right or left depending on its position
				$('#user-profile-2 .memberdiv').on('mouseenter touchstart', function(){
					var $this = $(this);
					var $parent = $this.closest('.tab-pane');

					var off1 = $parent.offset();
					var w1 = $parent.width();

					var off2 = $this.offset();
					var w2 = $this.width();

					var place = 'left';
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) place = 'right';

					$this.find('.popover').removeClass('right left').addClass(place);
				}).on('click', function(e) {
					e.preventDefault();
				});


				///////////////////////////////////////////
				$('#user-profile-3')
				.find('input[type=file]').ace_file_input({
					style:'well',
					btn_choose:'Change avatar',
					btn_change:null,
					no_icon:'ace-icon fa fa-picture-o',
					thumbnail:'large',
					droppable:true,

					allowExt: ['jpg', 'jpeg', 'png', 'gif'],
					allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
				})
				.end().find('button[type=reset]').on(ace.click_event, function(){
					$('#user-profile-3 input[type=file]').ace_file_input('reset_input');
				})
				.end().find('.date-picker').datepicker().next().on(ace.click_event, function(){
					$(this).prev().focus();
				})
				.end().find('.date-picker1').datepicker().next().on(ace.click_event, function(){
					$(this).prev().focus();
				})
				$('.input-mask-phone').mask('(9999) 9999-9999');

				$('#user-profile-3').find('input[type=file]').ace_file_input('show_file_list', [{type: 'image', name: $('#avatar').attr('src')}]);


				////////////////////
				//change profile
				$('[data-toggle="buttons"] .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					$('.user-profile').parent().addClass('hide');
					$('#user-profile-'+which).parent().removeClass('hide');
				});



				/////////////////////////////////////
				$(document).one('ajaxloadstart.page', function(e) {
					//in ajax mode, remove remaining elements before leaving page
					try {
						$('.editable').editable('destroy');
					} catch(e) {}
					$('[class*=select2]').remove();
				});
			});
		</script>
	<script type="text/javascript">
			jQuery(function($) {
				$('#loading-btn').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 3000)
				});

				$('#loading-btn1').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 3000)
				});

				$('#loading-btn2').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 3000)
				});

				$('#loading-btn3').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 3000)
				});

				$('#loading-btn4').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 3000)
				});
				$('#loading-btn5').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 3000)
				});
				$('#loading-btn6').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 3000)
				});
				$('#id-button-borders').attr('checked' , 'checked').on('click', function(){
					$('#default-buttons .btn').toggleClass('no-border');
				});
			})
		</script>
		<script type="text/javascript">
			jQuery(function($) {

				$.mask.definitions['~']='[+-]';
				$('#hp').mask('(9999) 9999-9999');

				$('.input-mask-whatsapp').mask('(9999) 9999-9999');
				$.mask.definitions['~']='[+-]';
				$('#whatsapp').mask('(9999) 9999-9999');

				jQuery.validator.addMethod("hp", function (value, element) {
					return this.optional(element) || /^\(\d{4}\) \d{4}\-\d{4}( x\d{1,10})?$/.test(value);
				}, "Hanya Angka atau Nomor yang diperbolehkan.");
				$('#validation-form').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: true,
					ignore: "",
					rules: {
						email: {
							required: true,
							minlength: 8,
							email:true
						},
						url: {
							maxlength: 100,
							minlength: 8,
							url:true
						},
						tgl: {
							required: true
						},

						jk: {
							required: true,
						},

						alamat: {
							required: true,
							minlength: 10,
							maxlength: 250
						},
						tempat: {
							required: true,
							minlength: 5,
							maxlength: 25
						},
						bidang: {
							required: true
						},
						agama: {
							required: true
						},
						status: {
							required: true
						},
						hp: {
							required: true,
							minlength: 10,
							hp: 'required',
							maxlength: 16
						},
						whatsapp: {

							minlength: 12,

							maxlength: 16
						},
						euname: {
							required: true,
							minlength: 8,
							maxlength: 50
						},
						email1: {
							required: true,
							minlength: 8,
							email:true
						},
						password: {
							required: true,
							minlength: 8,
							maxlength: 25

						}
					},

					messages: {
						email: {
							required: "Masukkan Email.",
							minlength: "Minimal 8 Karakter.",
							email: "Email Tidak Valid."
						},
						euname: {
							required: "Masukkan Nama Anda.",
							minlength: "Minimal 8 Karakter.",
							maxlength: "Maximal 50 Karakter."
						},
						url: {
							url: "URL Tidak Valid.",
							minlength: "Minimal 8 Karakter.",
							maxlength: "Maximal 100 Karakter."
						},
						hp: {
							required: "Masukkan Nomor Telepon Anda.",
							minlength: "Minimal 10 Karakter.",
							maxlength: "Maximal 16 Karakter."
						},
						whatsapp: {

							minlength: "Minimal 12 Karakter.",
							maxlength: "Maximal 16 Karakter."
						},
						tempat: {
							required: "Masukkan Tempat Lahir Anda.",
							minlength: "Minimal 5 Karakter.",
							maxlength: "Maximal 25 Karakter."
						},
						alamat: {
							required: "Masukkan Alamat Anda.",
							minlength: "Minimal 10 Karakter.",
							maxlength: "Maximal 250 Karakter."
						},
						email1: {
							required: "Masukkan Email.",
							minlength: "Minimal 8 Karakter.",
							email: "Email Tidak Valid."
						},
						password: {
							required: "Masukkan Password.",
							minlength: "Minimal 8 Karakter.",
							maxlength: "Maximal 25 Karakter."
						},

						tgl: "Masukkan Tanggal Lahir",
						bidang: "Masukkan Bidang Proyek Anda",
						agama: "Isi Agama Anda",
						jk: "Pilih Jenis Kelamin",

						status: "Pilih Status Pernikahan"
					},

					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},

					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},

					errorPlacement: function (error, element) {
						if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
							var controls = element.closest('div[class*="col-"]');
							if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
							else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
						}
						else if(element.is('.select2')) {
							error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
						}
						else if(element.is('.chosen-select')) {
							error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
						}
						else error.insertAfter(element.parent());
					}

				});

					$('#validation-form1').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: true,
					ignore: "",
					rules: {
						ubahpass: {
							required: true,

							minlength: 8
						},
						passbaru: {
							required: true,
							minlength: 8
						},
						konpassbaru: {
							required: true,
							minlength: 8,
							equalTo: "#passbaru"

						}
					},

					messages: {
						ubahpass: {
							required: "Masukkan Password.",
							minlength: "Minimal 8 Karakter."
						},
						passbaru: {
							required: "Masukkan Password.",
							minlength: "Minimal 8 Karakter."
						},
						konpassbaru: {
							required: "Masukkan Password.",
							minlength: "Minimal 8 Karakter.",
							equalTo: "Password tidak cocok"
						},
						tgl: "Masukkan Tanggal Lahir",
						jk: "Pilih Jenis Kelamin",
						gender: "Please choose gender",
						agree: "Please accept our policy"
					},


					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},

					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},

					errorPlacement: function (error, element) {
						if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
							var controls = element.closest('div[class*="col-"]');
							if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
							else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
						}
						else if(element.is('.select2')) {
							error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
						}
						else if(element.is('.chosen-select')) {
							error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
						}
						else error.insertAfter(element.parent());
					}

				});


				$('#validation-form2').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: true,
					ignore: "",
					rules: {
						fileToUpload: {
							required: true

						}
					},

					messages: {
						fileToUpload: {
							required: "Pilih Foto yang ingin di ubah."
						},

						tgl: "Masukkan Tanggal Lahir",
						jk: "Pilih Jenis Kelamin",
						gender: "Please choose gender",
						agree: "Please accept our policy"
					},


					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},

					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},

					errorPlacement: function (error, element) {
						if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
							var controls = element.closest('div[class*="col-"]');
							if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
							else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
						}
						else if(element.is('.select2')) {
							error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
						}
						else if(element.is('.chosen-select')) {
							error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
						}
						else error.insertAfter(element.parent());
					}

				});

				$('.input-mask-proyek').mask('99/aaa/999');
				$.mask.definitions['~']='[+-]';
				$('#id').mask('99/aaa/999');



				$('#validation-form3').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: true,
					ignore: "",
					rules: {
						id: {
							required: true,
							minlength: 10
						},
						proyek: {
							required: true,
							minlength: 8,
							maxlength: 50
						},
						jenis: {
							required: true
						},
						lokasi: {
							required: true,
							minlength: 10,
							maxlength: 100
						},
						lahan: {
							required: true,
							minlength: 2,
							maxlength: 10,
							number: true
						},
						bangunan: {
							required: true,
							minlength: 2,
							maxlength: 10,
							number: true
						},
						totalbangunan: {
							required: true,
							minlength: 2,
							maxlength: 25
						},
						lantai: {
							required: true,
							minlength: 1,
							maxlength: 2,
							number: true
						},
						basement: {
							required: true,
							minlength: 1,
							maxlength: 2,
							number: true
						},
						owner: {
							required: true
						},
						arsitek: {
							required: true,
							minlength: 8,
							maxlength: 50
						},
						fungsi: {
							required: true,
							minlength: 8,
							maxlength: 50
						},
						tahun: {
							required: true,
							minlength: 4,
							maxlength: 4,
							number: true
						},
						tglmulai: {
							required: true
						},
						tglselesai: {
							required: true
						},
						cpassword: {
							required: true,
							minlength: 8,
							equalTo: "#password"

						}
					},

					messages: {
						id: {
							required: "Masukkan ID Proyek, contoh : MALL-10-BER-001.",
							minlength: "Minimal 10 Karakter."
						},
						proyek: {
							required: "Masukkan Nama Proyek.",
							minlength: "Minimal 8 Karakter.",
							maxlength: "Maksimal 50 Karakter."

						},
						lokasi: {
							required: "Masukkan Lokasi Proyek.",
							minlength: "Minimal 10 Karakter.",
							maxlength: "Maksimal 100 Karakter."

						},
						lantai: {
							required: "Masukkan Jumlah Lantai Proyek.",
							minlength: "Minimal 1 Karakter.",
							maxlength: "Maksimal 2 Karakter.",
							number: "Hanya Angka"

						},
						lahan: {
							required: "Masukkan Area Lahan Proyek.",
							minlength: "Minimal 2 Karakter.",
							maxlength: "Minimal 10 Karakter.",
							number: "Hanya Angka"

						},
						bangunan: {
							required: "Masukkan Area Bangunan Proyek.",
							minlength: "Minimal 2 Karakter.",
							maxlength: "Minimal 10 Karakter.",
							number: "Hanya Angka"
						},
						totalbangunan: {
							required: "Masukkan Area Total Bangunan Proyek.",
							minlength: "Minimal 2 Karakter.",
							maxlength: "Minimal 25 Karakter."
						},
						owner: {
							required: "Masukkan Nama Owner."
						},
						totalbangunan: {
							required: "Masukkan Area Total Bangunan Proyek.",
							minlength: "Minimal 2 Karakter.",
							maxlength: "Minimal 25 Karakter."
						},
						arsitek: {
							required: "Masukkan Nama Arsitek.",
							minlength: "Minimal 8 Karakter.",
							maxlength: "Maksimal 50 Karakter."
						},
						fungsi: {
							required: "Masukkan Fungsi Bangunan.",
							minlength: "Minimal 8 Karakter.",
							maxlength: "Maksimal 50 Karakter."
						},
						basement: {
							required: "Masukkan Jumlah Basement, jika tidak ada isi dengan 0.",
							minlength: "Minimal 1 Karakter.",
							number: "Hanya boleh angka atau nomor",
							maxlength: "Maksimal 2 Karakter."
						},
						tahun: {
							required: "Masukkan Tahun Dikerjakan nya Proyek.",
							minlength: "Minimal 4 Karakter.",
							number: "Hanya boleh angka atau nomor",
							maxlength: "Maksimal 4 Karakter."
						},
						cpassword: {
							required: "Masukkan Konfirmasi Password.",
							minlength: "Minimal 8 Karakter.",
							equalTo: "Password tidak cocok"
						},
						jabatan: "Pilih Jabatan",
						tglmulai: "Isi Tanggal Mulai Proyek",
						tglselesai: "Isi Tanggal Selesai Proyek",
						jenis: "Pilih Jenis Bangunan"
					},


					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},

					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},

					errorPlacement: function (error, element) {
						if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
							var controls = element.closest('div[class*="col-"]');
							if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
							else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
						}
						else if(element.is('.select2')) {
							error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
						}
						else if(element.is('.chosen-select')) {
							error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
						}
						else error.insertAfter(element.parent());
					}

				});

				$('#validation-form4').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: true,
					ignore: "",
					rules: {
						id: {
							required: true
						},
						passbaru: {
							required: true,
							minlength: 8
						},
						konpassbaru: {
							required: true,
							minlength: 8,
							equalTo: "#passbaru"

						}
					},

					messages: {
						id: {
							required: "Pilih Proyek."
						},
						passbaru: {
							required: "Masukkan Password.",
							minlength: "Minimal 8 Karakter."
						},
						konpassbaru: {
							required: "Masukkan Password.",
							minlength: "Minimal 8 Karakter.",
							equalTo: "Password tidak cocok"
						},
						tgl: "Masukkan Tanggal Lahir",
						jk: "Pilih Jenis Kelamin",
						gender: "Please choose gender",
						agree: "Please accept our policy"
					},


					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},

					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},

					errorPlacement: function (error, element) {
						if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
							var controls = element.closest('div[class*="col-"]');
							if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
							else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
						}
						else if(element.is('.select2')) {
							error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
						}
						else if(element.is('.chosen-select')) {
							error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
						}
						else error.insertAfter(element.parent());
					}

				});

				$('#validation-form5').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: true,
					ignore: "",
					rules: {
						<?php
						$lantai = aman($_GET['id']);

	$stmt = $user_home->runQuery("SELECT * FROM proyek WHERE id_proyek=:uid");
$stmt->execute(array(":uid"=>$lantai));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
	$jml = $terpilih['total_lantai']; 
$basement = $terpilih['total_basement']; 
	$ground = $terpilih['total_ground']; 

															for($lantai=1;$lantai<=$jml;$lantai++) {
						echo "idm".$lantai.": {
							required: true
						}, ";

						echo "ide".$lantai.": {
							required: true
						}, ";
					} 
					for($lantai=1;$lantai<=$basement;$lantai++) {
						echo "bm".$lantai.": {
							required: true
						}, ";

						echo "be".$lantai.": {
							required: true
						}, ";
					}
					for($lantai=1;$lantai<=$ground;$lantai++) {
						echo "gm".$lantai.": {
							required: true
						}, ";

						echo "ge".$lantai.": {
							required: true
						}, ";
					}
					?>

						passbaru: {
							required: true,
							minlength: 8
						},
						konpassbaru: {
							required: true,
							minlength: 8,
							equalTo: "#passbaru"

						}
					},

					messages: {
						<?php 
						for($lantai=1;$lantai<=$jml;$lantai++) {
							echo "idm$lantai: {
							required: 'Pilih Pegawai Mechanical'
						}, ";
						echo "ide$lantai: {
							required: 'Pilih Pegawai Electrical'
						}, ";
					} 
					for($lantai=1;$lantai<=$basement;$lantai++) {
							echo "bm$lantai: {
							required: 'Pilih Pegawai Mechanical'
						}, ";
						echo "be$lantai: {
							required: 'Pilih Pegawai Electrical'
						}, ";
					}
					for($lantai=1;$lantai<=$ground;$lantai++) {
							echo "gm$lantai: {
							required: 'Pilih Pegawai Mechanical'
						}, ";
						echo "ge$lantai: {
							required: 'Pilih Pegawai Electrical'
						}, ";
					}
					?>

						passbaru: {
							required: "Masukkan Password.",
							minlength: "Minimal 8 Karakter."
						},
						konpassbaru: {
							required: "Masukkan Password.",
							minlength: "Minimal 8 Karakter.",
							equalTo: "Password tidak cocok"
						},
						tgl: "Masukkan Tanggal Lahir",
						jk: "Pilih Jenis Kelamin",
						gender: "Please choose gender",
						agree: "Please accept our policy"
					},


					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},

					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},

					errorPlacement: function (error, element) {
						if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
							var controls = element.closest('div[class*="col-"]');
							if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
							else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
						}
						else if(element.is('.select2')) {
							error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
						}
						else if(element.is('.chosen-select')) {
							error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
						}
						else error.insertAfter(element.parent());
					}

				});

				/**
				$('#date').datepicker({autoclose:true}).on('changeDate', function(ev) {
					$(this).closest('form').validate().element($(this));
				});

				$('#mychosen').chosen().on('change', function(ev) {
					$(this).closest('form').validate().element($(this));
				});
				*/



			})
		</script>
		<script>
		jQuery(function($) {

				$( "#datepicker" ).datepicker({
					showOtherMonths: true,
					selectOtherMonths: false,
					//isRTL:true,


					/*
					changeMonth: true,
					changeYear: true,

					showButtonPanel: true,
					beforeShow: function() {
						//change button colors
						var datepicker = $(this).datepicker( "widget" );
						setTimeout(function(){
							var buttons = datepicker.find('.ui-datepicker-buttonpane')
							.find('button');
							buttons.eq(0).addClass('btn btn-xs');
							buttons.eq(1).addClass('btn btn-xs btn-success');
							buttons.wrapInner('<span class="bigger-110" />');
						}, 0);
					}
			*/
				});
				$( "#datepicker1" ).datepicker({
					showOtherMonths: true,
					selectOtherMonths: false,
					//isRTL:true,


					/*
					changeMonth: true,
					changeYear: true,

					showButtonPanel: true,
					beforeShow: function() {
						//change button colors
						var datepicker = $(this).datepicker( "widget" );
						setTimeout(function(){
							var buttons = datepicker.find('.ui-datepicker-buttonpane')
							.find('button');
							buttons.eq(0).addClass('btn btn-xs');
							buttons.eq(1).addClass('btn btn-xs btn-success');
							buttons.wrapInner('<span class="bigger-110" />');
						}, 0);
					}
			*/
				});
				});
				</script>
