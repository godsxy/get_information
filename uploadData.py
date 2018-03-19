#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
ีuploadData.py เอาไว้ใช้อัพโหลดข้อมูลขึ้น database
Ver 1.0
by Sorapunya Insala
"""
import pymysql
from project_end import conDB

def uploadToSql(jobs_detail):
    db=conDB.conDB()
    c = db.cursor()
    for i in jobs_detail:
        try:
            c.execute("SET NAMES utf8mb4;")
            sql = """INSERT INTO main (`j_name`, `cop_name`, `loc`, `detail`, `level`, `edu`, `type`, `jfunc`, `indus`, `time`) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
            #เช็คข้อมูลซ้ำ
            CKsql = """SELECT EXISTS(SELECT * FROM main WHERE `j_name`=%s AND `cop_name`=%s AND `loc`=%s AND`time`=%s)"""
            CKExis = c.execute(CKsql,(i["""j_name"""],i["""cop_name"""],i["""loc"""],i["""time"""],))
            if CKExis == 0:
                c.execute(sql, (i["""j_name"""],i["""cop_name"""],i["""loc"""],i["""detail"""],i["""lv"""],i["""edu"""],i["""type"""],i["""jfunc"""],i["""indus"""],i["""time"""],))
                db.commit()
            else:
                print("Duplicate Data in List..")

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
