from selenium import webdriver
from selenium.webdriver.common.by import By
import pytest


driver_path = "/usr/local/bin/chromedriver"

@pytest.fixture(scope="module")
def driver():
    driver = webdriver.Chrome(executable_path=driver_path)
    yield driver
    driver.quit()

def test_login_page(driver):
    driver.get("http://localhost:1337")
    login_form = driver.find_element(By.ID, "loginForm")
    assert login_form is not None, "Login form not found"
