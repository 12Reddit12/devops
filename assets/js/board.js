const boardContainer = document.querySelector('.board-container');
const newTaskBoardForm = document.getElementById('new-task-board-form');

const modal = document.querySelector('.modal');
const newTaskBoardModal = document.getElementById('new-task-board-modal');
const moreOptionModal = document.getElementById('more-option-modal');
const cancelButtons = document.querySelectorAll('.cancel-btn');

const newBtn = document.getElementById('new-btn');
const optionBtn = document.querySelectorAll('.more-option-btn');
const deleteBtn = document.getElementById('delete-btn');
const updateBtn = document.getElementById('update-btn');
const newTaskModal = document.getElementById('new-task-modal');
newBtn.addEventListener('click', handleNewBtnClick);
let globalBoardData = [];
let globalTaskData = [];
function handleNewBtnClick() {
    modal.style.display = 'flex';
    newTaskBoardModal.style.display = 'flex';
}



cancelButtons.forEach(cancelButton => {
    cancelButton.addEventListener('click', handleHideModal);
})

function handleHideModal() {
    newTaskModal.style.display = 'none';
    modal.style.display = 'none';
    newTaskBoardModal.style.display = 'none';
    moreOptionModal.style.display = 'none';
}
function showNewTaskBoardModal() {
    modal.style.display = 'flex';
    moreOptionModal.style.display = 'flex';
}
        function fetchProjects() {
            fetch('/controllers/get_sections.php', {
                method: 'GET'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                globalBoardData = data;
                // console.log('Global Board Data:', globalBoardData); 

               
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
        }
fetchProjects();
function getProjectById(id) {
    return globalBoardData.find(project => project.id === Number(id));
}

function handleShowOptionModel(e) {
    showNewTaskBoardModal();
    const selectedIndex = e.dataset.index;
    const selectedData = getProjectById(selectedIndex);
    const taskBoardIdInput = document.getElementById('task-section-id');
    const boardNameInput = document.getElementById('modify-section-name');
    const descriptionInput = document.getElementById('modify-description');
   
    taskBoardIdInput.value = selectedData['id'];
    boardNameInput.value = selectedData['name'];
    descriptionInput.value = selectedData['description'];
    boardNameInput.placeholder = selectedData['name'];
    descriptionInput.placeholder = selectedData['description'];
}

optionBtn.forEach(button => {
        button.addEventListener('click', () => handleShowOptionModel(button));
})



function handleUpdateTaskBoard(e) {
    e.preventDefault(); // Предотвращаем стандартное действие формы

    // Получаем данные из формы
    const taskBoardId = document.getElementById('task-section-id').value;
    const boardName = document.getElementById('modify-section-name').value;
    const description = document.getElementById('modify-description').value;

    // Отправляем данные на сервер
    fetch('/controllers/update_section.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'id': taskBoardId,
            'section-name': boardName,
            'description': description
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text(); // Вы можете изменить это на response.json(), если сервер возвращает JSON
    })
    .then(result => {
        // Обработка успешного ответа
        console.log('Success:', result);
        // Обновите страницу или выполните другие действия
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

updateBtn.addEventListener('click', handleUpdateTaskBoard);

function handleDeleteTaskBoard(e) {
    e.preventDefault();
 const taskBoardId = document.getElementById('task-section-id').value;
    if (confirm('Вы уверены, что хотите удалить эту секцию?')) {
        fetch('/controllers/delete_section.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'id': taskBoardId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(result => {
            console.log('Success:', result);
            // Обновите страницу или удалите элемент из DOM
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
deleteBtn.addEventListener('click', handleDeleteTaskBoard);

const newTaskForm = document.getElementById('new-task-form');


const newTaskBtn = document.getElementById('new-task-btn');
const createTaskBtn = document.getElementById('create-task-btn');

newTaskBtn.addEventListener('click', handleShowNewTaskModal);
createTaskBtn.addEventListener('click', handleCreateNewTask);

function handleShowNewTaskModal(e) {
    e.preventDefault();
    const selectedIndex = document.getElementById('task-section-id').value;
    handleHideModal();
    
    const taskBoardIdInput = document.getElementById('task-section-id-2');
    taskBoardIdInput.value = selectedIndex;
    modal.style.display = 'flex';
    newTaskModal.style.display = 'flex';

}

function handleCreateNewTask(e) {
    e.preventDefault(); // Предотвращаем стандартное действие формы

    // Получаем данные из формы
    const taskBoardId = document.getElementById('task-section-id-2').value;
    const boardName = document.getElementById('task-name').value;
    const description = document.getElementById('task-description').value;
 const completedate = document.getElementById('complete-date').value;
    // Отправляем данные на сервер
    fetch('/controllers/createtask.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'id': taskBoardId,
            'task-name': boardName,
            'task-description': description,
            'complete-date' : completedate
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text(); // Вы можете изменить это на response.json(), если сервер возвращает JSON
    })
    .then(result => {
        // Обработка успешного ответа
        console.log('Success:', result);
        // Обновите страницу или выполните другие действия
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function getTaskById(id) {
    return globalTaskData.find(project => project.id === Number(id));
}
function handleTaskShowOptionModel(e) {
    showTaskMoreOptionModal();

    const selectedIndex = e.dataset.index;

    const selectedData = getTaskById(selectedIndex);

    const taskIdInput = document.getElementById('task-id');
    const taskNameInput = document.getElementById('modify-task-name');
    const descriptionInput = document.getElementById('modify-task-description');
    const completeDateInput = document.getElementById('modify-task-complete-date');

    taskIdInput.value = selectedData['id'];
    taskNameInput.value = selectedData['name'];
    descriptionInput.value = selectedData['description'];
    completeDateInput.value = selectedData['complete_date'];
    taskNameInput.placeholder = selectedData['name'];
    descriptionInput.placeholder = selectedData['content'];
}

const taskMoreOptionModal = document.getElementById('task-more-option-modal');
function showTaskMoreOptionModal() {
    modal.style.display = 'flex';
    taskMoreOptionModal.style.display = 'flex';
}

const buttonsmoretask = document.querySelectorAll('.task-more-option-btn');

    buttonsmoretask.forEach(button => {
        button.addEventListener('click', () => handleTaskShowOptionModel(button));
        // console.log(button.dataset.taskBoardId);
    })


    function fetchTasks() {
            fetch('/controllers/get_tasks.php', {
                method: 'GET'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                globalTaskData = data;
               

               
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
        }
fetchTasks();



const updateTaskBtn = document.getElementById('update-task-btn');
const deleteTaskBtn = document.getElementById('delete-task-btn');

updateTaskBtn.addEventListener('click', handleUpdateTask);
deleteTaskBtn.addEventListener('click', handleDeleteTask);

function handleUpdateTask(e) {
  e.preventDefault(); // Предотвращаем стандартное действие формы

    // Получаем данные из формы
    const taskBoardId = document.getElementById('task-id').value;
    const boardName = document.getElementById('modify-task-name').value;
    const description = document.getElementById('modify-task-description').value;
const completedate = document.getElementById('modify-task-complete-date').value;
    // Отправляем данные на сервер
    fetch('/controllers/update_task.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'id': taskBoardId,
            'section-name': boardName,
            'description': description,
            'completedate': completedate
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text(); // Вы можете изменить это на response.json(), если сервер возвращает JSON
    })
    .then(result => {
        // Обработка успешного ответа
        console.log('Success:', result);
        // Обновите страницу или выполните другие действия
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function handleDeleteTask(e) {
    e.preventDefault();
 const taskBoardId = document.getElementById('task-id').value;
    if (confirm('Вы уверены, что хотите удалить это задание?')) {
        fetch('/controllers/delete_task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'id': taskBoardId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(result => {
            console.log('Success:', result);
            // Обновите страницу или удалите элемент из DOM
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
function handleComplete(e) {

    const taskId = e.dataset.index;
    const checked = e.checked;

    const isCompleted = checked ? 1 : 0;

    if (isCompleted) {
        e.parentElement.parentElement.parentElement.classList.add("completed");
    } else {
        e.parentElement.parentElement.parentElement.classList.remove("completed");
    }
fetch('/controllers/complete_task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'id': taskId,
                'isCompleted': isCompleted
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(result => {
            console.log('Success:', result);
            // Обновите страницу или удалите элемент из DOM
            //window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });

    
}
 const checkboxes = document.querySelectorAll('.complete-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', handleComplete);
    });

