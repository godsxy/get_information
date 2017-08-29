#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
getPage.py เอาไว้สำหรับเก็บลิ้งในแต่ละหน้า
Ver 1.0
by Sorapunya Insala
"""
from datetime import datetime, timedelta
from time import strptime
import requests
from bs4 import BeautifulSoup
from project_end.web.jobdb import getData

####################################
##  เก็บเลขหน้าของาน
####################################
## ถ้าจะเก็บข้อมูลย้อนหลังกี่วันให้เปลี่ยนตัวเลขที่ days
##

def getPage(jobLink):
    yday=datetime.now() - timedelta(days=1)
    yday=yday.replace(hour=0, minute=0,second=0,microsecond=0)
    page = 1
    sumjob=0
    stopPls=0
    jobs_links=[]
    while True:
        sumList = 0
        url_to_scrape=jobLink+str(page)
        r = requests.get(url_to_scrape)
        soup = BeautifulSoup(r.text,"lxml")
        data=soup.select("meta[itemprop='datePosted']")
        for i in data:
            TempDates = i.get('content')
            mon=strptime(TempDates[3:6],'%b').tm_mon
            postTime = "20"+TempDates.split("-")[2] +'-'+ str(mon) +'-'+TempDates.split("-")[0]
            R = datetime.strptime(postTime,'%Y-%m-%d')
            if R < yday:
                stopPls=1
                break
            else:
                sumList=sumList+1
                sumjob=sumjob+1
        print("หน้าที่: "+str(page) + "  มีจำนวนอาชีพ: "+str(sumList))
        data=soup.select(".result-sherlock-cell .job-main .job-title")
        for i in data:
            if sumList > 0 :
                jobs_links.append(i.find('a')['href'])
                sumList=sumList-1
            else:
                break
        if stopPls ==1:
            print("ถึงวันที่กำหนดแล้ว!!!")
            break
        else:
            page=page+1

    #print(len(jobs_links))
    print("เริ่มทำการดูดข้อมูลมีทั้งหมด "+str(sumjob)+" อาชีพ")
    getData.getData(jobs_links)
