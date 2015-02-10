$( "#listeProdFromProductLine" ).html( "Next Step..." );
//alert('boom');

$('#testclick').on('click', function(event){
	//alert('clicked');
	$.ajax({
            dataType: "html",
            type: "POST",
            evalScripts: true,
            //url: '/cakeGit/products/viewProductsFromProductLine/1',
			url: '/cakeGit/product_lines/mytest',
            data: ({type:'original'}),
            success: function (data, textStatus){
                $("#listeProdFromProductLine").html(data);

            }
        });
});
/*

*/