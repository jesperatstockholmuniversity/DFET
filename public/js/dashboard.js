jQuery(document).ready(function(){
    
    "use strict";

    function showTooltip(x, y, contents) {
	jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
	    position: 'absolute',
	    display: 'none',
	    top: y + 5,
	    left: x + 5
	}).appendTo("body").fadeIn(200);
    }
    
    
    // This will submit the basicWizard form
    // jQuery('.panel-wizard').submit(function() {    
    //     alert('This will submit the form wizard');
    //     return false // remove this to submit to specified action url
    // });
    
});