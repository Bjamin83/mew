<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      
    <?php
    //Unterscheidung Page, Post, oder Kategorie für facebook setup:
    $akt_object = get_queried_object();
    if(isset($akt_object)){  
        $classtyp = get_class($akt_object);
    }else $classtyp = 'statisch';
    
    if($classtyp == "WP_Term"){
        //Kategorie setup:
        $url    = get_category_link( $akt_object->cat_ID );
        $title  = $akt_object->name;
        $descr  = $akt_object->description;
        if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
            $image = wp_get_attachment_url( get_post_thumbnail_id() );
        }else $image  = "STANDARDPFAD";
       
        
    }elseif($classtyp == "WP_Post"){
        //Post setup:
        $url    = get_permalink();
        $title  = $akt_object->post_title;
        $descr  = $akt_object->post_content;
        if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
            $image = wp_get_attachment_url( get_post_thumbnail_id() );
        }else $image  = "STANDARDPFAD";
        
        
    }else {
        //Statische Seite setup:
        $url    = home_url();
        $title  = "My Easy Wedding";
        $descr  = "Wir helfen dir bei deiner Hochzeit";
        $image  = "STANDARDPFAD";
        
    }
    
      /* TESTING:
    print_r($akt_object); 
      echo "<br />POST: <br />";
    print_r($aktueller_post);  
    */
    ?>  
     
    
    <meta name="description" content="<?php echo $descr; ?>">
    <meta name="author" content="MEW">  
    <meta property="og:url"                content="<?php echo $url; ?>" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="<?php echo $title; ?>" />
    <meta property="og:description"        content="<?php echo $descr; ?>" />
    <meta property="og:image"              content="<?php echo $image; ?>" />
      
      
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $title; ?></title>
    
 	<!-- URL zur Benutzung in js -->
 	<script>
		var templateUrl = "<?php bloginfo('template_directory') ?>";
	</script>  
     
      
    <!-- CSS -->
    <link href="<?php bloginfo( 'template_url' ); ?>/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php bloginfo( 'template_url' ); ?>/css/myeasywedding.css" rel="stylesheet">
 	<link href="<?php bloginfo( 'template_url' ); ?>/css/mew.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="<?php bloginfo( 'template_url' ); ?>/css/bootstrap-select.css" rel="stylesheet">
     
    <?php wp_head(); ?>
  </head>
<!-- NAVBAR
	
	              <a class="navbar-brand rd-logo" href="<?php echo home_url(); ?>"><img alt="Hochzeitplaner" src="<?php bloginfo( 'template_url' ); ?>/img/logo2.png"></a>
================================================== -->
  <body>
	
  	<!-- BENUTZERANMELDUNG 
    Link entfernen sonst kommt ein Seitenrefresh
--->
                
	<div class="container no-padding">

        <?php

        //Unterscheidung ob Anmelden oder Abmelden:
        $current_user = wp_get_current_user();

        if ($current_user->exists()){
            $ausgabe= '<a id="userLogout" class="nav-login" href="'. wp_logout_url() .'">
            		<img alt="my easy wedding" src="' . get_bloginfo(  "template_url" ) .' /img/Icon_Anmeldung.png">
            		<p>Abmelden</p>
        			
      			</a>';

        } else {

            $ausgabe= '<a id="userLogin" class="nav-login" href="#"><img alt="my easy wedding" src="' . get_bloginfo(  'template_url' ) . '/img/Icon_Anmeldung.png"><p>Anmelden</p></a>';

        }

        echo $ausgabe;

        ?>

        <nav class="navbar navbar-default navbar-static-top">
          <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="rd-logo" href="<?php echo home_url(); ?>"></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
            	<a class="nav-logo" href="<?php echo home_url(); ?>">
        			<img alt="my easy wedding" src="<?php bloginfo( 'template_url' ); ?>/img/logo.png">
      			</a>
                

            	
            <?php 
				    //Verschiedene Menüs für verschiedene Benutzerrollen
					$current_user = wp_get_current_user();
					if(isset($current_user->roles[0])){
						$current_user_role = $current_user->roles[0];
					}else {
					$current_user_role = '';
					}
					switch ($current_user_role) {      
                        case 'administrator':
                            $user_menu = 'admin';
                            break;
                        case 'standard_kunde':
                            $user_menu = 'registriert';
                            break;
                        default:
                            $user_menu = 'unregistriert';
                    }


				

				$defaults = array(
				'theme_location'    => 'hauptmenu',
				'menu' 	=> $user_menu, 
				'container'			=> false,
				'menu_class'		=>'nav navbar-nav',
				'deepth'			=> 2,
				'walker'			=> new wp_bootstrap_navwalker()
				
				);
				
				wp_nav_menu($defaults);
			?>
  
            </div>
          </div>
          


        </nav>


</div>

  

<div id="userpanelPopup" class="popupContainer">

    <div class="col-xs-10 col-sm-4 col-sm-offset-4">
    <?php  
        $args = array(
	'echo'           => true,
	'remember'       => true,
	'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
	'form_id'        => 'loginform',
	'id_username'    => 'user_login',
	'id_password'    => 'user_pass',
	'id_remember'    => 'rememberme',
	'id_submit'      => 'wp-submit',
	'label_username' => __( 'Username' ),
	'label_password' => __( 'Password' ),
	'label_remember' => __( 'Remember Me' ),
	'label_log_in'   => __( 'Log In' ),
	'value_username' => '',
	'value_remember' => false
    );
    
    wp_login_form( $args );     
    ?>
    
    <div class="pw-reg">
    <a href="http://localhost/mew/wordpress/wp-login.php?action=register">Registrieren</a>
         | 	
    <a href="http://localhost/mew/wordpress/wp-login.php?action=lostpassword" title="Passwortfundbüro">Passwort vergessen?</a>   
    </div>    
        
    </div>
    
    <div class="col-xs-1 no-padding">
        <div id="closeUserPanel">X</div>
    </div>
    
</div>      
      
      
<?php
      
      function getUserPanel(){
          
      }
      
      
?>
