<?php

// wp_logout();


						if ($_POST['control'] == 'logon') {
							
							$username = htmlentities($_POST['username']);
							if(mb_strlen($username)>4){ 
							$password = $_POST['pass'];
							
							// Авторизуем
							$auth = wp_authenticate( $username, $password );
							
							$creds = array();
							$creds['user_login'] = $username;
							$creds['user_password'] = $password;
							$creds['remember'] = false;
							
							$user = wp_signon( $creds, false );
						}
					   else{
						   
                         				   
						$error_string="Невірний логін або пароль!";
							
						 
					   }
						}
						
						if( isset( $_GET['logout'] ) )
							{
								wp_logout();
								wp_redirect( home_url('/') );
							}
?>

<?php
/**
    Template Name: login
 * The template: login pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Vodokanal
 */

get_header('auth'); ?>
	

	<div id="heading"></div>
	<aside></aside>
	<section>

		<div class="login">
					
				<?php
						
					if ((is_user_logged_in()) || (!empty($user -> id))) {

						if (!is_user_logged_in()) { 
							$in_user = $user -> display_name; 
						} else { 
							$current_user = wp_get_current_user(); 
							$in_user = $current_user -> display_name;
						}
						echo '<div class="auth">';
						echo '<div class="auth-control">';
						//echo '<br><br>';
						echo "<span style='color : blue'>Особистий кабінет для споживачів багатоквартирного та приватних секторів<br><br></span>";
						//echo '<p>' . $error_string . '</p>';
						
						echo "Авторизація виконана успішно!<br>";
						echo "Ви зайшли як ".$in_user."<br>";
						echo "Вітаємо Вас у особистому кабінеті";	

				?>
				
			<!--
			<div class="uinfo" style="width: 80%"> -->
				<br>
				<table cellspasing="5" rules="all">
					<tr>
						<td colspan="5" style="border: 0px;">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="5" style="background-color: #229fff; color: #fff">Розділи особистого кабінету</td>
					</tr>
					<tr>
						<td colspan="5" style="border: 0px;">&nbsp;</td>
					</tr>
					<tr>
						<td style="border: 0px; width: 20px;"></td>
						<td style="border: 0px; text-align: left;">Інформація  (перелік послуг, діючий тариф)</td>
						<td style="border: 0px; vertical-align: middle;"><a style="width: 40px; height: 20px; padding-top: 0px; position: relative; top: 2px;" href="<?php echo get_permalink(363);?>"><span style="position: relative; top: -2px;">>></span></a></td>
						<td style="border: 0px; width: 20px;"></td>
					</tr>
					<tr>
						<td style="border: 0px; width: 20px;"></td>
						<td style="border: 0px; text-align: left;">Водоміри (внести показники)</td>
						<td style="border: 0px; vertical-align: middle;"><a style="width: 40px; height: 20px; padding-top: 0px; position: relative; top: 2px;" href="<?php echo get_permalink(365);?>"><span style="position: relative; top: -2px;">>></span></a></td>
						<td style="border: 0px; width: 20px;"></td>
					</tr>
					<tr>
						<td style="border: 0px; width: 20px;"></td>
						<td style="border: 0px; text-align: left;">Розрахунки (стан рахунку)</td>
						<td style="border: 0px; vertical-align: middle;"><a style="width: 40px; height: 20px; padding-top: 0px; position: relative; top: 2px;" href="<?php echo get_permalink(367);?>"><span style="position: relative; top: -2px;">>></span></a></td>
						<td style="border: 0px; width: 20px;"></td>
					</tr>
					<tr>
						<td style="border: 0px; width: 20px;"></td>
						<td style="border: 0px; text-align: left;">Оплата (сплатити онлайн)</td>
						<td style="border: 0px; vertical-align: middle;"><a style="width: 40px; height: 20px; padding-top: 0px; position: relative; top: 2px;" href="/water.kherson.ua/oplata/"><span style="position: relative; top: -2px;">>></span></a></td>
						<td style="border: 0px; width: 20px;"></td>
					</tr>
					<tr>
						<td style="border: 0px; width: 20px;"></td>
						<td style="border: 0px; text-align: left;">Профіль (особиста інформація)</td>
						<td style="border: 0px; vertical-align: middle;"><a style="width: 40px; height: 20px; padding-top: 0px; position: relative; top: 2px;" href="<?php echo get_permalink(371);?>"><span style="position: relative; top: -2px;">>></span></a></td>
						<td style="border: 0px; width: 20px;"></td>
					</tr>
                 <tr>
						<td style="border: 0px; width: 20px;"></td>
						<td style="border: 0px; text-align: left;">ЗАМОВИТИ ПОСЛУГУ ОНЛАЙН</td>
						<td style="border: 0px; vertical-align: middle;"><a style="width: 40px; height: 20px; padding-top: 0px; position: relative; top: 2px;" href="/water.kherson.ua/onlajn-servis/"><span style="position: relative; top: -2px;">>></span></a></td>
						<td style="border: 0px; width: 20px;"></td>
					</tr>
					
					
					
					
				</table>
			<!--
			</div> <!-- .uinfo -->
				
				<?php

					} else {
						
						
						if (is_wp_error( $user )) {
							//$error_string = $user->get_error_message();
							echo '<div class="auth">';
							echo '<div class="auth-control">';
							$error_string="Невірний логін або пароль!";
						    echo '<div id="message"  style="color:red"><br><br><h4>' . $error_string . '</h4></div>';
						} else {
							echo '<div class="auth">';
							echo '<div class="auth-control">';
						}
							vd_login();
							echo '<div class="auth-reg-button-long">';
							echo '<a href="'. get_permalink(386) . '">Зареєструватись</a>';
							echo '</div>';

							echo '<div class="auth-reg-button-long">';
							//echo '<a href="' . esc_url( wp_lostpassword_url() ) . '" title="Забули пароль?">Забули пароль?</a>';
							echo '<a href="/forgot-pass">Забули пароль?</a>';
							echo '</div>';

					}

						echo '<div class="auth-reg-button">';
						
						
				       // echo '<a href="'.wp_logout_url().'">Вийти</a>';
					   
					   	echo '<a href="'.$_SERVER['REQUEST_URI'].'?logout=true">Вийти</a>';
								
						//  ;
						echo '</div><!-- .auth-reg-button-long -->';	

				?>

				</div><!-- .auth-control -->
			</div><!-- .auth -->
		</div><!-- .login -->
		
		<script>
		jQuery(function ($){
	
	$(document).ready(function() { 
	$('body').on('click', '.password-checkbox', function(){
	if ($(this).is(':checked')){
		$('#pass').attr('type', 'text');
	} else {
		$('#pass').attr('type', 'password');
	}
}); 
		
	})
		}
		)
		</script>

	</section>


	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		</main><!-- #main -->
	</div><!-- #primary -->
	
	

<?php
get_sidebar();
get_footer('auth');
