import requests

BASE_URL = "http://localhost:1337/controllers/createboard.php"

def test_create_board_successfully():
    """Тест на успішне створення проекту."""
    session = requests.Session()
    session.post(
        "http://localhost:1337/controllers/createboard.php",
        data={"username": "new_user", "newpassword": "testpassword"}
    )
    data = {
        "board-name": "Test Board",
        "description": "This is a test project description."
    }
    response = session.post(BASE_URL, data=data)
    assert response.status_code == 200, "Project creation should redirect"
    assert response.headers["Location"] == "/../pages/dashboard.php", "Should redirect to dashboard"

def test_create_board_missing_fields():
    """Тест на створення проекту з порожніми полями."""
    session = requests.Session()
    session.post(
        "http://localhost:1337/controllers/login.php",
        data={"username": "testuser", "password": "testpassword"}
    )
    data = {
        "board-name": "", 
        "description": "This is a test project description."
    }
    response = session.post(BASE_URL, data=data)
    assert response.status_code == 200, "Request should redirect due to missing fields"
    assert response.headers["Location"] == "/../pages/dashboard.php", "Should redirect to dashboard"
