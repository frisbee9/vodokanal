
<?php 
error_reporting(0);
if(!is_user_logged_in()) {
  wp_safe_redirect(home_url('/login')); exit; } ?>
  

<?php

/**
    Template Name: user_counters
 * The template: User counters pages
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

 
 
 
 
 
 
function myPrintVneski($row,$flag)
{
		echo "<tr>";
	
	echo "<td style=\"border: none;background-color: #fff\"></td>";
	echo "<td>".date_norm($row['val_date'])."</td>";
	echo "<td>".$row['val']."</td>";

	echo "<td>".$row['src']."</td>";
	
	echo "</tr>";
}

$uacc = 0;
if( current_user_can('view_as_proxy') ){
	$user_role = 'operator';
	$uacc = get_uacc();
	if ($uacc > 0) { $is_proxy = 1; } else { $is_proxy = 0; }
} else {
	$user_role = 'user';
	$is_proxy = 0;
}

$now_user = get_account_info($uacc);

$last_value = get_last_value($now_user['account']);

if($last_value['date_val']<'2021-12-31')//2022-01-01 менялся тариф
				{
				
				               $inputDate=date('Ymd');
				 $day1=date_diff(new DateTime('20211231'), new DateTime($last_value['date_val']))->days;
				 $day2= date_diff(new DateTime($inputDate), new DateTime('20211231'))->days;
				 $day=$day1+$day2;
				
				 
					if(($now_user['tarif_in']>0) && ($now_user['tarif_out']>0)) {
					
					
				     $tarif1=29.34;
					 $tarif2=30.696;
					 $tarif=30.696;
					
					
				    }
					elseif(($now_user['tarif_in']>0) && ($now_user['tarif_out']==0))
        			{
					
					 $tarif1=15.156;
					 $tarif2=15.78;
					 $tarif=15.78;
					
						 
					}elseif(($now_user['tarif_in']==0) && ($now_user['tarif_out']>0))
					{
					
					$tarif1=14.184;
					$tarif2=14.916;
					$tarif=14.916;
					
				    }	
					
					
				$tar=$tarif1*$day1/$day+$tarif2*$day2/$day;	
					
		 
				}else{
				 	
				 $tarif2=0;
                 $tarif1=0;
				 
                 if(($now_user['tarif_in']>0) && ($now_user['tarif_out']>0)) {
					
					
				     $tarif=29.34;
					
				    }
					elseif(($now_user['tarif_in']>0) && ($now_user['tarif_out']==0))
        			{
					
					 $tarif=15.156;
						
					}elseif(($now_user['tarif_in']==0) && ($now_user['tarif_out']>0))
					{
					
					
					$tarif=14.184;
					
				    }	
				 
				 $tar=$tarif;
				 
				 
				}				

 
				
				
				

//$tarif=(($now_user['population']-$now_user['privil_count'])*$now_user['tarif']+$now_user['privil_count']*$now_user['privil_tarif'])/$now_user['population'];


$result['control'] = 0;
$result['msg'] = '';

//echo $now_user['seal'];

if (($_POST['op_type'] == "set_indicate") && (isset($_POST['button1']))) {
	if (!empty($_POST['account'])) {	
		$ccounters=array();
		if (!empty($_POST['ccounts']))
			$ccounters=$_POST['ccounts'];
		$last_value = get_last_value($now_user['account']);
		if (empty($last_value['val'])) {
			$value_data['p_val'] = $now_user['indicate'];
			$value_data['date_p_val'] = date2sql($now_user['date_indicate']);
		} else {
			$value_data['p_val'] = $last_value['val'];
			$value_data['date_p_val'] = $last_value['date_val'];
		}
		$value_data['account'] = $_POST['account'];
		$value_data['val'] = $_POST['indicate'];
		
		$value_data['seal']=$now_user['seal'];
		
		$value_data['src'] = "особистий кабiнет";
		$value_data['avans'] = $now_user['avans'];
		
		
		
		
		$result = add_value($value_data);
		
		if($result['control']==1){
		$value = $now_user['last_count']+$now_user['cubavans'];
		
		
		
		$rizn=$value_data['val']-$value;
		
	
		
		$sum=$tar*$rizn;
		
		
		$vodata['account']=$_POST['account'];
		
		$vodata['data']=$sum;
		$vodata['type_data']='2';
		$result1=add_data($vodata);
		
		$vodata['data']=$rizn;
		$vodata['type_data']='3';
		$result1=add_data($vodata);
		
		}
		
	}
}

if ($_POST['op_type'] == "get_indicate") {
	$value_data['account'] = $_POST['account'];
	$value_data['from_date'] = $_POST['from_year'].'-'.$_POST['from_date']."-01";
	$value_data['to_date'] = $_POST['to_year'].'-'.$_POST['to_date']."-31";
	$q = get_values($value_data);
	
	$f_mon = $_POST['from_date']; $f_year = $_POST['from_year'];
	$t_mon = $_POST['to_date']; $t_year = $_POST['to_year'];
} else {
	if ((empty($_POST['from_date'])) && (empty($_POST['to_date']))) {
	
		$to_date = date("Y-m-d");
		$value_data['to_date'] = $to_date;
		$from_date = get_from_date($to_date);
		$value_data['from_date'] = $from_date;
		
		$list = explode("-",$to_date);
		$t_year = $list[0];
		$t_mon = $list[1];
	
		$list = explode("-",$from_date);
		$f_year = $list[0];
		$f_mon = $list[1];
	
		$value_data['account'] = $now_user['account'];
		$q = get_values($value_data);
		
		//echo "From: ".$from_date."<br>";
		//echo "To: ".$to_date."<br>";
	}
}


$last_value_control = get_last_value_control($now_user['account'],'контролер особисто','контролер особисто');
$last_value = get_last_value($now_user['account']);
$user_last_val = $last_value['val'];
if ($user_last_val > $now_user['indicate']) {
	$now_user['indicate'] = $user_last_val;
	$now_user['date_indicate'] = date_norm($last_value['date_val']);
	$now_user['date_control'] = date_norm($last_value_control['date_val']);
	$now_user['indicate_prev'] = $last_value['p_val'];
	$now_user['indicate_period'] = date_norm($last_value['date_p_val'])."-".date_norm($last_value['date_val']);
	$now_user['consumed'] = $last_value['val'] - $last_value['p_val'];
	$now_user['src'] = $last_value['src'];
}

get_header('auth'); ?>
	
<script type="text/javascript">
/*
jQuery(function ($){
	var isDone=false;
	$(document).ready(function() { 
		$('input').keydown(function(e){
			if(e.keyCode===13){
				$("#target").click();
			}
		});		
		$("#target").click( function(event){ // лoвим клик пo ссылки с id="target"
		if(isDone===false){
			var t_pla=0;
			//console.log("t_pla =%d",t_pla);
			//console.log("t_pla =%d",$("p[name*='potoch'").text());
			var summ=0;
			var os_val=parseFloat($("p[name*='os_value'").text());
			var tek_val= +$("input[name*='indicate'").val();
			var os_bal=parseFloat($("p[name*='balan'").text());
			var t_pla=parseFloat($("p[name*='potoch'").text());
			
			var delta=tek_val-os_val;
			if((os_val<tek_val) && (delta < 90)){
				$("p[name*='teper'").text(tek_val+" м3");
				//console.log("t_pla =%d",$("p[name*='potoch'").text());
				var pokaznik=$("p[name*='summ'");
				//console.log("t_pla =%d",$("p[name*='potoch'").text());
				var rizn=$("p[name*='rizn'");
				
				
				var tar= parseFloat($("p[name='tarif'").text());
				
				
			    var tar1= parseFloat($("p[name*='tarif1'").text());
			
				var tar2= parseFloat($("p[name*='tarif2'").text());
				
				var day1= parseFloat($("p[name*='day1'").text());
				var day2= parseFloat($("p[name*='day2'").text());
				
				var day=day1+day2;
				
				if(tar1>0){
				
				var summ1=tar1*(tek_val-os_val)*day1/day;
				var summ2=tar2*(tek_val-os_val)*day2/day;
				
				
				var summ=summ1+summ2-os_bal-t_pla;
				
				}else{
					var summ=tar*(tek_val-os_val)-os_bal-t_pla;
					
				}


			
				
				
				
				
				
				var SumItogText = "Всього до сплати: ";
				
				
				if (summ < 0){
					SumItogText = "Переплата становить:";
					summ = summ*(-1);
					
				}
				
				
				 $("p[name*='borg'").text(SumItogText);
				//-parseFloat($("p[name*='potoch'").text());
				pokaznik.text(Math.round((summ)*100)/100 + " грн");
				rizn.text(Math.round((tek_val-os_val)*100)/100 + " м3");
				console.log("t_pla =%d",t_pla);				
				console.log("os_bal =%d",os_bal);
				console.log("sum    =%d",summ);
				console.log("tek_val=%d",tek_val);
				console.log("os_val =%d",os_val);
				console.log("tar    =%d",tar);
				console.log("os_bal =%d",os_bal);
				event.preventDefault(); // выключaем стaндaртную рoль элементa
				$('#overlay').fadeIn(400, // снaчaлa плaвнo пoкaзывaем темную пoдлoжку
					function(){ // пoсле выпoлнения предъидущей aнимaции
						$('#modal_form') 
							.css('display', 'block') // убирaем у мoдaльнoгo oкнa display: none;
							.animate({opacity: 1, top: '25%'}, 200); // плaвнo прибaвляем прoзрaчнoсть oднoвременнo сo съезжaнием вниз
				});///продолжить event.currentTarget.submit();
			}
		}
		});
		//var value =0;
		$("input[name*='ccounts'").on("input keyup",function(){
			value =0;
			$("input[name*='ccounts'").each(function (index, el){
				var valcount= parseFloat(this.value);
				if (isNaN( +valcount))
					valcount=0;
				value+= +valcount;
			});
			$("input[name*='indicate'").val(value);
			$("input[name*='indicate'").disabled = true;
			console.log(value);
		});
		
		$('#modal_close, #overlay, #modal_bu_ex').click( function(){ // лoвим клик пo крестику или пoдлoжке
			$('#modal_form')
				.animate({opacity: 0, top: '45%'}, 200,  // плaвнo меняем прoзрaчнoсть нa 0 и oднoвременнo двигaем oкнo вверх
					function(){ // пoсле aнимaции
						$(this).css('display', 'none'); // делaем ему display: none;
						$('#overlay').fadeOut(400); // скрывaем пoдлoжку
						alert('Ви не передали показники!!!Hеобхідно натиснути кнопку \"Підтвердити\"!!!!');
					}
				);
		});
		$('#modal_but').click( function(){ // лoвим клик пo крестику или пoдлoжке
			$('#modal_form')
				.animate({opacity: 0, top: '45%'}, 200,  // плaвнo меняем прoзрaчнoсть нa 0 и oднoвременнo двигaем oкнo вверх
					function(){ // пoсле aнимaции
						$(this).css('display', 'none'); // делaем ему display: none;
						$('#overlay').fadeOut(400); // скрывaем пoдлoжку
					}
				);
				isDone=true;
				$("#target").click();
		});
		$('#modal_save').click( function(){ // лoвим клик пo зберегти
			var os_val=parseFloat($("p[name*='os_value'").text());
			var tek_val= +$("input[name*='indicate'").val();
			var os_bal=parseFloat($("p[name*='balan'").text());
			var tar=parseFloat($("p[name*='tarif'").text());
			if (os_bal<0)
				borg="Загальна сума боргу";
			else
				borg="Передоплата становить";
			var text = " Після обробки показників\r\nнарахування по Вашому особовому рахунку складають\r\n\tСума до сплати\r\n"+
			borg+"\t"+os_bal+
			"\r\nПоточний платіж\t\t"+$("p[name*='potoch'").text()+
			"\r\nпопередні показники\t"+os_val+
			"\r\nтеперешні показники\t"+tek_val+
			"\r\nрізниця\t\t\t"+(tek_val-os_val)+
			"\r\nтариф\t\t\t"+tar+
			"\r\nВсього до сплати\t"+(Math.round((tar*(tek_val-os_val)-os_bal-parseFloat($("p[name*='potoch'").text()))*100)/100);
			var BlobBlob = new Blob([text], {type : 'text/plain;charset=UTF-8'});
			ww = URL.createObjectURL(BlobBlob);
			ll.href = ww;
			ll.click();
			//window.location = ww;
			//window.open(ww); 
		});	
	});
});*/
</script>
	
  <div id="heading"></div>
  <aside></aside>
  <section>
    
		<div class="user-page">
			
      <div class="uinfo">
				
				
				
				<?php 
					if ($result['control'] == 2) {
						echo '<span style="color : red">Помилка! '.$result['msg'].'<br>Перевірте вірність вказаних показників та спробуйте ще раз.<br></span>';
					}
					if ($result['control'] == 3) {
						echo '<span style="color : red">'.$result['msg'].'<br></span>';
					}
					if ($result['control'] == 11) {
						echo '<span style="color : red">Помилка! '.$result['msg'].'</span>';
					}
					
					
					
					if ($result['control'] == 1) {
						echo '<span>Ваші показники прийнято. Дякуємо за співпрацю.<br></span>';
						$ww=difference_calculation($now_user['account']);
						if (($ww== -1) or ($ww>359)) {
						echo '<span>Дякуємо за внесені показники!<br></span>';
						echo '<span>Вами внесені показники лічильника після перерви більше ніж 1 рік. Вам необхідно протягом місяця підтвердити інформацію щодо наданих показників одним із наступних способів:<br></span> ';
						echo '<span>1. Месенджер Viber 050-396-90-91, при передачі необхідно вказати:<br></span>';
						echo '<span>- номер особового рахунку;<br></span>';
						echo '<span>- адресу (вулиця, будинок, квартира);<br></span>';
						echo '<span>- прикріпити фото водолічильника (водолічильників) з цілісністю пломб та з останніми показниками.<br></span>';
						echo '<span>2. Надати заявку на виклик контролера, який зніме фактичні показники. Телефон для замовлення: +38(0552)43-58-58,42-22-33.<br></span>';
						}
					}
					
      	?>
		<br><br>
		<h2>
		<?php echo $now_user['account']." - ".$now_user['addr']."."; ?>
		 </h2>
		
      	<br><br>
			

					<h3 > <span style="color:#2849B8" >УВАГА! Показники за спожиті послуги водоспоживання надаються споживачем щомісячно у строк не пізніше 3 робочих днів місяця, наступного за розрахунковим.</span></h3><br><br>
		
      	<form method="post">
					<input type="hidden" name="account" value="<?php echo $now_user['account']; ?>">
					<input type="hidden" name="op_type" value="set_indicate">
	        <table cellspasing="5" rules="all">
	          <tr>
	            <td colspan="2" style="background-color: #229fff; color: #fff">ОСТАННЯ ДАТА ПОВІРКИ ВОДОМІРУ</td>
	            <td colspan="2"><?php echo $now_user['date_check']; ?></td>
	          </tr>
	          <tr>
	            <td colspan="2" style="background-color: #229fff; color: #fff">ОСТАННЯ ДАТА ПЕРЕВІРКИ ПОКАЗНИКІВ КОНТРОЛЕРОМ</td>
	            <td colspan="2"><?php 
				
				if(strtotime($now_user['date_check'])>strtotime($now_user['date_control']))
				{ echo $now_user['date_check'];}
				else{
				echo $now_user['date_control']; 
				}
				?></td>
	          </tr>
	        </table>
	          
	        <table cellspasing="5" rules="all">  
	          <tr>
	            <td rowspan="2" style="background-color: #229fff; color: #fff">ВИД ПОСЛУГ</td>
	            <!-- <td rowspan="2" style="background-color: #229fff; color: #fff">МОДЕЛЬ/ІНВ.№</td> -->
	            <td colspan="2" style="background-color: #229fff; color: #fff">ОСТАННІ ПОКАЗНИКИ</td>
	            <td rowspan="2" style="background-color: #229fff; color: #fff">ПОТОЧНІ ПОКАЗНИКИ</td>
	          </tr><tr>
	          	<td style="background-color: #229fff; color: #fff">ДАТА</td>
	            <td style="background-color: #229fff; color: #fff">ПОКАЗНИКИ</td>
	          </tr>
	          <tr>
	            <td>Водопостачання</td>
	            <!-- <td><?php //echo $now_user['counter_num']; ?></td> -->
	            <td>
				
				<?php 
			
			    echo $last_value['date_val']."<br>";
					
				 
				?>
				</td>
				
	            <td><?php 
				//echo $now_user['indicate']; 
					echo $last_value['val']."<br>";

				
				?>
				</td>
				
				

				
				
				
				
	            <td><input type="text" name="indicate" pattern='\d+(\.\d{2})?' required  size="10"></td>
	          </tr>
				<?php
				$now_user['сcount'];
				if ($now_user['сcount']>1){
					for ($i = 1; $i <= $now_user['сcount']; $i++) {				  
				?>
			  <tr>
				<td colspan="3" align="right"><?php echo $i." Лiчильник";?></td>
				<td><input type="text" name="ccounts[]"  value="" size="10">
			  </tr>
				<?php
						}
					}
				?>
	            <td style="border: 0px"></td>
	            <!-- <td style="border: 0px"></td> -->
	            <td style="border: 0px"></td>
	            <td style="border: 0px">
								<?php
								if ($is_proxy == 0) { ?>
									<button id="target"style="width:150px;height:30px;margin-top:5px" type="submit" name="button1" value="send">Надіслати</button>
								<?php }
								?>
							</td>
	            
	            <td style="border: 0px">
							<?php
							/*
								if ($is_proxy == 0) {
									echo '<div class="receipt-button">';
									echo '<a href="'.get_permalink(2050).'" target="_blank">Роздрукувати</a>';
									echo '</div><!-- .auth-reg-button-long -->';
								}
								*/
							?>
	            </td>
	          	<tr></tr>
			</table>
		</form>
	
				<form method="post">
					<input type="hidden" name="account" value="<?php echo $now_user['account']; ?>">
					<input type="hidden" name="op_type" value="get_indicate"> 
					<table cellspasing="5" rules="all">  
						<tr>
							<td colspan="2">
								Період з:
								<?php
									$in_date['sel_name'] = "from_date";
									$in_date['sel_style'] = "width:110px;height:25px";
									$in_date['sel_active'] = $f_mon;
									get_month_select($in_date);
								?>
							
								<?php
									$in_date['sel_name'] = "from_year";
									$in_date['sel_style'] = "width:90px;height:25px";
									$in_date['sel_active'] = $f_year;
									$in_date['sel_from'] = 2020;
									$in_date['sel_to'] = 2022;
									get_year_select($in_date);
								?>
							
							</td>
							<td colspan="2">
								до:
								<?php
									$in_date['sel_name'] = "to_date";
									$in_date['sel_style'] = "width:110px;height:25px";
									$in_date['sel_active'] = $t_mon;
									get_month_select($in_date);
								?>
								
								<?php
									$in_date['sel_name'] = "to_year";
									$in_date['sel_style'] = "width:90px;height:25px";
									$in_date['sel_active'] = $t_year;
									$in_date['sel_from'] = 2020;
									$in_date['sel_to'] = 2022;
									get_year_select($in_date);
								?>
								
	            </td>
	            <td colspan="3"><button style="width:150px;height:30px;margin-top:2px" type="submit">Шукати</button></td>
	          </tr>  
	          <tr>
	            <td colspan="7" style="background-color: #229fff; color: #fff">ІСТОРІЯ ВНЕСЕНИХ АБОНЕНТОМ ПОКАЗНИКІВ (ОБЛІКУ СПОЖИТОЇ ВОДИ)</td>
	          </tr>
			<tr>
				<td style=" color: #fff; border: none"></td>
	          	<td style="background-color: #229fff; color: #fff">ДАТА НАДАННЯ ПОКАЗНИКІВ</td>

	          
	          	<td style="background-color: #229fff; color: #fff">ПОКАЗНИКИ (КУБ.М)</td>
	            <!--<td style="background-color: #229fff; color: #fff">СПОЖИТО (КУБ.М)</td>-->
	            <td style="background-color: #229fff; color: #fff">ДЖЕРЕЛО</td>
	        </tr>
					<?php 
				    while ($row = mysql_fetch_array($q)) {
		            	
						echo "<tr>";
	
	echo "<td style=\"border: none;background-color: #fff\"></td>";
	echo "<td>".date_norm($row['val_date'])."</td>";
	


	echo "<td>".$row['val']."</td>";

	echo "<td>".$row['src']."</td>";
	
	echo "</tr>";
					}
     						
			

	         
	        ?>
	        </table>           
			
			
			
        </form>     
	<?php

	?>
      </div>
    </div>
    
	</section>


	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		</main><!-- #main -->
	</div><!-- #primary -->


	<!-- resources -->
	<datalist id="years">
		<option value="2018"></option>
		<option value="2019"></option>
		<option value="2020"></option>
		<option value="2021"></option>
		<option value="2022"></option>
		<option value="2023"></option>
		<option value="2024"></option>
		<option value="2025"></option>
	</datalist>       

	<datalist id="month">
		<option value="1">Січень</option>
		<option value="2">Лютий</option>
		<option value="3">Березень</option>
		<option value="4">Квітень</option>
		<option value="5">Травень</option>
		<option value="6">Червень</option>
		<option value="7">Липень</option>
		<option value="8">Серпень</option>
		<option value="9">Вересень</option>
		<option value="10">Жовтень</option>
		<option value="11">Листопад</option>
		<option value="12">Грудень</option>
	</datalist>
