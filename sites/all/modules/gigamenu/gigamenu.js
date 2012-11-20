// $Id: gigamenu.js,v 1.1 2010/11/04 15:40:17 recidive Exp $

Drupal.behaviors.GigaMenu = function(context) {
  // MouseOver event handler.
  var hoverOn = function() {
    $(this).find('ul.gigamenu:first').show();
    $(this).append('<span class="mega-menu-arrow"></span>');
  };

  // MouseOut event handler.
  var hoverOut = function() {
    $(this).find('ul.gigamenu:first').hide();
    $(this).find('.mega-menu-arrow').remove();
  };


  // Attach behavior to all giga menu parent items that have a giga menu.
  $('ul.gigamenu li.gigamenu-level-0:has(ul.gigamenu)').hoverIntent(hoverOn, hoverOut);
};
