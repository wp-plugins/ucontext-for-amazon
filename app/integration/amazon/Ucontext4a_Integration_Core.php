<?php

// Copyright 2013 - Summit Media Concepts LLC - http://SummitMediaConcepts.com

require_once UCONTEXT4A_APP_PATH.'/Ucontext4a_Integration_Base.php';

class Ucontext4a_Integration_Core extends Ucontext4a_Integration_Base
{

	public static function search($keyword)
	{
		$result = array();

		$options = array(
		'keyword'		=> $keyword['custom_search'],
		'search_index'	=> @get_option('ucontext4a_dflt_search_index'),
		'condition'		=> @get_option('ucontext4a_dflt_condition')
		);

		if (@$keyword['search_index'] && $keyword['search_index'] != 'default')
		{
			$options['search_index'] = $keyword['search_index'];
		}

		if (@$keyword['condition'] && $keyword['condition'] != 'default')
		{
			$options['condition'] = $keyword['condition'];
		}

		$param_list = array(
		'Service'			=> 'AWSECommerceService',
		'Version'			=> '2011-08-01',
		'Operation'			=> 'ItemSearch',
		'Keywords'			=> $keyword['custom_search'],
		'AssociateTag'		=> get_option('ucontext4a_associate_tag'),
		'AWSAccessKeyId'	=> get_option('ucontext4a_public_key'),
		'Timestamp'			=> gmdate('Y-m-d\TH:i:s\Z'),
		'ResponseGroup'		=> 'ItemAttributes,Offers',
		'SearchIndex'		=> 'All',
		'Condition'			=> 'New'
		);

		if (isset($options['search_index']) && $options['search_index'])
		{
			$param_list['SearchIndex'] = $options['search_index'];
		}

		if (isset($options['condition']) && $options['condition'])
		{
			$param_list['Condition'] = $options['condition'];
		}

		$method = 'GET';
		$host = @get_option('ucontext4a_amazon_site', 'webservices.amazon.com');
		$uri = '/onca/xml';

		if (trim($host))
		{
			$host = 'webservices.amazon.com';
		}

		ksort($param_list);

		$key = md5(serialize($param_list));

		$response = Ucontext4a_Base::getCache('amazon_search', $key);

		if ($response === FALSE)
		{
			$canonicalized_query = array();

			foreach ($param_list as $param => $value)
			{
				$param = str_replace('%7E', '~', rawurlencode($param));
				$value = str_replace('%7E', '~', rawurlencode($value));

				$canonicalized_query[] = $param.'='.$value;
			}

			$canonicalized_query = implode('&', $canonicalized_query);

			$string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;

			$signature = base64_encode(hash_hmac('sha256', $string_to_sign, get_option('ucontext4a_private_key'), TRUE));

			$signature = str_replace('%7E', '~', rawurlencode($signature));

			$request_url = 'http://'.$host.$uri.'?'.$canonicalized_query.'&Signature='.$signature;

			$response = wp_remote_get($request_url);

			Ucontext4a_Base::setCache('amazon_search', $key, $response);
		}
		else
		{
			$response = unserialize($response);
		}

		$response = simplexml_load_string($response['body']);

		if (@$response->Items->Request->Errors->Error->Code == 'AWS.InvalidAccount')
		{
			update_option('ucontext4a_notification', 'uContext for '.UCONTEXT4A_INTEGRATION_TITLE.': '.(string)@$response->Items->Request->Errors->Error->Message);
			update_option('ucontext4a_api_disabled', 1);
		}
		elseif (@$response->Error->Code == 'InvalidClientTokenId')
		{
			update_option('ucontext4a_notification', 'uContext for '.UCONTEXT4A_INTEGRATION_TITLE.': '.(string)@$response->Error->Message);
			update_option('ucontext4a_api_disabled', 1);
		}
		elseif (@$response->Error->Code == 'SignatureDoesNotMatch')
		{
			update_option('ucontext4a_notification', 'uContext for '.UCONTEXT4A_INTEGRATION_TITLE.': '.(string)@$response->Error->Message);
			update_option('ucontext4a_api_disabled', 1);
		}
		elseif ((int)@$response->Items->TotalResults)
		{
			$row = 0;
			$found = FALSE;

			foreach ($response->Items->Item as $item)
			{
				$row++;
				if ($row == 1)
				{
					$first_asin = $item->ASIN;
				}

				if (trim($item->ASIN) == trim($keyword['product_id']))
				{
					$found = TRUE;
				}

				$result['search_results'][(string)$item->ASIN] = array(
					'title'	=> (string)$item->ItemAttributes->Title,
					'url'	=> (string)$item->DetailPageURL
				);
			}

			$result['product_id'] = trim($keyword['product_id']);
			if (!$found)
			{
				$result['product_id'] = $first_asin;
			}
		}

		return $result;
	}
}