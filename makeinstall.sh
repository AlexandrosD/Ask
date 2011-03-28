#!/bin/bash
#usage makeinstall.sh VERSION
TMPDIR="TMP"
PACKAGEDIR="./packages"
OUTPUT=com_ask.$1.zip
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
mv $TMPDIR/$OUTPUT $PACKAGEDIR
rm -r $TMPDIR/