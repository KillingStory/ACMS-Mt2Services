<?php
	$login_id = isset($_GET['login']) ? $_GET['login'] : null;
	$verif_ps = isset($_GET['psl']) ? $_GET['psl'] : null;
	$accid 	= isset($_GET['accid']) ? $_GET['accid'] : null;
	
	function VerificatorRP($abc, $bcd, $cde)
	{
		if($abc!=NULL && $bcd!=NULL && $cde!=NULL)
		{
			global $verif_ps;
			
			if(isset($verif_ps) && ($verif_ps!='0' || $verif_ps!='cfcd208495d565ef66e7dff9f98764da'))
			{
				if(ResetMLCreditentials($abc, $bcd, $cde))
					return true;
				else return false;
			}
		}
	}
	if(VerificatorRP($login_id, $verif_ps, $accid))
	{
		$error_ml = 0;
		if(isset($_POST['mailsubmit']))
		{
			if($_POST['newmail'])
			{
				$new_mail=$_POST['newmail'];

				$stmt_newml = $database->Account("UPDATE account SET email=:nemail WHERE id=:accid");
				$stmt_newml->bindParam(':nemail', $new_mail, PDO::PARAM_STR);
				$stmt_newml->bindParam(':accid', $accid, PDO::PARAM_INT);

				if($stmt_newml->execute())
				{
					$stmt_delml = $database->Account("UPDATE account SET maillost='0' WHERE id=:accid");
					$stmt_delml->bindParam(':accid', $accid, PDO::PARAM_INT);
					$stmt_delml->execute();
					$return_message = '<div class="alert alert-success">'.l(94).'</div>';
				}
			}
			else 
				$return_message = '<div class="alert alert-warning">'.l(95).'</div>';
		}
	}
	else
		$error_ml = 1;
?>