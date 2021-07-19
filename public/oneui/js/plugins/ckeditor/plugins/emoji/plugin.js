/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
(function(){function k(a){a.name||(a.name=e(a.id.replace(/::.*$/,":").replace(/^:|:$/g,"")));return a}var g=!1,f=CKEDITOR.tools.array,e=CKEDITOR.tools.htmlEncode,h=CKEDITOR.tools.createClass({$:function(a,d){var c=this.lang=a.lang.emoji,b=this;this.listeners=[];this.plugin=d;this.editor=a;this.groups=[{name:"people",sectionName:c.groups.people,svgId:"cke4-icon-emoji-2",position:{x:-21,y:0},items:[]},{name:"nature",sectionName:c.groups.nature,svgId:"cke4-icon-emoji-3",position:{x:-42,y:0},items:[]},
{name:"food",sectionName:c.groups.food,svgId:"cke4-icon-emoji-4",position:{x:-63,y:0},items:[]},{name:"travel",sectionName:c.groups.travel,svgId:"cke4-icon-emoji-6",position:{x:-42,y:-21},items:[]},{name:"activities",sectionName:c.groups.activities,svgId:"cke4-icon-emoji-5",position:{x:-84,y:0},items:[]},{name:"objects",sectionName:c.groups.objects,svgId:"cke4-icon-emoji-7",position:{x:0,y:-21},items:[]},{name:"symbols",sectionName:c.groups.symbols,svgId:"cke4-icon-emoji-8",position:{x:-21,y:-21},
items:[]},{name:"flags",sectionName:c.groups.flags,svgId:"cke4-icon-emoji-9",position:{x:-63,y:-21},items:[]}];this.elements={};a.ui.addToolbarGroup("emoji","insert");a.ui.add("EmojiPanel",CKEDITOR.UI_PANELBUTTON,{label:"emoji",title:c.title,modes:{wysiwyg:1},editorFocus:0,toolbar:"insert",panel:{css:[CKEDITOR.skin.getPath("editor"),d.path+"skins/default.css"],attributes:{role:"listbox","aria-label":c.title},markFirst:!1},onBlock:function(d,c){var e=c.keys,f="rtl"===a.lang.dir;e[f?37:39]="next";e[40]=
"next";e[9]="next";e[f?39:37]="prev";e[38]="prev";e[CKEDITOR.SHIFT+9]="prev";e[32]="click";b.blockElement=c.element;b.emojiList=b.editor._.emoji.list;b.addEmojiToGroups();c.element.getAscendant("html").addClass("cke_emoji");c.element.getDocument().appendStyleSheet(CKEDITOR.getUrl(CKEDITOR.basePath+"contents.css"));c.element.addClass("cke_emoji-panel_block");c.element.setHtml(b.createEmojiBlock());c.element.removeAttribute("title");d.element.addClass("cke_emoji-panel");b.items=c._.getItems();b.blockObject=
c;b.elements.emojiItems=c.element.find(".cke_emoji-outer_emoji_block li \x3e a");b.elements.sectionHeaders=c.element.find(".cke_emoji-outer_emoji_block h2");b.elements.input=c.element.findOne("input");b.inputIndex=b.getItemIndex(b.items,b.elements.input);b.elements.emojiBlock=c.element.findOne(".cke_emoji-outer_emoji_block");b.elements.navigationItems=c.element.find("nav li");b.elements.statusIcon=c.element.findOne(".cke_emoji-status_icon");b.elements.statusDescription=c.element.findOne("p.cke_emoji-status_description");
b.elements.statusName=c.element.findOne("p.cke_emoji-status_full_name");b.elements.sections=c.element.find("section");b.registerListeners()},onOpen:b.openReset()})},proto:{registerListeners:function(){f.forEach(this.listeners,function(a){var d=a.listener,c=a.event,b=a.ctx||this;f.forEach(this.blockElement.find(a.selector).toArray(),function(a){a.on(c,d,b)})},this)},createEmojiBlock:function(){var a=[];this.loadSVGNavigationIcons();a.push(this.createGroupsNavigation());a.push(this.createSearchSection());
a.push(this.createEmojiListBlock());a.push(this.createStatusBar());return'\x3cdiv class\x3d"cke_emoji-inner_panel"\x3e'+a.join("")+"\x3c/div\x3e"},createGroupsNavigation:function(){var a,d;this.editor.plugins.emoji.isSVGSupported()?(d=CKEDITOR.env.safari?'xlink:href\x3d"#{svgId}"':'href\x3d"#{svgId}"',a=new CKEDITOR.template('\x3cli class\x3d"cke_emoji-navigation_item" data-cke-emoji-group\x3d"{group}"\x3e\x3ca href\x3d"#" title\x3d"{name}" draggable\x3d"false" _cke_focus\x3d"1"\x3e\x3csvg viewBox\x3d"0 0 34 34" aria-labelledby\x3d"{svgId}-title"\x3e\x3ctitle id\x3d"{svgId}-title"\x3e{name}\x3c/title\x3e\x3cuse '+
d+"\x3e\x3c/use\x3e\x3c/svg\x3e\x3c/a\x3e\x3c/li\x3e"),d=f.reduce(this.groups,function(c,b){return b.items.length?c+a.output({group:e(b.name),name:e(b.sectionName),svgId:e(b.svgId),translateX:b.translate&&b.translate.x?e(b.translate.x):0,translateY:b.translate&&b.translate.y?e(b.translate.y):0}):c},"")):(d=CKEDITOR.getUrl(this.plugin.path+"assets/iconsall.png"),a=new CKEDITOR.template('\x3cli class\x3d"cke_emoji-navigation_item" data-cke-emoji-group\x3d"{group}"\x3e\x3ca href\x3d"#" draggable\x3d"false" _cke_focus\x3d"1" title\x3d"{name}"\x3e\x3cspan style\x3d"background-image:url('+
d+');background-repeat:no-repeat;background-position:{positionX}px {positionY}px;"\x3e\x3c/span\x3e\x3c/a\x3e\x3c/li\x3e'),d=f.reduce(this.groups,function(c,b){return b.items.length?c+a.output({group:e(b.name),name:e(b.sectionName),positionX:b.position.x,positionY:b.position.y}):c},""));this.listeners.push({selector:"nav",event:"click",listener:function(a){var b=a.data.getTarget().getAscendant("li",!0);b&&(f.forEach(this.elements.navigationItems.toArray(),function(a){a.equals(b)?a.addClass("active"):
a.removeClass("active")}),this.clearSearchAndMoveFocus(b),a.data.preventDefault())}});return'\x3cnav aria-label\x3d"'+e(this.lang.navigationLabel)+'"\x3e\x3cul\x3e'+d+"\x3c/ul\x3e\x3c/nav\x3e"},createSearchSection:function(){this.listeners.push({selector:"input",event:"input",listener:CKEDITOR.tools.throttle(200,this.filter,this).input});this.listeners.push({selector:"input",event:"click",listener:function(){this.blockObject._.markItem(this.inputIndex)}});return'\x3clabel class\x3d"cke_emoji-search"\x3e'+
this.getLoupeIcon()+'\x3cinput placeholder\x3d"'+e(this.lang.searchPlaceholder)+'" type\x3d"search" aria-label\x3d"'+e(this.lang.searchLabel)+'" role\x3d"search" _cke_focus\x3d"1"\x3e\x3c/label\x3e'},createEmojiListBlock:function(){this.listeners.push({selector:".cke_emoji-outer_emoji_block",event:"scroll",listener:CKEDITOR.tools.throttle(150,this.refreshNavigationStatus,this).input});this.listeners.push({selector:".cke_emoji-outer_emoji_block",event:"click",listener:function(a){a.data.getTarget().data("cke-emoji-name")&&
this.editor.execCommand("insertEmoji",{emojiText:a.data.getTarget().data("cke-emoji-symbol")})}});this.listeners.push({selector:".cke_emoji-outer_emoji_block",event:"mouseover",listener:function(a){this.updateStatusbar(a.data.getTarget())}});this.listeners.push({selector:".cke_emoji-outer_emoji_block",event:"keyup",listener:function(){this.updateStatusbar(this.items.getItem(this.blockObject._.focusIndex))}});return'\x3cdiv class\x3d"cke_emoji-outer_emoji_block"\x3e'+this.getEmojiSections()+"\x3c/div\x3e"},
createStatusBar:function(){return'\x3cdiv class\x3d"cke_emoji-status_bar"\x3e\x3cdiv class\x3d"cke_emoji-status_icon"\x3e\x3c/div\x3e\x3cp class\x3d"cke_emoji-status_description"\x3e\x3c/p\x3e\x3cp class\x3d"cke_emoji-status_full_name"\x3e\x3c/p\x3e\x3c/div\x3e'},getLoupeIcon:function(){var a=CKEDITOR.getUrl(this.plugin.path+"assets/iconsall.png");return this.editor.plugins.emoji.isSVGSupported()?(a=CKEDITOR.env.safari?'xlink:href\x3d"#cke4-icon-emoji-10"':'href\x3d"#cke4-icon-emoji-10"','\x3csvg viewBox\x3d"0 0 34 34" role\x3d"img" aria-hidden\x3d"true" class\x3d"cke_emoji-search_loupe"\x3e\x3cuse '+
a+"\x3e\x3c/use\x3e\x3c/svg\x3e"):'\x3cspan class\x3d"cke_emoji-search_loupe" aria-hidden\x3d"true" style\x3d"background-image:url('+a+');"\x3e\x3c/span\x3e'},getEmojiSections:function(){return f.reduce(this.groups,function(a,d){return d.items.length?a+this.getEmojiSection(d):a},"",this)},getEmojiSection:function(a){var d=e(a.name),c=e(a.sectionName);a=this.getEmojiListGroup(a.items);return'\x3csection data-cke-emoji-group\x3d"'+d+'" \x3e\x3ch2 id\x3d"'+d+'"\x3e'+c+"\x3c/h2\x3e\x3cul\x3e"+a+"\x3c/ul\x3e\x3c/section\x3e"},
getEmojiListGroup:function(a){var d=new CKEDITOR.template('\x3cli class\x3d"cke_emoji-item"\x3e\x3ca draggable\x3d"false" data-cke-emoji-full-name\x3d"{id}" data-cke-emoji-name\x3d"{name}" data-cke-emoji-symbol\x3d"{symbol}" data-cke-emoji-group\x3d"{group}" data-cke-emoji-keywords\x3d"{keywords}" title\x3d"{name}" href\x3d"#" _cke_focus\x3d"1"\x3e{symbol}\x3c/a\x3e\x3c/li\x3e');return f.reduce(a,function(a,b){k(b);return a+d.output({symbol:e(b.symbol),id:e(b.id),name:b.name,group:e(b.group),keywords:e((b.keywords||
[]).join(","))})},"",this)},filter:function(a){var d={},c="string"===typeof a?a:a.sender.getValue();f.forEach(this.elements.emojiItems.toArray(),function(a){var e;a:{e=a.data("cke-emoji-name");var f=a.data("cke-emoji-keywords");if(-1!==e.indexOf(c))e=!0;else{if(f)for(e=f.split(","),f=0;f<e.length;f++)if(-1!==e[f].indexOf(c)){e=!0;break a}e=!1}}e||""===c?(a.removeClass("hidden"),a.getParent().removeClass("hidden"),d[a.data("cke-emoji-group")]=!0):(a.addClass("hidden"),a.getParent().addClass("hidden"))});
f.forEach(this.elements.sectionHeaders.toArray(),function(a){d[a.getId()]?(a.getParent().removeClass("hidden"),a.removeClass("hidden")):(a.addClass("hidden"),a.getParent().addClass("hidden"))});this.refreshNavigationStatus()},clearSearchInput:function(){this.elements.input.setValue("");this.filter("")},openReset:function(){var a=this,d;return function(){d||(a.filter(""),d=!0);a.elements.emojiBlock.$.scrollTop=0;a.refreshNavigationStatus();a.clearSearchInput();CKEDITOR.tools.setTimeout(function(){a.elements.input.focus(!0);
a.blockObject._.markItem(a.inputIndex)},0,a);a.clearStatusbar()}},refreshNavigationStatus:function(){var a=this.elements.emojiBlock.getClientRect().top,d,c;d=f.filter(this.elements.sections.toArray(),function(b){var c=b.getClientRect();return!c.height||b.findOne("h2").hasClass("hidden")?!1:c.height+c.top>a});c=d.length?d[0].data("cke-emoji-group"):!1;f.forEach(this.elements.navigationItems.toArray(),function(a){a.data("cke-emoji-group")===c?a.addClass("active"):a.removeClass("active")})},updateStatusbar:function(a){"a"===
a.getName()&&a.hasAttribute("data-cke-emoji-name")&&(this.elements.statusIcon.setText(e(a.getText())),this.elements.statusDescription.setText(e(a.data("cke-emoji-name"))),this.elements.statusName.setText(e(a.data("cke-emoji-full-name"))))},clearStatusbar:function(){this.elements.statusIcon.setText("");this.elements.statusDescription.setText("");this.elements.statusName.setText("")},clearSearchAndMoveFocus:function(a){this.clearSearchInput();this.moveFocus(a.data("cke-emoji-group"))},moveFocus:function(a){a=
this.blockElement.findOne('a[data-cke-emoji-group\x3d"'+e(a)+'"]');var d;a&&(d=this.getItemIndex(this.items,a),a.focus(!0),a.getAscendant("section").getFirst().scrollIntoView(!0),this.blockObject._.markItem(d))},getItemIndex:function(a,d){return f.indexOf(a.toArray(),function(a){return a.equals(d)})},loadSVGNavigationIcons:function(){if(this.editor.plugins.emoji.isSVGSupported()){var a=this.blockElement.getDocument();CKEDITOR.ajax.load(CKEDITOR.getUrl(this.plugin.path+"assets/iconsall.svg"),function(d){var c=
new CKEDITOR.dom.element("div");c.addClass("cke_emoji-navigation_icons");c.setHtml(d);a.getBody().append(c)})}},addEmojiToGroups:function(){var a={};f.forEach(this.groups,function(d){a[d.name]=d.items},this);f.forEach(this.emojiList,function(d){a[d.group].push(d)},this)}}});CKEDITOR.plugins.add("emoji",{requires:"autocomplete,textmatch,ajax,panelbutton,floatpanel",lang:"da,de,en,en-au,et,fr,gl,hr,hu,it,nl,pl,pt-br,sr,sr-latn,sv,tr,uk,zh,zh-cn",icons:"emojipanel",hidpi:!0,isSupportedEnvironment:function(){return!CKEDITOR.env.ie||
11<=CKEDITOR.env.version},beforeInit:function(){this.isSupportedEnvironment()&&!g&&(CKEDITOR.document.appendStyleSheet(this.path+"skins/default.css"),g=!0)},init:function(a){if(this.isSupportedEnvironment()){var d=CKEDITOR.tools.array;CKEDITOR.ajax.load(CKEDITOR.getUrl(a.config.emoji_emojiListUrl||"plugins/emoji/emoji.json"),function(c){function b(){a._.emoji.autocomplete=new CKEDITOR.plugins.autocomplete(a,{textTestCallback:e(),dataCallback:g,itemTemplate:'\x3cli data-id\x3d"{id}" class\x3d"cke_emoji-suggestion_item"\x3e\x3cspan\x3e{symbol}\x3c/span\x3e {name}\x3c/li\x3e',
outputTemplate:"{symbol}"})}function e(){return function(a){return a.collapsed?CKEDITOR.plugins.textMatch.match(a,f):null}}function f(a,b){var c=a.slice(0,b),d=c.match(new RegExp("(?:\\s|^)(:\\S{"+l+"}\\S*)$"));return d?{start:c.lastIndexOf(d[1]),end:b}:null}function g(a,b){var c=a.query.substr(1).toLowerCase(),e=d.filter(h,function(a){return-1!==a.id.toLowerCase().indexOf(c)}).sort(function(a,b){var d=!a.id.substr(1).indexOf(c),e=!b.id.substr(1).indexOf(c);return d!=e?d?-1:1:a.id>b.id?1:-1}),e=d.map(e,
k);b(e)}if(null!==c){void 0===a._.emoji&&(a._.emoji={});void 0===a._.emoji.list&&(a._.emoji.list=JSON.parse(c));var h=a._.emoji.list,l=void 0===a.config.emoji_minChars?2:a.config.emoji_minChars;if("ready"!==a.status)a.once("instanceReady",b);else b()}});a.addCommand("insertEmoji",{exec:function(a,b){a.insertHtml(b.emojiText)}});a.plugins.toolbar&&new h(a,this)}},isSVGSupported:function(){return!CKEDITOR.env.ie||CKEDITOR.env.edge}})})();