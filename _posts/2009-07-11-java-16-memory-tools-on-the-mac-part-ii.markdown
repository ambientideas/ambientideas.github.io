---
layout: post
status: publish
published: true
title: Java 1.6 Memory Tools on the Mac, Part II
author: Matthew McCullough
author_login: admin
author_email: sales@ambientideas.com
author_url: http://www.ambientideas.com
excerpt: '<p>Then I started checking if this fixed the issue in reverse order, starting
  with the sudo: [bash] sudo java -version java version "1.6.0_13" Java(TM) SE Runtime
  Environment (build 1.6.0_13-b03-211) Java HotSpot(TM) 64-Bit Server VM (build 11.3-b02-83,
  mixed mode) [/bash] <img src="http://farm3.static.flickr.com/2552/3709615153_a367f70a9f.jpg"
  width="480" height="143" alt="200907110802.jpg" /> Looking good! ... Concurrent
  Mark-Sweep GC Heap Configuration: &nbsp;&nbsp;&nbsp; MinHeapFreeRatio = 40 &nbsp;&nbsp;&nbsp;
  MaxHeapFreeRatio = 70 &nbsp;&nbsp;&nbsp; MaxHeapSize = 88080384 (84.0MB) &nbsp;&nbsp;&nbsp;
  NewSize = 21757952 (20.75MB) &nbsp;&nbsp;&nbsp; MaxNewSize = 43581440 (41.5625MB)
  &nbsp;&nbsp;&nbsp; OldSize = 64159744 (61.1875MB) &nbsp;&nbsp;&nbsp; NewRatio =
  7 &nbsp;&nbsp;&nbsp; SurvivorRatio = 6 &nbsp;&nbsp;&nbsp; PermSize = 21757952 (20.75MB)
  &nbsp;&nbsp;&nbsp; MaxPermSize = 88080384 (84.0MB) Heap Usage: New Generation (Eden
  + 1 Survivor Space): &nbsp;&nbsp;&nbsp; capacity = 19070976 (18.1875MB) &nbsp;&nbsp;&nbsp;
  used = 2351616 (2.24267578125MB) &nbsp;&nbsp;&nbsp; free = 16719360 (15.94482421875MB)
  &nbsp;&nbsp;&nbsp; 12.330863402061855% used Eden Space: &nbsp;&nbsp;&nbsp; capacity
  = 16384000 (15.625MB) &nbsp;&nbsp;&nbsp; used = 2351616 (2.24267578125MB) &nbsp;&nbsp;&nbsp;
  free = 14032384 (13.38232421875MB) &nbsp;&nbsp;&nbsp; 14.353125% used From Space:
  &nbsp;&nbsp;&nbsp; capacity = 2686976 (2.5625MB) &nbsp;&nbsp;&nbsp; used = 0 (0.0MB)
  &nbsp;&nbsp;&nbsp; free = 2686976 (2.5625MB) &nbsp;&nbsp;&nbsp; 0.0% used To Space:
  &nbsp;&nbsp;&nbsp; capacity = 2686976 (2.5625MB) &nbsp;&nbsp;&nbsp; used = 0 (0.0MB)
  &nbsp;&nbsp;&nbsp; free = 2686976 (2.5625MB) &nbsp;&nbsp;&nbsp; 0.0% used concurrent
  mark-sweep generation: &nbsp;&nbsp;&nbsp; capacity = 64159744 (61.1875MB) &nbsp;&nbsp;&nbsp;
  used = 0 (0.0MB) &nbsp;&nbsp;&nbsp; free = 64159744 (61.1875MB) &nbsp;&nbsp;&nbsp;
  0.0% used Perm Generation: &nbsp;&nbsp;&nbsp; capacity = 21757952 (20.75MB) &nbsp;&nbsp;&nbsp;
  used = 4716880 (4.4983673095703125MB) &nbsp;&nbsp;&nbsp; free = 17041072 (16.251632690429688MB)
  &nbsp;&nbsp;&nbsp; 21.678878600338855% used [/bash] Thanks to a combination of Ken
  Sipe , Fred Jean , a few good guesses and some investigative work, the problem is
  solved! ... The short answer is to create a text file called /private/etc/launchd.conf
  and put the following (applicable portions, based on your tool usage) contents in
  it: [bash] setenv JAVA_VERSION 1.6 # A) Some process-launchers will cause their
  child to default to 1.5 if using /Library/Java/Home # even if Java Preferences pane
  says 1.6 at the top # setenv JAVA_HOME /Library/Java/Home # B) Alternate: Force
  Java 1.6 as Java Home setenv JAVA_HOME /System/Library/Frameworks/JavaVM.framework/Versions/1.6/Home
  setenv GROOVY_HOME /Applications/Dev/groovy setenv GRAILS_HOME /Applications/Dev/grails
  setenv NEXUS_HOME /Applications/Dev/nexus/nexus-webapp setenv JRUBY_HOME /Applications/Dev/jruby
  # Set up Ant setenv ANT_HOME /Applications/Dev/apache-ant setenv ANT_OPTS -Xmx512M
  # Set up Maven setenv MAVEN_OPTS -Xmx1024M setenv M2_HOME /Applications/Dev/apache-maven
  [/bash] With the only pitfall being that it is not honored by sudo''ed java invocations.</p>'
