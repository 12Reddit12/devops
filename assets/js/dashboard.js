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

newBtn.addEventListener('click', handleNewBtnClick);
let globalBoardData = [];

function handleNewBtnClick() {
    modal.style.display = 'flex';
    newTaskBoardModal.style.display = 'flex';
}



cancelButtons.forEach(cancelButton => {
    cancelButton.addEventListener('click', handleHideModal);
})

function handleHideModal() {
    modal.style.display = 'none';
    newTaskBoardModal.style.display = 'none';
    moreOptionModal.style.display = 'none';
}
function showNewTaskBoardModal() {
    modal.style.display = 'flex';
    moreOptionModal.style.display = 'flex';
}
        function fetchProjects() {
            fetch('/controllers/get_projects.php', {
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
    const taskBoardIdInput = document.getElementById('task-board-id');
    const boardNameInput = document.getElementById('modify-board-name');
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
    e.preventDefault();

    // Получаем данные из формы
    const taskBoardId = document.getElementById('task-board-id').value;
    const boardName = document.getElementById('modify-board-name').value;
    const description = document.getElementById('modify-description').value;

    // Отправляем данные на сервер
    fetch('/controllers/update_board.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'id': taskBoardId,
            'board-name': boardName,
            'description': description
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
       
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

updateBtn.addEventListener('click', handleUpdateTaskBoard);

function handleDeleteTaskBoard(e) {
    e.preventDefault();
 const taskBoardId = document.getElementById('task-board-id').value;
    if (confirm('Вы уверены, что хотите удалить этот проект?')) {
        fetch('/controllers/delete_board.php', {
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
            
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
deleteBtn.addEventListener('click', handleDeleteTaskBoard);