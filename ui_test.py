from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from webdriver_manager.chrome import ChromeDriverManager
import pytest

@pytest.fixture(scope="module")
def driver():
    service = Service(ChromeDriverManager().install())
    options = webdriver.ChromeOptions()

    options.add_argument('--headless') 
    options.add_argument('--no-sandbox')
    options.add_argument('--disable-dev-shm-usage')
    options.binary_location = "/usr/bin/google-chrome-stable"

    driver = webdriver.Chrome(service=service, options=options)
    yield driver
    driver.quit()

def test_login_page(driver):
    driver.get("http://localhost:1337")
    login_form = driver.find_element(By.ID, "loginForm")
    assert login_form is not None, "Login form not found"
