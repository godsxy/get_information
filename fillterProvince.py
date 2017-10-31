#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
เอาไว้ตรวจสอบจังหวัด
by Sorapunya Insala
"""
import pymysql

def filletP(none):
    c = None
    try:
        db = pymysql.connect(host='localhost', user='root', passwd='123456789', db='job_data',charset='utf8',use_unicode=True)
        #c = db.cursor()
        #c.execute("SELECT VERSION()")
        #data = c.fetchone()
    except :
        print("connect error")
    c = db.cursor()
    c.execute ("select loc from main")
    data = c.fetchall ()
    listCheck=[]
    for row in data:
        # ใช้เพื่อดูว่ามีจังหวัดอะไรบ้าง
        #c.execute ("""select name from list_pro WHERE name = %s""",row[0])
        #row_count = c.rowcount
        #if row_count == 0:
        #    if row[0] not in listCheck:
        #        print(row[0])
        #        listCheck.append(row[0])
        c.execute("""UPDATE list_pro SET have = 1 WHERE name = %s""",row[0])
    db.commit()
filletP(None)
