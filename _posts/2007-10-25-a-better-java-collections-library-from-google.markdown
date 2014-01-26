---
layout: post
status: publish
published: true
title: A Better Java Collections Library from Google
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
wordpress_id: 62
wordpress_url: http://ambientideas.com/blog/index.php/2007/10/a-better-java-collections-library-from-google/
date: 2007-10-25 07:29:00.000000000 -06:00
categories:
- Programming
tags: []
comments: []
---
<p>I'm working on a project that is going to need extreme performance capabilities, as well as some unique libraries. Of course, any good Open Source practitioner should do some searching and check their <a href="http://del.icio.us/network/programr" target="_blank">deli.cio.us network's bookmarks</a> before writing their own library. I stumbled across the <a href="http://code.google.com/p/google-collections/" target="_blank">Google Collections library</a> and an <a href="http://www.javalobby.org/articles/google-collections/" target="_blank">article that interviews the authors</a>. This exactly fits the bill. The Google Collections library offers such nice-to-haves as Multimap with a sensible interface (e.g. calling multimap.put(bar, baz) rather than building up a list first). Here's <a href="http://publicobject.com/2007/09/series-recap-coding-in-small-with.html" target="_blank">some code from another related Google Collections series of articles</a> to show the before-and-after benefits:</p><br /><p><strong>Before:</strong></p><br /><p><code>Map&lt;Salesperson, List&lt;Sale&gt;&gt; map = new Hashmap&lt;SalesPerson, List&lt;Sale&gt;&gt;();<br /><br /><br /><br />public void makeSale(Salesperson salesPerson, Sale sale) {<br /><br />List&lt;Sale&gt; sales = map.get(salesPerson);<br /><br />if (sales == null) {<br /><br />sales = new ArrayList&lt;Sale&gt;();<br /><br />map.put(salesPerson, sales);<br /><br />}<br /><br />sales.add(sale);<br /><br />}</code></p><br /><p><strong>After:</strong></p><br /><p><code>Multimap&lt;Salesperson, Sale&gt; multimap = new ArrayListMultimap&lt;Salesperson,Sale&gt;();<br /><br /><br /><br />public void makeSale(Salesperson salesPerson, Sale sale) {<br /><br />multimap.put(salesperson, sale);<br /><br />}</code></p><br /><br />
