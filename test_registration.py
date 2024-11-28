import requests
import os

BASE_URL = "http://localhost:1337/controllers/register.php"


def test_registration_empty_fields():
    """Тест на порожні поля."""
    data = {
        'username': '',
        'password': ''
    }
    response = requests.post(BASE_URL, data=data)
    assert "Всі поля повинні бути заповнені!" in response.text

def test_registration_valid_data_without_avatar():
    """Тест на коректну реєстрацію без аватару."""
    data = {
        'username': 'new_user',
        'password': 'newpassword'
    }
    response = requests.post(BASE_URL, data=data)
    assert response.status_code == 302 

def test_registration_user_exists():
    """Тест на наявність користувача з таким же логіном."""
    data = {
        'username': 'new_user',
        'password': 'newpassword'
    }

    response = requests.post(BASE_URL, data=data)
    assert "Користувач з таким логіном вже існує!" in response.text
