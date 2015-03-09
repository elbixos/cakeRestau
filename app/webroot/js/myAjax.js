//$( "#listeProdFromProductLine" ).html( "Next Step..." );
//alert('boom');

$( document ).ready(function() {
	
	$('.prodLineShow').on('click', function(event){
		
		// Si la div de présentation est visible, on la cache
		if ( !$( "#listeProdFromProductLine" ).is( ":hidden" ) ) {
			$( "#listeProdFromProductLine" ).slideUp( "slow");
		}
		var pl_id = $(this).attr('product_line_id');
		//alert('clicked '+pl_id);
		$.ajax({
				dataType: "html",
				type: "POST",
				evalScripts: true,
				url: 'products/viewAjaxProductsFromProductLine/'+pl_id,
				//url: '/cakeGit/product_lines/mytest',
				data: ({type:'original'}),
				success: function (data, status){
					//alert(event.target);
					$("#listeProdFromProductLine").html(data);
					
					// On slide down le resultat
					$( "#listeProdFromProductLine" ).slideDown( "slow" );
				}
			});

	});
});
