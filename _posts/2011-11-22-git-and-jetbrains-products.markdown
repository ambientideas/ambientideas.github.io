---
layout: post
status: publish
published: true
title: Git and GitHub Support in JetBrains YouTrack
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: The JetBrains team continues to innovate with Git and GitHub support.
wordpress_id: 317
wordpress_url: http://ambientideas.com/blog/?p=317
date: 2011-11-22 21:54:17.000000000 -07:00
categories:
- Programming
tags:
- Git
- github
- jetbrains
- bugtracking
comments: []
---
<p>I recently had the chance to get a demo of <a href="http://jetbrains.com">JetBrains</a> products' <a href="http://git-scm.com.com/">Git</a> integration and to meet some of the JetBrains development team in person at <a href="http://oredev.org/2011">Øredev</a> in Malmö, Sweden.</p>

<p>I love seeing things integrate better with the <a href="http://developer.github.com/v3/">GitHub API</a>. It really is fantastic to see what is possible when a rich Internet application additionally becomes a platform for apps that extend the core value proposition. <a href="http://github.com">GitHub</a> has executed on this quite well with their <a href="http://developer.github.com/v3/">API, now at version 3.0</a> and with features like gist, repo, user, and even organization management.</p>

<p><img src="/blog/wp-content/uploads/2011/11/youtrack-issue-bug-tracker-jetbrains.jpg" alt="Youtrack issue bug tracker jetbrains" title="youtrack-issue-bug-tracker-jetbrains.jpg" border="0" width="483" height="89" style="float:right;" />I like to keep abreast of just about everything that happens in the Git world, and the JetBrains folks certainly as very active there. <a href="http://www.jetbrains.com/youtrack/">The JetBrains issue tracking tool, YouTrack</a>, makes extensive use of the GitHub API and has much in the way of Git love. I've been pointing folks at the <a href="http://tv.jetbrains.net/videocontent/youtrack-overview">YouTrack overview video</a> if they want a quick summary and the <a href="http://tv.jetbrains.net/videocontent/youtrack-github-integration">integration demo</a>, if the GitHub facet is the attraction.</p>

<p>It is always fun to ask a vendor for their view of what's important and what's next. The JetBrains team said (paraphrased):</p>

<p>
<ol>
<li>Keyboard-centric approach: All common actions have handy shortcuts.</li>

<li>Smart issue search: Search with queries similar to everyday language aided by completion and highlighting. For example, type <code>for me unresolved</code> to filter down to open issues assigned to me.</li>

<li>Batch modification commands similar to search queries: Select multiple issues and resolve them all by typing <code>fixed assignee Matthew</code></li>

<li>Report from everywhere: You can report issues via email or any third party application via a REST API.</li>

<li>Full customization: You can define and use new attributes for your bug tracking and <a href="http://tv.jetbrains.net/videocontent/youtrack-customizable-workflow-overview">create workflows</a> using a YouTrack workflow editor with a domain-specific language.</li>

<li>Integration with VCSs via <a href="http://www.jetbrains.com/teamcity/">TeamCity</a> and native integration with <a href="http://www.github.com">GitHub</a>: You can specify an Issue ID and command to be applied to the issue right from commit comment. No opening the bug tracker just to change a bug state.</li>

<li>REST API to perform any action programmatically: Complex actions like administration, issue tracking, and user management all have good treatment in the API which means tools can extend the tool if necessary.</li>

<li>Import from other bug trackers: History can be imported from any issue tracker using the YouTrack Client Python library. There are even some ready to use scripts to import from the most popular trackers like JIRA, FogBugz, Mantis, and Bugzilla.</li>

<li>Constant innovation with transparency: The <a href="http://www.jetbrains.com/youtrack/roadmap/index.html">roadmap is public</a> and <a href="http://agilemanifesto.org/">agile</a> project management is the next big focus.</li>
</ol>

<p>More Git-integrating tool reviews are being planned. Stay tuned.</p>
