<?php
require_once('twitteroauth.php');
/**
 * @author FlorentGlauda <webmaster@vakario.com>
 * 
 */
 
 class SocialFeed extends Module
 {
	public function __construct()
	{
		$this->name				=	'socialfeed';
		$this->tab				=	'front_office_features';
		$this->version			=	1.1;
		$this->author			=	'vakario';
		$this->displayName		=	$this->l('Social Feed');
		$this->description		=	$this->l('Module d\'affichage de contenu provenant de réseaux sociaux');
		$this->confirmUninstall = 	$this->l('Etes-vous sur de vouloir désinstaller ce module?');
		$this->context 			= 	Context::getContext();
		$this->bootstrap		= 	true;
		$this->consumer_key		=	''; 
		$this->consumer_secret	=	''; 
		$this->oauth_token 		= 	''; 
		$this->oauth_token_secret = ''; 
		
		/*$this->context->smarty->assign('module_name', $this->name);*/
		
		parent :: __construct();
	}
	
	public function getContent()
	{
		$html='';
		if(Tools::isSubmit('submitSocialFeed'))
		{
			if(Tools::getValue('API_Key')!= '' || Tools::getValue('API_Secret')!= '' || Tools::getValue('Tweeter_name')!= '' || Tools::getValue('Access_token_key')!= '' || Tools::getValue('Access_token_secret')!= '')
			{
				 Configuration::updateValue('MWS_SOCIALFEED_API_KEY', Tools::getValue('API_Key'));
				 Configuration::updateValue('MWS_SOCIALFEED_APY_SECRET', Tools::getValue('API_Secret'));
				 Configuration::updateValue('MWS_SOCIALFEED_TWEETER_NAME', Tools::getValue('Tweeter_name'));
				 Configuration::updateValue('MWS_SOCIALFEED_ACCESS_TOKEN_KEY', Tools::getValue('Access_token_key'));
				 Configuration::updateValue('MWS_SOCIALFEED_ACCESS_TOKEN_SECRET', Tools::getValue('Access_token_secret'));
				 Configuration::updateValue('MWS_SOCIALFEED_POST_NUMBER', Tools::getValue('Post_number'));
				 Configuration::updateValue('MY_SOCIALFEED_FACEBOOK', Tools::getValue('my_socialfeed_facebook'));
				 Configuration::updateValue('MY_SOCIALFEED_TWITTER', Tools::getValue('my_socialfeed_twitter'));
				 Configuration::updateValue('MY_SOCIALFEED_YOUTUBE', Tools::getValue('my_socialfeed_youtube'));
				 Configuration::updateValue('MY_SOCIALFEED_GOOGLE_PLUS', Tools::getValue('my_socialfeed_google_plus'));
				 Configuration::updateValue('MY_SOCIALFEED_PINTEREST', Tools::getValue('my_socialfeed_pinterest'));
				 Configuration::updateValue('MY_SOCIALFEED_INSTAGRAM', Tools::getValue('my_socialfeed_instagram'));
				 $html .= $this->displayConfirmation($this->l('Paramètres mis à  jour avec succès'));
			}
			else
			{
				$html .= $this->displayError( $this->l('Erreur de mise à  jour. Veuillez vérifier que tout les champs du compte Twitter sont remplis et que les valeurs sont correctes') );
			}

		}
		
		$html .= $this->renderForm();
		return $html;
		
	}
	
	public function install()
	{
		return parent :: install()
		&& $this->registerHook('displayHome') 
		&& $this->registerHook('displayHeader')
		&& Configuration::updateValue('MWS_SOCIALFEED_API_KEY', '')
		&& Configuration::updateValue('MWS_SOCIALFEED_APY_SECRET', '')
		&& Configuration::updateValue('MWS_SOCIALFEED_TWEETER_NAME', '')
		&& Configuration::updateValue('MWS_SOCIALFEED_ACCESS_TOKEN_KEY', '')
		&& Configuration::updateValue('MWS_SOCIALFEED_ACCESS_TOKEN_SECRET', '')
		&& Configuration::updateValue('MWS_SOCIALFEED_POST_NUMBER', '')
		&& Configuration::updateValue('MY_SOCIALFEED_FACEBOOK', '') 
		&& Configuration::updateValue('MY_SOCIALFEED_TWITTER', '') 
		&& Configuration::updateValue('MY_SOCIALFEED_YOUTUBE', '') 
		&& Configuration::updateValue('MY_SOCIALFEED_GOOGLE_PLUS', '') 
		&& Configuration::updateValue('MY_SOCIALFEED_PINTEREST', '')
		&& Configuration::updateValue('MY_SOCIALFEED_INSTAGRAM', '');
		
	}
 
	public function hookDisplayHome($params)
	{
		$this->context->smarty->assign(array(
				'link_facebook' 	=> Configuration::get('MY_SOCIALFEED_FACEBOOK'),
				'link_twitter'		=> Configuration::get('MY_SOCIALFEED_TWITTER'),
				'link_youtube'		=> Configuration::get('MY_SOCIALFEED_YOUTUBE'),
				'link_google_plus'	=> Configuration::get('MY_SOCIALFEED_GOOGLE_PLUS'),
				'link_pinterest'	=> Configuration::get('MY_SOCIALFEED_PINTEREST'),
				'link_instagram'	=> Configuration::get('MY_SOCIALFEED_INSTAGRAM'),
		));
				
		$connection = new TwitterOAuth(Configuration::get('MWS_SOCIALFEED_API_KEY'), Configuration::get('MWS_SOCIALFEED_APY_SECRET'), Configuration::get('MWS_SOCIALFEED_ACCESS_TOKEN_KEY'), Configuration::get('MWS_SOCIALFEED_ACCESS_TOKEN_SECRET'));
		$query = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.Configuration::get('MWS_SOCIALFEED_TWEETER_NAME').'&count='.Configuration::get('MWS_SOCIALFEED_POST_NUMBER'); //Requète Twitter
		$content = $connection->get($query);
		if(!is_object($content))
		{
			$this->context->smarty->assign('feed_tweets', $content);
			return $this->display(__FILE__, 'home.tpl');
		}
	}
	
	public function hookDisplayHeader()
	{
		$this->context->controller->addCSS($this->_path.'css/socialfeed.css', 'all');
		$this->context->controller->addJS($this->_path.'js/socialfeed.js', 'all');
	}
	
	public function hookDisplayFooter($params)
	{
		return $this->hookDisplayHome($params);
	}
	
	public function renderForm ()
	{
	
	$options = array();
		for($i=1; $i<6; $i++)
		{
			array_push($options, array('id_option' => $i,'name' => $i));
		}

	$fields_form = array(
	'form' => array(
		'legend' => array(
			'title' => $this->l('Settings'),
			'icon' => 'icon-cogs'
		),
		
		'input' => array(
			array(
				'type' => 'text',
				'label' => $this->l('Tweeter name'),
				'name' => 'Tweeter_name',
			),
		
			array(
				'type' => 'text',
				'label' => $this->l('API key'),
				'name' => 'API_Key',
			),
	
			array(
				'type' => 'text',
				'label' => $this->l('API secret'),
				'name' => 'API_Secret',
			),
		
			array(
				'type' => 'text',
				'label' => $this->l('Access Token Key'),
				'name' => 'Access_token_key',
			),
		
			array(
				'type' => 'text',
				'label' => $this->l('Access Token Secret'),
				'name' => 'Access_token_secret',
			),
			
			array(
			  'type' => 'select',
			  'label' => $this->l('Post number'),
			  'name' => 'Post_number',
			  'options' => array(
				'query' => $options,
				'id' => 'id_option', 
				'name' => 'name'
						)
			),
			
			array(
				'type' => 'text',
				'label' => $this->l('Facebook URL'),
				'name' => 'my_socialfeed_facebook',
				'desc' => $this->l('Your official Facebook page link.'),
			),
			array(
				'type' => 'text',
				'label' => $this->l('Twitter URL'),
				'name' => 'my_socialfeed_twitter',
				'desc' => $this->l('Your official Twitter page link.'),
			),
			array(
				'type' => 'text',
				'label' => $this->l('YouTube URL'),
				'name' => 'my_socialfeed_youtube',
				'desc' => $this->l('Your official YouTube page link.'),
			),
			array(
				'type' => 'text',
				'label' => $this->l('Google Plus URL:'),
				'name' => 'my_socialfeed_google_plus',
				'desc' => $this->l('Your official Google Plus page link..'),
			),
			array(
				'type' => 'text',
				'label' => $this->l('Pinterest URL:'),
				'name' => 'my_socialfeed_pinterest',
				'desc' => $this->l('Your official Pinterest page link.'),
			),
			array(
				'type' => 'text',
				'label' => $this->l('instagram URL:'),
				'name' => 'my_socialfeed_instagram',
				'desc' => $this->l('Your official Instagram page link.'),
			),
				
			
			),
			
			
			'submit' => array(
			'title' => $this->l('Save')
						)	
				),
			);
					
		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table =  $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();

		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitSocialFeed';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(array($fields_form));
	}
	
	public function getConfigFieldsValues()
	{
		return array(
			'Tweeter_name' 				=> Configuration::get('MWS_SOCIALFEED_TWEETER_NAME'),
			'API_Key' 					=> Configuration::get('MWS_SOCIALFEED_API_KEY'),
			'API_Secret' 				=> Configuration::get('MWS_SOCIALFEED_APY_SECRET'),
			'Access_token_key' 			=> Configuration::get('MWS_SOCIALFEED_ACCESS_TOKEN_KEY'),
			'Access_token_secret'		=> Configuration::get('MWS_SOCIALFEED_ACCESS_TOKEN_SECRET'),
			'Post_number' 				=> Configuration::get('MWS_SOCIALFEED_POST_NUMBER'),
			'my_socialfeed_facebook' 	=> Configuration::get('MY_SOCIALFEED_FACEBOOK'),
			'my_socialfeed_twitter'		=> Configuration::get('MY_SOCIALFEED_TWITTER'),
			'my_socialfeed_youtube'		=> Configuration::get('MY_SOCIALFEED_YOUTUBE'),
			'my_socialfeed_google_plus'	=> Configuration::get('MY_SOCIALFEED_GOOGLE_PLUS'),
			'my_socialfeed_pinterest'	=> Configuration::get('MY_SOCIALFEED_PINTEREST'),
			'my_socialfeed_instagram'	=> Configuration::get('MY_SOCIALFEED_INSTAGRAM')
		);
	}
 
	public function uninstall()
	{
		return 	Configuration::deleteByName('MWS_SOCIALFEED_TWEETER_NAME') &&
				Configuration::deleteByName('MWS_SOCIALFEED_API_KEY') &&
				Configuration::deleteByName('MWS_SOCIALFEED_APY_SECRET') &&
				Configuration::deleteByName('MWS_SOCIALFEED_ACCESS_TOKEN_KEY') &&
				Configuration::deleteByName('MWS_SOCIALFEED_ACCESS_TOKEN_SECRET') &&
				Configuration::deleteByName('MWS_SOCIALFEED_POST_NUMBER') &&
				Configuration::deleteByName('MY_SOCIALFEED_FACEBOOK') && 
				Configuration::deleteByName('MY_SOCIALFEED_TWITTER') && 
				Configuration::deleteByName('MY_SOCIALFEED_YOUTUBE') && 
				Configuration::deleteByName('MY_SOCIALFEED_GOOGLE_PLUS') && 
				Configuration::deleteByName('MY_SOCIALFEED_PINTEREST') &&
				Configuration::deleteByName('MY_SOCIALFEED_INSTAGRAM') &&
				parent::uninstall();
	}
 }
 ?>