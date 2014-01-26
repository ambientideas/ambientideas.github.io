---
layout: post
status: publish
published: true
title: iPhone SDK Memory Leak Acknowledged
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
wordpress_id: 104
wordpress_url: http://ambientideas.com/blog/index.php/2009/02/iphone-sdk-memory-leak-acknowledged/
date: 2009-02-05 10:18:21.000000000 -07:00
categories:
- Programming
tags:
- iPhone
- Bug
- Cocoa
comments:
- id: 11
  author: RESTful Java Web Services must not return void to iPhone HTTP Services &laquo;
    Ambient Ideas&#8217; Denver Dev
  author_email: ''
  author_url: http://ambientideas.com/blog/index.php/2009/02/restful-java-web-services-must-not-return-void-to-iphone-http-services/
  date: '2009-02-17 08:39:08 -0700'
  date_gmt: '2009-02-17 15:39:08 -0700'
  content: '[...] After many sessions of debugging and even memory inspection not
    yielding fruit, I&#8217;ve finally discovered what caused my previous RESTful
    demo apps to have sporadic behavior, in addition to the memory leak of the synchronous
    call. [...]'
---
<p>I was pleased to see an email sitting in my inbox this morning from Apple <a href="http://ambientideas.com/blog/index.php/2009/01/iphone-sdk-cocoa-restful-web-services-memory-leak/" target="_blank">replying to the memory leak of the iPhone SDK around the sendSynchronousRequest call</a>. However, the body was a bit disappointing. Paraphrased:</p>
<blockquote>
  <p>Hello Matthew,<br />
  <br />
  This is a follow up to Bug ID# 6503844. After further investigation it has been determined that this is a known issue, which is currently being investigated by engineering. This issue has been filed in our bug database under the original Bug ID# 6548496.<br />
  <br />
  Thank you for submitting this bug report. We truly appreciate your assistance in helping us discover and isolate bugs.</p>
</blockquote>
<p>The part that is odd is that the "Original Bug ID" is a larger number than mine. I was pretty sure that the <a href="http://radar.apple.com" target="_blank">bug IDs were sequential</a>. Perhaps not.</p>
<p>This particular call appears to have been leaking since I first jumped on board iPhone SDK development over a year ago. Let's hope it becomes a priority in a soon-upcoming release of the software and SDK.</p>
<p>Still, on the whole, development on the iPhone is awesome, and if you are in <a href="http://www.nofluffjuststuff.com/conference/speaker/matthew_mccullough.html" target="_blank">Minneapolis, Seattle, or Denver, I'd be pleased to have you in the audience at the NFJS talks.</a></p>
