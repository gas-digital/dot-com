function getAdminbarHeight(){var t=0;return jQuery("#wpadminbar").length&&(t=parseInt(jQuery("#wpadminbar").outerHeight(),10)),t}function getWaypointOffset(t){var e=t.data("animationoffset");return void 0===e&&(e="bottom-in-view"),"top-out-of-view"===e&&(e=getAdminbarHeight()+("function"===getWaypointTopOffset?getWaypointTopOffset():0)),e}jQuery(window).load(function(){setTimeout(function(){"function"==typeof jQuery.waypoints&&jQuery.waypoints("viewportHeight")},300)});