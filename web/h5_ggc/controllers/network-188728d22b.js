"use strict";var _extends=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var s in r)Object.prototype.hasOwnProperty.call(r,s)&&(e[s]=r[s])}return e};function _toConsumableArray(e){if(Array.isArray(e)){for(var t=0,r=Array(e.length);t<e.length;t++)r[t]=e[t];return r}return Array.from(e)}window.network={api:{openMachine:"store/store/open-machine"},request:function(e){return new Promise(function(t,r){network.http(_extends({},e,{success:function(e){return t(e)},error:function(e){return r(e)}}))})},requesting:[],requestingCtrl:function(e,t){if("add"===e)this.requesting.push(t);else if("del"===e){var r=this.requesting.indexOf(t);-1<r&&this.requesting.splice(r,1)}},http:function(e){var r=this,s=Object.assign({},{type:"post",url:"",fullUrl:"",dataType:"",data:{},params:{},headers:{},success:0,error:0,complete:0,errorDisabled:!1,successAll:!1,loadingIcon:!0,timeout:1e4,others:{},autoReconnect:!0,reconnect:{status:!1,timeoutReconnectNum:0,interceptors:0}},e),n=function(e,t){var r;(r=functions).log.apply(r,[{title:"http-"+s.type+"-"+e,text:s.url||s.fullUrl,color:t}].concat(_toConsumableArray(Array.prototype.slice.apply(arguments).splice(2,arguments.length))))},o=s.reconnect.status?0:Date.now(),c=s.reconnect.status?s.reconnect.interceptors:axios.interceptors.response.use(function(e){return e},function(e){if(e&&e.response)switch(e.response.status){case 400:e.message="请求错误";break;case 401:e.message="未授权，请登录";break;case 403:e.message="拒绝访问";break;case 404:e.message="请求地址错误: "+(s.url||s.fullUrl);break;case 408:e.message="请求超时";break;case 500:e.message="服务器内部错误";break;case 501:e.message="服务未实现";break;case 502:e.message="网关错误";break;case 503:e.message="服务不可用";break;case 504:e.message="网关超时";break;case 505:e.message="HTTP版本不受支持"}return Promise.reject(e)});s.loadingIcon&&s.reconnect.status,this.requestingCtrl("add",s.url||s.fullUrl),axios(_extends({method:s.type,url:s.fullUrl?s.fullUrl:s.url,headers:s.headers,data:s.data,params:s.params,timeout:s.timeout},e.others)).then(function(e){r.requestingCtrl("del",s.url||s.fullUrl);var t=e.data;n("success","#0000ff",JSON.parse(JSON.stringify(t))),axios.interceptors.request.eject(c),s.successAll?s.success(t):(1===t.code||"00"===t.code||200===t.httpCode?"function"==typeof s.success&&s.success(t):(s.errorDisabled||r.responseErrorDist(t),s.errorDisabled instanceof Array&&!s.errorDisabled.includes(e.data.code)?r.responseErrorDist(t):"function"==typeof s.error&&s.error(t)),s.complete&&s.complete(t))}).catch(function(e){r.requestingCtrl("del",s.url||s.fullUrl);var t=e.toString();t.includes("timeout")&&s.autoReconnect?s.reconnect.timeoutReconnectNum<3?(n("reconnect","#ffa500","接口请求"+s.timeout+"ms超时，第"+(s.reconnect.timeoutReconnectNum+1)+"次发起重新请求"),r.http(Object.assign({},s,{reconnect:{status:!0,timeoutReconnectNum:s.reconnect.timeoutReconnectNum+1,interceptors:c}}))):Date.now()-o<s.timeout?(n("reconnect","#ff0000","检测到接口请求非正常超时，判断可能是网络断开状态，等待3秒后将再次重新发起请求"),setTimeout(function(){r.http(Object.assign({},s,{reconnect:{status:!0,interceptors:c}}))},3e3)):(n("discontinue","#ff0000","接口连续重新请求"+s.reconnect.timeoutReconnectNum+"次超时，停止继续请求"),axios.interceptors.request.eject(c),functions.toast("您的网络不稳定，请检查网络设置"),s.complete&&s.complete(e)):(n("error","#ff0000",t),functions.toast(e.message),s.complete&&s.complete(e))})},responseErrorDist:function(e){switch(!0){case"-100"===e.code:case 415===e.code:case 488===e.code:break;default:functions.toast(e.msg)}}};