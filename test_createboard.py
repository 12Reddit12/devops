import requests

BASE_URL = "http://localhost:1337/controllers/createboard.php"

def test_create_board_successfully():
    """Тест на успішне створення проекту."""
    session = requests.Session()

    # Логинимся
    login_response = session.post(
        "http://localhost:1337/controllers/login.php",
        data={"username": "new_user", "password": "newpassword"}
    )
    assert login_response.status_code in [200, 302], "Login should be successful"

    # Создаем проект
    data = {
        "board-name": "Test Board",
        "description": "This is a test project description."
    }
    response = session.post(BASE_URL, data=data)
    assert response.status_code == 200, "Project creation should succeed"
    assert "Test Board" in response.text

def test_create_board_missing_fields():
    """Тест на створення проекту з порожніми полями."""
    session = requests.Session()

    # Логинимся
    session.post(
        "http://localhost:1337/controllers/login.php",
        data={"username": "new_user", "password": "newpassword"}
    )

    # Пропускаем обязательное поле
    data = {
        "board-name": "", 
        "description": "nonvalidproject."
    }
    response = session.post(BASE_URL, data=data)
    assert response.status_code == 200, "Request should fail due to missing fields"
    assert "nonvalidproject" not in response.text, "Error it created with empty name"
