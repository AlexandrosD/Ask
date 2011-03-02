#!/bin/bash
TMPDIR="TMP"
PACKAGEDIR=".."
rm $PACKAGEDIR/ask.zip
mkdir $TMPDIR
mkdir $TMPDIR/site/
mkdir $TMPDIR/admin/
cp -r frontend/* $TMPDIR/site
cp -r backend/* $TMPDIR/admin
cp ask.xml $TMPDIR/
cp script.php $TMPDIR/
cp README $TMPDIR/
cd $TMPDIR/
zip -r ask.zip *
cd ../
mv $TMPDIR/ask.zip $PACKAGEDIR
rm -r $TMPDIR/
