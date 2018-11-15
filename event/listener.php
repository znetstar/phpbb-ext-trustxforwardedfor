<?php
/**
* phpBB Extension - marttiphpbb Trust X-Forwarded-For
* @copyright (c) 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\trustxforwardedfor\event;

use phpbb\request\request;
use phpbb\event\data as event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var request */
	private $request;

	/**
	* @param request
	*/
	public function __construct(request $request)
	{
		$this->request = $request;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.session_ip_after'		=> 'core_session_ip_after',
		];
	}

	public function core_session_ip_after(event $event)
	{
		$ip = $event['ip'];

		if ($trusted_ips = getenv('MARTTIPHPBB_TRUSTXFORWARDEDFOR_IPS'))
		{
			$trusted_ips = str_replace(' ', '', $trusted_ips);
			$trusted_ips = explode(',', $trusted_ips);
		}
		else
		{
			$trusted_ips = ['127.0.0.1', '::1'];
		}

		if (!in_array($ip, $trusted_ips))
		{
			throw new \Exception('Trust X-Forwarded-For Extension: Untrusted IP: ' . $ip);
		}

		$forwarded_for = trim($this->request->header('X-Forwarded-For'));
		$forwarded_for = str_replace(' ', '', $forwarded_for);
		$forwarded_for = explode(',', $forwarded_for);
		$forwarded_for = trim($forwarded_for[count($forwarded_for) - 1]);

		if (!filter_var($forwarded_for, FILTER_VALIDATE_IP))
		{
			throw new \Exception('Trust X-Forwarded-For Extension: invalid X-Forwarded-For: ' . $forwarded_for);
		}

		error_log('X-Forwarded-For: ' . $forwarded_for);

		$event['ip'] = $forwarded_for;
	}
}
