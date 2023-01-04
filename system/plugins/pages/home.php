<?php
$news_starter = new newstarter();

class newstarter
{
	private $db;
	
	public function __construct()
	{
		$database = new online_connection();
		$db = $database->__Connect("", "", "", "", "yes");
		$this->db = $db;
    }

	public function news_show($query, $url, $read_more)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$rowCount = count($stmt->fetchAll());
		
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		
		if($rowCount>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$big = false;
				$string = strip_tags($row['content']);
				
				$image = array();
				preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $row['content'], $image);
								
				if (strlen($string) > 350) {
					$big = true;
					$stringCut = substr($string, 0, 350);
					$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <p><a href="'.$url.'read/'.$row['id'].'"><i class="fa-brands fa-readme"></i> '.$read_more.'</a></p>'; 
				}
				if(!$big)
					$string = $row['content'];
					include 'public/'.Theme::Used().'/partials/home.php';
			}
		}
	}
	
	public function limits($query,$records_per_page)
	{
		$starting_position=0;
		if(isset($_GET["page_no"]))
		{
			if(is_numeric($_GET["page_no"]))
				$starting_position=($_GET["page_no"]-1)*$records_per_page;
		}
		$query2=$query." limit $starting_position,$records_per_page";
		return $query2;
	}
	
	public function show_pages($query,$records_per_page,$self)
	{		
		$self = $self.'home/';
		$sql = "SELECT count(*) ".strstr($query, 'FROM');
		$stmt = $this->db->prepare($sql);
		$stmt->execute(); 
		$total_no_of_records = $stmt->fetchColumn();
		if($total_no_of_records > 0)
		{
			print '<br><br><ul class="pagination flex-c-c">';
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
				echo "<a class='number larger' href='".$self.$previous."'>&laquo;</a>&nbsp;&nbsp;";
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
			{
				if($i==$current_page)
				{
					echo "<a class='number active' href='".$self.$i."'>".$i."</a>&nbsp;&nbsp;";
				}
				else if($i>$total_no_of_pages)
					break;
				else
				{
					echo "<a class='number' href='".$self.$i."'>".$i."</a>&nbsp;&nbsp;";
				}
			}
			if($current_page!=$total_no_of_pages)
			{
				$next=$current_page+1;
				echo "<a class='number' href='".$self.$next."'>&raquo;</a>&nbsp;&nbsp;";
			}
			print '</ul>';
		}
	}
}