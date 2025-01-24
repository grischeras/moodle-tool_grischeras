import Ajax from 'core/ajax';

const deleteAction = (itemId, row) => {
      Ajax.call([{
          methodname: 'tool_grischeras_delete',
          args: {itemid: itemId}
      }])[0].done(() => {
          // Delete item container from html.
          row.remove();
      });
};

export const init = () => {
   document.addEventListener('click', event => {
        let element = event.srcElement;
        let requestedaction = element.dataset.action;
        let itemId = element.id;
        if (requestedaction === 'delete') {
            event.preventDefault();
            if (confirm('Are you sure?')) {
                deleteAction(itemId, event.srcElement.parentNode.parentNode.parentNode);
            }
        }
   });
};
