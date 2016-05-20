var priceUnit   = 0;
var priceTot    = 0;
var placeDispo  = 0;
var placeZone   = "";
var placeBloc   = "";
var placeNb     = 0;
var jour        = "";

function selectBloc (bloc) {
                console.log(bloc);
                console.log(jour);
		$.ajax({
			"url": "php/placesdispo.php?bloc="+bloc+"&jour="+jour,
			"type":"POST",
			"dataType":"json",
			"success": function(data){
				$("#helpZone").text("");	
                                placeDispo = data.nb;
				if(placeDispo <= 0){
                                        $("#pZone").html(data.zone);
					$("#pBloc").html("<button class='btn btn-"+data.color+"' type='button'>" +data.bloc +" <span class='badge'>complet</span></button>");
                                        $("#inputPlaces").val(0);
					$("#inputTotal").val(0);
                                        placeBloc = data.bloc;
                                        placeZone = data.zone;
                                        priceUnit = 0;
                                        priceTot=priceUnit;
                                        $('#btnReserver').hide();
                                }else {
                                        $("#pZone").html(data.zone);
					$("#pBloc").html("<button class='btn btn-"+data.color+"' type='button'>" +data.bloc +" <span class='badge'>" +data.nb +"</span></button>   "+data.price+".00 €");
                                        $("#inputPlaces").val(1);
					$("#inputTotal").val(data.price);
                                        priceUnit=data.price;
                                        priceTot=priceUnit;
                                        placeZone=data.zone;
                                        placeBloc=data.bloc;
                                        placeNb=1;
                                        $('#btnReserver').show();
                                        $('#salleHelp').html("");
				}
				
			}
		});
}

function doSum(nbPlace, pricePlace){
    if (nbPlace.length === 0 ) nbPlace=0;
    return parseInt(nbPlace)*parseInt(pricePlace);  
}

$(document).ready(function(){
    
// scroll grayscale
	$(window).scroll(function() {
	    if ($(".navbar").offset().top > 50) {
	        $(".navbar-fixed-top").addClass("top-nav-collapse");
	    } else {
	        $(".navbar-fixed-top").removeClass("top-nav-collapse");
	    }
	});
		

		
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        //event.preventDefault();
    });
	
	$('.navbar-collapse ul li a').click(function() {
	    $('.navbar-toggle:visible').click();
	});
//////////////////////////////////////////////////////////////////

        $('#btnReserver').hide();
        jour =  $('#jour').text();
        //console.log(jour);
        // Zone bleue
	$("#bloc_a").click(function(){selectBloc("bloc_a");});
        $("#bloc_b").click(function(){selectBloc("bloc_b");});
        $("#bloc_c").click(function(){selectBloc("bloc_c");});
        $("#bloc_d").click(function(){selectBloc("bloc_d");});
	$("#bloc_f").click(function(){selectBloc("bloc_f");});
        $("#bloc_f0").click(function(){selectBloc("bloc_f0");});
        $("#bloc_e").click(function(){selectBloc("bloc_e");});
        $("#bloc_e0").click(function(){selectBloc("bloc_e0");});
        // Zone bleue sup
	$("#bloc_a_sup").click(function(){selectBloc("bloc_a_sup");});
        $("#bloc_b_sup").click(function(){selectBloc("bloc_b_sup");});
        $("#bloc_c_sup").click(function(){selectBloc("bloc_c_sup");});
        $("#bloc_d_sup").click(function(){selectBloc("bloc_d_sup");});
	$("#bloc_e_sup").click(function(){selectBloc("bloc_e_sup");});
        // Zone rouge
        $("#bloc_g").click(function(){selectBloc("bloc_g");});
        $("#bloc_h").click(function(){selectBloc("bloc_h");});
        $("#bloc_i").click(function(){selectBloc("bloc_i");});
	$("#bloc_j").click(function(){selectBloc("bloc_j");});
        $("#bloc_k").click(function(){selectBloc("bloc_k");});
        $("#bloc_z").click(function(){selectBloc("bloc_z");});
        $("#bloc_z0").click(function(){selectBloc("bloc_z0");});
        // Zone rouge sup
	$("#bloc_g_sup").click(function(){selectBloc("bloc_g_sup");});
        $("#bloc_h_sup").click(function(){selectBloc("bloc_h_sup");});
        $("#bloc_i_sup").click(function(){selectBloc("bloc_i_sup");});
        $("#bloc_j_sup").click(function(){selectBloc("bloc_j_sup");});
	$("#bloc_k_sup").click(function(){selectBloc("bloc_k_sup");});
        $("#bloc_z_sup").click(function(){selectBloc("bloc_z_sup");});
        $("#bloc_z0_sup").click(function(){selectBloc("bloc_z0_sup");});
        // Zone jaune
        $("#bloc_l").click(function(){selectBloc("bloc_l");});
	$("#bloc_m").click(function(){selectBloc("bloc_m");});
        $("#bloc_n").click(function(){selectBloc("bloc_n");});
        $("#bloc_o").click(function(){selectBloc("bloc_o");});
        $("#bloc_p").click(function(){selectBloc("bloc_p");});
	$("#bloc_q").click(function(){selectBloc("bloc_q");});
        $("#bloc_r").click(function(){selectBloc("bloc_r");});
        // Zone jaune sup
        $("#bloc_l_sup").click(function(){selectBloc("bloc_l_sup");});
        $("#bloc_m_sup").click(function(){selectBloc("bloc_m_sup");});
	$("#bloc_n_sup").click(function(){selectBloc("bloc_n_sup");});
        $("#bloc_o_sup").click(function(){selectBloc("bloc_o_sup");});
        $("#bloc_p_sup").click(function(){selectBloc("bloc_p_sup");});
        // Zone noire 
        $("#bloc_x").click(function(){selectBloc("bloc_x");});
        $("#bloc_v").click(function(){selectBloc("bloc_v");});
        $("#bloc_u").click(function(){selectBloc("bloc_u");});
        $("#bloc_t").click(function(){selectBloc("bloc_t");});
        $("#bloc_s").click(function(){selectBloc("bloc_s");});
      
        
        $('#inputPlaces').keyup(function(){
            placeNb=$("#inputPlaces").val();
            console.log(placeNb);
            if (parseInt($("#inputPlaces").val()) > placeDispo || placeNb == ""){
                if(placeNb == ""){
                    $('#salleHelp').html("");
                }else{
                    $('#salleHelp').html("<div class='alert alert-danger' role='alert'>Trop de places<br /><em>(Too much tickets)</em></div>");
                };
                $('#btnReserver').hide();
            }else{
                $('#salleHelp').html("");
                $('#btnReserver').show();
                priceTot = doSum($("#inputPlaces").val(), priceUnit);
                $("#inputTotal").val(priceTot);
            }
        });
        $('#btnReserver').click(function(){
            $.ajax({
                    "url": "php/doCommande.php",
                    "type":"POST",
                    "dataType":"json",
                    "data": {
                        "priceTot": priceTot, 
                        "placeNb": placeNb, 
                        "placeBloc":placeBloc,
                        "placeZone":placeZone 
                    },
                    "success": function(data){
                        console.log(data.msg);
                        document.location.href="confirmation.php";
                    }
                });
            
        });

        $('#btnConfirmer').click(function(){
            $.ajax({
                    "url": "php/doResmail.php",
                    "type":"POST",
                    "dataType":"json",
                    "success": function(data){
                        console.log(data.msg);
                        document.location.href="reservations.php";
                    }
                });
            
        });
    
});

