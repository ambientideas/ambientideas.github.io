---
layout: post
status: publish
published: true
title: Maven Unit Tests and Continuous Integration Servers
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: ' If you are running a Continuous Integration server such as  Hudson , you''ll
  want to consider routing your  SureFire  outputs to the console so that they''ll
  appear in the build-report logs.   If you leave SureFire at its  default , it will
  output each test''s success or failure  to an individual test XML and TXT file ,
  but those are likely not in an exposed directory on your CI server.   If instead,
  you  route the output to the console , it will get reported in your failure emails
  that your CI server is capable of sending. '
wordpress_id: 121
wordpress_url: http://ambientideas.com/blog/index.php/2009/03/maven-unit-tests-and-continuous-integration-servers/
date: 2009-03-11 12:50:20.000000000 -06:00
categories:
- Programming
- Maven
tags:
- Java
- Maven
- ContinuousIntegration
comments:
- id: 1045
  author: Andreas Ebbert-Karroum
  author_email: andreas@karroum.de
  author_url: http://blogs.karroum.de/andreas
  date: '2009-03-11 14:32:11 -0600'
  date_gmt: '2009-03-11 21:32:11 -0600'
  content: "Hi,\r\n\r\nhow do the hudson plugins react to that? I could imagine they
    look for the xml files in order to show the test trend.\r\n\r\nAndreas"
---
<p>If you are running a Continuous Integration server such as <a href="https://hudson.dev.java.net/" target="_blank">Hudson</a>, you'll want to consider routing your <a href="http://maven.apache.org/plugins/maven-surefire-plugin/" target="_blank">SureFire</a> outputs to the console so that they'll appear in the build-report logs. If you leave SureFire at its <strong>default</strong>, it will output each test's success or failure <strong>to an individual test XML and TXT file</strong>, but those are likely not in an exposed directory on your CI server. If instead, you <a href="http://maven.apache.org/plugins/maven-surefire-plugin/test-mojo.html#useFile" target="_blank">route the output to the console</a>, it will get reported in your failure emails that your CI server is capable of sending.</p>Just <a href="http://maven.apache.org/plugins/maven-surefire-plugin/test-mojo.html#useFile" target="_blank">pass the useFile=false parameter</a> on the command line or set it in the plugin config section of your pom.xml.
<pre>
<code>mvn test -Dsurefire.useFile=false</code>
</pre><br />
<p>Before:</p>
<pre>
<code><span style="color: #6C1506;">-------------------------------------------------------
T E S T S
-------------------------------------------------------
Running com.ambientideas.AppTest
Hello World! This is a JUnit test!
Tests run: 1, Failures: 1, Errors: 0, Skipped: 0, Time elapsed: 0.045 sec &lt;&lt;&lt; FAILURE!<br />Results :<br />Failed tests:<br />testApp(com.ambientideas.AppTest)<br />Tests run: 1, Failures: 1, Errors: 0, Skipped: 0</span></code>
</pre>
<p>After:</p>
<pre>
<code><span style="color: #3C7D00;">-------------------------------------------------------
T E S T S
-------------------------------------------------------
Running com.ambientideas.AppTest
Hello World! This is a JUnit test!
Tests run: 1, Failures: 1, Errors: 0, Skipped: 0, Time elapsed: 0.045 sec &lt;&lt;&lt; FAILURE!
testApp(com.ambientideas.AppTest)  Time elapsed: 0.014 sec  &lt;&lt;&lt; FAILURE!
<span style="color: #0B0581;">junit.framework.AssertionFailedError
at junit.framework.Assert.fail(Assert.java:47)
at junit.framework.Assert.assertTrue(Assert.java:20)
at junit.framework.Assert.assertTrue(Assert.java:27)
at com.ambientideas.AppTest.testApp(AppTest.java:37)</span><br /><br />Results :<br />Failed tests:<br />testApp(com.ambientideas.AppTest)<br />Tests run: 1, Failures: 1, Errors: 0, Skipped: 0<br /></span></code>
</pre>
