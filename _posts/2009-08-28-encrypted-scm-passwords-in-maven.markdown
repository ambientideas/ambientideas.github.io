---
layout: post
status: publish
published: true
title: Encrypted SCM Passwords in Maven
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: |
  <p>A little late night hacking and I was able to get encrypted passwords to work in the Maven SCM plugin with Maven 2.2 based on the prodding of Kurt Tometich , an NFJS attendee, and his JIRA bug# SCM-495 . ... The Maven Mojo Developer Cookbook did offer a bit of insight (though syntactically off a bit on the container.getLookupRealm() ) on how to get a handle to the container and look up the security provider , DefaultSecDispatcher.java. [java] SecDispatcher sd = null; try { sd = (SecDispatcher)container.lookup( SecDispatcher.... The only interesting finding was how, instead of putting the decryption on the accessor (getter) of password from the settings data structure, it is put in each place it is attempted to be used (e.g. the Wagon "dispatcher", and now the SCM "dispatcher").</p>
wordpress_id: 155
wordpress_url: http://ambientideas.com/blog/index.php/2009/08/encrypted-scm-passwords-in-maven/
date: 2009-08-28 08:54:04.000000000 -06:00
categories:
- Programming
tags:
- Maven
- Programming
comments: []
---
<p>A little late night hacking and I was able to get encrypted passwords to work in the Maven SCM plugin with <a href="http://maven.apache.org/" target="_blank">Maven 2.2</a> based on the <a href="http://www.nabble.com/SCM-plugin-password-encryption-td24967285.html" target="_blank">prodding of Kurt Tometich</a>, an NFJS attendee, and <a href="http://jira.codehaus.org/browse/SCM-495" target="_blank">his JIRA bug# SCM-495</a>. Previously, this <a href="http://maven.apache.org/guides/mini/guide-encryption.html" target="_blank">encryption feature</a> only worked for Wagon providers (the connectors for uploading artifacts), not for SCM providers, contrary to some blog comments.</p>
<p>It was quite the effort. After a few minutes, I found the code in <a href="http://svn.apache.org/viewvc/maven/maven-2/branches/maven-2.2.x/maven-core/src/main/java/org/apache/maven/DefaultMaven.java?revision=798706" target="_blank">DefaultMaven.java</a> that performed the decryption. Now, I thought, "just implement a similar call in <a href="http://svn.apache.org/viewvc/maven/scm/trunk/maven-scm-plugin/src/main/java/org/apache/maven/scm/plugin/AbstractScmMojo.java?revision=731240&amp;pathrev=731240jo.java?revision=731240&amp;pathrev=731240" target="_blank">AbstractScmMojo.java</a> right?" I harbor a bit of angst for the fact that the JIRA isn't Fisheye-connected to the source code repository, so finding the files changed for a given defect is much harder than it should be.</p>
<p>The <a href="http://docs.codehaus.org/display/MAVENUSER/Mojo+Developer+Cookbook" target="_blank">Maven Mojo Developer Cookbook</a> did offer a bit of insight (though syntactically off a bit on the <code>container.getLookupRealm()</code>) on how to get a handle to the container and look up the <a href="http://svn.sonatype.org/spice/trunk/plexus-sec-dispatcher/src/main/java/org/sonatype/plexus/components/sec/dispatcher/DefaultSecDispatcher.java" target="_blank">security provider</a>, DefaultSecDispatcher.java.</p>
<p>[java]
SecDispatcher sd = null;

try {
  sd = (SecDispatcher)container.lookup( SecDispatcher.ROLE, &amp;amp;amp;quot;maven&amp;amp;amp;quot; );
}
[/java]</p>
<p>There was even the fabled "java.lang.ClassCastException: org.sonatype.plexus.components.sec.dispatcher.DefaultSecDispatcher cannot be cast to org.sonatype.plexus.components.sec.dispatcher.DefaultSecDispatcher" at one point. Oh nuts. Not the classloader scoping issue, please...<br /></p>
<p>The trick on the classloader is that the <a href="http://svn.sonatype.org/spice/trunk/plexus-sec-dispatcher/src/main/java/org/sonatype/plexus/components/sec/dispatcher/DefaultSecDispatcher.java" target="_blank">DefaultSecDispatcher</a> class is available via a dependency to plexus-sec-dispatcher, but also included (repackaged) in the Maven core distribution maven-2.2.0-uber.jar. So the SCM provider project's dependency on <a href="http://repo1.maven.org/maven2/org/sonatype/plexus/plexus-sec-dispatcher/" target="_blank">plexus-sec-dispatcher</a> has to be scoped as &lt;provided&gt; for compilation of the <a href="http://maven.apache.org/scm/plugins/index.html" target="_blank">maven-scm-plugin</a>.</p>
<p>Lots of learning about the Maven code base occurred. The only interesting finding was how, instead of putting the decryption on the accessor (getter) of password from the settings data structure, it is put in each place it is attempted to be used (e.g. the Wagon "dispatcher", and now the SCM "dispatcher"). I'll bring up a refactoring of that with the Maven IRC folks...</p>
