jQuery(document).ready( function() {
  jQuery.validator.addMethod('minFare', function (value, el, param) {
    return value > param;
  },"Please set a valid number as the price");
});