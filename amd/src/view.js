import Ajax from 'core/ajax';

const deleteAction = (itemId) => {
      let confirmation = confirm('Are you sure you want delete this item? ' + itemId);
      let element = document.getElementById(itemId);
      if (confirmation == true) {
          Ajax.call([{
              methodname: 'tool_grischeras_delete_item',
              args: {itemid: itemId}
          }])[0].done(() => {
            // Delete item container from html.
            element.parentNode.parentNode.remove();
          });
      }
};

export const init = () => {
   document.addEventListener('click', event => {
        let element = event.srcElement;
        let requestedaction = element.dataset.action;
        let itemId = element.id;
        switch (requestedaction) {
         case 'delete':
            event.preventDefault();
            deleteAction(itemId);
            break;
        }
   });
};
