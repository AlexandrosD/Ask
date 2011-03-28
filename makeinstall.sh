#!/bin/bash
#usage makeinstall.sh
TMPDIR="TMP"
PACKAGEDIR="."
OUTPUT="com_ask.zip"
DATE=`date`
mv $PACKAGEDIR/$OUTPUT $PACKAGEDIR/$OUTPUT.old.$DATE
mkdir $TMPDIR
mkdir $TMPDIR/site/
mkdir $TMPDIR/admin/
cp -r frontend/* $TMPDIR/site
cp -r backend/* $TMPDIR/admin
cp ask.xml $TMPDIR/
cp script.php $TMPDIR/
cp README $TMPDIR/
cd $TMPDIR/
zip -r $OUTPUT *
cd ../
mv $TMPDIR/ask.zip $PACKAGEDIR
rm -r $TMPDIR/