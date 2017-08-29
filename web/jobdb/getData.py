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
        r = requests.get(job_link)
        soup = BeautifulSoup(r.text,"lxml")
        job_detail={}

        #ชื่อบริษัท
        data=soup.select("h2.jobad-header-company")
        cop_temp=""
        job_detail['cop_name'] = '-'
        for i in data:
            cop_temp = i.text.replace(' ', '').strip()
        if cop_temp != "":
            job_detail['cop_name'] = cop_temp
        #print(cop_temp)

        #เวลาโพส
        data=soup.select("p.data-timestamp")
        for i in data:
            tempDates=i.text.strip()
            mon=strptime(tempDates[3:6],'%b').tm_mon
            tempDate= "20"+ tempDates[7:9] + "-" + str(mon) +"-"+ tempDates[0:2]
            R = datetime.strptime(tempDate,'%Y-%m-%d')
            job_detail['time'] = R

        #ชื่ออาชีพ
        data=soup.select("h1.general-pos")
        for i in data:
            job_detail['j_name'] = i.text.strip()

        #หาสวัสดิการ
        if soup.select("div.meta-benefit"):
            job_detail['ben'] = "have"
        else:
            job_detail['ben'] = "none"
            data=soup.select("div.jobad-primary-details")
            for i in data:
                detail = i.text.replace('\n', ' ').replace('\xa0', '').strip()
            if "Benefits" in detail:
                    job_detail['ben'] = "have"
            else:
                if "สวัสดิการ" in detail:
                    job_detail['ben'] = "have"

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

        #สถานที่
        data=soup.select("p[itemprop='jobLocation']")
        if data == []:
            data=soup.select("h3[itemprop='jobLocation'] a")
        for i in data:
            job_detail['loc'] = i.text.strip()

        #ประเภทสัญญาจ้าง
        data=soup.select("div.meta-employmenttype")
        if data != []:
            for i in data:
                job_detail['type'] = i.text.replace(' ', ' ').replace('Employment Type', '').strip()
        else:
            job_detail['type']="none"

        #ประเภทธุรกิจ
        data=soup.select("div.meta-industry p[itemprop='industry']")
        for i in data:
            job_detail['indus'] = i.text.strip()

        #ประเภทงาน
        data=soup.select("div.meta-jobfunction p a")
        j=0
        tempjf=""
        for i in data:
            if j%2 == 0:
                if i.text.strip() not in tempjf:
                    tempjf = tempjf + i.text.strip() + ". "
                j=j+1
            else:
                j=j+1
        job_detail['jfunc']=tempjf

        if index % 50==0:
            print("ทำอันที่: "+ str(index))
        index = index+1
        #เพิ่มข้อมูลไปที่listหลักแล้วทำอันต่อไป
        jobs_detail.append(job_detail)
    #############################################
    #############################################
    #print(jobs_detail)
    uploadData.uploadToSql(jobs_detail)

