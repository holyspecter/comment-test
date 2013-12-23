function updateComments(comments) {
	$('.comment').remove();	
	for (i = 0; i < comments.length; i++) {		
		$('#comments-block').append(
			"<div class='comment'>"
				+ '<strong>' + comments[i].author + '</strong>' + " says:<br/>"
				+ comments[i].comment + "<br/>"
				+ "<span class='date'>" + comments[i].created_at + "</span>" +
			"</div>"
		);
	}
}

function addComment(comment) {	
	if (undefined !== comment) {		
		$('#comments-block').prepend(
			"<div class='comment'>"
				+ '<strong>' + comment.author + '</strong>' + " says:<br/>"
				+ comment.comment + "<br/>"
				+ "<span class='date'>" + comment.created_at + "</span>" +
			"</div>"
		);
		if (countComments >= perPage) {
			$('.comment:last').remove();
		}

		if (1 === countComments % perPage) {
			$('.navigation').append('<span class="page">' + (countComments / perPage + 1) +'</span>');
		}

		$('#form-errors').hide();
	} else {		
		$('#form-errors').show().text('Form is not valid. All fields are required!');		
	}
}

$(document).ready(function(){

	$('.page:first').addClass('current-page');

	// Adding comment
	$('#submit').click(function(){
		$.ajax({
			type: 'post',
			url: $('form#add-comment').attr('action'),
			data: {
				author: $('#author').val(),
				comment: $('#comment').val(),
				captcha: $('#captcha-text').val()
			},
			success: function(result){							
				addComment((result) ? JSON.parse(result) : undefined);
			}
		})		
	});

	// Navigation
	$('.page').click(function(){
		$('.current-page').removeClass('current-page');
		$(this).addClass('current-page');
		$.ajax({
			type: 'post',
			url: '#',
			data: {
				page: $(this).text()
			},
			success: function(result){															
				updateComments((result) ? JSON.parse(result) : undefined);
			}
		})
	});
});