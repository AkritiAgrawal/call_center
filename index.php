<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Matrix Solutions Pvt. Ltd.</title>
<link rel='stylesheet' type='text/css' href='style.css'/> 
</head>
<div id="header_container">
    
		<?php include("header.php"); ?>
		
	</div>	
	<div id="parent">
		
		<div id="content">
			<?php
	
			if (isset($_GET["sec"])) {
			$sec = $_GET["sec"];
			if ($sec=="login") {
		 include("login.html"); 
 	} else if ($sec=="loggedIn") {
	include("login.php");
 	} else if ($sec=="Solution") {
		echo "<style type='text/css'>
		#content
		{
			left:3%;  position:relative;
		}
	</style>";
	include("Solution.php"); 
	?>
	</div>
	<?php
 	} else if ($sec=="verify") {
	include("verify.php"); 
 	} else if ($sec=="feedback") {
	include("feedback.php");
 	} else if ($sec=="login") {
	include("login.html");
 	} else if ($sec=="Registration") {
	include("registration.html"); 
 	} else if ($sec=="Customer") {
	include("registration_customer.php");
 	}
 	 else if ($sec=="registration_engineer") {
 		 include("registration_engineer.php");
 		 	}
	 else if ($sec=="request") {
		include("request.php");
 	} else if ($sec=="status") {
		include("status.php");
 	} else if ($sec=="admin") {
		include("admin.php");
 	} else if ($sec=="NewEngg") {
		include("NewEngg.php"); 
 	} else if ($sec=="actionEngg") {
 		  include("actionEngg.php") ; 
 	}else if ($sec=="assign") {
  include ("assign.php"); 
 	}
 	else if ($sec=="feedback") {
 		  include("feedback.php"); 
 		 	}
 	else if ($sec=="adminAction") {
 		  include("adminAction.php");
 		 	}
 	else if ($sec=="action") {
		  include("action.php");  
		 	}
 	
 	else if ($sec=="assigned") {
		  include("assigned.php"); 
		 	}
 	else if ($sec=="FAQ") {
		  include("FAQ.php");  
		 	}
			else if ($sec=="AddEngg") {
		  include("AddEngg.php");  
		 	}
			else if ($sec=="AddCust") {
		  include("AddCust.php");  
		 	}
	else if ($sec=="logout") {
		  include("logout.php");  
		 	}
	else if ($sec=="ClickToCallBack") {
		  include("ClickToCallBack.php");  
		 	}
	else if ($sec=="CallBackSolution") {
		  include("CallBackSolution.php");  
		 	}
	else if ($sec=="Reports") {
		  include("Reports.php");  
		 	}
	else if ($sec=="CustomerReport") {
		  include("CustomerReport.php");  
		 	}
	else if ($sec=="ERROR") {
		  include("ERROR.php");  
		 	}	
	else if ($sec=="intro") {
		  include("intro.html");  
		 	}				
 } else {
  include("main.html"); 
 	}
 	
 ?>
				
			</div>
	</div>	

	<div id="footer_container">
		<div id="footer"><?php include("footer.php") ?>
	
		</div>
	</div>