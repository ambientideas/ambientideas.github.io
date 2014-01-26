---
layout: post
status: publish
published: true
title: 'Maven, OSS and iPhone: The Denver NFJS Audience Rocks'
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: '<p>Of all the cities I''ve presented in this year for both NFJS, private
  training, and user groups, two stand out so far as real gems: Minneapolis and Denver.</p>'
wordpress_id: 129
wordpress_url: http://ambientideas.com/blog/index.php/2009/06/maven-oss-and-iphone-the-denver-nfjs-audience-rocks/
date: 2009-06-01 10:45:47.000000000 -06:00
categories:
- Presentations
tags:
- iPhone
- OpenSource
- Presenting
- NFJS
comments: []
---
<p>Of all the cities I've presented in this year for both <a href="http://nofluffjuststuff.com" target="_blank">NFJS</a>, <a href="http://www.ambientideas.com" target="_blank">private training</a>, and <a href="http://www.denveropensource.org" title="Untitled" target="_blank">user groups</a>, two stand out so far as real gems: <a href="http://www.nofluffjuststuff.com/show_view.jsp?showId=184" target="_blank">Minneapolis</a> and <a href="http://www.nofluffjuststuff.com/show_view.jsp?showId=197" target="_blank">Denver</a>. The audiences are highly engaged and ask challenging questions. This is both scary and energizing as a presenter. You are being asked to call on not just your prepared slides, but your experience and catalog of knowledge to come up with a relevant answer. Sometimes, the audience will even help you with the answers, like on the <a href="http://stackoverflow.com/questions/588866/objective-c-properties-atomoic-vs-nonatomic" target="_blank">defaults for Objective-C's @property</a>. It turns out, the answer is: atomic. Thanks <a href="http://twitter.com/johnnywey" target="_blank">Johnny Wey</a>!</p>
<p>Sometimes things just don't go perfectly in the open source world. There are times where it seems like a dot release cures many things, but then breaks/regresses several important ones as well. Like the <a href="http://github.com/matthewmccullough/iphoneandjavawebservices/tree/master" target="_blank">XML parsing in the iPhone demo</a>. Turns out, it was a Grails 1.1 issue (which I upgraded to from 1.0.3 to solve another bug) in which optional URL parameters are wrongly required. <a href="http://jira.codehaus.org/browse/GRAILS?report=com.atlassian.jira.plugin.system.project:changelog-panel" target="_blank">Grails 1.1.1</a> fixes it, which I validated at 11pm last night, but it would have been fun to live fix this with the audience. This reinforces the point in my talk though that you should always check your web services, possibly using <a href="http://curl.haxx.se/" target="_blank">curl</a>, or <a href="http://www.soapui.org/" target="_blank">SOAPui</a> prior to connecting your iPhone application to them.</p>
<p>It's amazing to see how many of the <a href="http://tech.puredanger.com/2009/04/26/nfjs-twitter/" target="_blank">presenters</a> and <a href="http://hashtags.org/search?q=nfjs&amp;page=1" target="_blank">audience members</a> are on <a href="http://www.twitter.com" target="_blank">Twitter</a> and posting their experiences about <a href="http://twitter.com/nofluff" target="_blank">the conference</a>. That's a real change from last year, where hardly anyone was live posting in that fashion. I hope to see you all again in the Fall at the next <a href="http://www.nofluffjuststuff.com/show_view.jsp?showId=208" target="_blank">Denver NFJS</a>, loaded with more difficult questions and an inquiring state of mind.<br /></p>
