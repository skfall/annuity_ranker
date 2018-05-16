"use strict";

var network = {
	post: function(path, params, cb, type){
		$.ajax({
			url: path,
			type: 'post',
			data: params,
			headers: { "X-CSRF-TOKEN" : $('meta[name="_token"]').attr('content') },
			dataType: type,
			success: function (response, status) {
				if (status == "success") {
					if (response.reason == "token_timeout") {
						var new_token = response.new_token;
						$('meta[name="_token"]').attr('content', new_token);
						network.post(path, params, cb, type);
					}else{
						cb(response);
					}
				}
			}
		});
	},
	change_lang: function(lang, curr_page){
		network.post(RS + "ajax/", { action: 'change_lang', lang: lang, curr_page: curr_page }, function(response){
			if (response.status == "success") {
				document.location.href = response.new_destination;
			}
		}, "json");
	},
	register: function(){
		var form = $('#reg_form');
		var btn_wrapper = $('.reg_btn_wrapper');
		var btn = `
			<a class="waves-effect waves-light btn-large block" onclick="network.register()"><i class="material-icons left">check_circle</i>Register</a>
		`;
		btn_wrapper.html(`
			<div class="preloader-wrapper big active">
			<div class="spinner-layer spinner-blue-only">
			<div class="circle-clipper left">
			<div class="circle"></div>
			</div><div class="gap-patch">
			<div class="circle"></div>
			</div><div class="circle-clipper right">
			<div class="circle"></div>
			</div>
			</div>
			</div>
		`);
		this.post(RS + 'ajax/', form.serialize(), function(response){
			if (response.status == "success") {
				$('.reg_btn_wrapper').html("Successfull registration.");
				setTimeout(function(){
					document.location.href = RS + LANG + 'profile/';
				}, 1000);
			}else{
				btn_wrapper.html(btn);
			}
		}, "json");
		btn_wrapper.html(btn);
	},
	login: function(){
		var form = $('#login_form');
		var btn_wrapper = $('.reg_btn_wrapper');
		var btn = `
			<a class="waves-effect waves-light btn-large block" onclick="network.login()"><i class="material-icons left">person</i>Login</a>
		`;
		btn_wrapper.html(`
			<div class="preloader-wrapper big active">
			<div class="spinner-layer spinner-blue-only">
			<div class="circle-clipper left">
			<div class="circle"></div>
			</div><div class="gap-patch">
			<div class="circle"></div>
			</div><div class="circle-clipper right">
			<div class="circle"></div>
			</div>
			</div>
			</div>
		`);
		this.post(RS + 'ajax/', form.serialize(), function(response){
			if (response.status == "success") {
				$('.reg_btn_wrapper').html("Successfull login.");
				setTimeout(function(){
					document.location.href = RS + LANG + 'profile/';
				}, 1000);
			}else{
				btn_wrapper.html(btn);
			}
		}, "json");
		btn_wrapper.html(btn);
	},
	contactForm: function(){
		var post_data = $('#contact_form').serialize();
		this.post(RS + "ajax", post_data, function(response){
			if (response.status == "success") {
				$('.contact_response').text(response.message);
				$('#contact_form')[0].reset();
			}else{
				$('.contact_response').text(response.message);
			}
		}, "json");
	},
	answer: function(question_id, answer_id, annuity_id, annuity_alias, self){
		var question_id = question_id || 0;
		var answer_id = answer_id || 0;
		var annuity_id = annuity_id || 0;
		network.post(RS + "ajax/", {action: "user_answer", question_id: question_id, answer_id: answer_id}, function(response){
			if(annuity_id > 0) {
				setTimeout(function(){
					var last_question = $('.sct-block[data-annuity='+annuity_id+']').last();
					if(last_question.is($(self).closest('.sct-block'))){
						document.location.href = RS + "ranks/" + annuity_alias;
					}
				}, 100);
			}; 
		}, "json");
	}
};

var app = {
	start: function(){
		this.reinit();
		this.bind();
	},
	reinit: function(){
		
	},
	bind: function(){
		
	},
	log: (log_item) => {
		$('#log_target').append(log_item);
		var log_target = document.getElementById("log");
		log_target.scrollTop = log_target.scrollHeight;
	}
};

(function($){
	app.start();
})(jQuery);	
