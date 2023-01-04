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
				if(ResetPWCreditentials($abc, $bcd, $cde))
					return true;
				else return false;
			}
		}
	}
	if(VerificatorRP($login_id, $verif_ps, $accid))
	{
		$error_auth = 0;
		if(isset($_POST['resetpwsubmit']))
		{
			if($_POST['passwordReg']==$_POST['passwordRegs'])
			{
				$new_passwd=HashPW($_POST['passwordReg']);

				$stmt_newpas = $database->Account("UPDATE account SET password=:password WHERE id=:accid");
				$stmt_newpas->bindParam(':password', $new_passwd, PDO::PARAM_STR);
				$stmt_newpas->bindParam(':accid', $accid, PDO::PARAM_INT);

				if($stmt_newpas->execute())
				{
					$stmt_delplo = $database->Account("UPDATE account SET passlost='0' WHERE id=:accid");
					$stmt_delplo->bindParam(':accid', $accid, PDO::PARAM_INT);
					$stmt_delplo->execute();
					$return_message = '<div class="alert alert-success">'.l(91).'</div>';
				}
			}
			else 
				$return_message = '<div class="alert alert-warning">'.l(92).'</div>';
		}
	}
	else
		$error_auth = 1;
?>