import Ajax from 'core/ajax';
import * as notification from 'core/notification';

const deleteAction = (itemId) => {
      let element = document.getElementById(itemId);
      notification.confirm('Are you sure?', function() {
          Ajax.call([{
              methodname: 'tool_grischeras_delete',
              args: {itemid: itemId}
          }])[0].done(() => {
              // Delete item container from html.
              element.parentNode.parentNode.remove();
          });
      });
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
