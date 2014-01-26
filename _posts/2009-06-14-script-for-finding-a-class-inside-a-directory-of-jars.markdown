---
layout: post
status: publish
published: true
title: Script for finding a class inside a directory of JARs
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: In the spirit of automating anything I've done more than twice manually,
  here's an incredibly simple yet useful little script to recursively search a tree
  of JARs for a class file.
wordpress_id: 130
wordpress_url: http://ambientideas.com/blog/index.php/2009/06/script-for-finding-a-class-inside-a-directory-of-jars/
date: 2009-06-14 18:43:02.000000000 -06:00
categories:
- Programming
tags:
- Productivity
- Maven
- Programming
- Scripting
- Automation
comments:
- id: 2267
  author: Josh
  author_email: josh@marotti.com
  author_url: ''
  date: '2009-06-15 10:16:09 -0600'
  date_gmt: '2009-06-15 17:16:09 -0600'
  content: doesn't http://javacio.us/ do this for you?  Finds it in jars and in pom
    files (only for public repositories and jar files, though).
- id: 2270
  author: Matthew McCullough
  author_email: sales@ambientideas.com
  author_url: http://www.ambientideas.com
  date: '2009-06-17 13:15:31 -0600'
  date_gmt: '2009-06-17 20:15:31 -0600'
  content: Yup, javacio.us does something similar. But the reasoning for my script
    is that most of the time in my use-case, I have to search in private (company-internal)
    artifacts as well as commercials ones like BEA/Oracle JARs that would only exist
    in my HDD repo.
---
<p>In the spirit of automating anything I've done more than twice manually, here's an incredibly simple yet useful little script to recursively search a tree of JARs for a class file.  I most often use this against a local Maven repository.</p>

<p>
[bash]
#!/bin/sh
 
#Example Usages:
# findjars com/ambientideas/SuperWidget
# findjars AnotherWidget

CLASSNAMETOFIND=&amp;amp;quot;$1&amp;amp;quot;
 
echo &amp;amp;quot;Searching all JARs recursively...&amp;amp;quot;
for eachjar in `find . -iname &amp;amp;quot;*.jar&amp;amp;quot;`
do
  #echo &amp;amp;quot;Searching in $eachjar ...&amp;amp;quot;
  jar tvf $eachjar | grep $CLASSNAMETOFIND &amp;amp;gt; /dev/null
  if [ $? == 0 ]
  then
    echo &amp;amp;quot;******* Located &amp;amp;quot;$CLASSNAMETOFIND&amp;amp;quot; in $eachjar *******&amp;amp;quot;
  fi
done
[/bash]
</p>
