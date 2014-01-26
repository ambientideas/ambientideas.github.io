---
layout: post
status: publish
published: true
title: How To Remove Stuck Sidebar Items in MacOS
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
wordpress_id: 48
wordpress_url: http://ambientideas.com/blog/index.php/2008/02/how-to-remove-stuck-sidebar-items-in-macos/
date: 2008-02-10 11:59:00.000000000 -07:00
categories:
- Programming
tags:
- MacOS
- Java
comments: []
---
<p>Well, here's one of those things that isn't Mac-easy on Mac OS. Say you create a sidebar link to a server. Say you no longer have access to that server. Whoa. Can't click on it and remove it. Just keeps popping up an error message. Well, it turns out you have to <a href="http://sonicchicken.net/blog/wordpress/20070328/mac-osx-finder-the-volume-cannot-be-found/" target="_blank">follow these instructions</a> and edit the <span style="font-style: italic;">~/Library/Preferences/com.apple.sidebarlists.plist</span> file to purge the offending link. Come on! You have to be kidding Steve, right?</p><br /><br />
