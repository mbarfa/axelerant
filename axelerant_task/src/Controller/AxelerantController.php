<?php

namespace Drupal\axelerant_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

class AxelerantController extends ControllerBase {

	public function jsonrepresentationData($sitekey, $nid) {
		
        $site_config = \Drupal::config('system.site');
        $config_skey = $site_config->get('siteapikey');
		$properties['type'] = 'page';
		$properties['nid'] = $nid;
		
		$result_cms_data = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties($properties);

		$NodeObject = reset($result_cms_data);
		if((!$NodeObject)|| ($sitekey != $config_skey)) {
			throw new AccessDeniedHttpException();
		}

		$data['title'] = $NodeObject->title->value;
		$data['body'] = strip_tags($NodeObject->get('body')->value);
		$response = new JsonResponse($data);
		return $response;
	}	
}