<?php
	
	if(isset($_POST['search']) && strlen($_POST['search'])>=3)
	{
		header("Location: ".$site_url."admin/players/1/".$_POST['search']);
		die();
	} else if(isset($_POST['search']) && $_POST['search']=='')
	{
		header("Location: ".$site_url."admin/players/1");
		die();
	}
	
	if(isset($_GET['player_name']))
	{
		$new_search = strip_tags($_GET['player_name']);
		if(strlen($new_search)>=3)
			$search = $new_search;
	}
	
	if(isset($_POST['permanent']) && isset($_POST['accountID']))
	{
		PermanentBAN(intval($_POST['accountID']), $_POST['permanent']);
		
		$location = '';
		if(isset($_GET["page_no"]) && is_numeric($_GET["page_no"]) && $_GET["page_no"]>1)
			$location = $_GET["page_no"];
		else $location = 1;
		
		print "<script>window.location.replace('".Theme::URL()."admin_panel/players_management/1');</script>";
		die();
	}
	else if(isset($_POST['unban']) && isset($_POST['accountID']))
	{
		unBAN(intval($_POST['accountID']));
		
		$location = '';
		if(isset($_GET["page_no"]) && is_numeric($_GET["page_no"]) && $_GET["page_no"]>1)
			$location = $_GET["page_no"];
		else $location = 1;
		
		print "<script>window.location.replace('".Theme::URL()."admin_panel/players_management/1');</script>";
		die();
	} else if(isset($_POST['temporary']) && isset($_POST['accountID']) && isset($_POST['months']) && isset($_POST['days']) && isset($_POST['hours']) && isset($_POST['minutes']) && CheckColumns('availDt'))
	{
		$time_availDt = strtotime("now +".intval($_POST['months'])." month +".intval($_POST['days'])." day +".intval($_POST['hours'])." hours +".intval($_POST['minutes'])." minute");
		TempBAN(intval($_POST['accountID']), $_POST['temporary'], $time_availDt);
		
		$location = '';
		if(isset($_GET["page_no"]) && is_numeric($_GET["page_no"]) && $_GET["page_no"]>1)
			$location = $_GET["page_no"];
		else $location = 1;
		
		print "<script>window.location.replace('".Theme::URL()."admin_panel/players_management/1');</script>";
		die();
	}
	
	$paginate = new paginate();
	
	class paginate
	{
		private $db;
		
		public function __construct()
		{
			$database = new online_connection();
			$db = $database->__Connect(SERVER_IP, "player", SERVER_ID, SERVER_PW);
			$this->db = $db;
		}
		
		public function dataview($query, $search=NULL)
		{
			global $site_url;
			
			$stmt = $this->db->prepare($query);
			if($search)
				$search = str_replace(' ', '', $search);
			if(!filter_var($search, FILTER_VALIDATE_IP) === false)
				$stmt->bindValue(':ip', $search);
			else if($search)
				$stmt->bindValue(':search', '%'.$search.'%');
			$stmt->execute();

			$rowCount = count($stmt->fetchAll());
			
			$stmt = $this->db->prepare($query);
			if($search)
				$search = str_replace(' ', '', $search);
			if(!filter_var($search, FILTER_VALIDATE_IP) === false)
				$stmt->bindValue(':ip', $search);
			else if($search)
				$stmt->bindValue(':search', '%'.$search.'%');
			$stmt->execute();
			
			$number=0;
			if(isset($_GET["page_no"]))
			{
				if(is_numeric($_GET["page_no"]))
				{
					if($_GET["page_no"]>1)
						$number = ($_GET["page_no"]-1)*20;
				}
			}
			if($rowCount>0)
			{
				$availDt = CheckColumns('availDt');
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{	$number++;
					
					?>
				<tr>
					<td><?php print $row['account_id']; ?></td>
					<td><?php print $row['name']; ?><h6 style="float:right;"><small class="badge badge-secondary"><?php print 'Lv. '.$row['level']; ?></small></h6></td>
					<td><?php print $row['ip']; ?></td>
					<td><?php if($availDt && CheckBanned($row['account_id'])) print '<a class="text-danger" data-toggle="tooltip" data-html="true" data-placement="right" title="'.BanReason($row['account_id']).'</br>'.CheckBanned($row['account_id']).'">availDt</a>'; else if(checkStatus($row['account_id'])) print '<a class="text-success">OK</a>'; else print '<a class="text-danger" data-toggle="tooltip" data-html="true" data-placement="right" title="'.BanReason($row['account_id']).'">BLOCK</a>'; ?></td>
					<td class="exp-table">
						<center>
							<?php if(($availDt && CheckBanned($row['account_id'])) || !checkStatus($row['account_id'])) { ?>
							<a data-toggle="modal" data-id="<?php print $row['account_id']; ?>" class="btn btn-success btn-sm" href="#unban<?php print $row['account_id']; ?>"><i class="fa fa-check fa-1" aria-hidden="true"></i></a> 
							<?php } else { ?>
							<a data-toggle="modal" data-id="<?php print $row['account_id']; ?>" class="btn btn-danger btn-sm" href="#ban<?php print $row['account_id']; ?>"><i class="fa fa-ban fa-1" aria-hidden="true"></i></a> 
							<?php } if(ACP::CharsCount($row['account_id'])) { ?>
							<a data-toggle="modal" data-id="<?php print $row['account_id']; ?>" class="btn btn-warning btn-sm" href="#selectchar<?php print $row['account_id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-shield-halved"></i></a>
							<?php } ?>
						</center>
					</td>
				</tr>
				<div class="modal fade" id="ban<?php print $row['account_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="Ban" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="banModal"><?= l(117); ?></h5>
							</div>
							<div class="modal-body">
								<form method="POST" action="">
									<input type="hidden" name="accountID" id="accountID" value="<?php print $row['account_id']; ?>"/>
									<div class="form-group">
										<label for="reason"><?= l(118); ?></label>
										<textarea class="form-control" id="permanent" name="permanent" rows="3"></textarea>
									</div>
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary"><?= l(117); ?></button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= l(119); ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal fade" id="unban<?php print $row['account_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="unBan" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="unBanModal"><?= l(120); ?></h5>
							</div>
							<div class="modal-body">
								<form method="POST" action="">
									<input type="hidden" name="accountID" id="accountID" value="<?php print $row['account_id']; ?>"/>
									<input type="hidden" name="unban" id="unban" value=""/>
									<div class="form-group">
										<label for="reason"><?= l(121); ?></label>
									</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary"><?= l(120); ?></button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= l(119); ?></button>
							</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="selectchar<?php print $row['account_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="unBan" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="unBanModal">Select character</h5>
							</div>
							<div class="modal-body">
								<select class="form-control form-control-lg" onchange="if (this.value) window.location.href=this.value">
									<option>Select character</option>
									<?php
										$charslist = array();
										$charslist = ACP::CharsLists($row['account_id']);
										foreach($charslist as $show)
										{
											print '<option value="'.Theme::URL().'admin_panel/player_inventory/'.$show['id'].' ">'.$show['name'].'</option>';
										}
									?>
								</select>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= l(119); ?></button>
							</div>
						</div>
					</div>
				</div>
				
				<?php
				}
			}
			else
			{
				?>
				<tr>
				<td>Nothing here...</td>
				</tr>
				<?php
			}
			
		}
		
		public function paging($query,$records_per_page)
		{
			$starting_position=0;
			if(isset($_GET["page_no"]))
			{
				if(is_numeric($_GET["page_no"]))
					if($_GET["page_no"]>1)
						$starting_position=($_GET["page_no"]-1)*$records_per_page;
			}
			$query2=$query." limit $starting_position,$records_per_page";
			return $query2;
		}
		
		public function paginglink($query,$records_per_page,$self,$search=NULL)
		{		
			$self = $self.'admin_panel/players_management/';
			
			$sql = "SELECT count(*) ".strstr($query, 'FROM');
			
			$stmt = $this->db->prepare($sql);
			if($search)
				$search = str_replace(' ', '', $search);
			if(!filter_var($search, FILTER_VALIDATE_IP) === false)
				$stmt->bindValue(':ip', $search);
			else if($search)
				$stmt->bindValue(':search', '%'.$search.'%');
			$stmt->execute(); 
			
			$total_no_of_records = $stmt->fetchColumn();
			
			if($total_no_of_records > 0)
			{
				?><br><br><center><ul class="pagination"><?php
				$total_no_of_pages=ceil($total_no_of_records/$records_per_page);
				$current_page=1;
				if(isset($_GET["page_no"]))
				{
					if(is_numeric($_GET["page_no"]))
					{
						$current_page=$_GET["page_no"];
						
						if($_GET["page_no"]<1)
							print "<script>top.location='".$self."'</script>";
						else if($_GET["page_no"]>$total_no_of_pages)
							print "<script>top.location='".$self."'</script>";
					}
				}
				
				if($current_page!=1)
				{
					$previous = $current_page-1;
					if($search)
					{
						print "<li class='page-item'><a class='page-link' href='".$self."1/".$search."'>&laquo;</a></li>";
						print "<li class='page-item'><a class='page-link' href='".$self.$previous."/".$search."'>&laquo;</a></li>";
					}
					else
					{
						print "<li class='page-item'><a class='page-link' href='".$self."1'>1</a></li>";
						print "<li class='page-item'><a class='page-link' href='".$self.$previous."'>&laquo;</a></li>";
					}
				}
				
				$x=$current_page;

				if($current_page+3>$total_no_of_pages)
					if($total_no_of_pages-3>0)
						$x=$total_no_of_pages-3;
					else if($total_no_of_pages-2>0)
						$x=$total_no_of_pages-2;
					else if($total_no_of_pages-1>0)
						$x=$total_no_of_pages-1;
				
				for($i=$x;$i<=$x+3;$i++)
					if($i==$current_page)
					{
						if($search)
							print "<li class='page-item'><a class='page-link' href='".$self.$i."/".$search."' style='color:red;text-decoration:none'>".$i."</a></li>";
						else
							print "<li class='page-item'><a class='page-link' href='".$self.$i."' style='color:red;text-decoration:none'>".$i."</a></li>";
					}
					else if($i>$total_no_of_pages)
						break;
					else
					{
						if($search)
							print "<li class='page-item'><a class='page-link' href='".$self.$i."/".$search."'>".$i."</a></li>";
						else
							print "<li class='page-item'><a class='page-link' href='".$self.$i."'>".$i."</a></li>";
					}
				
				if($current_page!=$total_no_of_pages)
				{
					$next=$current_page+1;
					if($search)
						print "<li class='page-item'><a class='page-link' href='".$self.$next."/".$search."'>&raquo;</a></li>";
					else
						print "<li class='page-item'><a class='page-link' href='".$self.$next."'>&raquo;</a></li>";
				}
				?></ul></center><?php
			}
		}
	}