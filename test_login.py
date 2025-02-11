import requests

BASE_URL = "http://localhost:1337/controllers/login.php"
  
def test_login_invalid_credentials():
    """Тест на невірні логін або пароль."""
    data = {
        'username': 'wrong_user',
        'password': 'wrong_password'
    }

    response = requests.post(BASE_URL, data=data)

    assert response.status_code == 200, f"Expected 200, but got {response.status_code}"
    
def test_login_success():
    """Тест на успішну авторизацію."""
    data = {
        'username': 'new_user',
        'password': 'newpassword'
    }
    
    response = requests.post(BASE_URL, data=data)

    assert response.status_code == 200, f"Expected 200, but got {response.status_code}"
    assert "Dashboard" in response.text
