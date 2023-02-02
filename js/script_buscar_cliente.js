// autocomplet : this function will be executed every time we change the text
function autocomplet() {
	var min_length = 1; // minimo de caracteres para mostrar autocompletado
	var cliente = $('#cliente').val();
	if (cliente.length >= min_length) {
		$.ajax({
			url: 'ajx_buscar_cliente.php',
			type: 'POST',
			data: {cliente:cliente},
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
	$('#cliente').val(item);
	// hide proposition list
	$('#listado').hide();
}