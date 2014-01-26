---
layout: post
status: publish
published: true
title: IPC and Talend at the DOSUG March Meeting
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: |
  <p>When to use different IPC options The example applications The CLIP library Shared Memory Semaphores Shared Queues Resources Where to get the slides Other useful sites, etc. Clark did a great job on his slides with funny anecdotes, images for analogies, and clear verbal examples of IPC types (props to World of Warcraft). ... This French startup company is attempting to create a new price point for ETL tools with the now-common OSS business model, selling support and training while giving away the core product for free.</p>
wordpress_id: 117
wordpress_url: http://ambientideas.com/blog/index.php/2009/03/ipc-and-talend-at-the-dosug-march-meeting/
date: 2009-03-03 19:50:05.000000000 -07:00
categories:
- Programming
tags:
- Presenting
- Java
- DOSUG
- Programming
- Database
- IPC
comments: []
---
<p>Tonight was the <a href="http://denveropensource.org" target="_blank">Denver Open Source User's Group</a> March meeting.</p>
<h2>CLIP IPC Library</h2>
<p>First up was <a href="http://ltsllc.com" target="_blank">Clark Hobbie</a> on the <a href="http://ltsllc.com/slides/ipc.html" target="_blank">CLIP IPC Library</a>.</p>
<p>First, Clark addressed the question,"<a href="http://en.wikipedia.org/wiki/Inter-process_communication" target="_blank">Why do we need an IPC library</a>?" . He purports you need IPC "anytime you access something outside your JVM and need to share it in a controlled and coordinated manner with another client". Clark says that CLIP was created as an answer to the cryptic and verbose shared memory classes in the JDK.</p>
<p>A brief outline of what he <a href="http://www.slideshare.net/ltsllc/java-ipc-and-the-clip-library" target="_blank">covered in his slides</a> is as follows:</p>
<ul>
  <li>What is useful about IPC?</li>

  <li>When to use different IPC options</li>

  <li>The example applications</li>

  <li>The CLIP library</li>

  <li>Shared Memory</li>

  <li>Semaphores</li>

  <li>Shared Queues</li>

  <li>Resources</li>

  <li>Where to get the slides</li>

  <li>Other useful sites, etc.</li>
</ul>
<p>Clark did a great job on his slides with funny anecdotes, images for analogies, and clear verbal examples of IPC types (props to World of Warcraft).</p>
<p><span style="font-size: 18px; font-weight: bold;">Talend ETL Tool</span><br /></p>
<p>Second up was <a href="http://www.augusttechgroup.com/tim/blog/" target="_blank">Tim Berglund</a> speaking on the open source <a href="http://www.talend.com/index.php" target="_blank">Talend</a> Open Studio ETL (<a href="http://en.wikipedia.org/wiki/Extract,_transform,_load" target="_blank">Extract Transform and Load</a>) system. This French startup company is attempting to create a new price point for ETL tools with the now-common OSS business model, selling support and training while giving away the core product for free.</p><img src="http://farm4.static.flickr.com/3364/3327570928_094ffae350.jpg?v=0" />
<p>He neatly said this is a talk for non-DBAs but rather developers that need to work with databases. Tim admitted that there are a few negatives to the <a href="http://en.wikipedia.org/wiki/Talend_Open_Studio" target="_blank">otherwise great Talend tool</a>. Those are: the JAR is 70MB, the error messages have a French accent, and Mac Eclipse support is a work in progress.</p>
<p>The <a href="http://www.talend.com/img/Talend-Open-Studio-v1/thumb/tmap.gif" target="_blank">visual designer has a lot of off-the-shelf transforms</a>. We also saw XML, Excel files, 10+ DB brands, and CSVs as just some of the data sources.</p>
<p>It was a fun set of slides that were in the <a href="http://www.amazon.com/exec/obidos/ASIN/0596522347/bookstorenow99-20" target="_blank">vein of Slideology</a>.</p><img src="http://www.talend.com/img/Talend-Open-Studio-v1/tmap.gif" width="480" height="363" alt="tmap.gif" />
