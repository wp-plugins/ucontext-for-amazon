<?php

// Copyright 2013 - Summit Media Concepts LLC - http://SummitMediaConcepts.com

require_once dirname(__FILE__).'/Ucontext4a_Integration_Core.php';

class Ucontext4a_Integration extends Ucontext4a_Integration_Core
{
	public static function isValidLicense($force = FALSE)
	{
		return true;
	}
}