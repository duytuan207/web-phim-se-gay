using : 
open code embed
set Flashvars to : plugins=plugins/proxy.swf&proxy.link=[Yourlink]
EX: plugins=plugins/proxy.swf&proxy.link=http://hostplugins.com/abc.html

add multi plugins :
- open file plugins/pluginslist.xml
- insert element <plugins url="LinkPlugins.swf"/>
EX with 3 plugins:
<pluginlist loading="Loading Plugins, Please wait...">
	<plugins url="plugins1.swf"/>
	<plugins url="plugins2.swf"/>
	<plugins url="plugins3.swf"/>
</pluginlist>