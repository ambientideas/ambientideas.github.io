---
layout: post
status: publish
published: true
title: iPhone SDK, Cocoa & RESTful Web Services, Memory Leak
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
wordpress_id: 3
wordpress_url: http://67.199.122.150/blog/index.php/2009/01/iphone-sdk-cocoa-restful-web-services-memory-leak/
date: 2009-01-16 15:34:00.000000000 -07:00
categories:
- Programming
tags:
- iPhone
- MacOS
comments: []
---
<p>Recently, I gave the second version of my iPhone and Java Web Services talk at the <a href="http://www.boulderjug.org" target="_blank">Boulder JUG</a>. It was a great audience filled with interest and great questions. I promised them I would continue to load up <a href="http://delicious.com/matthew.mccullough/iphone" target="_blank">my Delicious bookmarks with great iPhone links</a>, and I'm doing just that.</p>
<p>Pertinent to that talk, let's quickly revisit that memory leak issue for NSURLConnection. In short, if you call sendSynchronousRequest, you get an internal memory leak of 128 bytes of a NSCFString object from inside the API.</p>
<p>To isolate this from my application coding skills via <a href="http://github.com/matthewmccullough/iphoneandjavawebservices/" target="_blank">the iPhone and Java Web Services demo code</a>, let's look at an example called <a href="http://appsamuck.com/day15.html" target="_blank">ZipWeather from AppsAmuck</a>. Attach the profile to the ZipWeather, exactly as downloaded. Run it. Type a zip code. It leaks.</p>
<p>It appears that the <a href="http://raoli.com/2004/03/11/nsurlconnection-and-amazon-web-services/" target="_blank">NSURLConnection:sendSynchronousRequest() Flaking out, even for others, calling this API</a> to Amazon Web Services. I believe it may <a href="http://lists.apple.com/archives/Macnetworkprog/2008/Nov/msg00002.html" target="_blank">be the leak contributing to these hiccups</a>. I've <a href="http://lists.apple.com/archives/Macnetworkprog/2008/Nov/msg00013.html" target="_blank">tried turning off the cache, but it still leaks. I've tried the async version and it still leaks too</a>.</p>
<p>This <a href="http://developer.apple.com/webapps/articles/creatingrestfulclients.html" target="_blank">Apple article even suggests using this same API in the same way</a> that ZipWeather and my iPhone and Java Web Services app does.</p>
<p>In short, I'm submitting another <a href="https://bugreport.apple.com/cgi-bin/WebObjects/RadarWeb.woa/wa/signIn" target="_blank">Radar report to Apple</a> about this and hope it doesn't get closed out as "Unable to reproduce" as <a href="http://lists.apple.com/archives/Macnetworkprog/2008/Nov/msg00006.html" target="_blank">João Pavão's defect # 6179277</a> did. I'm able to reproduce it every time, with everyone's sendSynchronousRequest calls.</p>
<p>I love the platform, but as you all know, one core API bug can really cause a lot of challenges until resolved. Let's hope this one gets resolved very soon!</p>
<p>References:</p>
<ol>
  <li><a href="http://www.iphonedevsdk.com/forum/iphone-sdk-development/2841-resolved-how-call-soap-service-3.html" target="_blank">SOAP Service Calls on the iPhone</a></li>

  <li><a href="http://stackoverflow.com/questions/393803/accessing-a-webserver-from-a-cocoa-application" target="_blank">Stack Overflow thread on Cocoa Web Service Access</a></li>

  <li><a href="http://developer.apple.com/iphone/" target="_blank">Apple iPhone Dev Center</a></li>

  <li><a href="http://kosmaczewski.net/2008/03/26/playing-with-http-libraries/" target="_blank">A Blog about 5 languages calling web services, including Objective-C</a></li>

  <li><a href="http://kosmaczewski.net/2008/10/18/rest-and-objective-c-again/" target="_blank">A continuation blog post specifically on Objective-C and REST</a></li>

  <li><a href="http://kosmaczewski.net/projects/objective-c-rest-client/" target="_blank">And a download of a sample client in Objective-C that calls REST methods</a></li>

  <li>UPDATE: <a href="http://www.iphonedevsdk.com/forum/iphone-sdk-development/3174-memory-leak.html#post41589" target="_blank">SeismicXML leak discussion</a></li>

  <li>UPDATE: <a href="http://forums.macrumors.com/showthread.php?t=576680" target="_blank">MacRumors sendSynchronousRequest leak discussion</a></li>

  <li>UPDATE: <a href="http://www.iphonedevsdk.com/forum/iphone-sdk-development/4910-nsxmlparser-rssparser-causing-memory-leak.html#post39064" target="_blank">NSXMLParser leaks too</a></li>
</ol>
<p><br />
<img src="http://farm4.static.flickr.com/3298/3201729569_ea16f4718d_o.jpg" width="794" height="578" alt="200901161532.jpg" /></p>
