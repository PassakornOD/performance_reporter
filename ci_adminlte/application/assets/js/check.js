<script language="javascript">
	function CheckNum(){
		if (event.keyCode < 48 || event.keyCode > 57){
			event.returnValue = false;
		}
	}
</script>
		
<script language="javascript">
	function check(txtVal,txtMass)
	{
		var pass1 = document.getElementById(txtVal);
		var message = document.getElementById(txtMass);
		var badColor = "#ff6666";
		if(pass1.value == ""){
			message.style.color = badColor;
			message.innerHTML = "*Require"
		}
	}  
</script>