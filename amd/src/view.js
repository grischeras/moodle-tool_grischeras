import Ajax from "../../../../../lib/amd/src/ajax";

const deleteAction = (itemId) => {
      let confirmation = confirm('Are you sure you want delete this item?');
      if (confirmation == true) {
          Ajax.call([{
              methodname: 'tool_grischeras_delete_item',
              args: {itemId: itemId}
          }])[0].done(() => {
             // Delete item container.
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
            deleteAction(itemId);
            break;
      }
   });
};