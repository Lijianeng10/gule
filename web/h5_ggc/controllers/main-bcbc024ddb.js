"use strict";var prototype=function(){Date.prototype.format=function(t){var e=this.getMonth()+1,n={"M+":e,"d+":this.getDate(),"h+":this.getHours(),"m+":this.getMinutes(),"s+":this.getSeconds(),"q+":Math.floor((this.getMonth()+3)/3),E:["冬","春","夏","秋"][Math.floor(e%12/3)],W:["日","一","二","三","四","五","六"][this.getDay()],S:this.getMilliseconds()},i=t;for(var o in/(y+)/.test(i)&&(i=i.replace(RegExp.$1,(this.getFullYear()+"").substr(4-RegExp.$1.length))),n)new RegExp("("+o+")").test(i)&&(i=i.replace(RegExp.$1,1===RegExp.$1.length?n[o]:("00"+n[o]).substr((""+n[o]).length)));return i},String.prototype.dateFormat=function(t){return new Date(this.replace(/-/g,"/")).format(t)},Array.prototype.last=function(){return this[this.length-1]},String.prototype.last=function(){return this.substr(-1)},String.prototype.lastStr=function(t,e){return this.substr(this.lastIndexOf(t)+!e,this.length)},String.prototype.trimAll=function(){return this.replace(/\s+/g,"")},String.prototype.firstUpperCase=function(){return this[0].toUpperCase()+this.slice(1)},HTMLElement.prototype.getStyle=function(t){return this.currentStyle?this.currentStyle[t]:document.defaultView.getComputedStyle(this,null)[t]},String.prototype.phoneNumberHide=function(){return this.replace(/(\d{3})\d{4}(\d{4})/,"$1****$2")}};window.GLOBAL={init:function(){prototype(),(functions.browser.versions.android||functions.browser.versions.ios<11)&&FastClick.attach(document.body),window.requestAnimationFrame=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||function(t){setTimeout(t,100)};var e=document.documentElement,t="orientationchange"in window?"orientationchange":"resize",n=function(){var t=e.clientWidth;t&&(640<innerWidth?e.style.fontSize="32px":e.style.fontSize=t/18+"px")};document.addEventListener&&(window.addEventListener(t,n,!1),document.addEventListener("DOMContentLoaded",n,!1))}},GLOBAL.init(),window.appjs&&window.appjs.isShowHeadLayout&&window.appjs.isShowHeadLayout(!1),window.isShowHeadLayout&&window.isShowHeadLayout(!1),$(function(){$("header > i").click(function(){window.appjs&&window.appjs.isShowHeadLayout?window.appjs.returnHome():window.isShowHeadLayout?window.returnHome():history.back()})});