<div id="modal_form"><!-- Сaмo oкнo --> 
	<span id="modal_close">X</span> <!-- Кнoпкa зaкрыть --> 
	<?php
		


	
		$balance=check_data(payment_calculation($now_user['account']));
		$value = $now_user['last_count']+$now_user['cubavans'];
		
		
		//$tarif=(($now_user['population']-$now_user['privil_count'])*$now_user['tarif']+$now_user['privil_count']*$now_user['privil_tarif'])/$now_user['population'];
		
	
		
		
	   
	  ?>
	  <div style="display: none;">
	  <p name="balan">  <?php echo $balance['balance'];?></p>
	  <p name="potoch"> <?php echo $balance['payment'];?></p>
	  <p name="os_value"> <?php echo $value ; ?></p>
	  <p name="tarif1"> <?php echo $tarif1 ; ?></p>
	  <p name="tarif2"> <?php echo $tarif2 ; ?></p>
	  <p name="tarif"> <?php echo $tar ; ?></p>
	
	  
	  <p name="day1"> <?php echo $day1 ; ?></p>
	  <p name="day2"> <?php echo $day2; ?></p>
	  
	  </div>
	  <p style="text-align: center;"><span style="text-align: center; color: #1881d2;"><span style="color: #1881d2;">&nbsp;</span><span style="text-align: center; color: #1881d2;">Після обробки показників</br></span><span style="text-align: center; color: №;">нарахування по Вашому особовому рахунку складають</span></span></p>

		<table>
			<tr>
				<td colspan="2" align="center">Сума до сплати</td>
			</tr>
			<tr>
			<?php if ($balance['balance']<0){ ?>
				<td>Загальна сума боргу</td>
				<td style="width: 95px;"><?php echo number_format($balance['balance'], 2, ',', ' '); ?>грн</td>
			</tr>
			<tr>	<!-- resources 
				<td>Платіж за договором </br>реструктурізації</td>-->
				<td></td>
				<td></td>
			<?php
			}
			else { 
			?>	
				<td>Переплата становить</td>
				<td style="width: 95px;"><?php echo number_format($balance['balance'], 2, ',', ' '); ?> грн</td>
			<?php 
			}
			?>
			</tr>
			<tr>
				<td>Поточний платіж</td>
				<td><?php echo number_format($balance['payment'], 2, ',', ' '); ?> грн</td>
			</tr>
			<!---
			<tr>
				<td>попередні показники </td>
				<td><?php //echo number_format($value, 0, ',', ' ')." м3 "; ?> </td>
			</tr>
			
			-->
			
			<tr>
				<td>теперішні показники</td>
				<td><p name ="teper"><?php //echo number_format($receipt_sum , 2, ',', ' '); ?></p></td>
			</tr>
			<tr>
				<td>різниця</td>
				<td ><p name ="rizn"> </p></td>
			</tr>
			
			
			<tr >
				<td>тариф</td>
				<td><?php echo number_format($tar, 3, ',', ' ')." грн" ; ?></td>
			</tr>
           	
			<tr>
				<td><p name ="borg">  </p></td>
				<td><p name ="summ"><?php //echo number_format($receipt_sum , 2, ',', ' '); ?></p></td>
			</tr>
		</table>		
		<div id="div_left"><button id="modal_but" type="submit" value="Підтвердити ">Підтвердити</button>
		<div id="div_right"><button id="modal_bu_ex" type="submit" value="Відміна">Відміна</button></div>
		<div id="center"><button id="modal_save" type="submit" value="Відміна">Друк</button></div></div>
		<p style="text-align: center;"><span style="text-align: center; color: #8111cf;">Цей розрахунок не є остаточним. Підсумковий розрахунок за надані послуги</span> 
		<span style="color: #FF0033;">буде сформовано до 10 числа наступного місяця</span>
		<a style="display: none;" download="text.txt" id="ll">text.txt</a>
</div>

<div id="overlay"></div><!-- Пoдлoжкa -->	

<?php
//get_sidebar();
get_footer('auth');
