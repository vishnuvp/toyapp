$(document).ready(function(){
  
  
  jQuery('a.menu-link').click(function(e){
    e.preventDefault();
    var href= jQuery(this).attr("to");
    jQuery('html, body').animate({
      scrollTop: jQuery(href).offset().top - 150}, 1000); }); 

  jQuery("#threshold-input").bind("input",function(){
    var n = jQuery(this).val();
    var htm = "";
    for(var i=1;i<=n;i++){
      if(i==1) {
        var em = jQuery("#welcome-msg").text();
        em = em.substring(em.indexOf('[')+1,em.length-1);
        htm += '<input type="email" name="email['+i+']" readonly="readonly" id="email-'+i+'" value="'+em+'" />';
      }
      else {
      htm += '<input type="email" name="email['+i+']" id="email-'+i+'" placeholder="Enter email '+ i +'"/>';
      }
    }
    jQuery("#hctrl-block").hide().html(htm).fadeIn('slow');
  });

  /*jQuery("#threshold-input").change(function(){
    var n = jQuery(this).val();
    var htm = "";
    for(var i=1;i<=n;i++){
      htm += '<input type="email" name="email-'+i+'" id="email-'+i+'" placeholder="Enter email '+ i +'"/>';
    }
    jQuery("#hctrl-block").hide().html(htm).fadeIn('slow');
  });*/

  //$('#welcome-overlay').mouseenter(function() { $('#dp-f').fadeIn();}).mouseleave(function() { $('#dp-f').fadeOut();});
});