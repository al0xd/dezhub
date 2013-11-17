<?php
class User{	

	function run()
	{
		
		
		$atask= $_REQUEST["atask"];
		$task= $_REQUEST["task"];
		
		switch ($atask)
		{	
			
			case 'group': 
				include_once("group.class".____EXTPHP);
				$manage_user= new AdminUserGroup();
				$manage_user->run($task);
				 break;
			case "user" :
				include_once("user.class".____EXTPHP);
				$manage_user= new AdminUser();
				switch ($task)
				{			
					case "edit":
						$manage_user->editUser();
						break;
					case "delete":
						$manage_user->deleteUser();
						break;
					case "multi_delete":
						$manage_user->deleteMultiUser();
						break;					
					case "add":
						$manage_user->addUser();
						break;
					default: case "list" :
						$manage_user->listUser( $_GET['msg'] );
						 break;
				}				
				 break;
			
				
		}
	}
		
}

?>