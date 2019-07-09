$(document).ready(function(){
	

	/* ACORDDION 
		$('h2.accordion').click(function(){
			$(this).next().slideToggle("slow");
			$('.calendario').remove();
		});
	*/
	
	
	
	$('#data_nascimento').focus(function(){
		$(this).calendario({ 
			target:'#data_nascimento',
			top:0,
			left:90
		});
	});
	
	$('#data_cadastro').focus(function(){
		$(this).calendario({ 
			target:'#data_cadastro',
			top:0,
			left:90
		});
	});
	
	$('#data_validade').focus(function(){
		$(this).calendario({ 
			target:'#data_validade',
			top:0,
			left:90
		});
	});
	
	
	$('#data_5_dia, #data_5_mes, #data_5_ano').focus(function(){
		$(this).calendario({ 
			targetDay :'#data_5_dia',
			targetMonth :'#data_5_mes',
			targetYear :'#data_5_ano',
			dateDefault: $('#data_5_dia').val()+"/"+$('#data_5_mes').val()+"/"+$('#data_5_ano').val(),
			referencePosition : '#data_5_dia'
		});
	});	
	
	$('#data_6').focus(function(){
		$(this).calendario({ 
			target :'#data_6',
			dateDefault:$(this).val(),
			minDate:'10/11/2008',
			maxDate:'25/01/2009'
		});
	});
});

