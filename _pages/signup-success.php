<?
if(!$_SESSION[AUTH_PREFIX.'AUTH'])
	header('Location:home.html');

$profile	= getCustomerDetails($_SESSION['USER_PROFILE']['id']);
?>

<!-- Facebook Conversion Code for Saverplaces User Registrations -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6021971739260', {'value':'0.00','currency':'GBP'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6021971739260&amp;cd[value]=0.00&amp;cd[currency]=GBP&amp;noscript=1" /></noscript>

<div class="account-settings">
    <h1>Welcome <?=$profile['firstname']?></h1> 
</div>
