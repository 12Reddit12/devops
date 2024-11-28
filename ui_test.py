from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.wait import WebDriverWait

from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import pytest
import time

@pytest.fixture(scope="module")
def driver():
    service = Service(ChromeDriverManager().install()) 
    user_agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36"

    options = webdriver.ChromeOptions()
    options.headless = True
    options.add_argument(f'user-agent={user_agent}')
    options.add_argument("--window-size=1920,1080")
    options.add_argument('--ignore-certificate-errors')
    options.add_argument('--allow-running-insecure-content')
    options.add_argument("--disable-extensions")
    options.add_argument("--proxy-server='direct://'")
    options.add_argument("--proxy-bypass-list=*")
    options.add_argument("--start-maximized")
    options.add_argument('--disable-gpu')
    options.add_argument('--disable-dev-shm-usage')
    options.add_argument('--no-sandbox')
 
    driver = webdriver.Chrome(service = service, options=options)
    yield driver
    driver.quit()

def test_login_page(driver):
    driver.get("http://localhost:1337/pages/register.php")
    wait = WebDriverWait(driver, 30)
    username = driver.find_element(By.NAME, "username")
    password = driver.find_element(By.NAME, "password")
    login_button = driver.find_element(By.XPATH, "/html/body/div[1]/form/button[2]")
    username.send_keys("testuser")
    password.send_keys("testpassword")
    wait.until(EC.element_to_be_clickable((By.XPATH, "/html/body/div[1]/form/button[1]"))).click()
    heading = driver.find_element(By.XPATH, "//h2[@class='form-signin-heading']")
    assert heading.text == "Авторизація в систему", "Failed to login"