wordpress_id: 144
wordpress_url: http://ambientideas.com/blog/index.php/2009/07/java-16-memory-tools-on-the-mac-part-ii/
date: 2009-07-11 09:35:14.000000000 -06:00
categories:
- Programming
tags:
- MacOS
- Java
- Programming
comments: []
---
<p>I've been battling getting jmap working properly on a new Mac. I followed <a href="http://kensipe.blogspot.com/2008/08/fixing-java-memory-tools-on-mac-os-x.html" target="_blank">the invaluable instructions</a> my <a href="http://www.nofluffjuststuff.com/conference/speaker/ken_sipe.html" target="_blank">NFJS colleague, Ken Sipe</a>, provided for the Rhino engine inclusion. However, I was still encountering an odd issue where I couldn't get jmap to attach to a Java process.</p>
<p>First, I would start a simple helloworld Java application.</p>
<p><pre>[bash]
java com.ambientideas.HelloWorldJava
Hello Java World!
[/bash]</pre></p>
<p>
<img src="http://farm3.static.flickr.com/2590/3709613661_617eff6518.jpg" width="480" height="136" alt="Picture 1.png" /></p>
<p>Then I would get the PID:</p>
<p><pre>[bash]
jps
11554 HelloWorldJava
11573 Jps
[/bash]</pre></p>
<p>Then I tried to jmap it, but got the following error</p>
<p><pre>[bash]
jmap -heap 11554
Attaching to process ID 11791, please wait...
attach: task_for_pid(11791) failed (5)
Error attaching to process: Error attaching to process, or no such process
[/bash]</pre></p>
<p>So I thought, "These memory tools often require root access, so I'll sudo it." When I did, I got the following equally cryptic error:</p>
<p><pre>[bash]
sudo jmap -heap 11791
Attaching to process ID 11791, please wait...
Exception in thread main java.lang.RuntimeException: gHotSpotVMTypes was not initialized properly in the remote process; can not continue
at sun.jvm.hotspot.HotSpotTypeDataBase.readVMTypes(HotSpotTypeDataBase.java:111)
at sun.jvm.hotspot.HotSpotTypeDataBase.&amp;amp;amp;amp;amp;amp;amp;lt;init&amp;amp;amp;amp;amp;amp;amp;gt;(HotSpotTypeDataBase.java:68)
at sun.jvm.hotspot.MacOSXTypeDataBase.&amp;amp;amp;amp;amp;amp;amp;lt;init&amp;amp;amp;amp;amp;amp;amp;gt;(MacOSXTypeDataBase.java:35)
at sun.jvm.hotspot.bugspot.BugSpotAgent.setupVM(BugSpotAgent.java:560)
at sun.jvm.hotspot.bugspot.BugSpotAgent.go(BugSpotAgent.java:481)
at sun.jvm.hotspot.bugspot.BugSpotAgent.attach(BugSpotAgent.java:319)
at sun.jvm.hotspot.tools.Tool.start(Tool.java:146)
at sun.jvm.hotspot.tools.JMap.main(JMap.java:128)
[/bash]</pre></p>
<p>I though, "Hmmmm, this looks a lot like a java version mismatch. Let's check which java version I'm running." I had javac compiled the HelloWorld against Java 6, so was expecting a matching java. I made a quick stop into the Java Preferences pane. Yup. Java 6 set as the first-priority choice.</p>
<p><br />
<img src="http://farm3.static.flickr.com/2464/3710424866_2943f9b502.jpg" width="480" height="337" alt="Picture 2.png" /></p>
<p>Let's check the command line too...</p>
<p><pre>[bash]
java -version
java version 1.6.0_13
Java(TM) SE Runtime Environment (build 1.6.0_13-b03-211)
Java HotSpot(TM) 64-Bit Server VM (build 11.3-b02-83, mixed mode)
[/bash]</pre></p>
<p>Excellent. Just what I expected. Java 6. But a little doubt crept into my mind. What if the sudo'ed invocation were finding a different Java. That didn't sound plausible, but yet was still worth checking out.</p>
<p><pre>[bash]
sudo java -version
java version 1.5.0_19
Java(TM) 2 Runtime Environment, Standard Edition (build 1.5.0_19-b02-304)
Java HotSpot(TM) Client VM (build 1.5.0_19-137, mixed mode, sharing)
[/bash]</pre></p>
<p>Aha! There's the culprit. So somehow, sudo'ed commands are running Java 5, even though I've set a preference for 6 in my profile. I searched the web high and low for a way to specify the Java version for "sudo" specifically, but could find no trace. I even tried the -E flag to maintain the caller's environment variables, as is possible on Linux distributions. Not implemented on Mac.</p>
<p>I did a quick check of my path and a "which java". Both ultimately routed to Java 6. I also had JAVA_HOME and JAVA_VERSION set just fine.</p>
<p><pre>[bash]
set | grep JAVA
JAVA_HOME=/System/Library/Frameworks/JavaVM.framework/Versions/1.6/Home
JAVA_VERSION=1.6

