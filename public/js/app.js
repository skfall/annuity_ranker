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
	},
	get_companies: function(event, self, curr_count, key_index, sort){
		var sort = sort || false;
		var curr_count = curr_count || 0;
		var key_index = key_index || 0;
		var form = $('#filter_form');
		var annuity_id = parseInt(form.find('input[name=type]:checked').val());
		var amount = parseInt(form.find('input[name=amount]').val()); 
		var spouse_rate = parseInt(form.find('input[name=spousal-rates]:checked').val());
		var age = parseInt(form.find('input[name=user-age]').val());
		var spouse_age = parseInt(form.find('input[name=spouse-age]').val());

		var response_log = form.find('.response');
		response_log.text("");
		$('#search_result').addClass('loading');

		if(annuity_id > 0){
			if (amount > 0) {
				if(age > 0){
					if (spouse_rate == 1) {
						if(spouse_age <= 0) {
							response_log.text("Enter spouse age.");	return;				
						}
					}
					network.post(RS + "ajax/", {
						action: "get_companies",
						annuity_id: annuity_id,
						amount: amount,
						spouse_rate: spouse_rate,
						age: age,
						spouse_age: spouse_age,
						curr_count: curr_count,
						old_url: document.location.href,
						key_index: key_index
					}, function(response){
						if (response.status == "success") {
							if (curr_count > 0 && !sort) {
								$('.show_more').remove();
								$('#search_result').append(response.html);								
							}else{
								if (sort) {
									var table_header = $('#search_result').find('.r-header-holder').clone();
									$('#search_result').html(table_header);
									$('#search_result').append(response.html);
								}else{
									$('#search_result').html(response.html);
								}
							}

							var new_url = response.new_url;
							if (new_url) {
								history.replaceState(null, null, new_url);
							}
						}else{
							response_log.text(response.message);
						}
						cs.initTabs();
						cs.initToggler();
						$('#search_result').removeClass('loading');
					}, "json");
				}else{
					response_log.text("Enter your age.");
				}
			}else{
				response_log.text("Enter amount.");
			}
		}else{
			response_log.text("Annuity type is not selected.");
		}
	},
	loadMore: function(){
		var curr_count = $('table[data-company]').length;
		network.get_companies(event, this, curr_count);
	},
	sort_table: function(key_index){
		var key_index = key_index || 1;
		var curr_count = $('table[data-company]').length;
		network.get_companies(event, this, curr_count, key_index, true);
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
