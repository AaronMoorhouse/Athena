/**
 * Script for making table rows clickable.
 *
 * This script makes rows in tables clickable by following href links in any anchor tag in that row.
 */

$(document).ready(function() {

	//Find <a> tag and follow its link
    $('tr').click(function() {
        var href = $(this).find("a").attr("href");
		
        if(href) {
            window.location = href;
        }
    });
});