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
        c.execute("SELECT VERSION()")
        data = c.fetchone()
        #print("db version: ", data)
    except :
        print("connect error")

    for i in jobs_detail:
        #sql='INSERT INTO main ( `j_name`, `cop_name`, `type`, `edu`, `loc`, `time`, `ben`, `jfunc`, `indus`) VALUES ("%s","%s","%s","%s","%s","%s","%s","%s","%s")'% (i["j_name"],i["cop_name"],i["type"],i["edu"],i["loc"],i["time"],i["ben"],i["jfunc"],i["indus"])
        try:
            c.execute("SET NAMES utf8mb4;")
            c.execute("""INSERT INTO main ( `j_name`, `cop_name`, `type`, `edu`, `loc`, `time`, `ben`, `jfunc`, `indus`) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)""", (i["""j_name"""],i["""cop_name"""],i["""type"""],i["""edu"""],i["""loc"""],i["""time"""],i["""ben"""],i["""jfunc"""],i["""indus"""],))
            db.commit()
        except Exception as e:
            print(i['index'])
            db.rollback()
            print(e)
        if i['index']%50==0:
            print(i['index'])
    if c:
        c.close()
