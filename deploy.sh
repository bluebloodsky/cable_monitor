#!/bin/sh
cd frontend
npm run build
cd ..
rm backend/static -rf
mv frontend/dist/* backend/

tar zvf dist.tar.gz -c backend 
