#!/bin/sh

# Generate POT File (Template).
FILES=`find .. -name *.php`

xgettext -c --from-code=utf-8 --keyword=_e --keyword=__ --default-domain=vistered-little --output=- \
	--msgid-bugs-address=tom@windyroad.org $FILES \
| sed -e 's/# SOME DESCRIPTIVE TITLE/# PO Template/' \
	  -e 's/# Copyright .*C.* YEAR THE PACKAGE.*S COPYRIGHT HOLDER/# Copyright \(C\) 2007 windyroad.org/' \
	  -e 's/PACKAGE/Vistered Little/' \
	  -e 's/# FIRST AUTHOR <EMAIL@ADDRESS>, YEAR./# Tom Howard <tom@windyroad.org>, 2007./' \
	  -e 's/VERSION/1.7.5/' \
	  -e 's/CHARSET/utf-8/' \
	  > vistered-little.pot
