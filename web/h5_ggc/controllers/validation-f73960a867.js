"use strict";window.validation={nickname:function(r){return!!r.toString().match(/^[_\-a-zA-Z0-9\u4e00-\u9fa5]{4,20}$/)},name:function(r){return!r.toString().match(/[^a-zA-Z\u4e00-\u9fa5]/g)},nameChinese:function(r){return/^[\u4e00-\u9fa5]{2,6}$/.test(r)},telChina:function(r){return!!r.toString().match(/^[1]([3][0-9]|[4][5-9]|[5][0-9]|66|70|71|[7][3-8]|[8][0-9]|98|99)[0-9]{8}$/)},password:function(r){return!!r.toString().match(/^[a-zA-Z0-9]{6,20}$/)},captchaSMS:function(r){return!!r.toString().match(/^[0-9]{6}$/)},idNumberChina:function(r){var n=/^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/.test(r);if(n&&18===r.length){for(var t=new Array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2),a=new Array(1,0,10,9,8,7,6,5,4,3,2),e=0,u=0;u<17;u++)e+=r.substring(u,u+1)*t[u];var s=e%11,i=isNaN(r.slice(-1))?"X":parseInt(r.slice(-1));n=2===s?"X"===i.toUpperCase():a[s]===i}return n},bankNumberLuhn:function(r){for(var n,t,a=r.substr(0,r.length-1),e=new Array,u=new Array,s=0,i=new Array,h=new Array,o=0,c=new Array,f=0,p=new Array,g=0,d=a.length-1;-1<d;d--)e.push(a.substr(d,1));for(var l=0;l<e.length;l++)(l+1)%2==1?2*e[l]<9?u.push(parseInt(2*e[l])):i.push(parseInt(2*e[l])):p.push(parseInt(e[l]));for(var w=0;w<i.length;w++)h.push(parseInt(i[w]%10)),c.push(parseInt(i[w]/10));for(var A=0;A<u.length;A++)s+=u[A];for(var m=0;m<p.length;m++)g+=p[m];for(var v=0;v<h.length;v++)o+=h[v],f+=c[v];return t=10-((n=s+g+o+f)%10==0?10:n%10),parseInt(r.last())===t}};