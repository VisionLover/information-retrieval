import time
import mysql.connector
from selenium import webdriver
from selenium .webdriver.common.keys import Keys
from selenium.webdriver.chrome.options import Options
chrome_options = Options()
# chrome_options.add_argument("--headless")
from selenium .webdriver.common.keys import Keys
driver = webdriver.Chrome(options=chrome_options)
for x in range(1,501):
    x = str(x)
    driver.get("https://jobinja.ir/jobs?page="+x)
    time.sleep(3)

    boxes = driver.find_element_by_xpath("html/body/div[1]/div[3]/form[2]/div/div/div[2]/section/div/ul")
    lboxes = boxes.find_elements_by_xpath("li")
    length = len(lboxes)
    print(length)
    for i in range(0,length):
        link = lboxes[i].find_element_by_xpath("div/div[1]/h3/a").get_attribute('href')
        title = lboxes[i].find_element_by_xpath("div/div[1]/h3/a").text
        company = lboxes[i].find_element_by_xpath("div/div[1]/ul/li[1]/span").text
        city = lboxes[i].find_element_by_xpath("div/div[1]/ul/li[2]/span").text
        mytime = lboxes[i].find_element_by_xpath("div/div[1]/ul/li[3]/span/span").text
        mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="searching"
        )

        mycursor = mydb.cursor()
        sql = "INSERT INTO records (link, title, company, city, time) VALUES (%s, %s, %s, %s, %s)"
        val = (link, title, company, city, mytime)

        mycursor.execute(sql, val)

        mydb.commit()

        print(mycursor.rowcount, "record inserted.")

    time.sleep(2)

driver.quit()