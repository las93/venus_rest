BUNDLE RESTFUL FOR VENUS FRAMEWORK
====================

Bundle Restful for Venus Framework PHP

Contact judicael.paquet@gmail.com pour participer au projet ou avoir plus d'information
Contact judicael.paquet@gmail.com to participate at the project or to have more informations

===================
Français
===================

Simple Bundle complet pour faire du RestFul sur Venus Framework

Vous devez copier deux parties dans votre projet Venus pour utiliser ce bundle Restful

Copier public/Rest et private/src/Rest dans votre projet Venus.

Voici un exemple de configuration Apache :

<pre>
&lt;VirtualHost *:83&gt;
     ServerName localhost
     DocumentRoot E:/venus/public/Rest/
     &lt;Directory E:/venus/public/Rest/&gt;
         DirectoryIndex index.php
         AllowOverride All
         Order allow,deny
         Allow from all
     &lt;/Directory&gt;
&lt;/VirtualHost&gt;
</pre>

Ne pas oublier d'ajouter votre Listen 83 dans Apache

===================
Anglais
===================

Simple complete Bundle to do RestFul on Venus Framework

You have to copy two parts in your Venus project to use this Restful bundle.

Copy public/Rest and private/src/Rest in your Venus project.

Thsi is an exemple to Apache configuration :

<pre>
&lt;VirtualHost *:80&gt;
     ServerName localhost
     DocumentRoot E:/venus/public/Setup/
     &lt;Directory E:/venus/public/Setup/&gt;
         DirectoryIndex index.php
         AllowOverride All
         Order allow,deny
         Allow from all
     &lt;/Directory&gt;
&lt;/VirtualHost&gt;
</pre>

Don't forget to add your Listen 83 in Apache.
