$(document).ready(function(){
// load modal contents
  $("[id^='object-property-values-modal']").one("show.bs.modal", function(e) {
    var id = $(this).attr('id');
    var lastChar = id.replace('object-property-values-modal', '');
    $(this).find(".modal-body").load('/object-properties/modal?id=' + lastChar, function() {
      checkAllOrNone();
    });    
  }); 
});

$(document).ready(function(){
  $("[id^='service-object-property-values-modal']").one("show.bs.modal", function(e) {
    var id = $(this).attr('id');
    var lastChar = id.replace('service-object-property-values-modal', '');
    $(this).find(".modal-body").load('/service-object-properties/modal?id=' + lastChar, function() {
      checkAllOrNone();
    });    
  });
});