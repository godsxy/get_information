#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
getJobLink.py เอาไว้สำหรับเก็บลิ้งต่างๆที่จำเป็นต้องใช้
by Sorapunya Insala
"""
import requests
from bs4 import BeautifulSoup
from project_end.web.jobdb import getPage
url_to_scrape='http://th.jobsdb.com/th'
r = requests.get(url_to_scrape)
soup = BeautifulSoup(r.text,"lxml")

####################################
##  เก็บลิ้งงานทุกแบบ
####################################
jobs_links=[]
data=soup.select("div[id='jobBrowserTabBody0'] li.browse-job-category div.job-category-wrapper")
j=0
for i in data:
    jobs_links.append('http://th.jobsdb.com/th'+i.find('a')['href'].rsplit('/',1)[0]+'/')
    j=j+1
print("เจอทั้งหมด "+str(j)+ " อาชีพ")
for i in jobs_links:
    print("ลิ้งอาชีพที่ทำอยู่ "+i)
    getPage.getPage(i)

