<?php

  function is_number($number, $min = 0, $max = 100): bool
  {
    return ($number >= $min and $number <= $max);
  } 

  function is_text($text, $min = 0, $max = 1000)
  {
    $length = mb_strlen($text);
    return ($length >= $min and $length <= $max);
  } 

  function is_password($password): bool
  {
    if ( mb_strlen($password) >= 8
         and preg_match('/[A-Z]/', $password)
         and preg_match('/[a-z]/', $password)
         and preg_match('/[0-9]/', $password)
         and preg_match('/[!@#$%]/', $password)
       ) {
      return true;  // Passed all tests
    } 
    return false;   // Invalid
  }

  function is_email($email): bool
  {
    if (preg_match('/[A-Za-z0-9]+@[A-Za-z0-9]+\.[A-Za-z0-9]/', $email)) {
      return true;
    }
    return false;
  }