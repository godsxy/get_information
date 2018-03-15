#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
getPage.py เอาไว้สำหรับเก็บลิ้งในแต่ละหน้า
Ver 1.0
by Sorapunya Insala
"""
from datetime import datetime, timedelta
from time import strptime
from datetime import datetime
import time
import requests
from bs4 import BeautifulSoup
from project_end.web.jobdb import getData
import math

####################################
##  เก็บเลขหน้าของาน
####################################
##  day max = 29
##

def getPage(jobLink,orderPage,orderMax):
    days=29
    yday=datetime.now() - timedelta(days)
    tday=datetime.now()
    tday=tday.replace(hour=0, minute=0,second=0,microsecond=0)
    yday=yday.replace(hour=0, minute=0,second=0,microsecond=0)
    page = 1
    maxpage=0
    sumjob=0
    stopPls=0
    jobs_links=[]
    while True:
            try:
                r = requests.get(jobLink)
                break
            except:
                print("มีปัญหาการหาจำนวนหน้าสูงสุด")
                print("ที่ลิ้ง: "+str(jobLink))
                time.sleep(30)
                continue
    soup = BeautifulSoup(r.text,"lxml")
    data=soup.select("h1 span[id='firstLineCriteriaContainer'] em")
    for i in data:
        maxpage = int(i.text.strip())/50
        maxpage = math.ceil(maxpage)

    while True:
        sumList = 0
        url_to_scrape=jobLink+str(page)
        while True:
            try:
                r = requests.get(url_to_scrape)
                break
            except:
                print("มีปัญหากลับไปรีเควสใหม่")
                print("ที่ลิ้ง: "+str(url_to_scrape))
                time.sleep(30)
                continue
        soup = BeautifulSoup(r.text,"lxml")
        data=soup.select("meta[itemprop='datePosted']")
        for i in data:
            TempDates = i.get('content')
            #mon=strptime(TempDates[5:7],'%m').tm_mon
            #postTime = "20"+TempDates.split("-")[2] +'-'+ str(mon) +'-'+TempDates.split("-")[0]
            R = datetime.strptime(TempDates[0:10],'%Y-%m-%d')
            if R < yday:
                stopPls=1
                break
            elif page > maxpage:
                stopPls=1
                break
            elif R == tday:
                pass
            else:
                sumList=sumList+1
                sumjob=sumjob+1
        print("หน้าที่: "+str(page) + "/"+str(maxpage)+"  มีจำนวนอาชีพ: "+str(sumList))
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
    getData.getData(jobs_links,orderPage,orderMax)
