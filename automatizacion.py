from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import pandas as pd
import random
import string
import time

# ------- Preparación del Dataframe -------
# Cargar el archivo Excel
data_excel_updated = pd.read_excel('G:\\Descargas_nuevo\\MATRICULA ISIC AGO23-ENE24 (1).xlsx', skiprows=2)

# Funciones para generar datos
def generate_fake_curp(name):
    if not isinstance(name, str):
        return "INVALIDCURP"
    initials = ''.join([word[0] for word in name.split()[:2]])
    date = ''.join([str(random.randint(0, 9)) for _ in range(6)])
    random_chars = ''.join(random.choice(string.ascii_uppercase) for _ in range(8))
    return initials + date + random_chars

def generate_random_password():
    return ''.join(random.choice(string.ascii_letters + string.digits) for _ in range(8))

def generate_email(control_number):
    return f"L{control_number}@huetamo.tecnm.mx"

def generate_phone_number():
    return ''.join([str(random.randint(0, 9)) for _ in range(10)])

# Generar CURP, contraseñas, IDs de tutor, correos electrónicos y números de teléfono
data_excel_updated['CURP'] = data_excel_updated['NOMBRE'].apply(generate_fake_curp)
data_excel_updated['PASSWORD'] = [generate_random_password() for _ in range(len(data_excel_updated))]
data_excel_updated['TUTOR_ID'] = 't' + data_excel_updated['CONTROL'].astype(str)
data_excel_updated['EMAIL'] = data_excel_updated['CONTROL'].apply(generate_email)
data_excel_updated['PHONE'] = [generate_phone_number() for _ in range(len(data_excel_updated))]

# ------- Automatización con Selenium -------
# Ruta al ejecutable de ChromeDriver
from selenium.webdriver.chrome.options import Options

chrome_options = Options()
chrome_options.binary_location = 'G:\\Descargas_nuevo\\chromedriver_win32\\chromedriver.exe'

driver = webdriver.Chrome(options=chrome_options)

# Inicializar el WebDriver

# Navegar al sitio web
driver.get('http://localhost/sech.2(1)/SECH.2/administrador/regAlumno.php')

# Rellenar el formulario con datos del archivo Excel
for index, row in data_excel_updated.iterrows():
    # Rellenar el formulario del alumno
    driver.find_element_by_name('noControl').send_keys(str(row['CONTROL']))
    driver.find_element_by_name('curp').send_keys(row['CURP'])
    driver.find_element_by_name('name').send_keys(row['NOMBRE'].split()[0])
    driver.find_element_by_name('firstLastname').send_keys(row['NOMBRE'].split()[1])
    driver.find_element_by_name('secundLastname').send_keys(row['NOMBRE'].split()[2])
    driver.find_element_by_name('email').send_keys(row['EMAIL'])
    driver.find_element_by_name('password').send_keys(row['PASSWORD'])
    driver.find_element_by_name('grupo').send_keys(row['Grupo'])
    
    # Rellenar el formulario del tutor usando la misma información del alumno
    driver.find_element_by_name('noUsuario').send_keys(row['TUTOR_ID'])
    driver.find_element_by_name('nombreTutor').send_keys(row['NOMBRE'].split()[0])
    driver.find_element_by_name('primerApellidoTutor').send_keys(row['NOMBRE'].split()[1])
    driver.find_element_by_name('segundoApellidoTutor').send_keys(row['NOMBRE'].split()[2])
    driver.find_element_by_name('telefono').send_keys(row['PHONE'])
    driver.find_element_by_name('passwordTutor').send_keys(row['PASSWORD'])

    # Hacer clic en el botón de enviar
    driver.find_element_by_name('submit').click()

    # Esperar unos segundos antes de registrar al siguiente usuario
    time.sleep(5)

# Cerrar el navegador después de registrar a todos los usuarios
driver.quit()
