//$( "#listeProdFromProductLine" ).html( "Next Step..." );
//alert('boom');

$( document ).ready(function() {
	$('.testclick').on('click', function(event){
		var pl_id = $(this).attr('product_line_id');
		//alert('clicked '+pl_id);
		$.ajax({
				dataType: "html",
				type: "POST",
				evalScripts: true,
				url: '/cakeGit/products/viewAjaxProductsFromProductLine/'+pl_id,
				//url: '/cakeGit/product_lines/mytest',
				data: ({type:'original'}),
				success: function (data, status){
					//alert(event.target);
					$("#listeProdFromProductLine").html(data);

				}
			});
	});
});
