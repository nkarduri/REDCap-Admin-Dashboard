$(document).ready(function() {
	$("#btn-login").click(function() {
		var username = $("#username").val();
		var password = $("#password").val();

		$("#error_msg").show();
		$("#error_msg").load("auth.php", {username: username, password: password});

		return false;

	});


	$("#myForm").keypress(function(event) { 
    		if (event.which == 13) {
			event.preventDefault();
			var username = $("#username").val();
			var password = $("#password").val();

			$("#error_msg").show();
			$("#error_msg").load("auth.php", {username: username, password: password});

			return false;
    		}
	});


});