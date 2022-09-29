## Joomla Content Stream Component

**What does this do?**

This component Creates a searchable "stream" of content pulled from a variety of places 

the component will pull in content from :
1. Child menu items 
2. weblinks component (if installed) 
3. docman component (if installed)

Note : at the moment only reads single linked item 

**How to use**

Install as normal Joomla Component 
Use the menu options to configure
-select a category for weblinks 
-select a category for Docman
-select a default menu item to generate docman links

for child menu items 
to add descriptions and tags you can add Json like below to the notes field 
if your menu item has a Params for "tags" or "itemdesc" component will use those . 
{"description":"test note", "tags":["dataset"]}

Example Output from Content Stream

![image](https://user-images.githubusercontent.com/9959732/192988637-f8b8dcd2-1d84-4d29-8241-15f912c3a0e6.png)
