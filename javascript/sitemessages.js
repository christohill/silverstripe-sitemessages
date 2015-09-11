/**
 * Description: Main JavaScript for site-messages module
 * Author: Chris Tohill
 * Author Email: hello@visualoverdose.ca
 */
(function($) {

	// Set cookie when close button is clicked
	$('.sitemessage-close a').on('click', function(e){

		var sitemessageid = $(this).closest('.sitemessage').attr('id');
		$('#' + sitemessageid).slideToggle();

		// Set cookie			
		setCookie(sitemessageid, 30);

	});

	/**
	 * Create a cookie to remember the users that have closed a site message
	 * @param String	name  The Unique ID of the site message
	 * @param Int 		days  The number of days until the cookie expires
	 */
    function setCookie(name, days) {

    	var date = new Date();
    	var expires = new Date(date.getTime() + 1000*60*60*24*days);

    	document.cookie = name + "=closed;expires=" + expires.toGMTString() + ';';
    }

})(jQuery);
