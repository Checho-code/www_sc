// autocomplet : this function will be executed every time we change the text
function autocomplet() {
	var min_length = 1; // min caracters to display the autocomplete
	var codigo = $('#codigo').val();
	if (codigo.length >= min_length) {
		$.ajax({
			url: 'ajx_vta_contado.php',
			type: 'POST',
			data: {codigo:codigo},
			success:function(data){
				$('#listado').show();
				$('#listado').html(data);
			}
		});
	} else {
		$('#listado').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	$('#codigo').val(item);
	// hide proposition list
	$('#listado').hide();
}