echo $PATH
/Applications/Dev/btrace/bin:/opt/local/bin:/opt/local/sbin:/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/bin:
/usr/X11/bin:./:
/Users/mccm06/scripts:/Applications/Dev/apache-ant/bin:
/Applications/Dev/apache-maven/bin
[/bash]</pre></p>
<p>So I turned to harness the wisdom of one of the really smart guys (that uses a Mac) I'm privileged to hang out with in Denver, Fred Jean. Fred said, "Try adding the 1.6 java explicitly to the front of your path rather than letting Java Preferences pane be the sole controller." I opened up ~/.bash_profile (alternatively you could edit ~/.bash_rc)and slammed in the following:</p>
<p><pre>[bash]
export PATH=/System/Library/Frameworks/JavaVM.framework/Versions/1.6/Commands:$PATH
[/bash]</pre></p>
<p>I opened a new terminal to pick up the shell changes. Then I started checking if this fixed the issue in reverse order, starting with the sudo:</p>
<p><pre>[bash]
sudo java -version
java version 1.6.0_13
Java(TM) SE Runtime Environment (build 1.6.0_13-b03-211)
Java HotSpot(TM) 64-Bit Server VM (build 11.3-b02-83, mixed mode)
[/bash]</pre></p>
<p><br />
<img src="http://farm3.static.flickr.com/2552/3709615153_a367f70a9f.jpg" width="480" height="143" alt="200907110802.jpg" /></p>
<p>Looking good! Now let's get back to our core goal, jmap.</p>
<p><img src="http://farm4.static.flickr.com/3447/3709615763_7c8a7ecae1.jpg" width="480" height="430" alt="200907110804.jpg" /></p>
<p><pre>[bash]
sudo jmap -heap 5951
Attaching to process ID 5951, please wait...
Debugger attached successfully.
Server compiler detected.
JVM version is 11.3-b02-83
using parallel threads in the new generation.
using thread-local object allocation.
Concurrent Mark-Sweep GC
Heap Configuration:
    MinHeapFreeRatio = 40
    MaxHeapFreeRatio = 70
    MaxHeapSize = 88080384 (84.0MB)
    NewSize = 21757952 (20.75MB)
    MaxNewSize = 43581440 (41.5625MB)
    OldSize = 64159744 (61.1875MB)
    NewRatio = 7
    SurvivorRatio = 6
    PermSize = 21757952 (20.75MB)
    MaxPermSize = 88080384 (84.0MB)
