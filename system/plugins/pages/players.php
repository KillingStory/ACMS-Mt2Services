<?php
	include 'public/'.Theme::Used().'/partials/custom.php';
	if(isset($_POST['search']) && strlen($_POST['search'])>=3)
	{
		header("Location: ".Theme::URL()."class/players/1/".$_POST['search']);
		die();
	} else if(isset($_POST['search']) && $_POST['search']=='')
	{
		header("Location: ".Theme::URL()."class/players/1");
		die();
	}
	
	if(isset($_GET['player_name']))
	{
		$new_search = strip_tags($_GET['player_name']);
		if(strlen($new_search)>=3)
			$search = $new_search;
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
			$stmt = $this->db->prepare($query);
			if($search)
				$stmt->bindValue(':search', $search.'%');
			$stmt->execute();

			$rowCount = count($stmt->fetchAll());
			
			$stmt = $this->db->prepare($query);
			if($search)
				$stmt->bindValue(':search', $search.'%');
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
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{	
					$number++;
					include 'public/'.Theme::Used().'/partials/players.php';
				}
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
		
		public function pagelist($query,$records_per_page,$first,$last,$self,$search=NULL)
		{		
			$self = $self.'class/players/';
			
			$sql = "SELECT count(*) ".strstr($query, 'FROM');
			
			$stmt = $this->db->prepare($sql);
			if($search)
				$stmt->bindValue(':search', $search.'%');
			$stmt->execute(); 
			
			$total_no_of_records = $stmt->fetchColumn();
			
			if($total_no_of_records > 0)
			{
				?><br><br><ul class="pagination flex-c-c"><?php
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
						print "<a class='number' href='".$self.$previous."/".$search."'>&laquo;</a>&nbsp;&nbsp;";
					}
					else
					{
						print "<a class='number' href='".$self.$previous."'>&laquo;</a>&nbsp;&nbsp;";
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
							print "<a class='number active' href='".$self.$i."/".$search."'>".$i."</a>&nbsp;&nbsp;";
						else
							print "<a class='number active' href='".$self.$i."'>".$i."</a>&nbsp;&nbsp;";
					}
					else if($i>$total_no_of_pages)
						break;
					else
					{
						if($search)
							print "<a class='number' href='".$self.$i."/".$search."'>".$i."</a>&nbsp;&nbsp;";
						else
							print "<a class='number' href='".$self.$i."'>".$i."</a>&nbsp;&nbsp;";
					}
				if($current_page!=$total_no_of_pages)
				{
					$next=$current_page+1;
					if($search)
						print "<a class='number' href='".$self.$next."/".$search."'>&raquo;</a>&nbsp;&nbsp;";
					else
						print "<a class='number' href='".$self.$next."'>&raquo;</a>&nbsp;&nbsp;";
				}
				?></ul><?php
			}
		}
	}