/*!
Waypoints - 3.0.0
Copyright © 2011-2014 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/waypoints/blog/master/licenses.txt
*/!function(){"use strict";function e(r){if(!r)throw new Error("No options passed to Waypoint constructor");if(!r.element)throw new Error("No element option passed to Waypoint constructor");if(!r.handler)throw new Error("No handler option passed to Waypoint constructor");this.key="waypoint-"+t,this.options=e.Adapter.extend({},e.defaults,r),this.element=this.options.element,this.adapter=new e.Adapter(this.element),this.callback=r.handler,this.axis=this.options.horizontal?"horizontal":"vertical",this.enabled=this.options.enabled,this.triggerPoint=null,this.group=e.Group.findOrCreate({name:this.options.group,axis:this.axis}),this.context=e.Context.findOrCreateByElement(this.options.context),e.offsetAliases[this.options.offset]&&(this.options.offset=e.offsetAliases[this.options.offset]),this.group.add(this),this.context.add(this),n[this.key]=this,t+=1}var t=0,n={};e.prototype.queueTrigger=function(e){this.group.queueTrigger(this,e)},e.prototype.trigger=function(e){this.enabled&&this.callback&&this.callback.apply(this,e)},e.prototype.destroy=function(){this.context.remove(this),this.group.remove(this),delete n[this.key]},e.prototype.disable=function(){return this.enabled=!1,this},e.prototype.enable=function(){return this.context.refresh(),this.enabled=!0,this},e.prototype.next=function(){return this.group.next(this)},e.prototype.previous=function(){return this.group.previous(this)},e.destroyAll=function(){var e=[];for(var t in n)e.push(n[t]);for(var r=0,s=e.length;s>r;r++)e[r].destroy()},e.refreshAll=function(){e.Context.refreshAll()},e.viewportHeight=function(){return window.innerHeight||document.documentElement.clientHeight},e.viewportWidth=function(){return document.documentElement.clientWidth},e.adapters=[],e.defaults={context:window,continuous:!0,enabled:!0,group:"default",horizontal:!1,offset:0},e.offsetAliases={"bottom-in-view":function(){return this.context.innerHeight()-this.adapter.outerHeight()},"right-in-view":function(){return this.context.innerWidth()-this.adapter.outerWidth()}},window.Waypoint=e}(),function(){"use strict";function e(e){window.setTimeout(e,1e3/60)}function t(e){this.element=e,this.Adapter=i.Adapter,this.adapter=new this.Adapter(e),this.key="waypoint-context-"+n,this.didScroll=!1,this.didResize=!1,this.oldScroll={x:this.adapter.scrollLeft(),y:this.adapter.scrollTop()},this.waypoints={vertical:{},horizontal:{}},e.waypointContextKey=this.key,r[e.waypointContextKey]=this,n+=1,this.createThrottledScrollHandler(),this.createThrottledResizeHandler()}var n=0,r={},i=window.Waypoint,s=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||e,o=window.onload;t.prototype.add=function(e){var t=e.options.horizontal?"horizontal":"vertical";this.waypoints[t][e.key]=e,this.refresh()},t.prototype.checkEmpty=function(){var e=this.Adapter.isEmptyObject(this.waypoints.horizontal),t=this.Adapter.isEmptyObject(this.waypoints.vertical);e&&t&&(this.adapter.off(".waypoints"),delete r[this.key])},t.prototype.createThrottledResizeHandler=function(){function e(){t.handleResize(),t.didResize=!1}var t=this;this.adapter.on("resize.waypoints",function(){t.didResize||(t.didResize=!0,s(e))})},t.prototype.createThrottledScrollHandler=function(){function e(){t.handleScroll(),t.didScroll=!1}var t=this;this.adapter.on("scroll.waypoints",function(){(!t.didScroll||i.isTouch)&&(t.didScroll=!0,s(e))})},t.prototype.handleResize=function(){i.Context.refreshAll()},t.prototype.handleScroll=function(){var e={},t={horizontal:{newScroll:this.adapter.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.adapter.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};for(var n in t){var r=t[n],i=r.newScroll>r.oldScroll,s=i?r.forward:r.backward;for(var o in this.waypoints[n]){var u=this.waypoints[n][o],a=r.oldScroll<u.triggerPoint,f=r.newScroll>=u.triggerPoint,l=a&&f,c=!a&&!f;(l||c)&&(u.queueTrigger(s),e[u.group.id]=u.group)}}for(var h in e)e[h].flushTriggers();this.oldScroll={x:t.horizontal.newScroll,y:t.vertical.newScroll}},t.prototype.innerHeight=function(){return this.element===this.element.window?i.viewportHeight():this.adapter.innerHeight()},t.prototype.remove=function(e){delete this.waypoints[e.axis][e.key],this.checkEmpty()},t.prototype.innerWidth=function(){return this.element===this.element.window?i.viewportWidth():this.adapter.innerWidth()},t.prototype.destroy=function(){var e=[];for(var t in this.waypoints)for(var n in this.waypoints[t])e.push(this.waypoints[t][n]);for(var r=0,i=e.length;i>r;r++)e[r].destroy()},t.prototype.refresh=function(){var e,t=this.element===this.element.window,n=this.adapter.offset(),r={};this.handleScroll(),e={horizontal:{contextOffset:t?0:n.left,contextScroll:t?0:this.oldScroll.x,contextDimension:this.innerWidth(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:t?0:n.top,contextScroll:t?0:this.oldScroll.y,contextDimension:this.innerHeight(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};for(var i in e){var s=e[i];for(var o in this.waypoints[i]){var u,a,f,l,c,h=this.waypoints[i][o],p=h.options.offset,d=h.triggerPoint,v=0,m=null==d;h.element!==h.element.window&&(v=h.adapter.offset()[s.offsetProp]),"function"==typeof p?p=p.apply(h):"string"==typeof p&&(p=parseFloat(p),h.options.offset.indexOf("%")>-1&&(p=Math.ceil(s.contextDimension*p/100))),u=s.contextScroll-s.contextOffset,h.triggerPoint=v+u-p,a=d<s.oldScroll,f=h.triggerPoint>=s.oldScroll,l=a&&f,c=!a&&!f,!m&&l?(h.queueTrigger(s.backward),r[h.group.id]=h.group):!m&&c?(h.queueTrigger(s.forward),r[h.group.id]=h.group):m&&s.oldScroll>=h.triggerPoint&&(h.queueTrigger(s.forward),r[h.group.id]=h.group)}}for(var g in r)r[g].flushTriggers();return this},t.findOrCreateByElement=function(e){return t.findByElement(e)||new t(e)},t.refreshAll=function(){for(var e in r)r[e].refresh()},t.findByElement=function(e){return r[e.waypointContextKey]},window.onload=function(){o&&o(),t.refreshAll()},i.Context=t}(),function(){"use strict";function e(e,t){return e.triggerPoint-t.triggerPoint}function t(e,t){return t.triggerPoint-e.triggerPoint}function n(e){this.name=e.name,this.axis=e.axis,this.id=this.name+"-"+this.axis,this.waypoints=[],this.clearTriggerQueues(),r[this.axis][this.name]=this}var r={vertical:{},horizontal:{}},i=window.Waypoint;n.prototype.add=function(e){this.waypoints.push(e)},n.prototype.clearTriggerQueues=function(){this.triggerQueues={up:[],down:[],left:[],right:[]}},n.prototype.flushTriggers=function(){for(var n in this.triggerQueues){var r=this.triggerQueues[n],i="up"===n||"left"===n;r.sort(i?t:e);for(var s=0,o=r.length;o>s;s+=1){var u=r[s];(u.options.continuous||s===r.length-1)&&u.trigger([n])}}this.clearTriggerQueues()},n.prototype.next=function(t){this.waypoints.sort(e);var n=i.Adapter.inArray(t,this.waypoints),r=n===this.waypoints.length-1;return r?null:this.waypoints[n+1]},n.prototype.previous=function(t){this.waypoints.sort(e);var n=i.Adapter.inArray(t,this.waypoints);return n?this.waypoints[n-1]:null},n.prototype.queueTrigger=function(e,t){this.triggerQueues[t].push(e)},n.prototype.remove=function(e){var t=i.Adapter.inArray(e,this.waypoints);t>-1&&this.waypoints.splice(t,1)},n.prototype.first=function(){return this.waypoints[0]},n.prototype.last=function(){return this.waypoints[this.waypoints.length-1]},n.findOrCreate=function(e){return r[e.axis][e.name]||new n(e)},i.Group=n}(),function(){"use strict";function e(e){this.$element=t(e)}var t=window.jQuery,n=window.Waypoint;t.each(["innerHeight","innerWidth","off","offset","on","outerHeight","outerWidth","scrollLeft","scrollTop"],function(t,n){e.prototype[n]=function(){var e=Array.prototype.slice.call(arguments);return this.$element[n].apply(this.$element,e)}}),t.each(["extend","inArray","isEmptyObject"],function(n,r){e[r]=t[r]}),n.adapters.push({name:"jquery",Adapter:e}),n.Adapter=e}(),function(){"use strict";function e(e){return function(){var n=[],r=arguments[0];return e.isFunction(arguments[0])&&(r=e.extend({},arguments[1]),r.handler=arguments[0]),this.each(function(){var s=e.extend({},r,{element:this});"string"==typeof s.context&&(s.context=e(this).closest(s.context)[0]),n.push(new t(s))}),n}}var t=window.Waypoint;window.jQuery&&(window.jQuery.fn.waypoint=e(window.jQuery)),window.Zepto&&(window.Zepto.fn.waypoint=e(window.Zepto))}();(function(e){e(document).ready(function(){})})(jQuery);