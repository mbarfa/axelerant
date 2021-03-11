<?php

namespace Drupal\axelerant_task\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;


class ExtendedSiteInformationForm extends SiteInformationForm {
 
   /**
   * {@inheritdoc}
   */
	  public function buildForm(array $form, FormStateInterface $form_state) {
		$site_config = $this->config('system.site');
		$form =  parent::buildForm($form, $form_state);
		$form['site_information']['siteapikey'] = [
			'#type' => 'textfield',
			'#title' => t('Site API Key'),
			'#default_value' => $site_config->get('siteapikey') ?: 'No API Key yet',
		];
		$form['actions']['submit']['#value'] = t('Update Configuration');
		return $form;
	}
	
	  public function submitForm(array &$form, FormStateInterface $form_state) {
	  	$site_key = $form_state->getValue('siteapikey');
		$this->config('system.site')
		  ->set('siteapikey', $site_key)
		  ->save();
		parent::submitForm($form, $form_state);
		if($site_key)
		 \Drupal::messenger()->addStatus(t('sitekey value %keyname:',['%keyname:' => $site_key]));
	  }
}
xxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxx