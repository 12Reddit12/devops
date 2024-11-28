from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from webdriver_manager.chrome import ChromeDriverManager
import pytest
import time

@pytest.fixture(scope="module")
def driver():
    service = Service(ChromeDriverManager().install())
    options = webdriver.ChromeOptions()
    options.add_argument("--headless")  # Безголовий режим
    options.add_argument("--disable-dev-shm-usage")
    options.binary_location = "/usr/bin/google-chrome-stable"

    driver = webdriver.Chrome(service=service, options=options)
    yield driver
    driver.quit()

def test_login_page(driver):
    driver.get("http://localhost:1337/pages/register.php")
    username = driver.find_element(By.NAME, "username")
    password = driver.find_element(By.NAME, "password")
    login_button = driver.find_element(By.XPATH, "/html/body/div[1]/form/button[2]")
    username.send_keys("testuser")
    password.send_keys("testpassword")
    login_button.click()
    time.sleep(3)
    assert driver.current_url == "http://localhost:1337/pages/login.php", "Failed to login"
