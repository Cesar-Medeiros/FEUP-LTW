#!/bin/bash
cd database
rm database.db 
cat database.sql |  sqlite3 -batch database.db
cd ..