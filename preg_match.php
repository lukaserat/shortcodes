<?php

// Determine subdomain and set in session
if (preg_match('/^(www|\/).*/',Request::path())) {
   // Public site, no subdomain
} else {
  // Subdomain.  
  $subdomain = preg_replace('/^([^\.]+).*/i', '$1', Request::path());
  // Set subdomain in session.
  Session::set('subdomain',$subdomain);
}
