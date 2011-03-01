#!/bin/bash
PACKAGEDIR="Packages"
mkdir $PACKAGEDIR
mkdir $PACKAGEDIR/site/
mkdir $PACKAGEDIR/admin/
cp -r frontend/* $PACKAGEDIR/site
cp -r backend/* $PACKAGEDIR/admin
cp ask.xml $PACKAGEDIR/
cp script.php $PACKAGEDIR/
cp README $PACKAGEDIR/
cd $PACKAGEDIR/
zip -r ask.zip *
mv ask.zip ../../
cd ../
rm -r $PACKAGEDIR/
