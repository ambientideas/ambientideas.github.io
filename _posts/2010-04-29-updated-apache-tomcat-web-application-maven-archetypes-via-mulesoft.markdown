---
layout: post
status: publish
published: true
title: Updated Apache Tomcat Web Application Maven Archetypes via MuleSoft
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: "Previously, the file named archetype.xml lived in the src/main/resources/META-INF/
  directory,  then it was relocated to src/main/resources/META-INF/maven , and finally,
  in full modern 2.0 form, has been additionally  renamed to src/main/resources/META-INF/maven/archetype-metadata.xml
  .  \n\n... Lastly, for those of you that prefer a video walkthrough of the usage
  of these two archetypes,  check out our screencast demo  that takes you from start
  to finish of working with these valuable new tools in the Maven, Tomcat, Tcat, and
  web application development ecosystems."
wordpress_id: 225
wordpress_url: http://ambientideas.com/blog/index.php/2010/04/updated-apache-tomcat-web-application-maven-archetypes-via-mulesoft/
date: 2010-04-29 21:39:13.000000000 -06:00
categories:
- Programming
tags:
- OpenSource
- Maven
- Programming
- Tomcat
comments: []
---
<h1>MuleSoft Tomcat Web App Maven Archetypes</h1>

<p>I'm pleased to announce that MuleSoft and I have collaborated to freshen the world's two most commonly used <a href="http://maven.apache.org/archetype/maven-archetype-plugin/" title="Archetypes Definition">Maven Web Application Archetypes</a>, the <em>maven-archetype-webapp</em> and the <em>wicket-archetype-quickstart</em>.</p>

<h2>The Motivations</h2>

<p>These two archetypes had fallen out of date, both in terms of using the new Archetype 2.0 style metadata, as well as in the dependencies on the third-party libraries such as JUnit.  Due to limited volunteer developer time, when the Maven Archetype developers <a href="http://svn.apache.org/viewvc/maven/archetype/branches/archetype-1.0.x/maven-archetype-bundles/" title="1.0 Branch">moved from the 1.0</a> to the <a href="http://svn.apache.org/viewvc/maven/archetype/trunk/archetype-samples/" title="2.0 Branch">2.0 branch</a> many of the existing archetypes did not successfully make the transition.  Thus, the public was having to make do by using old versions of these archetypes.</p>

<h2>The Update</h2>

<p>Given MuleSoft's and my keen interest in the <a href="http://www.mulesoft.com/understanding-apache-tomcat">Apache Tomcat</a> ecosystem, including the enterprise-strength <a href="http://www.mulesoft.com/tcat-server-enterprise-tomcat-application-server">Tcat</a> product, we set out to bring these two aging archetypes up to date.  We found that easiest to do under the very open <a href="http://admin.muleforge.org/projects/maven2">MuleForge repository</a> &amp; <a href="http://github.com/mulesoft/mulesoft-maven-archetypes">GitHub source code hosting</a> for the near term, but we will be <a href="http://svn.apache.org/viewvc/maven/archetype/trunk/archetype-common/src/main/resources/archetype-catalog.xml?view=log">submitting a patch</a> to get these improvements back into the <a href="http://svn.apache.org/viewvc/maven/archetype/trunk/" title="Archetype 2.0 Source Code">core archetypes at Apache</a> too.</p>

<h2>Contributing back to community</h2>

<p>A week into the effort, the "update" turned into a complete "rewrite" of the archetypes to reap all the benefits of the Maven Archetype Plugin's version 2.0 features.</p>

<p>The metadata has dramatically changed between the Maven Archetype 1.0 and 2.0 versions of the plugin.  Previously, the file named archetype.xml lived in the src/main/resources/META-INF/ directory, <a href="http://svn.apache.org/viewvc?view=revision&amp;revision=932937">then it was relocated to src/main/resources/META-INF/maven</a>, and finally, in full modern 2.0 form, has been additionally <a href="http://github.com/mulesoft/mulesoft-maven-archetypes/blob/master/maven-archetype-wicket/src/main/resources/META-INF/maven/archetype-metadata.xml">renamed to src/main/resources/META-INF/maven/archetype-metadata.xml</a>.</p>

