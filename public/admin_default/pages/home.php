<?php
	$update_version = file_get_contents('https://cms.mt2-services.eu/updater-acms/');
	if($_version!=$update_version)
	{
		$download_url = "https://cms.mt2-services.eu/updater-acms/?sitekey=".$siteownkey."&site=".Theme::URL().'&actualv='.$_version;
		$file = "update_".$update_version.".zip";
		$script = basename($_SERVER['PHP_SELF']);
		file_put_contents($file, fopen($download_url, 'r'));
		if(file_exists($file))
		{
			$path = pathinfo(realpath($file), PATHINFO_DIRNAME);
			$zip = new ZipArchive;
			$res = $zip->open($file);
			if ($res === TRUE) 
			{
				$zip->extractTo($path);
				$zip->close();
				if(file_exists($file) && unlink($file))
				{
					print '<script>UpdateTRUE("Homepage updated to version <b>'.$update_version.'</b>");</script>';
					print '<br><div class="alert alert-success"><center>Homepage updated to version <b>'.$update_version.'</b></center></div>';
				}
				else 
				{
					print '<br><div class="alert alert-danger"><center>I can\'t update homepage, probably you are banned, contact owner!</b></center></div>';
				}
			}
		}
		else 
		{
			print '<br><div class="alert alert-danger"><center>I can\'t update homepage, please contact owner!</b></center></div>';
		}
	}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
<div class="container-fluid py-4">
		<div class="row">
			<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
				<div class="card card-secondary">
					<div class="card-header pb-0">
						<h4 class="card-title"><i class="fa-solid fa-chart-simple"></i> <?= l(160); ?></h4><br>
						<h6 style="float:right;"></h6>
					</div>
					<div class="card-body">
						<canvas id="onlineplayers" width="400px" height="150px"></canvas>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
				<div class="card card-secondary">
					<div class="card-header pb-0">
						<h4 class="card-title"><i class="fa-solid fa-chart-simple"></i> <?= l(222); ?></h4><br>
						<h6 style="float:right;"></h6>
					</div>
					<div class="card-body">
						<canvas id="myChart" width="400px" height="150px"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
		<div class="col-lg-4 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary" style="height:580px;">
				<div class="card-header pb-0">
						<img src="<?= Theme::URL();?>style/empires/1.jpg"> <small> <b>Shinsoo</b></small>
					<h6 style="float:right;">
						<input type="button" onclick="reloadred()" class="btn btn-sm btn-warning" value="Refresh" />
					</h6>
				</div>
				<div class="card-body px-0 pb-2" style="margin-left:20px;display:block;"><center>
					<iframe src="<?=Theme::URL(); ?>?v=red" style="border:0px #ffffff none;" id="mapred" name="asdasd" scrolling="no" frameborder="1" marginheight="0px" marginwidth="0px" height="580px" width="500" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary" style="height:580px;">
				<div class="card-header pb-0">
						<img src="<?= Theme::URL();?>style/empires/2.jpg"> <small> <b>Chunjo</b></small>
					<h6 style="float:right;">
						<input type="button" onclick="reloadyellow()" class="btn btn-sm btn-warning" value="Refresh" />
					</h6>
				</div>
				<div class="card-body px-0 pb-2" style="margin-left:20px;display:block;"><center>
					<iframe src="<?=Theme::URL(); ?>?v=yellow" style="border:0px #ffffff none;" id="mapyellow" name="2" scrolling="no" frameborder="1" marginheight="0px" marginwidth="0px" height="580px" width="500" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary" style="height:580px;">
				<div class="card-header pb-0">
						<img src="<?= Theme::URL();?>style/empires/3.jpg"> <small> <b>Jinno</b></small>
					<h6 style="float:right;">
						<input type="button" onclick="reloadblue()" class="btn btn-sm btn-warning" value="Refresh" />
					</h6>
				</div>
				<div class="card-body px-0 pb-2" style="margin-left:20px;display:block;"><center>
					<iframe src="<?=Theme::URL(); ?>?v=blue" style="border:0px #ffffff none;" id="mapblue" name="3" scrolling="no" frameborder="1" marginheight="0px" marginwidth="0px" height="580px" width="500" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function reloadred(){document.getElementById("mapred").src+=""}function reloadyellow(){document.getElementById("mapyellow").src+=""}function reloadblue(){document.getElementById("mapblue").src+=""}var myBarChart,MAX_DATA_SET_LENGTH=5;function reLoad(){$.post("<?=Theme::URL();?>?v=general&chart=online_players",{name:name},function(a){var e=JSON.parse(a);adddata(e.online,e.chars,e.accounts)})}var stepsizes=20,canvas=document.getElementById("onlineplayers"),data={datasets:[{label:"Online Players",borderColor:"#6c757d",backgroundColor:"#6c757d",fill:!1,borderWidth:3},{label:"Created Characters",borderColor:"#910909",fill:!1,backgroundColor:"#910909",borderWidth:3,hidden:!0},{label:"Accounts Created",borderColor:"#1b39a7",fill:!1,backgroundColor:"#1b39a7",borderWidth:3,hidden:!0},]},options={scales:{yAxes:[{type:"linear",ticks:{stepSize:stepsizes,suggestedMax:stepsizes+40}}]},showLines:!0},onlineplayers=new Chart.Line(canvas,{data:data,options:options});function adddata(a=NaN,e=NaN,t=NaN,r=""){var s=onlineplayers.data.datasets,d=onlineplayers.data.labels,n=s[0].data,o=s[1].data,l=s[2].data,i=n.length,p=!1;i>MAX_DATA_SET_LENGTH&&(n.shift(),p=!0),p&&(d.shift(),o.shift(),l.shift()),n.push(a),o.push(e),l.push(t),d.push(r),onlineplayers.update()}setInterval(reLoad,2e3),setInterval(updatetable,2e3);var canvas=document.getElementById("myChart"),ctx=canvas.getContext("2d"),chartType="bar";Chart.defaults.global.defaultFontColor="grey";var xValues=["Shinsoo","Jinno","Chunjo","Other maps"],data={labels:xValues,datasets:[{backgroundColor:["#910909","#1b39a7","#c6b124","gray"],borderColor:"gray",data:[0,0,0,0]}]},options={legend:{display:!1},scales:{yAxes:[{ticks:{beginAtZero:!0}}]}};function init(){myBarChart=new Chart(ctx,{type:chartType,data:data,options:options})}function updatetable(){$.post("<?=Theme::URL();?>?v=general&chart=empire",{name:name},function(a){var e=JSON.parse(a);myBarChart.data.datasets[0].data[0]=e.emp1,myBarChart.data.datasets[0].data[1]=e.emp2,myBarChart.data.datasets[0].data[2]=e.emp3,myBarChart.data.datasets[0].data[3]=e.all,myBarChart.update()})}init();
</script>