#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
getJobLink.py เอาไว้สำหรับเก็บลิ้งต่างๆที่จำเป็นต้องใช้
by Sorapunya Insala
"""
import requests
import conDB
from bs4 import BeautifulSoup
import time
from datetime import datetime,timedelta
import getPage

def get_day(name):
    finalReslut=[]
    db=conDB.conDB()
    c = db.cursor()
    sqlGetIdJfunc = """ SELECT id FROM `jfunc` WHERE `name`=%s"""
    sqlGetLastTime = """ SELECT time FROM `main` WHERE `jfunc`=%s ORDER BY time DESC LIMIT 1"""
    while True:
        getID = c.execute(sqlGetIdJfunc,(name))
        if getID:
            getID = c.fetchall()
            getID=getID[0][0]
            break
        else:
            sql4="INSERT INTO `jfunc`(`name`) VALUES (%s)"
            c.execute(sql4,(name))
            db.commit()
            continue
    while True:
        getTime = c.execute(sqlGetLastTime,(getID))
        if getTime:
            getTime = c.fetchall()
            getTime=getTime[0][0]
            getTime=datetime.combine(getTime, datetime.min.time())
            timeNow=datetime.now()
            timeNow=timeNow.replace(hour=0, minute=0,second=0,microsecond=0)
            getTime=getTime.replace(hour=0, minute=0,second=0,microsecond=0)
            reslut =timeNow - getTime
            reslut=reslut.days
            break
        else:
            reslut=29
            break
    if(reslut >= 29):
        reslut=29
        finalReslut.append(reslut)
    else:
        finalReslut.append(reslut)
    return finalReslut

####################################
##  เก็บลิ้งงานทุกแบบ
####################################

url_to_scrape='https://th.jobsdb.com/th'
r = requests.get(url_to_scrape)
soup = BeautifulSoup(r.text,"lxml")
jobs_links=[]
jobs_date=[]
overDay=0
data=soup.select("div[id='jobBrowserTabBody0'] li.browse-job-category div.job-category-wrapper")
j=0
for i in data:
    jobs_links.append('https://th.jobsdb.com'+i.find('a')['href'].rsplit('/',1)[0]+'/')
    jobs_date.append(i.find('a').text.strip())
    j=j+1
print("เจอทั้งหมด "+str(j)+ " อาชีพ")
index_page=0
for i in jobs_links:
    print("ลิ้งอาชีพที่ทำอยู่ "+i +" อันที่ "+ str(index_page+1))
    day=get_day(jobs_date[index_page])
    #print(str(day[0])+" From gJL")
    getPage.getPage(i,str(index_page+1),str(j),day[0])
    index_page=index_page+1
