#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
getJobLink.py เอาไว้สำหรับเก็บลิ้งต่างๆที่จำเป็นต้องใช้
Ver 1.0
by Sorapunya Insala
"""
from datetime import datetime, timedelta
from time import strptime
import requests
from bs4 import BeautifulSoup
import getData

####################################
##  เก็บเลขหน้าของาน
####################################
## ถ้าจะเก็บข้อมูลทั้งหมดให้เปลี่ยน days = 31
yday=datetime.now() - timedelta(days=31)
yday=yday.replace(hour=0, minute=0,second=0,microsecond=0)
page = 13
stopPls=0
jobs_links=[]

while True:
    sumList = 0
    url_to_scrape='https://th.jobsdb.com/th/jobs/information-technology/'+str(page)
    r = requests.get(url_to_scrape)
    soup = BeautifulSoup(r.text,"lxml")
    data=soup.select("meta[itemprop='datePosted']")
    for i in data:
        TempDates = i.get('content')
        mon=strptime(TempDates[3:6],'%b').tm_mon
        postTime = "20"+TempDates.split("-")[2] +'-'+ str(mon) +'-'+TempDates.split("-")[0]
        R = datetime.strptime(postTime,'%Y-%m-%d')
        if R == yday:
            stopPls=1
            break
        else:
            sumList=sumList+1
    print(sumList)
    data=soup.select(".result-sherlock-cell .job-main .job-title")
    for i in data:
        if sumList == 50:
            jobs_links.append(i.find('a')['href'])
        elif sumList > 0 :
            jobs_links.append(i.find('a')['href'])
            sumList=sumList-1
        else:
            break

    if page==52:
        break
    elif stopPls ==1:
        break
    else:
        page=page+1

#print(len(jobs_links))
getData.getData(jobs_links)
