---
layout: post
status: publish
published: true
title: RESTful Java Web Services must not return void to iPhone HTTP Services
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: ' After many sessions of debugging and even memory inspection not yielding
  fruit, I''ve finally discovered what caused my previous RESTful demo apps to have
  sporadic behavior, in addition to th e memory leak of the synchronous call .    Today''s
  problem solving summary:   XCode projects  cannot have commas anywhere in the path  up
  to the location where they are stored or else you''ll get an error message of:  ld:
  -filelist file not found: &lt;Project Path&gt;     All RESTful web services called
  via the  NSURLConnection APIs  must return a non-null payload.  ...  The observable
  failure is very quiet, which made it so hard to debug; every other web service call
  appears valid, but never actually makes a call across the wire. '
wordpress_id: 110
wordpress_url: http://ambientideas.com/blog/index.php/2009/02/restful-java-web-services-must-not-return-void-to-iphone-http-services/
date: 2009-02-17 00:57:13.000000000 -07:00
categories:
- Programming
tags:
- iPhone
- OpenSource
- Java
- XCode
comments: []
---
<p>After many sessions of debugging and even memory inspection not yielding fruit, I've finally discovered what caused my previous RESTful demo apps to have sporadic behavior, in addition to th<a href="http://ambientideas.com/blog/index.php/2009/02/iphone-sdk-memory-leak-acknowledged/" target="_blank">e memory leak of the synchronous call</a>.</p>
<p>Today's problem solving summary:</p>
<ol>
  <li>XCode projects <a href="http://www.idevgames.com/forum/showthread.php?t=16284" target="_blank">cannot have commas anywhere in the path</a> up to the location where they are stored or else you'll get an error message of:<br />
  <code>ld: -filelist file not found: &lt;Project Path&gt;<br /></code><br /></li>

  <li>All RESTful web services called via the <a href="http://developer.apple.com/documentation/Cocoa/Conceptual/URLLoadingSystem/Tasks/UsingNSURLConnection.html" target="_blank">NSURLConnection APIs</a> must return a non-null payload.<br />
  <br />
  This bit me because <a href="http://github.com/matthewmccullough/iphoneandjavawebservices/blob/bb04e911cd6c7c247a92fea7e133589a3b53deba/JavaEndpoint-WSRESTful/src/com/ambientideas/iphone/ContestantDrawing.java" target="_blank">my "Add Contestant" function was adding the contestant and returning void</a>. I now return a string of "Success" to satisfy this requirement. The observable failure is very quiet, which made it so hard to debug; every other web service call appears valid, but never actually makes a call across the wire. This was <a href="http://en.wikipedia.org/wiki/Tcpdump" target="_blank">proven via TCPDump</a>. All the web service call callbacks are properly called in the Objective C side of the program. It just silently failed and passed back a null payload in the response data structure.</li>
</ol>
<p>All the c<a href="http://github.com/matthewmccullough/iphoneandjavawebservices/" target="_blank">ode for this project is available on GitHub</a> and will be updated with the results of the adjustments based on the above findings by tomorrow.</p>
