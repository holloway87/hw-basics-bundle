<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Util;


/**
 * Provides methods to manipulate an image in many ways.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.31
 */
class ImageManipulator
{

	/**
	 * Original image resource before any manipulation.
	 *
	 * @var resource
	 */
	private $img_orig;

	/**
	 * Image resource to do manipulation with.
	 *
	 * @var resource
	 */
	private $img;

	/**
	 * File extension.
	 *
	 * @var string
	 */
	private $extension;


	/**
	 * Loads the file to start manipulation.
	 *
	 * Throws a RuntimeException if the image failed to load.
	 *
	 * @param string $file
	 * @throws \RuntimeException
	 */
	public function __construct($file)
	{
		// first try the file extension
		if(preg_match('/\.(?P<extension>jpe?g|png)$/i', $file, $ext_match))
		{
			$this->extension = $ext_match['extension'];
		}
		// if no extension found, try the mimetype
		else
		{
			$info = getimagesize($file);
			preg_match('/image\/(?<extension>(x-)?png|jpe?g)/i', $info['mime'], $ext_match);
			if(!$ext_match)
			{
				return;
			}
			switch($ext_match['extension'])
			{
				case 'x-png':
				case 'png':
					$this->extension = 'png';
					break;
				case 'jpeg':
				case 'jpg':
					$this->extension = 'jpg';
			}
		}

		// create image
		$create_function = $this->_getCreateFunction();
		$this->img = $this->img_orig = $create_function($file);
		if (false === $this->img)
		{
			throw new \RuntimeException(sprintf('Image with filename "%s" failed to load.', $file));
		}
	}

	/**
	 * Returns the image create function depending on the file extension.
	 *
	 * @return string
	 */
	private function _getCreateFunction()
	{
		switch($this->extension)
		{
			case 'jpg':
			case 'jpeg':
				return 'imagecreatefromjpeg';
			case 'png':
				return 'imagecreatefrompng';
			default:
				return '';
		}
	}

	/**
	 * Returns the image output function depending on the file extension.
	 *
	 * @return  string
	 */
	private function _getOutputFunction()
	{
		switch($this->extension)
		{
			case 'jpg':
			case 'jpeg':
				return 'imagejpeg';
			case 'png':
				return 'imagepng';
			default:
				return '';
		}
	}

	/**
	 * Yiq function, returns the gray value of an rgb color.
	 *
	 * @param integer $r
	 * @param integer $g
	 * @param integer $b
	 * @return integer
	 */
	private function _yiq($r, $g, $b)
	{
		$gray = ($r * 0.299) + ($g * 0.587) + ($b * 0.114);
		return $gray;
	}

	/**
	 * Turns the image into black & white.
	 *
	 * @return $this
	 */
	public function blackandwhite()
	{
		if(!$this->img)
		{
			return $this;
		}

		$img_width = imagesx($this->img);
		$img_height = imagesy($this->img);
		$img = imagecreate($img_width, $img_height);

		// 256 color palette
		$palette = array();
		for($c=0; $c < 256; $c++)
		{
			$palette[$c] = imagecolorallocate($img, $c, $c, $c);
		}

		// go through each pixel
		for($y=0; $y < $img_height; $y++)
		{
			for($x=0; $x < $img_width; $x++)
			{
				// get original color
				$rgb = imagecolorat($this->img, $x, $y);
				$r = ($rgb >> 16) & 0xff;
				$g = ($rgb >> 8) & 0xff;
				$b = $rgb & 0xff;

				// get gray tone
				$gs = $this->_yiq($r, $g, $b);
				imagesetpixel($img, $x, $y, $palette[$gs]);
			}
		}

		$this->img = $img;
		return $this;
	}

	/**
	 * Returns the image mime type depending on the chosen extension.
	 *
	 * @return string
	 */
	public function getMimeType()
	{
		switch($this->extension)
		{
			case 'jpg':
			case 'jpeg':
				return 'image/jpeg';
			case 'png':
				return 'image/png';
			default:
				return '';
		}
	}

	/**
	 * Ouputs the image.
	 *
	 * The parameters must be comitted as the image function requires it from the gd library.
	 * Except the image resource parameter, it will be added from this method.
	 *
	 * @return boolean
	 */
	public function output()
	{
		$output_function = $this->_getOutputFunction();
		$args = func_get_args();
		array_unshift($args, $this->img);
		return call_user_func_array($output_function, $args);
	}

	/**
	 * Cuts the image to a rectangle.
	 *
	 * If nothing is specified it cuts the middle of the image.
	 *
	 * @param integer $startx
	 * @param integer $starty
	 * @param integer $width
	 * @return $this;
	 */
	public function rectangle($startx = null, $starty = null, $width = null)
	{
		$img_width = imagesx($this->img);
		$img_height = imagesy($this->img);

		// get all variables if not specified
		if(null === $startx and null === $starty and null === $width)
		{
			$width = $img_width == $img_height
				? $img_width
				: ($img_width > $img_height
					? $img_height
					: $img_width);
			$startx = ($img_width / 2) - ($width / 2);
			$starty = ($img_height / 2) - ($width / 2);
		}

		$img = imagecreatetruecolor($width, $width);
		imagecopyresampled($img, $this->img, 0, 0, $startx, $starty, $width, $width, $width, $width);
		$this->img = $img;
		return $this;
	}

	/**
	 * Resizes the image.
	 *
	 * @param integer $width
	 * @param integer $height
	 * @param boolean $proportions
	 * @return $this
	 */
	public function resize($width, $height, $proportions = true)
	{
		if(!$this->img)
		{
			return $this;
		}

		$img_width = imagesx($this->img);
		$img_height = imagesy($this->img);
		// preserve proportions if ordered
		if($proportions)
		{
			$img_props = $img_width / $img_height;
			$req_props = $width / $height;
			if($img_props > 1 and $req_props < $img_props)
			{
				$height = $img_height * $width / $img_width;
			}
			elseif($img_props > 1 and $req_props > $img_props)
			{
				$width = $img_width * $height / $img_height;
			}
			elseif($img_props < 1 and $req_props < $img_props)
			{
				$height = $img_height * $width / $img_width;
			}
			elseif($img_props < 1 and $req_props > $img_props)
			{
				$width = $img_width * $height / $img_height;
			}
		}

		$img = imagecreatetruecolor($width, $height);
		imagecopyresampled($img, $this->img, 0, 0, 0, 0, $width, $height,
			$img_width, $img_height);
		$this->img = $img;
		return $this;
	}

	/**
	 * Change the extension for the output format.
	 *
	 * Returns a boolean if extension is known and set.
	 *
	 * @param string $extension
	 * @return boolean
	 */
	public function setExtension($extension)
	{
		if(!preg_match('/^(?P<extension>jpe?g|png)$/i', $extension, $ext_match))
		{
			return false;
		}
		$this->extension = $ext_match['extension'];
		return true;
	}

}