Heap Usage:
New Generation (Eden + 1 Survivor Space):
    capacity = 19070976 (18.1875MB)
    used = 2351616 (2.24267578125MB)
    free = 16719360 (15.94482421875MB)
    12.330863402061855% used
Eden Space:
    capacity = 16384000 (15.625MB)
    used = 2351616 (2.24267578125MB)
    free = 14032384 (13.38232421875MB)
    14.353125% used
From Space:
    capacity = 2686976 (2.5625MB)
    used = 0 (0.0MB)
    free = 2686976 (2.5625MB)
    0.0% used
To Space:
    capacity = 2686976 (2.5625MB)
    used = 0 (0.0MB)
    free = 2686976 (2.5625MB)
    0.0% used
concurrent mark-sweep generation:
    capacity = 64159744 (61.1875MB)
    used = 0 (0.0MB)
    free = 64159744 (61.1875MB)
    0.0% used
Perm Generation:
    capacity = 21757952 (20.75MB)
    used = 4716880 (4.4983673095703125MB)
    free = 17041072 (16.251632690429688MB)
    21.678878600338855% used
[/bash]</pre></p>
<p>Thanks to a combination of <a href="http://twitter.com/kensipe" target="_blank">Ken Sipe</a>, <a href="http://twitter.com/fredjean" target="_blank">Fred Jean</a>, a few good guesses and some investigative work, the problem is solved! I'm longwindedly calling this the "java version is different for sudo-initiated processes on Mac" so that the next person Googling for this using similar keywords will hopefully find this tutorial.</p>
<p>As a closing note, I often get asked how I set my environment variables for Java so that Spotlight-launched, Quicksilver-launched, Dock-launched, and Terminal-launched processes can all see the variables (yes, there's some odd pitfalls about that on a Mac due to the process parents being different). The short answer is to create a text file called /private/etc/launchd.conf and put the following (applicable portions, based on your tool usage) contents in it:</p>
<p><pre>[bash]
setenv JAVA_VERSION 1.6
# A) Some process-launchers will cause their child to default to 1.5 if using /Library/Java/Home
# even if Java Preferences pane says 1.6 at the top
# setenv JAVA_HOME /Library/Java/Home
# B) Alternate: Force Java 1.6 as Java Home
setenv JAVA_HOME /System/Library/Frameworks/JavaVM.framework/Versions/1.6/Home
setenv GROOVY_HOME /Applications/Dev/groovy
setenv GRAILS_HOME /Applications/Dev/grails
setenv NEXUS_HOME /Applications/Dev/nexus/nexus-webapp
setenv JRUBY_HOME /Applications/Dev/jruby
# Set up Ant
setenv ANT_HOME /Applications/Dev/apache-ant
setenv ANT_OPTS -Xmx512M
# Set up Maven
setenv MAVEN_OPTS -Xmx1024M
setenv M2_HOME /Applications/Dev/apache-maven
[/bash]</pre></p>
<p>As we have learned the hard way, the only pitfall is that the java version specified in launchd.conf is not honored by sudo'ed java invocations.</p>

<p><a href="mailto:matthewm@ambientideas.com" target="_blank">Drop me an email</a> if you've seen this issue and this tutorial helps you solve it.</p>
