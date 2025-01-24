import Ajax from 'core/ajax';

const editAction = (data) => {
    Ajax.call([{
        methodname: 'tool_grischeras_edit',
        args: data
    }])[0].done(() => {
        document.getElementsByClassName('mform')[0].remove();

    });
};

export const init = ({itemid}) => {
    let element = document.getElementById('id_save');
    element.addEventListener('click',function () {
        let name = document.getElementById('id_name').value;
        let completed = document.getElementById('id_completed_1').checked;
        let priority = document.getElementById('id_priority').value;
        editAction({
            itemid: itemid,
            name : name,
            completed: completed,
            priority: priority
        });
    });
};