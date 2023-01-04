<?php
	$paginate = new paginate();
	class paginate
	{
		private $db;
		
		public function __construct()
		{
			$database = new online_connection();
			$db = $database->__Connect("", "", "", "", "yes");
			$this->db = $db;
		}
		
		public function dataview($query)
		{
			global $site_url;
			
			$stmt = $this->db->prepare($query);
			$stmt->execute();

			$rowCount = count($stmt->fetchAll());
			
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			
			$number=0;
			if(isset($_GET["page_no"]))
			{
				if(is_numeric($_GET["page_no"]))
				{
					if($_GET["page_no"]>1)
						$number = ($_GET["page_no"]-1)*10;
				}
			}
			if($rowCount>0)
			{
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{	$number++;
					
					?>
				<tr style="text-align: center;">
					<th scope="row"><?php print $number; ?></th>
					<td><?php print $row['code']; ?></td>
					<td><?php if($row['type']==1) print 'MD'; else if($row['type']==2) print 'JD'; else print 'item'; ?></td>
					<td><?php print $row['value']; ?></td>
					<td><form action="" method="POST"><input type="hidden" name="id" value="<?php print $row['id']; ?>"><input type="hidden" name="codeval" value="<?php print $row['code']; ?>"><button type="submit" name="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form></td>
				</tr>
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
			$self = $self.'admin_panel/voucher/';
			
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
				?><br><br><center><ul class="pagination pagination-sm"><?php
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