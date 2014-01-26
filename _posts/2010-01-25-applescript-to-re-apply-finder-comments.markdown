---
layout: post
status: publish
published: true
title: AppleScript to Re-Apply Finder Comments
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: '...depending on the Mac-specific intelligence of your backup solution, or
  when copying files written by a 10.4 Mac, your Spotlight (Finder) Comments stored
  in the .DS_Store files might not survive the round trip.'
wordpress_id: 209
wordpress_url: http://ambientideas.com/blog/index.php/2010/01/applescript-to-re-apply-finder-comments/
date: 2010-01-25 09:55:29.000000000 -07:00
categories:
- Programming
tags:
- MacOS
- OpenSource
- Programming
- Scripting
- Debugging
comments: []
---
<h1>Finder Comments Lost</h1>
<p>When restoring from a backup, depending on the Mac-specific intelligence of your backup solution, or when copying files written by a 10.4 Mac, your Spotlight (Finder) Comments stored in the <a href="http://en.wikipedia.org/wiki/.DS_Store">.DS_Store files</a> might not survive the round trip.  You'll first notice this by the fact that your comments field or column is completely empty for files you know you previously tagged or made comments on.</p>

<h2>Leopard, Snow Leopard Comment Storage</h2>
<p>Tiger and previous editions of Mac OSX store Spotlight comments in the .DS_Store file exclusively.  Leopard and Snow Leopard on the other hand, claim to maintain backwards compatibility by storing the <a href="http://ironicsoftware.com/community/comments.php?DiscussionID=344">Spotlight Comments in both</a> the .DS_Store and the new <a href="http://en.wikipedia.org/wiki/Extended_file_attributes">Extended File Attributes.</a>  I question this thinking though, because Mac OSX developer Steve Gehrman of the <a href="http://www.cocoatech.com/">awesome PathFinder team</a> says that Finder, while it <a href="http://news.softpedia.com/news/iRemove-DS-Store-Files-AppleScript-Eliminates-Tons-of-Fuss-124047.shtml">writes both formats</a>, still only reads back the .DS_Store ones.  It seems to me that Apple would have changed Finder to read from the newer Extended Attributes as soon as they started writing to those in duplicate.</p>

<blockquote>"On Mac OS X 10.4 Tiger, for example, .DS_Store files also contain the Spotlight comments of all the folder's files, whereas Mac OS X 10.5 "Leopard" stores this information in Extended file attributes."</blockquote>

<h2>Script Research</h2>
<p>Giving a tip of the hat to the similar-but-not-quite-what-I-wanted script that helped me get enough of the syntax working (using type <code>alias</code> instead of type <code>file</code> was tricky) get my own authored, I give you:</p>
<p>A <a href="http://www.macosxhints.com/article.php?story=20050614071122965">MacOSXHints article</a>, and the <a href="http://www.macosxhints.com/dlfiles/spotlight_comment_script.txt">corresponding code</a></p>
    <script src="http://gist.github.com/285988.js?file=spotlight-flag-comments.scpt"></script>

<h2>The Solution</h2>
<p>To solve this extended attributes vs. .DS_Store discrepancy, we only need to read (from the extended attributes) and reapply (thereby recreating the .DS_Store) the same comment.  The solution is this AppleScript.  Just highlight the files needing the treatment in Finder, then execute this script from the AppleScript Editor.</p>
<script src="http://gist.github.com/285667.js?file=recomment.scpt"></script>
<p>The result is that Finder (which reads only the .DS_Store files) and PathFinder (which only reads the extended attributes) can both now see the Spotlight Comments.</p>

<h3>Extras</h3>
<p>If you would like your Mac to automatically clean up the .DS_Store files it writes out to flash sticks and network drives, <a href="http://zeroonetwenty.com/blueharvest/">check out BlueHarvest</a>, an interesting little utility app that fills this need.</p>
