import requests

BASE_URL = "http://localhost:1337/controllers/createsection.php"

def test_create_section_successfully():
    """Тест на успішне створення секції для проекту."""
    session = requests.Session()
    
    session.post(
        "http://localhost:1337/controllers/login.php",
        data={"username": "new_user", "password": "newpassword"}
    )
    

    data = {
        "id": "0",
        "board-name": "Test Section",
        "description": "This is a test section description."
    }
    response = session.post(BASE_URL, data=data)
    

    assert response.status_code == 200, "Section creation should succeed"
    

    assert "Test Section" in response.text, "Section name should be present in response"
    assert "This is a test section description." in response.text, "Section description should be present in response"

def test_create_section_missing_fields():
    """Тест на створення секції з порожніми полями."""
    session = requests.Session()
    

    session.post(
        "http://localhost:1337/controllers/login.php",
        data={"username": "new_user", "password": "newpassword"}
    )
    

    data = {
        "id": "0", 
        "board-name": "",
        "description": "This is a test section description."
    }
    response = session.post(BASE_URL, data=data)
    

    assert response.status_code == 200, "Request should complete successfully"
    

    assert "This is a test section description." not in response.text, "Description should not appear on the page"

def test_create_section_unauthorized_access():
    """Тест на спробу створення секції без авторизації."""

    data = {
        "id": "0",
        "board-name": "Unauthorized Section",
        "description": "This should not be created."
    }
    response = requests.post(BASE_URL, data=data)
    

    assert response.status_code == 200, "Unauthorized access should not fail silently"
    

    assert "Unauthorized Section" not in response.text, "Section should not appear on the page"
    assert "This should not be created." not in response.text, "Description should not appear on the page"
