function autoFill(id, v){
	$(id).css({ color: "#b2adad" }).attr({ value: v }).focus(function(){
		if($(this).val()==v){
			$(this).val("").css({ color: "#333" });
		}
	}).blur(function(){
		if($(this).val()==""){
			$(this).css({ color: "#b2adad" }).val(v);
		}
	});

}

$(function() {
autoFill($('#edit-search-theme-form-1'), 'Search');
  new_menu = $('#front-content').length;
  $('.gigamenu-level-0 > ul').each(function(){
    var max = 0;
    var rt = 0;
    $('> li', this).each(function(){
      var h = $(this).height() + 10;
		if (new_menu > 0) {
			h += $(this).find('ul').height() + 10;
		}

      if ($(this).hasClass('expanded')) {

        if (h > max) {
          max = h;
        }
      } else {
        rt += h;
      }
    });
    if (rt > max) {
      max = rt;
    }
    $(this).height(max);
    $(this).find('>li.expanded').height(max-15);
  });
  // Hide giga menus.
  $('ul.gigamenu li.gigamenu-level-0 > ul.gigamenu').hide();
  //$('ul.gigamenu li.gigamenu-level-0 > ul.gigamenu > li:first-child').append($('<span class="mega-menu-arrow"></span>'));

  //$('.mega-menu-arrow').hide();
  
    $('.secondary li.expanded>a').append($('<span class="arrow"></span>'));
    $('.secondary li.collapsed>a').append($('<span class="arrow"></span>'));
  
  $('.secondary .expanded ul').hide();
  $('.secondary .expanded.active-trail ul').show();
  $('.secondary .expanded .more').show();
  $('.secondary .expanded.active-trail .more').hide();
  
  if ($('#accordion').length ) {
    $('#accordion').accordion({autoHeight: false, collapsible: true, active: false});
  
    $('#accordion table').each(function() {
    $(this).find('tr:odd').addClass('odd');
    });
    
    $('#accordion').bind('accordionchange', function(event, ui) {
	alert(ui.newHeader); // jQuery object, activated header
	//ui.oldHeader // jQuery object, previous header
	//ui.newContent // jQuery object, activated content
	//ui.oldContent // jQuery object, previous content
    });
  }
  
  if ($('.views-accordion').length) {
	$('.views-accordion').bind('accordionchange', function(event, ui) {
		alert(ui.newHeader); // jQuery object, activated header
		//ui.oldHeader // jQuery object, previous header
		//ui.newContent // jQuery object, activated content
		//ui.oldContent // jQuery object, previous content
	});
  }
  
$("ul.sf-menu").addClass('tr'); 
        $("ul.sf-menu > li").addClass('ts'); 
});