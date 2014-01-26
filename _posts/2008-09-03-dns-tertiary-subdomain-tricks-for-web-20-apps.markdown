---
layout: post
status: publish
published: true
title: DNS, Tertiary SubDomain Tricks for Web 2.0 Apps
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
wordpress_id: 32
wordpress_url: http://ambientideas.com/blog/index.php/2008/09/dns-tertiary-subdomain-tricks-for-web-20-apps/
date: 2008-09-03 22:03:00.000000000 -06:00
categories:
- Programming
tags:
- Productivity
- WebBrowser
comments: []
---
<p>Never really thought about this approach before, but if your DNS * record for your domain maps to your web server, you can use just a servlet filter or whatever other technology you want to use to capture custom tertiary level subdomains URLs and redirect to a user-specific page.</p>
<p>For example, if you want http://matthew.ambientideas.com to take your users to a user-profile page, there's no need to wire in your DNS to your software app, constantly updating it per user. You just capture the URL, parse out the tertiary domain part, and redirect, say, to http://ambientideas.com/users/?user=matthew. Easy, straightforward and cool. Kudos to <a href="http://ambientideas.com/advertising/index.html" target="_blank">Jordan</a> for the first implementation for an <a href="http://www.realated.com" target="_blank">upcoming app</a> from Ambient Ideas.</p>
