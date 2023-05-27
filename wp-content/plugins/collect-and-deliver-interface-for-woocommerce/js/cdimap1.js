jQuery(document).ready(function(relocatediv) {

  var target = document.querySelector('#order_review');
  var cdiobserver = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      if (mutation.type === 'childList' || mutation.type === 'subtree') {
        if (mutation.addedNodes) {
          if (mutation.addedNodes[0]) {
            if (mutation.addedNodes[0].className) {
              if (mutation.addedNodes[0].className === 'cdiselectlocation') {
                var $node = jQuery(mutation.addedNodes[0]);
                var idnewselect = mutation.addedNodes[0].id;
                // Relocate Div
                var where = cdiwhereselectorpickup;
                switch (where) {
                  case 'insertBefore( ".shop_table" )':
                    jQuery($node).insertBefore(".shop_table");
                    break;
                  case 'insertAfter( ".shop_table" )':
                    jQuery($node).insertAfter(".shop_table");
                    break;
                  case 'insertBefore( "#payment" )':
                    jQuery($node).insertBefore("#payment");
                    break;
                  case 'insertAfter( "#payment" )':
                    jQuery($node).insertAfter("#payment");
                    break;
                  case 'insertBefore( "#order_review" )':
                    jQuery($node).insertBefore("#order_review");
                    break;
                  case 'insertAfter( "#order_review" )':
                    jQuery($node).insertAfter("#order_review");
                    break;
                  default:
                    eval ('jQuery($node).' + where) ;
                }
                // Suppress old Div  
                jQuery(".cdiselectlocation").each(function(index) {
                  var currentID = this.id;
                  if (currentID != idnewselect) {
                    jQuery(this).remove();
                  }
                });
                // Restart after events
                cdiobserver.disconnect();   
                setTimeout(function(){ startobserver() }, 1500);          
              }
            }
          }
        }
      }
    });
  });
  
  if (target !== null) {
    startobserver() ;
  }
  
  function startobserver(){ 
    var config = {
      childList: true,
      subtree: true
      };
    cdiobserver.observe(target, config);
  }

});
