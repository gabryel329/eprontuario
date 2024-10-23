# public/python/blackbox_automation.py

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.firefox.service import Service
from webdriver_manager.firefox import GeckoDriverManager
import time
import sys

# L� o input enviado pelo Laravel
mensagem = sys.argv[1] if len(sys.argv) > 1 else "Oi, tudo bem?"

# Configura��o do WebDriver para Firefox
options = webdriver.FirefoxOptions()
options.add_argument("--headless")  # Executa em segundo plano
options.add_argument("--window-size=1920,1080")  # Define o tamanho da janela
options.add_argument("--disable-gpu")  # Evita usar a GPU

# Inicia o WebDriver em modo headless
driver = webdriver.Firefox(service=Service(GeckoDriverManager().install()), options=options)

try:
    # Acessa o site do Blackbox AI
    driver.get("https://www.blackbox.ai/")

    # Aguarda o carregamento da p�gina
    time.sleep(10)

    # Encontra o campo de entrada de texto e envia a mensagem
    chat_box = driver.find_element(By.ID, "chat-input-box")
    chat_box.send_keys(mensagem)
    chat_box.send_keys(Keys.ENTER)

    # Aguarda pela resposta
    time.sleep(15)

    # Captura a resposta
    response_elements = driver.find_elements(By.CLASS_NAME, "mb-2")
    response = "\n".join([element.text for element in response_elements])

    if response:
        print(response)
    else:
        print("Nenhuma resposta encontrada.")

except Exception as e:
    print(f"Ocorreu um erro: {e}")

finally:
    # Fecha o navegador
    driver.quit()
