jQuery(document).ready(function() {
	jQuery('.create-menu .tab-links a').on('click', function(e)  {
		var currentAttrValue = jQuery(this).attr('href');
// Show/Hide Tabs
		jQuery('.create-menu ' + currentAttrValue).show().siblings().hide();
// Change/remove current tab to active
		jQuery(this).parent('li').addClass('active').siblings().removeClass('active').addClass('inactive');
		e.preventDefault();
	});
});