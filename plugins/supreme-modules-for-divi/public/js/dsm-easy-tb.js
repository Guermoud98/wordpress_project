jQuery(document).ready(function(e){document.documentElement.className="js";navigator.userAgent.match(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/),e("#wpadminbar").height();var d,a=dsm_easy_tb_js.threshold;if(e(".dsm_fixed_header").length){var i=(d=0,function(e,a){clearTimeout(d),d=setTimeout(e,a)});e(".dsm_fixed_header_auto").length&&(e("#page-container").addClass("et-animated-content"),e("#page-container").attr("style","padding-top: "+e(".et-l--header").height()+"px !important;")),e(".dsm_fixed_header_shrink").length&&e(window).scroll(function(){e("body").hasClass("admin-bar")&&(!0===window.matchMedia("(max-width: 768px)").matches?e(document).scrollTop()>10?e(".dsm_fixed_header header").css("top","0"):e(".dsm_fixed_header header").css("top",e("#wpadminbar").height()):!0===window.matchMedia("(min-width: 769px)").matches&&e(".dsm_fixed_header header").css("top","")),e(document).scrollTop()>a?(e(".dsm_fixed_header_shrink").addClass("dsm_fixed_header_shrink_active"),e(".dsm_fixed_header_shrink").addClass("dsm_fixed_header_shrink_active_scrolled"),e("#page-container").css("margin-top",-e(".et-l--header").height()/2)):(e(".dsm_fixed_header_shrink").removeClass("dsm_fixed_header_shrink_active"),e("#page-container").css("margin-top","-1px"))}),e(window).resize(function(){i(function(){e(".dsm_fixed_header_auto").length&&e("#page-container").attr("style","padding-top: "+e(".et-l--header").height()+"px !important;"),e("body").hasClass("admin-bar")&&(!0===window.matchMedia("(max-width: 768px)").matches?e(document).scrollTop()>10?e(".dsm_fixed_header header").css("top","0"):e(".dsm_fixed_header header").css("top",e("#wpadminbar").height()):!0===window.matchMedia("(min-width: 769px)").matches&&e(".dsm_fixed_header header").css("top",""))},50)})}});