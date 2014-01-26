---
layout: post
status: publish
published: true
title: Clean your Git up to Pull successfully
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: |
  <p>Here's a quick tip to clean your local Git repository of unwanted changes to tracked and untracked files with two Git commands.</p>
wordpress_id: 107
wordpress_url: http://ambientideas.com/blog/index.php/2009/02/clean-your-git-up-to-pull-successfully/
date: 2009-02-14 10:53:16.000000000 -07:00
categories:
- Programming
tags:
- OpenSource
- Git
- SourceCodeControl
comments: []
---
<p>Here's a quick <a href="http://www.kernel.org/pub/software/scm/git/docs/git-pull.html" target="_blank">Git pulling &amp; merging</a> tip for those of you learning this awesome <a href="http://en.wikipedia.org/wiki/Distributed_revision_control" target="_blank">Distributed Version Control System</a>.</p>
<h2>Git Pull's Double Duty</h2>
<p>As you may be aware, the <a href="http://www.kernel.org/pub/software/scm/git/docs/git-pull.html" target="_blank">git pull command actually does two things under the covers</a>. It does a <code>git fetch</code> to freshen your tracked remote branch and it does a <code>git merge</code> to merge it into the linked local branch. Sometimes this can go awry if you've been experimenting with files locally and forgot to return them to a checked-in state. Git errors out nicely, saying "I don't know what you want me to do, but I'm going to be cautious here and just let you tell me exactly how to handle this."</p>
<h2>Error Message</h2>
<p>One of the possible error messages you'll see is:</p>
<blockquote>
  <code>error: Entry 'myapp/src/main/resources/scripts/launchapp.bat' not uptodate</code>
</blockquote>
<h2>Solutions</h2>
<p>If your local changes are unimportant to you and you just want to get back in alignment with the remote branch, you have two options to apply depending on the state of your local files. First, you can <a href="http://www.kernel.org/pub/software/scm/git/docs/git-reset.html" target="_blank">reset any tracked files to their last committed state</a> via the following command. This discards any local changes to any tracked files.</p>
<blockquote>
  <code>git reset --hard</code>
</blockquote>
<p>Second, you can <a href="http://www.kernel.org/pub/software/scm/git/docs/git-clean.html" target="_blank">discard any untracked local files</a> via the <code>git clean</code> command, in the case that they are colliding with files that the remote branch has actually added and is now tracking. You can purge your repository's current branch of untracked local files by typing:</p>
<blockquote>
  <code>git clean -f</code>
</blockquote>
<p>And in case you are paranoid about what this will remove, you can get a safe preview of what it would do by typing:</p>
<blockquote>
  <code>git clean -n</code>
</blockquote>
<p>Which outputs a preview list like so:</p>
<blockquote>
  <code>[~/Documents/Code/myproj.git]: git clean -n<br />
  Would remove morecruft.java<br />
  Would remove unwatedfile.txt</code>
</blockquote>