<p>Similarly, variables inside source files were updated to use the ${} notation, with <a href="http://svn.apache.org/viewvc/maven/archetype/branches/archetype-1.0.x/maven-archetype-bundles/maven-archetype-quickstart/src/main/resources/archetype-resources/src/main/java/App.java?view=markup">legacy elements like $package</a> <a href="http://github.com/mulesoft/mulesoft-maven-archetypes/blob/master/maven-archetype-wicket/src/main/resources/archetype-resources/src/main/java/WicketApplication.java">updated to ${package}</a>.</p>

<p>The poms for the archetypes were updated from the <a href="http://github.com/mulesoft/mulesoft-maven-archetypes/blob/master/maven-archetype-wicket/pom.xml">old archetype plugin</a> type to <a href="http://github.com/mulesoft/mulesoft-maven-archetypes/blob/master/maven-archetype-wicket/pom.xml">use the new 2.0 lifecycle extensions</a></p>

<p>The <a href="http://github.com/mulesoft/mulesoft-maven-archetypes">resultant archetype code is hosted at GitHub</a> for easy viewing, consumption, technical review and forking.  We'd love to <a href="http://github.com/mulesoft/mulesoft-maven-archetypes/issues">get your input and improvements</a>!</p>

<p>These two archetypes now represent the most pristine use of the Maven Archetype Plugin v2.0 format.</p>

<h2>Integration Tests</h2>

<p>We didn't want to stop at just updating the archetypes though.  We wanted to make them better.  So one of the most obvious ways to do that was through adding integration tests.  I can't tell you how often I get asked for a good example of leveraging the <a href="http://maven.apache.org/guides/introduction/introduction-to-the-lifecycle.html#Lifecycle_Reference">Maven pre-integration-test and post-integration-test lifecycle events</a>.  Up until now, I've been relatively empty handed to respond to this request, but finally we have some reference examples.</p>

<p>These lifecycles are now <a href="http://github.com/mulesoft/mulesoft-maven-archetypes/blob/master/maven-archetype-wicket/pom.xml">bound to the redeployment and undeployment of the web application artifact (WAR) and the execution of a JWebUnit integration test</a> that exercises and validates the home page on each of the JSP and Wicket flavors of web application.</p>

<h2>Instructions for Use</h2>

<p>We've built a wiki page showcasing the usage of this <a href="http://www.mulesoft.org/display/TCAT/MuleSoft+Tcat+Archetypes">archetype</a> which we also invite you to review and improve.  In short, you can inform Maven of the new archetype catalog via a quick execution of:</p>

<pre><code>mvn archetype:generate -DarchetypeCatalog=http://dist.muleforge.org/maven2/
</code></pre>

<p>Lastly, for those of you that prefer a video walkthrough of the usage of these two archetypes, <a href="http://www.youtube.com/watch?v=T7b4DgghZQ4">check out our screencast demo</a> that takes you from start to finish of working with these valuable new tools in the Maven, Tomcat, Tcat, and web application development ecosystems.</p>

<h2>Future Goals</h2>

<p>Like all good developers, we are always looking towards the next iteration, just as the current ones are drawing to successful close.  In the next release of these archetypes, or perhaps in supplemental sibling instances, we're exploring:</p>

<ol>
<li>A zero-footprint, embedded <a href="http://www.mulesoft.com/download-tcat-server-enterprise-tomcat">Tcat installation</a> that can be retrieved from a Maven repository.</li>
<li>Profiles to allow for the integration tests to be selectively executed in a local or embedded Tomcat or Tcat installation, possibly auto-detected to activate the proper profile.</li>
<li>Support for Maven provisioning of completed artifacts into <a href="http://www.mulesoft.com/tcat-server-tomcat-administration-console">Tcat server groups</a>.</li>
</ol>

<h2>OSS Thanks</h2>

<p>In closing, we want to thank the <a href="http://tomcat.apache.org/">Tomcat community</a> for founding such a great product and the Maven community for planting the seeds of these new archetypes.  Java web application development is at its current fevered pitch, thanks, in large part, to these excellent tools and their communities.</p>
