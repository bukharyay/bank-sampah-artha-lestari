<?php
if ( ! function_exists ( 'url_title_custom' ) )
  {
  function url_title_custom ( $str, $separator = '-', $lowercase = TRUE )
    {
    // Ganti slash dengan placeholder khusus
    $str = str_replace ( '/', '--SLASH--', $str );

    // Proses normal url_title
    $str = url_title ( $str, $separator, $lowercase );

    // Kembalikan placeholder ke slash
    $str = str_replace ( '--slash--', '/', strtolower ( $str ) );
    $str = str_replace ( '--SLASH--', '/', $str );

    return $str;
    }
  }