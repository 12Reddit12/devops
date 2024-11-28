from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from webdriver_manager.chrome import ChromeDriverManager
import pytest

@pytest.fixture(scope="module")
def driver():
    # Створюємо сервіс для ChromeDriver
    service = Service(ChromeDriverManager().install())
    options = webdriver.ChromeOptions()

    # Додаємо опції для безголової роботи Chrome
    options.add_argument('--headless')  # Безголовий режим
    options.add_argument('--no-sandbox')  # Безпека
    options.add_argument('--disable-dev-shm-usage')  # Використання оперативної пам'яті
    options.binary_location = "/usr/local/bin/chromedriver"  # Вказуємо розташування Chrome

    driver = webdriver.Chrome(service=service, options=options)
    yield driver
    driver.quit()

def test_login_page(driver):
    driver.get("http://localhost:1337")
    login_form = driver.find_element(By.ID, "loginForm")
    assert login_form is not None, "Login form not found"
