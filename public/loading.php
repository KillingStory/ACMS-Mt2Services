<script>
function timedRefresh(timeoutPeriod) 
{
	var timer = setInterval(function() 
	{
		if (timeoutPeriod > 0) {
			timeoutPeriod -= 1;
			document.body.innerHTML = "<center style='font-size:20px;margin-top:300px;'><div class='alert alert-danger' style='width:30%;'> The database connection could not be established!<br><br>We are trying to reconnect in:<b> " +timeoutPeriod + "</b>.." + "</div><br />";
			document.getElementById("countdown").innerHTML = timeoutPeriod + ".." + "<br /></center>";
		}
		else
		{
			clearInterval(timer);
				window.location.href = window.location.href;
		};
	}, 1000);
};
timedRefresh(8);
</script>