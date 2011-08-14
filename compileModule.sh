#!/bin/bash
#usage compileModule MODULE VERSION
TMPDIR="TMP"
PACKAGEDIR="./packages"
OUTPUT=$1.$2.zip
DATE=`date`
mv $PACKAGEDIR/$OUTPUT $PACKAGEDIR/$OUTPUT.old.$DATE
mkdir $TMPDIR
cp -r modules/$1/* $TMPDIR
cd $TMPDIR/
zip -r $OUTPUT *
cd ../
mv $TMPDIR/$OUTPUT $PACKAGEDIR
rm -r $TMPDIR/
