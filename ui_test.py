from xvfbwrapper import Xvfb
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import pytest
import time

@pytest.fixture(scope="module")
def driver():
    # Створюємо віртуальний дисплей з Xvfb
    xvfb = Xvfb()
    xvfb.start()

    # Налаштовуємо Chrome в headless режимі
    service = Service(ChromeDriverManager().install()) 
    options = webdriver.ChromeOptions()
    options.add_argument("--headless")  # Безголовий режим
    options.add_argument("--disable-dev-shm-usage")

    # Запускаємо Chrome через Selenium
    driver = webdriver.Chrome(service=service, options=options)
    
    yield driver  # Це дасть можливість використовувати driver в тестах
    
    driver.quit()  # Закриваємо драйвер після завершення тесту
    xvfb.stop()  # Зупиняємо Xvfb, коли тести завершені

def test_login_page(driver):
    driver.get("http://localhost:1337/pages/register.php")
    wait = WebDriverWait(driver, 30)
    
    # Знаходимо елементи на сторінці
    username = driver.find_element(By.NAME, "username")
    password = driver.find_element(By.NAME, "password")
    login_button = driver.find_element(By.XPATH, "/html/body/div[1]/form/button[2]")
    
    # Заповнюємо форму
    username.send_keys("testuser")
    password.send_keys("testpassword")
    
    # Клікаємо на кнопку
    wait.until(EC.element_to_be_clickable((By.XPATH, "/html/body/div[1]/form/button[1]"))).click()
    
    # Перевіряємо результат
    heading = driver.find_element(By.XPATH, "//h2[@class='form-signin-heading']")
    assert heading.text == "Авторизація в систему", "Failed to login"

# Запуск тесту
if __name__ == "__main__":
    pytest.main()
