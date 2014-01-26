---
layout: post
status: publish
published: true
title: JPS and VisualVM on Windows
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: ' At several stops on the  NFJS tour , I''ve been asked about  some of the
  minor issues in running JPS  and VisualVM on the Windows platform.   The primary
  problem is that the processes in JPS and VisualVM are listed as:   &lt;Unknown Application&gt;
  (pid ###)    I have been successful in working around this  by renaming the hsperfdata
  temp directory as noted in a  separate thread on the Sun forums . '
wordpress_id: 158
wordpress_url: http://ambientideas.com/blog/index.php/2009/10/jps-and-visualvm-on-windows/
date: 2009-10-04 00:03:29.000000000 -06:00
categories:
- Programming
tags:
- Java
- Debugging
comments: []
---
<p>At several stops on the <a href="http://nofluffjuststuff.com" target="_blank">NFJS tour</a>, I've been asked about <a href="http://markmail.org/message/bfacrkap4kqjn265" target="_blank">some of the minor issues in running JPS</a> and VisualVM on the Windows platform. The primary problem is that the processes in JPS and VisualVM are listed as:<br /></p>
<p>&lt;Unknown Application&gt; (pid ###)<br /></p>
<p><a href="https://visualvm.dev.java.net/troubleshooting.html" target="_blank">I have been successful in working around this</a> by renaming the hsperfdata temp directory as noted in a <a href="http://forums.sun.com/thread.jspa?threadID=5133218" target="_blank">separate thread on the Sun forums</a>.</p>
