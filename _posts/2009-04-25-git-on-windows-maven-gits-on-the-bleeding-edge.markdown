---
layout: post
status: publish
published: true
title: Git on Windows + Maven Gits on the Bleeding Edge
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: |
  <p>While the methods for putting Git on Windows have a slight variance from that of putting it on Mac or Linux, I have seen no real compatibility issues in my near daily use of it on all three aforementioned platforms. ... And if you are using IntelliJ, support is built right into v8.1 , Eclipse has eGit as an official Eclipse project now , and NetBeans has an issue open and some ongoing work for support which, awesomely consumes parts of eGit (JGit Libs) from Eclipse. And just to share the "Peanutbutter in my Chocolate" favorite story of the week, Maven is moving to Git in many directions at once: I asked Jukka Zitting of Apache to mirror the Maven SVN trunks to Git . 36 hours later, it was done .</p>
wordpress_id: 125
wordpress_url: http://ambientideas.com/blog/index.php/2009/04/git-on-windows-maven-gits-on-the-bleeding-edge/
date: 2009-04-25 14:46:47.000000000 -06:00
categories:
- Programming
tags:
- Git
- Maven
- Programming
comments:
- id: 1993
  author: Mike
  author_email: rbrhood@yahoo.com
  author_url: ''
  date: '2009-04-26 09:16:35 -0600'
  date_gmt: '2009-04-26 16:16:35 -0600'
  content: Not many Java developers on Windows use Emacs, I know, but for Emacs there
    is the great Magit (http://zagadka.vm.bytemark.co.uk/magit/). Magit is a much
    more comprehensive interface to Git than what the standard vc-mode of Emacs offers,
    and it's also much easier to use and more intuitive in my opinion. If you write
    code in Emacs, Magit pretty much obviates the need to access Git from the command
    line and also makes you reach for gitk and such much less frequently.
- id: 1999
  author: Ibrahim
  author_email: ibrahim.awwal@gmail.com
  author_url: http://iofthestorm.wordpress.com
  date: '2009-04-26 12:20:32 -0600'
  date_gmt: '2009-04-26 19:20:32 -0600'
  content: Note that Git Extensions http://code.google.com/p/gitextensions/ is also
    a nice GUI shell extension for Windows. Not quite like Tortoise(X) but it's prettier
    IMO.
---
<p><a href="http://git-scm.com/">Git</a>, the oft-referred to as "Linux, Rubyists, and Cool Kids source code control system", is gaining ground so fast that there's not enough room in this post to mention all the traction and <a href="http://images.businessweek.com/ss/09/04/0421_best_young_entrepreneurs/17.htm">good press it is achieving</a>. Yet, a common comment I hear over lunches and cubicle walls is</p>
<blockquote>
  <p>"<em>Git doesn't have good support on Windows yet.</em>"</p>
</blockquote>
<p>I politely disagree.</p>
<p>While the <a href="http://nathanj.github.com/gitguide/" target="_blank">methods</a> for putting <a href="http://github.com/guides/using-git-and-github-for-the-windows-for-newbies" target="_blank">Git on Windows</a> have a slight variance from that of putting it on <a href="http://github.com/guides/compiling-and-installing-git-on-mac-os-x" target="_blank">Mac</a> or Linux, I have seen no real compatibility issues in my near daily use of it on all three aforementioned platforms. Is there still room for it to get better on Windows though? Definitely!</p>
<p>The next lament I hear is</p>
<blockquote>
  <p>"<em>If only there were a Tortise-like UI for Git.</em>"</p>
</blockquote>
<p>Let me also put that to rest and <a href="http://code.google.com/p/tortoisegit/" target="_blank">direct you to the TortiseGit homepage</a>. While TortiseGit is still a work in progress, I've seen a handful of folks already putting it to productive daily use. And if you don't like TortiseGit, then <a href="http://www.kodespace.com/gitSafe/" target="_blank">try GitSafe</a>. And if you are using <a href="http://www.jetbrains.com/idea/features/newfeatures.html" target="_blank">IntelliJ, support is built right into v8.1</a>, Eclipse has <a href="http://www.eclipse.org/proposals/egit/" target="_blank">eGit as an official Eclipse project now</a>, and NetBeans has <a href="http://www.netbeans.org/issues/show_bug.cgi?id=131531" target="_blank">an issue open</a> and <a href="http://groups.google.com/group/nbgit/" target="_blank">some ongoing work for support</a> which, awesomely consumes parts of eGit (JGit Libs) from Eclipse.<br /></p>
<p style="font: 12.0px Helvetica"><img border="1" src="http://tortoisegit.googlecode.com/files/sendmail.jpg" width="483" height="262" /></p>
<p>And just to share the "Peanutbutter in my Chocolate" favorite story of the week, <a href="http://maven.apache.org" target="_blank">Maven</a> is moving to Git in many directions at once:</p>
<ol>
  <li>I asked <a href="http://twitter.com/jukkaz" target="_blank">Jukka Zitting</a> of Apache to <a href="http://issues.apache.org/jira/browse/INFRA-2013" target="_blank">mirror the Maven SVN trunks to Git</a>. 36 hours later, <a href="http://git.apache.org" target="_blank">it was done</a>. What an amazing team player Jukka is.</li>

  <li><a href="http://www.sonatype.com/books/maven-book/reference/" target="_blank">Maven: The Definitive Guide</a> has moved its <a href="http://github.com/sonatype/maven-guide/tree/master" target="_blank">canonical repository to GitHub</a>. Fork, contribute, and issue pull requests to Sonatype at will!</li>

  <li><a href="http://twitter.com/jvanzyl" target="_blank">Jason van Zyl</a>, the founder of Maven, has sent out an inquiry to the <a href="http://www.nabble.com/Using-GIT-as-the-canonical-repository-for-Maven-3.x-td23201420.html" target="_blank">Maven Dev mailing list musing about moving Maven's official source repo to Git</a>.</li>
</ol>
<p>If you have yet to explore or fully leverage the power of Git or Maven, now is a critical juncture of market acceptance for these tools, and accordingly, a perfect time to explore their benefits. For the latest news on Git, Maven, iPhone development, and Open Source, <a href="http://twitter.com/matthewmccull" target="_blank">join the conversation over at Twitter</a>.</p>
