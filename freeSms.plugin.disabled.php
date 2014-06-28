<?php
/*
@name Free SMS
@author Quintard clement <clement@quintard.me>
@link http://quintard.me
@licence CC by nc sa
@version 1.0.0
@description Permet l'envoi d'alert SMS pour les aboner free moble
*/

//Si vous utiliser la base de donnees a ajouter
//include('freeSmsConfig.class.php');

//Cette fonction va generer un nouveau element dans le menu
function freeSms_plugin_menu(&$menuItems){
	global $_;
	$menuItems[] = array('sort'=>10,'content'=>'<a href="index.php?module=freeSms"><i class="icon-th-large"></i> Config/Envois SMS </a>');
}

//Cette fonction va generer une page quand on clique sur Modele dans menu
function freeSms_plugin_page($_){
	global $_,$conf;
	if(isset($_['module']) && $_['module']=='freeSms'){
	?>

	<div class="span12">
		<h1>Configuration SMS</h1>
		<p>Configuration et envoi de SMS pour les clients free mobile</p>
		
		pour la configuration de l'espace free référez vous a ce lien : 
		<a href="http://www.nextinpact.com/news/88097-avec-free-mobile-vos-appareils-connectes-peuvent-vous-envoyer-sms.htm">http://www.nextinpact.com/news/88097-avec-free-mobile-vos-appareils-connectes-peuvent-vous-envoyer-sms.htm</a>
		
		<form  class="form-inline"  method="post" action="action.php?action=freeSms_plugin_setting">
			ID : <input type="textbox" class="input-large" name="identifiant" value="<?php echo $conf->get('plugin_freesmsm_identifiant');?>" />
			Pass : <input type="textbox" class="input-large" name="password" value="<?php echo $conf->get('plugin_freesmsm_password');?>"  />
			<input type="submit"   class="btn" value="sauvegarder"/>
		</form>
		
		<form  class="form-inline"  method="post" action="action.php?action=freeSms_sendSms">
			message : <input type="textbox" class="input-large" name="message" />
			<input type="hidden" name="test" value="1" />
			<input type="submit"   class="btn" value="Envoyer sms test"/>
		</form>


	</div>
<?php
	}
}



function freeSms_action()
{
	global $_,$conf;

	switch($_['action'])
	{
		case 'freeSms_plugin_setting':
			$conf->put('plugin_freesmsm_identifiant',$_['identifiant']);
			$conf->put('plugin_freesmsm_password',$_['password']);
			
			header('location:index.php?module=freeSms');
		break;

		case 'freeSms_sendSms':
			global $_;
			$id = $conf->get('plugin_freesmsm_identifiant');
			$pass = $conf->get('plugin_freesmsm_password');
			if(isset($id ) && isset($pass))
			{
				$url = "https://smsapi.free-mobile.fr/sendmsg?user=".$id."&pass=".$pass."&msg=".$_['message'];
				
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; fr-FR; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1" ); // required by wikipedia.org server; use YOUR 
				//curl_setopt($ch, CURLOPT_HEADER, 0);

				// grab URL and pass it to the browser
				curl_exec($ch);

				// close cURL resource, and free up system resources
				//curl_close($ch);
				
				if($_['test']==1)
				{
					header('location:index.php?module=freeSms');
				}
				else 
				{			
					$response = array('responses'=>array(
												array('type'=>'sound','file'=>$_['sound'])
															)
										);
					$json = json_encode($response);
					echo ($json=='[]'?'{}':$json);
				}
			}
			else 
			{
				throw new Exception('Veuillez saisir la configuration free SMS.'); 
			}
			
			break;
			
	}
}

Plugin::addCss("/css/style.css"); 
//Plugin::addJs("/js/main.js"); 

Plugin::addHook("menubar_pre_home", "freeSms_plugin_menu");  
Plugin::addHook("home", "freeSms_plugin_page");  
Plugin::addHook("action_post_case", "freeSms_action"); 
?>