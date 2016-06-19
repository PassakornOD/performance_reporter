// JavaScript Document
	// DATE Picker
	$(function() {
		$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd'});
		$( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd'});
	});
	
	// Hostname Picker
	$(function(){
	  $("select#hostgroup_id").change(function(){
		$("select#hostname_id").html("<option value='0'>waitng</option>");
		$.getJSON("ajax_load_hostname.php",{hostgroup: $(this).val(), ajax: 'true'}, function(j){
		  var options = '';
		  for (var i = 0; i < j.length; i++) {
			options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
		  }
		  $("select#hostname_id").html(options);
			
		})
	  })
	})
	
	// Menu Jumping
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
		if(selObj.selectedIndex == 3){
		  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		  if (restore) selObj.selectedIndex=1;
		}
	}
	
	// Menu Jumping2
	function MM_jumpMenu2(targ,selObj,restore){ //v3.0
		if(selObj.selectedIndex != 3){
		  eval(targ+".location='index.php?select="+selObj.options[selObj.selectedIndex].value+"'");
		  if (restore) selObj.selectedIndex=1;
		}
	}