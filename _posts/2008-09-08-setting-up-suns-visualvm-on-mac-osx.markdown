---
layout: post
status: publish
published: true
title: Setting up Sun's VisualVM on Mac OSX
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
wordpress_id: 31
wordpress_url: http://ambientideas.com/blog/index.php/2008/09/setting-up-suns-visualvm-on-mac-osx/
date: 2008-09-08 21:55:00.000000000 -06:00
categories:
- Programming
tags:
- MacOS
- Java
comments: []
---
<p>There is a relatively new tool out from Sun call the <a href="https://visualvm.dev.java.net" target="_blank">VisualVM</a>. It is, in short a super new version of <a href="http://java.sun.com/developer/technicalArticles/J2SE/jconsole.html" target="_blank">JConsole</a>. In fact, it even runs all the extensions you have previously written for JConsole. Nice job Sun! You can profile, <a href="https://visualvm.dev.java.net/features.html" target="_blank">take snapshots, and watch in real time, threads, memory usage</a>, and so much more of any local or remote java application.</p>
<p>Now, it takes a little bit of a trick to get it to work on Mac OSX. You need the <a href="http://developer.apple.com/java/download/" target="_blank">latest Java 6 JDK installed,</a> though it can monitor apps running on JRE 1.4 through JRE 7.0. But if you don't set it as your default JDK, which can cause many apps such as <a href="http://www.eclipse.org" target="_blank">Eclipse</a> and <a href="http://cyberduck.ch/" target="_blank">CyberDuck</a> to stop working, then you'll need to use the --jdkhome option when launching visualvm. I set up a shell script to do so. The full invocation is as follows:</p>
<p><code>visualvm --jdkhome /System/Library/Frameworks/JavaVM.framework/Versions/1.6.0/Home/</code></p>
<p>There is even a <a href="https://visualvm.dev.java.net/gettingstarted.html" target="_blank">getting started guide</a> that shows you the basic features. And if video is more your style, there's a <a href="http://java.sun.com/javaone/sf/media_shell.jsp?id=FRdamp267672" target="_blank">vodcast that shows off this new app</a> as well. If you still can't get enough of this new tool, there's a neat <a href="http://java.dzone.com/news/visual-vm-free-and-open-source" target="_blank">DZone overview written by Geertjan Wielenga</a>.</p>
