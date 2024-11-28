import requests

BASE_URL = "http://localhost:1337/pages/login.php"

def test_login_success():
    """Тест на успішну авторизацію."""
    data = {
        'username': 'new_user',
        'password': 'newpassword'
    }
    
    response = requests.post(BASE_URL, data=data)

    assert response.status_code == 302, f"Expected 302, but got {response.status_code}"

    assert response.headers["Location"] == "/pages/dashboard.php", "Redirection failed to dashboard.php"
  
def test_login_invalid_credentials():
    """Тест на невірні логін або пароль."""
    data = {
        'username': 'wrong_user',
        'password': 'wrong_password'
    }

    response = requests.post(BASE_URL, data=data)

    assert response.status_code == 302, f"Expected 302, but got {response.status_code}"

    assert response.headers["Location"] == "/pages/login.php", "Redirection failed to login.php"
    
    response = requests.get(BASE_URL)
    assert 'Невірний логін або пароль!' in response.text, "Error message not found"
