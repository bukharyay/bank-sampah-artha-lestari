<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

if ( ! function_exists ( 'get_greeting' ) )
	{
	function get_greeting ()
		{
		$hour = (int) date ( 'H' );

		if ( $hour >= 6 && $hour < 10 )
			{
			return 'Selamat Pagi';
			}
		elseif ( $hour >= 10 && $hour < 14 )
			{
			return 'Selamat Siang';
			}
		elseif ( $hour >= 14 && $hour < 18 )
			{
			return 'Selamat Sore';
			}
		else
			{
			return 'Selamat Malam';
			}
		}
	}