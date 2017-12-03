#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
getData.py เอาไว้เก็บข้อมูลจากหน้าแสดงรายการงานเพียงหน้าเดียว( 1 page )และส่งไปยัง uploadData เพื่อนำขึ้น database
by Sorapunya Insala
"""
import requests
from time import strptime
from project_end import uploadData
from datetime import datetime, timedelta
import time
import sys
from bs4 import BeautifulSoup

####################################
####################################
##  เก็บรายละเอียดของงาน
####################################
def getData(jobs_links):
    jobs_detail=[]
    #for job_link in jobs_links[35:38]:
    index = 1
    for job_link in jobs_links:
        #print(job_link)

        while True:
            try:
                r = requests.get(job_link)
                break
            except:
                print("มีปัญหากลับไปรีเควสใหม่")
                print("ที่ลิ้ง: "+str(job_link))
                time.sleep(30)
                continue
        soup = BeautifulSoup(r.text,"lxml")
        job_detail={}

        #ชื่ออาชีพ
        data=soup.select("h1.general-pos")
        for i in data:
            job_detail['j_name'] = i.text.strip()

        #ชื่อบริษัท
        data=soup.select("h2.jobad-header-company")
        cop_temp=""
        job_detail['cop_name'] = '-'
        for i in data:
            cop_temp = i.text.replace(' ', '').strip()
        if cop_temp != "":
            job_detail['cop_name'] = cop_temp
        #print(cop_temp)

        #สถานที่
        AllLocation=["Amnat Charoen","Ang Thong","Ayutthaya","Bangkok","Bueng Kan","Buri Ram","Chachoengsao","Chai Nat","Chaiyaphum","Chanthaburi","Chiang Mai","Chiang Rai","ChonBuri","Chumphon","Kalasin","Kamphaeng Phet","Kanchanaburi","Khon Kaen","Krabi","Lampang","Lampoon","Loei","LopBuri","Mae Hong Son","Maha Sarakham","Mukdahan","Nakhon Pathom","Nakhon Phanom","Nakhon Ratchasima","Nakhon Sawan","Nakhon Si Thammarat","Nakornnayok","Nan","Narathiwat","Nong Bua Lamphu","Nong Khai","Nonthaburi","PathumThani","Pattani","Petchaburi","Phangnga","Phatthalung","Phayao","Phetchabun","Phichit","Phitsanulok","Phrachinburi","Phrae","Phuket","Prachuap Khiri Khan","Rajchaburi","Ranong","Rayong","Roi Et","Sa Kaeo","Sakon Nakhon","Samut Sakhon","Samut Songkhram","Samutprakarn","Saraburi","Satun","Si Sa Ket","SingBuri","Songkhla","Sukhothai","SuphanBuri","Surat Thani","Surin","Tak","Trang","Trat","Ubon Ratchathani","Udon Thani","Uthai Thani","Uttaradit","Yala","Yasothon"];
        tempLoc=""
        data=soup.select("p[itemprop='jobLocation']")
        if data == []:
            data=soup.select("h3[itemprop='jobLocation'] a")
        for i in data:
            tempLoc = i.text.split(" >")[0].strip()
        if tempLoc not in AllLocation:
            job_detail['loc'] = "AroundBangkok"
        else:
            job_detail['loc'] = tempLoc

        #รายละเอียด
        data=soup.select("div.jobad-primary-details span[itemprop='description']")
        for i in data:
            #print("<br>".join(i.text.strip().replace('\xa0','').splitlines()))
            job_detail['detail'] = "<br>".join(i.text.strip().replace('\xa0','').splitlines())

        #หาระดับพนักงาน
        if soup.select("b.primary-meta-lv"):
            data = soup.select("b.primary-meta-lv")
            for i in data:
                job_detail['lv'] = i.text.strip()
        else:
            job_detail['lv'] = "-"

        #การศึกษาขั้นต่ำ
        data=soup.select("span[itemprop='educationRequirements']")
        if data != []:
            for i in data:
                if i.text.strip() not in "(N/A)":
                    job_detail['edu'] = i.text.strip()
                else:
                    job_detail['edu']="None"
        else:
            job_detail['edu']="None"

        #ประเภทสัญญาจ้าง
        data=soup.select("div.meta-employmenttype")
        if data != []:
            for i in data:
                job_detail['type'] = i.text.replace(' ', ' ').replace('Employment Type', '').strip()
        else:
            job_detail['type']="none"

        #ประเภทงาน
        data=soup.select("div.meta-jobfunction p a")
        for i in data:
            job_detail['jfunc']=i.text.strip()
            break

        #ประเภทธุรกิจ
        data=soup.select("div.meta-industry p[itemprop='industry']")
        for i in data:
            job_detail['indus'] = i.text.strip()

        #เวลาโพส
        try:
            data=soup.select("meta[itemprop='datePosted']")
            for i in data:
                tempDates=i.get('content')
                #mon=strptime(tempDates[3:6],'%b').tm_mon
                #tempDate= "20"+ tempDates[7:9] + "-" + str(mon) +"-"+ tempDates[0:2]
                if tempDates[4] == '/':
                    R = datetime.strptime(tempDates[0:9],'%m/%d/%Y')
                else:
                    R = datetime.strptime(tempDates[0:10],'%m/%d/%Y')
                job_detail['time'] = R
        except BaseException as e:
            print(str(e))

        job_detail['index']=index
        if index % 50==0:
            print("ดูดข้อมูลอาชีพลำดับที่: " + str(index) + " เสร็จแล้ว")
        index = index+1
        #เพิ่มข้อมูลไปที่listหลักแล้วทำอันต่อไป
        jobs_detail.append(job_detail)
    #############################################
    #############################################
    #print(jobs_detail)
    print("ได้เวลาอัพขึ้นฐานข้อมูลแล้ว!!!!")
    uploadData.uploadToSql(jobs_detail)

#jobs_links = ["https://th.jobsdb.com/th/en/job/accounting-officer-%E0%B8%9E%E0%B8%99%E0%B8%B1%E0%B8%81%E0%B8%87%E0%B8%B2%E0%B8%99%E0%B8%9A%E0%B8%B1%E0%B8%8D%E0%B8%8A%E0%B8%B5%E0%B8%A5%E0%B8%B9%E0%B8%81%E0%B8%AB%E0%B8%99%E0%B8%B5%E0%B9%89-%E0%B8%9A%E0%B8%B1%E0%B8%8D%E0%B8%8A%E0%B8%B5%E0%B9%80%E0%B8%88%E0%B9%89%E0%B8%B2%E0%B8%AB%E0%B8%99%E0%B8%B5%E0%B9%89-%E0%B8%AA%E0%B8%B2%E0%B8%82%E0%B8%B2%E0%B8%A5%E0%B8%B2%E0%B8%94%E0%B8%9E%E0%B8%A3%E0%B9%89%E0%B8%B2%E0%B8%A7-300003001496644"]
#getData(jobs_links)
