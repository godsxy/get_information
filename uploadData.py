#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
ีuploadData.py เอาไว้ใช้อัพโหลดข้อมูลขึ้น database
Ver 1.0
by Sorapunya Insala
"""
import pymysql

def uploadToSql(jobs_detail):
    c = None
    try:
        db = pymysql.connect(host='localhost', user='root', passwd='123456789', db='job_data',charset='utf8',use_unicode=True)
        c = db.cursor()
        #c.execute("SELECT VERSION()")
        #data = c.fetchone()
    except :
        print("connect error")
    for i in jobs_detail:
        try:
            c.execute("SET NAMES utf8mb4;")
            c.execute("""INSERT INTO main (`j_name`, `cop_name`, `loc`, `detail`, `level`, `edu`, `type`, `jfunc`, `indus`, `time`) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)""", (i["""j_name"""],i["""cop_name"""],i["""loc"""],i["""detail"""],i["""lv"""],i["""edu"""],i["""type"""],i["""jfunc"""],i["""indus"""],i["""time"""],))
            db.commit()
        except Exception as e:
            print("ลำดับข้อมูลอันที่ "+str(i['index'])+"มีปัญหา")
            db.rollback()
            print(e)
        if i['index']%50==0:
            print("อัพข้อมูลลำดับที่ " + str(i['index']))
    if c:
        c.close()
    print("------------------")
    print("------------------")
    print("------------------")
