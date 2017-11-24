#! /usr/bin/env python3.5
# -*- coding: utf-8 -*-

import pymysql
import warnings

def filletJobFunc():
    #ปิดเเพื่อให้แสดงคำเตือน
    warnings.filterwarnings("ignore")
    c = None
    try:
        db = pymysql.connect(host='localhost', user='root', passwd='123456789', db='job_data',charset='utf8',use_unicode=True)
    except :
        print("connect error")
    c = db.cursor()
    c.execute ("SELECT DISTINCT(jfunc) FROM main")
    data = c.fetchall()
    for row in data:
        c.execute("INSERT IGNORE INTO `job_func`(`name`) VALUES (%s)",(row))
    db.commit()
filletJobFunc()
