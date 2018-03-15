#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-
ThisFileDetail="""
conDB.py เอาไว้ใช้เชื่อมต่อ database
Ver 1.0
by Sorapunya Insala
"""
import pymysql

def conDB():
    try:
        db = pymysql.connect(host='localhost', user='root', passwd='123456789', db='job_data',charset='utf8',use_unicode=True)
        return db
        #c = db.cursor()
        #c.execute("SELECT VERSION()")
        #data = c.fetchone()
    except :
        print("connect error")
