<?php
/**
 * Git Laravel extension.
 *
 * Provides versioned urls to script and style tags
 *
 * @author    Mike Farrow <contact@mikefarrow.co.uk>
 * @license   Proprietary/Closed Source
 * @copyright Mike Farrow
 */

namespace Weyforth\GitLaravel;

use Weyforth\GitPHP\GitTools as GitPHP;
use HTML;
use URL;

class GitTools
{

	protected $tools;

	public function __construct()
	{
		$this->tools = new GitPHP;
		$this->tools->setRootPath(base_path());
	}

	protected function constructUrl($url){
		return $url . '?v=' . $this->tools->currentCommit();
	}

	public function style($url, $attributes = array(), $secure = null)
	{
		return HTML::style($this->constructUrl($url), $attributes, $secure);
	}

	public function script($url, $attributes = array(), $secure = null)
	{
		return HTML::script($this->constructUrl($url), $attributes, $secure);
	}

	public function url($path, $extra = array(), $secure = null)
	{
		return URL::to($this->constructUrl($path), $extra, $secure);
	}

	public function __call($name, $arguments)
	{
		return call_user_func(array($this->tools, $name), $arguments);
	}

}
