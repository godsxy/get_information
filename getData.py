#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
getData.py เอาไว้เก็บข้อมูลจากหน้าแสดงรายการงานเพียงหน้าเดียว( 1 page )และส่งไปยัง uploadData เพื่อนำขึ้น database
by Sorapunya Insala
"""
import requests
import uploadData
import conDB
from datetime import datetime
import time
import pymysql
from bs4 import BeautifulSoup

####################################
####################################
##  เก็บรายละเอียดของงาน
####################################
def get_idInDB(data,table):
    errorLen=0
    db=conDB.conDB()
    c = db.cursor()
    sql = """ SELECT id FROM `"""+table+"""` WHERE `name`=%s"""
    sql2 = """ INSERT INTO `"""+table+"""`(`name`) VALUES (%s)"""
    while True:
        c.execute(sql,(data))
        getID = c.fetchall()
        if getID:
            return getID[0][0]
        else:
            try:
                if(errorLen>0):
                    return "004broken004"
                c.execute(sql2,(data))
                db.commit()
                print("Add new "+ table)
                errorLen+=1
                continue
            except:
                return "004broken004"

def get_jobName(soup):
    data=soup.select("h1.general-pos")
    for i in data:
        return i.text.strip()

def get_copName(soup):
    data=soup.select("h2.jobad-header-company")
    cop_temp=""
    for i in data:
        cop_temp = i.text.replace(' ', '').strip()
    if cop_temp != "":
        return get_idInDB(cop_temp,"cop_name")
    else:
        return get_idInDB('-',"cop_name")

def get_loc(soup):
    AllLocation=["Ang Thong"
,"Ayutthaya"
,"Bangkok"
,"Chachoengsao"
,"Chai Nat"
,"Chiang Mai"
,"Chiang Rai"
,"Chonburi"
,"Chumphon"
,"Kanchanaburi"
,"Khon Kaen"
,"Krabi"
,"Lampang"
,"Lampoon"
,"Lopburi"
,"Mae Hong Son"
,"Nakhon Ratchasima"
,"Nakhon Si Thammarat"
,"Nakornnayok"
,"Nakornsawan"
,"Nonthaburi"
,"Pathumthani"
,"Petchaburi"
,"Phitsanulok"
,"Phrachinburi"
,"Phuket"
,"Prachuap Khiri Khan"
,"Rajchaburi"
,"Rayong"
,"Samutprakarn"
,"Samutsongkhram"
,"Saraburi"
,"Singburi"
,"Songkhla"
,"Suphanburi"
,"Surat Thani"
,"Tak"
,"Ubon Ratchathani"
,"Udon Thani"
,"Yala"
,"Yasothon"];
    tempLoc=""
    data=soup.select("a.loc-link")
    for i in data:
        tempLoc = i.text.split(" >")[0].strip()
    if tempLoc not in AllLocation:
        return get_idInDB("AroundBangkok","location")
    else:
        return get_idInDB(tempLoc,"location")

def get_detail(soup):
    data=soup.select("div.jobad-primary-details")
    for i in data:
        return "<br>".join(i.text.strip().replace('\xa0','').splitlines())

def get_lvEmp(soup):
    if soup.select("b.primary-meta-lv"):
        data = soup.select("b.primary-meta-lv")
        for i in data:
            return i.text.strip()
    else:
        return "-"

def get_edu(soup):
    data=soup.select("p.meta-item.primary-meta-edu.col-xs-9 span")
    if data != []:
        for i in data:
            if i.text.strip() not in "(N/A)":
                return i.text.strip()
            else:
                return "None"
    else:
        return "None"

def get_type(soup):
    data=soup.select("div.meta-employmenttype")
    if data != []:
        for i in data:
            return i.text.replace(' ', ' ').replace('Employment Type', '').strip()
    else:
        return "none"

def get_jfunc(soup):
    data=soup.select("div.meta-jobfunction p a")
    for i in data:
        return get_idInDB(i.text.strip(),"jfunc")

def get_indus(soup):
    data=soup.select("div.primary-meta-box.row.meta-industry p a")
    for i in data:
        return i.text.strip()

def get_time(soup):
    try:
        data=soup.select("div.primary-general-box.general-data meta")
        for i in data:
            tempDates=i.get('content')
            #mon=strptime(tempDates[3:6],'%b').tm_mon
            #tempDate= "20"+ tempDates[7:9] + "-" + str(mon) +"-"+ tempDates[0:2]
            if tempDates[1] == '/':
                if tempDates[3] == '/':
                    R = datetime.strptime(tempDates[0:8],'%m/%d/%Y')
                else:
                    R = datetime.strptime(tempDates[0:9],'%m/%d/%Y')
            else:
                if tempDates[4] == '/':
                    R = datetime.strptime(tempDates[0:9],'%m/%d/%Y')
                else:
                    R = datetime.strptime(tempDates[0:10],'%m/%d/%Y')
            return R
    except BaseException as e:
        print(str(e))

def ck_exist(cop,loc,time,jfunc):
    db=conDB.conDB()
    c = db.cursor()
    sql = """ SELECT id FROM main WHERE `cop_name`=%s AND `loc`=%s AND `time`=%s AND `jfunc`=%s"""
    found = c.execute(sql,(cop,loc,time,jfunc))
    return found

def getData(jobs_links,orderPage,orderMax):
    jobs_detail=[]
    #for job_link in jobs_links[35:38]:
    index = 1
    MaxDuplicate=0
    skip=0
    for job_link in reversed(jobs_links):
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

        #ชื่อบริษัท
        job_detail['cop_name'] = get_copName(soup)
        if(job_detail['cop_name']=="004broken004"):
            print("DATA BROKEN")
            continue

        #สถานที่
        job_detail['loc'] = get_loc(soup)
        if(job_detail['loc']=="004broken004"):
            print("DATA BROKEN")
            continue

        #เวลาโพส
        job_detail['time'] = get_time(soup)
        if(job_detail['time']=="004broken004"):
            print("DATA BROKEN")
            continue

        #ประเภทงาน
        job_detail['jfunc'] = get_jfunc(soup)
        if(job_detail['jfunc']=="004broken004"):
            print("DATA BROKEN")
            continue

        ##ใช้ข้อมูลแค่นี้ในการตรวจเช็ตการซ้ำ
        if(ck_exist(job_detail['cop_name'],job_detail['loc'],job_detail['time'],job_detail['jfunc'])):
            index += 1
            MaxDuplicate+=1
            print("Progress: " +orderPage+"/"+orderMax+" ::: "+ str(index) + "/"+str(len(jobs_links))+" ซ้ำ "+ str(MaxDuplicate)+" ครั้ง")
            continue
        #####################
        #####ถ้าผ่านไปนี่แปลว่าไม่มีซ้ำ
        #ชื่ออาชีพ
        job_detail['j_name'] = get_jobName(soup)

        #รายละเอียด
        job_detail['detail'] = get_detail(soup)

        #หาระดับพนักงาน
        job_detail['lv'] = get_lvEmp(soup)

        #การศึกษาขั้นต่ำ
        job_detail['edu'] = get_edu(soup)

        #ประเภทสัญญาจ้าง
        job_detail['type'] = get_type(soup)

        #ประเภทธุรกิจ
        job_detail['indus'] = get_indus(soup)

        job_detail['index']=index
        print("Progress: " +orderPage+"/"+orderMax+" ::: "+ str(index) + "/"+str(len(jobs_links))+" เสร็จแล้ว.")
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
