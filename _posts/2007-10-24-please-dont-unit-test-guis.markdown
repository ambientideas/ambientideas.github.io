---
layout: post
status: publish
published: true
title: Please, Don't Unit Test GUIs
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
wordpress_id: 64
wordpress_url: http://ambientideas.com/blog/index.php/2007/10/please-dont-unit-test-guis/
date: 2007-10-24 09:01:00.000000000 -06:00
categories:
- Programming
tags: []
comments: []
---
<p>I'm on the side of thinking that believes companies spend way too much money unit testing GUIs when their business logic (their real value, most of the time) hasn't even got great JUnit coverage. I'm not completely against testing GUIs, but let's get our priorities straight -- make sure the business logic is tested first, then we'll talk about the UI. This developer <a href="http://www.regdeveloper.co.uk/2007/10/22/gui_unit_testing/" target="_blank">has an article that shares some of the same sentiments</a> and even mentions how <a href="http://www.theserverside.com/news/thread.tss?thread_id=25355" target="_blank">Martin Fowler has frequent "Don'ts" but then leaves it to the user to track them down</a>.</p><br /><br />
