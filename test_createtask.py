import requests

BASE_URL = "http://localhost:1337/controllers/createtask.php"

def test_create_task_missing_fields():
    """Тест на створення задачі з порожніми полями."""
    session = requests.Session()
    
    session.post(
        "http://localhost:1337/controllers/login.php",
        data={"username": "new_user", "password": "newpassword"}
    )
    
    data = {
        "id": "1", 
        "task-name": "",
        "task-description": "This is a test task description.",
        "complete-date": "2024-12-31"
    }
    response = session.post(BASE_URL, data=data)
    
    assert response.status_code == 200, "Request should complete successfully"
    assert "This is a test task description." not in response.text, "Task description should not appear on the page"

def test_create_task_unauthorized_access():
    """Тест на спробу створення задачі без авторизації."""
    data = {
        "id": "1",
        "task-name": "Unauthorized Task",
        "task-description": "This task should not be created.",
        "complete-date": "2024-12-31"
    }
    response = requests.post(BASE_URL, data=data)
    
    assert response.status_code == 200, "Unauthorized access should not fail silently"
    assert "Unauthorized Task" not in response.text, "Task name should not appear on the page"


def test_create_task_successfully():
    """Тест на успішне створення задачі в секції."""
    session = requests.Session()
    
    session.post(
        "http://localhost:1337/controllers/login.php",
        data={"username": "new_user", "password": "newpassword"}
    )
    
    data = {
        "id": "1",
        "task-name": "Test Task",
        "task-description": "This is a test task description.",
        "complete-date": "2024-12-31"
    }
    response = session.post(BASE_URL, data=data)
    
    assert response.status_code == 200, "Task creation should succeed"
    assert "Test Task" in response.text, "Task name should be present in response"
