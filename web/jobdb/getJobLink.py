#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
getJobLink.py เอาไว้สำหรับเก็บลิ้งต่างๆที่จำเป็นต้องใช้
by Sorapunya Insala
"""
import requests
from project_end import conDB
from bs4 import BeautifulSoup
import time
from datetime import datetime,timedelta
from project_end.web.jobdb import getPage

def get_day(name):
    finalReslut=[]
    db=conDB.conDB()
    c = db.cursor()
    sql = """ SELECT id FROM `jfunc` WHERE `name`=%s"""
    sql2 = """ SELECT time FROM `main` WHERE `jfunc`=%s ORDER BY time DESC LIMIT 1"""
    sql3 = """ SELECT COUNT(time) FROM `main` WHERE `time`=%s AND `jfunc`=%s"""
    c.execute(sql,(name))
    getID = c.fetchall()
    getID=getID[0][0]
    c.execute(sql2,(getID))
    getTime = c.fetchall()
    getTime=getTime[0][0]
    getTime=datetime.combine(getTime, datetime.min.time())
    timeNow=datetime.now()
    timeNow=timeNow.replace(hour=0, minute=0,second=0,microsecond=0)
    getTime=getTime.replace(hour=0, minute=0,second=0,microsecond=0)
    reslut =timeNow - getTime
    reslut=reslut.days
    if(reslut >= 29):
        finalReslut.append(reslut)
        finalReslut.append(0)
    else:
        reslut+=1
        finalReslut.append(reslut)
        lastDay=datetime.now() - timedelta(reslut)
        lastDay=lastDay.replace(hour=0, minute=0,second=0,microsecond=0)
        c.execute(sql3,(lastDay,getID))
        overDay = c.fetchall()
        overDay=overDay[0][0]
        finalReslut.append(overDay)
    return finalReslut

####################################
##  เก็บลิ้งงานทุกแบบ
####################################

url_to_scrape='http://th.jobsdb.com/th'
r = requests.get(url_to_scrape)
soup = BeautifulSoup(r.text,"lxml")
jobs_links=[]
jobs_date=[]
overDay=0
data=soup.select("div[id='jobBrowserTabBody0'] li.browse-job-category div.job-category-wrapper")
j=0
for i in data:
    jobs_links.append('http://th.jobsdb.com'+i.find('a')['href'].rsplit('/',1)[0]+'/')
    jobs_date.append(i.find('a').text.strip())
    j=j+1
print("เจอทั้งหมด "+str(j)+ " อาชีพ")
index_page=0
for i in jobs_links:
    print("ลิ้งอาชีพที่ทำอยู่ "+i +"อันที่ "+ str(index_page+1))
    day=get_day(jobs_date[index_page])
    print(day)
    getPage.getPage(i,str(index_page+1),str(j),day[0],day[1])
    index_page=index_page+1
