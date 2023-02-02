function cargar_carrito(idProducto, unidad) {
	var min_length = 1; // minimo de caracteres para mostrar autocompletado
	var cantidad = 1;
	if (cantidad.length >= min_length && cantidad>0) {
		$.ajax({
			async:true,
			url: 'ajx_cargar_carrito.php',
			type: 'POST',
			//contentType:"aplication/x-www-form-urlencoded",
			data: {cantidad:cantidad, producto:idProducto},
			//success:function(data){
				//$('#listado').show();
				//$('#listado').html(data);
				//alert('Agregado');
			//}
		});
	}
}

