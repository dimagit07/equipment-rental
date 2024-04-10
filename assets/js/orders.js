$(document).ready(function($) {
	$('.order__status').on('click', changeStatus);

	function changeStatus(event) {
		let order_id = $(event.target).data('order');
		let status = $(event.target).data('status');
		$.ajax({
			url: '../../admin/update.php',
			method: 'post',
			dataType: 'json',
			data: {
				_method: 'put',
				order_id: order_id,
				status: status
			},
			success: function(data){
				if(data.status) {
					console.log(data.status);
					window.location.reload();
				} else {
					console.log(data.status);
					window.location.reload();
				}
			}
		});
	}
});