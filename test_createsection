import requests

BASE_URL = "http://localhost:1337/controllers/createsection.php"

def test_create_section_successfully():
    """Тест на успішне створення секції для проекту."""
    session = requests.Session()
    session.post(
        "http://localhost:1337/controllers/login.php",
        data={"username": "new_user", "newpassword": "testpassword"}
    )
    data = {
        "id": "0",
        "board-name": "Test Section",
        "description": "This is a test section description."
    }
    response = session.post(BASE_URL, data=data)
    assert response.status_code == 200, "Section creation should redirect"
    assert response.headers["Location"] == "/../pages/board.php?id=1", "Should redirect to the board page"

def test_create_section_missing_fields():
    """Тест на створення секції з порожніми полями."""
    session = requests.Session()
    session.post(
        "http://localhost:1337/controllers/login.php",
        data={"username": "testuser", "password": "testpassword"}
    )
    data = {
        "id": "0",
        "board-name": "",
        "description": "This is a test section description."
    }
    response = session.post(BASE_URL, data=data)
    assert response.status_code == 200, "Request should redirect due to missing fields"
    assert response.headers["Location"] == "/../pages/dashboard.php", "Should redirect to dashboard"

def test_create_section_unauthorized_access():
    """Тест на спробу створення секції без авторизації."""
    data = {
        "id": "0",
        "board-name": "Unauthorized Section",
        "description": "This should not be created."
    }
    response = requests.post(BASE_URL, data=data)
    assert response.status_code == 200, "Unauthorized access should not redirect"
    assert "Location" not in response.headers, "No redirection should occur for unauthorized users"
