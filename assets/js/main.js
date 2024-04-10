$(document).ready(function($) {
	$('.logout-js').on('click', function(event) {
		$.ajax({
			url: '../../core/logout/logout.php',
			method: 'post',
			dataType: 'json',
			success: function(data){
				console.log(data);
				if(data.status) {
					window.location.href = '../../login/login.php';
				}
			}
		});
	});
});