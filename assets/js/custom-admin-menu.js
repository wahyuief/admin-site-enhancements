(function( $ ) {
   'use strict';

   $(document).ready( function() {

      // Initialize sortable elements: https://api.jqueryui.com/sortable/
      $('#custom-admin-menu').sortable();

      // Save custom order into a comma-separated string, triggerred after each drag and drop of menu item
      // https://api.jqueryui.com/sortable/#event-update
      // https://api.jqueryui.com/sortable/#method-toArray
      $('#custom-admin-menu').on( 'sortupdate', function( event, ui) {
         let menuOrder = $('#custom-admin-menu').sortable("toArray").toString();
         // console.log( menuOrder );

         // Set hidden input value
         document.getElementById('admin_site_enhancements[custom_menu_order]').value = menuOrder;

         // jQuery.ajax({
         //    url: ajaxurl,
         //    data: {
         //       'action': 'save_custom_menu_order',
         //       'menu_order': menuOrder
         //    },
         //    success:function(data) {
         //       var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
         //       var dataObj = JSON.parse(data);
         //       console.log(dataObj.message);
         //    },
         //    error:function(errorThrown) {
         //       console.log(errorThrown);
         //    }
         // });

      });

      // Define a function to delay execution of script by x miliecnods. Ref: https://stackoverflow.com/a/28173606
      // var delay = ( function() {
      //    var timer = 0;
      //    return function(callback, ms) {
      //       clearTimeout (timer);
      //       timer = setTimeout(callback, ms);
      //    };
      // })();

      // If Customize Admin Menu is enabled, save IDs of menu items that will be hidden
      if ( document.getElementById('admin_site_enhancements[customize_admin_menu]').checked ) {

         // Prepare constant to store IDs of menu items that will be hidden
         if ( document.getElementById('admin_site_enhancements[custom_menu_hidden]').value ) {

            var hiddenMenuItems = document.getElementById('admin_site_enhancements[custom_menu_hidden]').value.split(","); // array

         } else {

            var hiddenMenuItems = []; // array

         }

         console.log(hiddenMenuItems);

         // Detect which menu items are being checked. Ref: https://stackoverflow.com/a/3871602
         Array.from(document.getElementsByClassName('menu-item-checkbox')).forEach(function(item,index,array) {
 
            item.addEventListener('click', event => {

               if (event.target.checked) {

                  // Add ID of menu item to array
                  // alert(event.target.dataset.menuItemId + ' will be hidden');
                  hiddenMenuItems.push(event.target.dataset.menuItemId);

               } else {

                  // Remove ID of menu item from array
                  // alert(event.target.dataset.menuItemId + ' will not be hidden');
                  const start = hiddenMenuItems.indexOf(event.target.dataset.menuItemId);
                  const deleteCount = 1;
                  hiddenMenuItems.splice(start, deleteCount);

               }

               console.log(hiddenMenuItems.toString());

               // Set hidden input value
               document.getElementById('admin_site_enhancements[custom_menu_hidden]').value = hiddenMenuItems;

               // delay(function() {

               //    jQuery.ajax({
               //       url: ajaxurl,
               //       data: {
               //          'action': 'save_hidden_menu_items',
               //          'hidden_menu_items': hiddenMenuItems.toString()
               //       },
               //       success:function(data) {
               //          var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
               //          var dataObj = JSON.parse(data);
               //          console.log(dataObj.message );
               //       },
               //       error:function(errorThrown) {
               //          console.log(errorThrown);
               //       }
               //    });

               // }, 3000);

            });

         });

      }

   });

})( jQuery );