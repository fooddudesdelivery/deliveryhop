/*! jQuery v1.11.1 | (c) 2005, 2014 jQuery Foundation, Inc. | jquery.org/license */
!function(a,b){"object"==typeof module&&"object"==typeof module.exports?module.exports=a.document?b(a,!0):function(a){if(!a.document)throw new Error("jQuery requires a window with a document");return b(a)}:b(a)}("undefined"!=typeof window?window:this,function(a,b){var c=[],d=c.slice,e=c.concat,f=c.push,g=c.indexOf,h={},i=h.toString,j=h.hasOwnProperty,k={},l="1.11.1",m=function(a,b){return new m.fn.init(a,b)},n=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,o=/^-ms-/,p=/-([\da-z])/gi,q=function(a,b){return b.toUpperCase()};m.fn=m.prototype={jquery:l,constructor:m,selector:"",length:0,toArray:function(){return d.call(this)},get:function(a){return null!=a?0>a?this[a+this.length]:this[a]:d.call(this)},pushStack:function(a){var b=m.merge(this.constructor(),a);return b.prevObject=this,b.context=this.context,b},each:function(a,b){return m.each(this,a,b)},map:function(a){return this.pushStack(m.map(this,function(b,c){return a.call(b,c,b)}))},slice:function(){return this.pushStack(d.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},eq:function(a){var b=this.length,c=+a+(0>a?b:0);return this.pushStack(c>=0&&b>c?[this[c]]:[])},end:function(){return this.prevObject||this.constructor(null)},push:f,sort:c.sort,splice:c.splice},m.extend=m.fn.extend=function(){var a,b,c,d,e,f,g=arguments[0]||{},h=1,i=arguments.length,j=!1;for("boolean"==typeof g&&(j=g,g=arguments[h]||{},h++),"object"==typeof g||m.isFunction(g)||(g={}),h===i&&(g=this,h--);i>h;h++)if(null!=(e=arguments[h]))for(d in e)a=g[d],c=e[d],g!==c&&(j&&c&&(m.isPlainObject(c)||(b=m.isArray(c)))?(b?(b=!1,f=a&&m.isArray(a)?a:[]):f=a&&m.isPlainObject(a)?a:{},g[d]=m.extend(j,f,c)):void 0!==c&&(g[d]=c));return g},m.extend({expando:"jQuery"+(l+Math.random()).replace(/\D/g,""),isReady:!0,error:function(a){throw new Error(a)},noop:function(){},isFunction:function(a){return"function"===m.type(a)},isArray:Array.isArray||function(a){return"array"===m.type(a)},isWindow:function(a){return null!=a&&a==a.window},isNumeric:function(a){return!m.isArray(a)&&a-parseFloat(a)>=0},isEmptyObject:function(a){var b;for(b in a)return!1;return!0},isPlainObject:function(a){var b;if(!a||"object"!==m.type(a)||a.nodeType||m.isWindow(a))return!1;try{if(a.constructor&&!j.call(a,"constructor")&&!j.call(a.constructor.prototype,"isPrototypeOf"))return!1}catch(c){return!1}if(k.ownLast)for(b in a)return j.call(a,b);for(b in a);return void 0===b||j.call(a,b)},type:function(a){return null==a?a+"":"object"==typeof a||"function"==typeof a?h[i.call(a)]||"object":typeof a},globalEval:function(b){b&&m.trim(b)&&(a.execScript||function(b){a.eval.call(a,b)})(b)},camelCase:function(a){return a.replace(o,"ms-").replace(p,q)},nodeName:function(a,b){return a.nodeName&&a.nodeName.toLowerCase()===b.toLowerCase()},each:function(a,b,c){var d,e=0,f=a.length,g=r(a);if(c){if(g){for(;f>e;e++)if(d=b.apply(a[e],c),d===!1)break}else for(e in a)if(d=b.apply(a[e],c),d===!1)break}else if(g){for(;f>e;e++)if(d=b.call(a[e],e,a[e]),d===!1)break}else for(e in a)if(d=b.call(a[e],e,a[e]),d===!1)break;return a},trim:function(a){return null==a?"":(a+"").replace(n,"")},makeArray:function(a,b){var c=b||[];return null!=a&&(r(Object(a))?m.merge(c,"string"==typeof a?[a]:a):f.call(c,a)),c},inArray:function(a,b,c){var d;if(b){if(g)return g.call(b,a,c);for(d=b.length,c=c?0>c?Math.max(0,d+c):c:0;d>c;c++)if(c in b&&b[c]===a)return c}return-1},merge:function(a,b){var c=+b.length,d=0,e=a.length;while(c>d)a[e++]=b[d++];if(c!==c)while(void 0!==b[d])a[e++]=b[d++];return a.length=e,a},grep:function(a,b,c){for(var d,e=[],f=0,g=a.length,h=!c;g>f;f++)d=!b(a[f],f),d!==h&&e.push(a[f]);return e},map:function(a,b,c){var d,f=0,g=a.length,h=r(a),i=[];if(h)for(;g>f;f++)d=b(a[f],f,c),null!=d&&i.push(d);else for(f in a)d=b(a[f],f,c),null!=d&&i.push(d);return e.apply([],i)},guid:1,proxy:function(a,b){var c,e,f;return"string"==typeof b&&(f=a[b],b=a,a=f),m.isFunction(a)?(c=d.call(arguments,2),e=function(){return a.apply(b||this,c.concat(d.call(arguments)))},e.guid=a.guid=a.guid||m.guid++,e):void 0},now:function(){return+new Date},support:k}),m.each("Boolean Number String Function Array Date RegExp Object Error".split(" "),function(a,b){h["[object "+b+"]"]=b.toLowerCase()});function r(a){var b=a.length,c=m.type(a);return"function"===c||m.isWindow(a)?!1:1===a.nodeType&&b?!0:"array"===c||0===b||"number"==typeof b&&b>0&&b-1 in a}var s=function(a){var b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u="sizzle"+-new Date,v=a.document,w=0,x=0,y=gb(),z=gb(),A=gb(),B=function(a,b){return a===b&&(l=!0),0},C="undefined",D=1<<31,E={}.hasOwnProperty,F=[],G=F.pop,H=F.push,I=F.push,J=F.slice,K=F.indexOf||function(a){for(var b=0,c=this.length;c>b;b++)if(this[b]===a)return b;return-1},L="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",M="[\\x20\\t\\r\\n\\f]",N="(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",O=N.replace("w","w#"),P="\\["+M+"*("+N+")(?:"+M+"*([*^$|!~]?=)"+M+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+O+"))|)"+M+"*\\]",Q=":("+N+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+P+")*)|.*)\\)|)",R=new RegExp("^"+M+"+|((?:^|[^\\\\])(?:\\\\.)*)"+M+"+$","g"),S=new RegExp("^"+M+"*,"+M+"*"),T=new RegExp("^"+M+"*([>+~]|"+M+")"+M+"*"),U=new RegExp("="+M+"*([^\\]'\"]*?)"+M+"*\\]","g"),V=new RegExp(Q),W=new RegExp("^"+O+"$"),X={ID:new RegExp("^#("+N+")"),CLASS:new RegExp("^\\.("+N+")"),TAG:new RegExp("^("+N.replace("w","w*")+")"),ATTR:new RegExp("^"+P),PSEUDO:new RegExp("^"+Q),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+M+"*(even|odd|(([+-]|)(\\d*)n|)"+M+"*(?:([+-]|)"+M+"*(\\d+)|))"+M+"*\\)|)","i"),bool:new RegExp("^(?:"+L+")$","i"),needsContext:new RegExp("^"+M+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+M+"*((?:-\\d)?\\d*)"+M+"*\\)|)(?=[^-]|$)","i")},Y=/^(?:input|select|textarea|button)$/i,Z=/^h\d$/i,$=/^[^{]+\{\s*\[native \w/,_=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,ab=/[+~]/,bb=/'|\\/g,cb=new RegExp("\\\\([\\da-f]{1,6}"+M+"?|("+M+")|.)","ig"),db=function(a,b,c){var d="0x"+b-65536;return d!==d||c?b:0>d?String.fromCharCode(d+65536):String.fromCharCode(d>>10|55296,1023&d|56320)};try{I.apply(F=J.call(v.childNodes),v.childNodes),F[v.childNodes.length].nodeType}catch(eb){I={apply:F.length?function(a,b){H.apply(a,J.call(b))}:function(a,b){var c=a.length,d=0;while(a[c++]=b[d++]);a.length=c-1}}}function fb(a,b,d,e){var f,h,j,k,l,o,r,s,w,x;if((b?b.ownerDocument||b:v)!==n&&m(b),b=b||n,d=d||[],!a||"string"!=typeof a)return d;if(1!==(k=b.nodeType)&&9!==k)return[];if(p&&!e){if(f=_.exec(a))if(j=f[1]){if(9===k){if(h=b.getElementById(j),!h||!h.parentNode)return d;if(h.id===j)return d.push(h),d}else if(b.ownerDocument&&(h=b.ownerDocument.getElementById(j))&&t(b,h)&&h.id===j)return d.push(h),d}else{if(f[2])return I.apply(d,b.getElementsByTagName(a)),d;if((j=f[3])&&c.getElementsByClassName&&b.getElementsByClassName)return I.apply(d,b.getElementsByClassName(j)),d}if(c.qsa&&(!q||!q.test(a))){if(s=r=u,w=b,x=9===k&&a,1===k&&"object"!==b.nodeName.toLowerCase()){o=g(a),(r=b.getAttribute("id"))?s=r.replace(bb,"\\$&"):b.setAttribute("id",s),s="[id='"+s+"'] ",l=o.length;while(l--)o[l]=s+qb(o[l]);w=ab.test(a)&&ob(b.parentNode)||b,x=o.join(",")}if(x)try{return I.apply(d,w.querySelectorAll(x)),d}catch(y){}finally{r||b.removeAttribute("id")}}}return i(a.replace(R,"$1"),b,d,e)}function gb(){var a=[];function b(c,e){return a.push(c+" ")>d.cacheLength&&delete b[a.shift()],b[c+" "]=e}return b}function hb(a){return a[u]=!0,a}function ib(a){var b=n.createElement("div");try{return!!a(b)}catch(c){return!1}finally{b.parentNode&&b.parentNode.removeChild(b),b=null}}function jb(a,b){var c=a.split("|"),e=a.length;while(e--)d.attrHandle[c[e]]=b}function kb(a,b){var c=b&&a,d=c&&1===a.nodeType&&1===b.nodeType&&(~b.sourceIndex||D)-(~a.sourceIndex||D);if(d)return d;if(c)while(c=c.nextSibling)if(c===b)return-1;return a?1:-1}function lb(a){return function(b){var c=b.nodeName.toLowerCase();return"input"===c&&b.type===a}}function mb(a){return function(b){var c=b.nodeName.toLowerCase();return("input"===c||"button"===c)&&b.type===a}}function nb(a){return hb(function(b){return b=+b,hb(function(c,d){var e,f=a([],c.length,b),g=f.length;while(g--)c[e=f[g]]&&(c[e]=!(d[e]=c[e]))})})}function ob(a){return a&&typeof a.getElementsByTagName!==C&&a}c=fb.support={},f=fb.isXML=function(a){var b=a&&(a.ownerDocument||a).documentElement;return b?"HTML"!==b.nodeName:!1},m=fb.setDocument=function(a){var b,e=a?a.ownerDocument||a:v,g=e.defaultView;return e!==n&&9===e.nodeType&&e.documentElement?(n=e,o=e.documentElement,p=!f(e),g&&g!==g.top&&(g.addEventListener?g.addEventListener("unload",function(){m()},!1):g.attachEvent&&g.attachEvent("onunload",function(){m()})),c.attributes=ib(function(a){return a.className="i",!a.getAttribute("className")}),c.getElementsByTagName=ib(function(a){return a.appendChild(e.createComment("")),!a.getElementsByTagName("*").length}),c.getElementsByClassName=$.test(e.getElementsByClassName)&&ib(function(a){return a.innerHTML="<div class='a'></div><div class='a i'></div>",a.firstChild.className="i",2===a.getElementsByClassName("i").length}),c.getById=ib(function(a){return o.appendChild(a).id=u,!e.getElementsByName||!e.getElementsByName(u).length}),c.getById?(d.find.ID=function(a,b){if(typeof b.getElementById!==C&&p){var c=b.getElementById(a);return c&&c.parentNode?[c]:[]}},d.filter.ID=function(a){var b=a.replace(cb,db);return function(a){return a.getAttribute("id")===b}}):(delete d.find.ID,d.filter.ID=function(a){var b=a.replace(cb,db);return function(a){var c=typeof a.getAttributeNode!==C&&a.getAttributeNode("id");return c&&c.value===b}}),d.find.TAG=c.getElementsByTagName?function(a,b){return typeof b.getElementsByTagName!==C?b.getElementsByTagName(a):void 0}:function(a,b){var c,d=[],e=0,f=b.getElementsByTagName(a);if("*"===a){while(c=f[e++])1===c.nodeType&&d.push(c);return d}return f},d.find.CLASS=c.getElementsByClassName&&function(a,b){return typeof b.getElementsByClassName!==C&&p?b.getElementsByClassName(a):void 0},r=[],q=[],(c.qsa=$.test(e.querySelectorAll))&&(ib(function(a){a.innerHTML="<select msallowclip=''><option selected=''></option></select>",a.querySelectorAll("[msallowclip^='']").length&&q.push("[*^$]="+M+"*(?:''|\"\")"),a.querySelectorAll("[selected]").length||q.push("\\["+M+"*(?:value|"+L+")"),a.querySelectorAll(":checked").length||q.push(":checked")}),ib(function(a){var b=e.createElement("input");b.setAttribute("type","hidden"),a.appendChild(b).setAttribute("name","D"),a.querySelectorAll("[name=d]").length&&q.push("name"+M+"*[*^$|!~]?="),a.querySelectorAll(":enabled").length||q.push(":enabled",":disabled"),a.querySelectorAll("*,:x"),q.push(",.*:")})),(c.matchesSelector=$.test(s=o.matches||o.webkitMatchesSelector||o.mozMatchesSelector||o.oMatchesSelector||o.msMatchesSelector))&&ib(function(a){c.disconnectedMatch=s.call(a,"div"),s.call(a,"[s!='']:x"),r.push("!=",Q)}),q=q.length&&new RegExp(q.join("|")),r=r.length&&new RegExp(r.join("|")),b=$.test(o.compareDocumentPosition),t=b||$.test(o.contains)?function(a,b){var c=9===a.nodeType?a.documentElement:a,d=b&&b.parentNode;return a===d||!(!d||1!==d.nodeType||!(c.contains?c.contains(d):a.compareDocumentPosition&&16&a.compareDocumentPosition(d)))}:function(a,b){if(b)while(b=b.parentNode)if(b===a)return!0;return!1},B=b?function(a,b){if(a===b)return l=!0,0;var d=!a.compareDocumentPosition-!b.compareDocumentPosition;return d?d:(d=(a.ownerDocument||a)===(b.ownerDocument||b)?a.compareDocumentPosition(b):1,1&d||!c.sortDetached&&b.compareDocumentPosition(a)===d?a===e||a.ownerDocument===v&&t(v,a)?-1:b===e||b.ownerDocument===v&&t(v,b)?1:k?K.call(k,a)-K.call(k,b):0:4&d?-1:1)}:function(a,b){if(a===b)return l=!0,0;var c,d=0,f=a.parentNode,g=b.parentNode,h=[a],i=[b];if(!f||!g)return a===e?-1:b===e?1:f?-1:g?1:k?K.call(k,a)-K.call(k,b):0;if(f===g)return kb(a,b);c=a;while(c=c.parentNode)h.unshift(c);c=b;while(c=c.parentNode)i.unshift(c);while(h[d]===i[d])d++;return d?kb(h[d],i[d]):h[d]===v?-1:i[d]===v?1:0},e):n},fb.matches=function(a,b){return fb(a,null,null,b)},fb.matchesSelector=function(a,b){if((a.ownerDocument||a)!==n&&m(a),b=b.replace(U,"='$1']"),!(!c.matchesSelector||!p||r&&r.test(b)||q&&q.test(b)))try{var d=s.call(a,b);if(d||c.disconnectedMatch||a.document&&11!==a.document.nodeType)return d}catch(e){}return fb(b,n,null,[a]).length>0},fb.contains=function(a,b){return(a.ownerDocument||a)!==n&&m(a),t(a,b)},fb.attr=function(a,b){(a.ownerDocument||a)!==n&&m(a);var e=d.attrHandle[b.toLowerCase()],f=e&&E.call(d.attrHandle,b.toLowerCase())?e(a,b,!p):void 0;return void 0!==f?f:c.attributes||!p?a.getAttribute(b):(f=a.getAttributeNode(b))&&f.specified?f.value:null},fb.error=function(a){throw new Error("Syntax error, unrecognized expression: "+a)},fb.uniqueSort=function(a){var b,d=[],e=0,f=0;if(l=!c.detectDuplicates,k=!c.sortStable&&a.slice(0),a.sort(B),l){while(b=a[f++])b===a[f]&&(e=d.push(f));while(e--)a.splice(d[e],1)}return k=null,a},e=fb.getText=function(a){var b,c="",d=0,f=a.nodeType;if(f){if(1===f||9===f||11===f){if("string"==typeof a.textContent)return a.textContent;for(a=a.firstChild;a;a=a.nextSibling)c+=e(a)}else if(3===f||4===f)return a.nodeValue}else while(b=a[d++])c+=e(b);return c},d=fb.selectors={cacheLength:50,createPseudo:hb,match:X,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(a){return a[1]=a[1].replace(cb,db),a[3]=(a[3]||a[4]||a[5]||"").replace(cb,db),"~="===a[2]&&(a[3]=" "+a[3]+" "),a.slice(0,4)},CHILD:function(a){return a[1]=a[1].toLowerCase(),"nth"===a[1].slice(0,3)?(a[3]||fb.error(a[0]),a[4]=+(a[4]?a[5]+(a[6]||1):2*("even"===a[3]||"odd"===a[3])),a[5]=+(a[7]+a[8]||"odd"===a[3])):a[3]&&fb.error(a[0]),a},PSEUDO:function(a){var b,c=!a[6]&&a[2];return X.CHILD.test(a[0])?null:(a[3]?a[2]=a[4]||a[5]||"":c&&V.test(c)&&(b=g(c,!0))&&(b=c.indexOf(")",c.length-b)-c.length)&&(a[0]=a[0].slice(0,b),a[2]=c.slice(0,b)),a.slice(0,3))}},filter:{TAG:function(a){var b=a.replace(cb,db).toLowerCase();return"*"===a?function(){return!0}:function(a){return a.nodeName&&a.nodeName.toLowerCase()===b}},CLASS:function(a){var b=y[a+" "];return b||(b=new RegExp("(^|"+M+")"+a+"("+M+"|$)"))&&y(a,function(a){return b.test("string"==typeof a.className&&a.className||typeof a.getAttribute!==C&&a.getAttribute("class")||"")})},ATTR:function(a,b,c){return function(d){var e=fb.attr(d,a);return null==e?"!="===b:b?(e+="","="===b?e===c:"!="===b?e!==c:"^="===b?c&&0===e.indexOf(c):"*="===b?c&&e.indexOf(c)>-1:"$="===b?c&&e.slice(-c.length)===c:"~="===b?(" "+e+" ").indexOf(c)>-1:"|="===b?e===c||e.slice(0,c.length+1)===c+"-":!1):!0}},CHILD:function(a,b,c,d,e){var f="nth"!==a.slice(0,3),g="last"!==a.slice(-4),h="of-type"===b;return 1===d&&0===e?function(a){return!!a.parentNode}:function(b,c,i){var j,k,l,m,n,o,p=f!==g?"nextSibling":"previousSibling",q=b.parentNode,r=h&&b.nodeName.toLowerCase(),s=!i&&!h;if(q){if(f){while(p){l=b;while(l=l[p])if(h?l.nodeName.toLowerCase()===r:1===l.nodeType)return!1;o=p="only"===a&&!o&&"nextSibling"}return!0}if(o=[g?q.firstChild:q.lastChild],g&&s){k=q[u]||(q[u]={}),j=k[a]||[],n=j[0]===w&&j[1],m=j[0]===w&&j[2],l=n&&q.childNodes[n];while(l=++n&&l&&l[p]||(m=n=0)||o.pop())if(1===l.nodeType&&++m&&l===b){k[a]=[w,n,m];break}}else if(s&&(j=(b[u]||(b[u]={}))[a])&&j[0]===w)m=j[1];else while(l=++n&&l&&l[p]||(m=n=0)||o.pop())if((h?l.nodeName.toLowerCase()===r:1===l.nodeType)&&++m&&(s&&((l[u]||(l[u]={}))[a]=[w,m]),l===b))break;return m-=e,m===d||m%d===0&&m/d>=0}}},PSEUDO:function(a,b){var c,e=d.pseudos[a]||d.setFilters[a.toLowerCase()]||fb.error("unsupported pseudo: "+a);return e[u]?e(b):e.length>1?(c=[a,a,"",b],d.setFilters.hasOwnProperty(a.toLowerCase())?hb(function(a,c){var d,f=e(a,b),g=f.length;while(g--)d=K.call(a,f[g]),a[d]=!(c[d]=f[g])}):function(a){return e(a,0,c)}):e}},pseudos:{not:hb(function(a){var b=[],c=[],d=h(a.replace(R,"$1"));return d[u]?hb(function(a,b,c,e){var f,g=d(a,null,e,[]),h=a.length;while(h--)(f=g[h])&&(a[h]=!(b[h]=f))}):function(a,e,f){return b[0]=a,d(b,null,f,c),!c.pop()}}),has:hb(function(a){return function(b){return fb(a,b).length>0}}),contains:hb(function(a){return function(b){return(b.textContent||b.innerText||e(b)).indexOf(a)>-1}}),lang:hb(function(a){return W.test(a||"")||fb.error("unsupported lang: "+a),a=a.replace(cb,db).toLowerCase(),function(b){var c;do if(c=p?b.lang:b.getAttribute("xml:lang")||b.getAttribute("lang"))return c=c.toLowerCase(),c===a||0===c.indexOf(a+"-");while((b=b.parentNode)&&1===b.nodeType);return!1}}),target:function(b){var c=a.location&&a.location.hash;return c&&c.slice(1)===b.id},root:function(a){return a===o},focus:function(a){return a===n.activeElement&&(!n.hasFocus||n.hasFocus())&&!!(a.type||a.href||~a.tabIndex)},enabled:function(a){return a.disabled===!1},disabled:function(a){return a.disabled===!0},checked:function(a){var b=a.nodeName.toLowerCase();return"input"===b&&!!a.checked||"option"===b&&!!a.selected},selected:function(a){return a.parentNode&&a.parentNode.selectedIndex,a.selected===!0},empty:function(a){for(a=a.firstChild;a;a=a.nextSibling)if(a.nodeType<6)return!1;return!0},parent:function(a){return!d.pseudos.empty(a)},header:function(a){return Z.test(a.nodeName)},input:function(a){return Y.test(a.nodeName)},button:function(a){var b=a.nodeName.toLowerCase();return"input"===b&&"button"===a.type||"button"===b},text:function(a){var b;return"input"===a.nodeName.toLowerCase()&&"text"===a.type&&(null==(b=a.getAttribute("type"))||"text"===b.toLowerCase())},first:nb(function(){return[0]}),last:nb(function(a,b){return[b-1]}),eq:nb(function(a,b,c){return[0>c?c+b:c]}),even:nb(function(a,b){for(var c=0;b>c;c+=2)a.push(c);return a}),odd:nb(function(a,b){for(var c=1;b>c;c+=2)a.push(c);return a}),lt:nb(function(a,b,c){for(var d=0>c?c+b:c;--d>=0;)a.push(d);return a}),gt:nb(function(a,b,c){for(var d=0>c?c+b:c;++d<b;)a.push(d);return a})}},d.pseudos.nth=d.pseudos.eq;for(b in{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})d.pseudos[b]=lb(b);for(b in{submit:!0,reset:!0})d.pseudos[b]=mb(b);function pb(){}pb.prototype=d.filters=d.pseudos,d.setFilters=new pb,g=fb.tokenize=function(a,b){var c,e,f,g,h,i,j,k=z[a+" "];if(k)return b?0:k.slice(0);h=a,i=[],j=d.preFilter;while(h){(!c||(e=S.exec(h)))&&(e&&(h=h.slice(e[0].length)||h),i.push(f=[])),c=!1,(e=T.exec(h))&&(c=e.shift(),f.push({value:c,type:e[0].replace(R," ")}),h=h.slice(c.length));for(g in d.filter)!(e=X[g].exec(h))||j[g]&&!(e=j[g](e))||(c=e.shift(),f.push({value:c,type:g,matches:e}),h=h.slice(c.length));if(!c)break}return b?h.length:h?fb.error(a):z(a,i).slice(0)};function qb(a){for(var b=0,c=a.length,d="";c>b;b++)d+=a[b].value;return d}function rb(a,b,c){var d=b.dir,e=c&&"parentNode"===d,f=x++;return b.first?function(b,c,f){while(b=b[d])if(1===b.nodeType||e)return a(b,c,f)}:function(b,c,g){var h,i,j=[w,f];if(g){while(b=b[d])if((1===b.nodeType||e)&&a(b,c,g))return!0}else while(b=b[d])if(1===b.nodeType||e){if(i=b[u]||(b[u]={}),(h=i[d])&&h[0]===w&&h[1]===f)return j[2]=h[2];if(i[d]=j,j[2]=a(b,c,g))return!0}}}function sb(a){return a.length>1?function(b,c,d){var e=a.length;while(e--)if(!a[e](b,c,d))return!1;return!0}:a[0]}function tb(a,b,c){for(var d=0,e=b.length;e>d;d++)fb(a,b[d],c);return c}function ub(a,b,c,d,e){for(var f,g=[],h=0,i=a.length,j=null!=b;i>h;h++)(f=a[h])&&(!c||c(f,d,e))&&(g.push(f),j&&b.push(h));return g}function vb(a,b,c,d,e,f){return d&&!d[u]&&(d=vb(d)),e&&!e[u]&&(e=vb(e,f)),hb(function(f,g,h,i){var j,k,l,m=[],n=[],o=g.length,p=f||tb(b||"*",h.nodeType?[h]:h,[]),q=!a||!f&&b?p:ub(p,m,a,h,i),r=c?e||(f?a:o||d)?[]:g:q;if(c&&c(q,r,h,i),d){j=ub(r,n),d(j,[],h,i),k=j.length;while(k--)(l=j[k])&&(r[n[k]]=!(q[n[k]]=l))}if(f){if(e||a){if(e){j=[],k=r.length;while(k--)(l=r[k])&&j.push(q[k]=l);e(null,r=[],j,i)}k=r.length;while(k--)(l=r[k])&&(j=e?K.call(f,l):m[k])>-1&&(f[j]=!(g[j]=l))}}else r=ub(r===g?r.splice(o,r.length):r),e?e(null,g,r,i):I.apply(g,r)})}function wb(a){for(var b,c,e,f=a.length,g=d.relative[a[0].type],h=g||d.relative[" "],i=g?1:0,k=rb(function(a){return a===b},h,!0),l=rb(function(a){return K.call(b,a)>-1},h,!0),m=[function(a,c,d){return!g&&(d||c!==j)||((b=c).nodeType?k(a,c,d):l(a,c,d))}];f>i;i++)if(c=d.relative[a[i].type])m=[rb(sb(m),c)];else{if(c=d.filter[a[i].type].apply(null,a[i].matches),c[u]){for(e=++i;f>e;e++)if(d.relative[a[e].type])break;return vb(i>1&&sb(m),i>1&&qb(a.slice(0,i-1).concat({value:" "===a[i-2].type?"*":""})).replace(R,"$1"),c,e>i&&wb(a.slice(i,e)),f>e&&wb(a=a.slice(e)),f>e&&qb(a))}m.push(c)}return sb(m)}function xb(a,b){var c=b.length>0,e=a.length>0,f=function(f,g,h,i,k){var l,m,o,p=0,q="0",r=f&&[],s=[],t=j,u=f||e&&d.find.TAG("*",k),v=w+=null==t?1:Math.random()||.1,x=u.length;for(k&&(j=g!==n&&g);q!==x&&null!=(l=u[q]);q++){if(e&&l){m=0;while(o=a[m++])if(o(l,g,h)){i.push(l);break}k&&(w=v)}c&&((l=!o&&l)&&p--,f&&r.push(l))}if(p+=q,c&&q!==p){m=0;while(o=b[m++])o(r,s,g,h);if(f){if(p>0)while(q--)r[q]||s[q]||(s[q]=G.call(i));s=ub(s)}I.apply(i,s),k&&!f&&s.length>0&&p+b.length>1&&fb.uniqueSort(i)}return k&&(w=v,j=t),r};return c?hb(f):f}return h=fb.compile=function(a,b){var c,d=[],e=[],f=A[a+" "];if(!f){b||(b=g(a)),c=b.length;while(c--)f=wb(b[c]),f[u]?d.push(f):e.push(f);f=A(a,xb(e,d)),f.selector=a}return f},i=fb.select=function(a,b,e,f){var i,j,k,l,m,n="function"==typeof a&&a,o=!f&&g(a=n.selector||a);if(e=e||[],1===o.length){if(j=o[0]=o[0].slice(0),j.length>2&&"ID"===(k=j[0]).type&&c.getById&&9===b.nodeType&&p&&d.relative[j[1].type]){if(b=(d.find.ID(k.matches[0].replace(cb,db),b)||[])[0],!b)return e;n&&(b=b.parentNode),a=a.slice(j.shift().value.length)}i=X.needsContext.test(a)?0:j.length;while(i--){if(k=j[i],d.relative[l=k.type])break;if((m=d.find[l])&&(f=m(k.matches[0].replace(cb,db),ab.test(j[0].type)&&ob(b.parentNode)||b))){if(j.splice(i,1),a=f.length&&qb(j),!a)return I.apply(e,f),e;break}}}return(n||h(a,o))(f,b,!p,e,ab.test(a)&&ob(b.parentNode)||b),e},c.sortStable=u.split("").sort(B).join("")===u,c.detectDuplicates=!!l,m(),c.sortDetached=ib(function(a){return 1&a.compareDocumentPosition(n.createElement("div"))}),ib(function(a){return a.innerHTML="<a href='#'></a>","#"===a.firstChild.getAttribute("href")})||jb("type|href|height|width",function(a,b,c){return c?void 0:a.getAttribute(b,"type"===b.toLowerCase()?1:2)}),c.attributes&&ib(function(a){return a.innerHTML="<input/>",a.firstChild.setAttribute("value",""),""===a.firstChild.getAttribute("value")})||jb("value",function(a,b,c){return c||"input"!==a.nodeName.toLowerCase()?void 0:a.defaultValue}),ib(function(a){return null==a.getAttribute("disabled")})||jb(L,function(a,b,c){var d;return c?void 0:a[b]===!0?b.toLowerCase():(d=a.getAttributeNode(b))&&d.specified?d.value:null}),fb}(a);m.find=s,m.expr=s.selectors,m.expr[":"]=m.expr.pseudos,m.unique=s.uniqueSort,m.text=s.getText,m.isXMLDoc=s.isXML,m.contains=s.contains;var t=m.expr.match.needsContext,u=/^<(\w+)\s*\/?>(?:<\/\1>|)$/,v=/^.[^:#\[\.,]*$/;function w(a,b,c){if(m.isFunction(b))return m.grep(a,function(a,d){return!!b.call(a,d,a)!==c});if(b.nodeType)return m.grep(a,function(a){return a===b!==c});if("string"==typeof b){if(v.test(b))return m.filter(b,a,c);b=m.filter(b,a)}return m.grep(a,function(a){return m.inArray(a,b)>=0!==c})}m.filter=function(a,b,c){var d=b[0];return c&&(a=":not("+a+")"),1===b.length&&1===d.nodeType?m.find.matchesSelector(d,a)?[d]:[]:m.find.matches(a,m.grep(b,function(a){return 1===a.nodeType}))},m.fn.extend({find:function(a){var b,c=[],d=this,e=d.length;if("string"!=typeof a)return this.pushStack(m(a).filter(function(){for(b=0;e>b;b++)if(m.contains(d[b],this))return!0}));for(b=0;e>b;b++)m.find(a,d[b],c);return c=this.pushStack(e>1?m.unique(c):c),c.selector=this.selector?this.selector+" "+a:a,c},filter:function(a){return this.pushStack(w(this,a||[],!1))},not:function(a){return this.pushStack(w(this,a||[],!0))},is:function(a){return!!w(this,"string"==typeof a&&t.test(a)?m(a):a||[],!1).length}});var x,y=a.document,z=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,A=m.fn.init=function(a,b){var c,d;if(!a)return this;if("string"==typeof a){if(c="<"===a.charAt(0)&&">"===a.charAt(a.length-1)&&a.length>=3?[null,a,null]:z.exec(a),!c||!c[1]&&b)return!b||b.jquery?(b||x).find(a):this.constructor(b).find(a);if(c[1]){if(b=b instanceof m?b[0]:b,m.merge(this,m.parseHTML(c[1],b&&b.nodeType?b.ownerDocument||b:y,!0)),u.test(c[1])&&m.isPlainObject(b))for(c in b)m.isFunction(this[c])?this[c](b[c]):this.attr(c,b[c]);return this}if(d=y.getElementById(c[2]),d&&d.parentNode){if(d.id!==c[2])return x.find(a);this.length=1,this[0]=d}return this.context=y,this.selector=a,this}return a.nodeType?(this.context=this[0]=a,this.length=1,this):m.isFunction(a)?"undefined"!=typeof x.ready?x.ready(a):a(m):(void 0!==a.selector&&(this.selector=a.selector,this.context=a.context),m.makeArray(a,this))};A.prototype=m.fn,x=m(y);var B=/^(?:parents|prev(?:Until|All))/,C={children:!0,contents:!0,next:!0,prev:!0};m.extend({dir:function(a,b,c){var d=[],e=a[b];while(e&&9!==e.nodeType&&(void 0===c||1!==e.nodeType||!m(e).is(c)))1===e.nodeType&&d.push(e),e=e[b];return d},sibling:function(a,b){for(var c=[];a;a=a.nextSibling)1===a.nodeType&&a!==b&&c.push(a);return c}}),m.fn.extend({has:function(a){var b,c=m(a,this),d=c.length;return this.filter(function(){for(b=0;d>b;b++)if(m.contains(this,c[b]))return!0})},closest:function(a,b){for(var c,d=0,e=this.length,f=[],g=t.test(a)||"string"!=typeof a?m(a,b||this.context):0;e>d;d++)for(c=this[d];c&&c!==b;c=c.parentNode)if(c.nodeType<11&&(g?g.index(c)>-1:1===c.nodeType&&m.find.matchesSelector(c,a))){f.push(c);break}return this.pushStack(f.length>1?m.unique(f):f)},index:function(a){return a?"string"==typeof a?m.inArray(this[0],m(a)):m.inArray(a.jquery?a[0]:a,this):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(a,b){return this.pushStack(m.unique(m.merge(this.get(),m(a,b))))},addBack:function(a){return this.add(null==a?this.prevObject:this.prevObject.filter(a))}});function D(a,b){do a=a[b];while(a&&1!==a.nodeType);return a}m.each({parent:function(a){var b=a.parentNode;return b&&11!==b.nodeType?b:null},parents:function(a){return m.dir(a,"parentNode")},parentsUntil:function(a,b,c){return m.dir(a,"parentNode",c)},next:function(a){return D(a,"nextSibling")},prev:function(a){return D(a,"previousSibling")},nextAll:function(a){return m.dir(a,"nextSibling")},prevAll:function(a){return m.dir(a,"previousSibling")},nextUntil:function(a,b,c){return m.dir(a,"nextSibling",c)},prevUntil:function(a,b,c){return m.dir(a,"previousSibling",c)},siblings:function(a){return m.sibling((a.parentNode||{}).firstChild,a)},children:function(a){return m.sibling(a.firstChild)},contents:function(a){return m.nodeName(a,"iframe")?a.contentDocument||a.contentWindow.document:m.merge([],a.childNodes)}},function(a,b){m.fn[a]=function(c,d){var e=m.map(this,b,c);return"Until"!==a.slice(-5)&&(d=c),d&&"string"==typeof d&&(e=m.filter(d,e)),this.length>1&&(C[a]||(e=m.unique(e)),B.test(a)&&(e=e.reverse())),this.pushStack(e)}});var E=/\S+/g,F={};function G(a){var b=F[a]={};return m.each(a.match(E)||[],function(a,c){b[c]=!0}),b}m.Callbacks=function(a){a="string"==typeof a?F[a]||G(a):m.extend({},a);var b,c,d,e,f,g,h=[],i=!a.once&&[],j=function(l){for(c=a.memory&&l,d=!0,f=g||0,g=0,e=h.length,b=!0;h&&e>f;f++)if(h[f].apply(l[0],l[1])===!1&&a.stopOnFalse){c=!1;break}b=!1,h&&(i?i.length&&j(i.shift()):c?h=[]:k.disable())},k={add:function(){if(h){var d=h.length;!function f(b){m.each(b,function(b,c){var d=m.type(c);"function"===d?a.unique&&k.has(c)||h.push(c):c&&c.length&&"string"!==d&&f(c)})}(arguments),b?e=h.length:c&&(g=d,j(c))}return this},remove:function(){return h&&m.each(arguments,function(a,c){var d;while((d=m.inArray(c,h,d))>-1)h.splice(d,1),b&&(e>=d&&e--,f>=d&&f--)}),this},has:function(a){return a?m.inArray(a,h)>-1:!(!h||!h.length)},empty:function(){return h=[],e=0,this},disable:function(){return h=i=c=void 0,this},disabled:function(){return!h},lock:function(){return i=void 0,c||k.disable(),this},locked:function(){return!i},fireWith:function(a,c){return!h||d&&!i||(c=c||[],c=[a,c.slice?c.slice():c],b?i.push(c):j(c)),this},fire:function(){return k.fireWith(this,arguments),this},fired:function(){return!!d}};return k},m.extend({Deferred:function(a){var b=[["resolve","done",m.Callbacks("once memory"),"resolved"],["reject","fail",m.Callbacks("once memory"),"rejected"],["notify","progress",m.Callbacks("memory")]],c="pending",d={state:function(){return c},always:function(){return e.done(arguments).fail(arguments),this},then:function(){var a=arguments;return m.Deferred(function(c){m.each(b,function(b,f){var g=m.isFunction(a[b])&&a[b];e[f[1]](function(){var a=g&&g.apply(this,arguments);a&&m.isFunction(a.promise)?a.promise().done(c.resolve).fail(c.reject).progress(c.notify):c[f[0]+"With"](this===d?c.promise():this,g?[a]:arguments)})}),a=null}).promise()},promise:function(a){return null!=a?m.extend(a,d):d}},e={};return d.pipe=d.then,m.each(b,function(a,f){var g=f[2],h=f[3];d[f[1]]=g.add,h&&g.add(function(){c=h},b[1^a][2].disable,b[2][2].lock),e[f[0]]=function(){return e[f[0]+"With"](this===e?d:this,arguments),this},e[f[0]+"With"]=g.fireWith}),d.promise(e),a&&a.call(e,e),e},when:function(a){var b=0,c=d.call(arguments),e=c.length,f=1!==e||a&&m.isFunction(a.promise)?e:0,g=1===f?a:m.Deferred(),h=function(a,b,c){return function(e){b[a]=this,c[a]=arguments.length>1?d.call(arguments):e,c===i?g.notifyWith(b,c):--f||g.resolveWith(b,c)}},i,j,k;if(e>1)for(i=new Array(e),j=new Array(e),k=new Array(e);e>b;b++)c[b]&&m.isFunction(c[b].promise)?c[b].promise().done(h(b,k,c)).fail(g.reject).progress(h(b,j,i)):--f;return f||g.resolveWith(k,c),g.promise()}});var H;m.fn.ready=function(a){return m.ready.promise().done(a),this},m.extend({isReady:!1,readyWait:1,holdReady:function(a){a?m.readyWait++:m.ready(!0)},ready:function(a){if(a===!0?!--m.readyWait:!m.isReady){if(!y.body)return setTimeout(m.ready);m.isReady=!0,a!==!0&&--m.readyWait>0||(H.resolveWith(y,[m]),m.fn.triggerHandler&&(m(y).triggerHandler("ready"),m(y).off("ready")))}}});function I(){y.addEventListener?(y.removeEventListener("DOMContentLoaded",J,!1),a.removeEventListener("load",J,!1)):(y.detachEvent("onreadystatechange",J),a.detachEvent("onload",J))}function J(){(y.addEventListener||"load"===event.type||"complete"===y.readyState)&&(I(),m.ready())}m.ready.promise=function(b){if(!H)if(H=m.Deferred(),"complete"===y.readyState)setTimeout(m.ready);else if(y.addEventListener)y.addEventListener("DOMContentLoaded",J,!1),a.addEventListener("load",J,!1);else{y.attachEvent("onreadystatechange",J),a.attachEvent("onload",J);var c=!1;try{c=null==a.frameElement&&y.documentElement}catch(d){}c&&c.doScroll&&!function e(){if(!m.isReady){try{c.doScroll("left")}catch(a){return setTimeout(e,50)}I(),m.ready()}}()}return H.promise(b)};var K="undefined",L;for(L in m(k))break;k.ownLast="0"!==L,k.inlineBlockNeedsLayout=!1,m(function(){var a,b,c,d;c=y.getElementsByTagName("body")[0],c&&c.style&&(b=y.createElement("div"),d=y.createElement("div"),d.style.cssText="position:absolute;border:0;width:0;height:0;top:0;left:-9999px",c.appendChild(d).appendChild(b),typeof b.style.zoom!==K&&(b.style.cssText="display:inline;margin:0;border:0;padding:1px;width:1px;zoom:1",k.inlineBlockNeedsLayout=a=3===b.offsetWidth,a&&(c.style.zoom=1)),c.removeChild(d))}),function(){var a=y.createElement("div");if(null==k.deleteExpando){k.deleteExpando=!0;try{delete a.test}catch(b){k.deleteExpando=!1}}a=null}(),m.acceptData=function(a){var b=m.noData[(a.nodeName+" ").toLowerCase()],c=+a.nodeType||1;return 1!==c&&9!==c?!1:!b||b!==!0&&a.getAttribute("classid")===b};var M=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,N=/([A-Z])/g;function O(a,b,c){if(void 0===c&&1===a.nodeType){var d="data-"+b.replace(N,"-$1").toLowerCase();if(c=a.getAttribute(d),"string"==typeof c){try{c="true"===c?!0:"false"===c?!1:"null"===c?null:+c+""===c?+c:M.test(c)?m.parseJSON(c):c}catch(e){}m.data(a,b,c)}else c=void 0}return c}function P(a){var b;for(b in a)if(("data"!==b||!m.isEmptyObject(a[b]))&&"toJSON"!==b)return!1;return!0}function Q(a,b,d,e){if(m.acceptData(a)){var f,g,h=m.expando,i=a.nodeType,j=i?m.cache:a,k=i?a[h]:a[h]&&h;
if(k&&j[k]&&(e||j[k].data)||void 0!==d||"string"!=typeof b)return k||(k=i?a[h]=c.pop()||m.guid++:h),j[k]||(j[k]=i?{}:{toJSON:m.noop}),("object"==typeof b||"function"==typeof b)&&(e?j[k]=m.extend(j[k],b):j[k].data=m.extend(j[k].data,b)),g=j[k],e||(g.data||(g.data={}),g=g.data),void 0!==d&&(g[m.camelCase(b)]=d),"string"==typeof b?(f=g[b],null==f&&(f=g[m.camelCase(b)])):f=g,f}}function R(a,b,c){if(m.acceptData(a)){var d,e,f=a.nodeType,g=f?m.cache:a,h=f?a[m.expando]:m.expando;if(g[h]){if(b&&(d=c?g[h]:g[h].data)){m.isArray(b)?b=b.concat(m.map(b,m.camelCase)):b in d?b=[b]:(b=m.camelCase(b),b=b in d?[b]:b.split(" ")),e=b.length;while(e--)delete d[b[e]];if(c?!P(d):!m.isEmptyObject(d))return}(c||(delete g[h].data,P(g[h])))&&(f?m.cleanData([a],!0):k.deleteExpando||g!=g.window?delete g[h]:g[h]=null)}}}m.extend({cache:{},noData:{"applet ":!0,"embed ":!0,"object ":"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"},hasData:function(a){return a=a.nodeType?m.cache[a[m.expando]]:a[m.expando],!!a&&!P(a)},data:function(a,b,c){return Q(a,b,c)},removeData:function(a,b){return R(a,b)},_data:function(a,b,c){return Q(a,b,c,!0)},_removeData:function(a,b){return R(a,b,!0)}}),m.fn.extend({data:function(a,b){var c,d,e,f=this[0],g=f&&f.attributes;if(void 0===a){if(this.length&&(e=m.data(f),1===f.nodeType&&!m._data(f,"parsedAttrs"))){c=g.length;while(c--)g[c]&&(d=g[c].name,0===d.indexOf("data-")&&(d=m.camelCase(d.slice(5)),O(f,d,e[d])));m._data(f,"parsedAttrs",!0)}return e}return"object"==typeof a?this.each(function(){m.data(this,a)}):arguments.length>1?this.each(function(){m.data(this,a,b)}):f?O(f,a,m.data(f,a)):void 0},removeData:function(a){return this.each(function(){m.removeData(this,a)})}}),m.extend({queue:function(a,b,c){var d;return a?(b=(b||"fx")+"queue",d=m._data(a,b),c&&(!d||m.isArray(c)?d=m._data(a,b,m.makeArray(c)):d.push(c)),d||[]):void 0},dequeue:function(a,b){b=b||"fx";var c=m.queue(a,b),d=c.length,e=c.shift(),f=m._queueHooks(a,b),g=function(){m.dequeue(a,b)};"inprogress"===e&&(e=c.shift(),d--),e&&("fx"===b&&c.unshift("inprogress"),delete f.stop,e.call(a,g,f)),!d&&f&&f.empty.fire()},_queueHooks:function(a,b){var c=b+"queueHooks";return m._data(a,c)||m._data(a,c,{empty:m.Callbacks("once memory").add(function(){m._removeData(a,b+"queue"),m._removeData(a,c)})})}}),m.fn.extend({queue:function(a,b){var c=2;return"string"!=typeof a&&(b=a,a="fx",c--),arguments.length<c?m.queue(this[0],a):void 0===b?this:this.each(function(){var c=m.queue(this,a,b);m._queueHooks(this,a),"fx"===a&&"inprogress"!==c[0]&&m.dequeue(this,a)})},dequeue:function(a){return this.each(function(){m.dequeue(this,a)})},clearQueue:function(a){return this.queue(a||"fx",[])},promise:function(a,b){var c,d=1,e=m.Deferred(),f=this,g=this.length,h=function(){--d||e.resolveWith(f,[f])};"string"!=typeof a&&(b=a,a=void 0),a=a||"fx";while(g--)c=m._data(f[g],a+"queueHooks"),c&&c.empty&&(d++,c.empty.add(h));return h(),e.promise(b)}});var S=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,T=["Top","Right","Bottom","Left"],U=function(a,b){return a=b||a,"none"===m.css(a,"display")||!m.contains(a.ownerDocument,a)},V=m.access=function(a,b,c,d,e,f,g){var h=0,i=a.length,j=null==c;if("object"===m.type(c)){e=!0;for(h in c)m.access(a,b,h,c[h],!0,f,g)}else if(void 0!==d&&(e=!0,m.isFunction(d)||(g=!0),j&&(g?(b.call(a,d),b=null):(j=b,b=function(a,b,c){return j.call(m(a),c)})),b))for(;i>h;h++)b(a[h],c,g?d:d.call(a[h],h,b(a[h],c)));return e?a:j?b.call(a):i?b(a[0],c):f},W=/^(?:checkbox|radio)$/i;!function(){var a=y.createElement("input"),b=y.createElement("div"),c=y.createDocumentFragment();if(b.innerHTML="  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>",k.leadingWhitespace=3===b.firstChild.nodeType,k.tbody=!b.getElementsByTagName("tbody").length,k.htmlSerialize=!!b.getElementsByTagName("link").length,k.html5Clone="<:nav></:nav>"!==y.createElement("nav").cloneNode(!0).outerHTML,a.type="checkbox",a.checked=!0,c.appendChild(a),k.appendChecked=a.checked,b.innerHTML="<textarea>x</textarea>",k.noCloneChecked=!!b.cloneNode(!0).lastChild.defaultValue,c.appendChild(b),b.innerHTML="<input type='radio' checked='checked' name='t'/>",k.checkClone=b.cloneNode(!0).cloneNode(!0).lastChild.checked,k.noCloneEvent=!0,b.attachEvent&&(b.attachEvent("onclick",function(){k.noCloneEvent=!1}),b.cloneNode(!0).click()),null==k.deleteExpando){k.deleteExpando=!0;try{delete b.test}catch(d){k.deleteExpando=!1}}}(),function(){var b,c,d=y.createElement("div");for(b in{submit:!0,change:!0,focusin:!0})c="on"+b,(k[b+"Bubbles"]=c in a)||(d.setAttribute(c,"t"),k[b+"Bubbles"]=d.attributes[c].expando===!1);d=null}();var X=/^(?:input|select|textarea)$/i,Y=/^key/,Z=/^(?:mouse|pointer|contextmenu)|click/,$=/^(?:focusinfocus|focusoutblur)$/,_=/^([^.]*)(?:\.(.+)|)$/;function ab(){return!0}function bb(){return!1}function cb(){try{return y.activeElement}catch(a){}}m.event={global:{},add:function(a,b,c,d,e){var f,g,h,i,j,k,l,n,o,p,q,r=m._data(a);if(r){c.handler&&(i=c,c=i.handler,e=i.selector),c.guid||(c.guid=m.guid++),(g=r.events)||(g=r.events={}),(k=r.handle)||(k=r.handle=function(a){return typeof m===K||a&&m.event.triggered===a.type?void 0:m.event.dispatch.apply(k.elem,arguments)},k.elem=a),b=(b||"").match(E)||[""],h=b.length;while(h--)f=_.exec(b[h])||[],o=q=f[1],p=(f[2]||"").split(".").sort(),o&&(j=m.event.special[o]||{},o=(e?j.delegateType:j.bindType)||o,j=m.event.special[o]||{},l=m.extend({type:o,origType:q,data:d,handler:c,guid:c.guid,selector:e,needsContext:e&&m.expr.match.needsContext.test(e),namespace:p.join(".")},i),(n=g[o])||(n=g[o]=[],n.delegateCount=0,j.setup&&j.setup.call(a,d,p,k)!==!1||(a.addEventListener?a.addEventListener(o,k,!1):a.attachEvent&&a.attachEvent("on"+o,k))),j.add&&(j.add.call(a,l),l.handler.guid||(l.handler.guid=c.guid)),e?n.splice(n.delegateCount++,0,l):n.push(l),m.event.global[o]=!0);a=null}},remove:function(a,b,c,d,e){var f,g,h,i,j,k,l,n,o,p,q,r=m.hasData(a)&&m._data(a);if(r&&(k=r.events)){b=(b||"").match(E)||[""],j=b.length;while(j--)if(h=_.exec(b[j])||[],o=q=h[1],p=(h[2]||"").split(".").sort(),o){l=m.event.special[o]||{},o=(d?l.delegateType:l.bindType)||o,n=k[o]||[],h=h[2]&&new RegExp("(^|\\.)"+p.join("\\.(?:.*\\.|)")+"(\\.|$)"),i=f=n.length;while(f--)g=n[f],!e&&q!==g.origType||c&&c.guid!==g.guid||h&&!h.test(g.namespace)||d&&d!==g.selector&&("**"!==d||!g.selector)||(n.splice(f,1),g.selector&&n.delegateCount--,l.remove&&l.remove.call(a,g));i&&!n.length&&(l.teardown&&l.teardown.call(a,p,r.handle)!==!1||m.removeEvent(a,o,r.handle),delete k[o])}else for(o in k)m.event.remove(a,o+b[j],c,d,!0);m.isEmptyObject(k)&&(delete r.handle,m._removeData(a,"events"))}},trigger:function(b,c,d,e){var f,g,h,i,k,l,n,o=[d||y],p=j.call(b,"type")?b.type:b,q=j.call(b,"namespace")?b.namespace.split("."):[];if(h=l=d=d||y,3!==d.nodeType&&8!==d.nodeType&&!$.test(p+m.event.triggered)&&(p.indexOf(".")>=0&&(q=p.split("."),p=q.shift(),q.sort()),g=p.indexOf(":")<0&&"on"+p,b=b[m.expando]?b:new m.Event(p,"object"==typeof b&&b),b.isTrigger=e?2:3,b.namespace=q.join("."),b.namespace_re=b.namespace?new RegExp("(^|\\.)"+q.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,b.result=void 0,b.target||(b.target=d),c=null==c?[b]:m.makeArray(c,[b]),k=m.event.special[p]||{},e||!k.trigger||k.trigger.apply(d,c)!==!1)){if(!e&&!k.noBubble&&!m.isWindow(d)){for(i=k.delegateType||p,$.test(i+p)||(h=h.parentNode);h;h=h.parentNode)o.push(h),l=h;l===(d.ownerDocument||y)&&o.push(l.defaultView||l.parentWindow||a)}n=0;while((h=o[n++])&&!b.isPropagationStopped())b.type=n>1?i:k.bindType||p,f=(m._data(h,"events")||{})[b.type]&&m._data(h,"handle"),f&&f.apply(h,c),f=g&&h[g],f&&f.apply&&m.acceptData(h)&&(b.result=f.apply(h,c),b.result===!1&&b.preventDefault());if(b.type=p,!e&&!b.isDefaultPrevented()&&(!k._default||k._default.apply(o.pop(),c)===!1)&&m.acceptData(d)&&g&&d[p]&&!m.isWindow(d)){l=d[g],l&&(d[g]=null),m.event.triggered=p;try{d[p]()}catch(r){}m.event.triggered=void 0,l&&(d[g]=l)}return b.result}},dispatch:function(a){a=m.event.fix(a);var b,c,e,f,g,h=[],i=d.call(arguments),j=(m._data(this,"events")||{})[a.type]||[],k=m.event.special[a.type]||{};if(i[0]=a,a.delegateTarget=this,!k.preDispatch||k.preDispatch.call(this,a)!==!1){h=m.event.handlers.call(this,a,j),b=0;while((f=h[b++])&&!a.isPropagationStopped()){a.currentTarget=f.elem,g=0;while((e=f.handlers[g++])&&!a.isImmediatePropagationStopped())(!a.namespace_re||a.namespace_re.test(e.namespace))&&(a.handleObj=e,a.data=e.data,c=((m.event.special[e.origType]||{}).handle||e.handler).apply(f.elem,i),void 0!==c&&(a.result=c)===!1&&(a.preventDefault(),a.stopPropagation()))}return k.postDispatch&&k.postDispatch.call(this,a),a.result}},handlers:function(a,b){var c,d,e,f,g=[],h=b.delegateCount,i=a.target;if(h&&i.nodeType&&(!a.button||"click"!==a.type))for(;i!=this;i=i.parentNode||this)if(1===i.nodeType&&(i.disabled!==!0||"click"!==a.type)){for(e=[],f=0;h>f;f++)d=b[f],c=d.selector+" ",void 0===e[c]&&(e[c]=d.needsContext?m(c,this).index(i)>=0:m.find(c,this,null,[i]).length),e[c]&&e.push(d);e.length&&g.push({elem:i,handlers:e})}return h<b.length&&g.push({elem:this,handlers:b.slice(h)}),g},fix:function(a){if(a[m.expando])return a;var b,c,d,e=a.type,f=a,g=this.fixHooks[e];g||(this.fixHooks[e]=g=Z.test(e)?this.mouseHooks:Y.test(e)?this.keyHooks:{}),d=g.props?this.props.concat(g.props):this.props,a=new m.Event(f),b=d.length;while(b--)c=d[b],a[c]=f[c];return a.target||(a.target=f.srcElement||y),3===a.target.nodeType&&(a.target=a.target.parentNode),a.metaKey=!!a.metaKey,g.filter?g.filter(a,f):a},props:"altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),fixHooks:{},keyHooks:{props:"char charCode key keyCode".split(" "),filter:function(a,b){return null==a.which&&(a.which=null!=b.charCode?b.charCode:b.keyCode),a}},mouseHooks:{props:"button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),filter:function(a,b){var c,d,e,f=b.button,g=b.fromElement;return null==a.pageX&&null!=b.clientX&&(d=a.target.ownerDocument||y,e=d.documentElement,c=d.body,a.pageX=b.clientX+(e&&e.scrollLeft||c&&c.scrollLeft||0)-(e&&e.clientLeft||c&&c.clientLeft||0),a.pageY=b.clientY+(e&&e.scrollTop||c&&c.scrollTop||0)-(e&&e.clientTop||c&&c.clientTop||0)),!a.relatedTarget&&g&&(a.relatedTarget=g===a.target?b.toElement:g),a.which||void 0===f||(a.which=1&f?1:2&f?3:4&f?2:0),a}},special:{load:{noBubble:!0},focus:{trigger:function(){if(this!==cb()&&this.focus)try{return this.focus(),!1}catch(a){}},delegateType:"focusin"},blur:{trigger:function(){return this===cb()&&this.blur?(this.blur(),!1):void 0},delegateType:"focusout"},click:{trigger:function(){return m.nodeName(this,"input")&&"checkbox"===this.type&&this.click?(this.click(),!1):void 0},_default:function(a){return m.nodeName(a.target,"a")}},beforeunload:{postDispatch:function(a){void 0!==a.result&&a.originalEvent&&(a.originalEvent.returnValue=a.result)}}},simulate:function(a,b,c,d){var e=m.extend(new m.Event,c,{type:a,isSimulated:!0,originalEvent:{}});d?m.event.trigger(e,null,b):m.event.dispatch.call(b,e),e.isDefaultPrevented()&&c.preventDefault()}},m.removeEvent=y.removeEventListener?function(a,b,c){a.removeEventListener&&a.removeEventListener(b,c,!1)}:function(a,b,c){var d="on"+b;a.detachEvent&&(typeof a[d]===K&&(a[d]=null),a.detachEvent(d,c))},m.Event=function(a,b){return this instanceof m.Event?(a&&a.type?(this.originalEvent=a,this.type=a.type,this.isDefaultPrevented=a.defaultPrevented||void 0===a.defaultPrevented&&a.returnValue===!1?ab:bb):this.type=a,b&&m.extend(this,b),this.timeStamp=a&&a.timeStamp||m.now(),void(this[m.expando]=!0)):new m.Event(a,b)},m.Event.prototype={isDefaultPrevented:bb,isPropagationStopped:bb,isImmediatePropagationStopped:bb,preventDefault:function(){var a=this.originalEvent;this.isDefaultPrevented=ab,a&&(a.preventDefault?a.preventDefault():a.returnValue=!1)},stopPropagation:function(){var a=this.originalEvent;this.isPropagationStopped=ab,a&&(a.stopPropagation&&a.stopPropagation(),a.cancelBubble=!0)},stopImmediatePropagation:function(){var a=this.originalEvent;this.isImmediatePropagationStopped=ab,a&&a.stopImmediatePropagation&&a.stopImmediatePropagation(),this.stopPropagation()}},m.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(a,b){m.event.special[a]={delegateType:b,bindType:b,handle:function(a){var c,d=this,e=a.relatedTarget,f=a.handleObj;return(!e||e!==d&&!m.contains(d,e))&&(a.type=f.origType,c=f.handler.apply(this,arguments),a.type=b),c}}}),k.submitBubbles||(m.event.special.submit={setup:function(){return m.nodeName(this,"form")?!1:void m.event.add(this,"click._submit keypress._submit",function(a){var b=a.target,c=m.nodeName(b,"input")||m.nodeName(b,"button")?b.form:void 0;c&&!m._data(c,"submitBubbles")&&(m.event.add(c,"submit._submit",function(a){a._submit_bubble=!0}),m._data(c,"submitBubbles",!0))})},postDispatch:function(a){a._submit_bubble&&(delete a._submit_bubble,this.parentNode&&!a.isTrigger&&m.event.simulate("submit",this.parentNode,a,!0))},teardown:function(){return m.nodeName(this,"form")?!1:void m.event.remove(this,"._submit")}}),k.changeBubbles||(m.event.special.change={setup:function(){return X.test(this.nodeName)?(("checkbox"===this.type||"radio"===this.type)&&(m.event.add(this,"propertychange._change",function(a){"checked"===a.originalEvent.propertyName&&(this._just_changed=!0)}),m.event.add(this,"click._change",function(a){this._just_changed&&!a.isTrigger&&(this._just_changed=!1),m.event.simulate("change",this,a,!0)})),!1):void m.event.add(this,"beforeactivate._change",function(a){var b=a.target;X.test(b.nodeName)&&!m._data(b,"changeBubbles")&&(m.event.add(b,"change._change",function(a){!this.parentNode||a.isSimulated||a.isTrigger||m.event.simulate("change",this.parentNode,a,!0)}),m._data(b,"changeBubbles",!0))})},handle:function(a){var b=a.target;return this!==b||a.isSimulated||a.isTrigger||"radio"!==b.type&&"checkbox"!==b.type?a.handleObj.handler.apply(this,arguments):void 0},teardown:function(){return m.event.remove(this,"._change"),!X.test(this.nodeName)}}),k.focusinBubbles||m.each({focus:"focusin",blur:"focusout"},function(a,b){var c=function(a){m.event.simulate(b,a.target,m.event.fix(a),!0)};m.event.special[b]={setup:function(){var d=this.ownerDocument||this,e=m._data(d,b);e||d.addEventListener(a,c,!0),m._data(d,b,(e||0)+1)},teardown:function(){var d=this.ownerDocument||this,e=m._data(d,b)-1;e?m._data(d,b,e):(d.removeEventListener(a,c,!0),m._removeData(d,b))}}}),m.fn.extend({on:function(a,b,c,d,e){var f,g;if("object"==typeof a){"string"!=typeof b&&(c=c||b,b=void 0);for(f in a)this.on(f,b,c,a[f],e);return this}if(null==c&&null==d?(d=b,c=b=void 0):null==d&&("string"==typeof b?(d=c,c=void 0):(d=c,c=b,b=void 0)),d===!1)d=bb;else if(!d)return this;return 1===e&&(g=d,d=function(a){return m().off(a),g.apply(this,arguments)},d.guid=g.guid||(g.guid=m.guid++)),this.each(function(){m.event.add(this,a,d,c,b)})},one:function(a,b,c,d){return this.on(a,b,c,d,1)},off:function(a,b,c){var d,e;if(a&&a.preventDefault&&a.handleObj)return d=a.handleObj,m(a.delegateTarget).off(d.namespace?d.origType+"."+d.namespace:d.origType,d.selector,d.handler),this;if("object"==typeof a){for(e in a)this.off(e,b,a[e]);return this}return(b===!1||"function"==typeof b)&&(c=b,b=void 0),c===!1&&(c=bb),this.each(function(){m.event.remove(this,a,c,b)})},trigger:function(a,b){return this.each(function(){m.event.trigger(a,b,this)})},triggerHandler:function(a,b){var c=this[0];return c?m.event.trigger(a,b,c,!0):void 0}});function db(a){var b=eb.split("|"),c=a.createDocumentFragment();if(c.createElement)while(b.length)c.createElement(b.pop());return c}var eb="abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",fb=/ jQuery\d+="(?:null|\d+)"/g,gb=new RegExp("<(?:"+eb+")[\\s/>]","i"),hb=/^\s+/,ib=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,jb=/<([\w:]+)/,kb=/<tbody/i,lb=/<|&#?\w+;/,mb=/<(?:script|style|link)/i,nb=/checked\s*(?:[^=]|=\s*.checked.)/i,ob=/^$|\/(?:java|ecma)script/i,pb=/^true\/(.*)/,qb=/^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,rb={option:[1,"<select multiple='multiple'>","</select>"],legend:[1,"<fieldset>","</fieldset>"],area:[1,"<map>","</map>"],param:[1,"<object>","</object>"],thead:[1,"<table>","</table>"],tr:[2,"<table><tbody>","</tbody></table>"],col:[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:k.htmlSerialize?[0,"",""]:[1,"X<div>","</div>"]},sb=db(y),tb=sb.appendChild(y.createElement("div"));rb.optgroup=rb.option,rb.tbody=rb.tfoot=rb.colgroup=rb.caption=rb.thead,rb.th=rb.td;function ub(a,b){var c,d,e=0,f=typeof a.getElementsByTagName!==K?a.getElementsByTagName(b||"*"):typeof a.querySelectorAll!==K?a.querySelectorAll(b||"*"):void 0;if(!f)for(f=[],c=a.childNodes||a;null!=(d=c[e]);e++)!b||m.nodeName(d,b)?f.push(d):m.merge(f,ub(d,b));return void 0===b||b&&m.nodeName(a,b)?m.merge([a],f):f}function vb(a){W.test(a.type)&&(a.defaultChecked=a.checked)}function wb(a,b){return m.nodeName(a,"table")&&m.nodeName(11!==b.nodeType?b:b.firstChild,"tr")?a.getElementsByTagName("tbody")[0]||a.appendChild(a.ownerDocument.createElement("tbody")):a}function xb(a){return a.type=(null!==m.find.attr(a,"type"))+"/"+a.type,a}function yb(a){var b=pb.exec(a.type);return b?a.type=b[1]:a.removeAttribute("type"),a}function zb(a,b){for(var c,d=0;null!=(c=a[d]);d++)m._data(c,"globalEval",!b||m._data(b[d],"globalEval"))}function Ab(a,b){if(1===b.nodeType&&m.hasData(a)){var c,d,e,f=m._data(a),g=m._data(b,f),h=f.events;if(h){delete g.handle,g.events={};for(c in h)for(d=0,e=h[c].length;e>d;d++)m.event.add(b,c,h[c][d])}g.data&&(g.data=m.extend({},g.data))}}function Bb(a,b){var c,d,e;if(1===b.nodeType){if(c=b.nodeName.toLowerCase(),!k.noCloneEvent&&b[m.expando]){e=m._data(b);for(d in e.events)m.removeEvent(b,d,e.handle);b.removeAttribute(m.expando)}"script"===c&&b.text!==a.text?(xb(b).text=a.text,yb(b)):"object"===c?(b.parentNode&&(b.outerHTML=a.outerHTML),k.html5Clone&&a.innerHTML&&!m.trim(b.innerHTML)&&(b.innerHTML=a.innerHTML)):"input"===c&&W.test(a.type)?(b.defaultChecked=b.checked=a.checked,b.value!==a.value&&(b.value=a.value)):"option"===c?b.defaultSelected=b.selected=a.defaultSelected:("input"===c||"textarea"===c)&&(b.defaultValue=a.defaultValue)}}m.extend({clone:function(a,b,c){var d,e,f,g,h,i=m.contains(a.ownerDocument,a);if(k.html5Clone||m.isXMLDoc(a)||!gb.test("<"+a.nodeName+">")?f=a.cloneNode(!0):(tb.innerHTML=a.outerHTML,tb.removeChild(f=tb.firstChild)),!(k.noCloneEvent&&k.noCloneChecked||1!==a.nodeType&&11!==a.nodeType||m.isXMLDoc(a)))for(d=ub(f),h=ub(a),g=0;null!=(e=h[g]);++g)d[g]&&Bb(e,d[g]);if(b)if(c)for(h=h||ub(a),d=d||ub(f),g=0;null!=(e=h[g]);g++)Ab(e,d[g]);else Ab(a,f);return d=ub(f,"script"),d.length>0&&zb(d,!i&&ub(a,"script")),d=h=e=null,f},buildFragment:function(a,b,c,d){for(var e,f,g,h,i,j,l,n=a.length,o=db(b),p=[],q=0;n>q;q++)if(f=a[q],f||0===f)if("object"===m.type(f))m.merge(p,f.nodeType?[f]:f);else if(lb.test(f)){h=h||o.appendChild(b.createElement("div")),i=(jb.exec(f)||["",""])[1].toLowerCase(),l=rb[i]||rb._default,h.innerHTML=l[1]+f.replace(ib,"<$1></$2>")+l[2],e=l[0];while(e--)h=h.lastChild;if(!k.leadingWhitespace&&hb.test(f)&&p.push(b.createTextNode(hb.exec(f)[0])),!k.tbody){f="table"!==i||kb.test(f)?"<table>"!==l[1]||kb.test(f)?0:h:h.firstChild,e=f&&f.childNodes.length;while(e--)m.nodeName(j=f.childNodes[e],"tbody")&&!j.childNodes.length&&f.removeChild(j)}m.merge(p,h.childNodes),h.textContent="";while(h.firstChild)h.removeChild(h.firstChild);h=o.lastChild}else p.push(b.createTextNode(f));h&&o.removeChild(h),k.appendChecked||m.grep(ub(p,"input"),vb),q=0;while(f=p[q++])if((!d||-1===m.inArray(f,d))&&(g=m.contains(f.ownerDocument,f),h=ub(o.appendChild(f),"script"),g&&zb(h),c)){e=0;while(f=h[e++])ob.test(f.type||"")&&c.push(f)}return h=null,o},cleanData:function(a,b){for(var d,e,f,g,h=0,i=m.expando,j=m.cache,l=k.deleteExpando,n=m.event.special;null!=(d=a[h]);h++)if((b||m.acceptData(d))&&(f=d[i],g=f&&j[f])){if(g.events)for(e in g.events)n[e]?m.event.remove(d,e):m.removeEvent(d,e,g.handle);j[f]&&(delete j[f],l?delete d[i]:typeof d.removeAttribute!==K?d.removeAttribute(i):d[i]=null,c.push(f))}}}),m.fn.extend({text:function(a){return V(this,function(a){return void 0===a?m.text(this):this.empty().append((this[0]&&this[0].ownerDocument||y).createTextNode(a))},null,a,arguments.length)},append:function(){return this.domManip(arguments,function(a){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var b=wb(this,a);b.appendChild(a)}})},prepend:function(){return this.domManip(arguments,function(a){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var b=wb(this,a);b.insertBefore(a,b.firstChild)}})},before:function(){return this.domManip(arguments,function(a){this.parentNode&&this.parentNode.insertBefore(a,this)})},after:function(){return this.domManip(arguments,function(a){this.parentNode&&this.parentNode.insertBefore(a,this.nextSibling)})},remove:function(a,b){for(var c,d=a?m.filter(a,this):this,e=0;null!=(c=d[e]);e++)b||1!==c.nodeType||m.cleanData(ub(c)),c.parentNode&&(b&&m.contains(c.ownerDocument,c)&&zb(ub(c,"script")),c.parentNode.removeChild(c));return this},empty:function(){for(var a,b=0;null!=(a=this[b]);b++){1===a.nodeType&&m.cleanData(ub(a,!1));while(a.firstChild)a.removeChild(a.firstChild);a.options&&m.nodeName(a,"select")&&(a.options.length=0)}return this},clone:function(a,b){return a=null==a?!1:a,b=null==b?a:b,this.map(function(){return m.clone(this,a,b)})},html:function(a){return V(this,function(a){var b=this[0]||{},c=0,d=this.length;if(void 0===a)return 1===b.nodeType?b.innerHTML.replace(fb,""):void 0;if(!("string"!=typeof a||mb.test(a)||!k.htmlSerialize&&gb.test(a)||!k.leadingWhitespace&&hb.test(a)||rb[(jb.exec(a)||["",""])[1].toLowerCase()])){a=a.replace(ib,"<$1></$2>");try{for(;d>c;c++)b=this[c]||{},1===b.nodeType&&(m.cleanData(ub(b,!1)),b.innerHTML=a);b=0}catch(e){}}b&&this.empty().append(a)},null,a,arguments.length)},replaceWith:function(){var a=arguments[0];return this.domManip(arguments,function(b){a=this.parentNode,m.cleanData(ub(this)),a&&a.replaceChild(b,this)}),a&&(a.length||a.nodeType)?this:this.remove()},detach:function(a){return this.remove(a,!0)},domManip:function(a,b){a=e.apply([],a);var c,d,f,g,h,i,j=0,l=this.length,n=this,o=l-1,p=a[0],q=m.isFunction(p);if(q||l>1&&"string"==typeof p&&!k.checkClone&&nb.test(p))return this.each(function(c){var d=n.eq(c);q&&(a[0]=p.call(this,c,d.html())),d.domManip(a,b)});if(l&&(i=m.buildFragment(a,this[0].ownerDocument,!1,this),c=i.firstChild,1===i.childNodes.length&&(i=c),c)){for(g=m.map(ub(i,"script"),xb),f=g.length;l>j;j++)d=i,j!==o&&(d=m.clone(d,!0,!0),f&&m.merge(g,ub(d,"script"))),b.call(this[j],d,j);if(f)for(h=g[g.length-1].ownerDocument,m.map(g,yb),j=0;f>j;j++)d=g[j],ob.test(d.type||"")&&!m._data(d,"globalEval")&&m.contains(h,d)&&(d.src?m._evalUrl&&m._evalUrl(d.src):m.globalEval((d.text||d.textContent||d.innerHTML||"").replace(qb,"")));i=c=null}return this}}),m.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(a,b){m.fn[a]=function(a){for(var c,d=0,e=[],g=m(a),h=g.length-1;h>=d;d++)c=d===h?this:this.clone(!0),m(g[d])[b](c),f.apply(e,c.get());return this.pushStack(e)}});var Cb,Db={};function Eb(b,c){var d,e=m(c.createElement(b)).appendTo(c.body),f=a.getDefaultComputedStyle&&(d=a.getDefaultComputedStyle(e[0]))?d.display:m.css(e[0],"display");return e.detach(),f}function Fb(a){var b=y,c=Db[a];return c||(c=Eb(a,b),"none"!==c&&c||(Cb=(Cb||m("<iframe frameborder='0' width='0' height='0'/>")).appendTo(b.documentElement),b=(Cb[0].contentWindow||Cb[0].contentDocument).document,b.write(),b.close(),c=Eb(a,b),Cb.detach()),Db[a]=c),c}!function(){var a;k.shrinkWrapBlocks=function(){if(null!=a)return a;a=!1;var b,c,d;return c=y.getElementsByTagName("body")[0],c&&c.style?(b=y.createElement("div"),d=y.createElement("div"),d.style.cssText="position:absolute;border:0;width:0;height:0;top:0;left:-9999px",c.appendChild(d).appendChild(b),typeof b.style.zoom!==K&&(b.style.cssText="-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:1px;width:1px;zoom:1",b.appendChild(y.createElement("div")).style.width="5px",a=3!==b.offsetWidth),c.removeChild(d),a):void 0}}();var Gb=/^margin/,Hb=new RegExp("^("+S+")(?!px)[a-z%]+$","i"),Ib,Jb,Kb=/^(top|right|bottom|left)$/;a.getComputedStyle?(Ib=function(a){return a.ownerDocument.defaultView.getComputedStyle(a,null)},Jb=function(a,b,c){var d,e,f,g,h=a.style;return c=c||Ib(a),g=c?c.getPropertyValue(b)||c[b]:void 0,c&&(""!==g||m.contains(a.ownerDocument,a)||(g=m.style(a,b)),Hb.test(g)&&Gb.test(b)&&(d=h.width,e=h.minWidth,f=h.maxWidth,h.minWidth=h.maxWidth=h.width=g,g=c.width,h.width=d,h.minWidth=e,h.maxWidth=f)),void 0===g?g:g+""}):y.documentElement.currentStyle&&(Ib=function(a){return a.currentStyle},Jb=function(a,b,c){var d,e,f,g,h=a.style;return c=c||Ib(a),g=c?c[b]:void 0,null==g&&h&&h[b]&&(g=h[b]),Hb.test(g)&&!Kb.test(b)&&(d=h.left,e=a.runtimeStyle,f=e&&e.left,f&&(e.left=a.currentStyle.left),h.left="fontSize"===b?"1em":g,g=h.pixelLeft+"px",h.left=d,f&&(e.left=f)),void 0===g?g:g+""||"auto"});function Lb(a,b){return{get:function(){var c=a();if(null!=c)return c?void delete this.get:(this.get=b).apply(this,arguments)}}}!function(){var b,c,d,e,f,g,h;if(b=y.createElement("div"),b.innerHTML="  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>",d=b.getElementsByTagName("a")[0],c=d&&d.style){c.cssText="float:left;opacity:.5",k.opacity="0.5"===c.opacity,k.cssFloat=!!c.cssFloat,b.style.backgroundClip="content-box",b.cloneNode(!0).style.backgroundClip="",k.clearCloneStyle="content-box"===b.style.backgroundClip,k.boxSizing=""===c.boxSizing||""===c.MozBoxSizing||""===c.WebkitBoxSizing,m.extend(k,{reliableHiddenOffsets:function(){return null==g&&i(),g},boxSizingReliable:function(){return null==f&&i(),f},pixelPosition:function(){return null==e&&i(),e},reliableMarginRight:function(){return null==h&&i(),h}});function i(){var b,c,d,i;c=y.getElementsByTagName("body")[0],c&&c.style&&(b=y.createElement("div"),d=y.createElement("div"),d.style.cssText="position:absolute;border:0;width:0;height:0;top:0;left:-9999px",c.appendChild(d).appendChild(b),b.style.cssText="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;display:block;margin-top:1%;top:1%;border:1px;padding:1px;width:4px;position:absolute",e=f=!1,h=!0,a.getComputedStyle&&(e="1%"!==(a.getComputedStyle(b,null)||{}).top,f="4px"===(a.getComputedStyle(b,null)||{width:"4px"}).width,i=b.appendChild(y.createElement("div")),i.style.cssText=b.style.cssText="-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0",i.style.marginRight=i.style.width="0",b.style.width="1px",h=!parseFloat((a.getComputedStyle(i,null)||{}).marginRight)),b.innerHTML="<table><tr><td></td><td>t</td></tr></table>",i=b.getElementsByTagName("td"),i[0].style.cssText="margin:0;border:0;padding:0;display:none",g=0===i[0].offsetHeight,g&&(i[0].style.display="",i[1].style.display="none",g=0===i[0].offsetHeight),c.removeChild(d))}}}(),m.swap=function(a,b,c,d){var e,f,g={};for(f in b)g[f]=a.style[f],a.style[f]=b[f];e=c.apply(a,d||[]);for(f in b)a.style[f]=g[f];return e};var Mb=/alpha\([^)]*\)/i,Nb=/opacity\s*=\s*([^)]*)/,Ob=/^(none|table(?!-c[ea]).+)/,Pb=new RegExp("^("+S+")(.*)$","i"),Qb=new RegExp("^([+-])=("+S+")","i"),Rb={position:"absolute",visibility:"hidden",display:"block"},Sb={letterSpacing:"0",fontWeight:"400"},Tb=["Webkit","O","Moz","ms"];function Ub(a,b){if(b in a)return b;var c=b.charAt(0).toUpperCase()+b.slice(1),d=b,e=Tb.length;while(e--)if(b=Tb[e]+c,b in a)return b;return d}function Vb(a,b){for(var c,d,e,f=[],g=0,h=a.length;h>g;g++)d=a[g],d.style&&(f[g]=m._data(d,"olddisplay"),c=d.style.display,b?(f[g]||"none"!==c||(d.style.display=""),""===d.style.display&&U(d)&&(f[g]=m._data(d,"olddisplay",Fb(d.nodeName)))):(e=U(d),(c&&"none"!==c||!e)&&m._data(d,"olddisplay",e?c:m.css(d,"display"))));for(g=0;h>g;g++)d=a[g],d.style&&(b&&"none"!==d.style.display&&""!==d.style.display||(d.style.display=b?f[g]||"":"none"));return a}function Wb(a,b,c){var d=Pb.exec(b);return d?Math.max(0,d[1]-(c||0))+(d[2]||"px"):b}function Xb(a,b,c,d,e){for(var f=c===(d?"border":"content")?4:"width"===b?1:0,g=0;4>f;f+=2)"margin"===c&&(g+=m.css(a,c+T[f],!0,e)),d?("content"===c&&(g-=m.css(a,"padding"+T[f],!0,e)),"margin"!==c&&(g-=m.css(a,"border"+T[f]+"Width",!0,e))):(g+=m.css(a,"padding"+T[f],!0,e),"padding"!==c&&(g+=m.css(a,"border"+T[f]+"Width",!0,e)));return g}function Yb(a,b,c){var d=!0,e="width"===b?a.offsetWidth:a.offsetHeight,f=Ib(a),g=k.boxSizing&&"border-box"===m.css(a,"boxSizing",!1,f);if(0>=e||null==e){if(e=Jb(a,b,f),(0>e||null==e)&&(e=a.style[b]),Hb.test(e))return e;d=g&&(k.boxSizingReliable()||e===a.style[b]),e=parseFloat(e)||0}return e+Xb(a,b,c||(g?"border":"content"),d,f)+"px"}m.extend({cssHooks:{opacity:{get:function(a,b){if(b){var c=Jb(a,"opacity");return""===c?"1":c}}}},cssNumber:{columnCount:!0,fillOpacity:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{"float":k.cssFloat?"cssFloat":"styleFloat"},style:function(a,b,c,d){if(a&&3!==a.nodeType&&8!==a.nodeType&&a.style){var e,f,g,h=m.camelCase(b),i=a.style;if(b=m.cssProps[h]||(m.cssProps[h]=Ub(i,h)),g=m.cssHooks[b]||m.cssHooks[h],void 0===c)return g&&"get"in g&&void 0!==(e=g.get(a,!1,d))?e:i[b];if(f=typeof c,"string"===f&&(e=Qb.exec(c))&&(c=(e[1]+1)*e[2]+parseFloat(m.css(a,b)),f="number"),null!=c&&c===c&&("number"!==f||m.cssNumber[h]||(c+="px"),k.clearCloneStyle||""!==c||0!==b.indexOf("background")||(i[b]="inherit"),!(g&&"set"in g&&void 0===(c=g.set(a,c,d)))))try{i[b]=c}catch(j){}}},css:function(a,b,c,d){var e,f,g,h=m.camelCase(b);return b=m.cssProps[h]||(m.cssProps[h]=Ub(a.style,h)),g=m.cssHooks[b]||m.cssHooks[h],g&&"get"in g&&(f=g.get(a,!0,c)),void 0===f&&(f=Jb(a,b,d)),"normal"===f&&b in Sb&&(f=Sb[b]),""===c||c?(e=parseFloat(f),c===!0||m.isNumeric(e)?e||0:f):f}}),m.each(["height","width"],function(a,b){m.cssHooks[b]={get:function(a,c,d){return c?Ob.test(m.css(a,"display"))&&0===a.offsetWidth?m.swap(a,Rb,function(){return Yb(a,b,d)}):Yb(a,b,d):void 0},set:function(a,c,d){var e=d&&Ib(a);return Wb(a,c,d?Xb(a,b,d,k.boxSizing&&"border-box"===m.css(a,"boxSizing",!1,e),e):0)}}}),k.opacity||(m.cssHooks.opacity={get:function(a,b){return Nb.test((b&&a.currentStyle?a.currentStyle.filter:a.style.filter)||"")?.01*parseFloat(RegExp.$1)+"":b?"1":""},set:function(a,b){var c=a.style,d=a.currentStyle,e=m.isNumeric(b)?"alpha(opacity="+100*b+")":"",f=d&&d.filter||c.filter||"";c.zoom=1,(b>=1||""===b)&&""===m.trim(f.replace(Mb,""))&&c.removeAttribute&&(c.removeAttribute("filter"),""===b||d&&!d.filter)||(c.filter=Mb.test(f)?f.replace(Mb,e):f+" "+e)}}),m.cssHooks.marginRight=Lb(k.reliableMarginRight,function(a,b){return b?m.swap(a,{display:"inline-block"},Jb,[a,"marginRight"]):void 0}),m.each({margin:"",padding:"",border:"Width"},function(a,b){m.cssHooks[a+b]={expand:function(c){for(var d=0,e={},f="string"==typeof c?c.split(" "):[c];4>d;d++)e[a+T[d]+b]=f[d]||f[d-2]||f[0];return e}},Gb.test(a)||(m.cssHooks[a+b].set=Wb)}),m.fn.extend({css:function(a,b){return V(this,function(a,b,c){var d,e,f={},g=0;if(m.isArray(b)){for(d=Ib(a),e=b.length;e>g;g++)f[b[g]]=m.css(a,b[g],!1,d);return f}return void 0!==c?m.style(a,b,c):m.css(a,b)},a,b,arguments.length>1)},show:function(){return Vb(this,!0)},hide:function(){return Vb(this)},toggle:function(a){return"boolean"==typeof a?a?this.show():this.hide():this.each(function(){U(this)?m(this).show():m(this).hide()})}});function Zb(a,b,c,d,e){return new Zb.prototype.init(a,b,c,d,e)}m.Tween=Zb,Zb.prototype={constructor:Zb,init:function(a,b,c,d,e,f){this.elem=a,this.prop=c,this.easing=e||"swing",this.options=b,this.start=this.now=this.cur(),this.end=d,this.unit=f||(m.cssNumber[c]?"":"px")
},cur:function(){var a=Zb.propHooks[this.prop];return a&&a.get?a.get(this):Zb.propHooks._default.get(this)},run:function(a){var b,c=Zb.propHooks[this.prop];return this.pos=b=this.options.duration?m.easing[this.easing](a,this.options.duration*a,0,1,this.options.duration):a,this.now=(this.end-this.start)*b+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),c&&c.set?c.set(this):Zb.propHooks._default.set(this),this}},Zb.prototype.init.prototype=Zb.prototype,Zb.propHooks={_default:{get:function(a){var b;return null==a.elem[a.prop]||a.elem.style&&null!=a.elem.style[a.prop]?(b=m.css(a.elem,a.prop,""),b&&"auto"!==b?b:0):a.elem[a.prop]},set:function(a){m.fx.step[a.prop]?m.fx.step[a.prop](a):a.elem.style&&(null!=a.elem.style[m.cssProps[a.prop]]||m.cssHooks[a.prop])?m.style(a.elem,a.prop,a.now+a.unit):a.elem[a.prop]=a.now}}},Zb.propHooks.scrollTop=Zb.propHooks.scrollLeft={set:function(a){a.elem.nodeType&&a.elem.parentNode&&(a.elem[a.prop]=a.now)}},m.easing={linear:function(a){return a},swing:function(a){return.5-Math.cos(a*Math.PI)/2}},m.fx=Zb.prototype.init,m.fx.step={};var $b,_b,ac=/^(?:toggle|show|hide)$/,bc=new RegExp("^(?:([+-])=|)("+S+")([a-z%]*)$","i"),cc=/queueHooks$/,dc=[ic],ec={"*":[function(a,b){var c=this.createTween(a,b),d=c.cur(),e=bc.exec(b),f=e&&e[3]||(m.cssNumber[a]?"":"px"),g=(m.cssNumber[a]||"px"!==f&&+d)&&bc.exec(m.css(c.elem,a)),h=1,i=20;if(g&&g[3]!==f){f=f||g[3],e=e||[],g=+d||1;do h=h||".5",g/=h,m.style(c.elem,a,g+f);while(h!==(h=c.cur()/d)&&1!==h&&--i)}return e&&(g=c.start=+g||+d||0,c.unit=f,c.end=e[1]?g+(e[1]+1)*e[2]:+e[2]),c}]};function fc(){return setTimeout(function(){$b=void 0}),$b=m.now()}function gc(a,b){var c,d={height:a},e=0;for(b=b?1:0;4>e;e+=2-b)c=T[e],d["margin"+c]=d["padding"+c]=a;return b&&(d.opacity=d.width=a),d}function hc(a,b,c){for(var d,e=(ec[b]||[]).concat(ec["*"]),f=0,g=e.length;g>f;f++)if(d=e[f].call(c,b,a))return d}function ic(a,b,c){var d,e,f,g,h,i,j,l,n=this,o={},p=a.style,q=a.nodeType&&U(a),r=m._data(a,"fxshow");c.queue||(h=m._queueHooks(a,"fx"),null==h.unqueued&&(h.unqueued=0,i=h.empty.fire,h.empty.fire=function(){h.unqueued||i()}),h.unqueued++,n.always(function(){n.always(function(){h.unqueued--,m.queue(a,"fx").length||h.empty.fire()})})),1===a.nodeType&&("height"in b||"width"in b)&&(c.overflow=[p.overflow,p.overflowX,p.overflowY],j=m.css(a,"display"),l="none"===j?m._data(a,"olddisplay")||Fb(a.nodeName):j,"inline"===l&&"none"===m.css(a,"float")&&(k.inlineBlockNeedsLayout&&"inline"!==Fb(a.nodeName)?p.zoom=1:p.display="inline-block")),c.overflow&&(p.overflow="hidden",k.shrinkWrapBlocks()||n.always(function(){p.overflow=c.overflow[0],p.overflowX=c.overflow[1],p.overflowY=c.overflow[2]}));for(d in b)if(e=b[d],ac.exec(e)){if(delete b[d],f=f||"toggle"===e,e===(q?"hide":"show")){if("show"!==e||!r||void 0===r[d])continue;q=!0}o[d]=r&&r[d]||m.style(a,d)}else j=void 0;if(m.isEmptyObject(o))"inline"===("none"===j?Fb(a.nodeName):j)&&(p.display=j);else{r?"hidden"in r&&(q=r.hidden):r=m._data(a,"fxshow",{}),f&&(r.hidden=!q),q?m(a).show():n.done(function(){m(a).hide()}),n.done(function(){var b;m._removeData(a,"fxshow");for(b in o)m.style(a,b,o[b])});for(d in o)g=hc(q?r[d]:0,d,n),d in r||(r[d]=g.start,q&&(g.end=g.start,g.start="width"===d||"height"===d?1:0))}}function jc(a,b){var c,d,e,f,g;for(c in a)if(d=m.camelCase(c),e=b[d],f=a[c],m.isArray(f)&&(e=f[1],f=a[c]=f[0]),c!==d&&(a[d]=f,delete a[c]),g=m.cssHooks[d],g&&"expand"in g){f=g.expand(f),delete a[d];for(c in f)c in a||(a[c]=f[c],b[c]=e)}else b[d]=e}function kc(a,b,c){var d,e,f=0,g=dc.length,h=m.Deferred().always(function(){delete i.elem}),i=function(){if(e)return!1;for(var b=$b||fc(),c=Math.max(0,j.startTime+j.duration-b),d=c/j.duration||0,f=1-d,g=0,i=j.tweens.length;i>g;g++)j.tweens[g].run(f);return h.notifyWith(a,[j,f,c]),1>f&&i?c:(h.resolveWith(a,[j]),!1)},j=h.promise({elem:a,props:m.extend({},b),opts:m.extend(!0,{specialEasing:{}},c),originalProperties:b,originalOptions:c,startTime:$b||fc(),duration:c.duration,tweens:[],createTween:function(b,c){var d=m.Tween(a,j.opts,b,c,j.opts.specialEasing[b]||j.opts.easing);return j.tweens.push(d),d},stop:function(b){var c=0,d=b?j.tweens.length:0;if(e)return this;for(e=!0;d>c;c++)j.tweens[c].run(1);return b?h.resolveWith(a,[j,b]):h.rejectWith(a,[j,b]),this}}),k=j.props;for(jc(k,j.opts.specialEasing);g>f;f++)if(d=dc[f].call(j,a,k,j.opts))return d;return m.map(k,hc,j),m.isFunction(j.opts.start)&&j.opts.start.call(a,j),m.fx.timer(m.extend(i,{elem:a,anim:j,queue:j.opts.queue})),j.progress(j.opts.progress).done(j.opts.done,j.opts.complete).fail(j.opts.fail).always(j.opts.always)}m.Animation=m.extend(kc,{tweener:function(a,b){m.isFunction(a)?(b=a,a=["*"]):a=a.split(" ");for(var c,d=0,e=a.length;e>d;d++)c=a[d],ec[c]=ec[c]||[],ec[c].unshift(b)},prefilter:function(a,b){b?dc.unshift(a):dc.push(a)}}),m.speed=function(a,b,c){var d=a&&"object"==typeof a?m.extend({},a):{complete:c||!c&&b||m.isFunction(a)&&a,duration:a,easing:c&&b||b&&!m.isFunction(b)&&b};return d.duration=m.fx.off?0:"number"==typeof d.duration?d.duration:d.duration in m.fx.speeds?m.fx.speeds[d.duration]:m.fx.speeds._default,(null==d.queue||d.queue===!0)&&(d.queue="fx"),d.old=d.complete,d.complete=function(){m.isFunction(d.old)&&d.old.call(this),d.queue&&m.dequeue(this,d.queue)},d},m.fn.extend({fadeTo:function(a,b,c,d){return this.filter(U).css("opacity",0).show().end().animate({opacity:b},a,c,d)},animate:function(a,b,c,d){var e=m.isEmptyObject(a),f=m.speed(b,c,d),g=function(){var b=kc(this,m.extend({},a),f);(e||m._data(this,"finish"))&&b.stop(!0)};return g.finish=g,e||f.queue===!1?this.each(g):this.queue(f.queue,g)},stop:function(a,b,c){var d=function(a){var b=a.stop;delete a.stop,b(c)};return"string"!=typeof a&&(c=b,b=a,a=void 0),b&&a!==!1&&this.queue(a||"fx",[]),this.each(function(){var b=!0,e=null!=a&&a+"queueHooks",f=m.timers,g=m._data(this);if(e)g[e]&&g[e].stop&&d(g[e]);else for(e in g)g[e]&&g[e].stop&&cc.test(e)&&d(g[e]);for(e=f.length;e--;)f[e].elem!==this||null!=a&&f[e].queue!==a||(f[e].anim.stop(c),b=!1,f.splice(e,1));(b||!c)&&m.dequeue(this,a)})},finish:function(a){return a!==!1&&(a=a||"fx"),this.each(function(){var b,c=m._data(this),d=c[a+"queue"],e=c[a+"queueHooks"],f=m.timers,g=d?d.length:0;for(c.finish=!0,m.queue(this,a,[]),e&&e.stop&&e.stop.call(this,!0),b=f.length;b--;)f[b].elem===this&&f[b].queue===a&&(f[b].anim.stop(!0),f.splice(b,1));for(b=0;g>b;b++)d[b]&&d[b].finish&&d[b].finish.call(this);delete c.finish})}}),m.each(["toggle","show","hide"],function(a,b){var c=m.fn[b];m.fn[b]=function(a,d,e){return null==a||"boolean"==typeof a?c.apply(this,arguments):this.animate(gc(b,!0),a,d,e)}}),m.each({slideDown:gc("show"),slideUp:gc("hide"),slideToggle:gc("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(a,b){m.fn[a]=function(a,c,d){return this.animate(b,a,c,d)}}),m.timers=[],m.fx.tick=function(){var a,b=m.timers,c=0;for($b=m.now();c<b.length;c++)a=b[c],a()||b[c]!==a||b.splice(c--,1);b.length||m.fx.stop(),$b=void 0},m.fx.timer=function(a){m.timers.push(a),a()?m.fx.start():m.timers.pop()},m.fx.interval=13,m.fx.start=function(){_b||(_b=setInterval(m.fx.tick,m.fx.interval))},m.fx.stop=function(){clearInterval(_b),_b=null},m.fx.speeds={slow:600,fast:200,_default:400},m.fn.delay=function(a,b){return a=m.fx?m.fx.speeds[a]||a:a,b=b||"fx",this.queue(b,function(b,c){var d=setTimeout(b,a);c.stop=function(){clearTimeout(d)}})},function(){var a,b,c,d,e;b=y.createElement("div"),b.setAttribute("className","t"),b.innerHTML="  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>",d=b.getElementsByTagName("a")[0],c=y.createElement("select"),e=c.appendChild(y.createElement("option")),a=b.getElementsByTagName("input")[0],d.style.cssText="top:1px",k.getSetAttribute="t"!==b.className,k.style=/top/.test(d.getAttribute("style")),k.hrefNormalized="/a"===d.getAttribute("href"),k.checkOn=!!a.value,k.optSelected=e.selected,k.enctype=!!y.createElement("form").enctype,c.disabled=!0,k.optDisabled=!e.disabled,a=y.createElement("input"),a.setAttribute("value",""),k.input=""===a.getAttribute("value"),a.value="t",a.setAttribute("type","radio"),k.radioValue="t"===a.value}();var lc=/\r/g;m.fn.extend({val:function(a){var b,c,d,e=this[0];{if(arguments.length)return d=m.isFunction(a),this.each(function(c){var e;1===this.nodeType&&(e=d?a.call(this,c,m(this).val()):a,null==e?e="":"number"==typeof e?e+="":m.isArray(e)&&(e=m.map(e,function(a){return null==a?"":a+""})),b=m.valHooks[this.type]||m.valHooks[this.nodeName.toLowerCase()],b&&"set"in b&&void 0!==b.set(this,e,"value")||(this.value=e))});if(e)return b=m.valHooks[e.type]||m.valHooks[e.nodeName.toLowerCase()],b&&"get"in b&&void 0!==(c=b.get(e,"value"))?c:(c=e.value,"string"==typeof c?c.replace(lc,""):null==c?"":c)}}}),m.extend({valHooks:{option:{get:function(a){var b=m.find.attr(a,"value");return null!=b?b:m.trim(m.text(a))}},select:{get:function(a){for(var b,c,d=a.options,e=a.selectedIndex,f="select-one"===a.type||0>e,g=f?null:[],h=f?e+1:d.length,i=0>e?h:f?e:0;h>i;i++)if(c=d[i],!(!c.selected&&i!==e||(k.optDisabled?c.disabled:null!==c.getAttribute("disabled"))||c.parentNode.disabled&&m.nodeName(c.parentNode,"optgroup"))){if(b=m(c).val(),f)return b;g.push(b)}return g},set:function(a,b){var c,d,e=a.options,f=m.makeArray(b),g=e.length;while(g--)if(d=e[g],m.inArray(m.valHooks.option.get(d),f)>=0)try{d.selected=c=!0}catch(h){d.scrollHeight}else d.selected=!1;return c||(a.selectedIndex=-1),e}}}}),m.each(["radio","checkbox"],function(){m.valHooks[this]={set:function(a,b){return m.isArray(b)?a.checked=m.inArray(m(a).val(),b)>=0:void 0}},k.checkOn||(m.valHooks[this].get=function(a){return null===a.getAttribute("value")?"on":a.value})});var mc,nc,oc=m.expr.attrHandle,pc=/^(?:checked|selected)$/i,qc=k.getSetAttribute,rc=k.input;m.fn.extend({attr:function(a,b){return V(this,m.attr,a,b,arguments.length>1)},removeAttr:function(a){return this.each(function(){m.removeAttr(this,a)})}}),m.extend({attr:function(a,b,c){var d,e,f=a.nodeType;if(a&&3!==f&&8!==f&&2!==f)return typeof a.getAttribute===K?m.prop(a,b,c):(1===f&&m.isXMLDoc(a)||(b=b.toLowerCase(),d=m.attrHooks[b]||(m.expr.match.bool.test(b)?nc:mc)),void 0===c?d&&"get"in d&&null!==(e=d.get(a,b))?e:(e=m.find.attr(a,b),null==e?void 0:e):null!==c?d&&"set"in d&&void 0!==(e=d.set(a,c,b))?e:(a.setAttribute(b,c+""),c):void m.removeAttr(a,b))},removeAttr:function(a,b){var c,d,e=0,f=b&&b.match(E);if(f&&1===a.nodeType)while(c=f[e++])d=m.propFix[c]||c,m.expr.match.bool.test(c)?rc&&qc||!pc.test(c)?a[d]=!1:a[m.camelCase("default-"+c)]=a[d]=!1:m.attr(a,c,""),a.removeAttribute(qc?c:d)},attrHooks:{type:{set:function(a,b){if(!k.radioValue&&"radio"===b&&m.nodeName(a,"input")){var c=a.value;return a.setAttribute("type",b),c&&(a.value=c),b}}}}}),nc={set:function(a,b,c){return b===!1?m.removeAttr(a,c):rc&&qc||!pc.test(c)?a.setAttribute(!qc&&m.propFix[c]||c,c):a[m.camelCase("default-"+c)]=a[c]=!0,c}},m.each(m.expr.match.bool.source.match(/\w+/g),function(a,b){var c=oc[b]||m.find.attr;oc[b]=rc&&qc||!pc.test(b)?function(a,b,d){var e,f;return d||(f=oc[b],oc[b]=e,e=null!=c(a,b,d)?b.toLowerCase():null,oc[b]=f),e}:function(a,b,c){return c?void 0:a[m.camelCase("default-"+b)]?b.toLowerCase():null}}),rc&&qc||(m.attrHooks.value={set:function(a,b,c){return m.nodeName(a,"input")?void(a.defaultValue=b):mc&&mc.set(a,b,c)}}),qc||(mc={set:function(a,b,c){var d=a.getAttributeNode(c);return d||a.setAttributeNode(d=a.ownerDocument.createAttribute(c)),d.value=b+="","value"===c||b===a.getAttribute(c)?b:void 0}},oc.id=oc.name=oc.coords=function(a,b,c){var d;return c?void 0:(d=a.getAttributeNode(b))&&""!==d.value?d.value:null},m.valHooks.button={get:function(a,b){var c=a.getAttributeNode(b);return c&&c.specified?c.value:void 0},set:mc.set},m.attrHooks.contenteditable={set:function(a,b,c){mc.set(a,""===b?!1:b,c)}},m.each(["width","height"],function(a,b){m.attrHooks[b]={set:function(a,c){return""===c?(a.setAttribute(b,"auto"),c):void 0}}})),k.style||(m.attrHooks.style={get:function(a){return a.style.cssText||void 0},set:function(a,b){return a.style.cssText=b+""}});var sc=/^(?:input|select|textarea|button|object)$/i,tc=/^(?:a|area)$/i;m.fn.extend({prop:function(a,b){return V(this,m.prop,a,b,arguments.length>1)},removeProp:function(a){return a=m.propFix[a]||a,this.each(function(){try{this[a]=void 0,delete this[a]}catch(b){}})}}),m.extend({propFix:{"for":"htmlFor","class":"className"},prop:function(a,b,c){var d,e,f,g=a.nodeType;if(a&&3!==g&&8!==g&&2!==g)return f=1!==g||!m.isXMLDoc(a),f&&(b=m.propFix[b]||b,e=m.propHooks[b]),void 0!==c?e&&"set"in e&&void 0!==(d=e.set(a,c,b))?d:a[b]=c:e&&"get"in e&&null!==(d=e.get(a,b))?d:a[b]},propHooks:{tabIndex:{get:function(a){var b=m.find.attr(a,"tabindex");return b?parseInt(b,10):sc.test(a.nodeName)||tc.test(a.nodeName)&&a.href?0:-1}}}}),k.hrefNormalized||m.each(["href","src"],function(a,b){m.propHooks[b]={get:function(a){return a.getAttribute(b,4)}}}),k.optSelected||(m.propHooks.selected={get:function(a){var b=a.parentNode;return b&&(b.selectedIndex,b.parentNode&&b.parentNode.selectedIndex),null}}),m.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){m.propFix[this.toLowerCase()]=this}),k.enctype||(m.propFix.enctype="encoding");var uc=/[\t\r\n\f]/g;m.fn.extend({addClass:function(a){var b,c,d,e,f,g,h=0,i=this.length,j="string"==typeof a&&a;if(m.isFunction(a))return this.each(function(b){m(this).addClass(a.call(this,b,this.className))});if(j)for(b=(a||"").match(E)||[];i>h;h++)if(c=this[h],d=1===c.nodeType&&(c.className?(" "+c.className+" ").replace(uc," "):" ")){f=0;while(e=b[f++])d.indexOf(" "+e+" ")<0&&(d+=e+" ");g=m.trim(d),c.className!==g&&(c.className=g)}return this},removeClass:function(a){var b,c,d,e,f,g,h=0,i=this.length,j=0===arguments.length||"string"==typeof a&&a;if(m.isFunction(a))return this.each(function(b){m(this).removeClass(a.call(this,b,this.className))});if(j)for(b=(a||"").match(E)||[];i>h;h++)if(c=this[h],d=1===c.nodeType&&(c.className?(" "+c.className+" ").replace(uc," "):"")){f=0;while(e=b[f++])while(d.indexOf(" "+e+" ")>=0)d=d.replace(" "+e+" "," ");g=a?m.trim(d):"",c.className!==g&&(c.className=g)}return this},toggleClass:function(a,b){var c=typeof a;return"boolean"==typeof b&&"string"===c?b?this.addClass(a):this.removeClass(a):this.each(m.isFunction(a)?function(c){m(this).toggleClass(a.call(this,c,this.className,b),b)}:function(){if("string"===c){var b,d=0,e=m(this),f=a.match(E)||[];while(b=f[d++])e.hasClass(b)?e.removeClass(b):e.addClass(b)}else(c===K||"boolean"===c)&&(this.className&&m._data(this,"__className__",this.className),this.className=this.className||a===!1?"":m._data(this,"__className__")||"")})},hasClass:function(a){for(var b=" "+a+" ",c=0,d=this.length;d>c;c++)if(1===this[c].nodeType&&(" "+this[c].className+" ").replace(uc," ").indexOf(b)>=0)return!0;return!1}}),m.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "),function(a,b){m.fn[b]=function(a,c){return arguments.length>0?this.on(b,null,a,c):this.trigger(b)}}),m.fn.extend({hover:function(a,b){return this.mouseenter(a).mouseleave(b||a)},bind:function(a,b,c){return this.on(a,null,b,c)},unbind:function(a,b){return this.off(a,null,b)},delegate:function(a,b,c,d){return this.on(b,a,c,d)},undelegate:function(a,b,c){return 1===arguments.length?this.off(a,"**"):this.off(b,a||"**",c)}});var vc=m.now(),wc=/\?/,xc=/(,)|(\[|{)|(}|])|"(?:[^"\\\r\n]|\\["\\\/bfnrt]|\\u[\da-fA-F]{4})*"\s*:?|true|false|null|-?(?!0\d)\d+(?:\.\d+|)(?:[eE][+-]?\d+|)/g;m.parseJSON=function(b){if(a.JSON&&a.JSON.parse)return a.JSON.parse(b+"");var c,d=null,e=m.trim(b+"");return e&&!m.trim(e.replace(xc,function(a,b,e,f){return c&&b&&(d=0),0===d?a:(c=e||b,d+=!f-!e,"")}))?Function("return "+e)():m.error("Invalid JSON: "+b)},m.parseXML=function(b){var c,d;if(!b||"string"!=typeof b)return null;try{a.DOMParser?(d=new DOMParser,c=d.parseFromString(b,"text/xml")):(c=new ActiveXObject("Microsoft.XMLDOM"),c.async="false",c.loadXML(b))}catch(e){c=void 0}return c&&c.documentElement&&!c.getElementsByTagName("parsererror").length||m.error("Invalid XML: "+b),c};var yc,zc,Ac=/#.*$/,Bc=/([?&])_=[^&]*/,Cc=/^(.*?):[ \t]*([^\r\n]*)\r?$/gm,Dc=/^(?:about|app|app-storage|.+-extension|file|res|widget):$/,Ec=/^(?:GET|HEAD)$/,Fc=/^\/\//,Gc=/^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/,Hc={},Ic={},Jc="*/".concat("*");try{zc=location.href}catch(Kc){zc=y.createElement("a"),zc.href="",zc=zc.href}yc=Gc.exec(zc.toLowerCase())||[];function Lc(a){return function(b,c){"string"!=typeof b&&(c=b,b="*");var d,e=0,f=b.toLowerCase().match(E)||[];if(m.isFunction(c))while(d=f[e++])"+"===d.charAt(0)?(d=d.slice(1)||"*",(a[d]=a[d]||[]).unshift(c)):(a[d]=a[d]||[]).push(c)}}function Mc(a,b,c,d){var e={},f=a===Ic;function g(h){var i;return e[h]=!0,m.each(a[h]||[],function(a,h){var j=h(b,c,d);return"string"!=typeof j||f||e[j]?f?!(i=j):void 0:(b.dataTypes.unshift(j),g(j),!1)}),i}return g(b.dataTypes[0])||!e["*"]&&g("*")}function Nc(a,b){var c,d,e=m.ajaxSettings.flatOptions||{};for(d in b)void 0!==b[d]&&((e[d]?a:c||(c={}))[d]=b[d]);return c&&m.extend(!0,a,c),a}function Oc(a,b,c){var d,e,f,g,h=a.contents,i=a.dataTypes;while("*"===i[0])i.shift(),void 0===e&&(e=a.mimeType||b.getResponseHeader("Content-Type"));if(e)for(g in h)if(h[g]&&h[g].test(e)){i.unshift(g);break}if(i[0]in c)f=i[0];else{for(g in c){if(!i[0]||a.converters[g+" "+i[0]]){f=g;break}d||(d=g)}f=f||d}return f?(f!==i[0]&&i.unshift(f),c[f]):void 0}function Pc(a,b,c,d){var e,f,g,h,i,j={},k=a.dataTypes.slice();if(k[1])for(g in a.converters)j[g.toLowerCase()]=a.converters[g];f=k.shift();while(f)if(a.responseFields[f]&&(c[a.responseFields[f]]=b),!i&&d&&a.dataFilter&&(b=a.dataFilter(b,a.dataType)),i=f,f=k.shift())if("*"===f)f=i;else if("*"!==i&&i!==f){if(g=j[i+" "+f]||j["* "+f],!g)for(e in j)if(h=e.split(" "),h[1]===f&&(g=j[i+" "+h[0]]||j["* "+h[0]])){g===!0?g=j[e]:j[e]!==!0&&(f=h[0],k.unshift(h[1]));break}if(g!==!0)if(g&&a["throws"])b=g(b);else try{b=g(b)}catch(l){return{state:"parsererror",error:g?l:"No conversion from "+i+" to "+f}}}return{state:"success",data:b}}m.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:zc,type:"GET",isLocal:Dc.test(yc[1]),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":Jc,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/xml/,html:/html/,json:/json/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":m.parseJSON,"text xml":m.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(a,b){return b?Nc(Nc(a,m.ajaxSettings),b):Nc(m.ajaxSettings,a)},ajaxPrefilter:Lc(Hc),ajaxTransport:Lc(Ic),ajax:function(a,b){"object"==typeof a&&(b=a,a=void 0),b=b||{};var c,d,e,f,g,h,i,j,k=m.ajaxSetup({},b),l=k.context||k,n=k.context&&(l.nodeType||l.jquery)?m(l):m.event,o=m.Deferred(),p=m.Callbacks("once memory"),q=k.statusCode||{},r={},s={},t=0,u="canceled",v={readyState:0,getResponseHeader:function(a){var b;if(2===t){if(!j){j={};while(b=Cc.exec(f))j[b[1].toLowerCase()]=b[2]}b=j[a.toLowerCase()]}return null==b?null:b},getAllResponseHeaders:function(){return 2===t?f:null},setRequestHeader:function(a,b){var c=a.toLowerCase();return t||(a=s[c]=s[c]||a,r[a]=b),this},overrideMimeType:function(a){return t||(k.mimeType=a),this},statusCode:function(a){var b;if(a)if(2>t)for(b in a)q[b]=[q[b],a[b]];else v.always(a[v.status]);return this},abort:function(a){var b=a||u;return i&&i.abort(b),x(0,b),this}};if(o.promise(v).complete=p.add,v.success=v.done,v.error=v.fail,k.url=((a||k.url||zc)+"").replace(Ac,"").replace(Fc,yc[1]+"//"),k.type=b.method||b.type||k.method||k.type,k.dataTypes=m.trim(k.dataType||"*").toLowerCase().match(E)||[""],null==k.crossDomain&&(c=Gc.exec(k.url.toLowerCase()),k.crossDomain=!(!c||c[1]===yc[1]&&c[2]===yc[2]&&(c[3]||("http:"===c[1]?"80":"443"))===(yc[3]||("http:"===yc[1]?"80":"443")))),k.data&&k.processData&&"string"!=typeof k.data&&(k.data=m.param(k.data,k.traditional)),Mc(Hc,k,b,v),2===t)return v;h=k.global,h&&0===m.active++&&m.event.trigger("ajaxStart"),k.type=k.type.toUpperCase(),k.hasContent=!Ec.test(k.type),e=k.url,k.hasContent||(k.data&&(e=k.url+=(wc.test(e)?"&":"?")+k.data,delete k.data),k.cache===!1&&(k.url=Bc.test(e)?e.replace(Bc,"$1_="+vc++):e+(wc.test(e)?"&":"?")+"_="+vc++)),k.ifModified&&(m.lastModified[e]&&v.setRequestHeader("If-Modified-Since",m.lastModified[e]),m.etag[e]&&v.setRequestHeader("If-None-Match",m.etag[e])),(k.data&&k.hasContent&&k.contentType!==!1||b.contentType)&&v.setRequestHeader("Content-Type",k.contentType),v.setRequestHeader("Accept",k.dataTypes[0]&&k.accepts[k.dataTypes[0]]?k.accepts[k.dataTypes[0]]+("*"!==k.dataTypes[0]?", "+Jc+"; q=0.01":""):k.accepts["*"]);for(d in k.headers)v.setRequestHeader(d,k.headers[d]);if(k.beforeSend&&(k.beforeSend.call(l,v,k)===!1||2===t))return v.abort();u="abort";for(d in{success:1,error:1,complete:1})v[d](k[d]);if(i=Mc(Ic,k,b,v)){v.readyState=1,h&&n.trigger("ajaxSend",[v,k]),k.async&&k.timeout>0&&(g=setTimeout(function(){v.abort("timeout")},k.timeout));try{t=1,i.send(r,x)}catch(w){if(!(2>t))throw w;x(-1,w)}}else x(-1,"No Transport");function x(a,b,c,d){var j,r,s,u,w,x=b;2!==t&&(t=2,g&&clearTimeout(g),i=void 0,f=d||"",v.readyState=a>0?4:0,j=a>=200&&300>a||304===a,c&&(u=Oc(k,v,c)),u=Pc(k,u,v,j),j?(k.ifModified&&(w=v.getResponseHeader("Last-Modified"),w&&(m.lastModified[e]=w),w=v.getResponseHeader("etag"),w&&(m.etag[e]=w)),204===a||"HEAD"===k.type?x="nocontent":304===a?x="notmodified":(x=u.state,r=u.data,s=u.error,j=!s)):(s=x,(a||!x)&&(x="error",0>a&&(a=0))),v.status=a,v.statusText=(b||x)+"",j?o.resolveWith(l,[r,x,v]):o.rejectWith(l,[v,x,s]),v.statusCode(q),q=void 0,h&&n.trigger(j?"ajaxSuccess":"ajaxError",[v,k,j?r:s]),p.fireWith(l,[v,x]),h&&(n.trigger("ajaxComplete",[v,k]),--m.active||m.event.trigger("ajaxStop")))}return v},getJSON:function(a,b,c){return m.get(a,b,c,"json")},getScript:function(a,b){return m.get(a,void 0,b,"script")}}),m.each(["get","post"],function(a,b){m[b]=function(a,c,d,e){return m.isFunction(c)&&(e=e||d,d=c,c=void 0),m.ajax({url:a,type:b,dataType:e,data:c,success:d})}}),m.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(a,b){m.fn[b]=function(a){return this.on(b,a)}}),m._evalUrl=function(a){return m.ajax({url:a,type:"GET",dataType:"script",async:!1,global:!1,"throws":!0})},m.fn.extend({wrapAll:function(a){if(m.isFunction(a))return this.each(function(b){m(this).wrapAll(a.call(this,b))});if(this[0]){var b=m(a,this[0].ownerDocument).eq(0).clone(!0);this[0].parentNode&&b.insertBefore(this[0]),b.map(function(){var a=this;while(a.firstChild&&1===a.firstChild.nodeType)a=a.firstChild;return a}).append(this)}return this},wrapInner:function(a){return this.each(m.isFunction(a)?function(b){m(this).wrapInner(a.call(this,b))}:function(){var b=m(this),c=b.contents();c.length?c.wrapAll(a):b.append(a)})},wrap:function(a){var b=m.isFunction(a);return this.each(function(c){m(this).wrapAll(b?a.call(this,c):a)})},unwrap:function(){return this.parent().each(function(){m.nodeName(this,"body")||m(this).replaceWith(this.childNodes)}).end()}}),m.expr.filters.hidden=function(a){return a.offsetWidth<=0&&a.offsetHeight<=0||!k.reliableHiddenOffsets()&&"none"===(a.style&&a.style.display||m.css(a,"display"))},m.expr.filters.visible=function(a){return!m.expr.filters.hidden(a)};var Qc=/%20/g,Rc=/\[\]$/,Sc=/\r?\n/g,Tc=/^(?:submit|button|image|reset|file)$/i,Uc=/^(?:input|select|textarea|keygen)/i;function Vc(a,b,c,d){var e;if(m.isArray(b))m.each(b,function(b,e){c||Rc.test(a)?d(a,e):Vc(a+"["+("object"==typeof e?b:"")+"]",e,c,d)});else if(c||"object"!==m.type(b))d(a,b);else for(e in b)Vc(a+"["+e+"]",b[e],c,d)}m.param=function(a,b){var c,d=[],e=function(a,b){b=m.isFunction(b)?b():null==b?"":b,d[d.length]=encodeURIComponent(a)+"="+encodeURIComponent(b)};if(void 0===b&&(b=m.ajaxSettings&&m.ajaxSettings.traditional),m.isArray(a)||a.jquery&&!m.isPlainObject(a))m.each(a,function(){e(this.name,this.value)});else for(c in a)Vc(c,a[c],b,e);return d.join("&").replace(Qc,"+")},m.fn.extend({serialize:function(){return m.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var a=m.prop(this,"elements");return a?m.makeArray(a):this}).filter(function(){var a=this.type;return this.name&&!m(this).is(":disabled")&&Uc.test(this.nodeName)&&!Tc.test(a)&&(this.checked||!W.test(a))}).map(function(a,b){var c=m(this).val();return null==c?null:m.isArray(c)?m.map(c,function(a){return{name:b.name,value:a.replace(Sc,"\r\n")}}):{name:b.name,value:c.replace(Sc,"\r\n")}}).get()}}),m.ajaxSettings.xhr=void 0!==a.ActiveXObject?function(){return!this.isLocal&&/^(get|post|head|put|delete|options)$/i.test(this.type)&&Zc()||$c()}:Zc;var Wc=0,Xc={},Yc=m.ajaxSettings.xhr();a.ActiveXObject&&m(a).on("unload",function(){for(var a in Xc)Xc[a](void 0,!0)}),k.cors=!!Yc&&"withCredentials"in Yc,Yc=k.ajax=!!Yc,Yc&&m.ajaxTransport(function(a){if(!a.crossDomain||k.cors){var b;return{send:function(c,d){var e,f=a.xhr(),g=++Wc;if(f.open(a.type,a.url,a.async,a.username,a.password),a.xhrFields)for(e in a.xhrFields)f[e]=a.xhrFields[e];a.mimeType&&f.overrideMimeType&&f.overrideMimeType(a.mimeType),a.crossDomain||c["X-Requested-With"]||(c["X-Requested-With"]="XMLHttpRequest");for(e in c)void 0!==c[e]&&f.setRequestHeader(e,c[e]+"");f.send(a.hasContent&&a.data||null),b=function(c,e){var h,i,j;if(b&&(e||4===f.readyState))if(delete Xc[g],b=void 0,f.onreadystatechange=m.noop,e)4!==f.readyState&&f.abort();else{j={},h=f.status,"string"==typeof f.responseText&&(j.text=f.responseText);try{i=f.statusText}catch(k){i=""}h||!a.isLocal||a.crossDomain?1223===h&&(h=204):h=j.text?200:404}j&&d(h,i,j,f.getAllResponseHeaders())},a.async?4===f.readyState?setTimeout(b):f.onreadystatechange=Xc[g]=b:b()},abort:function(){b&&b(void 0,!0)}}}});function Zc(){try{return new a.XMLHttpRequest}catch(b){}}function $c(){try{return new a.ActiveXObject("Microsoft.XMLHTTP")}catch(b){}}m.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/(?:java|ecma)script/},converters:{"text script":function(a){return m.globalEval(a),a}}}),m.ajaxPrefilter("script",function(a){void 0===a.cache&&(a.cache=!1),a.crossDomain&&(a.type="GET",a.global=!1)}),m.ajaxTransport("script",function(a){if(a.crossDomain){var b,c=y.head||m("head")[0]||y.documentElement;return{send:function(d,e){b=y.createElement("script"),b.async=!0,a.scriptCharset&&(b.charset=a.scriptCharset),b.src=a.url,b.onload=b.onreadystatechange=function(a,c){(c||!b.readyState||/loaded|complete/.test(b.readyState))&&(b.onload=b.onreadystatechange=null,b.parentNode&&b.parentNode.removeChild(b),b=null,c||e(200,"success"))},c.insertBefore(b,c.firstChild)},abort:function(){b&&b.onload(void 0,!0)}}}});var _c=[],ad=/(=)\?(?=&|$)|\?\?/;m.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var a=_c.pop()||m.expando+"_"+vc++;return this[a]=!0,a}}),m.ajaxPrefilter("json jsonp",function(b,c,d){var e,f,g,h=b.jsonp!==!1&&(ad.test(b.url)?"url":"string"==typeof b.data&&!(b.contentType||"").indexOf("application/x-www-form-urlencoded")&&ad.test(b.data)&&"data");return h||"jsonp"===b.dataTypes[0]?(e=b.jsonpCallback=m.isFunction(b.jsonpCallback)?b.jsonpCallback():b.jsonpCallback,h?b[h]=b[h].replace(ad,"$1"+e):b.jsonp!==!1&&(b.url+=(wc.test(b.url)?"&":"?")+b.jsonp+"="+e),b.converters["script json"]=function(){return g||m.error(e+" was not called"),g[0]},b.dataTypes[0]="json",f=a[e],a[e]=function(){g=arguments},d.always(function(){a[e]=f,b[e]&&(b.jsonpCallback=c.jsonpCallback,_c.push(e)),g&&m.isFunction(f)&&f(g[0]),g=f=void 0}),"script"):void 0}),m.parseHTML=function(a,b,c){if(!a||"string"!=typeof a)return null;"boolean"==typeof b&&(c=b,b=!1),b=b||y;var d=u.exec(a),e=!c&&[];return d?[b.createElement(d[1])]:(d=m.buildFragment([a],b,e),e&&e.length&&m(e).remove(),m.merge([],d.childNodes))};var bd=m.fn.load;m.fn.load=function(a,b,c){if("string"!=typeof a&&bd)return bd.apply(this,arguments);var d,e,f,g=this,h=a.indexOf(" ");return h>=0&&(d=m.trim(a.slice(h,a.length)),a=a.slice(0,h)),m.isFunction(b)?(c=b,b=void 0):b&&"object"==typeof b&&(f="POST"),g.length>0&&m.ajax({url:a,type:f,dataType:"html",data:b}).done(function(a){e=arguments,g.html(d?m("<div>").append(m.parseHTML(a)).find(d):a)}).complete(c&&function(a,b){g.each(c,e||[a.responseText,b,a])}),this},m.expr.filters.animated=function(a){return m.grep(m.timers,function(b){return a===b.elem}).length};var cd=a.document.documentElement;function dd(a){return m.isWindow(a)?a:9===a.nodeType?a.defaultView||a.parentWindow:!1}m.offset={setOffset:function(a,b,c){var d,e,f,g,h,i,j,k=m.css(a,"position"),l=m(a),n={};"static"===k&&(a.style.position="relative"),h=l.offset(),f=m.css(a,"top"),i=m.css(a,"left"),j=("absolute"===k||"fixed"===k)&&m.inArray("auto",[f,i])>-1,j?(d=l.position(),g=d.top,e=d.left):(g=parseFloat(f)||0,e=parseFloat(i)||0),m.isFunction(b)&&(b=b.call(a,c,h)),null!=b.top&&(n.top=b.top-h.top+g),null!=b.left&&(n.left=b.left-h.left+e),"using"in b?b.using.call(a,n):l.css(n)}},m.fn.extend({offset:function(a){if(arguments.length)return void 0===a?this:this.each(function(b){m.offset.setOffset(this,a,b)});var b,c,d={top:0,left:0},e=this[0],f=e&&e.ownerDocument;if(f)return b=f.documentElement,m.contains(b,e)?(typeof e.getBoundingClientRect!==K&&(d=e.getBoundingClientRect()),c=dd(f),{top:d.top+(c.pageYOffset||b.scrollTop)-(b.clientTop||0),left:d.left+(c.pageXOffset||b.scrollLeft)-(b.clientLeft||0)}):d},position:function(){if(this[0]){var a,b,c={top:0,left:0},d=this[0];return"fixed"===m.css(d,"position")?b=d.getBoundingClientRect():(a=this.offsetParent(),b=this.offset(),m.nodeName(a[0],"html")||(c=a.offset()),c.top+=m.css(a[0],"borderTopWidth",!0),c.left+=m.css(a[0],"borderLeftWidth",!0)),{top:b.top-c.top-m.css(d,"marginTop",!0),left:b.left-c.left-m.css(d,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){var a=this.offsetParent||cd;while(a&&!m.nodeName(a,"html")&&"static"===m.css(a,"position"))a=a.offsetParent;return a||cd})}}),m.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(a,b){var c=/Y/.test(b);m.fn[a]=function(d){return V(this,function(a,d,e){var f=dd(a);return void 0===e?f?b in f?f[b]:f.document.documentElement[d]:a[d]:void(f?f.scrollTo(c?m(f).scrollLeft():e,c?e:m(f).scrollTop()):a[d]=e)},a,d,arguments.length,null)}}),m.each(["top","left"],function(a,b){m.cssHooks[b]=Lb(k.pixelPosition,function(a,c){return c?(c=Jb(a,b),Hb.test(c)?m(a).position()[b]+"px":c):void 0})}),m.each({Height:"height",Width:"width"},function(a,b){m.each({padding:"inner"+a,content:b,"":"outer"+a},function(c,d){m.fn[d]=function(d,e){var f=arguments.length&&(c||"boolean"!=typeof d),g=c||(d===!0||e===!0?"margin":"border");return V(this,function(b,c,d){var e;return m.isWindow(b)?b.document.documentElement["client"+a]:9===b.nodeType?(e=b.documentElement,Math.max(b.body["scroll"+a],e["scroll"+a],b.body["offset"+a],e["offset"+a],e["client"+a])):void 0===d?m.css(b,c,g):m.style(b,c,d,g)},b,f?d:void 0,f,null)}})}),m.fn.size=function(){return this.length},m.fn.andSelf=m.fn.addBack,"function"==typeof define&&define.amd&&define("jquery",[],function(){return m});var ed=a.jQuery,fd=a.$;return m.noConflict=function(b){return a.$===m&&(a.$=fd),b&&a.jQuery===m&&(a.jQuery=ed),m},typeof b===K&&(a.jQuery=a.$=m),m});


/***************************
File generated by shrinker.ch
DateTime: 2015-08-01, 19:29:00
File list:
	* jscript_jquery.autocomplete.js
	* jscript_jquery.bootstrap.min.js
	* jscript_jquery.easing.1.3.js
	* jscript_jquery.nouislider.all.min.js
	* jscript_jquery.scrollbar.min.js
	* jscript_jquery.themepunch.revolution.min.js
	* jscript_jquery.themepunch.tools.min.js
	* jscript_owl.carousel.min.js
	* jscript_utils.js
	* jscript_waypoints.min.js
	* morphling.js
*****************************/
(function(b){typeof define==="function"&&define.amd?define(["jquery"],b):b(jQuery)})(function(b){function f(c,e){var j=function(){};j={autoSelectFirst:false,appendTo:document.body,serviceUrl:null,lookup:null,onSelect:null,width:"auto",minChars:1,maxHeight:300,deferRequestBy:0,params:{},formatResult:f.formatResult,delimiter:null,zIndex:9999,type:"GET",noCache:false,onSearchStart:j,onSearchComplete:j,onSearchError:j,containerClass:"autocomplete-suggestions",tabDisabled:false,dataType:"text",currentRequest:null,
triggerSelectOnValidInput:true,preventBadQueries:true,lookupFilter:function(s,w,K){return s.value.toLowerCase().indexOf(K)!==-1},paramName:"query",transformResult:function(s){return typeof s==="string"?b.parseJSON(s):s},showNoSuggestionNotice:false,noSuggestionNotice:"No results",orientation:"bottom",forceFixPosition:false};this.element=c;this.el=b(c);this.suggestions=[];this.badQueries=[];this.selectedIndex=-1;this.currentValue=this.element.value;this.intervalId=0;this.cachedResponse={};this.onChange=
this.onChangeInterval=null;this.isLocal=false;this.noSuggestionsContainer=this.suggestionsContainer=null;this.options=b.extend({},j,e);this.classes={selected:"autocomplete-selected",suggestion:"autocomplete-suggestion"};this.hint=null;this.hintValue="";this.selection=null;this.initialize();this.setOptions(e)}var n=function(){return{escapeRegExChars:function(c){return c.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,"\\$&")},createNode:function(c){var e=document.createElement("div");e.className=c;e.style.position=
"absolute";e.style.display="none";return e}}}(),g={ESC:27,TAB:9,RETURN:13,LEFT:37,UP:38,RIGHT:39,DOWN:40};f.utils=n;b.Autocomplete=f;f.formatResult=function(c,e){var j="("+n.escapeRegExChars(e)+")";return c.value.replace(RegExp(j,"gi"),"$1")};f.prototype={killerFn:null,initialize:function(){var c=this,e="."+c.classes.suggestion,j=c.classes.selected,s=c.options,w;c.element.setAttribute("autocomplete","off");c.killerFn=function(K){if(b(K.target).closest("."+c.options.containerClass).length===0){c.killSuggestions();
c.disableKillerFn()}};c.noSuggestionsContainer=b('<div class="autocomplete-no-suggestion"></div>').html(this.options.noSuggestionNotice).get(0);c.suggestionsContainer=f.utils.createNode(s.containerClass);w=b(c.suggestionsContainer);w.appendTo(s.appendTo);s.width!=="auto"&&w.width(s.width);w.on("mouseover.autocomplete",e,function(){c.activate(b(this).data("index"))});w.on("mouseout.autocomplete",function(){c.selectedIndex=-1;w.children("."+j).removeClass(j)});w.on("click.autocomplete",e,function(){});
c.fixPositionCapture=function(){c.visible&&c.fixPosition()};b(window).on("resize.autocomplete",c.fixPositionCapture);c.el.on("keydown.autocomplete",function(K){c.onKeyPress(K)});c.el.on("keyup.autocomplete",function(K){c.onKeyUp(K)});c.el.on("blur.autocomplete",function(){c.onBlur()});c.el.on("focus.autocomplete",function(){c.onFocus()});c.el.on("change.autocomplete",function(K){c.onKeyUp(K)})},onFocus:function(){this.fixPosition();if(this.options.minChars<=this.el.val().length)this.onValueChange()},
onBlur:function(){this.enableKillerFn()},setOptions:function(c){var e=this.options;b.extend(e,c);if(this.isLocal=b.isArray(e.lookup))e.lookup=this.verifySuggestionsFormat(e.lookup);e.orientation=this.validateOrientation(e.orientation,"bottom");b(this.suggestionsContainer).css({"max-height":e.maxHeight+"px",width:e.width+"px","z-index":e.zIndex})},clearCache:function(){this.cachedResponse={};this.badQueries=[]},clear:function(){this.clearCache();this.currentValue="";this.suggestions=[]},disable:function(){this.disabled=
true;this.currentRequest&&this.currentRequest.abort()},enable:function(){this.disabled=false},fixPosition:function(){var c=b(this.suggestionsContainer),e=c.parent().get(0);if(!(e!==document.body&&!this.options.forceFixPosition)){var j=this.options.orientation,s=c.outerHeight(),w=this.el.outerHeight(),K=this.el.offset(),p={top:K.top,left:K.left};if(j=="auto"){j=b(window).height();var L=b(window).scrollTop(),N=-L+K.top-s;j=Math.max(N,L+j-(K.top+w+s))===N?"top":"bottom"}p.top+=j==="top"?-s:w;if(e!==
document.body){e=c.css("opacity");this.visible||c.css("opacity",0).show();s=c.offsetParent().offset();p.top-=s.top;p.left-=s.left;this.visible||c.css("opacity",e).hide()}if(this.options.width==="auto")p.width=this.el.outerWidth()-2+"px";c.css(p)}},enableKillerFn:function(){b(document).on("click.autocomplete",this.killerFn)},disableKillerFn:function(){b(document).off("click.autocomplete",this.killerFn)},killSuggestions:function(){var c=this;c.stopKillSuggestions();c.intervalId=window.setInterval(function(){c.hide();
c.stopKillSuggestions()},50)},stopKillSuggestions:function(){window.clearInterval(this.intervalId)},isCursorAtEnd:function(){var c=this.el.val().length,e=this.element.selectionStart;if(typeof e==="number")return e===c;if(document.selection){e=document.selection.createRange();e.moveStart("character",-c);return c===e.text.length}return true},onKeyPress:function(c){if(!this.disabled&&!this.visible&&c.which===g.DOWN&&this.currentValue)this.suggest();else if(!(this.disabled||!this.visible)){switch(c.which){case g.ESC:this.el.val(this.currentValue);
this.hide();break;case g.RIGHT:if(this.hint&&this.options.onHint&&this.isCursorAtEnd()){this.selectHint();break}return;case g.TAB:if(this.hint&&this.options.onHint){this.selectHint();return}case g.RETURN:if(this.selectedIndex===-1){this.hide();return}this.select(this.selectedIndex);if(c.which===g.TAB&&this.options.tabDisabled===false)return;break;case g.UP:this.moveUp();break;case g.DOWN:this.moveDown();break;default:return}c.stopImmediatePropagation();c.preventDefault()}},onKeyUp:function(c){var e=
this;if(!e.disabled){switch(c.which){case g.UP:case g.DOWN:return}clearInterval(e.onChangeInterval);if(e.currentValue!==e.el.val()){e.findBestHint();if(e.options.deferRequestBy>0)e.onChangeInterval=setInterval(function(){e.onValueChange()},e.options.deferRequestBy);else e.onValueChange()}}},onValueChange:function(){var c=this.options,e=this.el.val(),j=this.getQuery(e);if(this.selection){this.selection=null;(c.onInvalidateSelection||b.noop).call(this.element)}clearInterval(this.onChangeInterval);this.currentValue=
e;this.selectedIndex=-1;if(c.triggerSelectOnValidInput){e=this.findSuggestionIndex(j);if(e!==-1){this.select(e);return}}j.length<c.minChars?this.hide():this.getSuggestions(j)},findSuggestionIndex:function(c){var e=-1,j=c.toLowerCase();b.each(this.suggestions,function(s,w){if(w.value.toLowerCase()===j){e=s;return false}});return e},getQuery:function(c){var e=this.options.delimiter;if(!e)return c;c=c.split(e);return b.trim(c[c.length-1])},getSuggestionsLocal:function(c){var e=this.options,j=c.toLowerCase(),
s=e.lookupFilter,w=parseInt(e.lookupLimit,10);e={suggestions:b.grep(e.lookup,function(K){return s(K,c,j)})};if(w&&e.suggestions.length>w)e.suggestions=e.suggestions.slice(0,w);return e},getSuggestions:function(c){var e,j=this,s=j.options,w=s.serviceUrl,K,p;s.params[s.paramName]=c;K=s.ignoreParams?null:s.params;if(j.isLocal)e=j.getSuggestionsLocal(c);else{if(b.isFunction(w))w=w.call(j.element,c);p=w+"?"+b.param(K||{});e=j.cachedResponse[p]}if(e&&b.isArray(e.suggestions)){j.suggestions=e.suggestions;
j.suggest()}else if(!j.isBadQuery(c))if(s.onSearchStart.call(j.element,s.params)!==false){j.currentRequest&&j.currentRequest.abort();j.currentRequest=b.ajax({url:w,data:K,type:s.type,dataType:s.dataType}).done(function(L){j.currentRequest=null;L=s.transformResult(L);j.processResponse(L,c,p);s.onSearchComplete.call(j.element,c,L.suggestions)}).fail(function(L,N,r){s.onSearchError.call(j.element,c,L,N,r)})}},isBadQuery:function(c){if(!this.options.preventBadQueries)return false;for(var e=this.badQueries,
j=e.length;j--;)if(c.indexOf(e[j])===0)return true;return false},hide:function(){this.visible=false;this.selectedIndex=-1;b(this.suggestionsContainer).hide();this.signalHint(null)},suggest:function(){if(this.suggestions.length===0)this.options.showNoSuggestionNotice?this.noSuggestions():this.hide();else{var c=this.options,e=c.formatResult,j=this.getQuery(this.currentValue),s=this.classes.suggestion,w=this.classes.selected,K=b(this.suggestionsContainer),p=b(this.noSuggestionsContainer),L=c.beforeRender,
N="",r;if(c.triggerSelectOnValidInput){r=this.findSuggestionIndex(j);if(r!==-1){this.select(r);return}}b.each(this.suggestions,function(x,m){N+='<div class="'+s+'" data-index="'+x+'">'+e(m,j)+"</div>"});this.adjustContainerWidth();p.detach();K.html(N);if(c.autoSelectFirst){this.selectedIndex=0;K.children().first().addClass(w)}b.isFunction(L)&&L.call(this.element,K);this.fixPosition();K.show();this.visible=true;this.findBestHint()}},noSuggestions:function(){var c=b(this.suggestionsContainer),e=b(this.noSuggestionsContainer);
this.adjustContainerWidth();e.detach();c.empty();c.append(e);this.fixPosition();c.show();this.visible=true},adjustContainerWidth:function(){var c=this.options,e=b(this.suggestionsContainer);if(c.width==="auto"){c=this.el.outerWidth()-2;e.width(c>0?c:300)}},findBestHint:function(){var c=this.el.val().toLowerCase(),e=null;if(c){b.each(this.suggestions,function(j,s){var w=s.value.toLowerCase().indexOf(c)===0;if(w)e=s;return!w});this.signalHint(e)}},signalHint:function(c){var e="";if(c)e=this.currentValue+
c.value.substr(this.currentValue.length);if(this.hintValue!==e){this.hintValue=e;this.hint=c;(this.options.onHint||b.noop)(e)}},verifySuggestionsFormat:function(c){if(c.length&&typeof c[0]==="string")return b.map(c,function(e){return{value:e,data:null}});return c},validateOrientation:function(c,e){c=c.trim().toLowerCase();if(["auto","bottom","top"].indexOf(c)=="-1")c=e;return c},processResponse:function(c,e,j){var s=this.options;c.suggestions=this.verifySuggestionsFormat(c.suggestions);if(!s.noCache){this.cachedResponse[j]=
c;s.preventBadQueries&&c.suggestions.length===0&&this.badQueries.push(e)}if(e===this.getQuery(this.currentValue)){this.suggestions=c.suggestions;this.suggest()}},activate:function(c){var e=this.classes.selected,j=b(this.suggestionsContainer),s=j.children();j.children("."+e).removeClass(e);this.selectedIndex=c;if(this.selectedIndex!==-1&&s.length>this.selectedIndex){c=s.get(this.selectedIndex);b(c).addClass(e);return c}return null},selectHint:function(){this.select(b.inArray(this.hint,this.suggestions))},
select:function(c){this.hide();this.onSelect(c)},moveUp:function(){if(this.selectedIndex!==-1)if(this.selectedIndex===0){b(this.suggestionsContainer).children().first().removeClass(this.classes.selected);this.selectedIndex=-1;this.el.val(this.currentValue);this.findBestHint()}else this.adjustScroll(this.selectedIndex-1)},moveDown:function(){this.selectedIndex!==this.suggestions.length-1&&this.adjustScroll(this.selectedIndex+1)},adjustScroll:function(c){var e=this.activate(c),j,s;if(e){e=e.offsetTop;
j=b(this.suggestionsContainer).scrollTop();s=j+this.options.maxHeight-25;if(e<j)b(this.suggestionsContainer).scrollTop(e);else e>s&&b(this.suggestionsContainer).scrollTop(e-this.options.maxHeight+25);this.el.val(this.getValue(this.suggestions[c].value));this.signalHint(null)}},onSelect:function(c){var e=this.options.onSelect;c=this.suggestions[c];this.currentValue=this.getValue(c.value);this.currentValue!==this.el.val()&&this.el.val(this.currentValue);this.signalHint(null);this.suggestions=[];this.selection=
c;b.isFunction(e)&&e.call(this.element,c)},getValue:function(c){var e=this.options.delimiter,j;if(!e)return c;j=this.currentValue;e=j.split(e);if(e.length===1)return c;return j.substr(0,j.length-e[e.length-1].length)+c},dispose:function(){this.el.off(".autocomplete").removeData("autocomplete");this.disableKillerFn();b(window).off("resize.autocomplete",this.fixPositionCapture);b(this.suggestionsContainer).remove()}};b.fn.autocomplete=function(c,e){if(arguments.length===0)return this.first().data("autocomplete");
return this.each(function(){var j=b(this),s=j.data("autocomplete");if(typeof c==="string"){if(s&&typeof s[c]==="function")s[c](e)}else{s&&s.dispose&&s.dispose();s=new f(this,c);j.data("autocomplete",s)}})}});if("undefined"==typeof jQuery)throw Error("Bootstrap's JavaScript requires jQuery");(function(b){b=b.fn.jquery.split(" ")[0].split(".");if(b[0]<2&&b[1]<9||1==b[0]&&9==b[1]&&b[2]<1)throw Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher");})(jQuery);
(function(b){function f(){var n=document.createElement("bootstrap"),g={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"},c;for(c in g)if(void 0!==n.style[c])return{end:g[c]};return false}b.fn.emulateTransitionEnd=function(n){var g=false,c=this;b(this).one("bsTransitionEnd",function(){g=true});return setTimeout(function(){g||b(c).trigger(b.support.transition.end)},n),this};b(function(){b.support.transition=f();
b.support.transition&&(b.event.special.bsTransitionEnd={bindType:b.support.transition.end,delegateType:b.support.transition.end,handle:function(n){return b(n.target).is(this)?n.handleObj.handler.apply(this,arguments):void 0}})})})(jQuery);
(function(b){var f=function(g){b(g).on("click",'[data-dismiss="alert"]',this.close)};f.VERSION="3.3.4";f.TRANSITION_DURATION=150;f.prototype.close=function(g){function c(){s.detach().trigger("closed.bs.alert").remove()}var e=b(this),j=e.attr("data-target");j||(j=e.attr("href"),j=j&&j.replace(/.*(?=#[^\s]*$)/,""));var s=b(j);g&&g.preventDefault();s.length||(s=e.closest(".alert"));s.trigger(g=b.Event("close.bs.alert"));g.isDefaultPrevented()||(s.removeClass("in"),b.support.transition&&s.hasClass("fade")?
s.one("bsTransitionEnd",c).emulateTransitionEnd(f.TRANSITION_DURATION):c())};var n=b.fn.alert;b.fn.alert=function(g){return this.each(function(){var c=b(this),e=c.data("bs.alert");e||c.data("bs.alert",e=new f(this));"string"==typeof g&&e[g].call(c)})};b.fn.alert.Constructor=f;b.fn.alert.noConflict=function(){return b.fn.alert=n,this};b(document).on("click.bs.alert.data-api",'[data-dismiss="alert"]',f.prototype.close)})(jQuery);
(function(b){function f(c){return this.each(function(){var e=b(this),j=e.data("bs.button"),s="object"==typeof c&&c;j||e.data("bs.button",j=new n(this,s));"toggle"==c?j.toggle():c&&j.setState(c)})}var n=function(c,e){this.$element=b(c);this.options=b.extend({},n.DEFAULTS,e);this.isLoading=false};n.VERSION="3.3.4";n.DEFAULTS={loadingText:"loading..."};n.prototype.setState=function(c){var e=this.$element,j=e.is("input")?"val":"html",s=e.data();c+="Text";null==s.resetText&&e.data("resetText",e[j]());
setTimeout(b.proxy(function(){e[j](null==s[c]?this.options[c]:s[c]);"loadingText"==c?(this.isLoading=true,e.addClass("disabled").attr("disabled","disabled")):this.isLoading&&(this.isLoading=false,e.removeClass("disabled").removeAttr("disabled"))},this),0)};n.prototype.toggle=function(){var c=true,e=this.$element.closest('[data-toggle="buttons"]');if(e.length){var j=this.$element.find("input");"radio"==j.prop("type")&&(j.prop("checked")&&this.$element.hasClass("active")?c=false:e.find(".active").removeClass("active"));
c&&j.prop("checked",!this.$element.hasClass("active")).trigger("change")}else this.$element.attr("aria-pressed",!this.$element.hasClass("active"));c&&this.$element.toggleClass("active")};var g=b.fn.button;b.fn.button=f;b.fn.button.Constructor=n;b.fn.button.noConflict=function(){return b.fn.button=g,this};b(document).on("click.bs.button.data-api",'[data-toggle^="button"]',function(c){var e=b(c.target);e.hasClass("btn")||(e=e.closest(".btn"));f.call(e,"toggle");c.preventDefault()}).on("focus.bs.button.data-api blur.bs.button.data-api",
'[data-toggle^="button"]',function(c){b(c.target).closest(".btn").toggleClass("focus",/^focus(in)?$/.test(c.type))})})(jQuery);
(function(b){function f(e){return this.each(function(){var j=b(this),s=j.data("bs.carousel"),w=b.extend({},n.DEFAULTS,j.data(),"object"==typeof e&&e),K="string"==typeof e?e:w.slide;s||j.data("bs.carousel",s=new n(this,w));"number"==typeof e?s.to(e):K?s[K]():w.interval&&s.pause().cycle()})}var n=function(e,j){this.$element=b(e);this.$indicators=this.$element.find(".carousel-indicators");this.options=j;this.$items=this.$active=this.interval=this.sliding=this.paused=null;this.options.keyboard&&this.$element.on("keydown.bs.carousel",
b.proxy(this.keydown,this));"hover"==this.options.pause&&!("ontouchstart"in document.documentElement)&&this.$element.on("mouseenter.bs.carousel",b.proxy(this.pause,this)).on("mouseleave.bs.carousel",b.proxy(this.cycle,this))};n.VERSION="3.3.4";n.TRANSITION_DURATION=600;n.DEFAULTS={interval:5E3,pause:"hover",wrap:true,keyboard:true};n.prototype.keydown=function(e){if(!/input|textarea/i.test(e.target.tagName)){switch(e.which){case 37:this.prev();break;case 39:this.next();break;default:return}e.preventDefault()}};
n.prototype.cycle=function(e){return e||(this.paused=false),this.interval&&clearInterval(this.interval),this.options.interval&&!this.paused&&(this.interval=setInterval(b.proxy(this.next,this),this.options.interval)),this};n.prototype.getItemIndex=function(e){return this.$items=e.parent().children(".item"),this.$items.index(e||this.$active)};n.prototype.getItemForDirection=function(e,j){var s=this.getItemIndex(j);if(("prev"==e&&0===s||"next"==e&&s==this.$items.length-1)&&!this.options.wrap)return j;
return this.$items.eq((s+("prev"==e?-1:1))%this.$items.length)};n.prototype.to=function(e){var j=this,s=this.getItemIndex(this.$active=this.$element.find(".item.active"));return e>this.$items.length-1||0>e?void 0:this.sliding?this.$element.one("slid.bs.carousel",function(){j.to(e)}):s==e?this.pause().cycle():this.slide(e>s?"next":"prev",this.$items.eq(e))};n.prototype.pause=function(e){return e||(this.paused=true),this.$element.find(".next, .prev").length&&b.support.transition&&(this.$element.trigger(b.support.transition.end),
this.cycle(true)),this.interval=clearInterval(this.interval),this};n.prototype.next=function(){return this.sliding?void 0:this.slide("next")};n.prototype.prev=function(){return this.sliding?void 0:this.slide("prev")};n.prototype.slide=function(e,j){var s=this.$element.find(".item.active"),w=j||this.getItemForDirection(e,s),K=this.interval,p="next"==e?"left":"right",L=this;if(w.hasClass("active"))return this.sliding=false;var N=w[0],r=b.Event("slide.bs.carousel",{relatedTarget:N,direction:p});if(this.$element.trigger(r),
!r.isDefaultPrevented()){if(this.sliding=true,K&&this.pause(),this.$indicators.length){this.$indicators.find(".active").removeClass("active");(r=b(this.$indicators.children()[this.getItemIndex(w)]))&&r.addClass("active")}var x=b.Event("slid.bs.carousel",{relatedTarget:N,direction:p});return b.support.transition&&this.$element.hasClass("slide")?(w.addClass(e),s.addClass(p),w.addClass(p),s.one("bsTransitionEnd",function(){w.removeClass([e,p].join(" ")).addClass("active");s.removeClass(["active",p].join(" "));
L.sliding=false;setTimeout(function(){L.$element.trigger(x)},0)}).emulateTransitionEnd(n.TRANSITION_DURATION)):(s.removeClass("active"),w.addClass("active"),this.sliding=false,this.$element.trigger(x)),K&&this.cycle(),this}};var g=b.fn.carousel;b.fn.carousel=f;b.fn.carousel.Constructor=n;b.fn.carousel.noConflict=function(){return b.fn.carousel=g,this};var c=function(e){var j,s=b(this),w=b(s.attr("data-target")||(j=s.attr("href"))&&j.replace(/.*(?=#[^\s]+$)/,""));if(w.hasClass("carousel")){j=b.extend({},
w.data(),s.data());(s=s.attr("data-slide-to"))&&(j.interval=false);f.call(w,j);s&&w.data("bs.carousel").to(s);e.preventDefault()}};b(document).on("click.bs.carousel.data-api","[data-slide]",c).on("click.bs.carousel.data-api","[data-slide-to]",c);b(window).on("load",function(){b('[data-ride="carousel"]').each(function(){var e=b(this);f.call(e,e.data())})})})(jQuery);
(function(b){function f(e){var j;e=e.attr("data-target")||(j=e.attr("href"))&&j.replace(/.*(?=#[^\s]+$)/,"");return b(e)}function n(e){return this.each(function(){var j=b(this),s=j.data("bs.collapse"),w=b.extend({},g.DEFAULTS,j.data(),"object"==typeof e&&e);!s&&w.toggle&&/show|hide/.test(e)&&(w.toggle=false);s||j.data("bs.collapse",s=new g(this,w));"string"==typeof e&&s[e]()})}var g=function(e,j){this.$element=b(e);this.options=b.extend({},g.DEFAULTS,j);this.$trigger=b('[data-toggle="collapse"][href="#'+
e.id+'"],[data-toggle="collapse"][data-target="#'+e.id+'"]');this.transitioning=null;this.options.parent?this.$parent=this.getParent():this.addAriaAndCollapsedClass(this.$element,this.$trigger);this.options.toggle&&this.toggle()};g.VERSION="3.3.4";g.TRANSITION_DURATION=350;g.DEFAULTS={toggle:true};g.prototype.dimension=function(){return this.$element.hasClass("width")?"width":"height"};g.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var e,j=this.$parent&&this.$parent.children(".panel").children(".in, .collapsing");
if(!(j&&j.length&&(e=j.data("bs.collapse"),e&&e.transitioning))){var s=b.Event("show.bs.collapse");if(this.$element.trigger(s),!s.isDefaultPrevented()){j&&j.length&&(n.call(j,"hide"),e||j.data("bs.collapse",null));var w=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[w](0).attr("aria-expanded",true);this.$trigger.removeClass("collapsed").attr("aria-expanded",true);this.transitioning=1;e=function(){this.$element.removeClass("collapsing").addClass("collapse in")[w]("");
this.transitioning=0;this.$element.trigger("shown.bs.collapse")};if(!b.support.transition)return e.call(this);j=b.camelCase(["scroll",w].join("-"));this.$element.one("bsTransitionEnd",b.proxy(e,this)).emulateTransitionEnd(g.TRANSITION_DURATION)[w](this.$element[0][j])}}}};g.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var e=b.Event("hide.bs.collapse");if(this.$element.trigger(e),!e.isDefaultPrevented()){e=this.dimension();this.$element[e](this.$element[e]());this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded",
false);this.$trigger.addClass("collapsed").attr("aria-expanded",false);this.transitioning=1;var j=function(){this.transitioning=0;this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")};return b.support.transition?void this.$element[e](0).one("bsTransitionEnd",b.proxy(j,this)).emulateTransitionEnd(g.TRANSITION_DURATION):j.call(this)}}};g.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()};g.prototype.getParent=function(){return b(this.options.parent).find('[data-toggle="collapse"][data-parent="'+
this.options.parent+'"]').each(b.proxy(function(e,j){var s=b(j);this.addAriaAndCollapsedClass(f(s),s)},this)).end()};g.prototype.addAriaAndCollapsedClass=function(e,j){var s=e.hasClass("in");e.attr("aria-expanded",s);j.toggleClass("collapsed",!s).attr("aria-expanded",s)};var c=b.fn.collapse;b.fn.collapse=n;b.fn.collapse.Constructor=g;b.fn.collapse.noConflict=function(){return b.fn.collapse=c,this};b(document).on("click.bs.collapse.data-api",'[data-toggle="collapse"]',function(e){var j=b(this);j.attr("data-target")||
e.preventDefault();e=f(j);j=e.data("bs.collapse")?"toggle":j.data();n.call(e,j)})})(jQuery);
(function(b){function f(s){s&&3===s.which||(b(g).remove(),b(c).each(function(){var w=b(this),K=n(w),p={relatedTarget:this};K.hasClass("open")&&(K.trigger(s=b.Event("hide.bs.dropdown",p)),s.isDefaultPrevented()||(w.attr("aria-expanded","false"),K.removeClass("open").trigger("hidden.bs.dropdown",p)))}))}function n(s){var w=s.attr("data-target");w||(w=s.attr("href"),w=w&&/#[A-Za-z]/.test(w)&&w.replace(/.*(?=#[^\s]*$)/,""));return(w=w&&b(w))&&w.length?w:s.parent()}var g=".dropdown-backdrop",c='[data-toggle="dropdown"]',
e=function(s){b(s).on("click.bs.dropdown",this.toggle)};e.VERSION="3.3.4";e.prototype.toggle=function(s){var w=b(this);if(!w.is(".disabled, :disabled")){var K=n(w),p=K.hasClass("open");if(f(),!p){"ontouchstart"in document.documentElement&&!K.closest(".navbar-nav").length&&b('<div class="dropdown-backdrop"></div>').insertAfter(b(this)).on("click",f);p={relatedTarget:this};if(K.trigger(s=b.Event("show.bs.dropdown",p)),s.isDefaultPrevented())return;w.trigger("focus").attr("aria-expanded","true");K.toggleClass("open").trigger("shown.bs.dropdown",
p)}return false}};e.prototype.keydown=function(s){if(/(38|40|27|32)/.test(s.which)&&!/input|textarea/i.test(s.target.tagName)){var w=b(this);if(s.preventDefault(),s.stopPropagation(),!w.is(".disabled, :disabled")){var K=n(w),p=K.hasClass("open");if(!p&&27!=s.which||p&&27==s.which)return 27==s.which&&K.find(c).trigger("focus"),w.trigger("click");w=K.find('[role="menu"] li:not(.disabled):visible a, [role="listbox"] li:not(.disabled):visible a');if(w.length){K=w.index(s.target);38==s.which&&K>0&&K--;
40==s.which&&K<w.length-1&&K++;~K||(K=0);w.eq(K).trigger("focus")}}}};var j=b.fn.dropdown;b.fn.dropdown=function(s){return this.each(function(){var w=b(this),K=w.data("bs.dropdown");K||w.data("bs.dropdown",K=new e(this));"string"==typeof s&&K[s].call(w)})};b.fn.dropdown.Constructor=e;b.fn.dropdown.noConflict=function(){return b.fn.dropdown=j,this};b(document).on("click.bs.dropdown.data-api",f).on("click.bs.dropdown.data-api",".dropdown form",function(s){s.stopPropagation()}).on("click.bs.dropdown.data-api",
c,e.prototype.toggle).on("keydown.bs.dropdown.data-api",c,e.prototype.keydown).on("keydown.bs.dropdown.data-api",'[role="menu"]',e.prototype.keydown).on("keydown.bs.dropdown.data-api",'[role="listbox"]',e.prototype.keydown)})(jQuery);
(function(b){function f(c,e){return this.each(function(){var j=b(this),s=j.data("bs.modal"),w=b.extend({},n.DEFAULTS,j.data(),"object"==typeof c&&c);s||j.data("bs.modal",s=new n(this,w));"string"==typeof c?s[c](e):w.show&&s.show(e)})}var n=function(c,e){this.options=e;this.$body=b(document.body);this.$element=b(c);this.$dialog=this.$element.find(".modal-dialog");this.originalBodyPad=this.isShown=this.$backdrop=null;this.scrollbarWidth=0;this.ignoreBackdropClick=false;this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,
b.proxy(function(){this.$element.trigger("loaded.bs.modal")},this))};n.VERSION="3.3.4";n.TRANSITION_DURATION=300;n.BACKDROP_TRANSITION_DURATION=150;n.DEFAULTS={backdrop:true,keyboard:true,show:true};n.prototype.toggle=function(c){return this.isShown?this.hide():this.show(c)};n.prototype.show=function(c){var e=this,j=b.Event("show.bs.modal",{relatedTarget:c});this.$element.trigger(j);this.isShown||j.isDefaultPrevented()||(this.isShown=true,this.checkScrollbar(),this.setScrollbar(),this.$body.addClass("modal-open"),
this.escape(),this.resize(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',b.proxy(this.hide,this)),this.$dialog.on("mousedown.dismiss.bs.modal",function(){e.$element.one("mouseup.dismiss.bs.modal",function(s){b(s.target).is(e.$element)&&(e.ignoreBackdropClick=true)})}),this.backdrop(function(){var s=b.support.transition&&e.$element.hasClass("fade");e.$element.parent().length||e.$element.appendTo(e.$body);e.$element.show().scrollTop(0);e.adjustDialog();e.$element.addClass("in").attr("aria-hidden",
false);e.enforceFocus();var w=b.Event("shown.bs.modal",{relatedTarget:c});s?e.$dialog.one("bsTransitionEnd",function(){e.$element.trigger("focus").trigger(w)}).emulateTransitionEnd(n.TRANSITION_DURATION):e.$element.trigger("focus").trigger(w)}))};n.prototype.hide=function(c){c&&c.preventDefault();c=b.Event("hide.bs.modal");this.$element.trigger(c);this.isShown&&!c.isDefaultPrevented()&&(this.isShown=false,this.escape(),this.resize(),b(document).off("focusin.bs.modal"),this.$element.removeClass("in").attr("aria-hidden",
true).off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"),this.$dialog.off("mousedown.dismiss.bs.modal"),b.support.transition&&this.$element.hasClass("fade")?this.$element.one("bsTransitionEnd",b.proxy(this.hideModal,this)).emulateTransitionEnd(n.TRANSITION_DURATION):this.hideModal())};n.prototype.enforceFocus=function(){b(document).off("focusin.bs.modal").on("focusin.bs.modal",b.proxy(function(c){this.$element[0]===c.target||this.$element.has(c.target).length||this.$element.trigger("focus")},
this))};n.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keydown.dismiss.bs.modal",b.proxy(function(c){27==c.which&&this.hide()},this)):this.isShown||this.$element.off("keydown.dismiss.bs.modal")};n.prototype.resize=function(){this.isShown?b(window).on("resize.bs.modal",b.proxy(this.handleUpdate,this)):b(window).off("resize.bs.modal")};n.prototype.hideModal=function(){var c=this;this.$element.hide();this.backdrop(function(){c.$body.removeClass("modal-open");c.resetAdjustments();
c.resetScrollbar();c.$element.trigger("hidden.bs.modal")})};n.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove();this.$backdrop=null};n.prototype.backdrop=function(c){var e=this,j=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var s=b.support.transition&&j;if(!(this.$backdrop=b('<div class="modal-backdrop '+j+'" ></w>').appendTo(this.$body),this.$element.on("click.dismiss.bs.modal",b.proxy(function(w){return this.ignoreBackdropClick?void(this.ignoreBackdropClick=
false):void(w.target===w.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus():this.hide()))},this)),this.$backdrop.addClass("in"),!c))s?this.$backdrop.one("bsTransitionEnd",c).emulateTransitionEnd(n.BACKDROP_TRANSITION_DURATION):c()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass("in");j=function(){e.removeBackdrop();c&&c()};b.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one("bsTransitionEnd",j).emulateTransitionEnd(n.BACKDROP_TRANSITION_DURATION):
j()}else c&&c()};n.prototype.handleUpdate=function(){this.adjustDialog()};n.prototype.adjustDialog=function(){var c=this.$element[0].scrollHeight>document.documentElement.clientHeight;this.$element.css({paddingLeft:!this.bodyIsOverflowing&&c?this.scrollbarWidth:"",paddingRight:this.bodyIsOverflowing&&!c?this.scrollbarWidth:""})};n.prototype.resetAdjustments=function(){this.$element.css({paddingLeft:"",paddingRight:""})};n.prototype.checkScrollbar=function(){var c=window.innerWidth;if(!c){c=document.documentElement.getBoundingClientRect();
c=c.right-Math.abs(c.left)}this.bodyIsOverflowing=document.body.clientWidth<c;this.scrollbarWidth=this.measureScrollbar()};n.prototype.setScrollbar=function(){var c=parseInt(this.$body.css("padding-right")||0,10);this.originalBodyPad=document.body.style.paddingRight||"";this.bodyIsOverflowing&&this.$body.css("padding-right",c+this.scrollbarWidth)};n.prototype.resetScrollbar=function(){this.$body.css("padding-right",this.originalBodyPad)};n.prototype.measureScrollbar=function(){var c=document.createElement("div");
c.className="modal-scrollbar-measure";this.$body.append(c);var e=c.offsetWidth-c.clientWidth;return this.$body[0].removeChild(c),e};var g=b.fn.modal;b.fn.modal=f;b.fn.modal.Constructor=n;b.fn.modal.noConflict=function(){return b.fn.modal=g,this};b(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(c){var e=b(this),j=e.attr("href"),s=b(e.attr("data-target")||j&&j.replace(/.*(?=#[^\s]+$)/,""));j=s.data("bs.modal")?"toggle":b.extend({remote:!/#/.test(j)&&j},s.data(),e.data());e.is("a")&&
c.preventDefault();s.one("show.bs.modal",function(w){w.isDefaultPrevented()||s.one("hidden.bs.modal",function(){e.is(":visible")&&e.trigger("focus")})});f.call(s,j,this)})})(jQuery);
(function(b){var f=function(g,c){this.$element=this.hoverState=this.timeout=this.enabled=this.options=this.type=null;this.init("tooltip",g,c)};f.VERSION="3.3.4";f.TRANSITION_DURATION=150;f.DEFAULTS={animation:true,placement:"top",selector:false,template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:false,container:false,viewport:{selector:"body",padding:0}};f.prototype.init=function(g,c,e){if(this.enabled=
true,this.type=g,this.$element=b(c),this.options=this.getOptions(e),this.$viewport=this.options.viewport&&b(this.options.viewport.selector||this.options.viewport),this.$element[0]instanceof document.constructor&&!this.options.selector)throw Error("`selector` option must be specified when initializing "+this.type+" on the window.document object!");g=this.options.trigger.split(" ");for(c=g.length;c--;){e=g[c];if("click"==e)this.$element.on("click."+this.type,this.options.selector,b.proxy(this.toggle,
this));else if("manual"!=e){var j="hover"==e?"mouseleave":"focusout";this.$element.on(("hover"==e?"mouseenter":"focusin")+"."+this.type,this.options.selector,b.proxy(this.enter,this));this.$element.on(j+"."+this.type,this.options.selector,b.proxy(this.leave,this))}}this.options.selector?this._options=b.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()};f.prototype.getDefaults=function(){return f.DEFAULTS};f.prototype.getOptions=function(g){return g=b.extend({},this.getDefaults(),
this.$element.data(),g),g.delay&&"number"==typeof g.delay&&(g.delay={show:g.delay,hide:g.delay}),g};f.prototype.getDelegateOptions=function(){var g={},c=this.getDefaults();return this._options&&b.each(this._options,function(e,j){c[e]!=j&&(g[e]=j)}),g};f.prototype.enter=function(g){var c=g instanceof this.constructor?g:b(g.currentTarget).data("bs."+this.type);return c&&c.$tip&&c.$tip.is(":visible")?void(c.hoverState="in"):(c||(c=new this.constructor(g.currentTarget,this.getDelegateOptions()),b(g.currentTarget).data("bs."+
this.type,c)),clearTimeout(c.timeout),c.hoverState="in",c.options.delay&&c.options.delay.show?void(c.timeout=setTimeout(function(){"in"==c.hoverState&&c.show()},c.options.delay.show)):c.show())};f.prototype.leave=function(g){var c=g instanceof this.constructor?g:b(g.currentTarget).data("bs."+this.type);return c||(c=new this.constructor(g.currentTarget,this.getDelegateOptions()),b(g.currentTarget).data("bs."+this.type,c)),clearTimeout(c.timeout),c.hoverState="out",c.options.delay&&c.options.delay.hide?
void(c.timeout=setTimeout(function(){"out"==c.hoverState&&c.hide()},c.options.delay.hide)):c.hide()};f.prototype.show=function(){var g=b.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){this.$element.trigger(g);var c=b.contains(this.$element[0].ownerDocument.documentElement,this.$element[0]);if(!(g.isDefaultPrevented()||!c)){var e=this;g=this.tip();c=this.getUID(this.type);this.setContent();g.attr("id",c);this.$element.attr("aria-describedby",c);this.options.animation&&g.addClass("fade");
c="function"==typeof this.options.placement?this.options.placement.call(this,g[0],this.$element[0]):this.options.placement;var j=/\s?auto?\s?/i,s=j.test(c);s&&(c=c.replace(j,"")||"top");g.detach().css({top:0,left:0,display:"block"}).addClass(c).data("bs."+this.type,this);this.options.container?g.appendTo(this.options.container):g.insertAfter(this.$element);j=this.getPosition();var w=g[0].offsetWidth,K=g[0].offsetHeight;if(s){s=c;var p=this.getPosition(this.options.container?b(this.options.container):
this.$element.parent());c="bottom"==c&&j.bottom+K>p.bottom?"top":"top"==c&&j.top-K<p.top?"bottom":"right"==c&&j.right+w>p.width?"left":"left"==c&&j.left-w<p.left?"right":c;g.removeClass(s).addClass(c)}this.applyPlacement(this.getCalculatedOffset(c,j,w,K),c);c=function(){var L=e.hoverState;e.$element.trigger("shown.bs."+e.type);e.hoverState=null;"out"==L&&e.leave(e)};b.support.transition&&this.$tip.hasClass("fade")?g.one("bsTransitionEnd",c).emulateTransitionEnd(f.TRANSITION_DURATION):c()}}};f.prototype.applyPlacement=
function(g,c){var e=this.tip(),j=e[0].offsetWidth,s=e[0].offsetHeight,w=parseInt(e.css("margin-top"),10),K=parseInt(e.css("margin-left"),10);isNaN(w)&&(w=0);isNaN(K)&&(K=0);g.top+=w;g.left+=K;b.offset.setOffset(e[0],b.extend({using:function(N){e.css({top:Math.round(N.top),left:Math.round(N.left)})}},g),0);e.addClass("in");K=e[0].offsetWidth;var p=e[0].offsetHeight;"top"==c&&p!=s&&(g.top=g.top+s-p);var L=this.getViewportAdjustedDelta(c,g,K,p);L.left?g.left+=L.left:g.top+=L.top;j=(w=/top|bottom/.test(c))?
2*L.left-j+K:2*L.top-s+p;s=w?"offsetWidth":"offsetHeight";e.offset(g);this.replaceArrow(j,e[0][s],w)};f.prototype.replaceArrow=function(g,c,e){this.arrow().css(e?"left":"top",50*(1-g/c)+"%").css(e?"top":"left","")};f.prototype.setContent=function(){var g=this.tip(),c=this.getTitle();g.find(".tooltip-inner")[this.options.html?"html":"text"](c);g.removeClass("fade in top bottom left right")};f.prototype.hide=function(g){function c(){"in"!=e.hoverState&&j.detach();e.$element.removeAttr("aria-describedby").trigger("hidden.bs."+
e.type);g&&g()}var e=this,j=b(this.$tip),s=b.Event("hide.bs."+this.type);return this.$element.trigger(s),s.isDefaultPrevented()?void 0:(j.removeClass("in"),b.support.transition&&j.hasClass("fade")?j.one("bsTransitionEnd",c).emulateTransitionEnd(f.TRANSITION_DURATION):c(),this.hoverState=null,this)};f.prototype.fixTitle=function(){var g=this.$element;(g.attr("title")||"string"!=typeof g.attr("data-original-title"))&&g.attr("data-original-title",g.attr("title")||"").attr("title","")};f.prototype.hasContent=
function(){return this.getTitle()};f.prototype.getPosition=function(g){g=g||this.$element;var c=g[0],e="BODY"==c.tagName;c=c.getBoundingClientRect();null==c.width&&(c=b.extend({},c,{width:c.right-c.left,height:c.bottom-c.top}));var j=e?{top:0,left:0}:g.offset();g={scroll:e?document.documentElement.scrollTop||document.body.scrollTop:g.scrollTop()};e=e?{width:b(window).width(),height:b(window).height()}:null;return b.extend({},c,g,e,j)};f.prototype.getCalculatedOffset=function(g,c,e,j){return"bottom"==
g?{top:c.top+c.height,left:c.left+c.width/2-e/2}:"top"==g?{top:c.top-j,left:c.left+c.width/2-e/2}:"left"==g?{top:c.top+c.height/2-j/2,left:c.left-e}:{top:c.top+c.height/2-j/2,left:c.left+c.width}};f.prototype.getViewportAdjustedDelta=function(g,c,e,j){var s={top:0,left:0};if(!this.$viewport)return s;var w=this.options.viewport&&this.options.viewport.padding||0,K=this.getPosition(this.$viewport);if(/right|left/.test(g)){e=c.top-w-K.scroll;c=c.top+w-K.scroll+j;e<K.top?s.top=K.top-e:c>K.top+K.height&&
(s.top=K.top+K.height-c)}else{j=c.left-w;c=c.left+w+e;j<K.left?s.left=K.left-j:c>K.width&&(s.left=K.left+K.width-c)}return s};f.prototype.getTitle=function(){var g=this.$element,c=this.options;return g.attr("data-original-title")||("function"==typeof c.title?c.title.call(g[0]):c.title)};f.prototype.getUID=function(g){do g+=~~(1E6*Math.random());while(document.getElementById(g));return g};f.prototype.tip=function(){return this.$tip=this.$tip||b(this.options.template)};f.prototype.arrow=function(){return this.$arrow=
this.$arrow||this.tip().find(".tooltip-arrow")};f.prototype.enable=function(){this.enabled=true};f.prototype.disable=function(){this.enabled=false};f.prototype.toggleEnabled=function(){this.enabled=!this.enabled};f.prototype.toggle=function(g){var c=this;g&&(c=b(g.currentTarget).data("bs."+this.type),c||(c=new this.constructor(g.currentTarget,this.getDelegateOptions()),b(g.currentTarget).data("bs."+this.type,c)));c.tip().hasClass("in")?c.leave(c):c.enter(c)};f.prototype.destroy=function(){var g=this;
clearTimeout(this.timeout);this.hide(function(){g.$element.off("."+g.type).removeData("bs."+g.type)})};var n=b.fn.tooltip;b.fn.tooltip=function(g){return this.each(function(){var c=b(this),e=c.data("bs.tooltip"),j="object"==typeof g&&g;(e||!/destroy|hide/.test(g))&&(e||c.data("bs.tooltip",e=new f(this,j)),"string"==typeof g&&e[g]())})};b.fn.tooltip.Constructor=f;b.fn.tooltip.noConflict=function(){return b.fn.tooltip=n,this}})(jQuery);
(function(b){var f=function(g,c){this.init("popover",g,c)};if(!b.fn.tooltip)throw Error("Popover requires tooltip.js");f.VERSION="3.3.4";f.DEFAULTS=b.extend({},b.fn.tooltip.Constructor.DEFAULTS,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'});f.prototype=b.extend({},b.fn.tooltip.Constructor.prototype);f.prototype.constructor=f;f.prototype.getDefaults=function(){return f.DEFAULTS};
f.prototype.setContent=function(){var g=this.tip(),c=this.getTitle(),e=this.getContent();g.find(".popover-title")[this.options.html?"html":"text"](c);g.find(".popover-content").children().detach().end()[this.options.html?"string"==typeof e?"html":"append":"text"](e);g.removeClass("fade top bottom left right in");g.find(".popover-title").html()||g.find(".popover-title").hide()};f.prototype.hasContent=function(){return this.getTitle()||this.getContent()};f.prototype.getContent=function(){var g=this.$element,
c=this.options;return g.attr("data-content")||("function"==typeof c.content?c.content.call(g[0]):c.content)};f.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")};var n=b.fn.popover;b.fn.popover=function(g){return this.each(function(){var c=b(this),e=c.data("bs.popover"),j="object"==typeof g&&g;(e||!/destroy|hide/.test(g))&&(e||c.data("bs.popover",e=new f(this,j)),"string"==typeof g&&e[g]())})};b.fn.popover.Constructor=f;b.fn.popover.noConflict=function(){return b.fn.popover=
n,this}})(jQuery);
(function(b){function f(c,e){this.$body=b(document.body);this.$scrollElement=b(b(c).is(document.body)?window:c);this.options=b.extend({},f.DEFAULTS,e);this.selector=(this.options.target||"")+" .nav li > a";this.offsets=[];this.targets=[];this.activeTarget=null;this.scrollHeight=0;this.$scrollElement.on("scroll.bs.scrollspy",b.proxy(this.process,this));this.refresh();this.process()}function n(c){return this.each(function(){var e=b(this),j=e.data("bs.scrollspy"),s="object"==typeof c&&c;j||e.data("bs.scrollspy",
j=new f(this,s));"string"==typeof c&&j[c]()})}f.VERSION="3.3.4";f.DEFAULTS={offset:10};f.prototype.getScrollHeight=function(){return this.$scrollElement[0].scrollHeight||Math.max(this.$body[0].scrollHeight,document.documentElement.scrollHeight)};f.prototype.refresh=function(){var c=this,e="offset",j=0;this.offsets=[];this.targets=[];this.scrollHeight=this.getScrollHeight();b.isWindow(this.$scrollElement[0])||(e="position",j=this.$scrollElement.scrollTop());this.$body.find(this.selector).map(function(){var s=
b(this);s=s.data("target")||s.attr("href");var w=/^#./.test(s)&&b(s);return w&&w.length&&w.is(":visible")&&[[w[e]().top+j,s]]||null}).sort(function(s,w){return s[0]-w[0]}).each(function(){c.offsets.push(this[0]);c.targets.push(this[1])})};f.prototype.process=function(){var c,e=this.$scrollElement.scrollTop()+this.options.offset,j=this.getScrollHeight(),s=this.options.offset+j-this.$scrollElement.height(),w=this.offsets,K=this.targets,p=this.activeTarget;if(this.scrollHeight!=j&&this.refresh(),e>=
s)return p!=(c=K[K.length-1])&&this.activate(c);if(p&&e<w[0])return this.activeTarget=null,this.clear();for(c=w.length;c--;)p!=K[c]&&e>=w[c]&&(void 0===w[c+1]||e<w[c+1])&&this.activate(K[c])};f.prototype.activate=function(c){this.activeTarget=c;this.clear();c=b(this.selector+'[data-target="'+c+'"],'+this.selector+'[href="'+c+'"]').parents("li").addClass("active");c.parent(".dropdown-menu").length&&(c=c.closest("li.dropdown").addClass("active"));c.trigger("activate.bs.scrollspy")};f.prototype.clear=
function(){b(this.selector).parentsUntil(this.options.target,".active").removeClass("active")};var g=b.fn.scrollspy;b.fn.scrollspy=n;b.fn.scrollspy.Constructor=f;b.fn.scrollspy.noConflict=function(){return b.fn.scrollspy=g,this};b(window).on("load.bs.scrollspy.data-api",function(){b('[data-spy="scroll"]').each(function(){var c=b(this);n.call(c,c.data())})})})(jQuery);
(function(b){function f(e){return this.each(function(){var j=b(this),s=j.data("bs.tab");s||j.data("bs.tab",s=new n(this));"string"==typeof e&&s[e]()})}var n=function(e){this.element=b(e)};n.VERSION="3.3.4";n.TRANSITION_DURATION=150;n.prototype.show=function(){var e=this.element,j=e.closest("ul:not(.dropdown-menu)"),s=e.data("target");if(s||(s=e.attr("href"),s=s&&s.replace(/.*(?=#[^\s]*$)/,"")),!e.parent("li").hasClass("active")){var w=j.find(".active:last a"),K=b.Event("hide.bs.tab",{relatedTarget:e[0]}),
p=b.Event("show.bs.tab",{relatedTarget:w[0]});if(w.trigger(K),e.trigger(p),!p.isDefaultPrevented()&&!K.isDefaultPrevented()){s=b(s);this.activate(e.closest("li"),j);this.activate(s,s.parent(),function(){w.trigger({type:"hidden.bs.tab",relatedTarget:e[0]});e.trigger({type:"shown.bs.tab",relatedTarget:w[0]})})}}};n.prototype.activate=function(e,j,s){function w(){K.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",false);
e.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded",true);p?e.addClass("in"):e.removeClass("fade");e.parent(".dropdown-menu").length&&e.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",true);s&&s()}var K=j.find("> .active"),p=s&&b.support.transition&&(K.length&&K.hasClass("fade")||!!j.find("> .fade").length);K.length&&p?K.one("bsTransitionEnd",w).emulateTransitionEnd(n.TRANSITION_DURATION):w();K.removeClass("in")};var g=b.fn.tab;b.fn.tab=
f;b.fn.tab.Constructor=n;b.fn.tab.noConflict=function(){return b.fn.tab=g,this};var c=function(e){e.preventDefault();f.call(b(this),"show")};b(document).on("click.bs.tab.data-api",'[data-toggle="tab"]',c).on("click.bs.tab.data-api",'[data-toggle="pill"]',c)})(jQuery);
(function(b){function f(c){return this.each(function(){var e=b(this),j=e.data("bs.affix"),s="object"==typeof c&&c;j||e.data("bs.affix",j=new n(this,s));"string"==typeof c&&j[c]()})}var n=function(c,e){this.options=b.extend({},n.DEFAULTS,e);this.$target=b(this.options.target).on("scroll.bs.affix.data-api",b.proxy(this.checkPosition,this)).on("click.bs.affix.data-api",b.proxy(this.checkPositionWithEventLoop,this));this.$element=b(c);this.pinnedOffset=this.unpin=this.affixed=null;this.checkPosition()};
n.VERSION="3.3.4";n.RESET="affix affix-top affix-bottom";n.DEFAULTS={offset:0,target:window};n.prototype.getState=function(c,e,j,s){var w=this.$target.scrollTop(),K=this.$element.offset(),p=this.$target.height();if(null!=j&&"top"==this.affixed)return j>w?"top":false;if("bottom"==this.affixed)return null!=j?w+this.unpin<=K.top?false:"bottom":c-s>=w+p?false:"bottom";var L=null==this.affixed;K=L?w:K.top;return null!=j&&j>=w?"top":null!=s&&K+(L?p:e)>=c-s?"bottom":false};n.prototype.getPinnedOffset=function(){if(this.pinnedOffset)return this.pinnedOffset;
this.$element.removeClass(n.RESET).addClass("affix");var c=this.$target.scrollTop();return this.pinnedOffset=this.$element.offset().top-c};n.prototype.checkPositionWithEventLoop=function(){setTimeout(b.proxy(this.checkPosition,this),1)};n.prototype.checkPosition=function(){if(this.$element.is(":visible")){var c=this.$element.height(),e=this.options.offset,j=e.top,s=e.bottom,w=b(document.body).height();"object"!=typeof e&&(s=j=e);"function"==typeof j&&(j=e.top(this.$element));"function"==typeof s&&
(s=e.bottom(this.$element));e=this.getState(w,c,j,s);if(this.affixed!=e){null!=this.unpin&&this.$element.css("top","");j="affix"+(e?"-"+e:"");var K=b.Event(j+".bs.affix");if(this.$element.trigger(K),K.isDefaultPrevented())return;this.affixed=e;this.unpin="bottom"==e?this.getPinnedOffset():null;this.$element.removeClass(n.RESET).addClass(j).trigger(j.replace("affix","affixed")+".bs.affix")}"bottom"==e&&this.$element.offset({top:w-c-s})}};var g=b.fn.affix;b.fn.affix=f;b.fn.affix.Constructor=n;b.fn.affix.noConflict=
function(){return b.fn.affix=g,this};b(window).on("load",function(){b('[data-spy="affix"]').each(function(){var c=b(this),e=c.data();e.offset=e.offset||{};null!=e.offsetBottom&&(e.offset.bottom=e.offsetBottom);null!=e.offsetTop&&(e.offset.top=e.offsetTop);f.call(c,e)})})})(jQuery);jQuery.easing.jswing=jQuery.easing.swing;
jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(b,f,n,g,c){return jQuery.easing[jQuery.easing.def](b,f,n,g,c)},easeInQuad:function(b,f,n,g,c){return g*(f/=c)*f+n},easeOutQuad:function(b,f,n,g,c){return-g*(f/=c)*(f-2)+n},easeInOutQuad:function(b,f,n,g,c){if((f/=c/2)<1)return g/2*f*f+n;return-g/2*(--f*(f-2)-1)+n},easeInCubic:function(b,f,n,g,c){return g*(f/=c)*f*f+n},easeOutCubic:function(b,f,n,g,c){return g*((f=f/c-1)*f*f+1)+n},easeInOutCubic:function(b,f,n,g,c){if((f/=c/2)<1)return g/
2*f*f*f+n;return g/2*((f-=2)*f*f+2)+n},easeInQuart:function(b,f,n,g,c){return g*(f/=c)*f*f*f+n},easeOutQuart:function(b,f,n,g,c){return-g*((f=f/c-1)*f*f*f-1)+n},easeInOutQuart:function(b,f,n,g,c){if((f/=c/2)<1)return g/2*f*f*f*f+n;return-g/2*((f-=2)*f*f*f-2)+n},easeInQuint:function(b,f,n,g,c){return g*(f/=c)*f*f*f*f+n},easeOutQuint:function(b,f,n,g,c){return g*((f=f/c-1)*f*f*f*f+1)+n},easeInOutQuint:function(b,f,n,g,c){if((f/=c/2)<1)return g/2*f*f*f*f*f+n;return g/2*((f-=2)*f*f*f*f+2)+n},easeInSine:function(b,
f,n,g,c){return-g*Math.cos(f/c*(Math.PI/2))+g+n},easeOutSine:function(b,f,n,g,c){return g*Math.sin(f/c*(Math.PI/2))+n},easeInOutSine:function(b,f,n,g,c){return-g/2*(Math.cos(Math.PI*f/c)-1)+n},easeInExpo:function(b,f,n,g,c){return f==0?n:g*Math.pow(2,10*(f/c-1))+n},easeOutExpo:function(b,f,n,g,c){return f==c?n+g:g*(-Math.pow(2,-10*f/c)+1)+n},easeInOutExpo:function(b,f,n,g,c){if(f==0)return n;if(f==c)return n+g;if((f/=c/2)<1)return g/2*Math.pow(2,10*(f-1))+n;return g/2*(-Math.pow(2,-10*--f)+2)+n},
easeInCirc:function(b,f,n,g,c){return-g*(Math.sqrt(1-(f/=c)*f)-1)+n},easeOutCirc:function(b,f,n,g,c){return g*Math.sqrt(1-(f=f/c-1)*f)+n},easeInOutCirc:function(b,f,n,g,c){if((f/=c/2)<1)return-g/2*(Math.sqrt(1-f*f)-1)+n;return g/2*(Math.sqrt(1-(f-=2)*f)+1)+n},easeInElastic:function(b,f,n,g,c){var e=0,j=g;if(f==0)return n;if((f/=c)==1)return n+g;e||(e=c*0.3);if(j<Math.abs(g)){j=g;b=e/4}else b=e/(2*Math.PI)*Math.asin(g/j);return-(j*Math.pow(2,10*(f-=1))*Math.sin((f*c-b)*2*Math.PI/e))+n},easeOutElastic:function(b,
f,n,g,c){var e=0,j=g;if(f==0)return n;if((f/=c)==1)return n+g;e||(e=c*0.3);if(j<Math.abs(g)){j=g;b=e/4}else b=e/(2*Math.PI)*Math.asin(g/j);return j*Math.pow(2,-10*f)*Math.sin((f*c-b)*2*Math.PI/e)+g+n},easeInOutElastic:function(b,f,n,g,c){var e=0,j=g;if(f==0)return n;if((f/=c/2)==2)return n+g;e||(e=c*0.3*1.5);if(j<Math.abs(g)){j=g;b=e/4}else b=e/(2*Math.PI)*Math.asin(g/j);if(f<1)return-0.5*j*Math.pow(2,10*(f-=1))*Math.sin((f*c-b)*2*Math.PI/e)+n;return j*Math.pow(2,-10*(f-=1))*Math.sin((f*c-b)*2*Math.PI/
e)*0.5+g+n},easeInBack:function(b,f,n,g,c,e){if(e==undefined)e=1.70158;return g*(f/=c)*f*((e+1)*f-e)+n},easeOutBack:function(b,f,n,g,c,e){if(e==undefined)e=1.70158;return g*((f=f/c-1)*f*((e+1)*f+e)+1)+n},easeInOutBack:function(b,f,n,g,c,e){if(e==undefined)e=1.70158;if((f/=c/2)<1)return g/2*f*f*(((e*=1.525)+1)*f-e)+n;return g/2*((f-=2)*f*(((e*=1.525)+1)*f+e)+2)+n},easeInBounce:function(b,f,n,g,c){return g-jQuery.easing.easeOutBounce(b,c-f,0,g,c)+n},easeOutBounce:function(b,f,n,g,c){return(f/=c)<1/
2.75?g*7.5625*f*f+n:f<2/2.75?g*(7.5625*(f-=1.5/2.75)*f+0.75)+n:f<2.5/2.75?g*(7.5625*(f-=2.25/2.75)*f+0.9375)+n:g*(7.5625*(f-=2.625/2.75)*f+0.984375)+n},easeInOutBounce:function(b,f,n,g,c){if(f<c/2)return jQuery.easing.easeInBounce(b,f*2,0,g,c)*0.5+n;return jQuery.easing.easeOutBounce(b,f*2-c,0,g,c)*0.5+g*0.5+n}});
(function(b){if(b.zepto&&!b.fn.removeData)throw new ReferenceError("Zepto is loaded without the data module.");b.fn.noUiSlider=function(f,n){function g(O){return O instanceof b||b.zepto&&b.zepto.isZ(O)}function c(O){return!isNaN(parseFloat(O))&&isFinite(O)}function e(O,Z){b.isArray(O)||(O=[O]);b.each(O,function(){"function"===typeof this&&this.call(Z)})}function j(O,Z){return function(){var fa=[null,null];fa[Z]=b(this).val();O.val(fa,true)}}function s(O,Z){O=O.toFixed(Z.decimals);0===parseFloat(O)&&
(O=O.replace("-0","0"));return O.replace(".",Z.serialization.mark)}function w(O){return parseFloat(O.toFixed(7))}function K(O,Z,fa,na){var I=na.target;O=O.replace(/\s/g,Wa+" ")+Wa;Z.on(O,function(P){var ca=I.attr("disabled");if(I.hasClass("noUi-state-tap")||void 0!==ca&&null!==ca)return false;var va;P.preventDefault();ca=0===P.type.indexOf("touch");var Qa=0===P.type.indexOf("mouse"),Pa=0===P.type.indexOf("pointer"),Ma,k=P;0===P.type.indexOf("MSPointer")&&(Pa=true);P.originalEvent&&(P=P.originalEvent);
ca&&(va=P.changedTouches[0].pageX,Ma=P.changedTouches[0].pageY);if(Qa||Pa){Pa||void 0!==window.pageXOffset||(window.pageXOffset=document.documentElement.scrollLeft,window.pageYOffset=document.documentElement.scrollTop);va=P.clientX+window.pageXOffset;Ma=P.clientY+window.pageYOffset}va=b.extend(k,{pointX:va,pointY:Ma,cursor:Qa});fa(va,na,I.data("base").data("options"))})}function p(O){var Z=this.target;if(void 0===O)return this.element.data("value");true===O?O=this.element.data("value"):this.element.data("value",
O);void 0!==O&&b.each(this.elements,function(){if("function"===typeof this)this.call(Z,O);else this[0][this[1]](O)})}function L(O,Z,fa){if(g(Z)){var na=[],I=O.data("target");O.data("options").direction&&(fa=fa?0:1);Z.each(function(){b(this).on("change"+Wa,j(I,fa));na.push([b(this),"val"])});return na}"string"===typeof Z&&(Z=[b('<input type="hidden" name="'+Z+'">').appendTo(O).addClass(za[3]).change(function(P){P.stopPropagation()}),"val"]);return[Z]}function N(O,Z,fa){var na=[];b.each(fa.to[Z],function(I){na=
na.concat(L(O,fa.to[Z][I],Z))});return{element:O,elements:na,target:O.data("target"),val:p}}function r(O,Z){var fa=O.data("target");fa.hasClass(za[14])||(Z||(fa.addClass(za[15]),setTimeout(function(){fa.removeClass(za[15])},450)),fa.addClass(za[14]),e(O.data("options").h,fa))}function x(O,Z){var fa=O.data("options");Z=w(Z);O.data("target").removeClass(za[14]);O.css(fa.style,Z+"%").data("pct",Z);O.is(":first-child")&&O.toggleClass(za[13],50<Z);fa.direction&&(Z=100-Z);O.data("store").val(s(Z*(fa.range[1]-
fa.range[0])/100+fa.range[0],fa))}function m(O,Z){var fa=O.data("base"),na=fa.data("options");fa=fa.data("handles");var I=0,P=100;if(!c(Z))return false;if(na.step){var ca=na.step;Z=Math.round(Z/ca)*ca}1<fa.length&&(O[0]!==fa[0][0]?I=w(fa[0].data("pct")+na.margin):P=w(fa[1].data("pct")-na.margin));Z=Math.min(Math.max(Z,I),0>P?100:P);if(Z===O.data("pct"))return[I?I:false,100===P?false:P];x(O,Z);return true}function F(O,Z,fa,na){O.addClass(za[5]);setTimeout(function(){O.removeClass(za[5])},300);m(Z,
fa);e(na,O.data("target"));O.data("target").change()}function V(O,Z,fa){var na=Z.a,I=O[Z.d]-Z.start[Z.d];I=100*I/Z.size;if(1===na.length){if(O=m(na[0],Z.c[0]+I),true!==O){0<=b.inArray(na[0].data("pct"),O)&&r(Z.b,!fa.margin);return}}else{var P,ca;fa.step&&(O=fa.step,I=Math.round(I/O)*O);O=P=Z.c[0]+I;I=ca=Z.c[1]+I;0>O?(I+=-1*O,O=0):100<I&&(O-=I-100,I=100);if(0>P&&!O&&!na[0].data("pct")||100===I&&100<ca&&100===na[1].data("pct"))return;x(na[0],O);x(na[1],I)}e(fa.slide,Z.target)}function ha(O,Z,fa){1===
Z.a.length&&Z.a[0].data("grab").removeClass(za[4]);O.cursor&&Q.css("cursor","").off(Wa);La.off(Wa);Z.target.removeClass(za[14]+" "+za[20]).change();e(fa.set,Z.target)}function ka(O,Z,fa){1===Z.a.length&&Z.a[0].data("grab").addClass(za[4]);O.stopPropagation();K(Na.move,La,V,{start:O,b:Z.b,target:Z.target,a:Z.a,c:[Z.a[0].data("pct"),Z.a[Z.a.length-1].data("pct")],d:fa.orientation?"pointY":"pointX",size:fa.orientation?Z.b.height():Z.b.width()});K(Na.end,La,ha,{target:Z.target,a:Z.a});O.cursor&&(Q.css("cursor",
b(O.target).css("cursor")),1<Z.a.length&&Z.target.addClass(za[20]),Q.on("selectstart"+Wa,function(){return false}))}function ta(O,Z,fa){Z=Z.b;var na,I;O.stopPropagation();fa.orientation?(O=O.pointY,I=Z.height()):(O=O.pointX,I=Z.width());na=Z.data("handles");var P=O,ca=fa.style;1===na.length?na=na[0]:(ca=na[0].offset()[ca]+na[1].offset()[ca],na=na[P<ca/2?0:1]);O=100*(O-Z.offset()[fa.style])/I;F(Z,na,O,[fa.slide,fa.set])}function Ka(O,Z,fa){var na=Z.b.data("handles"),I;I=fa.orientation?O.pointY:O.pointX;
O=(I=I<Z.b.offset()[fa.style])?0:100;I=I?0:na.length-1;F(Z.b,na[I],O,[fa.slide,fa.set])}function sa(O,Z){function fa(I){if(2!==I.length)return false;I=[parseFloat(I[0]),parseFloat(I[1])];return!c(I[0])||!c(I[1])||I[1]<I[0]?false:I}var na={f:function(I,P){switch(I){case 1:case 0.1:case 0.01:case 0.0010:case 1.0E-4:case 1.0E-5:I=I.toString().split(".");P.decimals="1"===I[0]?0:I[1].length;break;case void 0:P.decimals=2;break;default:return false}return true},e:function(I,P,ca){if(!I)return P[ca].mark=
".",true;switch(I){case ".":case ",":return true;default:return false}},g:function(I,P,ca){function va(k){return g(k)||"string"===typeof k||"function"===typeof k||false===k||g(k[0])&&"function"===typeof k[0][k[1]]}function Qa(k){var z=[[],[]];va(k)?z[0].push(k):b.each(k,function(C,J){1<C||(va(J)?z[C].push(J):z[C]=z[C].concat(J))});return z}if(I){var Pa,Ma;I=Qa(I);P.direction&&I[1].length&&I.reverse();for(Pa=0;Pa<P.handles;Pa++)for(Ma=0;Ma<I[Pa].length;Ma++){if(!va(I[Pa][Ma]))return false;I[Pa][Ma]||
I[Pa].splice(Ma,1)}P[ca].to=I}else P[ca].to=[[],[]];return true}};b.each({handles:{r:true,t:function(I){I=parseInt(I,10);return 1===I||2===I}},range:{r:true,t:function(I,P,ca){P[ca]=fa(I);return P[ca]&&P[ca][0]!==P[ca][1]}},start:{r:true,t:function(I,P,ca){if(1===P.handles)return b.isArray(I)&&(I=I[0]),I=parseFloat(I),P.start=[I],c(I);P[ca]=fa(I);return!!P[ca]}},connect:{r:true,t:function(I,P,ca){if("lower"===I)P[ca]=1;else if("upper"===I)P[ca]=2;else if(true===I)P[ca]=3;else if(false===I)P[ca]=0;
else return false;return true}},orientation:{t:function(I,P,ca){switch(I){case "horizontal":P[ca]=0;break;case "vertical":P[ca]=1;break;default:return false}return true}},margin:{r:true,t:function(I,P,ca){I=parseFloat(I);P[ca]=100*I/(P.range[1]-P.range[0]);return c(I)}},direction:{r:true,t:function(I,P,ca){switch(I){case "ltr":P[ca]=0;break;case "rtl":P[ca]=1;P.connect=[0,2,1,3][P.connect];break;default:return false}return true}},behaviour:{r:true,t:function(I,P,ca){P[ca]={tap:I!==(I=I.replace("tap",
"")),extend:I!==(I=I.replace("extend","")),drag:I!==(I=I.replace("drag","")),fixed:I!==(I=I.replace("fixed",""))};return!I.replace("none","").replace(/\-/g,"")}},serialization:{r:true,t:function(I,P,ca){return na.g(I.to,P,ca)&&na.f(I.resolution,P)&&na.e(I.mark,P,ca)}},slide:{t:function(I){return b.isFunction(I)}},set:{t:function(I){return b.isFunction(I)}},block:{t:function(I){return b.isFunction(I)}},step:{t:function(I,P,ca){I=parseFloat(I);P[ca]=100*I/(P.range[1]-P.range[0]);return c(I)}}},function(I,
P){var ca=O[I],va=void 0!==ca;if(P.r&&!va||va&&!P.t(ca,O,I))throw console&&console.log&&console.group&&(console.group("Invalid noUiSlider initialisation:"),console.log("Option:\t",I),console.log("Value:\t",ca),console.log("Slider(s):\t",Z),console.groupEnd()),new RangeError("noUiSlider");})}function qa(O){this.data("options",b.extend(true,{},O));O=b.extend({handles:2,margin:0,connect:false,direction:"ltr",behaviour:"tap",orientation:"horizontal"},O);O.serialization=O.serialization||{};sa(O,this);
O.style=O.orientation?"top":"left";return this.each(function(){var Z=b(this),fa,na=[],I,P=b("<div></ca>").appendTo(Z);if(Z.data("base"))throw Error("Slider was already initialized.");Z.data("base",P).addClass([za[6],za[16+O.direction],za[10+O.orientation]].join(" "));for(fa=0;fa<O.handles;fa++){I=b("<div><div></div></div>").appendTo(P);I.addClass(za[1]);I.children().addClass([za[2],za[2]+za[7+O.direction+(O.direction?-1*fa:fa)]].join(" "));I.data({base:P,target:Z,options:O,grab:I.children(),pct:-1}).attr("data-style",
O.style);I.data({store:N(I,fa,O.serialization)});na.push(I)}switch(O.connect){case 1:Z.addClass(za[9]);na[0].addClass(za[12]);break;case 3:na[1].addClass(za[12]);case 2:na[0].addClass(za[9]);case 0:Z.addClass(za[12])}P.addClass(za[0]).data({target:Z,options:O,handles:na});Z.val(O.start);if(!O.behaviour.fixed)for(fa=0;fa<na.length;fa++)K(Na.start,na[fa].children(),ka,{b:P,target:Z,a:[na[fa]]});O.behaviour.tap&&K(Na.start,P,ta,{b:P,target:Z});O.behaviour.extend&&(Z.addClass(za[19]),O.behaviour.tap&&
K(Na.start,Z,Ka,{b:P,target:Z}));O.behaviour.drag&&(fa=P.find("."+za[9]).addClass(za[18]),O.behaviour.fixed&&(fa=fa.add(P.children().not(fa).data("grab"))),K(Na.start,fa,ka,{b:P,target:Z,a:na}))})}function Oa(){var O=b(this).data("base"),Z=[];b.each(O.data("handles"),function(){Z.push(b(this).data("store").val())});return 1===Z.length?Z[0]:O.data("options").direction?Z.reverse():Z}function Aa(O,Z){b.isArray(O)||(O=[O]);return this.each(function(){var fa=b(this).data("base"),na,I=Array.prototype.slice.call(fa.data("handles"),
0),P=fa.data("options");1<I.length&&(I[2]=I[0]);P.direction&&O.reverse();for(fa=0;fa<I.length;fa++)if(na=O[fa%2],null!==na&&void 0!==na){"string"===b.type(na)&&(na=na.replace(",","."));var ca=P.range;na=parseFloat(na);na=100*(0>ca[0]?na+Math.abs(ca[0]):na-ca[0])/(ca[1]-ca[0]);P.direction&&(na=100-na);true!==m(I[fa],na)&&I[fa].data("store").val(true);true===Z&&e(P.set,b(this))}})}function Sa(O){var Z=[[O,""]];b.each(O.data("base").data("handles"),function(){Z=Z.concat(b(this).data("store").elements)});
b.each(Z,function(){1<this.length&&this[0].off(Wa)});O.removeClass(za.join(" "));O.empty().removeData("base options")}function Ia(O){return this.each(function(){var Z=b(this).val()||false,fa=b(this).data("options"),na=b.extend({},fa,O);false!==Z&&Sa(b(this));O&&(b(this).noUiSlider(na),false!==Z&&na.start===fa.start&&b(this).val(Z))})}var La=b(document),Q=b("body"),Wa=".nui",Ra=b.fn.val,za="noUi-base noUi-origin noUi-handle noUi-input noUi-active noUi-state-tap noUi-target -lower -upper noUi-connect noUi-horizontal noUi-vertical noUi-background noUi-stacking noUi-block noUi-state-blocked noUi-ltr noUi-rtl noUi-dragable noUi-extended noUi-state-drag".split(" "),
Na=window.navigator.pointerEnabled?{start:"pointerdown",move:"pointermove",end:"pointerup"}:window.navigator.msPointerEnabled?{start:"MSPointerDown",move:"MSPointerMove",end:"MSPointerUp"}:{start:"mousedown touchstart",move:"mousemove touchmove",end:"mouseup touchend"};b.fn.val=function(){return this.hasClass(za[6])?arguments.length?Aa.apply(this,arguments):Oa.apply(this):Ra.apply(this,arguments)};return(n?Ia:qa).call(this,f)}})(window.jQuery||window.Zepto);
(function(b){"function"==typeof define&&define.amd?define(["jquery"],b):b(jQuery)})(function(b){var f={wheelSpeed:10,wheelPropagation:false,minScrollbarLength:null,useBothWheelAxes:false,useKeyboard:true,suppressScrollX:false,suppressScrollY:false,scrollXMarginOffset:0,scrollYMarginOffset:0},n=function(){var g=0;return function(){var c=g;return g+=1,".perfect-scrollbar-"+c}}();b.fn.perfectScrollbar=function(g,c){return this.each(function(){var e=b.extend(true,{},f),j=b(this);if("object"==typeof g?
b.extend(true,e,g):c=g,"update"===c)return j.data("perfect-scrollbar-update")&&j.data("perfect-scrollbar-update")(),j;if("destroy"===c)return j.data("perfect-scrollbar-destroy")&&j.data("perfect-scrollbar-destroy")(),j;if(j.data("perfect-scrollbar"))return j.data("perfect-scrollbar");j.addClass("ps-container");var s,w,K,p,L,N,r,x,m,F,V=b("<div class='ps-scrollbar-x-rail'></div>").appendTo(j),ha=b("<div class='ps-scrollbar-y-rail'></div>").appendTo(j),ka=b("<div class='ps-scrollbar-x'></div>").appendTo(V),
ta=b("<div class='ps-scrollbar-y'></div>").appendTo(ha),Ka=parseInt(V.css("bottom"),10),sa=parseInt(ha.css("right"),10),qa=n(),Oa=function(I){return e.minScrollbarLength&&(I=Math.max(I,e.minScrollbarLength)),I},Aa=function(){V.css({left:j.scrollLeft(),bottom:Ka-j.scrollTop(),width:K,display:s?"inherit":"none"});ha.css({top:j.scrollTop(),right:sa-j.scrollLeft(),height:p,display:w?"inherit":"none"});ka.css({left:x,width:r});ta.css({top:F,height:m})},Sa=function(){K=j.width();p=j.height();L=j.prop("scrollWidth");
N=j.prop("scrollHeight");!e.suppressScrollX&&L>K+e.scrollXMarginOffset?(s=true,r=Oa(parseInt(K*K/L,10)),x=parseInt(j.scrollLeft()*(K-r)/(L-K),10)):(s=false,r=0,x=0,j.scrollLeft(0));!e.suppressScrollY&&N>p+e.scrollYMarginOffset?(w=true,m=Oa(parseInt(p*p/N,10)),F=parseInt(j.scrollTop()*(p-m)/(N-p),10)):(w=false,m=0,F=0,j.scrollTop(0));F>=p-m&&(F=p-m);x>=K-r&&(x=K-r);Aa()},Ia=function(){var I,P;ka.bind("mousedown"+qa,function(ca){P=ca.pageX;I=ka.position().left;V.addClass("in-scrolling");ca.stopPropagation();
ca.preventDefault()});b(document).bind("mousemove"+qa,function(ca){if(V.hasClass("in-scrolling")){var va=I+(ca.pageX-P),Qa=K-r;x=0>va?0:va>Qa?Qa:va;va=parseInt(x*(L-K)/(K-r),10);j.scrollLeft(va);ha.css({right:sa-va});ca.stopPropagation();ca.preventDefault()}});b(document).bind("mouseup"+qa,function(){V.hasClass("in-scrolling")&&V.removeClass("in-scrolling")});I=P=null},La=function(){var I,P;ta.bind("mousedown"+qa,function(ca){P=ca.pageY;I=ta.position().top;ha.addClass("in-scrolling");ca.stopPropagation();
ca.preventDefault()});b(document).bind("mousemove"+qa,function(ca){if(ha.hasClass("in-scrolling")){var va=I+(ca.pageY-P),Qa=p-m;F=0>va?0:va>Qa?Qa:va;va=parseInt(F*(N-p)/(p-m),10);j.scrollTop(va);V.css({bottom:Ka-va});ca.stopPropagation();ca.preventDefault()}});b(document).bind("mouseup"+qa,function(){ha.hasClass("in-scrolling")&&ha.removeClass("in-scrolling")});I=P=null},Q=function(I,P){var ca=j.scrollTop();if(0===I){if(!w)return false;if(0===ca&&P>0||ca>=N-p&&0>P)return!e.wheelPropagation}ca=j.scrollLeft();
if(0===P){if(!s)return false;if(0===ca&&0>I||ca>=L-K&&I>0)return!e.wheelPropagation}return true},Wa=function(){var I=false;j.bind("mousewheel"+qa,function(P,ca,va,Qa){e.useBothWheelAxes?w&&!s?Qa?j.scrollTop(j.scrollTop()-Qa*e.wheelSpeed):j.scrollTop(j.scrollTop()+va*e.wheelSpeed):s&&!w&&(va?j.scrollLeft(j.scrollLeft()+va*e.wheelSpeed):j.scrollLeft(j.scrollLeft()-Qa*e.wheelSpeed)):(j.scrollTop(j.scrollTop()-Qa*e.wheelSpeed),j.scrollLeft(j.scrollLeft()+va*e.wheelSpeed));Sa();(I=Q(va,Qa))&&P.preventDefault()});
j.bind("MozMousePixelScroll"+qa,function(P){I&&P.preventDefault()})},Ra=function(){var I=false;j.bind("mouseenter"+qa,function(){I=true});j.bind("mouseleave"+qa,function(){I=false});b(document).bind("keydown"+qa,function(P){if(I){var ca=0,va=0;switch(P.which){case 37:ca=-3;break;case 38:va=3;break;case 39:ca=3;break;case 40:va=-3;break;case 33:va=9;break;case 32:case 34:va=-9;break;case 35:va=-p;break;case 36:va=p;break;default:return}j.scrollTop(j.scrollTop()-va*e.wheelSpeed);j.scrollLeft(j.scrollLeft()+
ca*e.wheelSpeed);Q(ca,va)&&P.preventDefault()}})},za=function(){var I=function(P){P.stopPropagation()};ta.bind("click"+qa,I);ha.bind("click"+qa,function(P){var ca=parseInt(m/2,10);P=(P.pageY-ha.offset().top-ca)/(p-m);0>P?P=0:P>1&&(P=1);j.scrollTop((N-p)*P)});ka.bind("click"+qa,I);V.bind("click"+qa,function(P){var ca=parseInt(r/2,10);P=(P.pageX-V.offset().left-ca)/(K-r);0>P?P=0:P>1&&(P=1);j.scrollLeft((L-K)*P)})},Na=function(){var I=function(Ma,k){j.scrollTop(j.scrollTop()-k);j.scrollLeft(j.scrollLeft()-
Ma);Sa()},P={},ca=0,va={},Qa=null,Pa=false;b(window).bind("touchstart"+qa,function(){Pa=true});b(window).bind("touchend"+qa,function(){Pa=false});j.bind("touchstart"+qa,function(Ma){var k=Ma.originalEvent.targetTouches[0];P.pageX=k.pageX;P.pageY=k.pageY;ca=(new Date).getTime();null!==Qa&&clearInterval(Qa);Ma.stopPropagation()});j.bind("touchmove"+qa,function(Ma){if(!Pa&&1===Ma.originalEvent.targetTouches.length){var k=Ma.originalEvent.targetTouches[0],z={};z.pageX=k.pageX;z.pageY=k.pageY;k=z.pageX-
P.pageX;var C=z.pageY-P.pageY;I(k,C);P=z;z=(new Date).getTime();va.x=k/(z-ca);va.y=C/(z-ca);ca=z;Ma.preventDefault()}});j.bind("touchend"+qa,function(){clearInterval(Qa);Qa=setInterval(function(){return 0.01>Math.abs(va.x)&&0.01>Math.abs(va.y)?(clearInterval(Qa),void 0):(I(30*va.x,30*va.y),va.x*=0.8,va.y*=0.8,void 0)},10)})},O=function(){j.bind("scroll"+qa,function(){Sa()})},Z=function(){j.unbind(qa);b(window).unbind(qa);b(document).unbind(qa);j.data("perfect-scrollbar",null);j.data("perfect-scrollbar-update",
null);j.data("perfect-scrollbar-destroy",null);ka.remove();ta.remove();V.remove();ha.remove();ka=ta=K=p=L=N=r=x=Ka=m=F=sa=null},fa=function(I){j.addClass("ie").addClass("ie"+I);var P=function(){Aa=function(){ka.css({left:x+j.scrollLeft(),bottom:Ka,width:r});ta.css({top:F+j.scrollTop(),right:sa,height:m});ka.hide().show();ta.hide().show()}};6===I&&(function(){var ca=function(){b(this).addClass("hover")},va=function(){b(this).removeClass("hover")};j.bind("mouseenter"+qa,ca).bind("mouseleave"+qa,va);
V.bind("mouseenter"+qa,ca).bind("mouseleave"+qa,va);ha.bind("mouseenter"+qa,ca).bind("mouseleave"+qa,va);ka.bind("mouseenter"+qa,ca).bind("mouseleave"+qa,va);ta.bind("mouseenter"+qa,ca).bind("mouseleave"+qa,va)}(),P())},na="ontouchstart"in window||window.DocumentTouch&&document instanceof window.DocumentTouch;return function(){var I=navigator.userAgent.toLowerCase().match(/(msie) ([\w.]+)/);I&&"msie"===I[1]&&fa(parseInt(I[2],10));Sa();O();Ia();La();za();na&&Na();j.mousewheel&&Wa();e.useKeyboard&&
Ra();j.data("perfect-scrollbar",j);j.data("perfect-scrollbar-update",Sa);j.data("perfect-scrollbar-destroy",Z)}(),j})}});
(function(b){function f(c){var e=c||window.event,j=[].slice.call(arguments,1),s=0,w=0,K=0;return c=b.event.fix(e),c.type="mousewheel",e.detail&&(s=-e.detail/3),void 0!==e.wheelDeltaY&&(K=e.wheelDeltaY/120),void 0!==e.wheelDeltaX&&(w=-1*e.wheelDeltaX/120),j.unshift(c,s,w,K),(b.event.dispatch||b.event.handle).apply(this,j)}var n=["DOMMouseScroll","mousewheel"];if(b.event.fixHooks)for(var g=n.length;g;)b.event.fixHooks[n[--g]]=b.event.mouseHooks;b.event.special.mousewheel={setup:function(){if(this.addEventListener)for(var c=
n.length;c;)this.addEventListener(n[--c],f,false);else this.onmousewheel=f},teardown:function(){if(this.removeEventListener)for(var c=n.length;c;)this.removeEventListener(n[--c],f,false);else this.onmousewheel=null}};b.fn.extend({mousewheel:function(c){return c?this.bind("mousewheel",c):this.trigger("mousewheel")},unmousewheel:function(c){return this.unbind("mousewheel",c)}})})(jQuery);
function revslider_showDoubleJqueryError(b){var f="Revolution Slider Error: You have some jquery.js library include that comes after the revolution files js include.";f+="<br> This includes make eliminates the revolution slider libraries, and make it not work.";f+="<br><br> To fix it you can:<br>    1. In the Slider Settings -> Troubleshooting set option:  <strong><b>Put JS Includes To Body</b></strong> option to true.";f+="<br>    2. Find the double jquery.js include and remove it.";
jQuery(b).show().html("<span style='font-size:16px;color:#BC0C06;'>"+f+"</span>")}
(function(b,f){function n(){var d=false;if(navigator.userAgent.match(/iPhone/i)||navigator.userAgent.match(/iPod/i)||navigator.userAgent.match(/iPad/i)){if(navigator.userAgent.match(/OS 4_\d like Mac OS X/i))d=true}else d=false;return d}function g(d,a){if(a.navigationStyle=="preview1"||a.navigationStyle=="preview3"||a.navigationStyle=="preview4"){a.soloArrowLeftHalign="left";a.soloArrowLeftValign="center";a.soloArrowLeftHOffset=0;a.soloArrowLeftVOffset=0;a.soloArrowRightHalign="right";a.soloArrowRightValign=
"center";a.soloArrowRightHOffset=0;a.soloArrowRightVOffset=0;a.navigationArrows="solo"}if(a.simplifyAll=="on"&&(s(8)||n())){d.find(".tp-caption").each(function(){var U=b(this);U.removeClass("customin").removeClass("customout").addClass("fadein").addClass("fadeout");U.data("splitin","");U.data("speed",400)});d.find(">ul>li").each(function(){var U=b(this);U.data("transition","fade");U.data("masterspeed",500);U.data("slotamount",1);U.find(">img").first().data("kenburns","off")})}a.desktop=!navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|BB10|mobi|tablet|opera mini|nexus 7)/i);
if(a.fullWidth!="on"&&a.fullScreen!="on")a.autoHeight="off";if(a.fullScreen=="on")a.autoHeight="on";if(a.fullWidth!="on"&&a.fullScreen!="on")forceFulWidth="off";a.fullWidth=="on"&&a.autoHeight=="off"&&d.css({maxHeight:a.startheight+"px"});if(k()&&a.hideThumbsOnMobile=="on"&&a.navigationType=="thumb")a.navigationType="none";if(k()&&a.hideBulletsOnMobile=="on"&&a.navigationType=="bullet")a.navigationType="none";if(k()&&a.hideBulletsOnMobile=="on"&&a.navigationType=="both")a.navigationType="none";if(k()&&
a.hideArrowsOnMobile=="on")a.navigationArrows="none";if(a.forceFullWidth=="on"&&d.closest(".forcefullwidth_wrapper_tp_banner").length==0){var h=d.parent().offset().left,u=d.parent().css("marginBottom"),D=d.parent().css("marginTop");if(u==f)u=0;if(D==f)D=0;d.parent().wrap('<div style="position:relative;width:100%;height:auto;margin-top:'+D+";margin-bottom:"+u+'" class="forcefullwidth_wrapper_tp_banner"></div>');d.closest(".forcefullwidth_wrapper_tp_banner").append('<div class="tp-fullwidth-forcer" style="width:100%;height:'+
d.height()+'px"></div>');d.css({backgroundColor:d.parent().css("backgroundColor"),backgroundImage:d.parent().css("backgroundImage")});d.parent().css({left:0-h+"px",position:"absolute",width:b(window).width()});a.width=b(window).width()}try{a.hideThumbsUnderResolution>b(window).width()&&a.hideThumbsUnderResolution!=0?d.parent().find(".tp-bullets.tp-thumbs").css({display:"none"}):d.parent().find(".tp-bullets.tp-thumbs").css({display:"block"})}catch(G){}if(!d.hasClass("revslider-initialised")){d.addClass("revslider-initialised");
d.attr("id")==f&&d.attr("id","revslider-"+Math.round(Math.random()*1E3+5));a.firefox13=false;a.ie=!b.support.opacity;a.ie9=document.documentMode==9;a.origcd=a.delay;h=b.fn.jquery.split(".");u=parseFloat(h[0]);D=parseFloat(h[1]);parseFloat(h[2]||"0");u==1&&D<7&&d.html('<div style="text-align:center; padding:40px 0px; font-size:20px; color:#992222;"> The Current Version of jQuery:'+h+" <br>Please update your jQuery Version to min. 1.7 in Case you wish to use the Revolution Slider Plugin</div>");if(u>
1)a.ie=false;if(!b.support.transition)b.fn.transition=b.fn.animate;d.find(".caption").each(function(){b(this).addClass("tp-caption")});k()&&d.find(".tp-caption").each(function(){var U=b(this);if(U.data("autoplayonlyfirsttime")==true||U.data("autoplayonlyfirsttime")=="true")U.data("autoplayonlyfirsttime","false");if(U.data("autoplay")==true||U.data("autoplay")=="true")U.data("autoplay",false)});var S=0,R=0,H="http";if(location.protocol==="https:")H="https";d.find(".tp-caption").each(function(){try{if((b(this).data("ytid")!=
f||b(this).find("iframe").attr("src").toLowerCase().indexOf("youtube")>0)&&S==0){S=1;var U=document.createElement("script");U.src="https://www.youtube.com/iframe_api";var o=document.getElementsByTagName("script")[0],ga=true;b("head").find("*").each(function(){if(b(this).attr("src")=="https://www.youtube.com/iframe_api")ga=false});ga&&o.parentNode.insertBefore(U,o)}}catch(ua){}try{if((b(this).data("vimeoid")!=f||b(this).find("iframe").attr("src").toLowerCase().indexOf("vimeo")>0)&&R==0){R=1;var Fa=
document.createElement("script");Fa.src=H+"://a.vimeocdn.com/js/froogaloop2.min.js";o=document.getElementsByTagName("script")[0];ga=true;b("head").find("*").each(function(){if(b(this).attr("src")==H+"://a.vimeocdn.com/js/froogaloop2.min.js")ga=false});ga&&o.parentNode.insertBefore(Fa,o)}}catch(la){}try{b(this).data("videomp4")!=f||b(this).data("videowebm")}catch(oa){}});d.find(".tp-caption video").each(function(){b(this).removeClass("video-js").removeClass("vjs-default-skin");b(this).attr("preload",
"");b(this).css({display:"none"})});if(a.shuffle=="on"){h={};u=d.find(">ul:first-child >li:first-child");h.fstransition=u.data("fstransition");h.fsmasterspeed=u.data("fsmasterspeed");h.fsslotamount=u.data("fsslotamount");for(u=0;u<d.find(">ul:first-child >li").length;u++){D=Math.round(Math.random()*d.find(">ul:first-child >li").length);d.find(">ul:first-child >li:eq("+D+")").prependTo(d.find(">ul:first-child"))}u=d.find(">ul:first-child >li:first-child");u.data("fstransition",h.fstransition);u.data("fsmasterspeed",
h.fsmasterspeed);u.data("fsslotamount",h.fsslotamount)}a.slots=4;a.act=-1;a.next=0;if(a.startWithSlide!=f)a.next=a.startWithSlide;h=e("#")[0];if(h.length<9)if(h.split("slide").length>1){h=parseInt(h.split("slide")[1],0);if(h<1)h=1;if(h>d.find(">ul:first >li").length)h=d.find(">ul:first >li").length;a.next=h-1}a.firststart=1;if(a.navigationHOffset==f)a.navOffsetHorizontal=0;if(a.navigationVOffset==f)a.navOffsetVertical=0;d.append('<div class="tp-loader '+a.spinner+'"><div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
d.find(".tp-bannertimer").length==0&&d.append('<div class="tp-bannertimer" style="visibility:hidden"></div>');h=d.find(".tp-bannertimer");h.length>0&&h.css({width:"0%"});d.addClass("tp-simpleresponsive");a.container=d;a.slideamount=d.find(">ul:first >li").length;d.height()==0&&d.height(a.startheight);if(a.startwidth==f||a.startwidth==0)a.startwidth=d.width();if(a.startheight==f||a.startheight==0)a.startheight=d.height();a.width=d.width();a.height=d.height();a.bw=a.startwidth/d.width();a.bh=a.startheight/
d.height();if(a.width!=a.startwidth){a.height=Math.round(a.startheight*(a.width/a.startwidth));d.height(a.height)}if(a.shadow!=0){d.parent().append('<div class="tp-bannershadow tp-shadow'+a.shadow+'"></div>');h=0;if(a.forceFullWidth=="on")h=0-a.container.parent().offset().left;d.parent().find(".tp-bannershadow").css({width:a.width,left:h})}d.find("ul").css({display:"none"});d.find("ul").css({display:"block"});V(d,a);a.parallax!="off"&&xa(d,a);a.slideamount>1&&K(d,a);a.slideamount>1&&a.navigationType==
"thumb"&&Ga(d,a);a.slideamount>1&&p(d,a);a.keyboardNavigation=="on"&&L(d,a);N(d,a);a.hideThumbs>0&&r(d,a);Aa(d,a);a.slideamount>1&&Ma(d,a);setTimeout(function(){d.trigger("revolution.slide.onloaded")},500);b("body").data("rs-fullScreenMode",false);b(window).on("mozfullscreenchange webkitfullscreenchange fullscreenchange",function(){b("body").data("rs-fullScreenMode",!b("body").data("rs-fullScreenMode"));b("body").data("rs-fullScreenMode")&&setTimeout(function(){b(window).trigger("resize")},200)});
b(window).resize(function(){if(b("body").find(d)!=0)if(a.forceFullWidth=="on"){var U=a.container.closest(".forcefullwidth_wrapper_tp_banner").offset().left;a.container.parent().css({left:0-U+"px",width:b(window).width()})}if(d.outerWidth(true)!=a.width||d.is(":hidden"))j(d,a)});try{if(a.hideThumbsUnderResoluition!=0&&a.navigationType=="thumb")a.hideThumbsUnderResoluition>b(window).width()?b(".tp-bullets").css({display:"none"}):b(".tp-bullets").css({display:"block"})}catch(ea){}d.find(".tp-scrollbelowslider").on("click",
function(){var U=0;try{U=b("body").find(a.fullScreenOffsetContainer).height()}catch(o){}try{U-=parseInt(b(this).data("scrolloffset"),0)}catch(ga){}b("body,html").animate({scrollTop:d.offset().top+d.find(">ul >li").height()-U+"px"},{duration:400})});h=d.parent();if(b(window).width()<a.hideSliderAtLimit){d.trigger("stoptimer");h.css("display")!="none"&&h.data("olddisplay",h.css("display"));h.css({display:"none"})}c(d,a)}}b.fn.extend({revolution:function(d){defaults={delay:9E3,startheight:500,startwidth:960,
fullScreenAlignForce:"off",autoHeight:"off",hideTimerBar:"off",hideThumbs:200,hideNavDelayOnMobile:1500,thumbWidth:100,thumbHeight:50,thumbAmount:3,navigationType:"bullet",navigationArrows:"solo",navigationInGrid:"off",hideThumbsOnMobile:"off",hideBulletsOnMobile:"off",hideArrowsOnMobile:"off",hideThumbsUnderResoluition:0,navigationStyle:"round",navigationHAlign:"center",navigationVAlign:"bottom",navigationHOffset:0,navigationVOffset:20,soloArrowLeftHalign:"left",soloArrowLeftValign:"center",soloArrowLeftHOffset:20,
soloArrowLeftVOffset:0,soloArrowRightHalign:"right",soloArrowRightValign:"center",soloArrowRightHOffset:20,soloArrowRightVOffset:0,keyboardNavigation:"on",touchenabled:"on",onHoverStop:"on",stopAtSlide:-1,stopAfterLoops:-1,hideCaptionAtLimit:0,hideAllCaptionAtLimit:0,hideSliderAtLimit:0,shadow:0,fullWidth:"off",fullScreen:"off",minFullScreenHeight:0,fullScreenOffsetContainer:"",fullScreenOffset:"0",dottedOverlay:"none",forceFullWidth:"off",spinner:"spinner0",swipe_treshold:75,swipe_min_touches:1,
drag_block_vertical:false,isJoomla:false,parallax:"off",parallaxLevels:[10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85],parallaxBgFreeze:"off",parallaxOpacity:"on",parallaxDisableOnMobile:"off",panZoomDisableOnMobile:"off",simplifyAll:"on",minHeight:0,nextSlideOnWindowFocus:"off"};d=b.extend({},defaults,d);return this.each(function(){if(window.tplogs==true)try{console.groupCollapsed("Slider Revolution 4.6.0 Initialisation on "+b(this).attr("id"));console.groupCollapsed("Used Options:");console.info(d);
console.groupEnd();console.groupCollapsed("Tween Engine:")}catch(a){}if(punchgs.TweenLite==f){if(window.tplogs==true)try{console.error("GreenSock Engine Does not Exist!")}catch(h){}return false}punchgs.force3D=true;if(window.tplogs==true)try{console.info("GreenSock Engine Version in Slider Revolution:"+punchgs.TweenLite.version)}catch(u){}if(d.simplifyAll!="on"){punchgs.TweenLite.lagSmoothing(1E3,16);punchgs.force3D="true"}if(window.tplogs==true)try{console.groupEnd();console.groupEnd()}catch(D){}g(b(this),
d)})},revscroll:function(d){return this.each(function(){var a=b(this);b("body,html").animate({scrollTop:a.offset().top+a.find(">ul >li").height()-d+"px"},{duration:400})})},revredraw:function(){return this.each(function(){var d=b(this),a=d.parent().find(".tp-bannertimer").data("opt");j(d,a)})},revpause:function(){return this.each(function(){var d=b(this);d.data("conthover",1);d.data("conthover-changed",1);d.trigger("revolution.slide.onpause");d.parent().find(".tp-bannertimer").data("opt").bannertimeronpause=
true;d.trigger("stoptimer")})},revresume:function(){return this.each(function(){var d=b(this);d.data("conthover",0);d.data("conthover-changed",1);d.trigger("revolution.slide.onresume");d.parent().find(".tp-bannertimer").data("opt").bannertimeronpause=false;d.trigger("starttimer")})},revnext:function(){return this.each(function(){b(this).parent().find(".tp-rightarrow").click()})},revprev:function(){return this.each(function(){b(this).parent().find(".tp-leftarrow").click()})},revmaxslide:function(){return b(this).find(">ul:first-child >li").length},
revcurrentslide:function(){return b(this).parent().find(".tp-bannertimer").data("opt").act},revlastslide:function(){return b(this).parent().find(".tp-bannertimer").data("opt").lastslide},revshowslide:function(d){return this.each(function(){var a=b(this);a.data("showus",d);a.parent().find(".tp-rightarrow").click()})}});(function(){var d,a,h={hidden:"visibilitychange",webkitHidden:"webkitvisibilitychange",mozHidden:"mozvisibilitychange",msHidden:"msvisibilitychange"};for(d in h)if(d in document){a=
h[d];break}return function(u){u&&document.addEventListener(a,u);return!document[d]}})();var c=function(d,a){var h=window.chrome;if(document.documentMode===f&&!h)b(window).on("focusin",function(){setTimeout(function(){a.nextSlideOnWindowFocus=="on"&&d.revnext();d.revredraw()},300)}).on("focusout",function(){});else if(window.addEventListener){window.addEventListener("focus",function(){setTimeout(function(){a.nextSlideOnWindowFocus=="on"&&d.revnext();d.revredraw()},300)},false);window.addEventListener("blur",
function(){},false)}else{window.attachEvent("focus",function(){setTimeout(function(){a.nextSlideOnWindowFocus=="on"&&d.revnext();d.revredraw()},300)});window.attachEvent("blur",function(){})}},e=function(d){for(var a=[],h=window.location.href.slice(window.location.href.indexOf(d)+1).split("_"),u=0;u<h.length;u++){h[u]=h[u].replace("%3D","=");d=h[u].split("=");a.push(d[0]);a[d[0]]=d[1]}return a},j=function(d,a){try{if(a.hideThumbsUnderResoluition!=0&&a.navigationType=="thumb")a.hideThumbsUnderResoluition>
b(window).width()?b(".tp-bullets").css({display:"none"}):b(".tp-bullets").css({display:"block"})}catch(h){}d.find(".defaultimg").each(function(){F(b(this),a)});var u=d.parent();if(b(window).width()<a.hideSliderAtLimit){d.trigger("stoptimer");u.css("display")!="none"&&u.data("olddisplay",u.css("display"));u.css({display:"none"})}else if(d.is(":hidden")){u.data("olddisplay")!=f&&u.data("olddisplay")!="undefined"&&u.data("olddisplay")!="none"?u.css({display:u.data("olddisplay")}):u.css({display:"block"});
d.trigger("restarttimer");setTimeout(function(){j(d,a)},150)}u=0;if(a.forceFullWidth=="on")u=0-a.container.parent().offset().left;try{d.parent().find(".tp-bannershadow").css({width:a.width,left:u})}catch(D){}u=d.find(">ul >li:eq("+a.act+") .slotholder");var G=d.find(">ul >li:eq("+a.next+") .slotholder");Ka(d,a,d);punchgs.TweenLite.set(G.find(".defaultimg"),{opacity:0});u.find(".defaultimg").css({opacity:1});G.find(".defaultimg").each(function(){var S=b(this);if(!(a.panZoomDisableOnMobile=="on"&&k()))if(S.data("kenburn")!=
f){S.data("kenburn").restart();C(d,a,true)}});u=d.find(">ul >li:eq("+a.next+")");G=d.parent().find(".tparrows");G.hasClass("preview2")&&G.css({width:parseInt(G.css("minWidth"),0)});fa(u,a,true);x(d,a)},s=function(d,a){var h=b('<div style="display:none;"></div>').appendTo(b("body"));h.html("<\!--[if "+(a||"")+" IE "+(d||"")+"]><a> </a><![endif]--\>");var u=h.find("a").length;h.remove();return u},w=function(d,a){if(d.next==a.find(">ul >li").length-1){d.looptogo-=1;if(d.looptogo<=0)d.stopLoop="on"}Aa(a,
d)},K=function(d,a){var h="hidebullets";if(a.hideThumbs==0)h="";if(a.navigationType=="bullet"||a.navigationType=="both")d.parent().append('<div class="tp-bullets '+h+" simplebullets "+a.navigationStyle+'"></div>');var u=d.parent().find(".tp-bullets");d.find(">ul:first >li").each(function(D){d.find(">ul:first >li:eq("+D+") img:first").attr("src");u.append('<div class="bullet"></div>');u.find(".bullet:first")});u.find(".bullet").each(function(D){var G=b(this);D==a.slideamount-1&&G.addClass("last");
D==0&&G.addClass("first");G.click(function(){var S=false;if(a.navigationArrows=="withbullet"||a.navigationArrows=="nexttobullets"){if(G.index()-1==a.act)S=true}else if(G.index()==a.act)S=true;if(a.transition==0&&!S){a.next=a.navigationArrows=="withbullet"||a.navigationArrows=="nexttobullets"?G.index()-1:G.index();w(a,d)}})});u.append('<div class="tpclear"></div>');x(d,a)},p=function(d,a){function h(S){d.parent().append('<div style="'+u+'" class="tp-'+S+"arrow "+D+" tparrows "+G+'"><div class="tp-arr-allwrapper"><div class="tp-arr-iwrapper"><div class="tp-arr-imgholder"></div><div class="tp-arr-imgholder2"></div><div class="tp-arr-titleholder"></div><div class="tp-arr-subtitleholder"></div></div></div></div>')}
d.find(".tp-bullets");var u="",D="hidearrows";if(a.hideThumbs==0)D="";var G=a.navigationStyle;if(a.navigationArrows=="none")u="visibility:hidden;display:none";a.soloArrowStyle="default "+a.navigationStyle;if(a.navigationArrows!="none"&&a.navigationArrows!="nexttobullets")G=a.soloArrowStyle;h("left");h("right");d.parent().find(".tp-rightarrow").click(function(){if(a.transition==0){if(d.data("showus")!=f&&d.data("showus")!=-1)a.next=d.data("showus")-1;else a.next+=1;d.data("showus",-1);if(a.next>=a.slideamount)a.next=
0;if(a.next<0)a.next=0;a.act!=a.next&&w(a,d)}});d.parent().find(".tp-leftarrow").click(function(){if(a.transition==0){a.next-=1;a.leftarrowpressed=1;if(a.next<0)a.next=a.slideamount-1;w(a,d)}});x(d,a)},L=function(d,a){b(document).keydown(function(h){if(a.transition==0&&h.keyCode==39){if(d.data("showus")!=f&&d.data("showus")!=-1)a.next=d.data("showus")-1;else a.next+=1;d.data("showus",-1);if(a.next>=a.slideamount)a.next=0;if(a.next<0)a.next=0;a.act!=a.next&&w(a,d)}if(a.transition==0&&h.keyCode==37){a.next-=
1;a.leftarrowpressed=1;if(a.next<0)a.next=a.slideamount-1;w(a,d)}});x(d,a)},N=function(d,a){var h="vertical";if(a.touchenabled=="on"){if(a.drag_block_vertical==true)h="none";d.swipe({allowPageScroll:h,fingers:a.swipe_min_touches,treshold:a.swipe_treshold,swipe:function(u,D){switch(D){case "left":if(a.transition==0){a.next+=1;if(a.next==a.slideamount)a.next=0;w(a,d)}break;case "right":if(a.transition==0){a.next-=1;a.leftarrowpressed=1;if(a.next<0)a.next=a.slideamount-1;w(a,d)}break;case "up":h=="none"&&
b("html, body").animate({scrollTop:d.offset().top+d.height()+"px"});break;case "down":h=="none"&&b("html, body").animate({scrollTop:d.offset().top-b(window).height()+"px"})}}})}},r=function(d,a){var h=d.parent().find(".tp-bullets"),u=d.parent().find(".tparrows");if(h==null){d.append('<div class=".tp-bullets"></div>');h=d.parent().find(".tp-bullets")}if(u==null){d.append('<div class=".tparrows"></div>');u=d.parent().find(".tparrows")}d.data("hideThumbs",a.hideThumbs);h.addClass("hidebullets");u.addClass("hidearrows");
if(k())try{d.hammer().on("touch",function(){d.addClass("hovered");a.onHoverStop=="on"&&d.trigger("stoptimer");clearTimeout(d.data("hideThumbs"));h.removeClass("hidebullets");u.removeClass("hidearrows")});d.hammer().on("release",function(){d.removeClass("hovered");d.trigger("starttimer");!d.hasClass("hovered")&&!h.hasClass("hovered")&&d.data("hideThumbs",setTimeout(function(){h.addClass("hidebullets");u.addClass("hidearrows");d.trigger("starttimer")},a.hideNavDelayOnMobile))})}catch(D){}else{h.hover(function(){a.overnav=
true;a.onHoverStop=="on"&&d.trigger("stoptimer");h.addClass("hovered");clearTimeout(d.data("hideThumbs"));h.removeClass("hidebullets");u.removeClass("hidearrows")},function(){a.overnav=false;d.trigger("starttimer");h.removeClass("hovered");!d.hasClass("hovered")&&!h.hasClass("hovered")&&d.data("hideThumbs",setTimeout(function(){h.addClass("hidebullets");u.addClass("hidearrows")},a.hideThumbs))});u.hover(function(){a.overnav=true;a.onHoverStop=="on"&&d.trigger("stoptimer");h.addClass("hovered");clearTimeout(d.data("hideThumbs"));
h.removeClass("hidebullets");u.removeClass("hidearrows")},function(){a.overnav=false;d.trigger("starttimer");h.removeClass("hovered")});d.on("mouseenter",function(){d.addClass("hovered");a.onHoverStop=="on"&&d.trigger("stoptimer");clearTimeout(d.data("hideThumbs"));h.removeClass("hidebullets");u.removeClass("hidearrows")});d.on("mouseleave",function(){d.removeClass("hovered");d.trigger("starttimer");!d.hasClass("hovered")&&!h.hasClass("hovered")&&d.data("hideThumbs",setTimeout(function(){h.addClass("hidebullets");
u.addClass("hidearrows")},a.hideThumbs))})}},x=function(d,a){var h=d.parent(),u=h.find(".tp-bullets");if(a.navigationType=="thumb"){u.find(".thumb").each(function(){b(this).css({width:a.thumbWidth*a.bw+"px",height:a.thumbHeight*a.bh+"px"})});var D=u.find(".tp-mask");D.width(a.thumbWidth*a.thumbAmount*a.bw);D.height(a.thumbHeight*a.bh);D.parent().width(a.thumbWidth*a.thumbAmount*a.bw);D.parent().height(a.thumbHeight*a.bh)}D=h.find(".tp-leftarrow");h=h.find(".tp-rightarrow");if(a.navigationType=="thumb"&&
a.navigationArrows=="nexttobullets")a.navigationArrows="solo";if(a.navigationArrows=="nexttobullets"){D.prependTo(u).css({"float":"left"});h.insertBefore(u.find(".tpclear")).css({"float":"left"})}var G=0;if(a.forceFullWidth=="on")G=0-a.container.parent().offset().left;var S=0;if(a.navigationInGrid=="on"){S=d.width()>a.startwidth?(d.width()-a.startwidth)/2:0;d.height()>a.startheight&&d.height()}if(a.navigationArrows!="none"&&a.navigationArrows!="nexttobullets"){D.css({position:"absolute"});h.css({position:"absolute"});
a.soloArrowLeftValign=="center"&&D.css({top:"50%",marginTop:a.soloArrowLeftVOffset-Math.round(D.innerHeight()/2)+"px"});a.soloArrowLeftValign=="bottom"&&D.css({top:"auto",bottom:0+a.soloArrowLeftVOffset+"px"});a.soloArrowLeftValign=="top"&&D.css({bottom:"auto",top:0+a.soloArrowLeftVOffset+"px"});a.soloArrowLeftHalign=="center"&&D.css({left:"50%",marginLeft:G+a.soloArrowLeftHOffset-Math.round(D.innerWidth()/2)+"px"});a.soloArrowLeftHalign=="left"&&D.css({left:S+a.soloArrowLeftHOffset+G+"px"});a.soloArrowLeftHalign==
"right"&&D.css({right:S+a.soloArrowLeftHOffset-G+"px"});a.soloArrowRightValign=="center"&&h.css({top:"50%",marginTop:a.soloArrowRightVOffset-Math.round(h.innerHeight()/2)+"px"});a.soloArrowRightValign=="bottom"&&h.css({top:"auto",bottom:0+a.soloArrowRightVOffset+"px"});a.soloArrowRightValign=="top"&&h.css({bottom:"auto",top:0+a.soloArrowRightVOffset+"px"});a.soloArrowRightHalign=="center"&&h.css({left:"50%",marginLeft:G+a.soloArrowRightHOffset-Math.round(h.innerWidth()/2)+"px"});a.soloArrowRightHalign==
"left"&&h.css({left:S+a.soloArrowRightHOffset+G+"px"});a.soloArrowRightHalign=="right"&&h.css({right:S+a.soloArrowRightHOffset-G+"px"});D.position()!=null&&D.css({top:Math.round(parseInt(D.position().top,0))+"px"});h.position()!=null&&h.css({top:Math.round(parseInt(h.position().top,0))+"px"})}if(a.navigationArrows=="none"){D.css({visibility:"hidden"});h.css({visibility:"hidden"})}a.navigationVAlign=="center"&&u.css({top:"50%",marginTop:a.navigationVOffset-Math.round(u.innerHeight()/2)+"px"});a.navigationVAlign==
"bottom"&&u.css({bottom:0+a.navigationVOffset+"px"});a.navigationVAlign=="top"&&u.css({top:0+a.navigationVOffset+"px"});a.navigationHAlign=="center"&&u.css({left:"50%",marginLeft:G+a.navigationHOffset-Math.round(u.innerWidth()/2)+"px"});a.navigationHAlign=="left"&&u.css({left:0+a.navigationHOffset+G+"px"});a.navigationHAlign=="right"&&u.css({right:0+a.navigationHOffset-G+"px"})},m=function(d){var a=d.container;d.beforli=d.next-1;d.comingli=d.next+1;if(d.beforli<0)d.beforli=d.slideamount-1;if(d.comingli>=
d.slideamount)d.comingli=0;var h=a.find(">ul:first-child >li:eq("+d.comingli+")"),u=a.find(">ul:first-child >li:eq("+d.beforli+")"),D=u.find(".defaultimg").attr("src"),G=h.find(".defaultimg").attr("src");if(d.arr==f){d.arr=a.parent().find(".tparrows");d.rar=a.parent().find(".tp-rightarrow");d.lar=a.parent().find(".tp-leftarrow");d.raimg=d.rar.find(".tp-arr-imgholder");d.laimg=d.lar.find(".tp-arr-imgholder");d.raimg_b=d.rar.find(".tp-arr-imgholder2");d.laimg_b=d.lar.find(".tp-arr-imgholder2");d.ratit=
d.rar.find(".tp-arr-titleholder");d.latit=d.lar.find(".tp-arr-titleholder")}a=d.arr;var S=d.rar,R=d.lar,H=d.raimg,ea=d.laimg,U=d.raimg_b,o=d.laimg_b,ga=d.ratit;d=d.latit;h.data("title")!=f&&ga.html(h.data("title"));u.data("title")!=f&&d.html(u.data("title"));S.hasClass("itishovered")&&S.width(ga.outerWidth(true)+parseInt(S.css("minWidth"),0));R.hasClass("itishovered")&&R.width(d.outerWidth(true)+parseInt(R.css("minWidth"),0));if(a.hasClass("preview2")&&!a.hasClass("hashoveralready")){a.addClass("hashoveralready");
if(k()){a=b(this);d=a.find(".tp-arr-titleholder");d.addClass("alwayshidden");punchgs.TweenLite.set(d,{autoAlpha:0})}else a.hover(function(){var ua=b(this),Fa=ua.find(".tp-arr-titleholder");b(window).width()>767&&ua.width(Fa.outerWidth(true)+parseInt(ua.css("minWidth"),0));ua.addClass("itishovered")},function(){var ua=b(this);ua.find(".tp-arr-titleholder");ua.css({width:parseInt(ua.css("minWidth"),0)});ua.removeClass("itishovered")})}if(u.data("thumb")!=f)D=u.data("thumb");if(h.data("thumb")!=f)G=
h.data("thumb");if(a.hasClass("preview4")){U.css({backgroundImage:"url("+G+")"});o.css({backgroundImage:"url("+D+")"});punchgs.TweenLite.fromTo(U,0.8,{force3D:punchgs.force3d,x:0},{x:-H.width(),ease:punchgs.Power3.easeOut,delay:1,onComplete:function(){H.css({backgroundImage:"url("+G+")"});punchgs.TweenLite.set(U,{x:0})}});punchgs.TweenLite.fromTo(o,0.8,{force3D:punchgs.force3d,x:0},{x:H.width(),ease:punchgs.Power3.easeOut,delay:1,onComplete:function(){ea.css({backgroundImage:"url("+D+")"});punchgs.TweenLite.set(o,
{x:0})}});punchgs.TweenLite.fromTo(H,0.8,{x:0},{force3D:punchgs.force3d,x:-H.width(),ease:punchgs.Power3.easeOut,delay:1,onComplete:function(){punchgs.TweenLite.set(H,{x:0})}});punchgs.TweenLite.fromTo(ea,0.8,{x:0},{force3D:punchgs.force3d,x:H.width(),ease:punchgs.Power3.easeOut,delay:1,onComplete:function(){punchgs.TweenLite.set(ea,{x:0})}})}else{punchgs.TweenLite.to(H,0.5,{autoAlpha:0,onComplete:function(){H.css({backgroundImage:"url("+G+")"});ea.css({backgroundImage:"url("+D+")"})}});punchgs.TweenLite.to(ea,
0.5,{autoAlpha:0,onComplete:function(){punchgs.TweenLite.to(H,0.5,{autoAlpha:1,delay:0.2});punchgs.TweenLite.to(ea,0.5,{autoAlpha:1,delay:0.2})}})}if(S.hasClass("preview4")&&!S.hasClass("hashoveralready")){S.addClass("hashoveralready");S.hover(function(){var ua=b(this).find(".tp-arr-iwrapper"),Fa=b(this).find(".tp-arr-allwrapper");punchgs.TweenLite.fromTo(ua,0.4,{x:ua.width()},{x:0,delay:0.3,ease:punchgs.Power3.easeOut,overwrite:"all"});punchgs.TweenLite.to(Fa,0.2,{autoAlpha:1,overwrite:"all"})},
function(){var ua=b(this).find(".tp-arr-iwrapper"),Fa=b(this).find(".tp-arr-allwrapper");punchgs.TweenLite.to(ua,0.4,{x:ua.width(),ease:punchgs.Power3.easeOut,delay:0.2,overwrite:"all"});punchgs.TweenLite.to(Fa,0.2,{delay:0.6,autoAlpha:0,overwrite:"all"})});R.hover(function(){var ua=b(this).find(".tp-arr-iwrapper"),Fa=b(this).find(".tp-arr-allwrapper");punchgs.TweenLite.fromTo(ua,0.4,{x:0-ua.width()},{x:0,delay:0.3,ease:punchgs.Power3.easeOut,overwrite:"all"});punchgs.TweenLite.to(Fa,0.2,{autoAlpha:1,
overwrite:"all"})},function(){var ua=b(this).find(".tp-arr-iwrapper"),Fa=b(this).find(".tp-arr-allwrapper");punchgs.TweenLite.to(ua,0.4,{x:0-ua.width(),ease:punchgs.Power3.easeOut,delay:0.2,overwrite:"all"});punchgs.TweenLite.to(Fa,0.2,{delay:0.6,autoAlpha:0,overwrite:"all"})})}},F=function(d,a){a.container.closest(".forcefullwidth_wrapper_tp_banner").find(".tp-fullwidth-forcer").css({height:a.container.height()});a.container.closest(".rev_slider_wrapper").css({height:a.container.height()});a.width=
parseInt(a.container.width(),0);a.height=parseInt(a.container.height(),0);a.bw=a.width/a.startwidth;a.bh=a.height/a.startheight;if(a.bh>a.bw)a.bh=a.bw;if(a.bh<a.bw)a.bw=a.bh;if(a.bw<a.bh)a.bh=a.bw;if(a.bh>1){a.bw=1;a.bh=1}if(a.bw>1){a.bw=1;a.bh=1}a.height=Math.round(a.startheight*(a.width/a.startwidth));if(a.height>a.startheight&&a.autoHeight!="on")a.height=a.startheight;if(a.fullScreen=="on"){a.height=a.bw*a.startheight;a.container.parent().width();var h=b(window).height();if(a.fullScreenOffsetContainer!=
f){try{var u=a.fullScreenOffsetContainer.split(",");b.each(u,function(S,R){h-=b(R).outerHeight(true);if(h<a.minFullScreenHeight)h=a.minFullScreenHeight})}catch(D){}try{if(a.fullScreenOffset.split("%").length>1&&a.fullScreenOffset!=f&&a.fullScreenOffset.length>0)h-=b(window).height()*parseInt(a.fullScreenOffset,0)/100;else if(a.fullScreenOffset!=f&&a.fullScreenOffset.length>0)h-=parseInt(a.fullScreenOffset,0);if(h<a.minFullScreenHeight)h=a.minFullScreenHeight}catch(G){}}a.container.parent().height(h);
a.container.closest(".rev_slider_wrapper").height(h);a.container.css({height:"100%"});a.height=h;if(a.minHeight!=f&&a.height<a.minHeight)a.height=a.minHeight}else{if(a.minHeight!=f&&a.height<a.minHeight)a.height=a.minHeight;a.container.height(a.height)}a.slotw=Math.ceil(a.width/a.slots);a.sloth=a.fullScreen=="on"?Math.ceil(b(window).height()/a.slots):Math.ceil(a.height/a.slots);if(a.autoHeight=="on")a.sloth=Math.ceil(d.height()/a.slots)},V=function(d,a){d.find(".tp-caption").each(function(){b(this).addClass(b(this).data("transition"));
b(this).addClass("start")});d.find(">ul:first").css({overflow:"hidden",width:"100%",height:"100%",maxHeight:d.parent().css("maxHeight")});if(a.autoHeight=="on"){d.find(">ul:first").css({overflow:"hidden",width:"100%",height:"100%",maxHeight:"none"});d.css({maxHeight:"none"});d.parent().css({maxHeight:"none"})}d.find(">ul:first >li").each(function(){var h=b(this);h.css({width:"100%",height:"100%",overflow:"hidden"});if(h.data("link")!=f){var u=h.data("link"),D="_self",G=60;if(h.data("slideindex")==
"back")G=0;var S=h.data("linktoslide");if(h.data("target")!=f)D=h.data("target");u=="slide"?h.append('<div class="tp-caption sft slidelink" style="width:100%;height:100%;z-index:'+G+';" data-x="center" data-y="center" data-linktoslide="'+S+'" data-start="0"><a style="width:100%;height:100%;display:block"><span style="width:100%;height:100%;display:block"></span></a></div>'):h.append('<div class="tp-caption sft slidelink" style="width:100%;height:100%;z-index:'+G+';" data-x="center" data-y="center" data-linktoslide="no" data-start="0"><a style="width:100%;height:100%;display:block" target="'+
D+'" href="'+u+'"><span style="width:100%;height:100%;display:block"></span></a></div>')}});d.parent().css({overflow:"visible"});d.find(">ul:first >li >img").each(function(h){var u=b(this);u.addClass("defaultimg");u.data("lazyload")!=f&&u.data("lazydone")!=1||F(u,a);u.wrap('<div class="slotholder" style="width:100%;height:100%;"data-duration="'+u.data("duration")+'"data-zoomstart="'+u.data("zoomstart")+'"data-zoomend="'+u.data("zoomend")+'"data-rotationstart="'+u.data("rotationstart")+'"data-rotationend="'+
u.data("rotationend")+'"data-ease="'+u.data("ease")+'"data-duration="'+u.data("duration")+'"data-bgpositionend="'+u.data("bgpositionend")+'"data-bgposition="'+u.data("bgposition")+'"data-duration="'+u.data("duration")+'"data-kenburns="'+u.data("kenburns")+'"data-easeme="'+u.data("ease")+'"data-bgfit="'+u.data("bgfit")+'"data-bgfitend="'+u.data("bgfitend")+'"data-owidth="'+u.data("owidth")+'"data-oheight="'+u.data("oheight")+'"></div>');a.dottedOverlay!="none"&&a.dottedOverlay!=f&&u.closest(".slotholder").append('<div class="tp-dottedoverlay '+
a.dottedOverlay+'"></div>');var D=u.attr("src");u.data("lazyload");var G=u.data("bgfit"),S=u.data("bgrepeat"),R=u.data("bgposition");if(G==f)G="cover";if(S==f)S="no-repeat";if(R==f)R="center center";var H=u.closest(".slotholder");u.replaceWith('<div class="tp-bgimg defaultimg" data-lazyload="'+u.data("lazyload")+'" data-bgfit="'+G+'"data-bgposition="'+R+'" data-bgrepeat="'+S+'" data-lazydone="'+u.data("lazydone")+'" src="'+D+'" data-src="'+D+'" style="background-color:'+u.css("backgroundColor")+";background-repeat:"+
S+";background-image:url("+D+");background-size:"+G+";background-position:"+R+';width:100%;height:100%;"></div>');if(s(8)){H.find(".tp-bgimg").css({backgroundImage:"none","background-image":"none"});H.find(".tp-bgimg").append('<img class="ieeightfallbackimage defaultimg" src="'+D+'" style="width:100%">')}u.css({opacity:0});u.data("li-id",h)})},ha=function(d,a,h,u){var D=d.find(".defaultimg"),G=d.data("zoomstart"),S=d.data("rotationstart");if(D.data("currotate")!=f)S=D.data("currotate");if(D.data("curscale")!=
f)G=D.data("curscale");F(D,a);var R=D.data("src"),H=D.css("background-color"),ea=a.width,U=a.height,o=D.data("fxof");if(a.autoHeight=="on")U=a.container.height();if(o==f)o=0;var ga=fullyoff=0,ua=D.data("bgfit"),Fa=D.data("bgrepeat");D=D.data("bgposition");if(ua==f)ua="cover";if(Fa==f)Fa="no-repeat";if(D==f)D="center center";if(s(8)){d.data("kenburns","off");var la=R;R=""}a.panZoomDisableOnMobile=="on"&&k()&&d.data("kenburns","off");if(d.data("kenburns")=="on"){ua=G;if(ua.toString().length<4)ua=z(ua,
d,a)}if(u=="horizontal"){h||(ga=0-a.slotw);for(h=0;h<a.slots;h++){d.append('<div class="slot" style="position:absolute;top:'+(0+fullyoff)+"px;left:"+(o+h*a.slotw)+"px;overflow:hidden;width:"+(a.slotw+0.6)+"px;height:"+U+'px"><div class="slotslide" style="position:absolute;top:0px;left:'+ga+"px;width:"+(a.slotw+0.6)+"px;height:"+U+'px;overflow:hidden;"><div style="background-color:'+H+";position:absolute;top:0px;left:"+(0-h*a.slotw)+"px;width:"+ea+"px;height:"+U+"px;background-image:url("+R+");background-repeat:"+
Fa+";background-size:"+ua+";background-position:"+D+';"></div></div></div>');G!=f&&S!=f&&punchgs.TweenLite.set(d.find(".slot").last(),{rotationZ:S});if(s(8)){d.find(".slot ").last().find(".slotslide").append('<img class="ieeightfallbackimage" src="'+la+'" style="width:100%;height:auto">');ta(d,a)}}}else{h||(ga=0-a.sloth);for(h=0;h<a.slots+2;h++){d.append('<div class="slot" style="position:absolute;top:'+(fullyoff+h*a.sloth)+"px;left:"+o+"px;overflow:hidden;width:"+ea+"px;height:"+a.sloth+'px"><div class="slotslide" style="position:absolute;top:'+
ga+"px;left:0px;width:"+ea+"px;height:"+a.sloth+'px;overflow:hidden;"><div style="background-color:'+H+";position:absolute;top:"+(0-h*a.sloth)+"px;left:0px;width:"+ea+"px;height:"+U+"px;background-image:url("+R+");background-repeat:"+Fa+";background-size:"+ua+";background-position:"+D+';"></div></div></div>');G!=f&&S!=f&&punchgs.TweenLite.set(d.find(".slot").last(),{rotationZ:S});if(s(8)){d.find(".slot ").last().find(".slotslide").append('<img class="ieeightfallbackimage" src="'+la+'" style="width:100%;height:auto;">');
ta(d,a)}}}},ka=function(d,a){var h=d.find(".defaultimg"),u=d.data("zoomstart"),D=d.data("rotationstart");if(h.data("currotate")!=f)D=h.data("currotate");if(h.data("curscale")!=f)u=h.data("curscale")*100;F(h,a);var G=h.data("src"),S=h.css("backgroundColor"),R=a.width,H=a.height;if(a.autoHeight=="on")H=a.container.height();var ea=h.data("fxof");if(ea==f)ea=0;fullyoff=0;if(s(8)){var U=G;G=""}var o=0;o=a.sloth>a.slotw?a.sloth:a.slotw;a.slotw=o;a.sloth=o;var ga=0,ua=0,Fa=h.data("bgfit"),la=h.data("bgrepeat");
h=h.data("bgposition");if(Fa==f)Fa="cover";if(la==f)la="no-repeat";if(h==f)h="center center";if(d.data("kenburns")=="on"){Fa=u;if(Fa.toString().length<4)Fa=z(Fa,d,a)}for(var oa=0;oa<a.slots;oa++){for(var X=ua=0;X<a.slots;X++){d.append('<div class="slot" style="position:absolute;top:'+(fullyoff+ua)+"px;left:"+(ea+ga)+"px;width:"+o+"px;height:"+o+'px;overflow:hidden;"><div class="slotslide" data-x="'+ga+'" data-y="'+ua+'" style="position:absolute;top:0px;left:0px;width:'+o+"px;height:"+o+'px;overflow:hidden;"><div style="position:absolute;top:'+
(0-ua)+"px;left:"+(0-ga)+"px;width:"+R+"px;height:"+H+"px;background-color:"+S+";background-image:url("+G+");background-repeat:"+la+";background-size:"+Fa+";background-position:"+h+';"></div></div></div>');ua+=o;if(s(8)){d.find(".slot ").last().find(".slotslide").append('<img src="'+U+'">');ta(d,a)}u!=f&&D!=f&&punchgs.TweenLite.set(d.find(".slot").last(),{rotationZ:D})}ga+=o}},ta=function(d,a){if(s(8)){var h=d.find(".ieeightfallbackimage");h.width();h.height();a.startwidth/a.startheight<d.data("owidth")/
d.data("oheight")?h.css({width:"auto",height:"100%"}):h.css({width:"100%",height:"auto"});setTimeout(function(){var u=h.width(),D=h.height();d.data("bgposition")=="center center"&&h.css({position:"absolute",top:a.height/2-D/2+"px",left:a.width/2-u/2+"px"});if(d.data("bgposition")=="center top"||d.data("bgposition")=="top center")h.css({position:"absolute",top:"0px",left:a.width/2-u/2+"px"});if(d.data("bgposition")=="center bottom"||d.data("bgposition")=="bottom center")h.css({position:"absolute",
bottom:"0px",left:a.width/2-u/2+"px"});if(d.data("bgposition")=="right top"||d.data("bgposition")=="top right")h.css({position:"absolute",top:"0px",right:"0px"});if(d.data("bgposition")=="right bottom"||d.data("bgposition")=="bottom right")h.css({position:"absolute",bottom:"0px",right:"0px"});if(d.data("bgposition")=="right center"||d.data("bgposition")=="center right")h.css({position:"absolute",top:a.height/2-D/2+"px",right:"0px"});if(d.data("bgposition")=="left bottom"||d.data("bgposition")=="bottom left")h.css({position:"absolute",
bottom:"0px",left:"0px"});if(d.data("bgposition")=="left center"||d.data("bgposition")=="center left")h.css({position:"absolute",top:a.height/2-D/2+"px",left:"0px"})},20)}},Ka=function(d,a,h){h.find(".slot").each(function(){b(this).remove()});a.transition=0},sa=function(d,a){d.find("img, .defaultimg").each(function(){var h=b(this);if(h.data("lazyload")!=h.attr("src")&&a<3&&h.data("lazyload")!=f&&h.data("lazyload")!="undefined"){if(h.data("lazyload")!=f&&h.data("lazyload")!="undefined"){h.attr("src",
h.data("lazyload"));var u=new Image;u.onload=function(){h.data("lazydone",1);h.hasClass("defaultimg")&&qa(h,u)};u.error=function(){h.data("lazydone",1)};u.src=h.attr("src");if(u.complete){h.hasClass("defaultimg")&&qa(h,u);h.data("lazydone",1)}}}else if((h.data("lazyload")===f||h.data("lazyload")==="undefined")&&h.data("lazydone")!=1){u=new Image;u.onload=function(){h.hasClass("defaultimg")&&qa(h,u);h.data("lazydone",1)};u.error=function(){h.data("lazydone",1)};u.src=h.attr("src")!=f&&h.attr("src")!=
"undefined"?h.attr("src"):h.data("src");if(u.complete){h.hasClass("defaultimg")&&qa(h,u);h.data("lazydone",1)}}})},qa=function(d,a){var h=d.closest("li"),u=a.width,D=a.height;h.data("owidth",u);h.data("oheight",D);h.find(".slotholder").data("owidth",u);h.find(".slotholder").data("oheight",D);h.data("loadeddone",1)},Oa=function(d,a,h){sa(d,0);var u=setInterval(function(){h.bannertimeronpause=true;h.container.trigger("stoptimer");var D=h.cd=0;d.find("img, .defaultimg").each(function(){b(this).data("lazydone")!=
1&&D++});if(D>0)sa(d,D);else{clearInterval(u);a!=f&&a()}},100)},Aa=function(d,a){try{d.find(">ul:first-child >li:eq("+a.act+")")}catch(h){d.find(">ul:first-child >li:eq(1)")}a.lastslide=a.act;var u=d.find(">ul:first-child >li:eq("+a.next+")"),D=u.find(".defaultimg");a.bannertimeronpause=true;d.trigger("stoptimer");a.cd=0;if(D.data("lazyload")!=f&&D.data("lazyload")!="undefined"&&D.data("lazydone")!=1){s(8)?D.attr("src",u.find(".defaultimg").data("lazyload")):D.css({backgroundImage:'url("'+u.find(".defaultimg").data("lazyload")+
'")'});D.data("src",u.find(".defaultimg").data("lazyload"));D.data("lazydone",1);D.data("orgw",0);u.data("loadeddone",1);d.find(".tp-loader").css({display:"block"});Oa(d.find(".tp-static-layers"),function(){Oa(u,function(){var G=u.find(".slotholder");if(G.data("kenburns")=="on")var S=setInterval(function(){if(G.data("owidth")>=0){clearInterval(S);Sa(a,D,d)}},10);else Sa(a,D,d)},a)},a)}else if(u.data("loadeddone")===f){u.data("loadeddone",1);Oa(u,function(){Sa(a,D,d)},a)}else Sa(a,D,d)},Sa=function(d,
a,h){d.bannertimeronpause=false;d.cd=0;h.trigger("nulltimer");h.find(".tp-loader").css({display:"none"});F(a,d);x(h,d);F(a,d);Ia(h,d)},Ia=function(d,a){d.trigger("revolution.slide.onbeforeswap");a.transition=1;a.videoplaying=false;try{var h=d.find(">ul:first-child >li:eq("+a.act+")")}catch(u){h=d.find(">ul:first-child >li:eq(1)")}a.lastslide=a.act;var D=d.find(">ul:first-child >li:eq("+a.next+")");setTimeout(function(){m(a)},200);var G=h.find(".slotholder"),S=D.find(".slotholder");if(S.data("kenburns")==
"on"||G.data("kenburns")=="on"){aa(d,a);d.find(".kenburnimg").remove()}if(D.data("delay")!=f){a.cd=0;a.delay=D.data("delay")}else a.delay=a.origcd;a.firststart==1&&punchgs.TweenLite.set(h,{autoAlpha:0});punchgs.TweenLite.set(h,{zIndex:18});punchgs.TweenLite.set(D,{autoAlpha:0,zIndex:20});var R=0;if(h.index()!=D.index()&&a.firststart!=1)R=va(h,a);if(h.data("saveperformance")!="on")R=0;setTimeout(function(){d.trigger("restarttimer");La(d,a,D,h,G,S)},R)},La=function(d,a,h,u,D,G){function S(){b.each(ga,
function(E,M){if(M[0]==U||M[8]==U){R=M[1];o=M[2];ua=Fa}Fa+=1})}if(h.data("differentissplayed")=="prepared"){h.data("differentissplayed","done");h.data("transition",h.data("savedtransition"));h.data("slotamount",h.data("savedslotamount"));h.data("masterspeed",h.data("savedmasterspeed"))}if(h.data("fstransition")!=f&&h.data("differentissplayed")!="done"){h.data("savedtransition",h.data("transition"));h.data("savedslotamount",h.data("slotamount"));h.data("savedmasterspeed",h.data("masterspeed"));h.data("transition",
h.data("fstransition"));h.data("slotamount",h.data("fsslotamount"));h.data("masterspeed",h.data("fsmasterspeed"));h.data("differentissplayed","prepared")}d.find(".active-revslide").removeClass(".active-revslide");h.addClass("active-revslide");h.data("transition")==f&&h.data("transition","random");var R=0,H=h.data("transition").split(","),ea=h.data("nexttransid")==f?-1:h.data("nexttransid");if(h.data("randomtransition")=="on")ea=Math.round(Math.random()*H.length);else ea+=1;if(ea==H.length)ea=0;h.data("nexttransid",
ea);var U=H[ea];if(a.ie){if(U=="boxfade")U="boxslide";if(U=="slotfade-vertical")U="slotzoom-vertical";if(U=="slotfade-horizontal")U="slotzoom-horizontal"}if(s(8))U=11;var o=0;if(a.parallax=="scroll"&&a.parallaxFirstGo==f){a.parallaxFirstGo=true;ba(d,a);setTimeout(function(){ba(d,a)},210);setTimeout(function(){ba(d,a)},420)}if(U=="boxslide"||U=="boxfade"||U=="papercut"||U==0||U==1||U==16)U=9;if(U=="slidehorizontal"){U="slideleft";if(a.leftarrowpressed==1)U="slideright"}if(U=="slidevertical"){U="slideup";
if(a.leftarrowpressed==1)U="slidedown"}if(U=="parallaxhorizontal"){U="parallaxtoleft";if(a.leftarrowpressed==1)U="parallaxtoright"}if(U=="parallaxvertical"){U="parallaxtotop";if(a.leftarrowpressed==1)U="parallaxtobottom"}var ga=[["boxslide",0,1,10,0,"box",false,null,0],["boxfade",1,0,10,0,"box",false,null,1],["slotslide-horizontal",2,0,0,200,"horizontal",true,false,2],["slotslide-vertical",3,0,0,200,"vertical",true,false,3],["curtain-1",4,3,0,0,"horizontal",true,true,4],["curtain-2",5,3,0,0,"horizontal",
true,true,5],["curtain-3",6,3,25,0,"horizontal",true,true,6],["slotzoom-horizontal",7,0,0,400,"horizontal",true,true,7],["slotzoom-vertical",8,0,0,0,"vertical",true,true,8],["slotfade-horizontal",9,0,0,500,"horizontal",true,null,9],["slotfade-vertical",10,0,0,500,"vertical",true,null,10],["fade",11,0,1,300,"horizontal",true,null,11],["slideleft",12,0,1,0,"horizontal",true,true,12],["slideup",13,0,1,0,"horizontal",true,true,13],["slidedown",14,0,1,0,"horizontal",true,true,14],["slideright",15,0,1,
0,"horizontal",true,true,15],["papercut",16,0,0,600,"",null,null,16],["3dcurtain-horizontal",17,0,20,100,"vertical",false,true,17],["3dcurtain-vertical",18,0,10,100,"horizontal",false,true,18],["cubic",19,0,20,600,"horizontal",false,true,19],["cube",19,0,20,600,"horizontal",false,true,20],["flyin",20,0,4,600,"vertical",false,true,21],["turnoff",21,0,1,1600,"horizontal",false,true,22],["incube",22,0,20,200,"horizontal",false,true,23],["cubic-horizontal",23,0,20,500,"vertical",false,true,24],["cube-horizontal",
23,0,20,500,"vertical",false,true,25],["incube-horizontal",24,0,20,500,"vertical",false,true,26],["turnoff-vertical",25,0,1,200,"horizontal",false,true,27],["fadefromright",12,1,1,0,"horizontal",true,true,28],["fadefromleft",15,1,1,0,"horizontal",true,true,29],["fadefromtop",14,1,1,0,"horizontal",true,true,30],["fadefrombottom",13,1,1,0,"horizontal",true,true,31],["fadetoleftfadefromright",12,2,1,0,"horizontal",true,true,32],["fadetorightfadetoleft",15,2,1,0,"horizontal",true,true,33],["fadetobottomfadefromtop",
14,2,1,0,"horizontal",true,true,34],["fadetotopfadefrombottom",13,2,1,0,"horizontal",true,true,35],["parallaxtoright",12,3,1,0,"horizontal",true,true,36],["parallaxtoleft",15,3,1,0,"horizontal",true,true,37],["parallaxtotop",14,3,1,0,"horizontal",true,true,38],["parallaxtobottom",13,3,1,0,"horizontal",true,true,39],["scaledownfromright",12,4,1,0,"horizontal",true,true,40],["scaledownfromleft",15,4,1,0,"horizontal",true,true,41],["scaledownfromtop",14,4,1,0,"horizontal",true,true,42],["scaledownfrombottom",
13,4,1,0,"horizontal",true,true,43],["zoomout",13,5,1,0,"horizontal",true,true,44],["zoomin",13,6,1,0,"horizontal",true,true,45],["notransition",26,0,1,0,"horizontal",true,null,46]];H=[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45];ea=[16,17,18,19,20,21,22,23,24,25,26,27];R=0;o=1;var ua=0,Fa=0,la=[];if(G.data("kenburns")=="on"){if(U=="boxslide"||U==0||U=="boxfade"||U==1||U=="papercut"||U==16)U=11;C(d,a,true,true)}if(U=="random"){U=Math.round(Math.random()*
ga.length-1);if(U>ga.length-1)U=ga.length-1}if(U=="random-static"){U=Math.round(Math.random()*H.length-1);if(U>H.length-1)U=H.length-1;U=H[U]}if(U=="random-premium"){U=Math.round(Math.random()*ea.length-1);if(U>ea.length-1)U=ea.length-1;U=ea[U]}la=[12,13,14,15,16,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45];if(a.isJoomla==true&&window.MooTools!=f&&la.indexOf(U)!=-1){la=Math.round(Math.random()*(ea.length-2))+1;if(la>ea.length-1)la=ea.length-1;if(la==0)la=1;U=ea[la]}S();if(s(8)&&R>15&&R<
28){U=Math.round(Math.random()*H.length-1);if(U>H.length-1)U=H.length-1;U=H[U];Fa=0;S()}var oa=-1;if(a.leftarrowpressed==1||a.act>a.next)oa=1;a.leftarrowpressed=0;if(R>26)R=26;if(R<0)R=0;var X=300;if(h.data("masterspeed")!=f&&h.data("masterspeed")>99&&h.data("masterspeed")<4001)X=h.data("masterspeed");la=ga[ua];d.parent().find(".bullet").each(function(){var E=b(this);E.removeClass("selected");if(a.navigationArrows=="withbullet"||a.navigationArrows=="nexttobullets")E.index()-1==a.next&&E.addClass("selected");
else E.index()==a.next&&E.addClass("selected")});var da=new punchgs.TimelineLite({onComplete:function(){Q(d,a,G,D,h,u,da)}});da.add(punchgs.TweenLite.set(G.find(".defaultimg"),{opacity:0}));da.pause();if(h.data("slotamount")==f||h.data("slotamount")<1){a.slots=Math.round(Math.random()*12+4);if(U=="boxslide")a.slots=Math.round(Math.random()*6+3);else if(U=="flyin")a.slots=Math.round(Math.random()*4+1)}else a.slots=h.data("slotamount");a.rotate=h.data("rotate")==f?0:h.data("rotate")==999?Math.round(Math.random()*
360):h.data("rotate");if(!b.support.transition||a.ie||a.ie9)a.rotate=0;if(a.firststart==1)a.firststart=0;X+=la[4];if((R==4||R==5||R==6)&&a.slots<3)a.slots=3;if(la[3]!=0)a.slots=Math.min(a.slots,la[3]);if(R==9)a.slots=a.width/20;if(R==10)a.slots=a.height/20;if(la[5]=="box"){la[7]!=null&&ka(D,a,la[7]);la[6]!=null&&ka(G,a,la[6])}else if(la[5]=="vertical"||la[5]=="horizontal"){la[7]!=null&&ha(D,a,la[7],la[5]);la[6]!=null&&ha(G,a,la[6],la[5])}if(R==0){var Ca=Math.ceil(a.height/a.sloth),Ha=0;G.find(".slotslide").each(function(E){var M=
b(this);Ha+=1;if(Ha==Ca)Ha=0;da.add(punchgs.TweenLite.from(M,X/600,{opacity:0,top:0-a.sloth,left:0-a.slotw,rotation:a.rotate,force3D:"auto",ease:punchgs.Power2.easeOut}),(E*15+Ha*30)/1500)})}if(R==1){var Xa;G.find(".slotslide").each(function(){var E=b(this);rand=Math.random()*X+300;rand2=Math.random()*500+200;if(rand+rand2>Xa)Xa=rand2+rand2;da.add(punchgs.TweenLite.from(E,rand/1E3,{autoAlpha:0,force3D:"auto",rotation:a.rotate,ease:punchgs.Power2.easeInOut}),rand2/1E3)})}if(R==2){var Ba=new punchgs.TimelineLite;
D.find(".slotslide").each(function(){var E=b(this);Ba.add(punchgs.TweenLite.to(E,X/1E3,{left:a.slotw,force3D:"auto",rotation:0-a.rotate}),0);da.add(Ba,0)});G.find(".slotslide").each(function(){var E=b(this);Ba.add(punchgs.TweenLite.from(E,X/1E3,{left:0-a.slotw,force3D:"auto",rotation:a.rotate}),0);da.add(Ba,0)})}if(R==3){Ba=new punchgs.TimelineLite;D.find(".slotslide").each(function(){var E=b(this);Ba.add(punchgs.TweenLite.to(E,X/1E3,{top:a.sloth,rotation:a.rotate,force3D:"auto",transformPerspective:600}),
0);da.add(Ba,0)});G.find(".slotslide").each(function(){var E=b(this);Ba.add(punchgs.TweenLite.from(E,X/1E3,{top:0-a.sloth,rotation:a.rotate,ease:punchgs.Power2.easeOut,force3D:"auto",transformPerspective:600}),0);da.add(Ba,0)})}if(R==4||R==5){setTimeout(function(){D.find(".defaultimg").css({opacity:0})},100);var cb=X/1E3;Ba=new punchgs.TimelineLite;D.find(".slotslide").each(function(E){var M=b(this),Y=E*cb/a.slots;if(R==5)Y=(a.slots-E-1)*cb/a.slots/1.5;Ba.add(punchgs.TweenLite.to(M,cb*3,{transformPerspective:600,
force3D:"auto",top:0+a.height,opacity:0.5,rotation:a.rotate,ease:punchgs.Power2.easeInOut,delay:Y}),0);da.add(Ba,0)});G.find(".slotslide").each(function(E){var M=b(this),Y=E*cb/a.slots;if(R==5)Y=(a.slots-E-1)*cb/a.slots/1.5;Ba.add(punchgs.TweenLite.from(M,cb*3,{top:0-a.height,opacity:0.5,rotation:a.rotate,force3D:"auto",ease:punchgs.Power2.easeInOut,delay:Y}),0);da.add(Ba,0)})}if(R==6){if(a.slots<2)a.slots=2;if(a.slots%2)a.slots+=1;Ba=new punchgs.TimelineLite;setTimeout(function(){D.find(".defaultimg").css({opacity:0})},
100);D.find(".slotslide").each(function(E){var M=b(this);Ba.add(punchgs.TweenLite.to(M,(X+(E+1<a.slots/2?(E+2)*90:(2+a.slots-E)*90))/1E3,{top:0+a.height,opacity:1,force3D:"auto",rotation:a.rotate,ease:punchgs.Power2.easeInOut}),0);da.add(Ba,0)});G.find(".slotslide").each(function(E){var M=b(this);Ba.add(punchgs.TweenLite.from(M,(X+(E+1<a.slots/2?(E+2)*90:(2+a.slots-E)*90))/1E3,{top:0-a.height,opacity:1,force3D:"auto",rotation:a.rotate,ease:punchgs.Power2.easeInOut}),0);da.add(Ba,0)})}if(R==7){X*=
2;Ba=new punchgs.TimelineLite;setTimeout(function(){D.find(".defaultimg").css({opacity:0})},100);D.find(".slotslide").each(function(){var E=b(this).find("div");Ba.add(punchgs.TweenLite.to(E,X/1E3,{left:0-a.slotw/2+"px",top:0-a.height/2+"px",width:a.slotw*2+"px",height:a.height*2+"px",opacity:0,rotation:a.rotate,force3D:"auto",ease:punchgs.Power2.easeOut}),0);da.add(Ba,0)});G.find(".slotslide").each(function(E){var M=b(this).find("div");Ba.add(punchgs.TweenLite.fromTo(M,X/1E3,{left:0,top:0,opacity:0,
transformPerspective:600},{left:0-E*a.slotw+"px",ease:punchgs.Power2.easeOut,force3D:"auto",top:"0px",width:a.width,height:a.height,opacity:1,rotation:0,delay:0.1}),0);da.add(Ba,0)})}if(R==8){X*=3;Ba=new punchgs.TimelineLite;D.find(".slotslide").each(function(){var E=b(this).find("div");Ba.add(punchgs.TweenLite.to(E,X/1E3,{left:0-a.width/2+"px",top:0-a.sloth/2+"px",width:a.width*2+"px",height:a.sloth*2+"px",force3D:"auto",opacity:0,rotation:a.rotate}),0);da.add(Ba,0)});G.find(".slotslide").each(function(E){var M=
b(this).find("div");Ba.add(punchgs.TweenLite.fromTo(M,X/1E3,{left:0,top:0,opacity:0,force3D:"auto"},{left:"0px",top:0-E*a.sloth+"px",width:G.find(".defaultimg").data("neww")+"px",height:G.find(".defaultimg").data("newh")+"px",opacity:1,rotation:0}),0);da.add(Ba,0)})}if(R==9||R==10){var ab=0;G.find(".slotslide").each(function(E){var M=b(this);ab++;da.add(punchgs.TweenLite.fromTo(M,X/1E3,{autoAlpha:0,force3D:"auto",transformPerspective:600},{autoAlpha:1,ease:punchgs.Power2.easeInOut,delay:E*5/1E3}),
0)})}if(R==11||R==26){ab=0;if(R==26)X=0;G.find(".slotslide").each(function(){var E=b(this);da.add(punchgs.TweenLite.from(E,X/1E3,{autoAlpha:0,force3D:"auto",ease:punchgs.Power2.easeInOut}),0)})}if(R==12||R==13||R==14||R==15){X=1E3;setTimeout(function(){punchgs.TweenLite.set(D.find(".defaultimg"),{autoAlpha:0})},100);H=a.width;ea=a.height;var wa=G.find(".slotslide");if(a.fullWidth=="on"||a.fullScreen=="on"){H=wa.width();ea=wa.height()}var Ja=0,pa=0;if(R==12)Ja=H;else if(R==15)Ja=0-H;else if(R==13)pa=
ea;else if(R==14)pa=0-ea;var T=1,ia=la=1,l=punchgs.Power2.easeInOut,q=punchgs.Power2.easeInOut,v=X/1E3,y=v;if(o==1)T=0;if(o==2)T=0;if(o==3){l=punchgs.Power2.easeInOut;q=punchgs.Power1.easeInOut;v=X/1200}if(o==4||o==5)la=0.6;if(o==6)la=1.4;if(o==5||o==6){ia=1.4;pa=Ja=ea=H=T=0}if(o==6)ia=0.6;da.add(punchgs.TweenLite.from(wa,v,{left:Ja,top:pa,scale:ia,opacity:T,rotation:a.rotate,ease:q,force3D:"auto"}),0);wa=D.find(".slotslide");if(o==4||o==5)ea=H=0;if(o!=1)if(R==12)da.add(punchgs.TweenLite.to(wa,y,
{left:0-H+"px",force3D:"auto",scale:la,opacity:T,rotation:a.rotate,ease:l}),0);else if(R==15)da.add(punchgs.TweenLite.to(wa,y,{left:H+"px",force3D:"auto",scale:la,opacity:T,rotation:a.rotate,ease:l}),0);else if(R==13)da.add(punchgs.TweenLite.to(wa,y,{top:0-ea+"px",force3D:"auto",scale:la,opacity:T,rotation:a.rotate,ease:l}),0);else R==14&&da.add(punchgs.TweenLite.to(wa,y,{top:ea+"px",force3D:"auto",scale:la,opacity:T,rotation:a.rotate,ease:l}),0)}if(R==16){Ba=new punchgs.TimelineLite;da.add(punchgs.TweenLite.set(u,
{position:"absolute","z-index":20}),0);da.add(punchgs.TweenLite.set(h,{position:"absolute","z-index":15}),0);u.wrapInner('<div class="tp-half-one" style="position:relative; width:100%;height:100%"></div>');u.find(".tp-half-one").clone(true).appendTo(u).addClass("tp-half-two");u.find(".tp-half-two").removeClass("tp-half-one");H=a.width;ea=a.height;if(a.autoHeight=="on")ea=d.height();u.find(".tp-half-one .defaultimg").wrap('<div class="tp-papercut" style="width:'+H+"px;height:"+ea+'px;"></div>');u.find(".tp-half-two .defaultimg").wrap('<div class="tp-papercut" style="width:'+
H+"px;height:"+ea+'px;"></div>');u.find(".tp-half-two .defaultimg").css({position:"absolute",top:"-50%"});u.find(".tp-half-two .tp-caption").wrapAll('<div style="position:absolute;top:-50%;left:0px;"></div>');da.add(punchgs.TweenLite.set(u.find(".tp-half-two"),{width:H,height:ea,overflow:"hidden",zIndex:15,position:"absolute",top:ea/2,left:"0px",transformPerspective:600,transformOrigin:"center bottom"}),0);da.add(punchgs.TweenLite.set(u.find(".tp-half-one"),{width:H,height:ea/2,overflow:"visible",
zIndex:10,position:"absolute",top:"0px",left:"0px",transformPerspective:600,transformOrigin:"center top"}),0);u.find(".defaultimg");la=Math.round(Math.random()*20-10);l=Math.round(Math.random()*20-10);y=Math.round(Math.random()*20-10);wa=Math.random()*0.4-0.2;Ja=Math.random()*0.4-0.2;pa=Math.random()*1+1;ia=Math.random()*1+1;q=Math.random()*0.3+0.3;da.add(punchgs.TweenLite.set(u.find(".tp-half-one"),{overflow:"hidden"}),0);da.add(punchgs.TweenLite.fromTo(u.find(".tp-half-one"),X/800,{width:H,height:ea/
2,position:"absolute",top:"0px",left:"0px",force3D:"auto",transformOrigin:"center top"},{scale:pa,rotation:la,y:0-ea-ea/4,autoAlpha:0,ease:punchgs.Power2.easeInOut}),0);da.add(punchgs.TweenLite.fromTo(u.find(".tp-half-two"),X/800,{width:H,height:ea,overflow:"hidden",position:"absolute",top:ea/2,left:"0px",force3D:"auto",transformOrigin:"center bottom"},{scale:ia,rotation:l,y:ea+ea/4,ease:punchgs.Power2.easeInOut,autoAlpha:0,onComplete:function(){punchgs.TweenLite.set(u,{position:"absolute","z-index":15});
punchgs.TweenLite.set(h,{position:"absolute","z-index":20});if(u.find(".tp-half-one").length>0){u.find(".tp-half-one .defaultimg").unwrap();u.find(".tp-half-one .slotholder").unwrap()}u.find(".tp-half-two").remove()}}),0);Ba.add(punchgs.TweenLite.set(G.find(".defaultimg"),{autoAlpha:1}),0);u.html()!=null&&da.add(punchgs.TweenLite.fromTo(h,(X-200)/1E3,{scale:q,x:a.width/4*wa,y:ea/4*Ja,rotation:y,force3D:"auto",transformOrigin:"center center",ease:punchgs.Power2.easeOut},{autoAlpha:1,scale:1,x:0,y:0,
rotation:0}),0);da.add(Ba,0)}R==17&&G.find(".slotslide").each(function(E){var M=b(this);da.add(punchgs.TweenLite.fromTo(M,X/800,{opacity:0,rotationY:0,scale:0.9,rotationX:-110,force3D:"auto",transformPerspective:600,transformOrigin:"center center"},{opacity:1,top:0,left:0,scale:1,rotation:0,rotationX:0,force3D:"auto",rotationY:0,ease:punchgs.Power3.easeOut,delay:E*0.06}),0)});R==18&&G.find(".slotslide").each(function(E){var M=b(this);da.add(punchgs.TweenLite.fromTo(M,X/500,{autoAlpha:0,rotationY:310,
scale:0.9,rotationX:10,force3D:"auto",transformPerspective:600,transformOrigin:"center center"},{autoAlpha:1,top:0,left:0,scale:1,rotation:0,rotationX:0,force3D:"auto",rotationY:0,ease:punchgs.Power3.easeOut,delay:E*0.06}),0)});if(R==19||R==22){Ba=new punchgs.TimelineLite;da.add(punchgs.TweenLite.set(u,{zIndex:20}),0);da.add(punchgs.TweenLite.set(h,{zIndex:20}),0);setTimeout(function(){D.find(".defaultimg").css({opacity:0})},100);h.css("z-index");u.css("z-index");var t=90;T=1;if(oa==1)t=-90;if(R==
19){var B="center center -"+a.height/2;T=0}else B="center center "+a.height/2;punchgs.TweenLite.set(d,{transformStyle:"flat",backfaceVisibility:"hidden",transformPerspective:600});G.find(".slotslide").each(function(E){var M=b(this);Ba.add(punchgs.TweenLite.fromTo(M,X/1E3,{transformStyle:"flat",backfaceVisibility:"hidden",left:0,rotationY:a.rotate,z:10,top:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:B,rotationX:t},{left:0,rotationY:0,top:0,z:0,scale:1,force3D:"auto",rotationX:0,
delay:E*50/1E3,ease:punchgs.Power2.easeInOut}),0);Ba.add(punchgs.TweenLite.to(M,0.1,{autoAlpha:1,delay:E*50/1E3}),0);da.add(Ba)});D.find(".slotslide").each(function(E){var M=b(this),Y=-90;if(oa==1)Y=90;Ba.add(punchgs.TweenLite.fromTo(M,X/1E3,{transformStyle:"flat",backfaceVisibility:"hidden",autoAlpha:1,rotationY:0,top:0,z:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:B,rotationX:0},{autoAlpha:1,rotationY:a.rotate,top:0,z:10,scale:1,rotationX:Y,delay:E*50/1E3,force3D:"auto",ease:punchgs.Power2.easeInOut}),
0);da.add(Ba)})}if(R==20){setTimeout(function(){D.find(".defaultimg").css({opacity:0})},100);h.css("z-index");u.css("z-index");if(oa==1){var A=-a.width;t=70;B="left center -"+a.height/2}else{A=a.width;t=-70;B="right center -"+a.height/2}G.find(".slotslide").each(function(E){var M=b(this);da.add(punchgs.TweenLite.fromTo(M,X/1500,{left:A,rotationX:40,z:-600,opacity:T,top:0,force3D:"auto",transformPerspective:600,transformOrigin:B,rotationY:t},{left:0,delay:E*50/1E3,ease:punchgs.Power2.easeInOut}),0);
da.add(punchgs.TweenLite.fromTo(M,X/1E3,{rotationX:40,z:-600,opacity:T,top:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:B,rotationY:t},{rotationX:0,opacity:1,top:0,z:0,scale:1,rotationY:0,delay:E*50/1E3,ease:punchgs.Power2.easeInOut}),0);da.add(punchgs.TweenLite.to(M,0.1,{opacity:1,force3D:"auto",delay:E*50/1E3+X/2E3}),0)});D.find(".slotslide").each(function(E){var M=b(this);if(oa!=1)var Y=-a.width,$=70,ra="left center -"+a.height/2;else{Y=a.width;$=-70;ra="right center -"+a.height/
2}da.add(punchgs.TweenLite.fromTo(M,X/1E3,{opacity:1,rotationX:0,top:0,z:0,scale:1,left:0,force3D:"auto",transformPerspective:600,transformOrigin:ra,rotationY:0},{opacity:1,rotationX:40,top:0,z:-600,left:Y,force3D:"auto",scale:0.8,rotationY:$,delay:E*50/1E3,ease:punchgs.Power2.easeInOut}),0);da.add(punchgs.TweenLite.to(M,0.1,{force3D:"auto",opacity:0,delay:E*50/1E3+(X/1E3-X/1E4)}),0)})}if(R==21||R==25){setTimeout(function(){D.find(".defaultimg").css({opacity:0})},100);h.css("z-index");u.css("z-index");
if(oa==1){A=-a.width;t=90;if(R==25){B="center top 0";rot2=-t;t=a.rotate}else{B="left center 0";rot2=a.rotate}}else{A=a.width;t=-90;if(R==25){B="center bottom 0";rot2=-t;t=a.rotate}else{B="right center 0";rot2=a.rotate}}G.find(".slotslide").each(function(){var E=b(this);da.add(punchgs.TweenLite.fromTo(E,X/1E3,{left:0,transformStyle:"flat",rotationX:rot2,z:0,autoAlpha:0,top:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:B,rotationY:t},{left:0,rotationX:0,top:0,z:0,autoAlpha:1,scale:1,
rotationY:0,force3D:"auto",ease:punchgs.Power3.easeInOut}),0)});if(oa!=1){A=-a.width;t=90;if(R==25){B="center top 0";rot2=-t;t=a.rotate}else{B="left center 0";rot2=a.rotate}}else{A=a.width;t=-90;if(R==25){B="center bottom 0";rot2=-t;t=a.rotate}else{B="right center 0";rot2=a.rotate}}D.find(".slotslide").each(function(){var E=b(this);da.add(punchgs.TweenLite.fromTo(E,X/1E3,{left:0,transformStyle:"flat",rotationX:0,z:0,autoAlpha:1,top:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:B,
rotationY:0},{left:0,rotationX:rot2,top:0,z:0,autoAlpha:1,force3D:"auto",scale:1,rotationY:t,ease:punchgs.Power1.easeInOut}),0)})}if(R==23||R==24){setTimeout(function(){D.find(".defaultimg").css({opacity:0})},100);h.css("z-index");u.css("z-index");t=-90;if(oa==1)t=90;T=1;if(R==23){B="center center -"+a.width/2;T=0}else B="center center "+a.width/2;punchgs.TweenLite.set(d,{transformStyle:"preserve-3d",backfaceVisibility:"hidden",perspective:2500});G.find(".slotslide").each(function(E){var M=b(this);
da.add(punchgs.TweenLite.fromTo(M,X/1E3,{left:0,rotationX:a.rotate,force3D:"auto",opacity:T,top:0,scale:1,transformPerspective:600,transformOrigin:B,rotationY:t},{left:0,rotationX:0,autoAlpha:1,top:0,z:0,scale:1,rotationY:0,delay:E*50/500,ease:punchgs.Power2.easeInOut}),0)});t=90;if(oa==1)t=-90;D.find(".slotslide").each(function(E){var M=b(this);da.add(punchgs.TweenLite.fromTo(M,X/1E3,{left:0,autoAlpha:1,rotationX:0,top:0,z:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:B,rotationY:0},
{left:0,autoAlpha:1,rotationX:a.rotate,top:0,scale:1,rotationY:t,delay:E*50/500,ease:punchgs.Power2.easeInOut}),0)})}da.pause();fa(h,a,null,da);punchgs.TweenLite.to(h,0.0010,{autoAlpha:1});H={};H.slideIndex=a.next+1;H.slide=h;d.trigger("revolution.slide.onchange",H);setTimeout(function(){d.trigger("revolution.slide.onafterswap")},X);d.trigger("revolution.slide.onvideostop")},Q=function(d,a,h,u,D,G,S){punchgs.TweenLite.to(h.find(".defaultimg"),0.0010,{autoAlpha:1,onComplete:function(){Ka(d,a,D)}});
D.index()!=G.index()&&punchgs.TweenLite.to(G,0.2,{autoAlpha:0,onComplete:function(){Ka(d,a,G)}});a.act=a.next;a.navigationType=="thumb"&&Da(d);h.data("kenburns")=="on"&&C(d,a);d.find(".current-sr-slide-visible").removeClass("current-sr-slide-visible");D.addClass("current-sr-slide-visible");if(a.parallax=="scroll"||a.parallax=="scroll+mouse"||a.parallax=="mouse+scroll")ba(d,a);S.clear()},Wa=function(d){var a=d.target.getVideoEmbedCode();a=b("#"+a.split('id="')[1].split('"')[0]);var h=a.closest(".tp-simpleresponsive"),
u=a.parent().data("player");if(d.data==YT.PlayerState.PLAYING){var D=h.find(".tp-bannertimer");D=D.data("opt");a.closest(".tp-caption").data("volume")=="mute"&&u.mute();D.videoplaying=true;h.trigger("stoptimer");h.trigger("revolution.slide.onvideoplay")}else{D=h.find(".tp-bannertimer");D=D.data("opt");if(d.data!=-1&&d.data!=3){D.videoplaying=false;h.trigger("starttimer");h.trigger("revolution.slide.onvideostop")}if(d.data==0&&D.nextslideatend==true)D.container.revnext();else{D.videoplaying=false;
h.trigger("starttimer");h.trigger("revolution.slide.onvideostop")}}},Ra=function(d,a){var h=$f(d),u=b("#"+d),D=u.closest(".tp-simpleresponsive"),G=u.closest(".tp-caption");setTimeout(function(){h.addEvent("ready",function(){a&&h.api("play");h.addEvent("play",function(){D.find(".tp-bannertimer").data("opt").videoplaying=true;D.trigger("stoptimer");G.data("volume")=="mute"&&h.api("setVolume","0")});h.addEvent("finish",function(){var S=D.find(".tp-bannertimer").data("opt");S.videoplaying=false;D.trigger("starttimer");
D.trigger("revolution.slide.onvideoplay");S.nextslideatend==true&&S.container.revnext()});h.addEvent("pause",function(){D.find(".tp-bannertimer").data("opt").videoplaying=false;D.trigger("starttimer");D.trigger("revolution.slide.onvideostop")});G.find(".tp-thumb-image").click(function(){punchgs.TweenLite.to(b(this),0.3,{autoAlpha:0,force3D:"auto",ease:punchgs.Power3.easeInOut});h.api("play")})})},150)},za=function(d,a){var h=a.width(),u=a.height(),D=d.data("mediaAspect");if(D==f)D=1;var G=h/u;d.css({position:"absolute"});
d.find("video");G<D?punchgs.TweenLite.to(d,1.0E-4,{width:u*D,force3D:"auto",top:0,left:0-(u*D-h)/2,height:u}):punchgs.TweenLite.to(d,1.0E-4,{width:h,force3D:"auto",top:0-(h/D-u)/2,left:0,height:h/D})},Na=function(){var d={};d.x=0;d.y=0;d.rotationX=0;d.rotationY=0;d.rotationZ=0;d.scale=1;d.scaleX=1;d.scaleY=1;d.skewX=0;d.skewY=0;d.opacity=0;d.transformOrigin="center, center";d.transformPerspective=400;d.rotation=0;return d},O=function(d,a){var h=a.split(";");b.each(h,function(u,D){D=D.split(":");var G=
D[0],S=D[1];if(G=="rotationX")d.rotationX=parseInt(S,0);if(G=="rotationY")d.rotationY=parseInt(S,0);if(G=="rotationZ")d.rotationZ=parseInt(S,0);if(G=="rotationZ")d.rotation=parseInt(S,0);if(G=="scaleX")d.scaleX=parseFloat(S);if(G=="scaleY")d.scaleY=parseFloat(S);if(G=="opacity")d.opacity=parseFloat(S);if(G=="skewX")d.skewX=parseInt(S,0);if(G=="skewY")d.skewY=parseInt(S,0);if(G=="x")d.x=parseInt(S,0);if(G=="y")d.y=parseInt(S,0);if(G=="z")d.z=parseInt(S,0);if(G=="transformOrigin")d.transformOrigin=
S.toString();if(G=="transformPerspective")d.transformPerspective=parseInt(S,0)});return d},Z=function(d){d=d.split("animation:");var a={};a.animation=O(Na(),d[1]);d=d[0].split(";");b.each(d,function(h,u){u=u.split(":");var D=u[0],G=u[1];if(D=="typ")a.typ=G;if(D=="speed")a.speed=parseInt(G,0)/1E3;if(D=="start")a.start=parseInt(G,0)/1E3;if(D=="elementdelay")a.elementdelay=parseFloat(G);if(D=="ease")a.ease=G});return a},fa=function(d,a,h,u){d.data("ctl")==f&&d.data("ctl",new punchgs.TimelineLite);var D=
d.data("ctl"),G=0,S=0,R=d.find(".tp-caption");d=a.container.find(".tp-static-layers").find(".tp-caption");D.pause();b.each(d,function(H,ea){R.push(ea)});R.each(function(H){var ea=h,U=-1,o=b(this);if(o.hasClass("tp-static-layer")){U=o.data("startslide");var ga=o.data("endslide");if(U==-1||U=="-1")o.data("startslide",0);if(ga==-1||ga=="-1")o.data("endslide",a.slideamount);U==0&&ga==a.slideamount-1&&o.data("endslide",a.slideamount+1);U=o.data("startslide");ga=o.data("endslide");if(o.hasClass("tp-is-shown"))U=
ga==a.next||U>a.next||ga<a.next?2:0;else if(U<=a.next&&ga>=a.next||U==a.next||ga==a.next){o.addClass("tp-is-shown");U=1}else U=0}G=a.width/2-a.startwidth*a.bw/2;var ua=a.bw;if(a.fullScreen=="on")S=a.height/2-a.startheight*a.bh/2;if(a.autoHeight=="on"||a.minHeight!=f&&a.minHeight>0)S=a.container.height()/2-a.startheight*a.bh/2;if(S<0)S=0;ga=0;if(a.width<a.hideCaptionAtLimit&&o.data("captionhidden")=="on"){o.addClass("tp-hidden-caption");ga=1}else if(a.width<a.hideAllCaptionAtLimit||a.width<a.hideAllCaptionAtLilmit){o.addClass("tp-hidden-caption");
ga=1}else o.removeClass("tp-hidden-caption");if(ga==0){if(o.data("linktoslide")!=f&&!o.hasClass("hasclicklistener")){o.addClass("hasclicklistener");o.css({cursor:"pointer"});o.data("linktoslide")!="no"&&o.click(function(){var wa=b(this).data("linktoslide");if(wa!="next"&&wa!="prev"){a.container.data("showus",wa);a.container.parent().find(".tp-rightarrow").click()}else if(wa=="next")a.container.parent().find(".tp-rightarrow").click();else wa=="prev"&&a.container.parent().find(".tp-leftarrow").click()})}if(G<
0)G=0;if(o.hasClass("tp-videolayer")||o.find("iframe").length>0||o.find("video").length>0){var Fa="iframe"+Math.round(Math.random()*1E5+1);ga=o.data("videowidth");H=o.data("videoheight");var la=o.data("videoattributes"),oa=o.data("ytid"),X=o.data("vimeoid"),da=o.data("videpreload"),Ca=o.data("videomp4"),Ha=o.data("videowebm"),Xa=o.data("videocontrols"),Ba="http",cb=o.data("videoloop")=="loop"?"loop":o.data("videoloop")=="loopandnoslidestop"?"loop":"";o.data("thumbimage")!=f&&o.data("videoposter")==
f&&o.data("videoposter",o.data("thumbimage"));if(oa!=f&&String(oa).length>1&&o.find("iframe").length==0){Ba="https";if(Xa=="none"){la=la.replace("controls=1","controls=0");if(la.toLowerCase().indexOf("controls")==-1)la+="&controls=0"}o.append('<iframe style="visible:hidden" src="'+Ba+"://www.youtube.com/embed/"+oa+"?"+la+'" width="'+ga+'" height="'+H+'" style="width:'+ga+"px;height:"+H+'px"></iframe>')}X!=f&&String(X).length>1&&o.find("iframe").length==0&&o.append('<iframe style="visible:hidden" src="'+
Ba+"://player.vimeo.com/video/"+X+"?"+la+'" width="'+ga+'" height="'+H+'" style="width:'+ga+"px;height:"+H+'px"></iframe>');if((Ca!=f||Ha!=f)&&o.find("video").length==0){if(Xa!="controls")Xa="";o.append('<video style="visible:hidden" class="" '+cb+" "+Xa+' preload="'+da+'" width="'+ga+'" height="'+H+'"poster="'+o.data("videoposter")+'"><source src="'+Ca+'" type="video/mp4"" ></source><source src="'+Ha+'" type="video/webm"" ></source></video>')}var ab=false;if(o.data("autoplayonlyfirsttime")==true||o.data("autoplayonlyfirsttime")==
"true"||o.data("autoplay")==true){o.data("autoplay",true);ab=true}o.find("iframe").each(function(){var wa=b(this);punchgs.TweenLite.to(wa,0.1,{autoAlpha:1,zIndex:0,transformStyle:"preserve-3d",z:0,rotationX:0,force3D:"auto"});if(k()){var Ja=wa.attr("src");wa.attr("src","");wa.attr("src",Ja)}a.nextslideatend=o.data("nextslideatend");if(o.data("videoposter")!=f&&o.data("videoposter").length>2&&o.data("autoplay")!=true&&!ea)o.find(".tp-thumb-image").length==0?o.append('<div class="tp-thumb-image" style="cursor:pointer; position:absolute;top:0px;left:0px;width:100%;height:100%;background-image:url('+
o.data("videoposter")+'); background-size:cover"></div>'):punchgs.TweenLite.set(o.find(".tp-thumb-image"),{autoAlpha:1});if(wa.attr("src").toLowerCase().indexOf("youtube")>=0)if(wa.hasClass("HasListener")){pa=o.data("player");o.data("forcerewind")=="on"&&!k()&&pa.seekTo(0);if(!k()&&o.data("autoplay")==true||ab)o.data("timerplay",setTimeout(function(){pa.playVideo()},o.data("start")))}else try{wa.attr("id",Fa);var pa,T=setInterval(function(){if(YT!=f)if(typeof YT.Player!=f&&typeof YT.Player!="undefined")pa=
new YT.Player(Fa,{events:{onStateChange:Wa,onReady:function(E){var M=E.target.getVideoEmbedCode();M=b("#"+M.split('id="')[1].split('"')[0]).closest(".tp-caption");var Y=M.data("videorate");M.data("videostart");Y!=f&&E.target.setPlaybackRate(parseFloat(Y));if(M.data("autoplay")==true||ab)E.target.playVideo();M.find(".tp-thumb-image").click(function(){punchgs.TweenLite.to(b(this),0.3,{autoAlpha:0,force3D:"auto",ease:punchgs.Power3.easeInOut});k()||pa.playVideo()})}}});wa.addClass("HasListener");o.data("player",
pa);clearInterval(T)},100)}catch(ia){}else if(wa.attr("src").toLowerCase().indexOf("vimeo")>=0)if(wa.hasClass("HasListener")){if(!k()&&(o.data("autoplay")==true||o.data("forcerewind")=="on")){wa=o.find("iframe");Ja=wa.attr("id");var l=$f(Ja);o.data("forcerewind")=="on"&&l.api("seekTo",0);o.data("timerplay",setTimeout(function(){o.data("autoplay")==true&&l.api("play")},o.data("start")))}}else{wa.addClass("HasListener");wa.attr("id",Fa);Ja=wa.attr("src");for(var q={},v=Ja,y=/([^&=]+)=([^&]*)/g,t;t=
y.exec(v);)q[decodeURIComponent(t[1])]=decodeURIComponent(t[2]);Ja=q.player_id!=f?Ja.replace(q.player_id,Fa):Ja+"&player_id="+Fa;try{Ja=Ja.replace("api=0","api=1")}catch(B){}Ja+="&api=1";wa.attr("src",Ja);pa=o.find("iframe")[0];var A=setInterval(function(){if($f!=f)if(typeof $f(Fa).api!=f&&typeof $f(Fa).api!="undefined"){$f(pa).addEvent("ready",function(){Ra(Fa,ab)});clearInterval(A)}},100)}});k()&&o.data("disablevideoonmobile")==1&&o.find("video").remove();k()&&b(window).width()<569&&o.find("video").remove();
o.find("video").length>0&&o.find("video").each(function(){var wa=this,Ja=b(this);Ja.parent().hasClass("html5vid")||Ja.wrap('<div class="html5vid" style="position:relative;top:0px;left:0px;width:auto;height:auto"></div>');var pa=Ja.parent();wa.addEventListener?wa.addEventListener("loadedmetadata",function(){pa.data("metaloaded",1)}):wa.attachEvent("loadedmetadata",function(){pa.data("metaloaded",1)});clearInterval(pa.data("interval"));pa.data("interval",setInterval(function(){if(pa.data("metaloaded")==
1||wa.duration!=NaN){clearInterval(pa.data("interval"));if(!pa.hasClass("HasListener")){pa.addClass("HasListener");o.data("dottedoverlay")!="none"&&o.data("dottedoverlay")!=f&&o.find(".tp-dottedoverlay").length!=1&&pa.append('<div class="tp-dottedoverlay '+o.data("dottedoverlay")+'"></div>');if(Ja.attr("control")==f){pa.find(".tp-video-play-button").length==0&&pa.append('<div class="tp-video-play-button"><i class="revicon-right-dir"></i><div class="tp-revstop"></div></div>');pa.find("video, .tp-poster, .tp-video-play-button").click(function(){pa.hasClass("videoisplaying")?
wa.pause():wa.play()})}if(o.data("forcecover")==1||o.hasClass("fullscreenvideo")){if(o.data("forcecover")==1){za(pa,a.container);pa.addClass("fullcoveredvideo");o.addClass("fullcoveredvideo")}pa.css({width:"100%",height:"100%"})}wa.addEventListener?wa.addEventListener("play",function(){if(o.data("volume")=="mute")wa.muted=true;pa.addClass("videoisplaying");if(o.data("videoloop")=="loopandnoslidestop"){a.videoplaying=false;a.container.trigger("starttimer");a.container.trigger("revolution.slide.onvideostop")}else{a.videoplaying=
true;a.container.trigger("stoptimer");a.container.trigger("revolution.slide.onvideoplay")}}):wa.attachEvent("play",function(){if(o.data("volume")=="mute")wa.muted=true;pa.addClass("videoisplaying");if(o.data("videoloop")=="loopandnoslidestop"){a.videoplaying=false;a.container.trigger("starttimer");a.container.trigger("revolution.slide.onvideostop")}else{a.videoplaying=true;a.container.trigger("stoptimer");a.container.trigger("revolution.slide.onvideoplay")}});wa.addEventListener?wa.addEventListener("pause",
function(){pa.removeClass("videoisplaying");a.videoplaying=false;a.container.trigger("starttimer");a.container.trigger("revolution.slide.onvideostop")}):wa.attachEvent("pause",function(){pa.removeClass("videoisplaying");a.videoplaying=false;a.container.trigger("starttimer");a.container.trigger("revolution.slide.onvideostop")});wa.addEventListener?wa.addEventListener("ended",function(){pa.removeClass("videoisplaying");a.videoplaying=false;a.container.trigger("starttimer");a.container.trigger("revolution.slide.onvideostop");
a.nextslideatend==true&&a.container.revnext()}):wa.attachEvent("ended",function(){pa.removeClass("videoisplaying");a.videoplaying=false;a.container.trigger("starttimer");a.container.trigger("revolution.slide.onvideostop");a.nextslideatend==true&&a.container.revnext()})}var T=false;if(o.data("autoplayonlyfirsttime")==true||o.data("autoplayonlyfirsttime")=="true")T=true;var ia=16/9;if(o.data("aspectratio")=="4:3")ia=4/3;pa.data("mediaAspect",ia);if(pa.closest(".tp-caption").data("forcecover")==1){za(pa,
a.container);pa.addClass("fullcoveredvideo")}Ja.css({display:"block"});a.nextslideatend=o.data("nextslideatend");if(o.data("autoplay")==true||T==true){if(o.data("videoloop")=="loopandnoslidestop"){a.videoplaying=false;a.container.trigger("starttimer");a.container.trigger("revolution.slide.onvideostop")}else{a.videoplaying=true;a.container.trigger("stoptimer");a.container.trigger("revolution.slide.onvideoplay")}if(o.data("forcerewind")=="on"&&!pa.hasClass("videoisplaying"))if(wa.currentTime>0)wa.currentTime=
0;if(o.data("volume")=="mute")wa.muted=true;pa.data("timerplay",setTimeout(function(){if(o.data("forcerewind")=="on"&&!pa.hasClass("videoisplaying"))if(wa.currentTime>0)wa.currentTime=0;if(o.data("volume")=="mute")wa.muted=true;wa.play()},10+o.data("start")))}pa.data("ww")==f&&pa.data("ww",Ja.attr("width"));pa.data("hh")==f&&pa.data("hh",Ja.attr("height"));if(!o.hasClass("fullscreenvideo")&&o.data("forcecover")==1)try{pa.width(pa.data("ww")*a.bw);pa.height(pa.data("hh")*a.bh)}catch(l){}clearInterval(pa.data("interval"))}}),
100)});if(o.data("autoplay")==true){setTimeout(function(){if(o.data("videoloop")!="loopandnoslidestop"){a.videoplaying=true;a.container.trigger("stoptimer")}},200);if(o.data("videoloop")!="loopandnoslidestop"){a.videoplaying=true;a.container.trigger("stoptimer")}if(o.data("autoplayonlyfirsttime")==true||o.data("autoplayonlyfirsttime")=="true"){o.data("autoplay",false);o.data("autoplayonlyfirsttime",false)}}}H=ga=0;if(o.find("img").length>0){H=o.find("img");H.width()==0&&H.css({width:"auto"});H.height()==
0&&H.css({height:"auto"});H.data("ww")==f&&H.width()>0&&H.data("ww",H.width());H.data("hh")==f&&H.height()>0&&H.data("hh",H.height());ga=H.data("ww");la=H.data("hh");if(ga==f)ga=0;if(la==f)la=0;H.width(ga*a.bw);H.height(la*a.bh);ga=H.width();H=H.height()}else if(o.find("iframe").length>0||o.find("video").length>0){oa=false;H=o.find("iframe");if(H.length==0){H=o.find("video");oa=true}H.css({display:"block"});o.data("ww")==f&&o.data("ww",H.width());o.data("hh")==f&&o.data("hh",H.height());ga=o.data("ww");
la=o.data("hh");if(o.data("fsize")==f)o.data("fsize",parseInt(o.css("font-size"),0)||0);if(o.data("pt")==f)o.data("pt",parseInt(o.css("paddingTop"),0)||0);if(o.data("pb")==f)o.data("pb",parseInt(o.css("paddingBottom"),0)||0);if(o.data("pl")==f)o.data("pl",parseInt(o.css("paddingLeft"),0)||0);if(o.data("pr")==f)o.data("pr",parseInt(o.css("paddingRight"),0)||0);if(o.data("mt")==f)o.data("mt",parseInt(o.css("marginTop"),0)||0);if(o.data("mb")==f)o.data("mb",parseInt(o.css("marginBottom"),0)||0);if(o.data("ml")==
f)o.data("ml",parseInt(o.css("marginLeft"),0)||0);if(o.data("mr")==f)o.data("mr",parseInt(o.css("marginRight"),0)||0);if(o.data("bt")==f)o.data("bt",parseInt(o.css("borderTop"),0)||0);if(o.data("bb")==f)o.data("bb",parseInt(o.css("borderBottom"),0)||0);if(o.data("bl")==f)o.data("bl",parseInt(o.css("borderLeft"),0)||0);if(o.data("br")==f)o.data("br",parseInt(o.css("borderRight"),0)||0);if(o.data("lh")==f)o.data("lh",parseInt(o.css("lineHeight"),0)||0);X=a.width;da=a.height;if(X>a.startwidth)X=a.startwidth;
if(da>a.startheight)da=a.startheight;if(o.hasClass("fullscreenvideo")){S=G=0;o.data("x",0);o.data("y",0);X=a.height;if(a.autoHeight=="on")X=a.container.height();o.css({width:a.width,height:X})}else o.css({"font-size":o.data("fsize")*a.bw+"px","padding-top":o.data("pt")*a.bh+"px","padding-bottom":o.data("pb")*a.bh+"px","padding-left":o.data("pl")*a.bw+"px","padding-right":o.data("pr")*a.bw+"px","margin-top":o.data("mt")*a.bh+"px","margin-bottom":o.data("mb")*a.bh+"px","margin-left":o.data("ml")*a.bw+
"px","margin-right":o.data("mr")*a.bw+"px","border-top":o.data("bt")*a.bh+"px","border-bottom":o.data("bb")*a.bh+"px","border-left":o.data("bl")*a.bw+"px","border-right":o.data("br")*a.bw+"px","line-height":o.data("lh")*a.bh+"px",height:la*a.bh+"px"});if(oa==false){H.width(ga*a.bw);H.height(la*a.bh)}else if(o.data("forcecover")!=1&&!o.hasClass("fullscreenvideo")){H.width(ga*a.bw);H.height(la*a.bh)}ga=H.width();H=H.height()}else{o.find(".tp-resizeme, .tp-resizeme *").each(function(){I(b(this),a)});
o.hasClass("tp-resizeme")&&o.find("*").each(function(){I(b(this),a)});I(o,a);H=o.outerHeight(true);ga=o.outerWidth(true);la=o.outerHeight();oa=o.css("backgroundColor");o.find(".frontcorner").css({borderWidth:la+"px",left:0-la+"px",borderRight:"0px solid transparent",borderTopColor:oa});o.find(".frontcornertop").css({borderWidth:la+"px",left:0-la+"px",borderRight:"0px solid transparent",borderBottomColor:oa});o.find(".backcorner").css({borderWidth:la+"px",right:0-la+"px",borderLeft:"0px solid transparent",
borderBottomColor:oa});o.find(".backcornertop").css({borderWidth:la+"px",right:0-la+"px",borderLeft:"0px solid transparent",borderTopColor:oa})}if(a.fullScreenAlignForce=="on")S=G=0;o.data("voffset")==f&&o.data("voffset",0);o.data("hoffset")==f&&o.data("hoffset",0);la=o.data("voffset")*ua;oa=o.data("hoffset")*ua;X=a.startwidth*ua;da=a.startheight*ua;if(a.fullScreenAlignForce=="on"){X=a.container.width();da=a.container.height()}if(o.data("x")=="center"||o.data("xcenter")=="center"){o.data("xcenter",
"center");o.data("x",X/2-o.outerWidth(true)/2+oa)}if(o.data("x")=="left"||o.data("xleft")=="left"){o.data("xleft","left");o.data("x",0/ua+oa)}if(o.data("x")=="right"||o.data("xright")=="right"){o.data("xright","right");o.data("x",(X-o.outerWidth(true)+oa)/ua)}if(o.data("y")=="center"||o.data("ycenter")=="center"){o.data("ycenter","center");o.data("y",da/2-o.outerHeight(true)/2+la)}if(o.data("y")=="top"||o.data("ytop")=="top"){o.data("ytop","top");o.data("y",0/a.bh+la)}if(o.data("y")=="bottom"||o.data("ybottom")==
"bottom"){o.data("ybottom","bottom");o.data("y",(da-o.outerHeight(true)+la)/ua)}o.data("start")==f&&o.data("start",1E3);la=o.data("easing");if(la==f)la="punchgs.Power1.easeOut";la=o.data("start")/1E3;oa=o.data("speed")/1E3;X=o.data("x")=="center"||o.data("xcenter")=="center"?o.data("x")+G:ua*o.data("x")+G;da=o.data("y")=="center"||o.data("ycenter")=="center"?o.data("y")+S:a.bh*o.data("y")+S;punchgs.TweenLite.set(o,{top:da,left:X,overwrite:"auto"});if(U==0)ea=true;if(o.data("timeline")!=f&&!ea){U!=
2&&o.data("timeline").gotoAndPlay(0);ea=true}if(!ea){o.data("timeline");da=new punchgs.TimelineLite({smoothChildTiming:true,onStart:function(){}});da.pause();Ca=o;o.data("mySplitText")!=f&&o.data("mySplitText").revert();if(o.data("splitin")=="chars"||o.data("splitin")=="words"||o.data("splitin")=="lines"||o.data("splitout")=="chars"||o.data("splitout")=="words"||o.data("splitout")=="lines"){if(o.find("a").length>0)o.data("mySplitText",new punchgs.SplitText(o.find("a"),{type:"lines,words,chars",charsClass:"tp-splitted",
wordsClass:"tp-splitted",linesClass:"tp-splitted"}));else o.find(".tp-layer-inner-rotation").length>0?o.data("mySplitText",new punchgs.SplitText(o.find(".tp-layer-inner-rotation"),{type:"lines,words,chars",charsClass:"tp-splitted",wordsClass:"tp-splitted",linesClass:"tp-splitted"})):o.data("mySplitText",new punchgs.SplitText(o,{type:"lines,words,chars",charsClass:"tp-splitted",wordsClass:"tp-splitted",linesClass:"tp-splitted"}));o.addClass("splitted")}if(o.data("splitin")=="chars")Ca=o.data("mySplitText").chars;
if(o.data("splitin")=="words")Ca=o.data("mySplitText").words;if(o.data("splitin")=="lines")Ca=o.data("mySplitText").lines;X=Na();Ha=Na();if(o.data("repeat")!=f)repeatV=o.data("repeat");if(o.data("yoyo")!=f)yoyoV=o.data("yoyo");if(o.data("repeatdelay")!=f)repeatdelayV=o.data("repeatdelay");if(o.hasClass("customin"))X=O(X,o.data("customin"));else if(o.hasClass("randomrotate")){X.scale=Math.random()*3+1;X.rotation=Math.round(Math.random()*200-100);X.x=Math.round(Math.random()*200-100);X.y=Math.round(Math.random()*
200-100)}else if(o.hasClass("lfr")||o.hasClass("skewfromright"))X.x=15+a.width;else if(o.hasClass("lfl")||o.hasClass("skewfromleft"))X.x=-15-ga;else if(o.hasClass("sfl")||o.hasClass("skewfromleftshort"))X.x=-50;else if(o.hasClass("sfr")||o.hasClass("skewfromrightshort"))X.x=50;else if(o.hasClass("lft"))X.y=-25-H;else if(o.hasClass("lfb"))X.y=25+a.height;else if(o.hasClass("sft"))X.y=-50;else if(o.hasClass("sfb"))X.y=50;if(o.hasClass("skewfromright")||o.hasClass("skewfromrightshort"))X.skewX=-85;else if(o.hasClass("skewfromleft")||
o.hasClass("skewfromleftshort"))X.skewX=85;if(o.hasClass("fade")||o.hasClass("sft")||o.hasClass("sfl")||o.hasClass("sfb")||o.hasClass("skewfromleftshort")||o.hasClass("sfr")||o.hasClass("skewfromrightshort"))X.opacity=0;na().toLowerCase();ga=o.data("elementdelay")==f?0:o.data("elementdelay");Ha.ease=X.ease=o.data("easing")==f?punchgs.Power1.easeInOut:o.data("easing");X.data={};X.data.oldx=X.x;X.data.oldy=X.y;Ha.data={};Ha.data.oldx=Ha.x;Ha.data.oldy=Ha.y;X.x*=ua;X.y*=ua;H=new punchgs.TimelineLite;
if(U!=2)if(o.hasClass("customin")){Ca!=o&&da.add(punchgs.TweenLite.set(o,{force3D:"auto",opacity:1,scaleX:1,scaleY:1,rotationX:0,rotationY:0,rotationZ:0,skewX:0,skewY:0,z:0,x:0,y:0,visibility:"visible",opacity:1,delay:0,overwrite:"all"}));X.visibility="hidden";Ha.visibility="visible";Ha.overwrite="all";Ha.opacity=1;Ha.onComplete=void 0;Ha.delay=la;Ha.force3D="auto";da.add(H.staggerFromTo(Ca,oa,X,Ha,ga),"frame0")}else{X.visibility="visible";X.transformPerspective=600;Ca!=o&&da.add(punchgs.TweenLite.set(o,
{force3D:"auto",opacity:1,scaleX:1,scaleY:1,rotationX:0,rotationY:0,rotationZ:0,skewX:0,skewY:0,z:0,x:0,y:0,visibility:"visible",opacity:1,delay:0,overwrite:"all"}));Ha.visibility="visible";Ha.delay=la;Ha.onComplete=void 0;Ha.opacity=1;Ha.force3D="auto";if(o.hasClass("randomrotate")&&Ca!=o)for(H=0;H<Ca.length;H++){Xa={};Ba={};b.extend(Xa,X);b.extend(Ba,Ha);X.scale=Math.random()*3+1;X.rotation=Math.round(Math.random()*200-100);X.x=Math.round(Math.random()*200-100);X.y=Math.round(Math.random()*200-
100);if(H!=0)Ba.delay=la+H*ga;da.append(punchgs.TweenLite.fromTo(Ca[H],oa,Xa,Ba),"frame0")}else da.add(H.staggerFromTo(Ca,oa,X,Ha,ga),"frame0")}o.data("timeline",da);if(o.data("frames")!=f){ga=o.data("frames");ga=ga.replace(/\s+/g,"");ga=ga.replace("{","");ga=ga.split("}");b.each(ga,function(wa,Ja){if(Ja.length>0){var pa=Z(Ja),T="frame"+(wa+10),ia=o.data("timeline"),l=new punchgs.TimelineLite,q=o;if(pa.typ=="chars")q=o.data("mySplitText").chars;else if(pa.typ=="words")q=o.data("mySplitText").words;
else if(pa.typ=="lines")q=o.data("mySplitText").lines;pa.animation.ease=pa.ease;if(pa.animation.rotationZ!=f)pa.animation.rotation=pa.animation.rotationZ;pa.animation.data={};pa.animation.data.oldx=pa.animation.x;pa.animation.data.oldy=pa.animation.y;pa.animation.x*=ua;pa.animation.y*=ua;ia.add(l.staggerTo(q,pa.speed,pa.animation,pa.elementdelay),pa.start);ia.addLabel(T,pa.start);o.data("timeline",ia)}})}da=o.data("timeline");if(o.data("end")!=f&&(U==-1||U==2))Qa(o,a,o.data("end")/1E3,X,"frame99",
ua);else U==-1||U==2?Qa(o,a,999999,X,"frame99",ua):Qa(o,a,200,X,"frame99",ua);da=o.data("timeline");o.data("timeline",da);P(o,ua);da.resume()}}if(ea){ca(o);P(o,ua);if(o.data("timeline")!=f){U=o.data("timeline").getTweensOf();b.each(U,function(wa,Ja){if(Ja.vars.data!=f){var pa=Ja.vars.data.oldx*ua,T=Ja.vars.data.oldy*ua;if(Ja.progress()!=1&&Ja.progress()!=0)try{Ja.vars.x=pa;Ja.vary.y=T}catch(ia){}else Ja.progress()==1&&punchgs.TweenLite.set(Ja.target,{x:pa,y:T})}})}}});b("body").find("#"+a.container.attr("id")).find(".tp-bannertimer").data("opt",
a);u!=f&&setTimeout(function(){u.resume()},30)},na=function(){var d=navigator.appName,a=navigator.userAgent,h,u=a.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);if(u&&(h=a.match(/version\/([\.\d]+)/i))!=null)u[2]=h[1];u=u?[u[1],u[2]]:[d,navigator.appVersion,"-?"];return u[0]},I=function(d,a){if(d.data("fsize")==f)d.data("fsize",parseInt(d.css("font-size"),0)||0);if(d.data("pt")==f)d.data("pt",parseInt(d.css("paddingTop"),0)||0);if(d.data("pb")==f)d.data("pb",parseInt(d.css("paddingBottom"),
0)||0);if(d.data("pl")==f)d.data("pl",parseInt(d.css("paddingLeft"),0)||0);if(d.data("pr")==f)d.data("pr",parseInt(d.css("paddingRight"),0)||0);if(d.data("mt")==f)d.data("mt",parseInt(d.css("marginTop"),0)||0);if(d.data("mb")==f)d.data("mb",parseInt(d.css("marginBottom"),0)||0);if(d.data("ml")==f)d.data("ml",parseInt(d.css("marginLeft"),0)||0);if(d.data("mr")==f)d.data("mr",parseInt(d.css("marginRight"),0)||0);if(d.data("bt")==f)d.data("bt",parseInt(d.css("borderTopWidth"),0)||0);if(d.data("bb")==
f)d.data("bb",parseInt(d.css("borderBottomWidth"),0)||0);if(d.data("bl")==f)d.data("bl",parseInt(d.css("borderLeftWidth"),0)||0);if(d.data("br")==f)d.data("br",parseInt(d.css("borderRightWidth"),0)||0);if(d.data("ls")==f)d.data("ls",parseInt(d.css("letterSpacing"),0)||0);if(d.data("lh")==f)d.data("lh",parseInt(d.css("lineHeight"),0)||"auto");if(d.data("minwidth")==f)d.data("minwidth",parseInt(d.css("minWidth"),0)||0);if(d.data("minheight")==f)d.data("minheight",parseInt(d.css("minHeight"),0)||0);
if(d.data("maxwidth")==f)d.data("maxwidth",parseInt(d.css("maxWidth"),0)||"none");if(d.data("maxheight")==f)d.data("maxheight",parseInt(d.css("maxHeight"),0)||"none");if(d.data("wii")==f)d.data("wii",parseInt(d.css("width"),0)||0);if(d.data("hii")==f)d.data("hii",parseInt(d.css("height"),0)||0);d.data("wan")==f&&d.data("wan",d.css("-webkit-transition"));d.data("moan")==f&&d.data("moan",d.css("-moz-animation-transition"));d.data("man")==f&&d.data("man",d.css("-ms-animation-transition"));d.data("ani")==
f&&d.data("ani",d.css("transition"));if(!d.hasClass("tp-splitted")){d.css("-webkit-transition","none");d.css("-moz-transition","none");d.css("-ms-transition","none");d.css("transition","none");punchgs.TweenLite.set(d,{fontSize:Math.round(d.data("fsize")*a.bw)+"px",letterSpacing:Math.floor(d.data("ls")*a.bw)+"px",paddingTop:Math.round(d.data("pt")*a.bh)+"px",paddingBottom:Math.round(d.data("pb")*a.bh)+"px",paddingLeft:Math.round(d.data("pl")*a.bw)+"px",paddingRight:Math.round(d.data("pr")*a.bw)+"px",
marginTop:d.data("mt")*a.bh+"px",marginBottom:d.data("mb")*a.bh+"px",marginLeft:d.data("ml")*a.bw+"px",marginRight:d.data("mr")*a.bw+"px",borderTopWidth:Math.round(d.data("bt")*a.bh)+"px",borderBottomWidth:Math.round(d.data("bb")*a.bh)+"px",borderLeftWidth:Math.round(d.data("bl")*a.bw)+"px",borderRightWidth:Math.round(d.data("br")*a.bw)+"px",lineHeight:Math.round(d.data("lh")*a.bh)+"px",minWidth:d.data("minwidth")*a.bw+"px",minHeight:d.data("minheight")*a.bh+"px",overwrite:"auto"});setTimeout(function(){d.css("-webkit-transition",
d.data("wan"));d.css("-moz-transition",d.data("moan"));d.css("-ms-transition",d.data("man"));d.css("transition",d.data("ani"))},30);d.data("maxheight")!="none"&&d.css({maxHeight:d.data("maxheight")*a.bh+"px"});d.data("maxwidth")!="none"&&d.css({maxWidth:d.data("maxwidth")*a.bw+"px"})}},P=function(d,a){d.find(".rs-pendulum").each(function(){var h=b(this);if(h.data("timeline")==f){h.data("timeline",new punchgs.TimelineLite);var u=h.data("startdeg")==f?-20:h.data("startdeg"),D=h.data("enddeg")==f?20:
h.data("enddeg");speed=h.data("speed")==f?2:h.data("speed");origin=h.data("origin")==f?"50% 50%":h.data("origin");easing=h.data("ease")==f?punchgs.Power2.easeInOut:h.data("ease");u*=a;D*=a;h.data("timeline").append(new punchgs.TweenLite.fromTo(h,speed,{force3D:"auto",rotation:u,transformOrigin:origin},{rotation:D,ease:easing}));h.data("timeline").append(new punchgs.TweenLite.fromTo(h,speed,{force3D:"auto",rotation:D,transformOrigin:origin},{rotation:u,ease:easing,onComplete:function(){h.data("timeline").restart()}}))}});
d.find(".rs-slideloop").each(function(){var h=b(this);if(h.data("timeline")==f){h.data("timeline",new punchgs.TimelineLite);var u=h.data("xs")==f?0:h.data("xs"),D=h.data("ys")==f?0:h.data("ys");xe=h.data("xe")==f?0:h.data("xe");ye=h.data("ye")==f?0:h.data("ye");speed=h.data("speed")==f?2:h.data("speed");easing=h.data("ease")==f?punchgs.Power2.easeInOut:h.data("ease");u*=a;D*=a;xe*=a;ye*=a;h.data("timeline").append(new punchgs.TweenLite.fromTo(h,speed,{force3D:"auto",x:u,y:D},{x:xe,y:ye,ease:easing}));
h.data("timeline").append(new punchgs.TweenLite.fromTo(h,speed,{force3D:"auto",x:xe,y:ye},{x:u,y:D,onComplete:function(){h.data("timeline").restart()}}))}});d.find(".rs-pulse").each(function(){var h=b(this);if(h.data("timeline")==f){h.data("timeline",new punchgs.TimelineLite);var u=h.data("zoomstart")==f?0:h.data("zoomstart"),D=h.data("zoomend")==f?0:h.data("zoomend");speed=h.data("speed")==f?2:h.data("speed");easing=h.data("ease")==f?punchgs.Power2.easeInOut:h.data("ease");h.data("timeline").append(new punchgs.TweenLite.fromTo(h,
speed,{force3D:"auto",scale:u},{scale:D,ease:easing}));h.data("timeline").append(new punchgs.TweenLite.fromTo(h,speed,{force3D:"auto",scale:D},{scale:u,onComplete:function(){h.data("timeline").restart()}}))}});d.find(".rs-wave").each(function(){var h=b(this);if(h.data("timeline")==f){h.data("timeline",new punchgs.TimelineLite);var u=h.data("angle")==f?10:h.data("angle"),D=h.data("radius")==f?10:h.data("radius"),G=h.data("speed")==f?-20:h.data("speed");h.data("origin")==f||h.data("origin");u*=a;D*=
a;var S={a:0,ang:u,element:h,unit:D};h.data("timeline").append(new punchgs.TweenLite.fromTo(S,G,{a:360},{a:0,force3D:"auto",ease:punchgs.Linear.easeNone,onUpdate:function(){var R=S.a*(Math.PI/180);punchgs.TweenLite.to(S.element,0.1,{force3D:"auto",x:Math.cos(R)*S.unit,y:S.unit*(1-Math.sin(R))})},onComplete:function(){h.data("timeline").restart()}}))}})},ca=function(d){d.find(".rs-pendulum, .rs-slideloop, .rs-pulse, .rs-wave").each(function(){var a=b(this);if(a.data("timeline")!=f){a.data("timeline").pause();
a.data("timeline",null)}})},va=function(d,a){var h=0,u=d.find(".tp-caption"),D=a.container.find(".tp-static-layers").find(".tp-caption");b.each(D,function(G,S){u.push(S)});u.each(function(){var G=-1,S=b(this);if(S.hasClass("tp-static-layer")){if(S.data("startslide")==-1||S.data("startslide")=="-1")S.data("startslide",0);if(S.data("endslide")==-1||S.data("endslide")=="-1")S.data("endslide",a.slideamount);if(S.hasClass("tp-is-shown"))if(S.data("startslide")>a.next||S.data("endslide")<a.next){G=2;S.removeClass("tp-is-shown")}else G=
0;else G=2}if(G!=0){ca(S);if(S.find("iframe").length>0){punchgs.TweenLite.to(S.find("iframe"),0.2,{autoAlpha:0});k()&&S.find("iframe").remove();try{var R=S.find("iframe").attr("id");$f(R).api("pause");clearTimeout(S.data("timerplay"))}catch(H){}try{S.data("player").stopVideo();clearTimeout(S.data("timerplay"))}catch(ea){}}if(S.find("video").length>0)try{S.find("video").each(function(){var X=b(this).parent();X.attr("id");clearTimeout(X.data("timerplay"));this.pause()})}catch(U){}try{var o=S.data("timeline"),
ga=o.getLabelTime("frame99"),ua=o.time();if(ga>ua){var Fa=o.getTweensOf(S);b.each(Fa,function(X,da){X!=0&&da.pause()});if(S.css("opacity")!=0){var la=S.data("endspeed")==f?S.data("speed"):S.data("endspeed");if(la>h)h=la;o.play("frame99")}else o.progress(1,false)}}catch(oa){}}});return h},Qa=function(d,a,h,u,D,G){var S=d.data("timeline"),R=new punchgs.TimelineLite,H=Na(),ea=d.data("endspeed")==f?d.data("speed"):d.data("endspeed");H.ease=d.data("endeasing")==f?punchgs.Power1.easeInOut:d.data("endeasing");
ea/=1E3;if(d.hasClass("ltr")||d.hasClass("ltl")||d.hasClass("str")||d.hasClass("stl")||d.hasClass("ltt")||d.hasClass("ltb")||d.hasClass("stt")||d.hasClass("stb")||d.hasClass("skewtoright")||d.hasClass("skewtorightshort")||d.hasClass("skewtoleft")||d.hasClass("skewtoleftshort")||d.hasClass("fadeout")||d.hasClass("randomrotateout")){if(d.hasClass("skewtoright")||d.hasClass("skewtorightshort"))H.skewX=35;else if(d.hasClass("skewtoleft")||d.hasClass("skewtoleftshort"))H.skewX=-35;if(d.hasClass("ltr")||
d.hasClass("skewtoright"))H.x=a.width+60;else if(d.hasClass("ltl")||d.hasClass("skewtoleft"))H.x=0-(a.width+60);else if(d.hasClass("ltt"))H.y=0-(a.height+60);else if(d.hasClass("ltb"))H.y=a.height+60;else if(d.hasClass("str")||d.hasClass("skewtorightshort")){H.x=50;H.opacity=0}else if(d.hasClass("stl")||d.hasClass("skewtoleftshort")){H.x=-50;H.opacity=0}else if(d.hasClass("stt")){H.y=-50;H.opacity=0}else if(d.hasClass("stb")){H.y=50;H.opacity=0}else if(d.hasClass("randomrotateout")){H.x=Math.random()*
a.width;H.y=Math.random()*a.height;H.scale=Math.random()*2+0.3;H.rotation=Math.random()*360-180;H.opacity=0}else if(d.hasClass("fadeout"))H.opacity=0;if(d.hasClass("skewtorightshort"))H.x=270;else if(d.hasClass("skewtoleftshort"))H.x=-270;H.data={};H.data.oldx=H.x;H.data.oldy=H.y;H.x*=G;H.y*=G;H.overwrite="auto";a=a=d;if(d.data("splitout")=="chars")a=d.data("mySplitText").chars;else if(d.data("splitout")=="words")a=d.data("mySplitText").words;else if(d.data("splitout")=="lines")a=d.data("mySplitText").lines;
u=d.data("endelementdelay")==f?0:d.data("endelementdelay");S.add(R.staggerTo(a,ea,H,u),h)}else if(d.hasClass("customout")){H=O(H,d.data("customout"));a=d;if(d.data("splitout")=="chars")a=d.data("mySplitText").chars;else if(d.data("splitout")=="words")a=d.data("mySplitText").words;else if(d.data("splitout")=="lines")a=d.data("mySplitText").lines;u=d.data("endelementdelay")==f?0:d.data("endelementdelay");H.onStart=function(){punchgs.TweenLite.set(d,{transformPerspective:H.transformPerspective,transformOrigin:H.transformOrigin,
overwrite:"auto"})};H.data={};H.data.oldx=H.x;H.data.oldy=H.y;H.x*=G;H.y*=G;S.add(R.staggerTo(a,ea,H,u),h)}else{u.delay=0;S.add(punchgs.TweenLite.to(d,ea,u),h)}S.addLabel(D,h);d.data("timeline",S)},Pa=function(d,a){d.children().each(function(){try{b(this).die("click")}catch(u){}try{b(this).die("mouseenter")}catch(D){}try{b(this).die("mouseleave")}catch(G){}try{b(this).unbind("hover")}catch(S){}});try{d.die("click","mouseenter","mouseleave")}catch(h){}clearInterval(a.cdint);d=null},Ma=function(d,a){a.cd=
0;a.loop=0;a.looptogo=a.stopAfterLoops!=f&&a.stopAfterLoops>-1?a.stopAfterLoops:9999999;a.lastslidetoshow=a.stopAtSlide!=f&&a.stopAtSlide>-1?a.stopAtSlide:999;a.stopLoop="off";if(a.looptogo==0)a.stopLoop="on";if(a.slideamount>1&&!(a.stopAfterLoops==0&&a.stopAtSlide==1)){var h=d.find(".tp-bannertimer");d.on("stoptimer",function(){var D=b(this).find(".tp-bannertimer");D.data("tween").pause();a.hideTimerBar=="on"&&D.css({visibility:"hidden"})});d.on("starttimer",function(){if(a.conthover!=1&&a.videoplaying!=
true&&a.width>a.hideSliderAtLimit&&a.bannertimeronpause!=true&&a.overnav!=true)if(a.stopLoop=="on"&&a.next==a.lastslidetoshow-1||a.noloopanymore==1)a.noloopanymore=1;else{h.css({visibility:"visible"});h.data("tween").resume()}a.hideTimerBar=="on"&&h.css({visibility:"hidden"})});d.on("restarttimer",function(){var D=b(this).find(".tp-bannertimer");if(a.stopLoop=="on"&&a.next==a.lastslidetoshow-1||a.noloopanymore==1)a.noloopanymore=1;else{D.css({visibility:"visible"});D.data("tween").kill();D.data("tween",
punchgs.TweenLite.fromTo(D,a.delay/1E3,{width:"0%"},{force3D:"auto",width:"100%",ease:punchgs.Linear.easeNone,onComplete:u,delay:1}))}a.hideTimerBar=="on"&&D.css({visibility:"hidden"})});d.on("nulltimer",function(){h.data("tween").pause(0);a.hideTimerBar=="on"&&h.css({visibility:"hidden"})});var u=function(){if(b("body").find(d).length==0){Pa(d,a);clearInterval(a.cdint)}d.trigger("revolution.slide.slideatend");if(d.data("conthover-changed")==1){a.conthover=d.data("conthover");d.data("conthover-changed",
0)}a.act=a.next;a.next+=1;if(a.next>d.find(">ul >li").length-1){a.next=0;a.looptogo-=1;if(a.looptogo<=0)a.stopLoop="on"}if(a.stopLoop=="on"&&a.next==a.lastslidetoshow-1){d.find(".tp-bannertimer").css({visibility:"hidden"});d.trigger("revolution.slide.onstop");a.noloopanymore=1}else h.data("tween").restart();Aa(d,a)};h.data("tween",punchgs.TweenLite.fromTo(h,a.delay/1E3,{width:"0%"},{force3D:"auto",width:"100%",ease:punchgs.Linear.easeNone,onComplete:u,delay:1}));h.data("opt",a);d.hover(function(){if(a.onHoverStop==
"on"&&!k()){d.trigger("stoptimer");d.trigger("revolution.slide.onpause");d.find(">ul >li:eq("+a.next+") .slotholder").find(".defaultimg").each(function(){var D=b(this);D.data("kenburn")!=f&&D.data("kenburn").pause()})}},function(){if(d.data("conthover")!=1){d.trigger("revolution.slide.onresume");d.trigger("starttimer");d.find(">ul >li:eq("+a.next+") .slotholder").find(".defaultimg").each(function(){var D=b(this);D.data("kenburn")!=f&&D.data("kenburn").play()})}})}},k=function(){var d=["android","webos",
"iphone","ipad","blackberry","Android","webos",,"iPod","iPhone","iPad","Blackberry","BlackBerry"],a=false;for(i in d)if(navigator.userAgent.split(d[i]).length>1)a=true;return a},z=function(d,a,h){var u=a.data("owidth");a=a.data("oheight");if(u/a>h.width/h.height){u=h.container.width()/u;h=a*u/h.container.height()*d;d*=100/h;return d+"% 100% 1"}else{u=h.container.width()/u;h=a*u/h.container.height()*d;return d+"% "+h+"%"}},C=function(d,a,h,u){try{d.find(">ul:first-child >li:eq("+a.act+")")}catch(D){d.find(">ul:first-child >li:eq(1)")}a.lastslide=
a.act;var G=d.find(">ul:first-child >li:eq("+a.next+")").find(".slotholder"),S=G.data("bgposition"),R=G.data("bgpositionend");d=G.data("zoomstart")/100;h=G.data("zoomend")/100;var H=G.data("rotationstart"),ea=G.data("rotationend"),U=G.data("bgfit"),o=G.data("bgfitend"),ga=G.data("easeme"),ua=G.data("duration")/1E3,Fa=100;if(U==f)U=100;if(o==f)o=100;var la=U,oa=o;U=z(U,G,a);o=z(o,G,a);Fa=z(100,G,a);if(d==f)d=1;if(h==f)h=1;if(H==f)H=0;if(ea==f)ea=0;if(d<1)d=1;if(h<1)h=1;var X={};X.w=parseInt(Fa.split(" ")[0],
0);X.h=parseInt(Fa.split(" ")[1],0);var da=false;if(Fa.split(" ")[2]=="1")da=true;G.find(".defaultimg").each(function(){var Ca=b(this);G.find(".kenburnimg").length==0?G.append('<div class="kenburnimg" style="position:absolute;z-index:1;width:100%;height:100%;top:0px;left:0px;"><img src="'+Ca.attr("src")+'" style="-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;position:absolute;width:'+X.w+"%;height:"+X.h+
'%;"></div>'):G.find(".kenburnimg img").css({width:X.w+"%",height:X.h+"%"});var Ha=G.find(".kenburnimg img"),Xa=J(a,S,U,Ha,da),Ba=J(a,R,o,Ha,da);if(da){Xa.w=la/100;Ba.w=oa/100}if(u){punchgs.TweenLite.set(Ha,{autoAlpha:0,transformPerspective:1200,transformOrigin:"0% 0%",top:0,left:0,scale:Xa.w,x:Xa.x,y:Xa.y});Ba=Xa.w;var cb=Ba*Ha.width()-a.width,ab=Ba*Ha.height()-a.height,wa=Math.abs(Xa.x/cb*100);Xa=Math.abs(Xa.y/ab*100);if(ab==0)Xa=0;if(cb==0)wa=0;Ca.data("bgposition",wa+"% "+Xa+"%");s(8)||Ca.data("currotate",
W(Ha));s(8)||Ca.data("curscale",X.w*Ba+"%  "+(X.h*Ba+"%"));G.find(".kenburnimg").remove()}else Ca.data("kenburn",punchgs.TweenLite.fromTo(Ha,ua,{autoAlpha:1,force3D:punchgs.force3d,transformOrigin:"0% 0%",top:0,left:0,scale:Xa.w,x:Xa.x,y:Xa.y},{autoAlpha:1,rotationZ:ea,ease:ga,x:Ba.x,y:Ba.y,scale:Ba.w,onUpdate:function(){var Ja=Ha[0]._gsTransform.scaleX,pa=Ja*Ha.width()-a.width,T=Ja*Ha.height()-a.height,ia=Math.abs(Ha[0]._gsTransform.x/pa*100),l=Math.abs(Ha[0]._gsTransform.y/T*100);if(T==0)l=0;if(pa==
0)ia=0;Ca.data("bgposition",ia+"% "+l+"%");s(8)||Ca.data("currotate",W(Ha));s(8)||Ca.data("curscale",X.w*Ja+"%  "+(X.h*Ja+"%"))}}))})},J=function(d,a,h,u,D){var G={};G.w=D?parseInt(h.split(" ")[1],0)/100:parseInt(h.split(" ")[0],0)/100;switch(a){case "left top":case "top left":G.x=0;G.y=0;break;case "center top":case "top center":G.x=((0-u.width())*G.w+parseInt(d.width,0))/2;G.y=0;break;case "top right":case "right top":G.x=(0-u.width())*G.w+parseInt(d.width,0);G.y=0;break;case "center left":case "left center":G.x=
0;G.y=((0-u.height())*G.w+parseInt(d.height,0))/2;break;case "center center":G.x=((0-u.width())*G.w+parseInt(d.width,0))/2;G.y=((0-u.height())*G.w+parseInt(d.height,0))/2;break;case "center right":case "right center":G.x=(0-u.width())*G.w+parseInt(d.width,0);G.y=((0-u.height())*G.w+parseInt(d.height,0))/2;break;case "bottom left":case "left bottom":G.x=0;G.y=(0-u.height())*G.w+parseInt(d.height,0);break;case "bottom center":case "center bottom":G.x=((0-u.width())*G.w+parseInt(d.width,0))/2;G.y=(0-
u.height())*G.w+parseInt(d.height,0);break;case "bottom right":case "right bottom":G.x=(0-u.width())*G.w+parseInt(d.width,0);G.y=(0-u.height())*G.w+parseInt(d.height,0)}return G},W=function(d){d=d.css("-webkit-transform")||d.css("-moz-transform")||d.css("-ms-transform")||d.css("-o-transform")||d.css("transform");if(d!=="none"){d=d.split("(")[1].split(")")[0].split(",");d=Math.round(Math.atan2(d[1],d[0])*(180/Math.PI))}else d=0;return d<0?d+=360:d},aa=function(d,a){try{var h=d.find(">ul:first-child >li:eq("+
a.act+")")}catch(u){h=d.find(">ul:first-child >li:eq(1)")}a.lastslide=a.act;var D=d.find(">ul:first-child >li:eq("+a.next+")");h.find(".slotholder");D.find(".slotholder");d.find(".defaultimg").each(function(){var G=b(this);punchgs.TweenLite.killTweensOf(G,false);punchgs.TweenLite.set(G,{scale:1,rotationZ:0});punchgs.TweenLite.killTweensOf(G.data("kenburn img"),false);G.data("kenburn")!=f&&G.data("kenburn").pause();G.data("currotate")!=f&&G.data("bgposition")!=f&&G.data("curscale")!=f&&punchgs.TweenLite.set(G,
{rotation:G.data("currotate"),backgroundPosition:G.data("bgposition"),backgroundSize:G.data("curscale")});G!=f&&G.data("kenburn img")!=f&&G.data("kenburn img").length>0&&punchgs.TweenLite.set(G.data("kenburn img"),{autoAlpha:0})})},xa=function(d,a){if(k()&&a.parallaxDisableOnMobile=="on")return false;d.find(">ul:first-child >li").each(function(){for(var h=b(this),u=1;u<=10;u++)h.find(".rs-parallaxlevel-"+u).each(function(){var D=b(this);D.wrap('<div style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index:'+
D.css("zIndex")+'" class="tp-parallax-container" data-parallaxlevel="'+a.parallaxLevels[u-1]+'"></div>')})});if(a.parallax=="mouse"||a.parallax=="scroll+mouse"||a.parallax=="mouse+scroll"){d.mouseenter(function(h){var u=d.find(".current-sr-slide-visible"),D=d.offset().top,G=d.offset().left;D=h.pageY-D;u.data("enterx",h.pageX-G);u.data("entery",D)});d.on("mousemove.hoverdir, mouseleave.hoverdir",function(h){var u=d.find(".current-sr-slide-visible");switch(h.type){case "mousemove":var D=d.offset().top,
G=d.offset().left,S=u.data("enterx"),R=u.data("entery"),H=S-(h.pageX-G),ea=R-(h.pageY-D);u.find(".tp-parallax-container").each(function(){var U=b(this),o=parseInt(U.data("parallaxlevel"),0)/100,ga=H*o;o*=ea;a.parallax=="scroll+mouse"||a.parallax=="mouse+scroll"?punchgs.TweenLite.to(U,0.4,{force3D:"auto",x:ga,ease:punchgs.Power3.easeOut,overwrite:"all"}):punchgs.TweenLite.to(U,0.4,{force3D:"auto",x:ga,y:o,ease:punchgs.Power3.easeOut,overwrite:"all"})});break;case "mouseleave":u.find(".tp-parallax-container").each(function(){var U=
b(this);a.parallax=="scroll+mouse"||a.parallax=="mouse+scroll"?punchgs.TweenLite.to(U,1.5,{force3D:"auto",x:0,ease:punchgs.Power3.easeOut}):punchgs.TweenLite.to(U,1.5,{force3D:"auto",x:0,y:0,ease:punchgs.Power3.easeOut})})}});if(k())window.ondeviceorientation=function(h){var u=Math.round(h.beta||0);h=Math.round(h.gamma||0);var D=d.find(".current-sr-slide-visible");if(b(window).width()>b(window).height()){var G=h;h=u;u=G}var S=360/d.width()*h,R=180/d.height()*u;D.find(".tp-parallax-container").each(function(){var H=
b(this),ea=parseInt(H.data("parallaxlevel"),0)/100;punchgs.TweenLite.to(H,0.2,{force3D:"auto",x:S*ea,y:R*ea,ease:punchgs.Power3.easeOut})})}}if(a.parallax=="scroll"||a.parallax=="scroll+mouse"||a.parallax=="mouse+scroll")b(window).on("scroll",function(){ba(d,a)})},ba=function(d,a){if(k()&&a.parallaxDisableOnMobile=="on")return false;var h=d.offset().top,u=b(window).scrollTop(),D=h+d.height()/2;h=h+d.height()/2-u;u=b(window).height()/2;var G=u-h;if(D<u)G-=u-D;d.find(".current-sr-slide-visible");d.find(".tp-parallax-container").each(function(){var S=
b(this),R=parseInt(S.data("parallaxlevel"),0)/100;R*=G;S.data("parallaxoffset",R);punchgs.TweenLite.to(S,0.2,{force3D:"auto",y:R,ease:punchgs.Power3.easeOut})});a.parallaxBgFreeze!="on"&&punchgs.TweenLite.to(d,0.2,{force3D:"auto",y:G*(a.parallaxLevels[0]/100),ease:punchgs.Power3.easeOut})},Ga=function(d,a){var h=d.parent();if(a.navigationType=="thumb"||a.navsecond=="both")h.append('<div class="tp-bullets tp-thumbs '+a.navigationStyle+'"><div class="tp-mask"><div class="tp-thumbcontainer"></div></div></div>');
var u=h.find(".tp-bullets.tp-thumbs .tp-mask .tp-thumbcontainer");h=u.parent();h.width(a.thumbWidth*a.thumbAmount);h.height(a.thumbHeight);h.parent().width(a.thumbWidth*a.thumbAmount);h.parent().height(a.thumbHeight);d.find(">ul:first >li").each(function(S){var R=d.find(">ul:first >li:eq("+S+")");S=R.find(".defaultimg").css("backgroundColor");R=R.data("thumb")!=f?R.data("thumb"):R.find("img:first").attr("src");u.append('<div class="bullet thumb" style="background-color:'+S+";position:relative;width:"+
a.thumbWidth+"px;height:"+a.thumbHeight+"px;background-image:url("+R+') !important;background-size:cover;background-position:center center;"></div>');u.find(".bullet:first")});var D=10;u.find(".bullet").each(function(S){var R=b(this);S==a.slideamount-1&&R.addClass("last");S==0&&R.addClass("first");R.width(a.thumbWidth);R.height(a.thumbHeight);if(D<R.outerWidth(true))D=R.outerWidth(true);R.click(function(){if(a.transition==0&&R.index()!=a.act){a.next=R.index();w(a,d)}})});h=D*d.find(">ul:first >li").length;
var G=u.parent().width();a.thumbWidth=D;if(G<h){b(document).mousemove(function(S){b("body").data("mousex",S.pageX)});u.parent().mouseenter(function(){var S=b(this);S.addClass("over");var R=S.offset(),H=b("body").data("mousex")-R.left;R=S.width();var ea=S.find(".bullet:first").outerWidth(true)*d.find(">ul:first >li").length;H-=30;H=0-H*((ea-R+15)/R);if(H>0)H=0;if(H<0-ea+R)H=0-ea+R;Ta(S,H,200)});u.parent().mousemove(function(){var S=b(this),R=S.offset(),H=b("body").data("mousex")-R.left;R=S.width();
var ea=S.find(".bullet:first").outerWidth(true)*d.find(">ul:first >li").length-1;H-=3;if(H<6)H=0;if(H+3>R-6)H=R;H=0-H*((ea-R+15)/R);if(H>0)H=0;if(H<0-ea+R)H=0-ea+R;Ta(S,H,0)});u.parent().mouseleave(function(){b(this).removeClass("over");Da(d)})}},Da=function(d){var a=d.parent().find(".tp-bullets.tp-thumbs .tp-mask .tp-thumbcontainer").parent();a.offset();var h=a.find(".bullet:first").outerWidth(true),u=a.find(".bullet.selected").index()*h,D=a.width();h=a.find(".bullet:first").outerWidth(true);d=h*
d.find(">ul:first >li").length;u=0-u;if(u>0)u=0;if(u<0-d+D)u=0-d+D;a.hasClass("over")||Ta(a,u,200)},Ta=function(d,a){punchgs.TweenLite.to(d.find(".tp-thumbcontainer"),0.2,{force3D:"auto",left:a,ease:punchgs.Power3.easeOut,overwrite:"auto"})}})(jQuery);
(function(b){typeof define==="function"&&define.amd&&define.amd.jQuery?define(["jquery"],b):b(jQuery)})(function(b){function f(La){if(La&&La.allowPageScroll===undefined&&(La.swipe!==undefined||La.swipeStatus!==undefined))La.allowPageScroll=K;if(La.click!==undefined&&La.tap===undefined)La.tap=La.click;La||(La={});La=b.extend({},b.fn.swipe.defaults,La);return this.each(function(){var Q=b(this),Wa=Q.data(Ia);if(!Wa){Wa=new n(this,La);Q.data(Ia,Wa)}})}function n(La,Q){function Wa(T){if(oa.data(Ia+"_intouch")!==
true)if(!(b(T.target).closest(Q.excludedElements,oa).length>0)){var ia=T.originalEvent?T.originalEvent:T,l,q=Oa?ia.touches[0]:ia;X=ta;if(Oa)da=ia.touches.length;else T.preventDefault();R=0;Fa=H=null;o=U=ea=0;ga=1;ua=0;Ca=xa();la=Ga();cb=Ba=0;if(!Oa||da===Q.fingers||Q.fingers===ha||Pa()){W(0,q);Ha=d();if(da==2){W(1,ia.touches[1]);U=o=Ta(Ca[0].start,Ca[1].start)}if(Q.swipeStatus||Q.pinchStatus)l=na(ia,X)}else l=false;if(l===false){X=qa;na(ia,X);return l}else{if(Q.hold)Ja=setTimeout(b.proxy(function(){oa.trigger("hold",
[ia.target]);if(Q.hold)l=Q.hold.call(oa,ia,ia.target)},this),Q.longTapThreshold);J(true)}return null}}function Ra(T){var ia=T.originalEvent?T.originalEvent:T;if(!(X===sa||X===qa||C())){var l,q=aa(Oa?ia.touches[0]:ia);Xa=d();if(Oa)da=ia.touches.length;Q.hold&&clearTimeout(Ja);X=Ka;if(da==2){if(U==0){W(1,ia.touches[1]);U=o=Ta(Ca[0].start,Ca[1].start)}else{aa(ia.touches[1]);o=Ta(Ca[0].end,Ca[1].end);Fa=ga<1?w:s}ga=(o/U*1).toFixed(2);ua=Math.abs(U-o)}if(da===Q.fingers||Q.fingers===ha||!Oa||Pa()){var v;
v=q.start;var y=q.end;v=Math.round(Math.atan2(y.y-v.y,v.x-y.x)*180/Math.PI);if(v<0)v=360-Math.abs(v);v=H=v<=45&&v>=0?g:v<=360&&v>=315?g:v>=135&&v<=225?c:v>45&&v<135?j:e;if(Q.allowPageScroll===K||Pa())T.preventDefault();else{y=Q.allowPageScroll===p;switch(v){case g:if(Q.swipeLeft&&y||!y&&Q.allowPageScroll!=F)T.preventDefault();break;case c:if(Q.swipeRight&&y||!y&&Q.allowPageScroll!=F)T.preventDefault();break;case e:if(Q.swipeUp&&y||!y&&Q.allowPageScroll!=V)T.preventDefault();break;case j:if(Q.swipeDown&&
y||!y&&Q.allowPageScroll!=V)T.preventDefault()}}R=Math.round(Math.sqrt(Math.pow(q.end.x-q.start.x,2)+Math.pow(q.end.y-q.start.y,2)));ea=Xa-Ha;T=H;v=R;v=Math.max(v,ba(T));la[T].distance=v;if(Q.swipeStatus||Q.pinchStatus)l=na(ia,X);if(!Q.triggerOnTouchEnd||Q.triggerOnTouchLeave){T=true;if(Q.triggerOnTouchLeave){T=b(this);v=T.offset();T={left:v.left,right:v.left+T.outerWidth(),top:v.top,bottom:v.top+T.outerHeight()};T=q.end.x>T.left&&q.end.x<T.right&&q.end.y>T.top&&q.end.y<T.bottom}if(!Q.triggerOnTouchEnd&&
T)X=fa(Ka);else if(Q.triggerOnTouchLeave&&!T)X=fa(sa);if(X==qa||X==sa)na(ia,X)}}else{X=qa;na(ia,X)}if(l===false){X=qa;na(ia,X)}}}function za(T){var ia=T.originalEvent;if(Oa)if(ia.touches.length>0){Ba=d();cb=event.touches.length+1;return true}if(C())da=cb;Xa=d();ea=Xa-Ha;if(ca()||!P()){X=qa;na(ia,X)}else if(Q.triggerOnTouchEnd||Q.triggerOnTouchEnd==false&&X===Ka){T.preventDefault();X=sa;na(ia,X)}else if(!Q.triggerOnTouchEnd&&Q.tap){X=sa;I(ia,X,r)}else if(X===Ka){X=qa;na(ia,X)}J(false);return null}
function Na(){o=U=Ha=Xa=da=0;ga=1;cb=Ba=0;J(false)}function O(T){T=T.originalEvent;if(Q.triggerOnTouchLeave){X=fa(sa);na(T,X)}}function Z(){oa.unbind(h,Wa);oa.unbind(S,Na);oa.unbind(u,Ra);oa.unbind(D,za);G&&oa.unbind(G,O);J(false)}function fa(T){var ia=T,l=va(),q=P(),v=ca();if(!l||v)ia=qa;else if(q&&T==Ka&&(!Q.triggerOnTouchEnd||Q.triggerOnTouchLeave))ia=sa;else if(!q&&T==sa&&Q.triggerOnTouchLeave)ia=qa;return ia}function na(T,ia){var l=undefined;if(Ma()&&k()||k())l=I(T,ia,L);else if((Qa()&&Pa()||
Pa())&&l!==false)l=I(T,ia,N);if(z()&&Q.doubleTap&&l!==false)l=I(T,ia,x);else if(ea>Q.longTapThreshold&&R<ka&&Q.longTap&&l!==false)l=I(T,ia,m);else if((da===1||!Oa)&&(isNaN(R)||R<Q.threshold)&&Q.tap&&l!==false)l=I(T,ia,r);ia===qa&&Na(T);if(ia===sa)if(Oa)T.touches.length==0&&Na(T);else Na(T);return l}function I(T,ia,l){var q=undefined;if(l==L){oa.trigger("swipeStatus",[ia,H||null,R||0,ea||0,da,Ca]);if(Q.swipeStatus){q=Q.swipeStatus.call(oa,T,ia,H||null,R||0,ea||0,da,Ca);if(q===false)return false}if(ia==
sa&&Ma()){oa.trigger("swipe",[H,R,ea,da,Ca]);if(Q.swipe){q=Q.swipe.call(oa,T,H,R,ea,da,Ca);if(q===false)return false}switch(H){case g:oa.trigger("swipeLeft",[H,R,ea,da,Ca]);if(Q.swipeLeft)q=Q.swipeLeft.call(oa,T,H,R,ea,da,Ca);break;case c:oa.trigger("swipeRight",[H,R,ea,da,Ca]);if(Q.swipeRight)q=Q.swipeRight.call(oa,T,H,R,ea,da,Ca);break;case e:oa.trigger("swipeUp",[H,R,ea,da,Ca]);if(Q.swipeUp)q=Q.swipeUp.call(oa,T,H,R,ea,da,Ca);break;case j:oa.trigger("swipeDown",[H,R,ea,da,Ca]);if(Q.swipeDown)q=
Q.swipeDown.call(oa,T,H,R,ea,da,Ca)}}}if(l==N){oa.trigger("pinchStatus",[ia,Fa||null,ua||0,ea||0,da,ga,Ca]);if(Q.pinchStatus){q=Q.pinchStatus.call(oa,T,ia,Fa||null,ua||0,ea||0,da,ga,Ca);if(q===false)return false}if(ia==sa&&Qa())switch(Fa){case s:oa.trigger("pinchIn",[Fa||null,ua||0,ea||0,da,ga,Ca]);if(Q.pinchIn)q=Q.pinchIn.call(oa,T,Fa||null,ua||0,ea||0,da,ga,Ca);break;case w:oa.trigger("pinchOut",[Fa||null,ua||0,ea||0,da,ga,Ca]);if(Q.pinchOut)q=Q.pinchOut.call(oa,T,Fa||null,ua||0,ea||0,da,ga,Ca)}}if(l==
r){if(ia===qa||ia===sa){clearTimeout(wa);clearTimeout(Ja);if(Q.doubleTap&&!z()){ab=d();wa=setTimeout(b.proxy(function(){ab=null;oa.trigger("tap",[T.target]);if(Q.tap)q=Q.tap.call(oa,T,T.target)},this),Q.doubleTapThreshold)}else{ab=null;oa.trigger("tap",[T.target]);if(Q.tap)q=Q.tap.call(oa,T,T.target)}}}else if(l==x){if(ia===qa||ia===sa){clearTimeout(wa);ab=null;oa.trigger("doubletap",[T.target]);if(Q.doubleTap)q=Q.doubleTap.call(oa,T,T.target)}}else if(l==m)if(ia===qa||ia===sa){clearTimeout(wa);ab=
null;oa.trigger("longtap",[T.target]);if(Q.longTap)q=Q.longTap.call(oa,T,T.target)}return q}function P(){var T=true;if(Q.threshold!==null)T=R>=Q.threshold;return T}function ca(){var T=false;if(Q.cancelThreshold!==null&&H!==null)T=ba(H)-R>=Q.cancelThreshold;return T}function va(){return Q.maxTimeThreshold?ea>=Q.maxTimeThreshold?false:true:true}function Qa(){var T=da===Q.fingers||Q.fingers===ha||!Oa,ia=Ca[0].end.x!==0,l;l=Q.pinchThreshold!==null?ua>=Q.pinchThreshold:true;return T&&ia&&l}function Pa(){return!!(Q.pinchStatus||
Q.pinchIn||Q.pinchOut)}function Ma(){var T=va(),ia=P(),l=da===Q.fingers||Q.fingers===ha||!Oa,q=Ca[0].end.x!==0;return!ca()&&q&&l&&ia&&T}function k(){return!!(Q.swipe||Q.swipeStatus||Q.swipeLeft||Q.swipeRight||Q.swipeUp||Q.swipeDown)}function z(){if(ab==null)return false;var T=d();return!!Q.doubleTap&&T-ab<=Q.doubleTapThreshold}function C(){var T=false;if(Ba)if(d()-Ba<=Q.fingerReleaseThreshold)T=true;return T}function J(T){if(T===true){oa.bind(u,Ra);oa.bind(D,za);G&&oa.bind(G,O)}else{oa.unbind(u,Ra,
false);oa.unbind(D,za,false);G&&oa.unbind(G,O,false)}oa.data(Ia+"_intouch",T===true)}function W(T,ia){Ca[T].identifier=ia.identifier!==undefined?ia.identifier:0;Ca[T].start.x=Ca[T].end.x=ia.pageX||ia.clientX;Ca[T].start.y=Ca[T].end.y=ia.pageY||ia.clientY;return Ca[T]}function aa(T){var ia;a:{for(ia=0;ia<Ca.length;ia++)if(Ca[ia].identifier==(T.identifier!==undefined?T.identifier:0)){ia=Ca[ia];break a}ia=void 0}ia.end.x=T.pageX||T.clientX;ia.end.y=T.pageY||T.clientY;return ia}function xa(){for(var T=
[],ia=0;ia<=5;ia++)T.push({start:{x:0,y:0},end:{x:0,y:0},identifier:0});return T}function ba(T){if(la[T])return la[T].distance}function Ga(){var T={};T[g]=Da(g);T[c]=Da(c);T[e]=Da(e);T[j]=Da(j);return T}function Da(T){return{direction:T,distance:0}}function Ta(T,ia){var l=Math.abs(T.x-ia.x),q=Math.abs(T.y-ia.y);return Math.round(Math.sqrt(l*l+q*q))}function d(){return(new Date).getTime()}var a=Oa||Sa||!Q.fallbackToMouseEvents,h=a?Sa?Aa?"MSPointerDown":"pointerdown":"touchstart":"mousedown",u=a?Sa?
Aa?"MSPointerMove":"pointermove":"touchmove":"mousemove",D=a?Sa?Aa?"MSPointerUp":"pointerup":"touchend":"mouseup",G=a?null:"mouseleave",S=Sa?Aa?"MSPointerCancel":"pointercancel":"touchcancel",R=0,H=null,ea=0,U=0,o=0,ga=1,ua=0,Fa=0,la=null,oa=b(La),X="start",da=0,Ca=null,Ha=0,Xa=0,Ba=0,cb=0,ab=0,wa=null,Ja=null;try{oa.bind(h,Wa);oa.bind(S,Na)}catch(pa){b.error("events not supported "+h+","+S+" on jQuery.swipe")}this.enable=function(){oa.bind(h,Wa);oa.bind(S,Na);return oa};this.disable=function(){Z();
return oa};this.destroy=function(){Z();oa.data(Ia,null);return oa};this.option=function(T,ia){if(Q[T]!==undefined)if(ia===undefined)return Q[T];else Q[T]=ia;else b.error("Option "+T+" does not exist on jQuery.swipe.options");return null}}var g="left",c="right",e="up",j="down",s="in",w="out",K="none",p="auto",L="swipe",N="pinch",r="tap",x="doubletap",m="longtap",F="horizontal",V="vertical",ha="all",ka=10,ta="start",Ka="move",sa="end",qa="cancel",Oa="ontouchstart"in window,Aa=window.navigator.msPointerEnabled&&
!window.navigator.pointerEnabled,Sa=window.navigator.pointerEnabled||window.navigator.msPointerEnabled,Ia="TouchSwipe";b.fn.swipe=function(La){var Q=b(this),Wa=Q.data(Ia);if(Wa&&typeof La==="string")if(Wa[La])return Wa[La].apply(this,Array.prototype.slice.call(arguments,1));else b.error("Method "+La+" does not exist on jQuery.swipe");else if(!Wa&&(typeof La==="object"||!La))return f.apply(this,arguments);return Q};b.fn.swipe.defaults={fingers:1,threshold:75,cancelThreshold:null,pinchThreshold:20,
maxTimeThreshold:null,fingerReleaseThreshold:250,longTapThreshold:500,doubleTapThreshold:200,swipe:null,swipeLeft:null,swipeRight:null,swipeUp:null,swipeDown:null,swipeStatus:null,pinchIn:null,pinchOut:null,pinchStatus:null,click:null,tap:null,doubleTap:null,longTap:null,hold:null,triggerOnTouchEnd:true,triggerOnTouchLeave:false,allowPageScroll:"auto",fallbackToMouseEvents:true,excludedElements:"label, button, input, select, textarea, a, .noSwipe"};b.fn.swipe.phases={PHASE_START:ta,PHASE_MOVE:Ka,
PHASE_END:sa,PHASE_CANCEL:qa};b.fn.swipe.directions={LEFT:g,RIGHT:c,UP:e,DOWN:j,IN:s,OUT:w};b.fn.swipe.pageScroll={NONE:K,HORIZONTAL:F,VERTICAL:V,AUTO:p};b.fn.swipe.fingers={ONE:1,TWO:2,THREE:3,ALL:ha}});if(typeof console==="undefined"){var console={};console.log=console.error=console.info=console.debug=console.warn=console.trace=console.dir=console.dirxml=console.group=console.groupEnd=console.time=console.timeEnd=console.assert=console.profile=console.groupCollapsed=function(){}}
if(window.tplogs==true)try{console.groupCollapsed("ThemePunch GreenSocks Logs")}catch(e$$1){}var oldgs=window.GreenSockGlobals;oldgs_queue=window._gsQueue;var punchgs=window.GreenSockGlobals={};if(window.tplogs==true)try{console.info("Build GreenSock SandBox for ThemePunch Plugins");console.info("GreenSock TweenLite Engine Initalised by ThemePunch Plugin")}catch(e$$2){}
(function(b,f){var n=b.GreenSockGlobals=b.GreenSockGlobals||b;if(!n.TweenLite){var g,c,e,j,s,w=function(k){var z=k.split("."),C=n;for(k=0;z.length>k;k++)C[z[k]]=C=C[z[k]]||{};return C},K=w("com.greensock"),p=function(k){var z,C=[],J=k.length;for(z=0;z!==J;C.push(k[z++]));return C},L=function(){},N=function(){var k=Object.prototype.toString,z=k.call([]);return function(C){return null!=C&&(C instanceof Array||"object"==typeof C&&!!C.push&&k.call(C)===z)}}(),r={},x=function(k,z,C,J){this.sc=r[k]?r[k].sc:
[];r[k]=this;this.gsClass=null;this.func=C;var W=[];this.check=function(aa){for(var xa,ba,Ga=z.length,Da=Ga;--Ga>-1;)(xa=r[z[Ga]]||new x(z[Ga],[])).gsClass?(W[Ga]=xa.gsClass,Da--):aa&&xa.sc.push(this);if(0===Da&&C){aa=("com.greensock."+k).split(".");xa=aa.pop();ba=w(aa.join("."))[xa]=this.gsClass=C.apply(C,W);J&&(n[xa]=ba,"function"==typeof define&&define.amd?define((b.GreenSockAMDPath?b.GreenSockAMDPath+"/":"")+k.split(".").pop(),[],function(){return ba}):k===f&&"undefined"!=typeof module&&module.exports&&
(module.exports=ba));for(Ga=0;this.sc.length>Ga;Ga++)this.sc[Ga].check()}};this.check(true)},m=b._gsDefine=function(k,z,C,J){return new x(k,z,C,J)},F=K._class=function(k,z,C){return z=z||function(){},m(k,[],function(){return z},C),z};m.globals=n;var V=[0,0,1,1],ha=[],ka=F("easing.Ease",function(k,z,C,J){this._func=k;this._type=C||0;this._power=J||0;this._params=z?V.concat(z):V},true),ta=ka.map={},Ka=ka.register=function(k,z,C,J){var W,aa,xa;z=z.split(",");for(var ba=z.length,Ga=(C||"easeIn,easeOut,easeInOut").split(",");--ba>
-1;){W=z[ba];C=J?F("easing."+W,null,true):K.easing[W]||{};for(aa=Ga.length;--aa>-1;){xa=Ga[aa];ta[W+"."+xa]=ta[xa+W]=C[xa]=k.getRatio?k:k[xa]||new k}}};e=ka.prototype;e._calcEnd=false;e.getRatio=function(k){if(this._func)return this._params[0]=k,this._func.apply(null,this._params);var z=this._type,C=this._power,J=1===z?1-k:2===z?k:0.5>k?2*k:2*(1-k);return 1===C?J*=J:2===C?J*=J*J:3===C?J*=J*J*J:4===C&&(J*=J*J*J*J),1===z?1-J:2===z?J:0.5>k?J/2:1-J/2};g=["Linear","Quad","Cubic","Quart","Quint,Strong"];
for(c=g.length;--c>-1;){e=g[c]+",Power"+c;Ka(new ka(null,null,1,c),e,"easeOut",true);Ka(new ka(null,null,2,c),e,"easeIn"+(0===c?",easeNone":""));Ka(new ka(null,null,3,c),e,"easeInOut")}ta.linear=K.easing.Linear.easeIn;ta.swing=K.easing.Quad.easeInOut;var sa=F("events.EventDispatcher",function(k){this._listeners={};this._eventTarget=k||this});e=sa.prototype;e.addEventListener=function(k,z,C,J,W){W=W||0;var aa,xa=this._listeners[k],ba=0;null==xa&&(this._listeners[k]=xa=[]);for(aa=xa.length;--aa>-1;){k=
xa[aa];k.c===z&&k.s===C?xa.splice(aa,1):0===ba&&W>k.pr&&(ba=aa+1)}xa.splice(ba,0,{c:z,s:C,up:J,pr:W});this!==j||s||j.wake()};e.removeEventListener=function(k,z){var C,J=this._listeners[k];if(J)for(C=J.length;--C>-1;)if(J[C].c===z)return J.splice(C,1),void 0};e.dispatchEvent=function(k){var z,C,J,W=this._listeners[k];if(W){z=W.length;for(C=this._eventTarget;--z>-1;){J=W[z];J.up?J.c.call(J.s||C,{type:k,target:C}):J.c.call(J.s||C)}}};var qa=b.requestAnimationFrame,Oa=b.cancelAnimationFrame,Aa=Date.now||
function(){return(new Date).getTime()},Sa=Aa();g=["ms","moz","webkit","o"];for(c=g.length;--c>-1&&!qa;){qa=b[g[c]+"RequestAnimationFrame"];Oa=b[g[c]+"CancelAnimationFrame"]||b[g[c]+"CancelRequestAnimationFrame"]}F("Ticker",function(k,z){var C,J,W,aa,xa,ba=this,Ga=Aa(),Da=z!==false&&qa,Ta=500,d=33,a=function(h){var u,D;u=Aa()-Sa;u>Ta&&(Ga+=u-d);Sa+=u;ba.time=(Sa-Ga)/1E3;u=ba.time-xa;(!C||u>0||h===true)&&(ba.frame++,xa+=u+(u>=aa?0.0040:aa-u),D=true);h!==true&&(W=J(a));D&&ba.dispatchEvent("tick")};sa.call(ba);
ba.time=ba.frame=0;ba.tick=function(){a(true)};ba.lagSmoothing=function(h,u){Ta=h||1E10;d=Math.min(u,Ta,0)};ba.sleep=function(){null!=W&&(Da&&Oa?Oa(W):clearTimeout(W),J=L,W=null,ba===j&&(s=false))};ba.wake=function(){null!==W?ba.sleep():ba.frame>10&&(Sa=Aa()-Ta+5);J=0===C?L:Da&&qa?qa:function(h){return setTimeout(h,0|1E3*(xa-ba.time)+1)};ba===j&&(s=true);a(2)};ba.fps=function(h){return arguments.length?(C=h,aa=1/(C||60),xa=this.time+aa,ba.wake(),void 0):C};ba.useRAF=function(h){return arguments.length?
(ba.sleep(),Da=h,ba.fps(C),void 0):Da};ba.fps(k);setTimeout(function(){Da&&(!W||5>ba.frame)&&ba.useRAF(false)},1500)});e=K.Ticker.prototype=new K.events.EventDispatcher;e.constructor=K.Ticker;var Ia=F("core.Animation",function(k,z){if(this.vars=z=z||{},this._duration=this._totalDuration=k||0,this._delay=Number(z.delay)||0,this._timeScale=1,this._active=z.immediateRender===true,this.data=z.data,this._reversed=z.reversed===true,P){s||j.wake();var C=this.vars.useFrames?I:P;C.add(this,C._time);this.vars.paused&&
this.paused(true)}});j=Ia.ticker=new K.Ticker;e=Ia.prototype;e._dirty=e._gc=e._initted=e._paused=false;e._totalTime=e._time=0;e._rawPrevTime=-1;e._next=e._last=e._onUpdate=e._timeline=e.timeline=null;e._paused=false;var La=function(){s&&Aa()-Sa>2E3&&j.wake();setTimeout(La,2E3)};La();e.play=function(k,z){return null!=k&&this.seek(k,z),this.reversed(false).paused(false)};e.pause=function(k,z){return null!=k&&this.seek(k,z),this.paused(true)};e.resume=function(k,z){return null!=k&&this.seek(k,z),this.paused(false)};
e.seek=function(k,z){return this.totalTime(Number(k),z!==false)};e.restart=function(k,z){return this.reversed(false).paused(false).totalTime(k?-this._delay:0,z!==false,true)};e.reverse=function(k,z){return null!=k&&this.seek(k||this.totalDuration(),z),this.reversed(true).paused(false)};e.render=function(){};e.invalidate=function(){return this};e.isActive=function(){var k,z=this._timeline,C=this._startTime;return!z||!this._gc&&!this._paused&&z.isActive()&&(k=z.rawTime())>=C&&C+this.totalDuration()/
this._timeScale>k};e._enabled=function(k,z){return s||j.wake(),this._gc=!k,this._active=this.isActive(),z!==true&&(k&&!this.timeline?this._timeline.add(this,this._startTime-this._delay):!k&&this.timeline&&this._timeline._remove(this,true)),false};e._kill=function(){return this._enabled(false,false)};e.kill=function(k,z){return this._kill(k,z),this};e._uncache=function(k){for(k=k?this:this.timeline;k;){k._dirty=true;k=k.timeline}return this};e._swapSelfInParams=function(k){for(var z=k.length,C=k.concat();--z>
-1;)"{self}"===k[z]&&(C[z]=this);return C};e.eventCallback=function(k,z,C,J){if("on"===(k||"").substr(0,2)){var W=this.vars;if(1===arguments.length)return W[k];null==z?delete W[k]:(W[k]=z,W[k+"Params"]=N(C)&&-1!==C.join("").indexOf("{self}")?this._swapSelfInParams(C):C,W[k+"Scope"]=J);"onUpdate"===k&&(this._onUpdate=z)}return this};e.delay=function(k){return arguments.length?(this._timeline.smoothChildTiming&&this.startTime(this._startTime+k-this._delay),this._delay=k,this):this._delay};e.duration=
function(k){return arguments.length?(this._duration=this._totalDuration=k,this._uncache(true),this._timeline.smoothChildTiming&&this._time>0&&this._time<this._duration&&0!==k&&this.totalTime(this._totalTime*(k/this._duration),true),this):(this._dirty=false,this._duration)};e.totalDuration=function(k){return this._dirty=false,arguments.length?this.duration(k):this._totalDuration};e.time=function(k,z){return arguments.length?(this._dirty&&this.totalDuration(),this.totalTime(k>this._duration?this._duration:
k,z)):this._time};e.totalTime=function(k,z,C){if(s||j.wake(),!arguments.length)return this._totalTime;if(this._timeline){if(0>k&&!C&&(k+=this.totalDuration()),this._timeline.smoothChildTiming){this._dirty&&this.totalDuration();var J=this._totalDuration,W=this._timeline;if(k>J&&!C&&(k=J),this._startTime=(this._paused?this._pauseTime:W._time)-(this._reversed?J-k:k)/this._timeScale,W._dirty||this._uncache(false),W._timeline)for(;W._timeline;){W._timeline._time!==(W._startTime+W._totalTime)/W._timeScale&&
W.totalTime(W._totalTime,true);W=W._timeline}}this._gc&&this._enabled(true,false);(this._totalTime!==k||0===this._duration)&&(this.render(k,z,false),Ra.length&&ca())}return this};e.progress=e.totalProgress=function(k,z){return arguments.length?this.totalTime(this.duration()*k,z):this._time/this.duration()};e.startTime=function(k){return arguments.length?(k!==this._startTime&&(this._startTime=k,this.timeline&&this.timeline._sortChildren&&this.timeline.add(this,k-this._delay)),this):this._startTime};
e.timeScale=function(k){if(!arguments.length)return this._timeScale;if(k=k||1.0E-10,this._timeline&&this._timeline.smoothChildTiming){var z=this._pauseTime;z=z||0===z?z:this._timeline.totalTime();this._startTime=z-(z-this._startTime)*this._timeScale/k}return this._timeScale=k,this._uncache(false)};e.reversed=function(k){return arguments.length?(k!=this._reversed&&(this._reversed=k,this.totalTime(this._timeline&&!this._timeline.smoothChildTiming?this.totalDuration()-this._totalTime:this._totalTime,
true)),this):this._reversed};e.paused=function(k){if(!arguments.length)return this._paused;if(k!=this._paused&&this._timeline){s||k||j.wake();var z=this._timeline,C=z.rawTime(),J=C-this._pauseTime;!k&&z.smoothChildTiming&&(this._startTime+=J,this._uncache(false));this._pauseTime=k?C:null;this._paused=k;this._active=this.isActive();!k&&0!==J&&this._initted&&this.duration()&&this.render(z.smoothChildTiming?this._totalTime:(C-this._startTime)/this._timeScale,true,true)}return this._gc&&!k&&this._enabled(true,
false),this};c=F("core.SimpleTimeline",function(k){Ia.call(this,0,k);this.autoRemoveChildren=this.smoothChildTiming=true});e=c.prototype=new Ia;e.constructor=c;e.kill()._gc=false;e._first=e._last=null;e._sortChildren=false;e.add=e.insert=function(k,z){var C,J;if(k._startTime=Number(z||0)+k._delay,k._paused&&this!==k._timeline&&(k._pauseTime=k._startTime+(this.rawTime()-k._startTime)/k._timeScale),k.timeline&&k.timeline._remove(k,true),k.timeline=k._timeline=this,k._gc&&k._enabled(true,true),C=this._last,
this._sortChildren)for(J=k._startTime;C&&C._startTime>J;)C=C._prev;return C?(k._next=C._next,C._next=k):(k._next=this._first,this._first=k),k._next?k._next._prev=k:this._last=k,k._prev=C,this._timeline&&this._uncache(true),this};e._remove=function(k,z){return k.timeline===this&&(z||k._enabled(false,true),k._prev?k._prev._next=k._next:this._first===k&&(this._first=k._next),k._next?k._next._prev=k._prev:this._last===k&&(this._last=k._prev),k._next=k._prev=k.timeline=null,this._timeline&&this._uncache(true)),
this};e.render=function(k,z,C){var J,W=this._first;for(this._totalTime=this._time=this._rawPrevTime=k;W;){J=W._next;(W._active||k>=W._startTime&&!W._paused)&&(W._reversed?W.render((W._dirty?W.totalDuration():W._totalDuration)-(k-W._startTime)*W._timeScale,z,C):W.render((k-W._startTime)*W._timeScale,z,C));W=J}};e.rawTime=function(){return s||j.wake(),this._totalTime};var Q=F("TweenLite",function(k,z,C){if(Ia.call(this,z,C),this.render=Q.prototype.render,null==k)throw"Cannot tween a null target.";this.target=
k="string"!=typeof k?k:Q.selector(k)||k;var J,W;J=k.jquery||k.length&&k!==b&&k[0]&&(k[0]===b||k[0].nodeType&&k[0].style&&!k.nodeType);C=this.vars.overwrite;if(this._overwrite=C=null==C?na[Q.defaultOverwrite]:"number"==typeof C?C>>0:na[C],(J||k instanceof Array||k.push&&N(k))&&"number"!=typeof k[0]){this._targets=W=p(k);this._propLookup=[];this._siblings=[];for(k=0;W.length>k;k++)(J=W[k])?"string"!=typeof J?J.length&&J!==b&&J[0]&&(J[0]===b||J[0].nodeType&&J[0].style&&!J.nodeType)?(W.splice(k--,1),
this._targets=W=W.concat(p(J))):(this._siblings[k]=va(J,this,false),1===C&&this._siblings[k].length>1&&Qa(J,this,null,1,this._siblings[k])):(J=W[k--]=Q.selector(J),"string"==typeof J&&W.splice(k+1,1)):W.splice(k--,1)}else{this._propLookup={};this._siblings=va(k,this,false);1===C&&this._siblings.length>1&&Qa(k,this,null,1,this._siblings)}(this.vars.immediateRender||0===z&&0===this._delay&&this.vars.immediateRender!==false)&&(this._time=-1.0E-10,this.render(-this._delay))},true),Wa=function(k){return k.length&&
k!==b&&k[0]&&(k[0]===b||k[0].nodeType&&k[0].style&&!k.nodeType)};e=Q.prototype=new Ia;e.constructor=Q;e.kill()._gc=false;e.ratio=0;e._firstPT=e._targets=e._overwrittenProps=e._startAt=null;e._notifyPluginsOfEnabled=e._lazy=false;Q.version="1.13.1";Q.defaultEase=e._ease=new ka(null,null,1,1);Q.defaultOverwrite="auto";Q.ticker=j;Q.autoSleep=true;Q.lagSmoothing=function(k,z){j.lagSmoothing(k,z)};Q.selector=b.$||b.jQuery||function(k){var z=b.$||b.jQuery;return z?(Q.selector=z,z(k)):"undefined"==typeof document?
k:document.querySelectorAll?document.querySelectorAll(k):document.getElementById("#"===k.charAt(0)?k.substr(1):k)};var Ra=[],za={};Ka=Q._internals={isArray:N,isSelector:Wa,lazyTweens:Ra};var Na=Q._plugins={},O=Ka.tweenLookup={},Z=0,fa=Ka.reservedProps={ease:1,delay:1,overwrite:1,onComplete:1,onCompleteParams:1,onCompleteScope:1,useFrames:1,runBackwards:1,startAt:1,onUpdate:1,onUpdateParams:1,onUpdateScope:1,onStart:1,onStartParams:1,onStartScope:1,onReverseComplete:1,onReverseCompleteParams:1,onReverseCompleteScope:1,
onRepeat:1,onRepeatParams:1,onRepeatScope:1,easeParams:1,yoyo:1,immediateRender:1,repeat:1,repeatDelay:1,data:1,paused:1,reversed:1,autoCSS:1,lazy:1},na={none:0,all:1,auto:2,concurrent:3,allOnStart:4,preexisting:5,"true":1,"false":0},I=Ia._rootFramesTimeline=new c,P=Ia._rootTimeline=new c,ca=Ka.lazyRender=function(){var k=Ra.length;for(za={};--k>-1;)(g=Ra[k])&&g._lazy!==false&&(g.render(g._lazy,false,true),g._lazy=false);Ra.length=0};P._startTime=j.time;I._startTime=j.frame;P._active=I._active=true;
setTimeout(ca,1);Ia._updateRoot=Q.render=function(){var k,z,C;if(Ra.length&&ca(),P.render((j.time-P._startTime)*P._timeScale,false,false),I.render((j.frame-I._startTime)*I._timeScale,false,false),Ra.length&&ca(),!(j.frame%120)){for(C in O){z=O[C].tweens;for(k=z.length;--k>-1;)z[k]._gc&&z.splice(k,1);0===z.length&&delete O[C]}if(C=P._first,(!C||C._paused)&&Q.autoSleep&&!I._first&&1===j._listeners.tick.length){for(;C&&C._paused;)C=C._next;C||j.sleep()}}};j.addEventListener("tick",Ia._updateRoot);var va=
function(k,z,C){var J,W,aa=k._gsTweenID;if(O[aa||(k._gsTweenID=aa="t"+Z++)]||(O[aa]={target:k,tweens:[]}),z&&(J=O[aa].tweens,J[W=J.length]=z,C))for(;--W>-1;)J[W]===z&&J.splice(W,1);return O[aa].tweens},Qa=function(k,z,C,J,W){var aa,xa,ba;if(1===J||J>=4){k=W.length;for(aa=0;k>aa;aa++)if((ba=W[aa])!==z)ba._gc||ba._enabled(false,false)&&(xa=true);else if(5===J)break;return xa}var Ga,Da=z._startTime+1.0E-10,Ta=[],d=0,a=0===z._duration;for(aa=W.length;--aa>-1;)(ba=W[aa])===z||ba._gc||ba._paused||(ba._timeline!==
z._timeline?(Ga=Ga||Pa(z,0,a),0===Pa(ba,Ga,a)&&(Ta[d++]=ba)):Da>=ba._startTime&&ba._startTime+ba.totalDuration()/ba._timeScale>Da&&((a||!ba._initted)&&2.0E-10>=Da-ba._startTime||(Ta[d++]=ba)));for(aa=d;--aa>-1;){ba=Ta[aa];2===J&&ba._kill(C,k)&&(xa=true);(2!==J||!ba._firstPT&&ba._initted)&&ba._enabled(false,false)&&(xa=true)}return xa},Pa=function(k,z,C){for(var J=k._timeline,W=J._timeScale,aa=k._startTime;J._timeline;){if(aa+=J._startTime,W*=J._timeScale,J._paused)return-100;J=J._timeline}return aa/=
W,aa>z?aa-z:C&&aa===z||!k._initted&&2.0E-10>aa-z?1.0E-10:(aa+=k.totalDuration()/k._timeScale/W)>z+1.0E-10?0:aa-z-1.0E-10};e._init=function(){var k,z,C,J=this.vars,W=this._overwrittenProps,aa=this._duration,xa=!!J.immediateRender,ba=J.ease;if(J.startAt){this._startAt&&(this._startAt.render(-1,true),this._startAt.kill());C={};for(k in J.startAt)C[k]=J.startAt[k];if(C.overwrite=false,C.immediateRender=true,C.lazy=xa&&J.lazy!==false,C.startAt=C.delay=null,this._startAt=Q.to(this.target,0,C),xa)if(this._time>
0)this._startAt=null;else if(0!==aa)return}else if(J.runBackwards&&0!==aa)if(this._startAt){this._startAt.render(-1,true);this._startAt.kill();this._startAt=null}else{C={};for(k in J)fa[k]&&"autoCSS"!==k||(C[k]=J[k]);if(C.overwrite=0,C.data="isFromStart",C.lazy=xa&&J.lazy!==false,C.immediateRender=xa,this._startAt=Q.to(this.target,0,C),xa){if(0===this._time)return}else{this._startAt._init();this._startAt._enabled(false)}}if(this._ease=ba=ba?ba instanceof ka?ba:"function"==typeof ba?new ka(ba,J.easeParams):
ta[ba]||Q.defaultEase:Q.defaultEase,J.easeParams instanceof Array&&ba.config&&(this._ease=ba.config.apply(ba,J.easeParams)),this._easeType=this._ease._type,this._easePower=this._ease._power,this._firstPT=null,this._targets)for(k=this._targets.length;--k>-1;)this._initProps(this._targets[k],this._propLookup[k]={},this._siblings[k],W?W[k]:null)&&(z=true);else z=this._initProps(this.target,this._propLookup,this._siblings,W);if(z&&Q._onPluginEvent("_onInitAllProps",this),W&&(this._firstPT||"function"!=
typeof this.target&&this._enabled(false,false)),J.runBackwards)for(C=this._firstPT;C;){C.s+=C.c;C.c=-C.c;C=C._next}this._onUpdate=J.onUpdate;this._initted=true};e._initProps=function(k,z,C,J){var W,aa,xa,ba,Ga;if(null==k)return false;za[k._gsTweenID]&&ca();if(!this.vars.css)if(k.style)if(k!==b)if(k.nodeType)if(Na.css)if(this.vars.autoCSS!==false){aa=this.vars;var Da,Ta={};for(Da in aa)fa[Da]||Da in k&&"transform"!==Da&&"x"!==Da&&"y"!==Da&&"width"!==Da&&"height"!==Da&&"className"!==Da&&"border"!==
Da||!(!Na[Da]||Na[Da]&&Na[Da]._autoCSS)||(Ta[Da]=aa[Da],delete aa[Da]);aa.css=Ta}for(W in this.vars){if(aa=this.vars[W],fa[W])aa&&(aa instanceof Array||aa.push&&N(aa))&&-1!==aa.join("").indexOf("{self}")&&(this.vars[W]=this._swapSelfInParams(aa,this));else if(Na[W]&&(ba=new Na[W])._onInitTween(k,this.vars[W],this)){this._firstPT=Ga={_next:this._firstPT,t:ba,p:"setRatio",s:0,c:1,f:true,n:W,pg:true,pr:ba._priority};for(aa=ba._overwriteProps.length;--aa>-1;)z[ba._overwriteProps[aa]]=this._firstPT;(ba._priority||
ba._onInitAllProps)&&(xa=true);(ba._onDisable||ba._onEnable)&&(this._notifyPluginsOfEnabled=true)}else{this._firstPT=z[W]=Ga={_next:this._firstPT,t:k,p:W,f:"function"==typeof k[W],n:W,pg:false,pr:0};Ga.s=Ga.f?k[W.indexOf("set")||"function"!=typeof k["get"+W.substr(3)]?W:"get"+W.substr(3)]():parseFloat(k[W]);Ga.c="string"==typeof aa&&"="===aa.charAt(1)?parseInt(aa.charAt(0)+"1",10)*Number(aa.substr(2)):Number(aa)-Ga.s||0}Ga&&Ga._next&&(Ga._next._prev=Ga)}return J&&this._kill(J,k)?this._initProps(k,
z,C,J):this._overwrite>1&&this._firstPT&&C.length>1&&Qa(k,this,z,this._overwrite,C)?(this._kill(z,k),this._initProps(k,z,C,J)):(this._firstPT&&(this.vars.lazy!==false&&this._duration||this.vars.lazy&&!this._duration)&&(za[k._gsTweenID]=true),xa)};e.render=function(k,z,C){var J,W,aa,xa,ba=this._time,Ga=this._duration;aa=this._rawPrevTime;if(k>=Ga){this._totalTime=this._time=Ga;this.ratio=this._ease._calcEnd?this._ease.getRatio(1):1;this._reversed||(J=true,W="onComplete");0===Ga&&(this._initted||!this.vars.lazy||
C)&&(this._startTime===this._timeline._duration&&(k=0),(0===k||0>aa||aa===1.0E-10)&&aa!==k&&(C=true,aa>1.0E-10&&(W="onReverseComplete")),this._rawPrevTime=xa=!z||k||aa===k?k:1.0E-10)}else if(1.0E-7>k){this._totalTime=this._time=0;this.ratio=this._ease._calcEnd?this._ease.getRatio(0):0;(0!==ba||0===Ga&&aa>0&&aa!==1.0E-10)&&(W="onReverseComplete",J=this._reversed);0>k?(this._active=false,0===Ga&&(this._initted||!this.vars.lazy||C)&&(aa>=0&&(C=true),this._rawPrevTime=xa=!z||k||aa===k?k:1.0E-10)):this._initted||
(C=true)}else if(this._totalTime=this._time=k,this._easeType){var Da=k/Ga,Ta=this._easeType,d=this._easePower;(1===Ta||3===Ta&&Da>=0.5)&&(Da=1-Da);3===Ta&&(Da*=2);1===d?Da*=Da:2===d?Da*=Da*Da:3===d?Da*=Da*Da*Da:4===d&&(Da*=Da*Da*Da*Da);this.ratio=1===Ta?1-Da:2===Ta?Da:0.5>k/Ga?Da/2:1-Da/2}else this.ratio=this._ease.getRatio(k/Ga);if(this._time!==ba||C){if(!this._initted){if(this._init(),!this._initted||this._gc)return;if(!C&&this._firstPT&&(this.vars.lazy!==false&&this._duration||this.vars.lazy&&
!this._duration))return this._time=this._totalTime=ba,this._rawPrevTime=aa,Ra.push(this),this._lazy=k,void 0;this._time&&!J?this.ratio=this._ease.getRatio(this._time/Ga):J&&this._ease._calcEnd&&(this.ratio=this._ease.getRatio(0===this._time?0:1))}this._lazy!==false&&(this._lazy=false);this._active||!this._paused&&this._time!==ba&&k>=0&&(this._active=true);0===ba&&(this._startAt&&(k>=0?this._startAt.render(k,z,C):W||(W="_dummyGS")),this.vars.onStart&&(0!==this._time||0===Ga)&&(z||this.vars.onStart.apply(this.vars.onStartScope||
this,this.vars.onStartParams||ha)));for(aa=this._firstPT;aa;){aa.f?aa.t[aa.p](aa.c*this.ratio+aa.s):aa.t[aa.p]=aa.c*this.ratio+aa.s;aa=aa._next}this._onUpdate&&(0>k&&this._startAt&&this._startTime&&this._startAt.render(k,z,C),z||(this._time!==ba||J)&&this._onUpdate.apply(this.vars.onUpdateScope||this,this.vars.onUpdateParams||ha));W&&(!this._gc||C)&&(0>k&&this._startAt&&!this._onUpdate&&this._startTime&&this._startAt.render(k,z,C),J&&(this._timeline.autoRemoveChildren&&this._enabled(false,false),
this._active=false),!z&&this.vars[W]&&this.vars[W].apply(this.vars[W+"Scope"]||this,this.vars[W+"Params"]||ha),0===Ga&&this._rawPrevTime===1.0E-10&&xa!==1.0E-10&&(this._rawPrevTime=0))}};e._kill=function(k,z){if("all"===k&&(k=null),null==k&&(null==z||z===this.target))return this._lazy=false,this._enabled(false,false);z="string"!=typeof z?z||this._targets||this.target:Q.selector(z)||z;var C,J,W,aa,xa,ba,Ga;if((N(z)||Wa(z))&&"number"!=typeof z[0])for(C=z.length;--C>-1;)this._kill(k,z[C])&&(ba=true);
else{if(this._targets)for(C=this._targets.length;--C>-1;){if(z===this._targets[C]){xa=this._propLookup[C]||{};this._overwrittenProps=this._overwrittenProps||[];J=this._overwrittenProps[C]=k?this._overwrittenProps[C]||{}:"all";break}}else{if(z!==this.target)return false;xa=this._propLookup;J=this._overwrittenProps=k?this._overwrittenProps||{}:"all"}if(xa){C=k||xa;Ga=k!==J&&"all"!==J&&k!==xa&&("object"!=typeof k||!k._tempKill);for(W in C){(aa=xa[W])&&(aa.pg&&aa.t._kill(C)&&(ba=true),aa.pg&&0!==aa.t._overwriteProps.length||
(aa._prev?aa._prev._next=aa._next:aa===this._firstPT&&(this._firstPT=aa._next),aa._next&&(aa._next._prev=aa._prev),aa._next=aa._prev=null),delete xa[W]);Ga&&(J[W]=1)}!this._firstPT&&this._initted&&this._enabled(false,false)}}return ba};e.invalidate=function(){return this._notifyPluginsOfEnabled&&Q._onPluginEvent("_onDisable",this),this._firstPT=null,this._overwrittenProps=null,this._onUpdate=null,this._startAt=null,this._initted=this._active=this._notifyPluginsOfEnabled=this._lazy=false,this._propLookup=
this._targets?{}:[],this};e._enabled=function(k,z){if(s||j.wake(),k&&this._gc){var C,J=this._targets;if(J)for(C=J.length;--C>-1;)this._siblings[C]=va(J[C],this,true);else this._siblings=va(this.target,this,true)}return Ia.prototype._enabled.call(this,k,z),this._notifyPluginsOfEnabled&&this._firstPT?Q._onPluginEvent(k?"_onEnable":"_onDisable",this):false};Q.to=function(k,z,C){return new Q(k,z,C)};Q.from=function(k,z,C){return C.runBackwards=true,C.immediateRender=0!=C.immediateRender,new Q(k,z,C)};
Q.fromTo=function(k,z,C,J){return J.startAt=C,J.immediateRender=0!=J.immediateRender&&0!=C.immediateRender,new Q(k,z,J)};Q.delayedCall=function(k,z,C,J,W){return new Q(z,0,{delay:k,onComplete:z,onCompleteParams:C,onCompleteScope:J,onReverseComplete:z,onReverseCompleteParams:C,onReverseCompleteScope:J,immediateRender:false,useFrames:W,overwrite:0})};Q.set=function(k,z){return new Q(k,0,z)};Q.getTweensOf=function(k,z){if(null==k)return[];k="string"!=typeof k?k:Q.selector(k)||k;var C,J,W,aa;if((N(k)||
Wa(k))&&"number"!=typeof k[0]){C=k.length;for(J=[];--C>-1;)J=J.concat(Q.getTweensOf(k[C],z));for(C=J.length;--C>-1;){aa=J[C];for(W=C;--W>-1;)aa===J[W]&&J.splice(C,1)}}else{J=va(k).concat();for(C=J.length;--C>-1;)(J[C]._gc||z&&!J[C].isActive())&&J.splice(C,1)}return J};Q.killTweensOf=Q.killDelayedCallsTo=function(k,z,C){"object"==typeof z&&(C=z,z=false);z=Q.getTweensOf(k,z);for(var J=z.length;--J>-1;)z[J]._kill(C,k)};var Ma=F("plugins.TweenPlugin",function(k,z){this._overwriteProps=(k||"").split(",");
this._propName=this._overwriteProps[0];this._priority=z||0;this._super=Ma.prototype},true);if(e=Ma.prototype,Ma.version="1.10.1",Ma.API=2,e._firstPT=null,e._addTween=function(k,z,C,J,W,aa){var xa,ba;return null!=J&&(xa="number"==typeof J||"="!==J.charAt(1)?Number(J)-C:parseInt(J.charAt(0)+"1",10)*Number(J.substr(2)))?(this._firstPT=ba={_next:this._firstPT,t:k,p:z,s:C,c:xa,f:"function"==typeof k[z],n:W||z,r:aa},ba._next&&(ba._next._prev=ba),ba):void 0},e.setRatio=function(k){for(var z,C=this._firstPT;C;){z=
C.c*k+C.s;C.r?z=Math.round(z):1.0E-6>z&&z>-1.0E-6&&(z=0);C.f?C.t[C.p](z):C.t[C.p]=z;C=C._next}},e._kill=function(k){var z,C=this._overwriteProps,J=this._firstPT;if(null!=k[this._propName])this._overwriteProps=[];else for(z=C.length;--z>-1;)null!=k[C[z]]&&C.splice(z,1);for(;J;){null!=k[J.n]&&(J._next&&(J._next._prev=J._prev),J._prev?(J._prev._next=J._next,J._prev=null):this._firstPT===J&&(this._firstPT=J._next));J=J._next}return false},e._roundProps=function(k,z){for(var C=this._firstPT;C;){(k[this._propName]||
null!=C.n&&k[C.n.split(this._propName+"_").join("")])&&(C.r=z);C=C._next}},Q._onPluginEvent=function(k,z){var C,J,W,aa,xa,ba=z._firstPT;if("_onInitAllProps"===k){for(;ba;){xa=ba._next;for(J=W;J&&J.pr>ba.pr;)J=J._next;(ba._prev=J?J._prev:aa)?ba._prev._next=ba:W=ba;(ba._next=J)?J._prev=ba:aa=ba;ba=xa}ba=z._firstPT=W}for(;ba;){ba.pg&&"function"==typeof ba.t[k]&&ba.t[k]()&&(C=true);ba=ba._next}return C},Ma.activate=function(k){for(var z=k.length;--z>-1;)k[z].API===Ma.API&&(Na[(new k[z])._propName]=k[z]);
return true},m.plugin=function(k){if(!(k&&k.propName&&k.init&&k.API))throw"illegal plugin definition.";var z,C=k.propName,J=k.priority||0,W=k.overwriteProps,aa={init:"_onInitTween",set:"setRatio",kill:"_kill",round:"_roundProps",initAll:"_onInitAllProps"},xa=F("plugins."+C.charAt(0).toUpperCase()+C.substr(1)+"Plugin",function(){Ma.call(this,C,J);this._overwriteProps=W||[]},k.global===true),ba=xa.prototype=new Ma(C);ba.constructor=xa;xa.API=k.API;for(z in aa)"function"==typeof k[z]&&(ba[aa[z]]=k[z]);
return xa.version=k.version,Ma.activate([xa]),xa},g=b._gsQueue){for(c=0;g.length>c;c++)g[c]();for(e in r)r[e].func||b.console.log("GSAP encountered missing dependency: com.greensock."+e)}s=false}})("undefined"!=typeof module&&module.exports&&"undefined"!=typeof global?global:this||window,"TweenLite");var _gsScope="undefined"!=typeof module&&module.exports&&"undefined"!=typeof global?global:this||window;
(_gsScope._gsQueue||(_gsScope._gsQueue=[])).push(function(){_gsScope._gsDefine("TimelineLite",["core.Animation","core.SimpleTimeline","TweenLite"],function(b,f,n){var g=function(r){f.call(this,r);this._labels={};this.autoRemoveChildren=this.vars.autoRemoveChildren===true;this.smoothChildTiming=this.vars.smoothChildTiming===true;this._sortChildren=true;this._onUpdate=this.vars.onUpdate;var x,m=this.vars;for(x in m){r=m[x];j(r)&&-1!==r.join("").indexOf("{self}")&&(m[x]=this._swapSelfInParams(r))}j(m.tweens)&&
this.add(m.tweens,0,m.align,m.stagger)},c=n._internals,e=c.isSelector,j=c.isArray,s=c.lazyTweens,w=c.lazyRender,K=[],p=_gsScope._gsDefine.globals,L=function(r){var x,m={};for(x in r)m[x]=r[x];return m},N=function(r,x,m,F){r._timeline.pause(r._startTime);x&&x.apply(F||r._timeline,m||K)};c=g.prototype=new f;return g.version="1.13.1",c.constructor=g,c.kill()._gc=false,c.to=function(r,x,m,F){var V=m.repeat&&p.TweenMax||n;return x?this.add(new V(r,x,m),F):this.set(r,m,F)},c.from=function(r,x,m,F){return this.add((m.repeat&&
p.TweenMax||n).from(r,x,m),F)},c.fromTo=function(r,x,m,F,V){var ha=F.repeat&&p.TweenMax||n;return x?this.add(ha.fromTo(r,x,m,F),V):this.set(r,F,V)},c.staggerTo=function(r,x,m,F,V,ha,ka,ta){ha=new g({onComplete:ha,onCompleteParams:ka,onCompleteScope:ta,smoothChildTiming:this.smoothChildTiming});"string"==typeof r&&(r=n.selector(r)||r);if(e(r)){ta=[];var Ka=r.length;for(ka=0;ka!==Ka;ta.push(r[ka++]));r=ta}F=F||0;for(ka=0;r.length>ka;ka++){m.startAt&&(m.startAt=L(m.startAt));ha.to(r[ka],x,L(m),ka*F)}return this.add(ha,
V)},c.staggerFrom=function(r,x,m,F,V,ha,ka,ta){return m.immediateRender=0!=m.immediateRender,m.runBackwards=true,this.staggerTo(r,x,m,F,V,ha,ka,ta)},c.staggerFromTo=function(r,x,m,F,V,ha,ka,ta,Ka){return F.startAt=m,F.immediateRender=0!=F.immediateRender&&0!=m.immediateRender,this.staggerTo(r,x,F,V,ha,ka,ta,Ka)},c.call=function(r,x,m,F){return this.add(n.delayedCall(0,r,x,m),F)},c.set=function(r,x,m){return m=this._parseTimeOrLabel(m,0,true),null==x.immediateRender&&(x.immediateRender=m===this._time&&
!this._paused),this.add(new n(r,0,x),m)},g.exportRoot=function(r,x){r=r||{};null==r.smoothChildTiming&&(r.smoothChildTiming=true);var m,F,V=new g(r),ha=V._timeline;null==x&&(x=true);ha._remove(V,true);V._startTime=0;V._rawPrevTime=V._time=V._totalTime=ha._time;for(m=ha._first;m;){F=m._next;x&&m instanceof n&&m.target===m.vars.onComplete||V.add(m,m._startTime-m._delay);m=F}return ha.add(V,0),V},c.add=function(r,x,m,F){var V,ha,ka;if("number"!=typeof x&&(x=this._parseTimeOrLabel(x,0,true,r)),!(r instanceof
b)){if(r instanceof Array||r&&r.push&&j(r)){m=m||"normal";F=F||0;V=r.length;for(ha=0;V>ha;ha++){j(ka=r[ha])&&(ka=new g({tweens:ka}));this.add(ka,x);"string"!=typeof ka&&"function"!=typeof ka&&("sequence"===m?x=ka._startTime+ka.totalDuration()/ka._timeScale:"start"===m&&(ka._startTime-=ka.delay()));x+=F}return this._uncache(true)}if("string"==typeof r)return this.addLabel(r,x);if("function"!=typeof r)throw"Cannot add "+r+" into the timeline; it is not a tween, timeline, function, or string.";r=n.delayedCall(0,
r)}if(f.prototype.add.call(this,r,x),(this._gc||this._time===this._duration)&&!this._paused&&this._duration<this.duration()){m=this;for(r=m.rawTime()>r._startTime;m._timeline;){r&&m._timeline.smoothChildTiming?m.totalTime(m._totalTime,true):m._gc&&m._enabled(true,false);m=m._timeline}}return this},c.remove=function(r){if(r instanceof b)return this._remove(r,false);if(r instanceof Array||r&&r.push&&j(r)){for(var x=r.length;--x>-1;)this.remove(r[x]);return this}return"string"==typeof r?this.removeLabel(r):
this.kill(null,r)},c._remove=function(r,x){f.prototype._remove.call(this,r,x);var m=this._last;return m?this._time>m._startTime+m._totalDuration/m._timeScale&&(this._time=this.duration(),this._totalTime=this._totalDuration):this._time=this._totalTime=this._duration=this._totalDuration=0,this},c.append=function(r,x){return this.add(r,this._parseTimeOrLabel(null,x,true,r))},c.insert=c.insertMultiple=function(r,x,m,F){return this.add(r,x||0,m,F)},c.appendMultiple=function(r,x,m,F){return this.add(r,
this._parseTimeOrLabel(null,x,true,r),m,F)},c.addLabel=function(r,x){return this._labels[r]=this._parseTimeOrLabel(x),this},c.addPause=function(r,x,m,F){return this.call(N,["{self}",x,m,F],this,r)},c.removeLabel=function(r){return delete this._labels[r],this},c.getLabelTime=function(r){return null!=this._labels[r]?this._labels[r]:-1},c._parseTimeOrLabel=function(r,x,m,F){var V;if(F instanceof b&&F.timeline===this)this.remove(F);else if(F&&(F instanceof Array||F.push&&j(F)))for(V=F.length;--V>-1;)F[V]instanceof
b&&F[V].timeline===this&&this.remove(F[V]);if("string"==typeof x)return this._parseTimeOrLabel(x,m&&"number"==typeof r&&null==this._labels[x]?r-this.duration():0,m);if(x=x||0,"string"!=typeof r||!isNaN(r)&&null==this._labels[r])null==r&&(r=this.duration());else{if(V=r.indexOf("="),-1===V)return null==this._labels[r]?m?this._labels[r]=this.duration()+x:x:this._labels[r]+x;x=parseInt(r.charAt(V-1)+"1",10)*Number(r.substr(V+1));r=V>1?this._parseTimeOrLabel(r.substr(0,V-1),0,m):this.duration()}return Number(r)+
x},c.seek=function(r,x){return this.totalTime("number"==typeof r?r:this._parseTimeOrLabel(r),x!==false)},c.stop=function(){return this.paused(true)},c.gotoAndPlay=function(r,x){return this.play(r,x)},c.gotoAndStop=function(r,x){return this.pause(r,x)},c.render=function(r,x,m){this._gc&&this._enabled(true,false);var F,V,ha,ka,ta=this._dirty?this.totalDuration():this._totalDuration,Ka=this._time,sa=this._startTime,qa=this._timeScale,Oa=this._paused;if(r>=ta?(this._totalTime=this._time=ta,this._reversed||
this._hasPausedChild()||(V=true,ka="onComplete",0===this._duration&&(0===r||0>this._rawPrevTime||this._rawPrevTime===1.0E-10)&&this._rawPrevTime!==r&&this._first&&this._rawPrevTime>1.0E-10&&(ka="onReverseComplete")),this._rawPrevTime=this._duration||!x||r||this._rawPrevTime===r?r:1.0E-10,r=ta+1.0E-4):1.0E-7>r?(this._totalTime=this._time=0,(0!==Ka||0===this._duration&&this._rawPrevTime!==1.0E-10&&(this._rawPrevTime>0||0>r&&this._rawPrevTime>=0))&&(ka="onReverseComplete",V=this._reversed),0>r?(this._active=
false,this._rawPrevTime=r):(this._rawPrevTime=this._duration||!x||r||this._rawPrevTime===r?r:1.0E-10,r=0,this._initted||(F=true))):this._totalTime=this._time=this._rawPrevTime=r,this._time!==Ka&&this._first||m||F){if(this._initted||(this._initted=true),this._active||!this._paused&&this._time!==Ka&&r>0&&(this._active=true),0===Ka&&this.vars.onStart&&0!==this._time&&(x||this.vars.onStart.apply(this.vars.onStartScope||this,this.vars.onStartParams||K)),this._time>=Ka)for(F=this._first;F&&(ha=F._next,
!this._paused||Oa);){(F._active||F._startTime<=this._time&&!F._paused&&!F._gc)&&(F._reversed?F.render((F._dirty?F.totalDuration():F._totalDuration)-(r-F._startTime)*F._timeScale,x,m):F.render((r-F._startTime)*F._timeScale,x,m));F=ha}else for(F=this._last;F&&(ha=F._prev,!this._paused||Oa);){(F._active||Ka>=F._startTime&&!F._paused&&!F._gc)&&(F._reversed?F.render((F._dirty?F.totalDuration():F._totalDuration)-(r-F._startTime)*F._timeScale,x,m):F.render((r-F._startTime)*F._timeScale,x,m));F=ha}this._onUpdate&&
(x||(s.length&&w(),this._onUpdate.apply(this.vars.onUpdateScope||this,this.vars.onUpdateParams||K)));ka&&(this._gc||(sa===this._startTime||qa!==this._timeScale)&&(0===this._time||ta>=this.totalDuration())&&(V&&(s.length&&w(),this._timeline.autoRemoveChildren&&this._enabled(false,false),this._active=false),!x&&this.vars[ka]&&this.vars[ka].apply(this.vars[ka+"Scope"]||this,this.vars[ka+"Params"]||K)))}},c._hasPausedChild=function(){for(var r=this._first;r;){if(r._paused||r instanceof g&&r._hasPausedChild())return true;
r=r._next}return false},c.getChildren=function(r,x,m,F){F=F||-9999999999;for(var V=[],ha=this._first,ka=0;ha;){F>ha._startTime||(ha instanceof n?x!==false&&(V[ka++]=ha):(m!==false&&(V[ka++]=ha),r!==false&&(V=V.concat(ha.getChildren(true,x,m)),ka=V.length)));ha=ha._next}return V},c.getTweensOf=function(r,x){var m,F,V=this._gc,ha=[],ka=0;V&&this._enabled(true,true);m=n.getTweensOf(r);for(F=m.length;--F>-1;)(m[F].timeline===this||x&&this._contains(m[F]))&&(ha[ka++]=m[F]);return V&&this._enabled(false,
true),ha},c._contains=function(r){for(r=r.timeline;r;){if(r===this)return true;r=r.timeline}return false},c.shiftChildren=function(r,x,m){m=m||0;for(var F,V=this._first,ha=this._labels;V;){V._startTime>=m&&(V._startTime+=r);V=V._next}if(x)for(F in ha)ha[F]>=m&&(ha[F]+=r);return this._uncache(true)},c._kill=function(r,x){if(!r&&!x)return this._enabled(false,false);for(var m=x?this.getTweensOf(x):this.getChildren(true,true,false),F=m.length,V=false;--F>-1;)m[F]._kill(r,x)&&(V=true);return V},c.clear=
function(r){var x=this.getChildren(false,true,true),m=x.length;for(this._time=this._totalTime=0;--m>-1;)x[m]._enabled(false,false);return r!==false&&(this._labels={}),this._uncache(true)},c.invalidate=function(){for(var r=this._first;r;){r.invalidate();r=r._next}return this},c._enabled=function(r,x){if(r===this._gc)for(var m=this._first;m;){m._enabled(r,true);m=m._next}return f.prototype._enabled.call(this,r,x)},c.duration=function(r){return arguments.length?(0!==this.duration()&&0!==r&&this.timeScale(this._duration/
r),this):(this._dirty&&this.totalDuration(),this._duration)},c.totalDuration=function(r){if(!arguments.length){if(this._dirty){var x,m,F=0;m=this._last;for(var V=999999999999;m;){x=m._prev;m._dirty&&m.totalDuration();m._startTime>V&&this._sortChildren&&!m._paused?this.add(m,m._startTime-m._delay):V=m._startTime;0>m._startTime&&!m._paused&&(F-=m._startTime,this._timeline.smoothChildTiming&&(this._startTime+=m._startTime/this._timeScale),this.shiftChildren(-m._startTime,false,-9999999999),V=0);m=m._startTime+
m._totalDuration/m._timeScale;m>F&&(F=m);m=x}this._duration=this._totalDuration=F;this._dirty=false}return this._totalDuration}return 0!==this.totalDuration()&&0!==r&&this.timeScale(this._totalDuration/r),this},c.usesFrames=function(){for(var r=this._timeline;r._timeline;)r=r._timeline;return r===b._rootFramesTimeline},c.rawTime=function(){return this._paused?this._totalTime:(this._timeline.rawTime()-this._startTime)*this._timeScale},g},true)});_gsScope._gsDefine&&_gsScope._gsQueue.pop()();
(function(b){var f=function(){return(_gsScope.GreenSockGlobals||_gsScope)[b]};"function"==typeof define&&define.amd?define(["TweenLite"],f):"undefined"!=typeof module&&module.exports&&(require("./TweenLite.js"),module.exports=f())})("TimelineLite");_gsScope="undefined"!=typeof module&&module.exports&&"undefined"!=typeof global?global:this||window;
(_gsScope._gsQueue||(_gsScope._gsQueue=[])).push(function(){_gsScope._gsDefine("easing.Back",["easing.Ease"],function(b){var f,n,g,c=_gsScope.GreenSockGlobals||_gsScope,e=2*Math.PI,j=Math.PI/2,s=c.com.greensock._class,w=function(m,F){var V=s("easing."+m,function(){},true),ha=V.prototype=new b;return ha.constructor=V,ha.getRatio=F,V},K=b.register||function(){},p=function(m,F,V,ha){F=s("easing."+m,{easeOut:new F,easeIn:new V,easeInOut:new ha},true);return K(F,m),F},L=function(m,F,V){this.t=m;this.v=
F;V&&(this.next=V,V.prev=this,this.c=V.v-F,this.gap=V.t-m)},N=function(m,F){var V=s("easing."+m,function(ka){this._p1=ka||0===ka?ka:1.70158;this._p2=1.525*this._p1},true),ha=V.prototype=new b;return ha.constructor=V,ha.getRatio=F,ha.config=function(ka){return new V(ka)},V};N=p("Back",N("BackOut",function(m){return(m-=1)*m*((this._p1+1)*m+this._p1)+1}),N("BackIn",function(m){return m*m*((this._p1+1)*m-this._p1)}),N("BackInOut",function(m){return 1>(m*=2)?0.5*m*m*((this._p2+1)*m-this._p2):0.5*((m-=
2)*m*((this._p2+1)*m+this._p2)+2)}));var r=s("easing.SlowMo",function(m,F,V){null==m?m=0.7:m>1&&(m=1);this._p=1!==m?F||0===F?F:0.7:0;this._p1=(1-m)/2;this._p2=m;this._p3=this._p1+this._p2;this._calcEnd=V===true},true),x=r.prototype=new b;return x.constructor=r,x.getRatio=function(m){var F=m+(0.5-m)*this._p;return this._p1>m?this._calcEnd?1-(m=1-m/this._p1)*m:F-(m=1-m/this._p1)*m*m*m*F:m>this._p3?this._calcEnd?1-(m=(m-this._p3)/this._p1)*m:F+(m-F)*(m=(m-this._p3)/this._p1)*m*m*m:this._calcEnd?1:F},
r.ease=new r(0.7,0.7),x.config=r.config=function(m,F,V){return new r(m,F,V)},f=s("easing.SteppedEase",function(m){m=m||1;this._p1=1/m;this._p2=m+1},true),x=f.prototype=new b,x.constructor=f,x.getRatio=function(m){return 0>m?m=0:m>=1&&(m=0.999999999),(this._p2*m>>0)*this._p1},x.config=f.config=function(m){return new f(m)},n=s("easing.RoughEase",function(m){m=m||{};for(var F,V,ha,ka,ta=m.taper||"none",Ka=[],sa=0,qa=ka=0|(m.points||20),Oa=m.randomize!==false,Aa=m.clamp===true,Sa=m.template instanceof
b?m.template:null,Ia="number"==typeof m.strength?0.4*m.strength:0.4;--qa>-1;){m=Oa?Math.random():1/ka*qa;F=Sa?Sa.getRatio(m):m;"none"===ta?V=Ia:"out"===ta?(ha=1-m,V=ha*ha*Ia):"in"===ta?V=m*m*Ia:0.5>m?(ha=2*m,V=0.5*ha*ha*Ia):(ha=2*(1-m),V=0.5*ha*ha*Ia);Oa?F+=Math.random()*V-0.5*V:qa%2?F+=0.5*V:F-=0.5*V;Aa&&(F>1?F=1:0>F&&(F=0));Ka[sa++]={x:m,y:F}}Ka.sort(function(La,Q){return La.x-Q.x});V=new L(1,1,null);for(qa=ka;--qa>-1;){ka=Ka[qa];V=new L(ka.x,ka.y,V)}this._prev=new L(0,0,0!==V.t?V:V.next)},true),
x=n.prototype=new b,x.constructor=n,x.getRatio=function(m){var F=this._prev;if(m>F.t){for(;F.next&&m>=F.t;)F=F.next;F=F.prev}else for(;F.prev&&F.t>=m;)F=F.prev;return this._prev=F,F.v+(m-F.t)/F.gap*F.c},x.config=function(m){return new n(m)},n.ease=new n,p("Bounce",w("BounceOut",function(m){return 1/2.75>m?7.5625*m*m:2/2.75>m?7.5625*(m-=1.5/2.75)*m+0.75:2.5/2.75>m?7.5625*(m-=2.25/2.75)*m+0.9375:7.5625*(m-=2.625/2.75)*m+0.984375}),w("BounceIn",function(m){return 1/2.75>(m=1-m)?1-7.5625*m*m:2/2.75>m?
1-(7.5625*(m-=1.5/2.75)*m+0.75):2.5/2.75>m?1-(7.5625*(m-=2.25/2.75)*m+0.9375):1-(7.5625*(m-=2.625/2.75)*m+0.984375)}),w("BounceInOut",function(m){var F=0.5>m;return m=F?1-2*m:2*m-1,m=1/2.75>m?7.5625*m*m:2/2.75>m?7.5625*(m-=1.5/2.75)*m+0.75:2.5/2.75>m?7.5625*(m-=2.25/2.75)*m+0.9375:7.5625*(m-=2.625/2.75)*m+0.984375,F?0.5*(1-m):0.5*m+0.5})),p("Circ",w("CircOut",function(m){return Math.sqrt(1-(m-=1)*m)}),w("CircIn",function(m){return-(Math.sqrt(1-m*m)-1)}),w("CircInOut",function(m){return 1>(m*=2)?-0.5*
(Math.sqrt(1-m*m)-1):0.5*(Math.sqrt(1-(m-=2)*m)+1)})),g=function(m,F,V){var ha=s("easing."+m,function(ka,ta){this._p1=ka||1;this._p2=ta||V;this._p3=this._p2/e*(Math.asin(1/this._p1)||0)},true);m=ha.prototype=new b;return m.constructor=ha,m.getRatio=F,m.config=function(ka,ta){return new ha(ka,ta)},ha},p("Elastic",g("ElasticOut",function(m){return this._p1*Math.pow(2,-10*m)*Math.sin((m-this._p3)*e/this._p2)+1},0.3),g("ElasticIn",function(m){return-(this._p1*Math.pow(2,10*(m-=1))*Math.sin((m-this._p3)*
e/this._p2))},0.3),g("ElasticInOut",function(m){return 1>(m*=2)?-0.5*this._p1*Math.pow(2,10*(m-=1))*Math.sin((m-this._p3)*e/this._p2):0.5*this._p1*Math.pow(2,-10*(m-=1))*Math.sin((m-this._p3)*e/this._p2)+1},0.45)),p("Expo",w("ExpoOut",function(m){return 1-Math.pow(2,-10*m)}),w("ExpoIn",function(m){return Math.pow(2,10*(m-1))-0.0010}),w("ExpoInOut",function(m){return 1>(m*=2)?0.5*Math.pow(2,10*(m-1)):0.5*(2-Math.pow(2,-10*(m-1)))})),p("Sine",w("SineOut",function(m){return Math.sin(m*j)}),w("SineIn",
function(m){return-Math.cos(m*j)+1}),w("SineInOut",function(m){return-0.5*(Math.cos(Math.PI*m)-1)})),s("easing.EaseLookup",{find:function(m){return b.map[m]}},true),K(c.SlowMo,"SlowMo","ease,"),K(n,"RoughEase","ease,"),K(f,"SteppedEase","ease,"),N},true)});_gsScope._gsDefine&&_gsScope._gsQueue.pop()();_gsScope="undefined"!=typeof module&&module.exports&&"undefined"!=typeof global?global:this||window;
(_gsScope._gsQueue||(_gsScope._gsQueue=[])).push(function(){_gsScope._gsDefine("plugins.CSSPlugin",["plugins.TweenPlugin","TweenLite"],function(b,f){var n,g,c,e,j=function(){b.call(this,"css");this._overwriteProps.length=0;this.setRatio=j.prototype.setRatio},s={},w=j.prototype=new b("css");w.constructor=j;j.version="1.13.0";j.API=2;j.defaultTransformPerspective=0;j.defaultSkewType="compensated";w="px";j.suffixMap={top:w,right:w,bottom:w,left:w,width:w,height:w,fontSize:w,padding:w,margin:w,perspective:w,
lineHeight:""};var K,p,L,N,r,x,m=/(?:\d|\-\d|\.\d|\-\.\d)+/g,F=/(?:\d|\-\d|\.\d|\-\.\d|\+=\d|\-=\d|\+=.\d|\-=\.\d)+/g,V=/(?:\+=|\-=|\-|\b)[\d\-\.]+[a-zA-Z0-9]*(?:%|\b)/gi,ha=/[^\d\-\.]/g,ka=/(?:\d|\-|\+|=|#|\.)*/g,ta=/opacity *= *([^)]*)/i,Ka=/opacity:([^;]*)/i,sa=/alpha\(opacity *=.+?\)/i,qa=/^(rgb|hsl)/,Oa=/([A-Z])/g,Aa=/-([a-z])/gi,Sa=/(^(?:url\(\"|url\())|(?:(\"\))$|\)$)/gi,Ia=function(l,q){return q.toUpperCase()},La=/(?:Left|Right|Width)/i,Q=/(M11|M12|M21|M22)=[\d\-\.e]+/gi,Wa=/progid\:DXImageTransform\.Microsoft\.Matrix\(.+?\)/i,
Ra=/,(?=[^\)]*(?:\(|$))/gi,za=Math.PI/180,Na=180/Math.PI,O={},Z=document,fa=Z.createElement("div"),na=Z.createElement("img"),I=j._internals={_specialProps:s},P=navigator.userAgent,ca=function(){var l,q=P.indexOf("Android"),v=Z.createElement("div");return L=-1!==P.indexOf("Safari")&&-1===P.indexOf("Chrome")&&(-1===q||Number(P.substr(q+8,1))>3),r=L&&6>Number(P.substr(P.indexOf("Version/")+8,1)),N=-1!==P.indexOf("Firefox"),/MSIE ([0-9]{1,}[\.0-9]{0,})/.exec(P)&&(x=parseFloat(RegExp.$1)),v.innerHTML=
"<a style='top:1px;opacity:.55;'>a</a>",l=v.getElementsByTagName("a")[0],l?/^0.55/.test(l.style.opacity):false}(),va=function(l){return ta.test("string"==typeof l?l:(l.currentStyle?l.currentStyle.filter:l.style.filter)||"")?parseFloat(RegExp.$1)/100:1},Qa="",Pa="",Ma=function(l,q){q=q||fa;var v,y,t=q.style;if(void 0!==t[l])return l;l=l.charAt(0).toUpperCase()+l.substr(1);v=["O","Moz","ms","Ms","Webkit"];for(y=5;--y>-1&&void 0===t[v[y]+l];);return y>=0?(Pa=3===y?"ms":v[y],Qa="-"+Pa.toLowerCase()+"-",
Pa+l):null},k=Z.defaultView?Z.defaultView.getComputedStyle:function(){},z=j.getStyle=function(l,q,v,y,t){var B;return ca||"opacity"!==q?(!y&&l.style[q]||((v=v||k(l))?v[q]||v.getPropertyValue(q)||v.getPropertyValue(q.replace(Oa,"-$1").toLowerCase()):l.currentStyle&&(B=l.currentStyle[q])),null==t||B&&"none"!==B&&"auto"!==B&&"auto auto"!==B?B:t):va(l)},C=I.convertToPixels=function(l,q,v,y,t){if("px"===y||!y)return v;if("auto"===y||!v)return 0;var B,A,E,M=La.test(q),Y=l;B=fa.style;var $=0>v;if($&&(v=
-v),"%"===y&&-1!==q.indexOf("border"))B=v/100*(M?l.clientWidth:l.clientHeight);else{if(B.cssText="border:0 solid red;position:"+z(l,"position")+";line-height:0;","%"!==y&&Y.appendChild)B[M?"borderLeftWidth":"borderTopWidth"]=v+y;else{if(Y=l.parentNode||Z.body,A=Y._gsCache,E=f.ticker.frame,A&&M&&A.time===E)return A.width*v/100;B[M?"width":"height"]=v+y}Y.appendChild(fa);B=parseFloat(fa[M?"offsetWidth":"offsetHeight"]);Y.removeChild(fa);M&&"%"===y&&j.cacheWidths!==false&&(A=Y._gsCache=Y._gsCache||{},
A.time=E,A.width=100*(B/v));0!==B||t||(B=C(l,q,v,y,true))}return $?-B:B},J=I.calculateOffset=function(l,q,v){if("absolute"!==z(l,"position",v))return 0;var y="left"===q?"Left":"Top";v=z(l,"margin"+y,v);return l["offset"+y]-(C(l,q,parseFloat(v),v.replace(ka,""))||0)},W=function(l,q){var v,y,t={};if(q=q||k(l,null))if(v=q.length)for(;--v>-1;)t[q[v].replace(Aa,Ia)]=q.getPropertyValue(q[v]);else for(v in q)t[v]=q[v];else if(q=l.currentStyle||l.style)for(v in q)"string"==typeof v&&void 0===t[v]&&(t[v.replace(Aa,
Ia)]=q[v]);return ca||(t.opacity=va(l)),y=Ha(l,q,false),t.rotation=y.rotation,t.skewX=y.skewX,t.scaleX=y.scaleX,t.scaleY=y.scaleY,t.x=y.x,t.y=y.y,da&&(t.z=y.z,t.rotationX=y.rotationX,t.rotationY=y.rotationY,t.scaleZ=y.scaleZ),t.filters&&delete t.filters,t},aa=function(l,q,v,y,t){var B,A,E,M={},Y=l.style;for(A in v)"cssText"!==A&&"length"!==A&&isNaN(A)&&(q[A]!==(B=v[A])||t&&t[A])&&-1===A.indexOf("Origin")&&("number"==typeof B||"string"==typeof B)&&(M[A]="auto"!==B||"left"!==A&&"top"!==A?""!==B&&"auto"!==
B&&"none"!==B||"string"!=typeof q[A]||""===q[A].replace(ha,"")?B:0:J(l,A),void 0!==Y[A]&&(E=new R(Y,A,Y[A],E)));if(y)for(A in y)"className"!==A&&(M[A]=y[A]);return{difs:M,firstMPT:E}},xa={width:["Left","Right"],height:["Top","Bottom"]},ba=["marginLeft","marginRight","marginTop","marginBottom"],Ga=function(l,q){(null==l||""===l||"auto"===l||"auto auto"===l)&&(l="0 0");var v=l.split(" "),y=-1!==l.indexOf("left")?"0%":-1!==l.indexOf("right")?"100%":v[0],t=-1!==l.indexOf("top")?"0%":-1!==l.indexOf("bottom")?
"100%":v[1];return null==t?t="0":"center"===t&&(t="50%"),("center"===y||isNaN(parseFloat(y))&&-1===(y+"").indexOf("="))&&(y="50%"),q&&(q.oxp=-1!==y.indexOf("%"),q.oyp=-1!==t.indexOf("%"),q.oxr="="===y.charAt(1),q.oyr="="===t.charAt(1),q.ox=parseFloat(y.replace(ha,"")),q.oy=parseFloat(t.replace(ha,""))),y+" "+t+(v.length>2?" "+v[2]:"")},Da=function(l,q){return"string"==typeof l&&"="===l.charAt(1)?parseInt(l.charAt(0)+"1",10)*parseFloat(l.substr(2)):parseFloat(l)-parseFloat(q)},Ta=function(l,q){return null==
l?q:"string"==typeof l&&"="===l.charAt(1)?parseInt(l.charAt(0)+"1",10)*Number(l.substr(2))+q:parseFloat(l)},d=function(l,q,v,y){var t,B,A;return null==l||"number"==typeof l||(t=l.split("_"),B=Number(t[0].replace(ha,""))*(-1===l.indexOf("rad")?1:Na)-("="===l.charAt(1)?0:q),t.length&&(y&&(y[v]=q+B),-1!==l.indexOf("short")&&(B%=360,B!==B%180&&(B=0>B?B+360:B-360)),-1!==l.indexOf("_cw")&&0>B?B=(B+3599999999640)%360-(0|B/360)*360:-1!==l.indexOf("ccw")&&B>0&&(B=(B-3599999999640)%360-(0|B/360)*360)),A=q+
B),1.0E-6>A&&A>-1.0E-6&&(A=0),A},a={aqua:[0,255,255],lime:[0,255,0],silver:[192,192,192],black:[0,0,0],maroon:[128,0,0],teal:[0,128,128],blue:[0,0,255],navy:[0,0,128],white:[255,255,255],fuchsia:[255,0,255],olive:[128,128,0],yellow:[255,255,0],orange:[255,165,0],gray:[128,128,128],purple:[128,0,128],green:[0,128,0],red:[255,0,0],pink:[255,192,203],cyan:[0,255,255],transparent:[255,255,255,0]},h=function(l,q,v){return l=0>l?l+1:l>1?l-1:l,0|255*(1>6*l?q+6*(v-q)*l:0.5>l?v:2>3*l?q+6*(v-q)*(2/3-l):q)+
0.5},u=function(l){var q,v,y,t,B,A;return l&&""!==l?"number"==typeof l?[l>>16,255&l>>8,255&l]:(","===l.charAt(l.length-1)&&(l=l.substr(0,l.length-1)),a[l]?a[l]:"#"===l.charAt(0)?(4===l.length&&(q=l.charAt(1),v=l.charAt(2),y=l.charAt(3),l="#"+q+q+v+v+y+y),l=parseInt(l.substr(1),16),[l>>16,255&l>>8,255&l]):"hsl"===l.substr(0,3)?(l=l.match(m),t=Number(l[0])%360/360,B=Number(l[1])/100,A=Number(l[2])/100,v=0.5>=A?A*(B+1):A+B-A*B,q=2*A-v,l.length>3&&(l[3]=Number(l[3])),l[0]=h(t+1/3,q,v),l[1]=h(t,q,v),l[2]=
h(t-1/3,q,v),l):(l=l.match(m)||a.transparent,l[0]=Number(l[0]),l[1]=Number(l[1]),l[2]=Number(l[2]),l.length>3&&(l[3]=Number(l[3])),l)):a.black},D="(?:\\b(?:(?:rgb|rgba|hsl|hsla)\\(.+?\\))|\\B#.+?\\b";for(w in a)D+="|"+w+"\\b";D=RegExp(D+")","gi");var G=function(l,q,v,y){if(null==l)return function(ja){return ja};var t,B=q?(l.match(D)||[""])[0]:"",A=l.split(B).join("").match(V)||[],E=l.substr(0,l.indexOf(A[0])),M=")"===l.charAt(l.length-1)?")":"",Y=-1!==l.indexOf(" ")?" ":",",$=A.length,ra=$>0?A[0].replace(m,
""):"";return $?t=q?function(ja){var ya,Ea,ma;if("number"==typeof ja)ja+=ra;else if(y&&Ra.test(ja)){ja=ja.replace(Ra,"|").split("|");for(ma=0;ja.length>ma;ma++)ja[ma]=t(ja[ma]);return ja.join(",")}if(ya=(ja.match(D)||[B])[0],Ea=ja.split(ya).join("").match(V)||[],ma=Ea.length,$>ma--)for(;$>++ma;)Ea[ma]=v?Ea[0|(ma-1)/2]:A[ma];return E+Ea.join(Y)+Y+ya+M+(-1!==ja.indexOf("inset")?" inset":"")}:function(ja){var ya,Ea;if("number"==typeof ja)ja+=ra;else if(y&&Ra.test(ja)){ja=ja.replace(Ra,"|").split("|");
for(Ea=0;ja.length>Ea;Ea++)ja[Ea]=t(ja[Ea]);return ja.join(",")}if(ya=ja.match(V)||[],Ea=ya.length,$>Ea--)for(;$>++Ea;)ya[Ea]=v?ya[0|(Ea-1)/2]:A[Ea];return E+ya.join(Y)+M}:function(ja){return ja}},S=function(l){return l=l.split(","),function(q,v,y,t,B,A,E){y=(v+"").split(" ");E={};for(v=0;4>v;v++)E[l[v]]=y[v]=y[v]||y[(v-1)/2>>0];return t.parse(q,E,B,A)}},R=(I._setPluginRatio=function(l){this.plugin.setRatio(l);for(var q,v,y=this.data,t=y.proxy,B=y.firstMPT;B;){q=t[B.v];B.r?q=Math.round(q):1.0E-6>
q&&q>-1.0E-6&&(q=0);B.t[B.p]=q;B=B._next}if(y.autoRotate&&(y.autoRotate.rotation=t.rotation),1===l)for(B=y.firstMPT;B;){if(v=B.t,v.type){if(1===v.type){q=v.xs0+v.s+v.xs1;for(l=1;v.l>l;l++)q+=v["xn"+l]+v["xs"+(l+1)];v.e=q}}else v.e=v.s+v.xs0;B=B._next}},function(l,q,v,y,t){this.t=l;this.p=q;this.v=v;this.r=t;y&&(y._prev=this,this._next=y)}),H=(I._parseToProxy=function(l,q,v,y,t,B){var A,E,M,Y=y,$={},ra={};E=v._transform;var ja=O;v._transform=null;O=q;y=l=v.parse(l,q,y,t);O=ja;for(B&&(v._transform=
E,Y&&(Y._prev=null,Y._prev&&(Y._prev._next=null)));y&&y!==Y;){if(1>=y.type&&(A=y.p,ra[A]=y.s+y.c,$[A]=y.s,B||(M=new R(y,"s",A,M,y.r),y.c=0),1===y.type))for(v=y.l;--v>0;){E="xn"+v;A=y.p+"_"+E;ra[A]=y.data[E];$[A]=y[E];B||(M=new R(y,E,A,M,y.rxp[E]))}y=y._next}return{proxy:$,end:ra,firstMPT:M,pt:l}},I.CSSPropTween=function(l,q,v,y,t,B,A,E,M,Y,$){this.t=l;this.p=q;this.s=v;this.c=y;this.n=A||q;l instanceof H||e.push(this.n);this.r=E;this.type=B||0;M&&(this.pr=M,n=true);this.b=void 0===Y?v:Y;this.e=void 0===
$?v+y:$;t&&(this._next=t,t._prev=this)}),ea=j.parseComplex=function(l,q,v,y,t,B,A,E,M,Y){v=v||B||"";A=new H(l,q,0,0,A,Y?2:1,null,false,E,v,y);y+="";var $,ra,ja,ya,Ea;l=v.split(", ").join(",").split(" ");q=y.split(", ").join(",").split(" ");E=l.length;var ma=K!==false;(-1!==y.indexOf(",")||-1!==v.indexOf(","))&&(l=l.join(" ").replace(Ra,", ").split(" "),q=q.join(" ").replace(Ra,", ").split(" "),E=l.length);E!==q.length&&(l=(B||"").split(" "),E=l.length);A.plugin=M;A.setRatio=Y;for(v=0;E>v;v++)if($=
l[v],M=q[v],ja=parseFloat($),ja||0===ja)A.appendXtra("",ja,Da(M,ja),M.replace(F,""),ma&&-1!==M.indexOf("px"),true);else if(t&&("#"===$.charAt(0)||a[$]||qa.test($))){Y=","===M.charAt(M.length-1)?"),":")";$=u($);M=u(M);(B=$.length+M.length>6)&&!ca&&0===M[3]?(A["xs"+A.l]+=A.l?" transparent":"transparent",A.e=A.e.split(q[v]).join("transparent")):(ca||(B=false),A.appendXtra(B?"rgba(":"rgb(",$[0],M[0]-$[0],",",true,true).appendXtra("",$[1],M[1]-$[1],",",true).appendXtra("",$[2],M[2]-$[2],B?",":Y,true),
B&&($=4>$.length?1:$[3],A.appendXtra("",$,(4>M.length?1:M[3])-$,Y,false)))}else if(B=$.match(m)){if(ra=M.match(F),!ra||ra.length!==B.length)return A;for(M=Y=0;B.length>M;M++){Ea=B[M];ya=$.indexOf(Ea,Y);A.appendXtra($.substr(Y,ya-Y),Number(Ea),Da(ra[M],Ea),"",ma&&"px"===$.substr(ya+Ea.length,2),0===M);Y=ya+Ea.length}A["xs"+A.l]+=$.substr(Y)}else A["xs"+A.l]+=A.l?" "+$:$;if(-1!==y.indexOf("=")&&A.data){Y=A.xs0+A.data.s;for(v=1;A.l>v;v++)Y+=A["xs"+v]+A.data["xn"+v];A.e=Y+A["xs"+v]}return A.l||(A.type=
-1,A.xs0=A.e),A.xfirst||A},U=9;w=H.prototype;for(w.l=w.pr=0;--U>0;){w["xn"+U]=0;w["xs"+U]=""}w.xs0="";w._next=w._prev=w.xfirst=w.data=w.plugin=w.setRatio=w.rxp=null;w.appendXtra=function(l,q,v,y,t,B){var A=this.l;return this["xs"+A]+=B&&A?" "+l:l||"",v||0===A||this.plugin?(this.l++,this.type=this.setRatio?2:1,this["xs"+this.l]=y||"",A>0?(this.data["xn"+A]=q+v,this.rxp["xn"+A]=t,this["xn"+A]=q,this.plugin||(this.xfirst=new H(this,"xn"+A,q,v,this.xfirst||this,0,this.n,t,this.pr),this.xfirst.xs0=0),
this):(this.data={s:q+v},this.rxp={},this.s=q,this.c=v,this.r=t,this)):(this["xs"+A]+=q+(y||""),this)};var o=function(l,q){q=q||{};this.p=q.prefix?Ma(l)||l:l;s[l]=s[this.p]=this;this.format=q.formatter||G(q.defaultValue,q.color,q.collapsible,q.multi);q.parser&&(this.parse=q.parser);this.clrs=q.color;this.multi=q.multi;this.keyword=q.keyword;this.dflt=q.defaultValue;this.pr=q.priority||0},ga=I._registerComplexSpecialProp=function(l,q,v){"object"!=typeof q&&(q={parser:v});var y=l.split(","),t=q.defaultValue;
v=v||[t];for(l=0;y.length>l;l++){q.prefix=0===l&&q.prefix;q.defaultValue=v[l]||t;new o(y[l],q)}},ua=function(l){if(!s[l]){var q=l.charAt(0).toUpperCase()+l.substr(1)+"Plugin";ga(l,{parser:function(v,y,t,B,A,E,M){var Y=(_gsScope.GreenSockGlobals||_gsScope).com.greensock.plugins[q];if(Y)v=(Y._cssRegister(),s[t].parse(v,y,t,B,A,E,M));else{window.console&&console.log("Error: "+q+" js file not loaded.");v=A}return v}})}};w=o.prototype;w.parseComplex=function(l,q,v,y,t,B){var A,E,M,Y,$,ra,ja=this.keyword;
if(this.multi&&(Ra.test(v)||Ra.test(q)?(E=q.replace(Ra,"|").split("|"),M=v.replace(Ra,"|").split("|")):ja&&(E=[q],M=[v])),M){Y=M.length>E.length?M.length:E.length;for(A=0;Y>A;A++){q=E[A]=E[A]||this.dflt;v=M[A]=M[A]||this.dflt;ja&&($=q.indexOf(ja),ra=v.indexOf(ja),$!==ra&&(v=-1===ra?M:E,v[A]+=" "+ja))}q=E.join(", ");v=M.join(", ")}return ea(l,this.p,q,v,this.clrs,this.dflt,y,this.pr,t,B)};w.parse=function(l,q,v,y,t,B){return this.parseComplex(l.style,this.format(z(l,this.p,c,false,this.dflt)),this.format(q),
t,B)};j.registerSpecialProp=function(l,q,v){ga(l,{parser:function(y,t,B,A,E,M){E=new H(y,B,0,0,E,2,B,false,v);return E.plugin=M,E.setRatio=q(y,t,A._tween,B),E},priority:v})};var Fa="scaleX,scaleY,scaleZ,x,y,z,skewX,skewY,rotation,rotationX,rotationY,perspective,xPercent,yPercent".split(","),la=Ma("transform"),oa=Qa+"transform",X=Ma("transformOrigin"),da=null!==Ma("perspective"),Ca=I.Transform=function(){this.skewY=0},Ha=I.getTransform=function(l,q,v,y){if(l._gsTransform&&v&&!y)return l._gsTransform;
var t,B,A,E,M,Y,$,ra,ja,ya,Ea,ma=v?l._gsTransform||new Ca:new Ca,Ua=0>ma.scaleX;M=179.99*za;var Ya=da?parseFloat(z(l,X,q,false,"0 0 0").split(" ")[2])||ma.zOrigin||0:0;if(la?t=z(l,oa,q,true):l.currentStyle&&(t=l.currentStyle.filter.match(Q),t=t&&4===t.length?[t[0].substr(4),Number(t[2].substr(4)),Number(t[1].substr(4)),t[3].substr(4),ma.x||0,ma.y||0].join(","):""),t&&"none"!==t&&"matrix(1, 0, 0, 1, 0, 0)"!==t){B=(t||"").match(/(?:\-|\b)[\d\-\.e]+\b/gi)||[];for(t=B.length;--t>-1;){A=Number(B[t]);B[t]=
(E=A-(A|=0))?(0|E*1E5+(0>E?-0.5:0.5))/1E5+A:A}if(16===B.length){Ua=B[8];q=B[9];E=B[10];A=B[12];var Za=B[13],fb=B[14];if(ma.zOrigin&&(fb=-ma.zOrigin,A=Ua*fb-B[12],Za=q*fb-B[13],fb=E*fb+ma.zOrigin-B[14]),!v||y||null==ma.rotationX){var ib;y=B[0];var gb=B[1],Va=B[2],lb=B[3],eb=B[4],bb=B[5],db=B[6],hb=B[7];B=B[11];var $a=Math.atan2(db,E),kb=-M>$a||$a>M;ma.rotationX=$a*Na;$a&&(ja=Math.cos(-$a),ya=Math.sin(-$a),Y=eb*ja+Ua*ya,$=bb*ja+q*ya,ra=db*ja+E*ya,Ua=eb*-ya+Ua*ja,q=bb*-ya+q*ja,E=db*-ya+E*ja,B=hb*-ya+
B*ja,eb=Y,bb=$,db=ra);$a=Math.atan2(Ua,y);ma.rotationY=$a*Na;$a&&(Ea=-M>$a||$a>M,ja=Math.cos(-$a),ya=Math.sin(-$a),Y=y*ja-Ua*ya,$=gb*ja-q*ya,ra=Va*ja-E*ya,q=gb*ya+q*ja,E=Va*ya+E*ja,B=lb*ya+B*ja,y=Y,gb=$,Va=ra);$a=Math.atan2(gb,bb);ma.rotation=$a*Na;$a&&(ib=-M>$a||$a>M,ja=Math.cos(-$a),ya=Math.sin(-$a),y=y*ja+eb*ya,$=gb*ja+bb*ya,bb=gb*-ya+bb*ja,db=Va*-ya+db*ja,gb=$);ib&&kb?ma.rotation=ma.rotationX=0:ib&&Ea?ma.rotation=ma.rotationY=0:Ea&&kb&&(ma.rotationY=ma.rotationX=0);ma.scaleX=(0|Math.sqrt(y*y+
gb*gb)*1E5+0.5)/1E5;ma.scaleY=(0|Math.sqrt(bb*bb+q*q)*1E5+0.5)/1E5;ma.scaleZ=(0|Math.sqrt(db*db+E*E)*1E5+0.5)/1E5;ma.skewX=0;ma.perspective=B?1/(0>B?-B:B):0;ma.x=A;ma.y=Za;ma.z=fb}}else if(!(da&&!y&&B.length&&ma.x===B[4]&&ma.y===B[5]&&(ma.rotationX||ma.rotationY)||void 0!==ma.x&&"none"===z(l,"display",q))){Y=(M=B.length>=6)?B[0]:1;ra=B[1]||0;$=B[2]||0;ja=M?B[3]:1;ma.x=B[4]||0;ma.y=B[5]||0;B=Math.sqrt(Y*Y+ra*ra);M=Math.sqrt(ja*ja+$*$);Y=Y||ra?Math.atan2(ra,Y)*Na:ma.rotation||0;$=$||ja?Math.atan2($,
ja)*Na+Y:ma.skewX||0;ra=B-Math.abs(ma.scaleX||0);ja=M-Math.abs(ma.scaleY||0);Math.abs($)>90&&270>Math.abs($)&&(Ua?(B*=-1,$+=0>=Y?180:-180,Y+=0>=Y?180:-180):(M*=-1,$+=0>=$?180:-180));ya=(Y-ma.rotation)%180;Ea=($-ma.skewX)%180;(void 0===ma.skewX||ra>2.0E-5||-2.0E-5>ra||ja>2.0E-5||-2.0E-5>ja||ya>-179.99&&179.99>ya&&false|ya*1E5||Ea>-179.99&&179.99>Ea&&false|Ea*1E5)&&(ma.scaleX=B,ma.scaleY=M,ma.rotation=Y,ma.skewX=$);da&&(ma.rotationX=ma.rotationY=ma.z=0,ma.perspective=parseFloat(j.defaultTransformPerspective)||
0,ma.scaleZ=1)}ma.zOrigin=Ya;for(t in ma)2.0E-5>ma[t]&&ma[t]>-2.0E-5&&(ma[t]=0)}else ma={x:0,y:0,z:0,scaleX:1,scaleY:1,scaleZ:1,skewX:0,perspective:0,rotation:0,rotationX:0,rotationY:0,zOrigin:0};return v&&(l._gsTransform=ma),ma.xPercent=ma.yPercent=0,ma},Xa=function(l){var q,v,y=this.data,t=-y.rotation*za,B=t+y.skewX*za,A=(0|Math.cos(t)*y.scaleX*1E5)/1E5,E=(0|Math.sin(t)*y.scaleX*1E5)/1E5,M=(0|Math.sin(B)*-y.scaleY*1E5)/1E5,Y=(0|Math.cos(B)*y.scaleY*1E5)/1E5;B=this.t.style;if(t=this.t.currentStyle){v=
E;E=-M;M=-v;q=t.filter;B.filter="";var $,ra;v=this.t.offsetWidth;var ja=this.t.offsetHeight,ya="absolute"!==t.position,Ea="progid:DXImageTransform.Microsoft.Matrix(M11="+A+", M12="+E+", M21="+M+", M22="+Y,ma=y.x+v*y.xPercent/100,Ua=y.y+ja*y.yPercent/100;if(null!=y.ox&&($=(y.oxp?0.01*v*y.ox:y.ox)-v/2,ra=(y.oyp?0.01*ja*y.oy:y.oy)-ja/2,ma+=$-($*A+ra*E),Ua+=ra-($*M+ra*Y)),ya?($=v/2,ra=ja/2,Ea+=", Dx="+($-($*A+ra*E)+ma)+", Dy="+(ra-($*M+ra*Y)+Ua)+")"):Ea+=", sizingMethod='auto expand')",B.filter=-1!==
q.indexOf("DXImageTransform.Microsoft.Matrix(")?q.replace(Wa,Ea):Ea+" "+q,(0===l||1===l)&&1===A&&0===E&&0===M&&1===Y&&(ya&&-1===Ea.indexOf("Dx=0, Dy=0")||ta.test(q)&&100!==parseFloat(RegExp.$1)||-1===q.indexOf(q.indexOf("Alpha"))&&B.removeAttribute("filter")),!ya){l=8>x?1:-1;$=y.ieOffsetX||0;ra=y.ieOffsetY||0;y.ieOffsetX=Math.round((v-((0>A?-A:A)*v+(0>E?-E:E)*ja))/2+ma);y.ieOffsetY=Math.round((ja-((0>Y?-Y:Y)*ja+(0>M?-M:M)*v))/2+Ua);for(U=0;4>U;U++){A=ba[U];E=t[A];v=-1!==E.indexOf("px")?parseFloat(E):
C(this.t,A,parseFloat(E),E.replace(ka,""))||0;E=v!==y[A]?2>U?-y.ieOffsetX:-y.ieOffsetY:2>U?$-y.ieOffsetX:ra-y.ieOffsetY;B[A]=(y[A]=Math.round(v-E*(0===U||2===U?1:l)))+"px"}}}},Ba=I.set3DTransformRatio=function(l){var q,v,y,t,B,A,E,M,Y,$,ra,ja,ya,Ea,ma,Ua,Ya,Za,fb,ib,gb,Va=this.data,lb=this.t.style,eb=Va.rotation*za,bb=Va.scaleX,db=Va.scaleY,hb=Va.scaleZ,$a=Va.x,kb=Va.y,mb=Va.z,jb=Va.perspective;if(!(1!==l&&0!==l||"auto"!==Va.force3D||Va.rotationY||Va.rotationX||1!==hb||jb||mb))return cb.call(this,
l),void 0;if(N){1.0E-4>bb&&bb>-1.0E-4&&(bb=hb=2.0E-5);1.0E-4>db&&db>-1.0E-4&&(db=hb=2.0E-5);!jb||Va.z||Va.rotationX||Va.rotationY||(jb=0)}if(eb||Va.skewX){Ua=Math.cos(eb);Ya=Math.sin(eb);l=Ua;t=Ya;Va.skewX&&(eb-=Va.skewX*za,Ua=Math.cos(eb),Ya=Math.sin(eb),"simple"===Va.skewType&&(Za=Math.tan(Va.skewX*za),Za=Math.sqrt(1+Za*Za),Ua*=Za,Ya*=Za));q=-Ya;B=Ua}else{if(!(Va.rotationY||Va.rotationX||1!==hb||jb))return lb[la]=(Va.xPercent||Va.yPercent?"translate("+Va.xPercent+"%,"+Va.yPercent+"%) translate3d(":
"translate3d(")+$a+"px,"+kb+"px,"+mb+"px)"+(1!==bb||1!==db?" scale("+bb+","+db+")":""),void 0;l=B=1;q=t=0}$=1;v=y=A=E=M=Y=ra=ja=ya=0;Ea=jb?-1/jb:0;ma=Va.zOrigin;(eb=Va.rotationY*za)&&(Ua=Math.cos(eb),Ya=Math.sin(eb),M=$*-Ya,ja=Ea*-Ya,v=l*Ya,A=t*Ya,$*=Ua,Ea*=Ua,l*=Ua,t*=Ua);(eb=Va.rotationX*za)&&(Ua=Math.cos(eb),Ya=Math.sin(eb),Za=q*Ua+v*Ya,fb=B*Ua+A*Ya,ib=Y*Ua+$*Ya,gb=ya*Ua+Ea*Ya,v=q*-Ya+v*Ua,A=B*-Ya+A*Ua,$=Y*-Ya+$*Ua,Ea=ya*-Ya+Ea*Ua,q=Za,B=fb,Y=ib,ya=gb);1!==hb&&(v*=hb,A*=hb,$*=hb,Ea*=hb);1!==db&&
(q*=db,B*=db,Y*=db,ya*=db);1!==bb&&(l*=bb,t*=bb,M*=bb,ja*=bb);ma&&(ra-=ma,y=v*ra,E=A*ra,ra=$*ra+ma);y=(Za=(y+=$a)-(y|=0))?(0|Za*1E5+(0>Za?-0.5:0.5))/1E5+y:y;E=(Za=(E+=kb)-(E|=0))?(0|Za*1E5+(0>Za?-0.5:0.5))/1E5+E:E;ra=(Za=(ra+=mb)-(ra|=0))?(0|Za*1E5+(0>Za?-0.5:0.5))/1E5+ra:ra;lb[la]=(Va.xPercent||Va.yPercent?"translate("+Va.xPercent+"%,"+Va.yPercent+"%) matrix3d(":"matrix3d(")+[(0|l*1E5)/1E5,(0|t*1E5)/1E5,(0|M*1E5)/1E5,(0|ja*1E5)/1E5,(0|q*1E5)/1E5,(0|B*1E5)/1E5,(0|Y*1E5)/1E5,(0|ya*1E5)/1E5,(0|v*1E5)/
1E5,(0|A*1E5)/1E5,(0|$*1E5)/1E5,(0|Ea*1E5)/1E5,y,E,ra,jb?1+-ra/jb:1].join(",")+")"},cb=I.set2DTransformRatio=function(l){var q,v,y,t,B=this.data,A=this.t.style,E=B.x,M=B.y;return B.rotationX||B.rotationY||B.z||B.force3D===true||"auto"===B.force3D&&1!==l&&0!==l?(this.setRatio=Ba,Ba.call(this,l),void 0):(B.rotation||B.skewX?(q=B.rotation*za,v=q-B.skewX*za,y=B.scaleX*1E5,t=B.scaleY*1E5,A[la]=(B.xPercent||B.yPercent?"translate("+B.xPercent+"%,"+B.yPercent+"%) matrix(":"matrix(")+(0|Math.cos(q)*y)/1E5+
","+(0|Math.sin(q)*y)/1E5+","+(0|Math.sin(v)*-t)/1E5+","+(0|Math.cos(v)*t)/1E5+","+E+","+M+")"):A[la]=(B.xPercent||B.yPercent?"translate("+B.xPercent+"%,"+B.yPercent+"%) matrix(":"matrix(")+B.scaleX+",0,0,"+B.scaleY+","+E+","+M+")",void 0)};ga("transform,scale,scaleX,scaleY,scaleZ,x,y,z,rotation,rotationX,rotationY,rotationZ,skewX,skewY,shortRotation,shortRotationX,shortRotationY,shortRotationZ,transformOrigin,transformPerspective,directionalRotation,parseTransform,force3D,skewType,xPercent,yPercent",
{parser:function(l,q,v,y,t,B,A){if(y._transform)return t;var E,M,Y,$,ra,ja;q=y._transform=Ha(l,c,true,A.parseTransform);var ya=l.style,Ea=Fa.length,ma={};if("string"==typeof A.transform&&la){Y=fa.style;Y[la]=A.transform;Y.display="block";Y.position="absolute";Z.body.appendChild(fa);E=Ha(fa,null,false);Z.body.removeChild(fa)}else if("object"==typeof A){if(E={scaleX:Ta(null!=A.scaleX?A.scaleX:A.scale,q.scaleX),scaleY:Ta(null!=A.scaleY?A.scaleY:A.scale,q.scaleY),scaleZ:Ta(A.scaleZ,q.scaleZ),x:Ta(A.x,
q.x),y:Ta(A.y,q.y),z:Ta(A.z,q.z),xPercent:Ta(A.xPercent,q.xPercent),yPercent:Ta(A.yPercent,q.yPercent),perspective:Ta(A.transformPerspective,q.perspective)},ja=A.directionalRotation,null!=ja)if("object"==typeof ja)for(Y in ja)A[Y]=ja[Y];else A.rotation=ja;"string"==typeof A.x&&-1!==A.x.indexOf("%")&&(E.x=0,E.xPercent=Ta(A.x,q.xPercent));"string"==typeof A.y&&-1!==A.y.indexOf("%")&&(E.y=0,E.yPercent=Ta(A.y,q.yPercent));E.rotation=d("rotation"in A?A.rotation:"shortRotation"in A?A.shortRotation+"_short":
"rotationZ"in A?A.rotationZ:q.rotation,q.rotation,"rotation",ma);da&&(E.rotationX=d("rotationX"in A?A.rotationX:"shortRotationX"in A?A.shortRotationX+"_short":q.rotationX||0,q.rotationX,"rotationX",ma),E.rotationY=d("rotationY"in A?A.rotationY:"shortRotationY"in A?A.shortRotationY+"_short":q.rotationY||0,q.rotationY,"rotationY",ma));E.skewX=null==A.skewX?q.skewX:d(A.skewX,q.skewX);E.skewY=null==A.skewY?q.skewY:d(A.skewY,q.skewY);(M=E.skewY-q.skewY)&&(E.skewX+=M,E.rotation+=M)}da&&null!=A.force3D&&
(q.force3D=A.force3D,ra=true);q.skewType=A.skewType||q.skewType||j.defaultSkewType;for((M=q.force3D||q.z||q.rotationX||q.rotationY||E.z||E.rotationX||E.rotationY||E.perspective)||null==A.scale||(E.scaleZ=1);--Ea>-1;){v=Fa[Ea];$=E[v]-q[v];($>1.0E-6||-1.0E-6>$||null!=O[v])&&(ra=true,t=new H(q,v,q[v],$,t),v in ma&&(t.e=ma[v]),t.xs0=0,t.plugin=B,y._overwriteProps.push(t.n))}return $=A.transformOrigin,($||da&&M&&q.zOrigin)&&(la?(ra=true,v=X,$=($||z(l,v,c,false,"50% 50%"))+"",t=new H(ya,v,0,0,t,-1,"transformOrigin"),
t.b=ya[v],t.plugin=B,da?(Y=q.zOrigin,$=$.split(" "),q.zOrigin=($.length>2&&(0===Y||"0px"!==$[2])?parseFloat($[2]):Y)||0,t.xs0=t.e=$[0]+" "+($[1]||"50%")+" 0px",t=new H(q,"zOrigin",0,0,t,-1,t.n),t.b=Y,t.xs0=t.e=q.zOrigin):t.xs0=t.e=$):Ga($+"",q)),ra&&(y._transformType=M||3===this._transformType?3:2),t},prefix:true});ga("boxShadow",{defaultValue:"0px 0px 0px 0px #999",prefix:true,color:true,multi:true,keyword:"inset"});ga("borderRadius",{defaultValue:"0px",parser:function(l,q,v,y,t){q=this.format(q);
var B,A,E,M,Y,$,ra,ja,ya,Ea,ma,Ua,Ya,Za,fb=["borderTopLeftRadius","borderTopRightRadius","borderBottomRightRadius","borderBottomLeftRadius"],ib=l.style;y=parseFloat(l.offsetWidth);ja=parseFloat(l.offsetHeight);q=q.split(" ");for(B=0;fb.length>B;B++){this.p.indexOf("border")&&(fb[B]=Ma(fb[B]));M=E=z(l,fb[B],c,false,"0px");-1!==M.indexOf(" ")&&(E=M.split(" "),M=E[0],E=E[1]);Y=A=q[B];$=parseFloat(M);Ea=M.substr(($+"").length);(ma="="===Y.charAt(1))?(ra=parseInt(Y.charAt(0)+"1",10),Y=Y.substr(2),ra*=
parseFloat(Y),ya=Y.substr((ra+"").length-(0>ra?1:0))||""):(ra=parseFloat(Y),ya=Y.substr((ra+"").length));""===ya&&(ya=g[v]||Ea);ya!==Ea&&(Ua=C(l,"borderLeft",$,Ea),Ya=C(l,"borderTop",$,Ea),"%"===ya?(M=100*(Ua/y)+"%",E=100*(Ya/ja)+"%"):"em"===ya?(Za=C(l,"borderLeft",1,"em"),M=Ua/Za+"em",E=Ya/Za+"em"):(M=Ua+"px",E=Ya+"px"),ma&&(Y=parseFloat(M)+ra+ya,A=parseFloat(E)+ra+ya));t=ea(ib,fb[B],M+" "+E,Y+" "+A,false,"0px",t)}return t},prefix:true,formatter:G("0px 0px 0px 0px",false,true)});ga("backgroundPosition",
{defaultValue:"0 0",parser:function(l,q,v,y,t,B){var A,E,M;v=c||k(l,null);v=this.format((v?x?v.getPropertyValue("background-position-x")+" "+v.getPropertyValue("background-position-y"):v.getPropertyValue("background-position"):l.currentStyle.backgroundPositionX+" "+l.currentStyle.backgroundPositionY)||"0 0");var Y=this.format(q);if(-1!==v.indexOf("%")!=(-1!==Y.indexOf("%"))&&(A=z(l,"backgroundImage").replace(Sa,""),A&&"none"!==A)){q=v.split(" ");y=Y.split(" ");na.setAttribute("src",A);for(A=2;--A>
-1;){v=q[A];E=-1!==v.indexOf("%");E!==(-1!==y[A].indexOf("%"))&&(M=0===A?l.offsetWidth-na.width:l.offsetHeight-na.height,q[A]=E?parseFloat(v)/100*M+"px":100*(parseFloat(v)/M)+"%")}v=q.join(" ")}return this.parseComplex(l.style,v,Y,t,B)},formatter:Ga});ga("backgroundSize",{defaultValue:"0 0",formatter:Ga});ga("perspective",{defaultValue:"0px",prefix:true});ga("perspectiveOrigin",{defaultValue:"50% 50%",prefix:true});ga("transformStyle",{prefix:true});ga("backfaceVisibility",{prefix:true});ga("userSelect",
{prefix:true});ga("margin",{parser:S("marginTop,marginRight,marginBottom,marginLeft")});ga("padding",{parser:S("paddingTop,paddingRight,paddingBottom,paddingLeft")});ga("clip",{defaultValue:"rect(0px,0px,0px,0px)",parser:function(l,q,v,y,t,B){var A,E;return 9>x?(E=8>x?" ":",",q=this.format(q).split(",").join(E)):(A=this.format(z(l,this.p,c,false,this.dflt)),q=this.format(q)),this.parseComplex(l.style,A,q,t,B)}});ga("textShadow",{defaultValue:"0px 0px 0px #999",color:true,multi:true});ga("autoRound,strictUnits",
{parser:function(l,q,v,y,t){return t}});ga("border",{defaultValue:"0px solid #000",parser:function(l,q,v,y,t,B){return this.parseComplex(l.style,this.format(z(l,"borderTopWidth",c,false,"0px")+" "+z(l,"borderTopStyle",c,false,"solid")+" "+z(l,"borderTopColor",c,false,"#000")),this.format(q),t,B)},color:true,formatter:function(l){var q=l.split(" ");return q[0]+" "+(q[1]||"solid")+" "+(l.match(D)||["#000"])[0]}});ga("borderWidth",{parser:S("borderTopWidth,borderRightWidth,borderBottomWidth,borderLeftWidth")});
ga("float,cssFloat,styleFloat",{parser:function(l,q,v,y,t){l=l.style;y="cssFloat"in l?"cssFloat":"styleFloat";return new H(l,y,0,0,t,-1,v,false,0,l[y],q)}});var ab=function(l){var q,v=this.t,y=v.filter||z(this.data,"filter");l=0|this.s+this.c*l;100===l&&(-1===y.indexOf("atrix(")&&-1===y.indexOf("radient(")&&-1===y.indexOf("oader(")?(v.removeAttribute("filter"),q=!z(this.data,"filter")):(v.filter=y.replace(sa,""),q=true));q||(this.xn1&&(v.filter=y=y||"alpha(opacity="+l+")"),-1===y.indexOf("pacity")?
0===l&&this.xn1||(v.filter=y+" alpha(opacity="+l+")"):v.filter=y.replace(ta,"opacity="+l))};ga("opacity,alpha,autoAlpha",{defaultValue:"1",parser:function(l,q,v,y,t,B){var A=parseFloat(z(l,"opacity",c,false,"1")),E=l.style,M="autoAlpha"===v;return"string"==typeof q&&"="===q.charAt(1)&&(q=("-"===q.charAt(0)?-1:1)*parseFloat(q.substr(2))+A),M&&1===A&&"hidden"===z(l,"visibility",c)&&0!==q&&(A=0),ca?t=new H(E,"opacity",A,q-A,t):(t=new H(E,"opacity",100*A,100*(q-A),t),t.xn1=M?1:0,E.zoom=1,t.type=2,t.b=
"alpha(opacity="+t.s+")",t.e="alpha(opacity="+(t.s+t.c)+")",t.data=l,t.plugin=B,t.setRatio=ab),M&&(t=new H(E,"visibility",0,0,t,-1,null,false,0,0!==A?"inherit":"hidden",0===q?"hidden":"inherit"),t.xs0="inherit",y._overwriteProps.push(t.n),y._overwriteProps.push(v)),t}});var wa=function(l,q){q&&(l.removeProperty?("ms"===q.substr(0,2)&&(q="M"+q.substr(1)),l.removeProperty(q.replace(Oa,"-$1").toLowerCase())):l.removeAttribute(q))},Ja=function(l){if(this.t._gsClassPT=this,1===l||0===l){this.t.setAttribute("class",
0===l?this.b:this.e);for(var q=this.data,v=this.t.style;q;){q.v?v[q.p]=q.v:wa(v,q.p);q=q._next}1===l&&this.t._gsClassPT===this&&(this.t._gsClassPT=null)}else this.t.getAttribute("class")!==this.e&&this.t.setAttribute("class",this.e)};ga("className",{parser:function(l,q,v,y,t,B,A){var E,M,Y,$,ra=l.getAttribute("class")||"",ja=l.style.cssText;if(t=y._classNamePT=new H(l,v,0,0,t,2),t.setRatio=Ja,t.pr=-11,n=true,t.b=ra,v=W(l,c),M=l._gsClassPT){Y={};for($=M.data;$;){Y[$.p]=1;$=$._next}M.setRatio(1)}return l._gsClassPT=
t,t.e="="!==q.charAt(1)?q:ra.replace(RegExp("\\s*\\b"+q.substr(2)+"\\b"),"")+("+"===q.charAt(0)?" "+q.substr(2):""),y._tween._duration&&(l.setAttribute("class",t.e),E=aa(l,v,W(l),A,Y),l.setAttribute("class",ra),t.data=E.firstMPT,l.style.cssText=ja,t=t.xfirst=y.parse(l,E.difs,t,B)),t}});var pa=function(l){if((1===l||0===l)&&this.data._totalTime===this.data._totalDuration&&"isFromStart"!==this.data.data){var q,v,y,t=this.t.style,B=s.transform.parse;if("all"===this.e){t.cssText="";y=true}else{l=this.e.split(",");
for(v=l.length;--v>-1;){q=l[v];s[q]&&(s[q].parse===B?y=true:q="transformOrigin"===q?X:s[q].p);wa(t,q)}}y&&(wa(t,la),this.t._gsTransform&&delete this.t._gsTransform)}};ga("clearProps",{parser:function(l,q,v,y,t){return t=new H(l,v,0,0,t,2),t.setRatio=pa,t.e=q,t.pr=-10,t.data=y._tween,n=true,t}});w="bezier,throwProps,physicsProps,physics2D".split(",");for(U=w.length;U--;)ua(w[U]);w=j.prototype;w._firstPT=null;w._onInitTween=function(l,q,v){if(!l.nodeType)return false;this._target=l;this._tween=v;this._vars=
q;K=q.autoRound;n=false;g=q.suffixMap||j.suffixMap;c=k(l,"");e=this._overwriteProps;var y,t,B,A,E=l.style;if(p&&""===E.zIndex&&(y=z(l,"zIndex",c),("auto"===y||""===y)&&this._addLazySet(E,"zIndex",0)),"string"==typeof q&&(B=E.cssText,y=W(l,c),E.cssText=B+";"+q,y=aa(l,y,W(l)).difs,!ca&&Ka.test(q)&&(y.opacity=parseFloat(RegExp.$1)),q=y,E.cssText=B),this._firstPT=v=this.parse(l,q,null),this._transformType){q=3===this._transformType;la?L&&(p=true,""===E.zIndex&&(t=z(l,"zIndex",c),("auto"===t||""===t)&&
this._addLazySet(E,"zIndex",0)),r&&this._addLazySet(E,"WebkitBackfaceVisibility",this._vars.WebkitBackfaceVisibility||(q?"visible":"hidden"))):E.zoom=1;for(t=v;t&&t._next;)t=t._next;y=new H(l,"transform",0,0,null,2);this._linkCSSP(y,null,t);y.setRatio=q&&da?Ba:la?cb:Xa;y.data=this._transform||Ha(l,c,true);e.pop()}if(n){for(;v;){l=v._next;for(t=B;t&&t.pr>v.pr;)t=t._next;(v._prev=t?t._prev:A)?v._prev._next=v:B=v;(v._next=t)?t._prev=v:A=v;v=l}this._firstPT=B}return true};w.parse=function(l,q,v,y){var t,
B,A,E,M,Y,$,ra,ja,ya=l.style;for(t in q){M=q[t];if(B=s[t])v=B.parse(l,M,t,this,v,y,q);else{B=z(l,t,c)+"";ra="string"==typeof M;if("color"===t||"fill"===t||"stroke"===t||-1!==t.indexOf("Color")||ra&&qa.test(M)){ra||(M=u(M),M=(M.length>3?"rgba(":"rgb(")+M.join(",")+")");v=ea(ya,t,B,M,true,"transparent",v,0,y)}else if(!ra||-1===M.indexOf(" ")&&-1===M.indexOf(",")){Y=(A=parseFloat(B))||0===A?B.substr((A+"").length):"";if(""===B||"auto"===B)if("width"===t||"height"===t){A=l;var Ea=t;Y=c;ja=parseFloat("width"===
Ea?A.offsetWidth:A.offsetHeight);Ea=xa[Ea];var ma=Ea.length;for(Y=Y||k(A,null);--ma>-1;){ja-=parseFloat(z(A,"padding"+Ea[ma],Y,true))||0;ja-=parseFloat(z(A,"border"+Ea[ma]+"Width",Y,true))||0}A=ja;Y="px"}else"left"===t||"top"===t?(A=J(l,t,c),Y="px"):(A="opacity"!==t?0:1,Y="");(ja=ra&&"="===M.charAt(1))?(E=parseInt(M.charAt(0)+"1",10),M=M.substr(2),E*=parseFloat(M),$=M.replace(ka,"")):(E=parseFloat(M),$=ra?M.substr((E+"").length)||"":"");""===$&&($=t in g?g[t]:Y);Y!==$&&""!==$&&(E||0===E)&&A&&(A=C(l,
t,A,Y),"%"===$?(A/=C(l,t,100,"%")/100,q.strictUnits!==true&&(B=A+"%")):"em"===$?A/=C(l,t,1,"em"):"px"!==$&&(E=C(l,t,E,$),$="px"),ja&&(E||0===E)&&(M=E+A+$));ja&&(E+=A);if(!A&&0!==A||!E&&0!==E)if(void 0!==ya[t]&&(M||"NaN"!=M+""&&null!=M)){v=new H(ya,t,E||A||0,0,v,-1,t,false,0,B,M);v.xs0="none"!==M||"display"!==t&&-1===t.indexOf("Style")?M:B}else window.console&&console.log("invalid "+t+" tween value: "+q[t]);else{v=new H(ya,t,A,E-A,v,0,t,K!==false&&("px"===$||"zIndex"===t),0,B,M);v.xs0=$}}else v=ea(ya,
t,B,M,true,null,v,0,y)}y&&v&&!v.plugin&&(v.plugin=y)}return v};w.setRatio=function(l){var q,v,y,t=this._firstPT;if(1!==l||this._tween._time!==this._tween._duration&&0!==this._tween._time)if(l||this._tween._time!==this._tween._duration&&0!==this._tween._time||this._tween._rawPrevTime===-1.0E-6)for(;t;){if(q=t.c*l+t.s,t.r?q=Math.round(q):1.0E-6>q&&q>-1.0E-6&&(q=0),t.type)if(1===t.type)if(y=t.l,2===y)t.t[t.p]=t.xs0+q+t.xs1+t.xn1+t.xs2;else if(3===y)t.t[t.p]=t.xs0+q+t.xs1+t.xn1+t.xs2+t.xn2+t.xs3;else if(4===
y)t.t[t.p]=t.xs0+q+t.xs1+t.xn1+t.xs2+t.xn2+t.xs3+t.xn3+t.xs4;else if(5===y)t.t[t.p]=t.xs0+q+t.xs1+t.xn1+t.xs2+t.xn2+t.xs3+t.xn3+t.xs4+t.xn4+t.xs5;else{v=t.xs0+q+t.xs1;for(y=1;t.l>y;y++)v+=t["xn"+y]+t["xs"+(y+1)];t.t[t.p]=v}else-1===t.type?t.t[t.p]=t.xs0:t.setRatio&&t.setRatio(l);else t.t[t.p]=q+t.xs0;t=t._next}else for(;t;){2!==t.type?t.t[t.p]=t.b:t.setRatio(l);t=t._next}else for(;t;){2!==t.type?t.t[t.p]=t.e:t.setRatio(l);t=t._next}};w._enableTransforms=function(l){this._transformType=l||3===this._transformType?
3:2;this._transform=this._transform||Ha(this._target,c,true)};var T=function(){this.t[this.p]=this.e;this.data._linkCSSP(this,this._next,null,true)};w._addLazySet=function(l,q,v){l=this._firstPT=new H(l,q,0,0,this._firstPT,2);l.e=v;l.setRatio=T;l.data=this};w._linkCSSP=function(l,q,v,y){return l&&(q&&(q._prev=l),l._next&&(l._next._prev=l._prev),l._prev?l._prev._next=l._next:this._firstPT===l&&(this._firstPT=l._next,y=true),v?v._next=l:y||null!==this._firstPT||(this._firstPT=l),l._next=q,l._prev=v),
l};w._kill=function(l){var q,v,y,t=l;if(l.autoAlpha||l.alpha){t={};for(v in l)t[v]=l[v];t.opacity=1;t.autoAlpha&&(t.visibility=1)}return l.className&&(q=this._classNamePT)&&(y=q.xfirst,y&&y._prev?this._linkCSSP(y._prev,q._next,y._prev._prev):y===this._firstPT&&(this._firstPT=q._next),q._next&&this._linkCSSP(q._next,q._next._next,y._prev),this._classNamePT=null),b.prototype._kill.call(this,t)};var ia=function(l,q,v){var y,t,B;if(l.slice)for(y=l.length;--y>-1;)ia(l[y],q,v);else{l=l.childNodes;for(y=
l.length;--y>-1;){t=l[y];B=t.type;t.style&&(q.push(W(t)),v&&v.push(t));1!==B&&9!==B&&11!==B||!t.childNodes.length||ia(t,q,v)}}};return j.cascadeTo=function(l,q,v){var y,t,B=f.to(l,q,v),A=[B],E=[],M=[],Y=[],$=f._internals.reservedProps;l=B._targets||B.target;ia(l,E,Y);B.render(q,true);ia(l,M);B.render(0,true);B._enabled(true);for(l=Y.length;--l>-1;)if(y=aa(Y[l],E[l],M[l]),y.firstMPT){y=y.difs;for(t in v)$[t]&&(y[t]=v[t]);A.push(f.to(Y[l],q,y))}return A},b.activate([j]),j},true)});
_gsScope._gsDefine&&_gsScope._gsQueue.pop()();(function(b){var f=function(){return(_gsScope.GreenSockGlobals||_gsScope)[b]};"function"==typeof define&&define.amd?define(["TweenLite"],f):"undefined"!=typeof module&&module.exports&&(require("../TweenLite.js"),module.exports=f())})("CSSPlugin");_gsScope="undefined"!=typeof module&&module.exports&&"undefined"!=typeof global?global:this||window;
(function(b){var f=b.GreenSockGlobals||b,n=function(r){var x=r.split("."),m=f;for(r=0;x.length>r;r++)m[x[r]]=m=m[x[r]]||{};return m}("com.greensock.utils"),g=function(r){var x=r.nodeType,m="";if(1===x||9===x||11===x){if("string"==typeof r.textContent)return r.textContent;for(r=r.firstChild;r;r=r.nextSibling)m+=g(r)}else if(3===x||4===x)return r.nodeValue;return m},c=document,e=c.defaultView?c.defaultView.getComputedStyle:function(){},j=/([A-Z])/g,s=function(r,x,m,F){var V;return(m=m||e(r,null))?r=
m.getPropertyValue(x.replace(j,"-$1").toLowerCase()):r.currentStyle&&(m=r.currentStyle,V=m[x]),F?V:parseInt(V,10)||0},w=function(r){return r.length&&r[0]&&(r[0].nodeType&&r[0].style&&!r.nodeType||r[0].length&&r[0][0])?true:false},K=/(?:<br>|<br\/>|<br \/>)/gi,p="<div style='position:relative;display:inline-block;"+(c.all&&!c.addEventListener?"*display:inline;*zoom:1;'":"'"),L=function(r){r=r||"";var x=-1!==r.indexOf("++"),m=1;return x&&(r=r.split("++").join("")),function(){return p+(r?" class='"+
r+(x?m++:"")+"'>":">")}},N=n.SplitText=f.SplitText=function(r,x){if("string"==typeof r&&(r=N.selector(r)),!r)throw"cannot split a null element.";var m;if(w(r)){m=r;var F,V,ha,ka=[],ta=m.length;for(F=0;ta>F;F++)if(V=m[F],w(V))for(ha=0;V.length>ha;ha++)ka.push(V[ha]);else ka.push(V);m=ka}else m=[r];this.elements=m;this.chars=[];this.words=[];this.lines=[];this._originals=[];this.vars=x||{};this.split(x)};n=N.prototype;n.split=function(r){this.isSplit&&this.revert();this.vars=r||this.vars;for(r=this._originals.length=
this.chars.length=this.words.length=this.lines.length=0;this.elements.length>r;r++){this._originals[r]=this.elements[r].innerHTML;var x=this.elements[r],m=this.vars,F=this.chars,V=this.words,ha=this.lines;K.test(x.innerHTML)&&(x.innerHTML=x.innerHTML.replace(K,")eefec303079ad17405c"));var ka=void 0,ta=void 0,Ka=void 0,sa=void 0,qa=void 0,Oa=void 0,Aa=void 0,Sa=void 0,Ia=void 0,La=void 0,Q=void 0,Wa=void 0;ta=g(x);var Ra=m.type||m.split||"chars,words,lines",za=-1!==Ra.indexOf("lines")?[]:null,Na=-1!==
Ra.indexOf("words");Ra=-1!==Ra.indexOf("chars");var O="absolute"===m.position||m.absolute===true;Oa=O?"?":" ";Wa=-999;sa=e(x);var Z=s(x,"paddingLeft",sa),fa=s(x,"borderBottomWidth",sa)+s(x,"borderTopWidth",sa),na=s(x,"borderLeftWidth",sa)+s(x,"borderRightWidth",sa),I=s(x,"paddingTop",sa)+s(x,"paddingBottom",sa),P=s(x,"paddingLeft",sa)+s(x,"paddingRight",sa),ca=s(x,"textAlign",sa,true),va=x.clientHeight,Qa=x.clientWidth,Pa=ta.length,Ma=L(m.wordsClass),k=L(m.charsClass),z=-1!==(m.linesClass||
"").indexOf("++");m=m.linesClass;z&&(m=m.split("++").join(""));Ka=Ma();for(sa=0;Pa>sa;sa++){qa=ta.charAt(sa);")"===qa&&ta.substr(sa,20)===")eefec303079ad17405c"?(Ka+="</div><BR/>",sa!==Pa-1&&(Ka+=" "+Ma()),sa+=19):" "===qa&&" "!==ta.charAt(sa-1)&&sa!==Pa-1?(Ka+="</div>",sa!==Pa-1&&(Ka+=Oa+Ma())):Ka+=Ra&&" "!==qa?k()+qa+"</div>":qa}x.innerHTML=Ka+"</div>";ta=x.getElementsByTagName("*");Pa=ta.length;Oa=[];for(sa=0;Pa>sa;sa++)Oa[sa]=ta[sa];if(za||O)for(sa=0;Pa>sa;sa++){Aa=Oa[sa];((ta=Aa.parentNode===
x)||O||Ra&&!Na)&&(Sa=Aa.offsetTop,za&&ta&&Sa!==Wa&&"BR"!==Aa.nodeName&&(ka=[],za.push(ka),Wa=Sa),O&&(Aa._x=Aa.offsetLeft,Aa._y=Sa,Aa._w=Aa.offsetWidth,Aa._h=Aa.offsetHeight),za&&(Na!==ta&&Ra||(ka.push(Aa),Aa._x-=Z),ta&&sa&&(Oa[sa-1]._wordEnd=true)))}for(sa=0;Pa>sa;sa++){Aa=Oa[sa];ta=Aa.parentNode===x;"BR"!==Aa.nodeName?(O&&(La=Aa.style,Na||ta||(Aa._x+=Aa.parentNode._x,Aa._y+=Aa.parentNode._y),La.left=Aa._x+"px",La.top=Aa._y+"px",La.position="absolute",La.display="block",La.width=Aa._w+1+"px",La.height=
Aa._h+"px"),Na?ta?V.push(Aa):Ra&&F.push(Aa):ta?(x.removeChild(Aa),Oa.splice(sa--,1),Pa--):!ta&&Ra&&(Sa=!za&&!O&&Aa.nextSibling,x.appendChild(Aa),Sa||x.appendChild(c.createTextNode(" ")),F.push(Aa))):za||O?(x.removeChild(Aa),Oa.splice(sa--,1),Pa--):Na||x.appendChild(Aa)}if(za){O&&(Ia=c.createElement("div"),x.appendChild(Ia),Q=Ia.offsetWidth+"px",Sa=Ia.offsetParent===x?0:x.offsetLeft,x.removeChild(Ia));La=x.style.cssText;for(x.style.cssText="display:none;";x.firstChild;)x.removeChild(x.firstChild);
Wa=!O||!Na&&!Ra;for(sa=0;za.length>sa;sa++){ka=za[sa];Ia=c.createElement("div");Ia.style.cssText="display:block;text-align:"+ca+";position:"+(O?"absolute;":"relative;");m&&(Ia.className=m+(z?sa+1:""));ha.push(Ia);Pa=ka.length;for(ta=0;Pa>ta;ta++)"BR"!==ka[ta].nodeName&&(Aa=ka[ta],Ia.appendChild(Aa),Wa&&(Aa._wordEnd||Na)&&Ia.appendChild(c.createTextNode(" ")),O&&(0===ta&&(Ia.style.top=Aa._y+"px",Ia.style.left=Z+Sa+"px"),Aa.style.top="0px",Sa&&(Aa.style.left=Aa._x-Sa+"px")));Na||Ra||(Ia.innerHTML=g(Ia).split(String.fromCharCode(160)).join(" "));
O&&(Ia.style.width=Q,Ia.style.height=Aa._h+"px");x.appendChild(Ia)}x.style.cssText=La}O&&(va>x.clientHeight&&(x.style.height=va-I+"px",va>x.clientHeight&&(x.style.height=va+fa+"px")),Qa>x.clientWidth&&(x.style.width=Qa-P+"px",Qa>x.clientWidth&&(x.style.width=Qa+na+"px")))}return this.isSplit=true,this};n.revert=function(){if(!this._originals)throw"revert() call wasn't scoped properly.";for(var r=this._originals.length;--r>-1;)this.elements[r].innerHTML=this._originals[r];return this.chars=[],this.words=
[],this.lines=[],this.isSplit=false,this};N.selector=b.$||b.jQuery||function(r){return b.$?(N.selector=b.$,b.$(r)):c?c.getElementById("#"===r.charAt(0)?r.substr(1):r):r};N.version="0.2.4"})(_gsScope);(function(b){var f=function(){return(_gsScope.GreenSockGlobals||_gsScope)[b]};"function"==typeof define&&define.amd?define(["TweenLite"],f):"undefined"!=typeof module&&module.exports&&(module.exports=f())})("SplitText");
try{window.GreenSockGobals=null;window._gsQueue=null;delete window.GreenSockGlobals;delete window._gsQueue}catch(e$$185){}try{window.GreenSockGlobals=oldgs;window._gsQueue=oldgs_queue}catch(e$$186){}if(window.tplogs==true)try{console.groupEnd()}catch(e$$187){}
(function(b){b.waitForImages={hasImageProperties:["backgroundImage","listStyleImage","borderImage","borderCornerImage"]};b.expr[":"].uncached=function(f){var n=document.createElement("img");n.src=f.src;return b(f).is('img[src!=""]')&&!n.complete};b.fn.waitForImages=function(f,n,g){if(b.isPlainObject(f)){n=f.each;g=f.waitForAll;f=f.finished}f=f||b.noop;n=n||b.noop;g=!!g;if(!b.isFunction(f)||!b.isFunction(n))throw new TypeError("An invalid callback was supplied.");return this.each(function(){var c=
b(this),e=[];if(g){var j=b.waitForImages.hasImageProperties||[],s=/url\((['"]?)(.*?)\1\)/g;c.find("*").each(function(){var p=b(this);p.is("img:uncached")&&e.push({src:p.attr("src"),element:p[0]});b.each(j,function(L,N){var r=p.css(N);if(!r)return true;for(var x;x=s.exec(r);)e.push({src:x[2],element:p[0]})})})}else c.find("img:uncached").each(function(){e.push({src:this.src,element:this})});var w=e.length,K=0;w==0&&f.call(c[0]);b.each(e,function(p,L){var N=new Image;b(N).bind("load error",function(r){K++;
n.call(L.element,K,w,r.type=="load");if(K==w){f.call(c[0]);return false}});N.src=L.src})})}})(jQuery);
(function(b,f,n,g){function c(p,L){this.settings=null;this.options=b.extend({},c.Defaults,L);this.$element=b(p);this.drag=b.extend({},s);this.state=b.extend({},w);this.e=b.extend({},K);this._plugins={};this._supress={};this._speed=this._current=null;this._coordinates=[];this._width=this._breakpoint=null;this._items=[];this._clones=[];this._mergers=[];this._invalidated={};this._pipe=[];b.each(c.Plugins,b.proxy(function(N,r){this._plugins[N[0].toLowerCase()+N.slice(1)]=new r(this)},this));b.each(c.Pipe,
b.proxy(function(N,r){this._pipe.push({filter:r.filter,run:b.proxy(r.run,this)})},this));this.setup();this.initialize()}function e(p){if(p.touches!==g)return{x:p.touches[0].pageX,y:p.touches[0].pageY};if(p.touches===g){if(p.pageX!==g)return{x:p.pageX,y:p.pageY};if(p.pageX===g)return{x:p.clientX,y:p.clientY}}}function j(p){var L,N,r=n.createElement("div");for(L in p)if(N=p[L],"undefined"!=typeof r.style[N])return[N,L];return[false]}var s,w,K;s={start:0,startX:0,startY:0,current:0,currentX:0,currentY:0,
offsetX:0,offsetY:0,distance:null,startTime:0,endTime:0,updatedX:0,targetEl:null};w={isTouch:false,isScrolling:false,isSwiping:false,direction:false,inMotion:false};K={_onDragStart:null,_onDragMove:null,_onDragEnd:null,_transitionEnd:null,_resizer:null,_responsiveCall:null,_goToLoop:null,_checkVisibile:null};c.Defaults={items:3,loop:false,center:false,mouseDrag:true,touchDrag:true,pullDrag:true,freeDrag:false,margin:0,stagePadding:0,merge:false,mergeFit:true,autoWidth:false,startPosition:0,rtl:false,
smartSpeed:250,fluidSpeed:false,dragEndSpeed:false,responsive:{},responsiveRefreshRate:200,responsiveBaseElement:f,responsiveClass:false,fallbackEasing:"swing",info:false,nestedItemSelector:false,itemElement:"div",stageElement:"div",themeClass:"owl-theme",baseClass:"owl-carousel",itemClass:"owl-item",centerClass:"center",activeClass:"active"};c.Width={Default:"default",Inner:"inner",Outer:"outer"};c.Plugins={};c.Pipe=[{filter:["width","items","settings"],run:function(p){p.current=this._items&&this._items[this.relative(this._current)]}},
{filter:["items","settings"],run:function(){var p=this._clones;(this.$stage.children(".cloned").length!==p.length||!this.settings.loop&&p.length>0)&&(this.$stage.children(".cloned").remove(),this._clones=[])}},{filter:["items","settings"],run:function(){var p,L,N=this._clones,r=this._items,x=this.settings.loop?N.length-Math.max(2*this.settings.items,4):0;p=0;for(L=Math.abs(x/2);L>p;p++)x>0?(this.$stage.children().eq(r.length+N.length-1).remove(),N.pop(),this.$stage.children().eq(0).remove(),N.pop()):
(N.push(N.length/2),this.$stage.append(r[N[N.length-1]].clone().addClass("cloned")),N.push(r.length-1-(N.length-1)/2),this.$stage.prepend(r[N[N.length-1]].clone().addClass("cloned")))}},{filter:["width","items","settings"],run:function(){var p,L,N,r=this.settings.rtl?1:-1,x=(this.width()/this.settings.items).toFixed(3),m=0;this._coordinates=[];L=0;for(N=this._clones.length+this._items.length;N>L;L++){p=this._mergers[this.relative(L)];p=this.settings.mergeFit&&Math.min(p,this.settings.items)||p;m+=
(this.settings.autoWidth?this._items[this.relative(L)].width()+this.settings.margin:x*p)*r;this._coordinates.push(m)}}},{filter:["width","items","settings"],run:function(){var p,L;p=(this.width()/this.settings.items).toFixed(3);var N={width:Math.abs(this._coordinates[this._coordinates.length-1])+2*this.settings.stagePadding,"padding-left":this.settings.stagePadding||"","padding-right":this.settings.stagePadding||""};if(this.$stage.css(N),N={width:this.settings.autoWidth?"auto":p-this.settings.margin},
N[this.settings.rtl?"margin-left":"margin-right"]=this.settings.margin,!this.settings.autoWidth&&b.grep(this._mergers,function(r){return r>1}).length>0){p=0;for(L=this._coordinates.length;L>p;p++){N.width=Math.abs(this._coordinates[p])-Math.abs(this._coordinates[p-1]||0)-this.settings.margin;this.$stage.children().eq(p).css(N)}}else this.$stage.children().css(N)}},{filter:["width","items","settings"],run:function(p){p.current&&this.reset(this.$stage.children().index(p.current))}},{filter:["position"],
run:function(){this.animate(this.coordinates(this._current))}},{filter:["width","position","items","settings"],run:function(){var p,L,N,r,x=this.settings.rtl?1:-1,m=2*this.settings.stagePadding,F=this.coordinates(this.current())+m,V=F+this.width()*x,ha=[];N=0;for(r=this._coordinates.length;r>N;N++){p=this._coordinates[N-1]||0;L=Math.abs(this._coordinates[N])+m*x;(this.op(p,"<=",F)&&this.op(p,">",V)||this.op(L,"<",F)&&this.op(L,">",V))&&ha.push(N)}this.$stage.children("."+this.settings.activeClass).removeClass(this.settings.activeClass);
this.$stage.children(":eq("+ha.join("), :eq(")+")").addClass(this.settings.activeClass);this.settings.center&&(this.$stage.children("."+this.settings.centerClass).removeClass(this.settings.centerClass),this.$stage.children().eq(this.current()).addClass(this.settings.centerClass))}}];c.prototype.initialize=function(){if(this.trigger("initialize"),this.$element.addClass(this.settings.baseClass).addClass(this.settings.themeClass).toggleClass("owl-rtl",this.settings.rtl),this.browserSupport(),this.settings.autoWidth&&
this.state.imagesLoaded!==true){var p,L,N;if(p=this.$element.find("img"),L=this.settings.nestedItemSelector?"."+this.settings.nestedItemSelector:g,N=this.$element.children(L).width(),p.length&&0>=N)return this.preloadAutoWidthImages(p),false}this.$element.addClass("owl-loading");this.$stage=b("<"+this.settings.stageElement+' class="owl-stage"/>').wrap('<div class="owl-stage-outer">');this.$element.append(this.$stage.parent());this.replace(this.$element.children().not(this.$stage.parent()));this._width=
this.$element.width();this.refresh();this.$element.removeClass("owl-loading").addClass("owl-loaded");this.eventsCall();this.internalEvents();this.addTriggerableEvents();this.trigger("initialized")};c.prototype.setup=function(){var p=this.viewport(),L=this.options.responsive,N=-1,r=null;L?(b.each(L,function(x){p>=x&&x>N&&(N=Number(x))}),r=b.extend({},this.options,L[N]),delete r.responsive,r.responsiveClass&&this.$element.attr("class",function(x,m){return m.replace(/\b owl-responsive-\S+/g,"")}).addClass("owl-responsive-"+
N)):r=b.extend({},this.options);(null===this.settings||this._breakpoint!==N)&&(this.trigger("change",{property:{name:"settings",value:r}}),this._breakpoint=N,this.settings=r,this.invalidate("settings"),this.trigger("changed",{property:{name:"settings",value:this.settings}}))};c.prototype.optionsLogic=function(){this.$element.toggleClass("owl-center",this.settings.center);this.settings.loop&&this._items.length<this.settings.items&&(this.settings.loop=false);this.settings.autoWidth&&(this.settings.stagePadding=
false,this.settings.merge=false)};c.prototype.prepare=function(p){var L=this.trigger("prepare",{content:p});return L.data||(L.data=b("<"+this.settings.itemElement+"></this>").addClass(this.settings.itemClass).append(p)),this.trigger("prepared",{content:L.data}),L.data};c.prototype.update=function(){for(var p=0,L=this._pipe.length,N=b.proxy(function(x){return this[x]},this._invalidated),r={};L>p;){(this._invalidated.all||b.grep(this._pipe[p].filter,N).length>0)&&this._pipe[p].run(r);p++}this._invalidated=
{}};c.prototype.width=function(p){switch(p||c.Width.Default){case c.Width.Inner:case c.Width.Outer:return this._width;default:return this._width-2*this.settings.stagePadding+this.settings.margin}};c.prototype.refresh=function(){if(0===this._items.length)return false;(new Date).getTime();this.trigger("refresh");this.setup();this.optionsLogic();this.$stage.addClass("owl-refresh");this.update();this.$stage.removeClass("owl-refresh");this.state.orientation=f.orientation;this.watchVisibility();this.trigger("refreshed")};
c.prototype.eventsCall=function(){this.e._onDragStart=b.proxy(function(p){this.onDragStart(p)},this);this.e._onDragMove=b.proxy(function(p){this.onDragMove(p)},this);this.e._onDragEnd=b.proxy(function(p){this.onDragEnd(p)},this);this.e._onResize=b.proxy(function(p){this.onResize(p)},this);this.e._transitionEnd=b.proxy(function(p){this.transitionEnd(p)},this);this.e._preventClick=b.proxy(function(p){this.preventClick(p)},this)};c.prototype.onThrottledResize=function(){f.clearTimeout(this.resizeTimer);
this.resizeTimer=f.setTimeout(this.e._onResize,this.settings.responsiveRefreshRate)};c.prototype.onResize=function(){return this._items.length?this._width===this.$element.width()?false:this.trigger("resize").isDefaultPrevented()?false:(this._width=this.$element.width(),this.invalidate("width"),this.refresh(),void this.trigger("resized")):false};c.prototype.eventsRouter=function(p){var L=p.type;"mousedown"===L||"touchstart"===L?this.onDragStart(p):"mousemove"===L||"touchmove"===L?this.onDragMove(p):
"mouseup"===L||"touchend"===L?this.onDragEnd(p):"touchcancel"===L&&this.onDragEnd(p)};c.prototype.internalEvents=function(){var p=f.navigator.msPointerEnabled;this.settings.mouseDrag?(this.$stage.on("mousedown",b.proxy(function(L){this.eventsRouter(L)},this)),this.$stage.on("dragstart",function(){return false}),this.$stage.get(0).onselectstart=function(){return false}):this.$element.addClass("owl-text-select-on");this.settings.touchDrag&&!p&&this.$stage.on("touchstart touchcancel",b.proxy(function(L){this.eventsRouter(L)},
this));this.transitionEndVendor&&this.on(this.$stage.get(0),this.transitionEndVendor,this.e._transitionEnd,false);this.settings.responsive!==false&&this.on(f,"resize",b.proxy(this.onThrottledResize,this))};c.prototype.onDragStart=function(p){var L,N,r;if(L=p.originalEvent||p||f.event,3===L.which||this.state.isTouch)return false;if("mousedown"===L.type&&this.$stage.addClass("owl-grab"),this.trigger("drag"),this.drag.startTime=(new Date).getTime(),this.speed(0),this.state.isTouch=true,this.state.isScrolling=
false,this.state.isSwiping=false,this.drag.distance=0,p=e(L).x,N=e(L).y,this.drag.offsetX=this.$stage.position().left,this.drag.offsetY=this.$stage.position().top,this.settings.rtl&&(this.drag.offsetX=this.$stage.position().left+this.$stage.width()-this.width()+this.settings.margin),this.state.inMotion&&this.support3d){r=this.getTransformProperty();this.drag.offsetX=r;this.animate(r);this.state.inMotion=true}else if(this.state.inMotion&&!this.support3d)return this.state.inMotion=false,false;this.drag.startX=
p-this.drag.offsetX;this.drag.startY=N-this.drag.offsetY;this.drag.start=p-this.drag.startX;this.drag.targetEl=L.target||L.srcElement;this.drag.updatedX=this.drag.start;("IMG"===this.drag.targetEl.tagName||"A"===this.drag.targetEl.tagName)&&(this.drag.targetEl.draggable=false);b(n).on("mousemove.owl.dragEvents mouseup.owl.dragEvents touchmove.owl.dragEvents touchend.owl.dragEvents",b.proxy(function(x){this.eventsRouter(x)},this))};c.prototype.onDragMove=function(p){var L,N,r,x,m,F;this.state.isTouch&&
(this.state.isScrolling||(L=p.originalEvent||p||f.event,N=e(L).x,r=e(L).y,this.drag.currentX=N-this.drag.startX,this.drag.currentY=r-this.drag.startY,this.drag.distance=this.drag.currentX-this.drag.offsetX,this.drag.distance<0?this.state.direction=this.settings.rtl?"right":"left":this.drag.distance>0&&(this.state.direction=this.settings.rtl?"left":"right"),this.settings.loop?this.op(this.drag.currentX,">",this.coordinates(this.minimum()))&&"right"===this.state.direction?this.drag.currentX-=(this.settings.center&&
this.coordinates(0))-this.coordinates(this._items.length):this.op(this.drag.currentX,"<",this.coordinates(this.maximum()))&&"left"===this.state.direction&&(this.drag.currentX+=(this.settings.center&&this.coordinates(0))-this.coordinates(this._items.length)):(x=this.coordinates(this.settings.rtl?this.maximum():this.minimum()),m=this.coordinates(this.settings.rtl?this.minimum():this.maximum()),F=this.settings.pullDrag?this.drag.distance/5:0,this.drag.currentX=Math.max(Math.min(this.drag.currentX,x+
F),m+F)),(this.drag.distance>8||this.drag.distance<-8)&&(L.preventDefault!==g?L.preventDefault():L.returnValue=false,this.state.isSwiping=true),this.drag.updatedX=this.drag.currentX,(this.drag.currentY>16||this.drag.currentY<-16)&&this.state.isSwiping===false&&(this.state.isScrolling=true,this.drag.updatedX=this.drag.start),this.animate(this.drag.updatedX)))};c.prototype.onDragEnd=function(p){var L;if(this.state.isTouch){if("mouseup"===p.type&&this.$stage.removeClass("owl-grab"),this.trigger("dragged"),
this.drag.targetEl.removeAttribute("draggable"),this.state.isTouch=false,this.state.isScrolling=false,this.state.isSwiping=false,0===this.drag.distance&&this.state.inMotion!==true)return this.state.inMotion=false,false;this.drag.endTime=(new Date).getTime();p=this.drag.endTime-this.drag.startTime;L=Math.abs(this.drag.distance);(L>3||p>300)&&this.removeClick(this.drag.targetEl);p=this.closest(this.drag.updatedX);this.speed(this.settings.dragEndSpeed||this.settings.smartSpeed);this.current(p);this.invalidate("position");
this.update();this.settings.pullDrag||this.drag.updatedX!==this.coordinates(p)||this.transitionEnd();this.drag.distance=0;b(n).off(".owl.dragEvents")}};c.prototype.removeClick=function(p){this.drag.targetEl=p;b(p).on("click.preventClick",this.e._preventClick);f.setTimeout(function(){b(p).off("click.preventClick")},300)};c.prototype.preventClick=function(p){p.preventDefault?p.preventDefault():p.returnValue=false;p.stopPropagation&&p.stopPropagation();b(p.target).off("click.preventClick")};c.prototype.getTransformProperty=
function(){var p,L;return p=f.getComputedStyle(this.$stage.get(0),null).getPropertyValue(this.vendorName+"transform"),p=p.replace(/matrix(3d)?\(|\)/g,"").split(","),L=16===p.length,L!==true?p[4]:p[12]};c.prototype.closest=function(p){var L=-1,N=this.width(),r=this.coordinates();return this.settings.freeDrag||b.each(r,b.proxy(function(x,m){return p>m-30&&m+30>p?L=x:this.op(p,"<",m)&&this.op(p,">",r[x+1]||m-N)&&(L="left"===this.state.direction?x+1:x),-1===L},this)),this.settings.loop||(this.op(p,">",
r[this.minimum()])?L=p=this.minimum():this.op(p,"<",r[this.maximum()])&&(L=p=this.maximum())),L};c.prototype.animate=function(p){this.trigger("translate");this.state.inMotion=this.speed()>0;this.support3d?this.$stage.css({transform:"translate3d("+p+"px,0px, 0px)",transition:this.speed()/1E3+"s"}):this.state.isTouch?this.$stage.css({left:p+"px"}):this.$stage.animate({left:p},this.speed()/1E3,this.settings.fallbackEasing,b.proxy(function(){this.state.inMotion&&this.transitionEnd()},this))};c.prototype.current=
function(p){if(p===g)return this._current;if(0===this._items.length)return g;if(p=this.normalize(p),this._current!==p){var L=this.trigger("change",{property:{name:"position",value:p}});L.data!==g&&(p=this.normalize(L.data));this._current=p;this.invalidate("position");this.trigger("changed",{property:{name:"position",value:this._current}})}return this._current};c.prototype.invalidate=function(p){this._invalidated[p]=true};c.prototype.reset=function(p){p=this.normalize(p);p!==g&&(this._speed=0,this._current=
p,this.suppress(["translate","translated"]),this.animate(this.coordinates(p)),this.release(["translate","translated"]))};c.prototype.normalize=function(p,L){var N=L?this._items.length:this._items.length+this._clones.length;return!b.isNumeric(p)||1>N?g:this._clones.length?(p%N+N)%N:Math.max(this.minimum(L),Math.min(this.maximum(L),p))};c.prototype.relative=function(p){return p=this.normalize(p),p-=this._clones.length/2,this.normalize(p,true)};c.prototype.maximum=function(p){var L,N,r=0,x=this.settings;
if(p)return this._items.length-1;if(!x.loop&&x.center)L=this._items.length-1;else if(x.loop||x.center)if(x.loop||x.center)L=this._items.length+x.items;else{if(!x.autoWidth&&!x.merge)throw"Can not detect maximum absolute position.";revert=x.rtl?1:-1;for(p=this.$stage.width()-this.$element.width();(N=this.coordinates(r))&&!(N*revert>=p);)L=++r}else L=this._items.length-x.items;return L};c.prototype.minimum=function(p){return p?0:this._clones.length/2};c.prototype.items=function(p){return p===g?this._items.slice():
(p=this.normalize(p,true),this._items[p])};c.prototype.mergers=function(p){return p===g?this._mergers.slice():(p=this.normalize(p,true),this._mergers[p])};c.prototype.clones=function(p){var L=this._clones.length/2,N=L+this._items.length;return p===g?b.map(this._clones,function(r,x){return x%2===0?N+x/2:L-(x+1)/2}):b.map(this._clones,function(r,x){return r===p?x%2===0?N+x/2:L-(x+1)/2:null})};c.prototype.speed=function(p){return p!==g&&(this._speed=p),this._speed};c.prototype.coordinates=function(p){var L=
null;return p===g?b.map(this._coordinates,b.proxy(function(N,r){return this.coordinates(r)},this)):(this.settings.center?(L=this._coordinates[p],L+=(this.width()-L+(this._coordinates[p-1]||0))/2*(this.settings.rtl?-1:1)):L=this._coordinates[p-1]||0,L)};c.prototype.duration=function(p,L,N){return Math.min(Math.max(Math.abs(L-p),1),6)*Math.abs(N||this.settings.smartSpeed)};c.prototype.to=function(p,L){if(this.settings.loop){var N=p-this.relative(this.current()),r=this.current(),x=this.current(),m=this.current()+
N,F=0>x-m?true:false,V=this._clones.length+this._items.length;m<this.settings.items&&F===false?(r=x+this._items.length,this.reset(r)):m>=V-this.settings.items&&F===true&&(r=x-this._items.length,this.reset(r));f.clearTimeout(this.e._goToLoop);this.e._goToLoop=f.setTimeout(b.proxy(function(){this.speed(this.duration(this.current(),r+N,L));this.current(r+N);this.update()},this),30)}else{this.speed(this.duration(this.current(),p,L));this.current(p);this.update()}};c.prototype.next=function(p){this.to(this.relative(this.current())+
1,p||false)};c.prototype.prev=function(p){this.to(this.relative(this.current())-1,p||false)};c.prototype.transitionEnd=function(p){return p!==g&&(p.stopPropagation(),(p.target||p.srcElement||p.originalTarget)!==this.$stage.get(0))?false:(this.state.inMotion=false,void this.trigger("translated"))};c.prototype.viewport=function(){var p;if(this.options.responsiveBaseElement!==f)p=b(this.options.responsiveBaseElement).width();else if(f.innerWidth)p=f.innerWidth;else{if(!n.documentElement||!n.documentElement.clientWidth)throw"Can not detect viewport width.";
p=n.documentElement.clientWidth}return p};c.prototype.replace=function(p){this.$stage.empty();this._items=[];p&&(p=p instanceof jQuery?p:b(p));this.settings.nestedItemSelector&&(p=p.find("."+this.settings.nestedItemSelector));p.filter(function(){return 1===this.nodeType}).each(b.proxy(function(L,N){N=this.prepare(N);this.$stage.append(N);this._items.push(N);this._mergers.push(1*N.find("[data-merge]").andSelf("[data-merge]").attr("data-merge")||1)},this));this.reset(b.isNumeric(this.settings.startPosition)?
this.settings.startPosition:0);this.invalidate("items")};c.prototype.add=function(p,L){L=L===g?this._items.length:this.normalize(L,true);this.trigger("add",{content:p,position:L});0===this._items.length||L===this._items.length?(this.$stage.append(p),this._items.push(p),this._mergers.push(1*p.find("[data-merge]").andSelf("[data-merge]").attr("data-merge")||1)):(this._items[L].before(p),this._items.splice(L,0,p),this._mergers.splice(L,0,1*p.find("[data-merge]").andSelf("[data-merge]").attr("data-merge")||
1));this.invalidate("items");this.trigger("added",{content:p,position:L})};c.prototype.remove=function(p){p=this.normalize(p,true);p!==g&&(this.trigger("remove",{content:this._items[p],position:p}),this._items[p].remove(),this._items.splice(p,1),this._mergers.splice(p,1),this.invalidate("items"),this.trigger("removed",{content:null,position:p}))};c.prototype.addTriggerableEvents=function(){var p=b.proxy(function(L,N){return b.proxy(function(r){r.relatedTarget!==this&&(this.suppress([N]),L.apply(this,
[].slice.call(arguments,1)),this.release([N]))},this)},this);b.each({next:this.next,prev:this.prev,to:this.to,destroy:this.destroy,refresh:this.refresh,replace:this.replace,add:this.add,remove:this.remove},b.proxy(function(L,N){this.$element.on(L+".owl.carousel",p(N,L+".owl.carousel"))},this))};c.prototype.watchVisibility=function(){function p(N){return N.offsetWidth>0&&N.offsetHeight>0}function L(){p(this.$element.get(0))&&(this.$element.removeClass("owl-hidden"),this.refresh(),f.clearInterval(this.e._checkVisibile))}
p(this.$element.get(0))||(this.$element.addClass("owl-hidden"),f.clearInterval(this.e._checkVisibile),this.e._checkVisibile=f.setInterval(b.proxy(L,this),500))};c.prototype.preloadAutoWidthImages=function(p){var L,N,r,x;L=0;N=this;p.each(function(m,F){r=b(F);x=new Image;x.onload=function(){L++;r.attr("src",x.src);r.css("opacity",1);L>=p.length&&(N.state.imagesLoaded=true,N.initialize())};x.src=r.attr("src")||r.attr("data-src")||r.attr("data-src-retina")})};c.prototype.destroy=function(){this.$element.hasClass(this.settings.themeClass)&&
this.$element.removeClass(this.settings.themeClass);this.settings.responsive!==false&&b(f).off("resize.owl.carousel");this.transitionEndVendor&&this.off(this.$stage.get(0),this.transitionEndVendor,this.e._transitionEnd);for(var p in this._plugins)this._plugins[p].destroy();(this.settings.mouseDrag||this.settings.touchDrag)&&(this.$stage.off("mousedown touchstart touchcancel"),b(n).off(".owl.dragEvents"),this.$stage.get(0).onselectstart=function(){},this.$stage.off("dragstart",function(){return false}));
this.$element.off(".owl");this.$stage.children(".cloned").remove();this.e=null;this.$element.removeData("owlCarousel");this.$stage.children().contents().unwrap();this.$stage.children().unwrap();this.$stage.unwrap()};c.prototype.op=function(p,L,N){var r=this.settings.rtl;switch(L){case "<":return r?p>N:N>p;case ">":return r?N>p:p>N;case ">=":return r?N>=p:p>=N;case "<=":return r?p>=N:N>=p}};c.prototype.on=function(p,L,N,r){p.addEventListener?p.addEventListener(L,N,r):p.attachEvent&&p.attachEvent("on"+
L,N)};c.prototype.off=function(p,L,N,r){p.removeEventListener?p.removeEventListener(L,N,r):p.detachEvent&&p.detachEvent("on"+L,N)};c.prototype.trigger=function(p,L,N){var r={item:{count:this._items.length,index:this.current()}},x=b.camelCase(b.grep(["on",p,N],function(F){return F}).join("-").toLowerCase()),m=b.Event([p,"owl",N||"carousel"].join(".").toLowerCase(),b.extend({relatedTarget:this},r,L));return this._supress[p]||(b.each(this._plugins,function(F,V){V.onTrigger&&V.onTrigger(m)}),this.$element.trigger(m),
this.settings&&"function"==typeof this.settings[x]&&this.settings[x].apply(this,m)),m};c.prototype.suppress=function(p){b.each(p,b.proxy(function(L,N){this._supress[N]=true},this))};c.prototype.release=function(p){b.each(p,b.proxy(function(L,N){delete this._supress[N]},this))};c.prototype.browserSupport=function(){if(this.support3d=j(["perspective","webkitPerspective","MozPerspective","OPerspective","MsPerspective"])[0],this.support3d){this.transformVendor=j(["transform","WebkitTransform","MozTransform",
"OTransform","msTransform"])[0];this.transitionEndVendor=["transitionend","webkitTransitionEnd","transitionend","oTransitionEnd"][j(["transition","WebkitTransition","MozTransition","OTransition"])[1]];this.vendorName=this.transformVendor.replace(/Transform/i,"");this.vendorName=""!==this.vendorName?"-"+this.vendorName.toLowerCase()+"-":""}this.state.orientation=f.orientation};b.fn.owlCarousel=function(p){return this.each(function(){b(this).data("owlCarousel")||b(this).data("owlCarousel",new c(this,
p))})};b.fn.owlCarousel.Constructor=c})(window.Zepto||window.jQuery,window,document);
(function(b,f){var n=function(g){this._core=g;this._loaded=[];this._handlers={"initialized.owl.carousel change.owl.carousel":b.proxy(function(c){if(c.namespace&&this._core.settings&&this._core.settings.lazyLoad&&(c.property&&"position"==c.property.name||"initialized"==c.type)){var e=this._core.settings,j=e.center&&Math.ceil(e.items/2)||e.items;e=e.center&&-1*j||0;c=(c.property&&c.property.value||this._core.current())+e;for(var s=this._core.clones().length,w=b.proxy(function(K,p){this.load(p)},this);e++<
j;){this.load(s/2+this._core.relative(c));s&&b.each(this._core.clones(this._core.relative(c++)),w)}}},this)};this._core.options=b.extend({},n.Defaults,this._core.options);this._core.$element.on(this._handlers)};n.Defaults={lazyLoad:false};n.prototype.load=function(g){var c=(g=this._core.$stage.children().eq(g))&&g.find(".owl-lazy");!c||b.inArray(g.get(0),this._loaded)>-1||(c.each(b.proxy(function(e,j){var s,w=b(j),K=f.devicePixelRatio>1&&w.attr("data-src-retina")||w.attr("data-src");this._core.trigger("load",
{element:w,url:K},"lazy");w.is("img")?w.one("load.owl.lazy",b.proxy(function(){w.css("opacity",1);this._core.trigger("loaded",{element:w,url:K},"lazy")},this)).attr("src",K):(s=new Image,s.onload=b.proxy(function(){w.css({"background-image":"url("+K+")",opacity:"1"});this._core.trigger("loaded",{element:w,url:K},"lazy")},this),s.src=K)},this)),this._loaded.push(g.get(0)))};n.prototype.destroy=function(){var g,c;for(g in this.handlers)this._core.$element.off(g,this.handlers[g]);for(c in Object.getOwnPropertyNames(this))"function"!=
typeof this[c]&&(this[c]=null)};b.fn.owlCarousel.Constructor.Plugins.Lazy=n})(window.Zepto||window.jQuery,window,document);
(function(b){var f=function(n){this._core=n;this._handlers={"initialized.owl.carousel":b.proxy(function(){this._core.settings.autoHeight&&this.update()},this),"changed.owl.carousel":b.proxy(function(g){this._core.settings.autoHeight&&"position"==g.property.name&&this.update()},this),"loaded.owl.lazy":b.proxy(function(g){this._core.settings.autoHeight&&g.element.closest("."+this._core.settings.itemClass)===this._core.$stage.children().eq(this._core.current())&&this.update()},this)};this._core.options=
b.extend({},f.Defaults,this._core.options);this._core.$element.on(this._handlers)};f.Defaults={autoHeight:false,autoHeightClass:"owl-height"};f.prototype.update=function(){this._core.$stage.parent().height(this._core.$stage.children().eq(this._core.current()).height()).addClass(this._core.settings.autoHeightClass)};f.prototype.destroy=function(){var n,g;for(n in this._handlers)this._core.$element.off(n,this._handlers[n]);for(g in Object.getOwnPropertyNames(this))"function"!=typeof this[g]&&(this[g]=
null)};b.fn.owlCarousel.Constructor.Plugins.AutoHeight=f})(window.Zepto||window.jQuery,window,document);
(function(b,f,n){var g=function(c){this._core=c;this._videos={};this._playing=null;this._fullscreen=false;this._handlers={"resize.owl.carousel":b.proxy(function(e){this._core.settings.video&&!this.isInFullScreen()&&e.preventDefault()},this),"refresh.owl.carousel changed.owl.carousel":b.proxy(function(){this._playing&&this.stop()},this),"prepared.owl.carousel":b.proxy(function(e){var j=b(e.content).find(".owl-video");j.length&&(j.css("display","none"),this.fetch(j,b(e.content)))},this)};this._core.options=
b.extend({},g.Defaults,this._core.options);this._core.$element.on(this._handlers);this._core.$element.on("click.owl.video",".owl-video-play-icon",b.proxy(function(e){this.play(e)},this))};g.Defaults={video:false,videoHeight:false,videoWidth:false};g.prototype.fetch=function(c,e){var j=c.attr("data-vimeo-id")?"vimeo":"youtube",s=c.attr("data-vimeo-id")||c.attr("data-youtube-id"),w=c.attr("data-width")||this._core.settings.videoWidth,K=c.attr("data-height")||this._core.settings.videoHeight,p=c.attr("href");
if(!p)throw Error("Missing video URL.");if(s=p.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/),s[3].indexOf("youtu")>-1)j="youtube";else{if(!(s[3].indexOf("vimeo")>-1))throw Error("Video URL not supported.");j="vimeo"}s=s[6];this._videos[p]={type:j,id:s,width:w,height:K};e.attr("data-video",p);this.thumbnail(c,this._videos[p])};g.prototype.thumbnail=function(c,e){var j,s,w=e.width&&e.height?
'style="width:'+e.width+"px;height:"+e.height+'px;"':"",K=c.find("img"),p="src",L="",N=this._core.settings,r=function(x){j=N.lazyLoad?'<div class="owl-video-tn '+L+'" '+p+'="'+x+'"></div>':'<div class="owl-video-tn" style="opacity:1;background-image:url('+x+')"></div>';c.after(j);c.after('<div class="owl-video-play-icon"></div>')};return c.wrap('<div class="owl-video-wrapper"'+w+"></div>"),this._core.settings.lazyLoad&&(p="data-src",L="owl-lazy"),K.length?(r(K.attr(p)),K.remove(),false):void("youtube"===
e.type?(s="http://img.youtube.com/vi/"+e.id+"/hqdefault.jpg",r(s)):"vimeo"===e.type&&b.ajax({type:"GET",url:"http://vimeo.com/api/v2/video/"+e.id+".json",jsonp:"callback",dataType:"jsonp",success:function(x){s=x[0].thumbnail_large;r(s)}}))};g.prototype.stop=function(){this._core.trigger("stop",null,"video");this._playing.find(".owl-video-frame").remove();this._playing.removeClass("owl-video-playing");this._playing=null};g.prototype.play=function(c){this._core.trigger("play",null,"video");this._playing&&
this.stop();var e;c=b(c.target||c.srcElement);var j=c.closest("."+this._core.settings.itemClass),s=this._videos[j.attr("data-video")],w=s.width||"100%",K=s.height||this._core.$stage.height();"youtube"===s.type?e='<iframe width="'+w+'" height="'+K+'" src="http://www.youtube.com/embed/'+s.id+"?autoplay=1&v="+s.id+'" frameborder="0" allowfullscreen></iframe>':"vimeo"===s.type&&(e='<iframe src="http://player.vimeo.com/video/'+s.id+'?autoplay=1" width="'+w+'" height="'+K+'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
j.addClass("owl-video-playing");this._playing=j;e=b('<div style="height:'+K+"px; width:"+w+'px" class="owl-video-frame">'+e+"</div>");c.after(e)};g.prototype.isInFullScreen=function(){var c=n.fullscreenElement||n.mozFullScreenElement||n.webkitFullscreenElement;return c&&b(c).parent().hasClass("owl-video-frame")&&(this._core.speed(0),this._fullscreen=true),c&&this._fullscreen&&this._playing?false:this._fullscreen?(this._fullscreen=false,false):this._playing&&this._core.state.orientation!==f.orientation?
(this._core.state.orientation=f.orientation,false):true};g.prototype.destroy=function(){var c,e;this._core.$element.off("click.owl.video");for(c in this._handlers)this._core.$element.off(c,this._handlers[c]);for(e in Object.getOwnPropertyNames(this))"function"!=typeof this[e]&&(this[e]=null)};b.fn.owlCarousel.Constructor.Plugins.Video=g})(window.Zepto||window.jQuery,window,document);
(function(b,f,n,g){var c=function(e){this.core=e;this.core.options=b.extend({},c.Defaults,this.core.options);this.swapping=true;this.next=this.previous=g;this.handlers={"change.owl.carousel":b.proxy(function(j){"position"==j.property.name&&(this.previous=this.core.current(),this.next=j.property.value)},this),"drag.owl.carousel dragged.owl.carousel translated.owl.carousel":b.proxy(function(j){this.swapping="translated"==j.type},this),"translate.owl.carousel":b.proxy(function(){this.swapping&&(this.core.options.animateOut||
this.core.options.animateIn)&&this.swap()},this)};this.core.$element.on(this.handlers)};c.Defaults={animateOut:false,animateIn:false};c.prototype.swap=function(){if(1===this.core.settings.items&&this.core.support3d){this.core.speed(0);var e,j=b.proxy(this.clear,this),s=this.core.$stage.children().eq(this.previous),w=this.core.$stage.children().eq(this.next),K=this.core.settings.animateIn,p=this.core.settings.animateOut;this.core.current()!==this.previous&&(p&&(e=this.core.coordinates(this.previous)-
this.core.coordinates(this.next),s.css({left:e+"px"}).addClass("animated owl-animated-out").addClass(p).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",j)),K&&w.addClass("animated owl-animated-in").addClass(K).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",j))}};c.prototype.clear=function(e){b(e.target).css({left:""}).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut);
this.core.transitionEnd()};c.prototype.destroy=function(){var e,j;for(e in this.handlers)this.core.$element.off(e,this.handlers[e]);for(j in Object.getOwnPropertyNames(this))"function"!=typeof this[j]&&(this[j]=null)};b.fn.owlCarousel.Constructor.Plugins.Animate=c})(window.Zepto||window.jQuery,window,document);
(function(b,f,n){var g=function(c){this.core=c;this.core.options=b.extend({},g.Defaults,this.core.options);this.handlers={"translated.owl.carousel refreshed.owl.carousel":b.proxy(function(){this.autoplay()},this),"play.owl.autoplay":b.proxy(function(e,j,s){this.play(j,s)},this),"stop.owl.autoplay":b.proxy(function(){this.stop()},this),"mouseover.owl.autoplay":b.proxy(function(){this.core.settings.autoplayHoverPause&&this.pause()},this),"mouseleave.owl.autoplay":b.proxy(function(){this.core.settings.autoplayHoverPause&&
this.autoplay()},this)};this.core.$element.on(this.handlers)};g.Defaults={autoplay:false,autoplayTimeout:5E3,autoplayHoverPause:false,autoplaySpeed:false};g.prototype.autoplay=function(){this.core.settings.autoplay&&!this.core.state.videoPlay?(f.clearInterval(this.interval),this.interval=f.setInterval(b.proxy(function(){this.play()},this),this.core.settings.autoplayTimeout)):f.clearInterval(this.interval)};g.prototype.play=function(){return n.hidden===true||this.core.state.isTouch||this.core.state.isScrolling||
this.core.state.isSwiping||this.core.state.inMotion?void 0:this.core.settings.autoplay===false?void f.clearInterval(this.interval):void this.core.next(this.core.settings.autoplaySpeed)};g.prototype.stop=function(){f.clearInterval(this.interval)};g.prototype.pause=function(){f.clearInterval(this.interval)};g.prototype.destroy=function(){var c,e;f.clearInterval(this.interval);for(c in this.handlers)this.core.$element.off(c,this.handlers[c]);for(e in Object.getOwnPropertyNames(this))"function"!=typeof this[e]&&
(this[e]=null)};b.fn.owlCarousel.Constructor.Plugins.autoplay=g})(window.Zepto||window.jQuery,window,document);
(function(b){var f=function(n){this._core=n;this._initialized=false;this._pages=[];this._controls={};this._templates=[];this.$element=this._core.$element;this._overrides={next:this._core.next,prev:this._core.prev,to:this._core.to};this._handlers={"prepared.owl.carousel":b.proxy(function(g){this._core.settings.dotsData&&this._templates.push(b(g.content).find("[data-dot]").andSelf("[data-dot]").attr("data-dot"))},this),"add.owl.carousel":b.proxy(function(g){this._core.settings.dotsData&&this._templates.splice(g.position,
0,b(g.content).find("[data-dot]").andSelf("[data-dot]").attr("data-dot"))},this),"remove.owl.carousel prepared.owl.carousel":b.proxy(function(g){this._core.settings.dotsData&&this._templates.splice(g.position,1)},this),"change.owl.carousel":b.proxy(function(g){if("position"==g.property.name&&!this._core.state.revert&&!this._core.settings.loop&&this._core.settings.navRewind){var c=this._core.current(),e=this._core.maximum(),j=this._core.minimum();g.data=g.property.value>e?c>=e?j:e:g.property.value<
j?e:g.property.value}},this),"changed.owl.carousel":b.proxy(function(g){"position"==g.property.name&&this.draw()},this),"refreshed.owl.carousel":b.proxy(function(){this._initialized||(this.initialize(),this._initialized=true);this._core.trigger("refresh",null,"navigation");this.update();this.draw();this._core.trigger("refreshed",null,"navigation")},this)};this._core.options=b.extend({},f.Defaults,this._core.options);this.$element.on(this._handlers)};f.Defaults={nav:false,navRewind:true,navText:["prev",
"next"],navSpeed:false,navElement:"div",navContainer:false,navContainerClass:"owl-nav",navClass:["owl-prev","owl-next"],slideBy:1,dotClass:"owl-dot",dotsClass:"owl-dots",dots:true,dotsEach:false,dotData:false,dotsSpeed:false,dotsContainer:false,controlsClass:"owl-controls"};f.prototype.initialize=function(){var n,g,c=this._core.settings;c.dotsData||(this._templates=[b("<div>").addClass(c.dotClass).append(b("<span>")).prop("outerHTML")]);c.navContainer&&c.dotsContainer||(this._controls.$container=
b("<div>").addClass(c.controlsClass).appendTo(this.$element));this._controls.$indicators=c.dotsContainer?b(c.dotsContainer):b("<div>").hide().addClass(c.dotsClass).appendTo(this._controls.$container);this._controls.$indicators.on("click","div",b.proxy(function(e){var j=b(e.target).parent().is(this._controls.$indicators)?b(e.target).index():b(e.target).parent().index();e.preventDefault();this.to(j,c.dotsSpeed)},this));n=c.navContainer?b(c.navContainer):b("<div>").addClass(c.navContainerClass).prependTo(this._controls.$container);
this._controls.$next=b("<"+c.navElement+">");this._controls.$previous=this._controls.$next.clone();this._controls.$previous.addClass(c.navClass[0]).html(c.navText[0]).hide().prependTo(n).on("click",b.proxy(function(){this.prev(c.navSpeed)},this));this._controls.$next.addClass(c.navClass[1]).html(c.navText[1]).hide().appendTo(n).on("click",b.proxy(function(){this.next(c.navSpeed)},this));for(g in this._overrides)this._core[g]=b.proxy(this[g],this)};f.prototype.destroy=function(){var n,g,c,e;for(n in this._handlers)this.$element.off(n,
this._handlers[n]);for(g in this._controls)this._controls[g].remove();for(e in this.overides)this._core[e]=this._overrides[e];for(c in Object.getOwnPropertyNames(this))"function"!=typeof this[c]&&(this[c]=null)};f.prototype.update=function(){var n,g,c;n=this._core.settings;var e=this._core.clones().length/2,j=e+this._core.items().length,s=n.center||n.autoWidth||n.dotData?1:n.dotsEach||n.items;if("page"!==n.slideBy&&(n.slideBy=Math.min(n.slideBy,n.items)),n.dots||"page"==n.slideBy){this._pages=[];
n=e;for(c=g=0;j>n;n++){(g>=s||0===g)&&(this._pages.push({start:n-e,end:n-e+s-1}),g=0,++c);g+=this._core.mergers(this._core.relative(n))}}};f.prototype.draw=function(){var n,g="",c=this._core.settings,e=(this._core.$stage.children(),this._core.relative(this._core.current()));if(!c.nav||c.loop||c.navRewind||(this._controls.$previous.toggleClass("disabled",0>=e),this._controls.$next.toggleClass("disabled",e>=this._core.maximum())),this._controls.$previous.toggle(c.nav),this._controls.$next.toggle(c.nav),
c.dots){if(n=this._pages.length-this._controls.$indicators.children().length,c.dotData&&0!==n){for(n=0;n<this._controls.$indicators.children().length;n++)g+=this._templates[this._core.relative(n)];this._controls.$indicators.html(g)}else n>0?(g=Array(n+1).join(this._templates[0]),this._controls.$indicators.append(g)):0>n&&this._controls.$indicators.children().slice(n).remove();this._controls.$indicators.find(".active").removeClass("active");this._controls.$indicators.children().eq(b.inArray(this.current(),
this._pages)).addClass("active")}this._controls.$indicators.toggle(c.dots)};f.prototype.onTrigger=function(n){var g=this._core.settings;n.page={index:b.inArray(this.current(),this._pages),count:this._pages.length,size:g&&(g.center||g.autoWidth||g.dotData?1:g.dotsEach||g.items)}};f.prototype.current=function(){var n=this._core.relative(this._core.current());return b.grep(this._pages,function(g){return g.start<=n&&g.end>=n}).pop()};f.prototype.getPosition=function(n){var g,c=this._core.settings;return"page"==
c.slideBy?(g=b.inArray(this.current(),this._pages),n?++g:--g):(g=this._core.relative(this._core.current()),this._core.items(),n?g+=c.slideBy:g-=c.slideBy),g};f.prototype.next=function(n){b.proxy(this._overrides.to,this._core)(this.getPosition(true),n)};f.prototype.prev=function(n){b.proxy(this._overrides.to,this._core)(this.getPosition(false),n)};f.prototype.to=function(n,g,c){var e;c?b.proxy(this._overrides.to,this._core)(n,g):(e=this._pages.length,b.proxy(this._overrides.to,this._core)(this._pages[(n%
e+e)%e].start,g))};b.fn.owlCarousel.Constructor.Plugins.Navigation=f})(window.Zepto||window.jQuery,window,document);
(function(b,f){var n=function(g){this._core=g;this._hashes={};this.$element=this._core.$element;this._handlers={"initialized.owl.carousel":b.proxy(function(){"URLHash"==this._core.settings.startPosition&&b(f).trigger("hashchange.owl.navigation")},this),"prepared.owl.carousel":b.proxy(function(c){this._hashes[b(c.content).find("[data-hash]").andSelf("[data-hash]").attr("data-hash")]=c.content},this)};this._core.options=b.extend({},n.Defaults,this._core.options);this.$element.on(this._handlers);b(f).on("hashchange.owl.navigation",
b.proxy(function(){var c=f.location.hash.substring(1),e=this._core.$stage.children();e=this._hashes[c]&&e.index(this._hashes[c])||0;return c?void this._core.to(e,false,true):false},this))};n.Defaults={URLhashListener:false};n.prototype.destroy=function(){var g,c;b(f).off("hashchange.owl.navigation");for(g in this._handlers)this._core.$element.off(g,this._handlers[g]);for(c in Object.getOwnPropertyNames(this))"function"!=typeof this[c]&&(this[c]=null)};b.fn.owlCarousel.Constructor.Plugins.Hash=n})(window.Zepto||
window.jQuery,window,document);function UpdateForm(){document.forms.checkout_payment.action="index.php?main_page=checkout_payment";document.forms.checkout_payment.submit()}
(function(){function b(g){if(!g)throw Error("No options passed to Waypoint constructor");if(!g.element)throw Error("No element option passed to Waypoint constructor");if(!g.handler)throw Error("No handler option passed to Waypoint constructor");this.key="waypoint-"+f;this.options=b.Adapter.extend({},b.defaults,g);this.element=this.options.element;this.adapter=new b.Adapter(this.element);this.callback=g.handler;this.axis=this.options.horizontal?"horizontal":"vertical";this.enabled=this.options.enabled;
this.triggerPoint=null;this.group=b.Group.findOrCreate({name:this.options.group,axis:this.axis});this.context=b.Context.findOrCreateByElement(this.options.context);b.offsetAliases[this.options.offset]&&(this.options.offset=b.offsetAliases[this.options.offset]);this.group.add(this);this.context.add(this);n[this.key]=this;f+=1}var f=0,n={};b.prototype.queueTrigger=function(g){this.group.queueTrigger(this,g)};b.prototype.trigger=function(g){this.enabled&&this.callback&&this.callback.apply(this,g)};b.prototype.destroy=
function(){this.context.remove(this);this.group.remove(this);delete n[this.key]};b.prototype.disable=function(){return this.enabled=false,this};b.prototype.enable=function(){return this.context.refresh(),this.enabled=true,this};b.prototype.next=function(){return this.group.next(this)};b.prototype.previous=function(){return this.group.previous(this)};b.destroyAll=function(){var g=[],c;for(c in n)g.push(n[c]);c=0;for(var e=g.length;e>c;c++)g[c].destroy()};b.refreshAll=function(){b.Context.refreshAll()};
b.viewportHeight=function(){return window.innerHeight||document.documentElement.clientHeight};b.viewportWidth=function(){return document.documentElement.clientWidth};b.adapters=[];b.defaults={context:window,continuous:true,enabled:true,group:"default",horizontal:false,offset:0};b.offsetAliases={"bottom-in-view":function(){return this.context.innerHeight()-this.adapter.outerHeight()},"right-in-view":function(){return this.context.innerWidth()-this.adapter.outerWidth()}};window.Waypoint=b})();
(function(){function b(s){window.setTimeout(s,1E3/60)}function f(s){this.element=s;this.Adapter=c.Adapter;this.adapter=new this.Adapter(s);this.key="waypoint-context-"+n;this.didResize=this.didScroll=false;this.oldScroll={x:this.adapter.scrollLeft(),y:this.adapter.scrollTop()};this.waypoints={vertical:{},horizontal:{}};s.waypointContextKey=this.key;g[s.waypointContextKey]=this;n+=1;this.createThrottledScrollHandler();this.createThrottledResizeHandler()}var n=0,g={},c=window.Waypoint,e=window.requestAnimationFrame||
window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||b,j=window.onload;f.prototype.add=function(s){this.waypoints[s.options.horizontal?"horizontal":"vertical"][s.key]=s;this.refresh()};f.prototype.checkEmpty=function(){var s=this.Adapter.isEmptyObject(this.waypoints.horizontal),w=this.Adapter.isEmptyObject(this.waypoints.vertical);s&&w&&(this.adapter.off(".waypoints"),delete g[this.key])};f.prototype.createThrottledResizeHandler=function(){function s(){w.handleResize();w.didResize=
false}var w=this;this.adapter.on("resize.waypoints",function(){w.didResize||(w.didResize=true,e(s))})};f.prototype.createThrottledScrollHandler=function(){function s(){w.handleScroll();w.didScroll=false}var w=this;this.adapter.on("scroll.waypoints",function(){(!w.didScroll||c.isTouch)&&(w.didScroll=true,e(s))})};f.prototype.handleResize=function(){c.Context.refreshAll()};f.prototype.handleScroll=function(){var s={},w={horizontal:{newScroll:this.adapter.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",
backward:"left"},vertical:{newScroll:this.adapter.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}},K;for(K in w){var p=w[K],L=p.newScroll>p.oldScroll?p.forward:p.backward,N;for(N in this.waypoints[K]){var r=this.waypoints[K][N],x=p.oldScroll<r.triggerPoint,m=p.newScroll>=r.triggerPoint,F=!x&&!m;(x&&m||F)&&(r.queueTrigger(L),s[r.group.id]=r.group)}}for(var V in s)s[V].flushTriggers();this.oldScroll={x:w.horizontal.newScroll,y:w.vertical.newScroll}};f.prototype.innerHeight=function(){return this.element===
this.element.window?c.viewportHeight():this.adapter.innerHeight()};f.prototype.remove=function(s){delete this.waypoints[s.axis][s.key];this.checkEmpty()};f.prototype.innerWidth=function(){return this.element===this.element.window?c.viewportWidth():this.adapter.innerWidth()};f.prototype.destroy=function(){var s=[],w;for(w in this.waypoints)for(var K in this.waypoints[w])s.push(this.waypoints[w][K]);w=0;for(K=s.length;K>w;w++)s[w].destroy()};f.prototype.refresh=function(){var s;s=this.element===this.element.window;
var w=this.adapter.offset(),K={};this.handleScroll();s={horizontal:{contextOffset:s?0:w.left,contextScroll:s?0:this.oldScroll.x,contextDimension:this.innerWidth(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:s?0:w.top,contextScroll:s?0:this.oldScroll.y,contextDimension:this.innerHeight(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};for(var p in s){w=s[p];for(var L in this.waypoints[p]){var N,r,x,m=this.waypoints[p][L];
x=m.options.offset;N=m.triggerPoint;r=0;var F=null==N;m.element!==m.element.window&&(r=m.adapter.offset()[w.offsetProp]);"function"==typeof x?x=x.apply(m):"string"==typeof x&&(x=parseFloat(x),m.options.offset.indexOf("%")>-1&&(x=Math.ceil(w.contextDimension*x/100)));m.triggerPoint=r+(w.contextScroll-w.contextOffset)-x;N=N<w.oldScroll;r=m.triggerPoint>=w.oldScroll;x=N&&r;N=!N&&!r;!F&&x?(m.queueTrigger(w.backward),K[m.group.id]=m.group):!F&&N?(m.queueTrigger(w.forward),K[m.group.id]=m.group):F&&w.oldScroll>=
m.triggerPoint&&(m.queueTrigger(w.forward),K[m.group.id]=m.group)}}for(var V in K)K[V].flushTriggers();return this};f.findOrCreateByElement=function(s){return f.findByElement(s)||new f(s)};f.refreshAll=function(){for(var s in g)g[s].refresh()};f.findByElement=function(s){return g[s.waypointContextKey]};window.onload=function(){j&&j();f.refreshAll()};c.Context=f})();
(function(){function b(e,j){return e.triggerPoint-j.triggerPoint}function f(e,j){return j.triggerPoint-e.triggerPoint}function n(e){this.name=e.name;this.axis=e.axis;this.id=this.name+"-"+this.axis;this.waypoints=[];this.clearTriggerQueues();g[this.axis][this.name]=this}var g={vertical:{},horizontal:{}},c=window.Waypoint;n.prototype.add=function(e){this.waypoints.push(e)};n.prototype.clearTriggerQueues=function(){this.triggerQueues={up:[],down:[],left:[],right:[]}};n.prototype.flushTriggers=function(){for(var e in this.triggerQueues){var j=
this.triggerQueues[e];j.sort("up"===e||"left"===e?f:b);for(var s=0,w=j.length;w>s;s+=1){var K=j[s];(K.options.continuous||s===j.length-1)&&K.trigger([e])}}this.clearTriggerQueues()};n.prototype.next=function(e){this.waypoints.sort(b);e=c.Adapter.inArray(e,this.waypoints);return e===this.waypoints.length-1?null:this.waypoints[e+1]};n.prototype.previous=function(e){this.waypoints.sort(b);return(e=c.Adapter.inArray(e,this.waypoints))?this.waypoints[e-1]:null};n.prototype.queueTrigger=function(e,j){this.triggerQueues[j].push(e)};
n.prototype.remove=function(e){e=c.Adapter.inArray(e,this.waypoints);e>-1&&this.waypoints.splice(e,1)};n.prototype.first=function(){return this.waypoints[0]};n.prototype.last=function(){return this.waypoints[this.waypoints.length-1]};n.findOrCreate=function(e){return g[e.axis][e.name]||new n(e)};c.Group=n})();
(function(){function b(g){this.$element=f(g)}var f=window.jQuery,n=window.Waypoint;f.each(["innerHeight","innerWidth","off","offset","on","outerHeight","outerWidth","scrollLeft","scrollTop"],function(g,c){b.prototype[c]=function(){var e=Array.prototype.slice.call(arguments);return this.$element[c].apply(this.$element,e)}});f.each(["extend","inArray","isEmptyObject"],function(g,c){b[c]=f[c]});n.adapters.push({name:"jquery",Adapter:b});n.Adapter=b})();
(function(){function b(n){return function(g,c){var e=[],j=g;return n.isFunction(g)&&(j=n.extend({},c),j.handler=g),this.each(function(){var s=n.extend({},j,{element:this});"string"==typeof s.context&&(s.context=n(this).closest(s.context)[0]);e.push(new f(s))}),e}}var f=window.Waypoint;window.jQuery&&(window.jQuery.fn.waypoint=b(window.jQuery));window.Zepto&&(window.Zepto.fn.waypoint=b(window.Zepto))})();
(function(){function b(g){this.options=f.extend({},n.defaults,b.defaults,g);this.element=this.options.element;this.$element=f(this.element);this.createWrapper();this.createWaypoint()}var f=window.jQuery,n=window.Waypoint;b.prototype.createWaypoint=function(){var g=this.options.handler;this.waypoint=new n(f.extend({},this.options,{element:this.wrapper,handler:f.proxy(function(c){var e=this.options.direction.indexOf(c)>-1;this.$wrapper.height(e?this.$element.outerHeight(true):"");this.$element.toggleClass(this.options.stuckClass,
e);g&&g.call(this,c)},this)}))};b.prototype.createWrapper=function(){this.$element.wrap(this.options.wrapper);this.$wrapper=this.$element.parent();this.wrapper=this.$wrapper[0]};b.prototype.destroy=function(){this.$element.parent()[0]===this.wrapper&&(this.waypoint.destroy(),this.$element.removeClass(this.options.stuckClass).unwrap())};b.defaults={wrapper:'<div class="sticky-wrapper" ></div>',stuckClass:"stuck",direction:"down right"};n.Sticky=b})();
jQuery(document).ready(function(){jQuery(".header-wrap").hasClass("sticky")&&new Waypoint.Sticky({element:jQuery(".nav-bot")[0],stuckClass:"nav-fixed"});jQuery(window).scroll(function(){jQuery(this).scrollTop()>768?jQuery("#back-top").fadeIn():jQuery("#back-top").fadeOut()});jQuery("#back-top a").click(function(n){n.preventDefault();jQuery("body,html").animate({scrollTop:0},800);return false});jQuery("#menu-button a").click(function(n){n.preventDefault();jQuery("body").toggleClass("opened-menu")});
jQuery(".cart-popup-content > ul").perfectScrollbar({suppressScrollX:true});jQuery('[data-toggle="pt-inlightbox"]').magnificPopup({type:"inline",midClick:true,closeBtnInside:true,callbacks:{open:function(){jQuery(".cart-popup-content > ul").perfectScrollbar("update");jQuery("body").addClass("mfp-body-open")},close:function(){jQuery("body").removeClass("mfp-body-open")}}});jQuery('[data-toggle="pt-ajaxlightbox"]').magnificPopup({type:"ajax",midClick:true,closeOnContentClick:false});jQuery('[data-toggle="pt-quickview"]').magnificPopup({type:"ajax",
midClick:true,closeOnContentClick:false,callbacks:{parseAjax:function(n){n.data=jQuery(n.data).find(".product-info-detail-inner")},ajaxContentAdded:function(){var n=jQuery("#productMainImage.img-carousel").owlCarousel({items:1,margin:0,nav:true,navRewind:false,center:false,loop:false,URLhashListener:true,navText:['<i class="fa fa-angle-left">','<i class="fa fa-angle-right">']});jQuery("#productAdditionalImage.img-thumb").on("initialized.owl.carousel",function(c){jQuery(c.target).find(".owl-item").first().addClass("current-item")});
var g=jQuery("#productAdditionalImage.img-thumb").owlCarousel({items:3,margin:15,nav:true,navRewind:false,loop:false,navText:['<i class="fa fa-angle-left">','<i class="fa fa-angle-right">']});n.on("change.owl.carousel",function(c){if(c.namespace&&c.property.name==="position"){var e=c.relatedTarget.relative(c.property.value);jQuery("#productAdditionalImage.img-thumb .owl-item.current-item").removeClass("current-item");jQuery("#productAdditionalImage.img-thumb .owl-item").each(function(j){if(e==j){jQuery(this).hasClass("active")||
g.trigger("to.owl.carousel",[e,250]);jQuery(this).addClass("current-item")}})}});jQuery(".img-thumb a").click(function(c){c.preventDefault();c=jQuery(this).attr("data-target");n.trigger("to.owl.carousel",[c,300])});jQuery(".cart-qty .qty-control").click(function(c){c.preventDefault();c=jQuery(this);var e=c.parent().parent().find("input").val();e=c.hasClass("cart-qty-inc")?parseFloat(e)+1:e>0?parseFloat(e)-1:0;c.parent().parent().find("input").val(e)})}}});jQuery('[data-toggle="pt-closelightbox"]').click(function(n){n.preventDefault();
jQuery.magnificPopup.close()});jQuery('[data-toggle="pt-search"]').click(function(n){n.preventDefault();jQuery(this).toggleClass("on");jQuery(".search-header").toggleClass("active");setTimeout(function(){jQuery("#head-search").focus()},100);jQuery(".account-list, .cart-list").toggleClass("stealth")});jQuery("#grid-switch").click(function(n){n.preventDefault();jQuery("#list-switch").removeClass("active");jQuery(this).addClass("active");jQuery("#productListing").removeClass("list").addClass("grid")});
jQuery("#list-switch").click(function(n){n.preventDefault();jQuery("#grid-switch").removeClass("active");jQuery(this).addClass("active");jQuery("#productListing").removeClass("grid").addClass("list")});jQuery(".main-menu.style1 ul.menu > li.dd-parent ul.dd-menu").each(function(){var n="-"+jQuery(this).outerWidth(true)/2+"px";jQuery(this).css({"margin-left":n})});jQuery(".owl-carousel").on("initialized.owl.carousel",function(n){jQuery(n.target).closest(".section-content").find(".preloader-wrap").addClass("animated fadeOut").hide();
jQuery(n.target).closest(".section-content-inner").removeClass("hide-first").addClass("animated fadeIn")});jQuery(".product-carousel, .brand-carousel").owlCarousel({items:5,margin:20,nav:true,autoplay:true,loop:true,autoplayHoverPause:true,navRewind:false,navText:['<i class="fa fa-angle-left">','<i class="fa fa-angle-right">'],responsiveClass:true,responsive:{0:{items:1,nav:false},480:{items:3,nav:true},991:{items:4,nav:true},1199:{items:5,nav:true}}});jQuery(".tweet-carousel").owlCarousel({items:1,
margin:0,nav:true,navRewind:false,autoplay:true,autoplayHoverPause:true,navText:['<i class="fa fa-angle-left">','<i class="fa fa-angle-right">']});var b=jQuery("#productMainImage.img-carousel").owlCarousel({items:1,margin:0,nav:true,navRewind:false,center:false,loop:false,URLhashListener:true,navText:['<i class="fa fa-angle-left">','<i class="fa fa-angle-right">']});jQuery("#productAdditionalImage.img-thumb").on("initialized.owl.carousel",function(n){jQuery(n.target).find(".owl-item").first().addClass("current-item")});
var f=jQuery("#productAdditionalImage.img-thumb").owlCarousel({items:3,margin:15,nav:true,navRewind:false,loop:false,navText:['<i class="fa fa-angle-left">','<i class="fa fa-angle-right">']});b.on("change.owl.carousel",function(n){if(n.namespace&&n.property.name==="position"){var g=n.relatedTarget.relative(n.property.value);jQuery("#productAdditionalImage.img-thumb .owl-item.current-item").removeClass("current-item");jQuery("#productAdditionalImage.img-thumb .owl-item").each(function(c){if(g==c){jQuery(this).hasClass("active")||
f.trigger("to.owl.carousel",[g,250]);jQuery(this).addClass("current-item")}})}});jQuery(".img-thumb a").click(function(n){n.preventDefault();n=jQuery(this).attr("data-target");b.trigger("to.owl.carousel",[n,300])});jQuery('[data-toggle="pt-tooltip"]').tooltip({container:"body"});jQuery(".cart-qty .qty-control").click(function(n){n.preventDefault();n=jQuery(this);var g=n.parent().parent().find("input").val();g=n.hasClass("cart-qty-inc")?parseFloat(g)+1:g>0?parseFloat(g)-1:0;n.parent().parent().find("input").val(g)});
jQuery("#rate-it i").click(function(){var n=jQuery(this).attr("data-value");jQuery("#rate-it i").removeClass("filled");for(var g=1;g<=parseInt(n);g++)jQuery("#rate-"+g).addClass("filled");jQuery("#rating-"+n).prop("checked",true)});jQuery(".img-carousel").magnificPopup({delegate:".image-popup",type:"image",mainClass:"mfp-no-margins mfp-with-zoom",gallery:{enabled:true,navigateByImgClick:true,preload:[0,1],tPrev:"",tNext:"",tCounter:""},image:{tError:'<a href="%url%">The image #%curr%</a> could not be loaded.'}});
jQuery("#review-trigger").click(function(n){n.preventDefault();n=jQuery(this).attr("href");jQuery("#product-tabs").find("li.active").removeClass("active");jQuery("#product-tabs").find('a[href="'+n+'"]').parent("li").addClass("active");jQuery("html, body").animate({scrollTop:jQuery("#product-tabs").offset().top-80},1E3)})});var geocoder,map;
function initialize(){geocoder=new google.maps.Geocoder;if(jQuery("#map-canvas").attr("data-map-lat")!=""&&jQuery("#map-canvas").attr("data-map-lon")!="")var b={zoom:parseInt(jQuery("#map-canvas").attr("data-map-zoom")),center:new google.maps.LatLng(parseFloat(jQuery("#map-canvas").attr("data-map-lat")),parseFloat(jQuery("#map-canvas").attr("data-map-lon"))),disableDefaultUI:true};else{codeAddress();b={zoom:parseInt(jQuery("#map-canvas").attr("data-map-zoom")),center:new google.maps.LatLng(0,0),disableDefaultUI:true}}map=
new google.maps.Map(document.getElementById("map-canvas"),b)}function codeAddress(){var b=jQuery("#map-canvas").attr("data-map-address");geocoder.geocode({address:b},function(f,n){if(n==google.maps.GeocoderStatus.OK){map.setCenter(f[0].geometry.location);new google.maps.Marker({map:map,position:f[0].geometry.location})}else map.setCenter(0,0)})}
function loadScript(){var b=document.createElement("script");b.type="text/javascript";b.src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize";document.body.appendChild(b)};





// Magnific Popup v0.9.9 by Dmitry Semenov
// http://bit.ly/magnific-popup#build=inline+image+ajax+iframe+gallery+retina+imagezoom+fastclick
(function(a){var b="Close",c="BeforeClose",d="AfterClose",e="BeforeAppend",f="MarkupParse",g="Open",h="Change",i="mfp",j="."+i,k="mfp-ready",l="mfp-removing",m="mfp-prevent-close",n,o=function(){},p=!!window.jQuery,q,r=a(window),s,t,u,v,w,x=function(a,b){n.ev.on(i+a+j,b)},y=function(b,c,d,e){var f=document.createElement("div");return f.className="mfp-"+b,d&&(f.innerHTML=d),e?c&&c.appendChild(f):(f=a(f),c&&f.appendTo(c)),f},z=function(b,c){n.ev.triggerHandler(i+b,c),n.st.callbacks&&(b=b.charAt(0).toLowerCase()+b.slice(1),n.st.callbacks[b]&&n.st.callbacks[b].apply(n,a.isArray(c)?c:[c]))},A=function(b){if(b!==w||!n.currTemplate.closeBtn)n.currTemplate.closeBtn=a(n.st.closeMarkup.replace("%title%",n.st.tClose)),w=b;return n.currTemplate.closeBtn},B=function(){a.magnificPopup.instance||(n=new o,n.init(),a.magnificPopup.instance=n)},C=function(){var a=document.createElement("p").style,b=["ms","O","Moz","Webkit"];if(a.transition!==undefined)return!0;while(b.length)if(b.pop()+"Transition"in a)return!0;return!1};o.prototype={constructor:o,init:function(){var b=navigator.appVersion;n.isIE7=b.indexOf("MSIE 7.")!==-1,n.isIE8=b.indexOf("MSIE 8.")!==-1,n.isLowIE=n.isIE7||n.isIE8,n.isAndroid=/android/gi.test(b),n.isIOS=/iphone|ipad|ipod/gi.test(b),n.supportsTransition=C(),n.probablyMobile=n.isAndroid||n.isIOS||/(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent),t=a(document),n.popupsCache={}},open:function(b){s||(s=a(document.body));var c;if(b.isObj===!1){n.items=b.items.toArray(),n.index=0;var d=b.items,e;for(c=0;c<d.length;c++){e=d[c],e.parsed&&(e=e.el[0]);if(e===b.el[0]){n.index=c;break}}}else n.items=a.isArray(b.items)?b.items:[b.items],n.index=b.index||0;if(n.isOpen){n.updateItemHTML();return}n.types=[],v="",b.mainEl&&b.mainEl.length?n.ev=b.mainEl.eq(0):n.ev=t,b.key?(n.popupsCache[b.key]||(n.popupsCache[b.key]={}),n.currTemplate=n.popupsCache[b.key]):n.currTemplate={},n.st=a.extend(!0,{},a.magnificPopup.defaults,b),n.fixedContentPos=n.st.fixedContentPos==="auto"?!n.probablyMobile:n.st.fixedContentPos,n.st.modal&&(n.st.closeOnContentClick=!1,n.st.closeOnBgClick=!1,n.st.showCloseBtn=!1,n.st.enableEscapeKey=!1),n.bgOverlay||(n.bgOverlay=y("bg").on("click"+j,function(){n.close()}),n.wrap=y("wrap").attr("tabindex",-1).on("click"+j,function(a){n._checkIfClose(a.target)&&n.close()}),n.container=y("container",n.wrap)),n.contentContainer=y("content"),n.st.preloader&&(n.preloader=y("preloader",n.container,n.st.tLoading));var h=a.magnificPopup.modules;for(c=0;c<h.length;c++){var i=h[c];i=i.charAt(0).toUpperCase()+i.slice(1),n["init"+i].call(n)}z("BeforeOpen"),n.st.showCloseBtn&&(n.st.closeBtnInside?(x(f,function(a,b,c,d){c.close_replaceWith=A(d.type)}),v+=" mfp-close-btn-in"):n.wrap.append(A())),n.st.alignTop&&(v+=" mfp-align-top"),n.fixedContentPos?n.wrap.css({overflow:n.st.overflowY,overflowX:"hidden",overflowY:n.st.overflowY}):n.wrap.css({top:r.scrollTop(),position:"absolute"}),(n.st.fixedBgPos===!1||n.st.fixedBgPos==="auto"&&!n.fixedContentPos)&&n.bgOverlay.css({height:t.height(),position:"absolute"}),n.st.enableEscapeKey&&t.on("keyup"+j,function(a){a.keyCode===27&&n.close()}),r.on("resize"+j,function(){n.updateSize()}),n.st.closeOnContentClick||(v+=" mfp-auto-cursor"),v&&n.wrap.addClass(v);var l=n.wH=r.height(),m={};if(n.fixedContentPos&&n._hasScrollBar(l)){var o=n._getScrollbarSize();o&&(m.marginRight=o)}n.fixedContentPos&&(n.isIE7?a("body, html").css("overflow","hidden"):m.overflow="hidden");var p=n.st.mainClass;return n.isIE7&&(p+=" mfp-ie7"),p&&n._addClassToMFP(p),n.updateItemHTML(),z("BuildControls"),a("html").css(m),n.bgOverlay.add(n.wrap).prependTo(n.st.prependTo||s),n._lastFocusedEl=document.activeElement,setTimeout(function(){n.content?(n._addClassToMFP(k),n._setFocus()):n.bgOverlay.addClass(k),t.on("focusin"+j,n._onFocusIn)},16),n.isOpen=!0,n.updateSize(l),z(g),b},close:function(){if(!n.isOpen)return;z(c),n.isOpen=!1,n.st.removalDelay&&!n.isLowIE&&n.supportsTransition?(n._addClassToMFP(l),setTimeout(function(){n._close()},n.st.removalDelay)):n._close()},_close:function(){z(b);var c=l+" "+k+" ";n.bgOverlay.detach(),n.wrap.detach(),n.container.empty(),n.st.mainClass&&(c+=n.st.mainClass+" "),n._removeClassFromMFP(c);if(n.fixedContentPos){var e={marginRight:""};n.isIE7?a("body, html").css("overflow",""):e.overflow="",a("html").css(e)}t.off("keyup"+j+" focusin"+j),n.ev.off(j),n.wrap.attr("class","mfp-wrap").removeAttr("style"),n.bgOverlay.attr("class","mfp-bg"),n.container.attr("class","mfp-container"),n.st.showCloseBtn&&(!n.st.closeBtnInside||n.currTemplate[n.currItem.type]===!0)&&n.currTemplate.closeBtn&&n.currTemplate.closeBtn.detach(),n._lastFocusedEl&&a(n._lastFocusedEl).focus(),n.currItem=null,n.content=null,n.currTemplate=null,n.prevHeight=0,z(d)},updateSize:function(a){if(n.isIOS){var b=document.documentElement.clientWidth/window.innerWidth,c=window.innerHeight*b;n.wrap.css("height",c),n.wH=c}else n.wH=a||r.height();n.fixedContentPos||n.wrap.css("height",n.wH),z("Resize")},updateItemHTML:function(){var b=n.items[n.index];n.contentContainer.detach(),n.content&&n.content.detach(),b.parsed||(b=n.parseEl(n.index));var c=b.type;z("BeforeChange",[n.currItem?n.currItem.type:"",c]),n.currItem=b;if(!n.currTemplate[c]){var d=n.st[c]?n.st[c].markup:!1;z("FirstMarkupParse",d),d?n.currTemplate[c]=a(d):n.currTemplate[c]=!0}u&&u!==b.type&&n.container.removeClass("mfp-"+u+"-holder");var e=n["get"+c.charAt(0).toUpperCase()+c.slice(1)](b,n.currTemplate[c]);n.appendContent(e,c),b.preloaded=!0,z(h,b),u=b.type,n.container.prepend(n.contentContainer),z("AfterChange")},appendContent:function(a,b){n.content=a,a?n.st.showCloseBtn&&n.st.closeBtnInside&&n.currTemplate[b]===!0?n.content.find(".mfp-close").length||n.content.append(A()):n.content=a:n.content="",z(e),n.container.addClass("mfp-"+b+"-holder"),n.contentContainer.append(n.content)},parseEl:function(b){var c=n.items[b],d;c.tagName?c={el:a(c)}:(d=c.type,c={data:c,src:c.src});if(c.el){var e=n.types;for(var f=0;f<e.length;f++)if(c.el.hasClass("mfp-"+e[f])){d=e[f];break}c.src=c.el.attr("data-mfp-src"),c.src||(c.src=c.el.attr("href"))}return c.type=d||n.st.type||"inline",c.index=b,c.parsed=!0,n.items[b]=c,z("ElementParse",c),n.items[b]},addGroup:function(a,b){var c=function(c){c.mfpEl=this,n._openClick(c,a,b)};b||(b={});var d="click.magnificPopup";b.mainEl=a,b.items?(b.isObj=!0,a.off(d).on(d,c)):(b.isObj=!1,b.delegate?a.off(d).on(d,b.delegate,c):(b.items=a,a.off(d).on(d,c)))},_openClick:function(b,c,d){var e=d.midClick!==undefined?d.midClick:a.magnificPopup.defaults.midClick;if(!e&&(b.which===2||b.ctrlKey||b.metaKey))return;var f=d.disableOn!==undefined?d.disableOn:a.magnificPopup.defaults.disableOn;if(f)if(a.isFunction(f)){if(!f.call(n))return!0}else if(r.width()<f)return!0;b.type&&(b.preventDefault(),n.isOpen&&b.stopPropagation()),d.el=a(b.mfpEl),d.delegate&&(d.items=c.find(d.delegate)),n.open(d)},updateStatus:function(a,b){if(n.preloader){q!==a&&n.container.removeClass("mfp-s-"+q),!b&&a==="loading"&&(b=n.st.tLoading);var c={status:a,text:b};z("UpdateStatus",c),a=c.status,b=c.text,n.preloader.html(b),n.preloader.find("a").on("click",function(a){a.stopImmediatePropagation()}),n.container.addClass("mfp-s-"+a),q=a}},_checkIfClose:function(b){if(a(b).hasClass(m))return;var c=n.st.closeOnContentClick,d=n.st.closeOnBgClick;if(c&&d)return!0;if(!n.content||a(b).hasClass("mfp-close")||n.preloader&&b===n.preloader[0])return!0;if(b!==n.content[0]&&!a.contains(n.content[0],b)){if(d&&a.contains(document,b))return!0}else if(c)return!0;return!1},_addClassToMFP:function(a){n.bgOverlay.addClass(a),n.wrap.addClass(a)},_removeClassFromMFP:function(a){this.bgOverlay.removeClass(a),n.wrap.removeClass(a)},_hasScrollBar:function(a){return(n.isIE7?t.height():document.body.scrollHeight)>(a||r.height())},_setFocus:function(){(n.st.focus?n.content.find(n.st.focus).eq(0):n.wrap).focus()},_onFocusIn:function(b){if(b.target!==n.wrap[0]&&!a.contains(n.wrap[0],b.target))return n._setFocus(),!1},_parseMarkup:function(b,c,d){var e;d.data&&(c=a.extend(d.data,c)),z(f,[b,c,d]),a.each(c,function(a,c){if(c===undefined||c===!1)return!0;e=a.split("_");if(e.length>1){var d=b.find(j+"-"+e[0]);if(d.length>0){var f=e[1];f==="replaceWith"?d[0]!==c[0]&&d.replaceWith(c):f==="img"?d.is("img")?d.attr("src",c):d.replaceWith('<img src="'+c+'" class="'+d.attr("class")+'" />'):d.attr(e[1],c)}}else b.find(j+"-"+a).html(c)})},_getScrollbarSize:function(){if(n.scrollbarSize===undefined){var a=document.createElement("div");a.id="mfp-sbm",a.style.cssText="width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;",document.body.appendChild(a),n.scrollbarSize=a.offsetWidth-a.clientWidth,document.body.removeChild(a)}return n.scrollbarSize}},a.magnificPopup={instance:null,proto:o.prototype,modules:[],open:function(b,c){return B(),b?b=a.extend(!0,{},b):b={},b.isObj=!0,b.index=c||0,this.instance.open(b)},close:function(){return a.magnificPopup.instance&&a.magnificPopup.instance.close()},registerModule:function(b,c){c.options&&(a.magnificPopup.defaults[b]=c.options),a.extend(this.proto,c.proto),this.modules.push(b)},defaults:{disableOn:0,key:null,midClick:!1,mainClass:"",preloader:!0,focus:"",closeOnContentClick:!1,closeOnBgClick:!0,closeBtnInside:!0,showCloseBtn:!0,enableEscapeKey:!0,modal:!1,alignTop:!1,removalDelay:0,prependTo:null,fixedContentPos:"auto",fixedBgPos:"auto",overflowY:"auto",closeMarkup:'<button title="%title%" type="button" class="mfp-close">&times;</button>',tClose:"Close (Esc)",tLoading:"Loading..."}},a.fn.magnificPopup=function(b){B();var c=a(this);if(typeof b=="string")if(b==="open"){var d,e=p?c.data("magnificPopup"):c[0].magnificPopup,f=parseInt(arguments[1],10)||0;e.items?d=e.items[f]:(d=c,e.delegate&&(d=d.find(e.delegate)),d=d.eq(f)),n._openClick({mfpEl:d},c,e)}else n.isOpen&&n[b].apply(n,Array.prototype.slice.call(arguments,1));else b=a.extend(!0,{},b),p?c.data("magnificPopup",b):c[0].magnificPopup=b,n.addGroup(c,b);return c};var D="inline",E,F,G,H=function(){G&&(F.after(G.addClass(E)).detach(),G=null)};a.magnificPopup.registerModule(D,{options:{hiddenClass:"hide",markup:"",tNotFound:"Content not found"},proto:{initInline:function(){n.types.push(D),x(b+"."+D,function(){H()})},getInline:function(b,c){H();if(b.src){var d=n.st.inline,e=a(b.src);if(e.length){var f=e[0].parentNode;f&&f.tagName&&(F||(E=d.hiddenClass,F=y(E),E="mfp-"+E),G=e.after(F).detach().removeClass(E)),n.updateStatus("ready")}else n.updateStatus("error",d.tNotFound),e=a("<div>");return b.inlineElement=e,e}return n.updateStatus("ready"),n._parseMarkup(c,{},b),c}}});var I="ajax",J,K=function(){J&&s.removeClass(J)},L=function(){K(),n.req&&n.req.abort()};a.magnificPopup.registerModule(I,{options:{settings:null,cursor:"mfp-ajax-cur",tError:'<a href="%url%">The content</a> could not be loaded.'},proto:{initAjax:function(){n.types.push(I),J=n.st.ajax.cursor,x(b+"."+I,L),x("BeforeChange."+I,L)},getAjax:function(b){J&&s.addClass(J),n.updateStatus("loading");var c=a.extend({url:b.src,success:function(c,d,e){var f={data:c,xhr:e};z("ParseAjax",f),n.appendContent(a(f.data),I),b.finished=!0,K(),n._setFocus(),setTimeout(function(){n.wrap.addClass(k)},16),n.updateStatus("ready"),z("AjaxContentAdded")},error:function(){K(),b.finished=b.loadError=!0,n.updateStatus("error",n.st.ajax.tError.replace("%url%",b.src))}},n.st.ajax.settings);return n.req=a.ajax(c),""}}});var M,N=function(b){if(b.data&&b.data.title!==undefined)return b.data.title;var c=n.st.image.titleSrc;if(c){if(a.isFunction(c))return c.call(n,b);if(b.el)return b.el.attr(c)||""}return""};a.magnificPopup.registerModule("image",{options:{markup:'<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>',cursor:"mfp-zoom-out-cur",titleSrc:"title",verticalFit:!0,tError:'<a href="%url%">The image</a> could not be loaded.'},proto:{initImage:function(){var a=n.st.image,c=".image";n.types.push("image"),x(g+c,function(){n.currItem.type==="image"&&a.cursor&&s.addClass(a.cursor)}),x(b+c,function(){a.cursor&&s.removeClass(a.cursor),r.off("resize"+j)}),x("Resize"+c,n.resizeImage),n.isLowIE&&x("AfterChange",n.resizeImage)},resizeImage:function(){var a=n.currItem;if(!a||!a.img)return;if(n.st.image.verticalFit){var b=0;n.isLowIE&&(b=parseInt(a.img.css("padding-top"),10)+parseInt(a.img.css("padding-bottom"),10)),a.img.css("max-height",n.wH-b)}},_onImageHasSize:function(a){a.img&&(a.hasSize=!0,M&&clearInterval(M),a.isCheckingImgSize=!1,z("ImageHasSize",a),a.imgHidden&&(n.content&&n.content.removeClass("mfp-loading"),a.imgHidden=!1))},findImageSize:function(a){var b=0,c=a.img[0],d=function(e){M&&clearInterval(M),M=setInterval(function(){if(c.naturalWidth>0){n._onImageHasSize(a);return}b>200&&clearInterval(M),b++,b===3?d(10):b===40?d(50):b===100&&d(500)},e)};d(1)},getImage:function(b,c){var d=0,e=function(){b&&(b.img[0].complete?(b.img.off(".mfploader"),b===n.currItem&&(n._onImageHasSize(b),n.updateStatus("ready")),b.hasSize=!0,b.loaded=!0,z("ImageLoadComplete")):(d++,d<200?setTimeout(e,100):f()))},f=function(){b&&(b.img.off(".mfploader"),b===n.currItem&&(n._onImageHasSize(b),n.updateStatus("error",g.tError.replace("%url%",b.src))),b.hasSize=!0,b.loaded=!0,b.loadError=!0)},g=n.st.image,h=c.find(".mfp-img");if(h.length){var i=document.createElement("img");i.className="mfp-img",b.img=a(i).on("load.mfploader",e).on("error.mfploader",f),i.src=b.src,h.is("img")&&(b.img=b.img.clone()),i=b.img[0],i.naturalWidth>0?b.hasSize=!0:i.width||(b.hasSize=!1)}return n._parseMarkup(c,{title:N(b),img_replaceWith:b.img},b),n.resizeImage(),b.hasSize?(M&&clearInterval(M),b.loadError?(c.addClass("mfp-loading"),n.updateStatus("error",g.tError.replace("%url%",b.src))):(c.removeClass("mfp-loading"),n.updateStatus("ready")),c):(n.updateStatus("loading"),b.loading=!0,b.hasSize||(b.imgHidden=!0,c.addClass("mfp-loading"),n.findImageSize(b)),c)}}});var O,P=function(){return O===undefined&&(O=document.createElement("p").style.MozTransform!==undefined),O};a.magnificPopup.registerModule("zoom",{options:{enabled:!1,easing:"ease-in-out",duration:300,opener:function(a){return a.is("img")?a:a.find("img")}},proto:{initZoom:function(){var a=n.st.zoom,d=".zoom",e;if(!a.enabled||!n.supportsTransition)return;var f=a.duration,g=function(b){var c=b.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),d="all "+a.duration/1e3+"s "+a.easing,e={position:"fixed",zIndex:9999,left:0,top:0,"-webkit-backface-visibility":"hidden"},f="transition";return e["-webkit-"+f]=e["-moz-"+f]=e["-o-"+f]=e[f]=d,c.css(e),c},h=function(){n.content.css("visibility","visible")},i,j;x("BuildControls"+d,function(){if(n._allowZoom()){clearTimeout(i),n.content.css("visibility","hidden"),e=n._getItemToZoom();if(!e){h();return}j=g(e),j.css(n._getOffset()),n.wrap.append(j),i=setTimeout(function(){j.css(n._getOffset(!0)),i=setTimeout(function(){h(),setTimeout(function(){j.remove(),e=j=null,z("ZoomAnimationEnded")},16)},f)},16)}}),x(c+d,function(){if(n._allowZoom()){clearTimeout(i),n.st.removalDelay=f;if(!e){e=n._getItemToZoom();if(!e)return;j=g(e)}j.css(n._getOffset(!0)),n.wrap.append(j),n.content.css("visibility","hidden"),setTimeout(function(){j.css(n._getOffset())},16)}}),x(b+d,function(){n._allowZoom()&&(h(),j&&j.remove(),e=null)})},_allowZoom:function(){return n.currItem.type==="image"},_getItemToZoom:function(){return n.currItem.hasSize?n.currItem.img:!1},_getOffset:function(b){var c;b?c=n.currItem.img:c=n.st.zoom.opener(n.currItem.el||n.currItem);var d=c.offset(),e=parseInt(c.css("padding-top"),10),f=parseInt(c.css("padding-bottom"),10);d.top-=a(window).scrollTop()-e;var g={width:c.width(),height:(p?c.innerHeight():c[0].offsetHeight)-f-e};return P()?g["-moz-transform"]=g.transform="translate("+d.left+"px,"+d.top+"px)":(g.left=d.left,g.top=d.top),g}}});var Q="iframe",R="//about:blank",S=function(a){if(n.currTemplate[Q]){var b=n.currTemplate[Q].find("iframe");b.length&&(a||(b[0].src=R),n.isIE8&&b.css("display",a?"block":"none"))}};a.magnificPopup.registerModule(Q,{options:{markup:'<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',srcAction:"iframe_src",patterns:{youtube:{index:"youtube.com",id:"v=",src:"//www.youtube.com/embed/%id%?autoplay=1"},vimeo:{index:"vimeo.com/",id:"/",src:"//player.vimeo.com/video/%id%?autoplay=1"},gmaps:{index:"//maps.google.",src:"%id%&output=embed"}}},proto:{initIframe:function(){n.types.push(Q),x("BeforeChange",function(a,b,c){b!==c&&(b===Q?S():c===Q&&S(!0))}),x(b+"."+Q,function(){S()})},getIframe:function(b,c){var d=b.src,e=n.st.iframe;a.each(e.patterns,function(){if(d.indexOf(this.index)>-1)return this.id&&(typeof this.id=="string"?d=d.substr(d.lastIndexOf(this.id)+this.id.length,d.length):d=this.id.call(this,d)),d=this.src.replace("%id%",d),!1});var f={};return e.srcAction&&(f[e.srcAction]=d),n._parseMarkup(c,f,b),n.updateStatus("ready"),c}}});var T=function(a){var b=n.items.length;return a>b-1?a-b:a<0?b+a:a},U=function(a,b,c){return a.replace(/%curr%/gi,b+1).replace(/%total%/gi,c)};a.magnificPopup.registerModule("gallery",{options:{enabled:!1,arrowMarkup:'<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',preload:[0,2],navigateByImgClick:!0,arrows:!0,tPrev:"Previous (Left arrow key)",tNext:"Next (Right arrow key)",tCounter:"%curr% of %total%"},proto:{initGallery:function(){var c=n.st.gallery,d=".mfp-gallery",e=Boolean(a.fn.mfpFastClick);n.direction=!0;if(!c||!c.enabled)return!1;v+=" mfp-gallery",x(g+d,function(){c.navigateByImgClick&&n.wrap.on("click"+d,".mfp-img",function(){if(n.items.length>1)return n.next(),!1}),t.on("keydown"+d,function(a){a.keyCode===37?n.prev():a.keyCode===39&&n.next()})}),x("UpdateStatus"+d,function(a,b){b.text&&(b.text=U(b.text,n.currItem.index,n.items.length))}),x(f+d,function(a,b,d,e){var f=n.items.length;d.counter=f>1?U(c.tCounter,e.index,f):""}),x("BuildControls"+d,function(){if(n.items.length>1&&c.arrows&&!n.arrowLeft){var b=c.arrowMarkup,d=n.arrowLeft=a(b.replace(/%title%/gi,c.tPrev).replace(/%dir%/gi,"left")).addClass(m),f=n.arrowRight=a(b.replace(/%title%/gi,c.tNext).replace(/%dir%/gi,"right")).addClass(m),g=e?"mfpFastClick":"click";d[g](function(){n.prev()}),f[g](function(){n.next()}),n.isIE7&&(y("b",d[0],!1,!0),y("a",d[0],!1,!0),y("b",f[0],!1,!0),y("a",f[0],!1,!0)),n.container.append(d.add(f))}}),x(h+d,function(){n._preloadTimeout&&clearTimeout(n._preloadTimeout),n._preloadTimeout=setTimeout(function(){n.preloadNearbyImages(),n._preloadTimeout=null},16)}),x(b+d,function(){t.off(d),n.wrap.off("click"+d),n.arrowLeft&&e&&n.arrowLeft.add(n.arrowRight).destroyMfpFastClick(),n.arrowRight=n.arrowLeft=null})},next:function(){n.direction=!0,n.index=T(n.index+1),n.updateItemHTML()},prev:function(){n.direction=!1,n.index=T(n.index-1),n.updateItemHTML()},goTo:function(a){n.direction=a>=n.index,n.index=a,n.updateItemHTML()},preloadNearbyImages:function(){var a=n.st.gallery.preload,b=Math.min(a[0],n.items.length),c=Math.min(a[1],n.items.length),d;for(d=1;d<=(n.direction?c:b);d++)n._preloadItem(n.index+d);for(d=1;d<=(n.direction?b:c);d++)n._preloadItem(n.index-d)},_preloadItem:function(b){b=T(b);if(n.items[b].preloaded)return;var c=n.items[b];c.parsed||(c=n.parseEl(b)),z("LazyLoad",c),c.type==="image"&&(c.img=a('<img class="mfp-img" />').on("load.mfploader",function(){c.hasSize=!0}).on("error.mfploader",function(){c.hasSize=!0,c.loadError=!0,z("LazyLoadError",c)}).attr("src",c.src)),c.preloaded=!0}}});var V="retina";a.magnificPopup.registerModule(V,{options:{replaceSrc:function(a){return a.src.replace(/\.\w+$/,function(a){return"@2x"+a})},ratio:1},proto:{initRetina:function(){if(window.devicePixelRatio>1){var a=n.st.retina,b=a.ratio;b=isNaN(b)?b():b,b>1&&(x("ImageHasSize."+V,function(a,c){c.img.css({"max-width":c.img[0].naturalWidth/b,width:"100%"})}),x("ElementParse."+V,function(c,d){d.src=a.replaceSrc(d,b)}))}}}}),function(){var b=1e3,c="ontouchstart"in window,d=function(){r.off("touchmove"+f+" touchend"+f)},e="mfpFastClick",f="."+e;a.fn.mfpFastClick=function(e){return a(this).each(function(){var g=a(this),h;if(c){var i,j,k,l,m,n;g.on("touchstart"+f,function(a){l=!1,n=1,m=a.originalEvent?a.originalEvent.touches[0]:a.touches[0],j=m.clientX,k=m.clientY,r.on("touchmove"+f,function(a){m=a.originalEvent?a.originalEvent.touches:a.touches,n=m.length,m=m[0];if(Math.abs(m.clientX-j)>10||Math.abs(m.clientY-k)>10)l=!0,d()}).on("touchend"+f,function(a){d();if(l||n>1)return;h=!0,a.preventDefault(),clearTimeout(i),i=setTimeout(function(){h=!1},b),e()})})}g.on("click"+f,function(){h||e()})})},a.fn.destroyMfpFastClick=function(){a(this).off("touchstart"+f+" click"+f),c&&r.off("touchmove"+f+" touchend"+f)}}(),B()})(window.jQuery||window.Zepto)






/////////////////////
//////////////////////



var function_trace = [];
function characterCount(){
	
}
$(document).ready(function(e) {
//bof click bank
//setTimeout(function(){
//		$('#search-btn-txt').click();
//	
//},1000);
//setCookie('counter',parseInt(getCookie('counter'))+1,1);
	//recreate_tables();

	if($('.messageStackError').css('display')!='none'){
		window.scrollTo(0, 0);
	}
	$('.payment-label').click(function(){
		if(this.id!='lbl-braintree_api'){
			$('#credit-collapse').removeClass('in');
		}
	});
	$('.live_chat').click(function(){
			if($('#chat_text').text()=='Live Chat'){
				window.location.href =  window.location.href.replace('?live_chat=0', '')+'?live_chat=1';
			}else{
				window.location.href = window.location.href.replace('?live_chat=1', '')+'?live_chat=0';
			}
			
	});
	
	$('#drop-close').click(function(){
			$('.drop-outer-sub-menu').each(function(index, element) {
                $(this).click();
            });
			if($('#drop-close').val()=='Drop Menu'){
				$('#drop-close').val('Collapse Menu');
			}else{
				$('#drop-close').val('Drop Menu');
			}
	});
	$('#keep_current_address').click(function(){
		$('.mfp-close').click();	
	});
    $('.zm-category-outer-menu').click(function(){
		$('.drop-sub-menu').hide();
		$('.zm-category-outer-menu').removeClass('zm-menu-select');
		$(this).addClass('zm-menu-select');
		var menu_id = $(this).attr('data-show');
		setCookie('menu_selected',this.id,1);
		$('#'+menu_id).show();
	});
	if(getCookie('menu_selected') && getCookie('menu_selected').length !=0){
		$('#'+getCookie('menu_selected')).click();
	}else{
		$('.zm-category-outer-menu :first-child').click();
	}
	//if(!getCookie('menu_selected')){
		var is_tru=false;
		$('.inner-sub-menu').each(function(index, element) {
            if($(this).hasClass('in')){
				is_tru=true;
				console.log('true');
			}else{
				console.log('false');
			}
        });
		
		if(!is_tru && window.current_page==1){
			$('.drop-outer-sub-menu')[0].click();
		}
		
	//}
	$('.drop-outer-sub-menu').click(function(){
		if(!$(this).next('ul').hasClass('in')){
			$(this).find('i').addClass('fa-chevron-down');
			$(this).find('i').removeClass('fa-chevron-left');
		}else {
			$(this).find('i').addClass('fa-chevron-left');
			$(this).find('i').removeClass('fa-chevron-down');
		}
	});
	$('.special-pay-legend').click(function(){
		if(!$(this).next('fieldset').hasClass('in')){
			$(this).find('i').addClass('fa-chevron-down');
			$(this).find('i').removeClass('fa-chevron-left');
		}else {
			$(this).find('i').addClass('fa-chevron-left');
			$(this).find('i').removeClass('fa-chevron-down');
		}
	});
	$('.messageStack').click(function(){
		$(this).slideToggle(200)	
	});
	$('.create-acct-legend').click(function(){
		$('#loginColumnLeft').toggle();
		$('.fec-no-account').toggle();
		$('#createAcctDefaultLoginLink').toggle();
	});
	$('.checkout-btn-popout').click(function(){
		zm_check_min_and_checkout($(this).attr('href'));
	});
	$('.save_time').click(add_dev_time_process);
	$('#time-save').click(add_dev_time_process);
	$('#clear_cart').click(zm_delete_cart);

//eof click bank

//bof menu hover orangening
	$('.list-group-item-custom').hover(function(){
		$(this).parent().prev().children('li').css('border-bottom','1px solid transparent');
		$(this).css('border-bottom','1px solid transparent');
	},function(){
		$(this).parent().prev().children('li').css('border-bottom','1px solid #ef6f00');
		$(this).css('border-bottom','1px solid #ef6f00');
	});
//eof menu hover orangening	
	

//bof stuff to run right away	
	$('.inputLabel span').each(function(index, element) {
        if($(element).hasClass('alert')){
			$(element).remove();	
		}
    });
	$('.fec-fieldset-legend').remove();
	//
	$('.form-alert').remove();
//eof stuff to run right away	

//macbook elitebook
// bof stuff for the fixed time sidebox
	if(window.current_page==1 && window.this_is_ie_9!=1){
		var initialPos =  $('.timecode-container-inner').offset().top;
		var initialWidth = ($('.timecode-container-inner').outerWidth()/$(window).width())*100;
		var timecodeHeight = $('.timecode-container-inner').height(); 
		var initialLeft = $('.timecode-container-inner').offset().left;
		var stopHeight = ($('.header-nav-menu-wrap').height()+$('.page-head').height()+
			$('#contentMainWrapper').height()+200);
		var initial_window_width = $(window).width();
		var footerHeight = $('#footer').height();
		fix_sidebox();	
		$(window).scroll(function(){
			fix_sidebox();
		});	
	}
// eof stuff for the fixed time sidebox

//idk what this does
	$(".image-container>img").each(function(i, img) {
    	$(img).css({
      	  position: "relative",
        	left: ($(img).parent().width() - $(img).width()) / 2
   		});
	});
//idk what this does



//bof address search click bank
window.geo_coded_checked=1;	
if(window.places){
	delete window.places; 	
}

$('.init-search').click(function(){
		check_if_geocoded(get_main_address());	
});

$('.init-search-popup').click(function(){
		check_if_geocoded(get_main_address());
});

$('#pac-input').keypress(function(e){
	if(e.which == 13){
		check_if_geocoded(get_main_address());
	}
	
});

// matellio code for preventing start
(function($){
    $.fn.focusTextToEnd = function(){
        this.focus();
        var $thisVal = this.val();
        this.val('').val($thisVal);
        return this;
    }
}(jQuery));
$('#pac-input').on('keyup',function(e){
	$('#pac-inputtest').val($(this).val());

	if($(this).val().length<=3){
	    $('#pac-inputtest').css('display','block');
	    $('#pac-input').css('display','none');
	    $('#pac-inputtest').css('border-color','#ef6f00');
	    $('#pac-inputtest').focus();
	    
	    $('#pac-inputtest').focusTextToEnd();
	}
});
$('#pac-inputtest').on('keyup',function(e){
	$('#pac-input').val($(this).val());
	$('#pac-input').css('border-color','#ef6f00');
	if($(this).val().length>3){
	    $('#pac-input').css('display','block');
	    $('#pac-inputtest').css('display','none');
	    $('#pac-input').focusTextToEnd();
	}
});
$("#pac-inputtest").focusin(function(){
    $('#pac-inputtest').css('border-color','');
});
$("#pac-inputtest").focusout(function(){
    $('#pac-inputtest').css('border-color','#ddd');
});
// matellio code for preventing end

$('#pac-input').on('paste', function(e) {
    setTimeout(function () { 
        $('#pac-input').attr('value',$('#pac-input').val());
		console.log(e);
    }, 100);
});
//eof address search click bank



//bof form submit debounces
window.good_to_submit=1;
$('#main_checkout_btn').click(function(){
	if(window.good_to_submit==1){
		window.good_to_submit=0;
		$('#circularG').css('display','block');
		setTimeout(function(){
			window.good_to_submit=1;
		},9000);
		zm_checkout_time_check();
	}
});
	

$('.create_account_btn').click(function(){
	$('#circularG').css('display','block');
		setTimeout(function(){
			$('#circularG').css('display','none');
		},6000);
});
//eof form submit debounces	
	
//bof timecode click stuff
var active_pages = ['no_account','login','index','checkout','cpath'];
 //var timecode_debounce=1;
//if(active_pages.indexOf(get_page()) && timecode_debounce==1){
	 //timecode_debounce=0;
	// setTimeout(function(){timecode_debounce=1;},500);

	 if(window.current_page && window.current_page==1 || window.current_page && window.current_page==66){
		 zm_get_restaurant_closed_dates();	
	 }
		
//}

$('.timecode-click').click(function(){
		if(!getCookie('picked_date')){
			var s_c_v = new Date();
			var form_date = (s_c_v.getMonth()+1)+
			'/'+s_c_v.getDate()+'/'+s_c_v.getFullYear();
			//console.log(form_date);
			if(window.closed_dates &&  window.closed_dates.indexOf(form_date)==-1){
				$('.timecode-calendar div').datepicker('setDate', form_date);
			}
				
		}else{
			if(window.closed_dates && window.closed_dates.indexOf(getCookie('picked_date'))==-1){
				$('.timecode-calendar div').datepicker('setDate',getCookie('picked_date'));
			}
			
		}	
});
//eof timecode click stuff
//eof action monitors

//bof functions called in jquery
setCookie('menu_save',0,0);	
function save_tables(){
	var menu_save=[];
	$('.inner-sub-menu').each(function(index, element) {
		if($(this).hasClass('in')){
			var id_array = this.id.split('_');
			menu_save.push(id_array[2]);
		}
    });
	setCookie('menu_save',menu_save,1);	
}



function fix_sidebox(){
	if($(window).width()>980){
		//&& scrolled < stopHeight-timecodeHeight
		console.log(initialLeft);
		if($(window).width()!=initial_window_width){
			initialWidth=25;
			//initialLeft=$('.outer-sub-menu-icon :first-child').offset().left+36;
		}
			
		
		var scrolled = $(window).scrollTop();
	    if( scrolled > initialPos-($('#messageStackHeader').height()+22) ){
        	$('.timecode-container-inner').css({
       	      top:$('#messageStackHeader').height()+22,
			  width:initialWidth+'%',
			  left:initialLeft
        	});
			$('.timecode-container-inner').addClass('timecode-fixed');
			
   		}
		else{
			$('.timecode-container-inner').css({
       	      top:'0px',
			  width:'',
			  left:0
        	});
			$('.timecode-container-inner').removeClass('timecode-fixed');
		}	
	}else{
		$('.timecode-container-inner').css({
       	      top:'0px',
			  width:'',
			  left:0
        	});
			$('.timecode-container-inner').removeClass('timecode-fixed');
		
	}
}



//tip stuff is inline at tpl_checkout_stacked.php


//bof cookies
function setCookie(cname, cvalue, exdays) {
	function_trace.push('setCookie');
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
function getCookie(cname) {
	function_trace.push('getCookie');
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}
//eof cookies



//
//
// bof address processing
//
//
//window.geolocate=function () {
//	if(window.goog){
//		return;	
//	}
//		  console.log('geolocate');
//		if (navigator.geolocation) {
//		  navigator.geolocation.getCurrentPosition(function(position) {
//			var geolocation = {
//			  lat: position.coords.latitude,
//			  lng: position.coords.longitude
//			};
//			var circle = new google.maps.Circle({
//			  center: geolocation,
//			  radius: position.coords.accuracy
//			});
//			console.log('bound set');
//			//for(var i =0;i<auto_length;i++){
//				window.searchBox_a.setBounds(circle.getBounds());
//			//}
//			
//		  });
//		}else{
//			console.log('no location');
//		}
//	  };
//	  
//window.initializeSearch = function() {
//	if(window.goog){
//		return;	
//	}
//	function_trace.push('initializeSearch');
//	console.log('init');
// 		 var input_a = document.getElementById('pac-input');
//		 try{
// 
//  		 		window.searchBox_a = new google.maps.places.SearchBox(input_a);
//				window.geolocate();
//  		 google.maps.event.addListener(window.searchBox_a, 'places_changed', function() {
//			 console.log(window.searchBox_a);
//    		 var places = window.searchBox_a.getPlaces();
//			 console.log(places);
//				var irifit = objectify_places(places);
//				if(irifit==5){
//					return;
//				}else if(irifit==1){
//					console.log('check if coded');
//					setTimeout(function(){
//						
//							check_if_geocoded(get_main_address());
//					
//						
//					},100);
//				}
// 			 });
//			 
//		}catch(e){
//			console.log('not a google page');
//	//this breaks on mostly every page 
//		}
//};

function sep_address(obj){
	if(window.goog){
		return;	
	}
	function_trace.push('sep_address');
	var $geo_code_data = obj ; 
	console.log(obj);
	var $address_separated = [];
try{
	for(var $y=0;$y<$geo_code_data.length;$y++){
	for(var $n=0;$n<$geo_code_data[$y]['address_components'].length;$n++){
		if($geo_code_data[$y]['address_components'][$n]['types'][0]=='street_number'){
			$address_separated['street_number'] = $geo_code_data[$y]['address_components'][$n]['long_name'];
		}
		if($geo_code_data[$y]['address_components'][$n]['types'][0]=='route'){
			$address_separated['street'] = $geo_code_data[$y]['address_components'][$n]['long_name'];
		}
		if($geo_code_data[$y]['address_components'][$n]['types'][0]=='locality'){
			$address_separated['city'] = $geo_code_data[$y]['address_components'][$n]['long_name'];
		}
		if($geo_code_data[$y]['address_components'][$n]['types'][0]=='administrative_area_level_1'){
			$address_separated['state'] = $geo_code_data[$y]['address_components'][$n]['long_name'];
			$address_separated['short_state'] = $geo_code_data[$y]['address_components'][$n]['short_name'];
		}
		if($geo_code_data[$y]['address_components'][$n]['types'][0]=='establishment'){
			$address_separated['street'] = $geo_code_data[$y]['address_components'][$n]['long_name'];

		}
		if($geo_code_data[$y]['address_components'][$n]['types'][0]=='premise'){
			$address_separated['street_number'] = $geo_code_data[$y]['address_components'][$n]['long_name'];

		}
		
		if($geo_code_data[$y]['address_components'][$n]['types'][0]=='postal_code'){
			$address_separated['postcode'] = $geo_code_data[$y]['address_components'][$n]['long_name'];
		}
		if($geo_code_data[$y]['address_components'][$n]['types'][0]=='subpremise'){
			$address_separated['apt'] = $geo_code_data[$y]['address_components'][$n]['long_name'];
		}
	}	
	}	
}catch(e){
	console.log(e);
		add_message_to_stack("Sorry please enter a more specific address",'sep address');
		return; 
}

		var address_separated_json = [];
    			address_separated_json.push({
	  				 "street_number":$address_separated['street_number'], 
      				 "street" : $address_separated['street'],
	   				 "city" : $address_separated['city'],
					  "apt" : $address_separated['apt'],
					 "short_state" : $address_separated['short_state'],
					 "state" : $address_separated['state'],
					 "postcode" : $address_separated['postcode']
    			});

	window.address_separated_json=address_separated_json;
	console.log('wraith awaiting launch orders');
	return $address_separated;
}


function get_main_address(){
	if(window.goog){
		return false;
	}
		var main_txt='';
		main_txt =$('#pac-input').val();
		if(main_txt==''){
			main_txt=$('#pac-input').attr('value');
		}	
	return main_txt;
}


function objectify_places(places){
	if(window.goog){
		return false;
	}
	function_trace.push('objectify_places');
	//console.log();
	var ret = 0;
	
	if(places[0]['address_components'] && places[0]['address_components'].length >4 ){

	if(places[0]){
		var sep = sep_address(places);
		if(sep['street']){
			if(sep['apt'] && sep['street_number'] && sep['street']){
				var formatted = sep['street_number']+' '+sep['street']+' '+sep['apt']+', '+sep['city'];
			}else if(sep['street_number'] && sep['street']){
				var formatted = sep['street_number']+' '+sep['street']+', '+sep['city'];
			}else if(sep['street']){
				var formatted = sep['street']+', '+sep['city'];
			}
			console.log(formatted);
			var formatted_cookie = sep['street_number']+' '+sep['street'];
		  	setCookie('address',formatted_cookie,1);
			$('#pac-input').val(formatted);
			window.places = places;
			ret = 1;
			console.log('nuclear launch detected');
			
			if(sep['city']=='Duluth'){
				//add_message_to_stack("We're sorry Duluth is closed for today, please try back later",'Duluth'); 
				//ret =5;
			}
			if(sep['city']=='Grand Forks'){
				//add_message_to_stack("We're sorry Grand Forks is closed for today, please try back later",'Duluth'); 
				//ret =5;
			}
			


		}else{	
			window.obj_time = setTimeout(function(){
			add_message_to_stack("Please enter a more specific address",'objectify_places'); 
			},5000);
			ret=5;
		}
	 }else{
		add_message_to_stack("Couldnt find address try again?",'objectify_places'); 
		console.log('error at objectify_places()');
	 }
	}else{
		window.obj_time = setTimeout(function(){
			add_message_to_stack("Couldnt find address please try again?",'objectify_places'); 
		},9000);
		ret=5;	
	}
	 return ret;
}

//function address_chop(address){
//// 		address = address.replace(' apt ', '');
//// 		address = address.replace(' apt.', '');
//// 		address = address.replace(' Apt.', '');
////		address = address.replace(' Apt#', '');
//// 		address = address.replace(' Apt ', '');
////		address = address.replace(' Suite ', '');
//// 		address = address.replace('#', '');
//		return address;
//	
//}

function check_if_geocoded(address){
	if(window.goog){
		return;	
	}
	function_trace.push('check_if_geocoded');
	if(window.geo_coded_checked==1){
		$('#circularG').css('display','block');
		window.geo_coded_checked=0;
		setTimeout(function(){
			window.geo_coded_checked=1;	
		},1);

		if(!address || address.length==0){
				add_message_to_stack("Please enter an address");
				return; 
		}
		
		if(address.length==5){
				add_message_to_stack("Our website now requires a full address as opposed to a zipcode, thank you",address);
				return; 
		}
		//address=address_chop(address);
		setTimeout(function(){
			if(!window.places){
				console.log('no window places');
				console.log(window.places);
				geo_code_address(address);
			}else{
				console.log('has places');
				console.log(window.places);
				zm_find_available_cities();
			}
		},100);
	}
}

function geo_code_address(address){
	if(window.goog){
		return;	
	}
	function_trace.push('geo_code_address');
	console.log('scv good to go');
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				console.log(results);
				var obj = objectify_places(results);
				if(obj==1){
					console.log('find cities');
					zm_find_available_cities();
				}else if(obj==5){
					return;
				}else{
					add_message_to_stack("Error, please enter a valid address",address);
					return;
				}
   		 	} else{
				add_message_to_stack("Please enter a valid address",address);
				console.log('error at geo_code_address()');	
				return;
			}
		}); 		

}

window.mapquest_debounce=1;
function mapquest(jason_string) {
	if(window.goog){
		return;	
	}
	function_trace.push('mapquest');
	clearTimeout(window.obj_time);
	if(mapquest_debounce!=1){
		return;
	}
	window.mapquest_debounce=0;
	setTimeout(function(){
		window.mapquest_debounce=1;
		
	},1000);
	console.log('your warriors have engaged the enemy.');
	killswitch_engage();
    try{
		MQA.withModule('directions', function() {
      		MQA.Directions.routeMatrix(
        	jason_string,
        	{routeOptions:{manyToOne:false}},
        	mapquest_return
      		);
    	})
	}catch(e){
		console.log(e);
		console.log('warning: mapquest failure');	
		zm_error_warning('ERROR MAPQUEST HAS FAILED CONTACT DAVE OR ZACH IMMEDIATLY');
		mapquest_failure();
	}
}

function mapquest_return(data) {
	console.log(data);
	function_trace.push('mapquest_return');
	clearTimeout(window.killswitch);
	if(window.mapquest_failed==1){
		return;
	}
	console.log('armageddon clock increased');
    if(data && data.locations) {
		try{
			console.log('they wont know what hit em');
			var master_categories_info = [];
			for(var p=1;p<data.distance.length;p++){
    			master_categories_info.push({
      				 "distance" : data.distance[p],
	   				 "duration" : data.time[p]
    			});
			}
			console.log('vector locked in');
			zm_find_available_restaurants(JSON.stringify(master_categories_info));
		}catch(e){
			add_message_to_stack('There was a problem finding restaurants','mapquest_return');
			console.log(e);	
		}
	}else{
		console.log('warning: mapquest failure');	
		//zm_error_warning('ERROR MAPQUEST HAS FAILED CONTACT DAVE OR ZACH IMMEDIATLY');
		mapquest_failure();
	}
}


function killswitch_engage(){
	if(window.goog){
		return;	
	}
	function_trace.push('killswitch_engage');
	window.killswitch=setTimeout(function(){
		console.log('killswitch engaged');
		mapquest_failure();	
	},500);	
}

function mapquest_failure() {
	if(window.goog){
		return;	
	}
	function_trace.push('mapquest_failure');
	console.log('if you can see this call fooddudestagings and warn them, there has been a fatal error');
	window.mapquest_failed=1;
		try{
			console.log(window.number_of_restaurants);
			var master_categories_info = [];
			for(var p=0;p<window.number_of_restaurants;p++){
    			master_categories_info.push({
      				 "distance" : 1,
	   				 "duration" : 1
    			});
			}
			console.log('vector locked in on failure');
			//console.log(master_categories_info);
			zm_find_available_restaurants(JSON.stringify(master_categories_info));
		}catch(e){
			add_message_to_stack('There was a problem finding restaurants','mapquest_failure');
			console.log(e);	
		}
}

//
// eof address processing
//
//


//bof time code

function run_the_timecode(the_code){
	function_trace.push('run_the_timecode');
	var $el = $(".timecode-timepicker");
	$el.empty(); // remove old options
	$.each(the_code, function(value,key) {
 	 $el.append($("<option></option>")
     .attr("value", value).text(key));
	});
}


function add_dev_time_process(){
	function_trace.push('add_dev_time_process');
		var t_session = $( ".timecode-timepicker option:selected" ).val();
		if(t_session==2){
			add_message_to_stack('Please pick a time');
			return;
		}		
		if(t_session==1){
			var delivery_time=1;
		}else{
			var d_session = new Date($('.timecode-calendar div').datepicker('getDate'));
			t_session= t_session.split(":");
			var delivery_time = new Date(d_session.getFullYear(),d_session.getMonth(),d_session.getDate(),t_session[0],t_session[1]);
			//console.log(delivery_time);
			delivery_time = delivery_time.getTime()/1000;
		}	
	 zm_session_add_delivery_time(delivery_time);	
}

//eof timecode


//bof misc

function json_to_assoc(json){
	function_trace.push('json_to_assoc');
	return $.map(json, function(el) { return el; });	
}



function get_page(){
	function_trace.push('get_page');
			var params = window.get_params;	
			var page;
		   if((params.hasOwnProperty('cPath')) && json_to_assoc(params).indexOf('index') !=-1){
				page='cpath';	
			}else{
				page=params['main_page'];
			}	
	return page;
}


//eof misc



//bof ajax post bank


function zm_error_warning(msg){	
	function_trace.push('zm_error_warning');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_error_warning:msg},
		dataType: 'text',
		async:true,
		error: function(){
			console.log('zm_error_warning()');
			//add_message_to_stack('Couldnt find times please try again');
		},
		success: function(data){
			console.log('success warning');
		}
	});
}



function zm_checkout_time_check(){
	function_trace.push('zm_checkout_time_check');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_checkout_time_check:1},
		dataType: 'text',
		async:true,
		error: function(){
			console.log('error at zm_check_min_and_checkout()');
			add_message_to_stack('Error submitting order please try again');
		},
		success: function(data){
			if(data==1){

				console.log('rock and roll');
				zm_check_min_and_submit();
				
			}else if(data==7){
				add_message_to_stack('Sorry the current menu is closed, please try another restaurant or menu');	
			}
		}
	});
}

function zm_check_min_and_submit(){
	function_trace.push('zm_check_min_and_checkout');
	//console.log(href);
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_check_min_and_checkout:1},
		dataType: 'json',
		async:true,
		error: function(){
			console.log('error at zm_check_min_and_checkout()');
			add_message_to_stack('Please try again');
		},
		success: function(data){
			if(data==1){
				console.log('min met');
				$('#checkout_payment').submit();
			}else{
				add_message_to_stack('The current restaurant has a minimum order of $'+data.toFixed(2));
			}
		}
	});
}

function zm_check_min_and_checkout(href){
	function_trace.push('zm_check_min_and_checkout');
	//console.log(href);
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_check_min_and_checkout:1},
		dataType: 'json',
		async:true,
		error: function(){
			console.log('error at zm_check_min_and_checkout()');
			add_message_to_stack('Please try again');
		},
		success: function(data){
			if(data==1){
				window.location.href = href;
			}else{
				add_message_to_stack('The current restaurant has a minimum order of $'+data.toFixed(2));
			}
		}
	});
}
//zm_set_timezone();
function zm_set_timezone(){
	function_trace.push('zm_set_timezone');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {set_tz:getTimeZone()},
		dataType: 'json',
		async:true,
		error: function(){
			//console.log('error at zm_session_add_delivery_time()');
			//add_message_to_stack('Couldnt add this time please try again');
		},
		success: function(data){
			//add_message_to_stack('Time updated');
		}
	});
}

function zm_session_add_delivery_time(date){
	function_trace.push('zm_session_add_delivery_time');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_session_add_delivery_time:date,tz:getTimeZone()},
		dataType: 'json',
		async:true,
		error: function(){
			console.log('error at zm_session_add_delivery_time()');
			add_message_to_stack('Couldnt add this time please try again');
		},
		success: function(data){
			add_message_to_stack('Time updated');
		}
	});
}

function getTimeZone() {
    var offset = new Date().getTimezoneOffset(), o = Math.abs(offset);
    return (offset < 0 ? "+" : "-") + ("00" + Math.floor(o / 60)).slice(-2) + ":" + ("00" + (o % 60)).slice(-2);
}
function zm_time_code(date){
	function_trace.push('zm_time_code');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_time_code:date,tz:getTimeZone()},
		dataType: 'json',
		async:true,
		error: function(){
			console.log('error at zm_time_code()');
			//add_message_to_stack('Couldnt find times please try again');
		},
		success: function(data){
			run_the_timecode(data);
		}
	});
}



function zm_find_available_cities(){
	console.log('good');
	if(!window.finding_cities){
		window.finding_cities=1;
		
	
	function_trace.push('zm_find_available_cities');
	var lat = window.places[0].geometry.location.lat();
	var lng = window.places[0].geometry.location.lng();
	var address = JSON.stringify(window.address_separated_json);
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_find_available_cities:1,lat:lat,lng:lng,address:address},
		dataType: 'json',
		async:true,
		error: function(){
			console.log('error at zm_find_available_cities()');
			add_message_to_stack('Error please try again.');
		},
		success: function(data){
			//console.log(data);
			console.log('upgrade complete');
			if(data['same_address'] && data['same_address']==1){
				console.log('same address');
				ok_to_proceed_redirect(get_page());
				return;
			}else if(data['no_cities'] && data['no_cities']==1){
				add_message_to_stack("Currently we do not service your address<br />For more information, please call 800-599-5770");
				//add_message_to_stack("There are no restaurants available to your address, please contact customer service for additional assistance.<br />service@staging.fooddudesdelivery.com");
				//add_message_to_stack("Holiday Hours: <br />Closed, Monday May 25 &#45; Memorial Day ");
				return;
			}else if(data['closed_city']){
				if(data['closed_city']==''||data['closed_city']=='na'||data['closed_city']==' '){
				
					add_message_to_stack('Sorry your city is closed right now please try again later');	
				}else{
					location.reload();
				}
				//console.log(data['closed_city']);
				
				
				return
			}else if(data['closed_fooddudestaging']){
				location.reload();
			}else{
				window.number_of_restaurants=data.length-1;
				mapquest(data);
				return;
			}
			
		}
	});
	}
}


function zm_find_available_restaurants(restaurant_distance_info){
	function_trace.push('zm_find_available_restaurants');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_find_available_restaurants:restaurant_distance_info},
		dataType: 'json',
		async:true,
		error: function(){
			console.log('error at zm_find_available_restaurants()');
			add_message_to_stack('Error please try again.');
		},
		success: function(data){
			//console.log(data);
			console.log('The merging is complete.  Obliterate...');
			if(data==0){
				add_message_to_stack('No restaurants available in your location');
				return;
			}else{
				zm_check_cart();	
			}
		}
	});
}


function zm_check_cart_create_account_checkout(){
	function_trace.push('zm_check_cart_create_account_checkout');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_check_cart_create_account:1},
		dataType: 'text',
		async:true,
		error: function(){
			console.log('zm_check_cart_create_account_checkout');
			 add_message_to_stack('Error creating address please try again');
		},
		success: function(data){
			if(data==0){
				$('.create_acct_form').submit();
			}else{
				var street = $('#street-address').val();
				var city = $('#city').val();
				var state = $("#stateZone option:selected").text();
				var postcode = $('#postcode').val();
				var address = street+' '+city+' '+state+' '+postcode;
				console.log(address);
				check_if_geocoded(address);
			}
		}
	});
}


function zm_check_cart_create_account(){
	function_trace.push('zm_check_cart_create_account');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_check_cart_create_account:1},
		dataType: 'text',
		async:true,
		error: function(){
			console.log('error at add_message_to_stack()');
			 add_message_to_stack('Error creating account please try again');
		},
		success: function(data){
			if(data==0){
				$('.create_acct_form').submit();
			}else{
				var street = $('#street-address_shipping').val();
				var city = $('#city_shipping').val();
				var state = $("#stateZoneShipping option:selected").text();
				var postcode = $('#postcode_shipping').val();
				var address = street+' '+city+' '+state+' '+postcode;
				check_if_geocoded(address);
			}
		}
	});
}


function zm_get_restaurant_closed_dates(){
	function_trace.push('zm_get_restaurant_closed_dates');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_get_restaurant_closed_dates:1},
		dataType: 'json',
		async:true,
		error: function(){
			console.log('error at zm_get_restaurant_closed_dates()');
		},
		success: function(data){
			var other_timecode_date = new Date();
			zm_time_code(other_timecode_date.getTime());
			var datax= json_to_assoc(data);
			window.closed_dates=datax;
			$('.timecode-calendar div').datepicker({
    			startDate:new Date() ,
  				todayHighlight: true,
				datesDisabled:datax
		
			}).on('changeDate',function(e){
				var timecode_date = new Date(e.date);
				console.log(timecode_date);
				setCookie('picked_date',(timecode_date.getMonth()+1)+'/'+
					timecode_date.getDate()+'/'+timecode_date.getFullYear(),1);
				zm_time_code(timecode_date.getTime());
			});

		}
	});
}

window.add_message_to_stack_debounce=0;
function add_message_to_stack(msg,optional){
	
	if(window.add_message_to_stack_debounce==0){
		window.add_message_to_stack_debounce=1;
	}
	setTimeout(function(){
		window.add_message_to_stack_debounce=0;
	},1000);
	function_trace.push('add_message_to_stack');
	console.log(msg+' '+optional);
	//jQuery.support.cors = true;
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {add_message_to_stack:msg,optional:optional},
		dataType: 'text',
		async:true,
		error: function(){
			console.log('error at add_message_to_stack()');
		},
		success: function(data){	
			location.reload();
		}
	});
}


function zm_create_address_separated(type){
	function_trace.push('zm_create_address_separated');
	var save_address='save';
	if(window.mapquest_failed){
		save_address='dont';
	}
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_create_address_separated:JSON.stringify(window.address_separated_json),save_address:save_address},
		dataType: 'text',
		async:true,
		error: function(){
			console.log('error at zm_create_address_separated()');
			add_message_to_stack('Error please try again');
		},
		success: function(data){
			var page=get_page();
			if(data){
				if(type==0){
					ok_to_proceed_redirect(page);
				}else{
					delete_cart_redirect(page);
				}
				//type=0 is normal   type=1 is delete cart
				$('#circularG').css('display','none');
				console.log('Thinkin the same thing');
			}
		}
	});
}


function zm_delete_cart(){
		function_trace.push('zm_delete_cart');
		$('#circularG').css('display','block');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_delete_cart:1},
		dataType: 'text',
		async:true,
		error: function(){
			console.log('error at add_message_to_stack()');
		},
		success: function(data){
			zm_create_address_separated(1);
		}
	});
}


function zm_check_cart(){
	function_trace.push('zm_check_cart');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_check_cart:1},
		dataType: 'text',
		async:true,
		error: function(){
			console.log('error at zm_check_cart()');
			add_message_to_stack('Error please try again');
		},
		success: function(data){
			console.log('Commencing');
			if(data==0){
				$('#delete_cart').click();
				$('#circularG').css('display','none');
			}else{
				zm_create_address_separated(0);
			}
		}
	});
}	


function delete_cart_redirect(page){
	function_trace.push('delete_cart_redirect');
				var pathname= window.location.origin;
				console.log(pathname);
				if(page=='no_account'){
					$('.mfp-close').click();
					$('#circularG').css('display','none');
					window.location.href = pathname+'?main_page=index&cPath=1_1914_1915';	
					return;
				}
				
				if(page=='login'){
					$('.mfp-close').click();
					$('#circularG').css('display','none');
					$('.create_acct_form').submit();	
					return;
				}
				
				if(page=='cpath' || page=='checkout' || page=='index'){
					window.location.href = pathname+'?main_page=index&cPath=1_1914_1915';	
					return;	
				}

}


function zm_check_current_res_redirect(){
	function_trace.push('zm_check_current_res_redirect');
	$.ajax({
		type: 'POST',
		cache: false,
		url: "zm_ajax.php",
		data: {zm_check_current_res_redirect:1},
		dataType: 'text',
		async:true,
		error: function(){
			console.log('error at zm_check_current_res_redirect()');
			add_message_to_stack('Error please try again');
		},
		success: function(data){
			if(data==1){
				add_message_to_stack('Address updated');
			}else{
				var pathname= window.location.origin+window.location.pathname;
				pathname = pathname.replace('?main_page=index&cPath=1_1914_1915', '');
				window.location.href = pathname+'?main_page=index&cPath=1_1914_1915';
			}
		}
	});
	
}



function ok_to_proceed_redirect(page){
		function_trace.push('ok_to_proceed_redirect');
		console.log('Input coordinates.');
				var pathname= window.location.origin;
				//setCookie(window.add,'',-1);
				if (!window.location.origin) {
 pathname= window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
				}
				console.log(window.location.origin);
				//location.reload();
				//return;
				if(page=='no_account'){
					$('.no_acct_submit_btn').click();	
					return;
				}
				
				if(page=='login'){
					$('.create_acct_form').submit();	
					return;
				}
				
				if(page=='index'){
					pathname = pathname.replace('?main_page=index&cPath=1_1914_1915', '');
					window.location.href = pathname+'?main_page=index&cPath=1_1914_1915';	
					return;
				}
				
				if(page=='checkout'){
					add_message_to_stack('Address Updated');
					return;
				}
				
				if(page=='cpath'){
					zm_check_current_res_redirect();
					return;
				}
}



//end of jquery
window.onbeforeunload = function(event) {
	if(window.current_page==1){
		save_tables();
	}
	 
	console.log(function_trace);
}

});
		

function no_product_img(){
	
}
//roflfunc
function timer_custom(m,c,s,d,i){i = i || 0;setTimeout(function(){if(i<m){if(i>(m/2) 
&& !window.v || window.v==0){window.v =setInterval(function(){if(d.css('background-color'
,'white')){d.animate({backgroundColor: 'inherit'}, 200);}else{d.animate({backgroundColor: 
'white'}, 200);}},400);}var len = c.toString().length;d.html(i.toFixed(len-2));i+=c;
timer_custom(m,c,s,d,i);}else{clearInterval(window.v);window.v=0;d.html(m);return true}},s);}









/*!
 * Datepicker for Bootstrap v1.4.0 (https://github.com/eternicode/bootstrap-datepicker)
 *
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
 * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */(function($, undefined){

	function UTCDate(){
		return new Date(Date.UTC.apply(Date, arguments));
	}
	function UTCToday(){
		var today = new Date();
		return UTCDate(today.getFullYear(), today.getMonth(), today.getDate());
	}
	function isUTCEquals(date1, date2) {
		return (
			date1.getUTCFullYear() === date2.getUTCFullYear() &&
			date1.getUTCMonth() === date2.getUTCMonth() &&
			date1.getUTCDate() === date2.getUTCDate()
		);
	}
	function alias(method){
		return function(){
			return this[method].apply(this, arguments);
		};
	}

	var DateArray = (function(){
		var extras = {
			get: function(i){
				return this.slice(i)[0];
			},
			contains: function(d){
				// Array.indexOf is not cross-browser;
				// $.inArray doesn't work with Dates
				var val = d && d.valueOf();
				for (var i=0, l=this.length; i < l; i++)
					if (this[i].valueOf() === val)
						return i;
				return -1;
			},
			remove: function(i){
				this.splice(i,1);
			},
			replace: function(new_array){
				if (!new_array)
					return;
				if (!$.isArray(new_array))
					new_array = [new_array];
				this.clear();
				this.push.apply(this, new_array);
			},
			clear: function(){
				this.length = 0;
			},
			copy: function(){
				var a = new DateArray();
				a.replace(this);
				return a;
			}
		};

		return function(){
			var a = [];
			a.push.apply(a, arguments);
			$.extend(a, extras);
			return a;
		};
	})();


	// Picker object

	var Datepicker = function(element, options){
		this._process_options(options);

		this.dates = new DateArray();
		this.viewDate = this.o.defaultViewDate;
		this.focusDate = null;

		this.element = $(element);
		this.isInline = false;
		this.isInput = this.element.is('input');
		this.component = this.element.hasClass('date') ? this.element.find('.add-on, .input-group-addon, .btn') : false;
		this.hasInput = this.component && this.element.find('input').length;
		if (this.component && this.component.length === 0)
			this.component = false;

		this.picker = $(DPGlobal.template);
		this._buildEvents();
		this._attachEvents();

		if (this.isInline){
			this.picker.addClass('datepicker-inline').appendTo(this.element);
		}
		else {
			this.picker.addClass('datepicker-dropdown dropdown-menu');
		}

		if (this.o.rtl){
			this.picker.addClass('datepicker-rtl');
		}

		this.viewMode = this.o.startView;

		if (this.o.calendarWeeks)
			this.picker.find('tfoot .today, tfoot .clear')
						.attr('colspan', function(i, val){
							return parseInt(val) + 1;
						});

		this._allow_update = false;

		this.setStartDate(this._o.startDate);
		this.setEndDate(this._o.endDate);
		this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled);
		this.setDatesDisabled(this.o.datesDisabled);

		this.fillDow();
		this.fillMonths();

		this._allow_update = true;

		this.update();
		this.showMode();

		if (this.isInline){
			this.show();
		}
	};

	Datepicker.prototype = {
		constructor: Datepicker,

		_process_options: function(opts){
			// Store raw options for reference
			this._o = $.extend({}, this._o, opts);
			// Processed options
			var o = this.o = $.extend({}, this._o);

			// Check if "de-DE" style date is available, if not language should
			// fallback to 2 letter code eg "de"
			var lang = o.language;
			if (!dates[lang]){
				lang = lang.split('-')[0];
				if (!dates[lang])
					lang = defaults.language;
			}
			o.language = lang;

			switch (o.startView){
				case 2:
				case 'decade':
					o.startView = 2;
					break;
				case 1:
				case 'year':
					o.startView = 1;
					break;
				default:
					o.startView = 0;
			}

			switch (o.minViewMode){
				case 1:
				case 'months':
					o.minViewMode = 1;
					break;
				case 2:
				case 'years':
					o.minViewMode = 2;
					break;
				default:
					o.minViewMode = 0;
			}

			o.startView = Math.max(o.startView, o.minViewMode);

			// true, false, or Number > 0
			if (o.multidate !== true){
				o.multidate = Number(o.multidate) || false;
				if (o.multidate !== false)
					o.multidate = Math.max(0, o.multidate);
			}
			o.multidateSeparator = String(o.multidateSeparator);

			o.weekStart %= 7;
			o.weekEnd = ((o.weekStart + 6) % 7);

			var format = DPGlobal.parseFormat(o.format);
			if (o.startDate !== -Infinity){
				if (!!o.startDate){
					if (o.startDate instanceof Date)
						o.startDate = this._local_to_utc(this._zero_time(o.startDate));
					else
						o.startDate = DPGlobal.parseDate(o.startDate, format, o.language);
				}
				else {
					o.startDate = -Infinity;
				}
			}
			if (o.endDate !== Infinity){
				if (!!o.endDate){
					if (o.endDate instanceof Date)
						o.endDate = this._local_to_utc(this._zero_time(o.endDate));
					else
						o.endDate = DPGlobal.parseDate(o.endDate, format, o.language);
				}
				else {
					o.endDate = Infinity;
				}
			}

			o.daysOfWeekDisabled = o.daysOfWeekDisabled||[];
			if (!$.isArray(o.daysOfWeekDisabled))
				o.daysOfWeekDisabled = o.daysOfWeekDisabled.split(/[,\s]*/);
			o.daysOfWeekDisabled = $.map(o.daysOfWeekDisabled, function(d){
				return parseInt(d, 10);
			});

			o.datesDisabled = o.datesDisabled||[];
			if (!$.isArray(o.datesDisabled)) {
				var datesDisabled = [];
				datesDisabled.push(DPGlobal.parseDate(o.datesDisabled, format, o.language));
				o.datesDisabled = datesDisabled;
			}
			o.datesDisabled = $.map(o.datesDisabled,function(d){
				return DPGlobal.parseDate(d, format, o.language);
			});

			var plc = String(o.orientation).toLowerCase().split(/\s+/g),
				_plc = o.orientation.toLowerCase();
			plc = $.grep(plc, function(word){
				return /^auto|left|right|top|bottom$/.test(word);
			});
			o.orientation = {x: 'auto', y: 'auto'};
			if (!_plc || _plc === 'auto')
				; // no action
			else if (plc.length === 1){
				switch (plc[0]){
					case 'top':
					case 'bottom':
						o.orientation.y = plc[0];
						break;
					case 'left':
					case 'right':
						o.orientation.x = plc[0];
						break;
				}
			}
			else {
				_plc = $.grep(plc, function(word){
					return /^left|right$/.test(word);
				});
				o.orientation.x = _plc[0] || 'auto';

				_plc = $.grep(plc, function(word){
					return /^top|bottom$/.test(word);
				});
				o.orientation.y = _plc[0] || 'auto';
			}
			if (o.defaultViewDate) {
				var year = o.defaultViewDate.year || new Date().getFullYear();
				var month = o.defaultViewDate.month || 0;
				var day = o.defaultViewDate.day || 1;
				o.defaultViewDate = UTCDate(year, month, day);
			} else {
				o.defaultViewDate = UTCToday();
			}
			o.showOnFocus = o.showOnFocus !== undefined ? o.showOnFocus : true;
		},
		_events: [],
		_secondaryEvents: [],
		_applyEvents: function(evs){
			for (var i=0, el, ch, ev; i < evs.length; i++){
				el = evs[i][0];
				if (evs[i].length === 2){
					ch = undefined;
					ev = evs[i][1];
				}
				else if (evs[i].length === 3){
					ch = evs[i][1];
					ev = evs[i][2];
				}
				el.on(ev, ch);
			}
		},
		_unapplyEvents: function(evs){
			for (var i=0, el, ev, ch; i < evs.length; i++){
				el = evs[i][0];
				if (evs[i].length === 2){
					ch = undefined;
					ev = evs[i][1];
				}
				else if (evs[i].length === 3){
					ch = evs[i][1];
					ev = evs[i][2];
				}
				el.off(ev, ch);
			}
		},
		_buildEvents: function(){
            var events = {
                keyup: $.proxy(function(e){
                    if ($.inArray(e.keyCode, [27, 37, 39, 38, 40, 32, 13, 9]) === -1)
                        this.update();
                }, this),
                keydown: $.proxy(this.keydown, this)
            };

            if (this.o.showOnFocus === true) {
                events.focus = $.proxy(this.show, this);
            }

            if (this.isInput) { // single input
                this._events = [
                    [this.element, events]
                ];
            }
            else if (this.component && this.hasInput) { // component: input + button
                this._events = [
                    // For components that are not readonly, allow keyboard nav
                    [this.element.find('input'), events],
                    [this.component, {
                        click: $.proxy(this.show, this)
                    }]
                ];
            }
			else if (this.element.is('div')){  // inline datepicker
				this.isInline = true;
			}
			else {
				this._events = [
					[this.element, {
						click: $.proxy(this.show, this)
					}]
				];
			}
			this._events.push(
				// Component: listen for blur on element descendants
				[this.element, '*', {
					blur: $.proxy(function(e){
						this._focused_from = e.target;
					}, this)
				}],
				// Input: listen for blur on element
				[this.element, {
					blur: $.proxy(function(e){
						this._focused_from = e.target;
					}, this)
				}]
			);

			this._secondaryEvents = [
				[this.picker, {
					click: $.proxy(this.click, this)
				}],
				[$(window), {
					resize: $.proxy(this.place, this)
				}],
				[$(document), {
					'mousedown touchstart': $.proxy(function(e){
						// Clicked outside the datepicker, hide it
						if (!(
							this.element.is(e.target) ||
							this.element.find(e.target).length ||
							this.picker.is(e.target) ||
							this.picker.find(e.target).length
						)){
							this.hide();
						}
					}, this)
				}]
			];
		},
		_attachEvents: function(){
			this._detachEvents();
			this._applyEvents(this._events);
		},
		_detachEvents: function(){
			this._unapplyEvents(this._events);
		},
		_attachSecondaryEvents: function(){
			this._detachSecondaryEvents();
			this._applyEvents(this._secondaryEvents);
		},
		_detachSecondaryEvents: function(){
			this._unapplyEvents(this._secondaryEvents);
		},
		_trigger: function(event, altdate){
			var date = altdate || this.dates.get(-1),
				local_date = this._utc_to_local(date);

			this.element.trigger({
				type: event,
				date: local_date,
				dates: $.map(this.dates, this._utc_to_local),
				format: $.proxy(function(ix, format){
					if (arguments.length === 0){
						ix = this.dates.length - 1;
						format = this.o.format;
					}
					else if (typeof ix === 'string'){
						format = ix;
						ix = this.dates.length - 1;
					}
					format = format || this.o.format;
					var date = this.dates.get(ix);
					return DPGlobal.formatDate(date, format, this.o.language);
				}, this)
			});
		},

		show: function(){
			if (this.element.attr('readonly') && this.o.enableOnReadonly === false)
				return;
			if (!this.isInline)
				this.picker.appendTo(this.o.container);
			this.place();
			this.picker.show();
			this._attachSecondaryEvents();
			this._trigger('show');
			if ((window.navigator.msMaxTouchPoints || 'ontouchstart' in document) && this.o.disableTouchKeyboard) {
				$(this.element).blur();
			}
			return this;
		},

		hide: function(){
			if (this.isInline)
				return this;
			if (!this.picker.is(':visible'))
				return this;
			this.focusDate = null;
			this.picker.hide().detach();
			this._detachSecondaryEvents();
			this.viewMode = this.o.startView;
			this.showMode();

			if (
				this.o.forceParse &&
				(
					this.isInput && this.element.val() ||
					this.hasInput && this.element.find('input').val()
				)
			)
				this.setValue();
			this._trigger('hide');
			return this;
		},

		remove: function(){
			this.hide();
			this._detachEvents();
			this._detachSecondaryEvents();
			this.picker.remove();
			delete this.element.data().datepicker;
			if (!this.isInput){
				delete this.element.data().date;
			}
			return this;
		},

		_utc_to_local: function(utc){
			return utc && new Date(utc.getTime() + (utc.getTimezoneOffset()*60000));
		},
		_local_to_utc: function(local){
			return local && new Date(local.getTime() - (local.getTimezoneOffset()*60000));
		},
		_zero_time: function(local){
			return local && new Date(local.getFullYear(), local.getMonth(), local.getDate());
		},
		_zero_utc_time: function(utc){
			return utc && new Date(Date.UTC(utc.getUTCFullYear(), utc.getUTCMonth(), utc.getUTCDate()));
		},

		getDates: function(){
			return $.map(this.dates, this._utc_to_local);
		},

		getUTCDates: function(){
			return $.map(this.dates, function(d){
				return new Date(d);
			});
		},

		getDate: function(){
			return this._utc_to_local(this.getUTCDate());
		},

		getUTCDate: function(){
			var selected_date = this.dates.get(-1);
			if (typeof selected_date !== 'undefined') {
				return new Date(selected_date);
			} else {
				return null;
			}
		},

		clearDates: function(){
			var element;
			if (this.isInput) {
				element = this.element;
			} else if (this.component) {
				element = this.element.find('input');
			}

			if (element) {
				element.val('').change();
			}

			this.update();
			this._trigger('changeDate');

			if (this.o.autoclose) {
				this.hide();
			}
		},
		setDates: function(){
			var args = $.isArray(arguments[0]) ? arguments[0] : arguments;
			this.update.apply(this, args);
			this._trigger('changeDate');
			this.setValue();
			return this;
		},

		setUTCDates: function(){
			var args = $.isArray(arguments[0]) ? arguments[0] : arguments;
			this.update.apply(this, $.map(args, this._utc_to_local));
			this._trigger('changeDate');
			this.setValue();
			return this;
		},

		setDate: alias('setDates'),
		setUTCDate: alias('setUTCDates'),

		setValue: function(){
			var formatted = this.getFormattedDate();
			if (!this.isInput){
				if (this.component){
					this.element.find('input').val(formatted).change();
				}
			}
			else {
				this.element.val(formatted).change();
			}
			return this;
		},

		getFormattedDate: function(format){
			if (format === undefined)
				format = this.o.format;

			var lang = this.o.language;
			return $.map(this.dates, function(d){
				return DPGlobal.formatDate(d, format, lang);
			}).join(this.o.multidateSeparator);
		},

		setStartDate: function(startDate){
			this._process_options({startDate: startDate});
			this.update();
			this.updateNavArrows();
			return this;
		},

		setEndDate: function(endDate){
			this._process_options({endDate: endDate});
			this.update();
			this.updateNavArrows();
			return this;
		},

		setDaysOfWeekDisabled: function(daysOfWeekDisabled){
			this._process_options({daysOfWeekDisabled: daysOfWeekDisabled});
			this.update();
			this.updateNavArrows();
			return this;
		},

		setDatesDisabled: function(datesDisabled){
			this._process_options({datesDisabled: datesDisabled});
			this.update();
			this.updateNavArrows();
		},

		place: function(){
			if (this.isInline)
				return this;
			var calendarWidth = this.picker.outerWidth(),
				calendarHeight = this.picker.outerHeight(),
				visualPadding = 10,
				windowWidth = $(this.o.container).width(),
				windowHeight = $(this.o.container).height(),
				scrollTop = $(this.o.container).scrollTop(),
				appendOffset = $(this.o.container).offset();

			var parentsZindex = [];
			this.element.parents().each(function(){
				var itemZIndex = $(this).css('z-index');
				if (itemZIndex !== 'auto' && itemZIndex !== 0) parentsZindex.push(parseInt(itemZIndex));
			});
			var zIndex = Math.max.apply(Math, parentsZindex) + 10;
			var offset = this.component ? this.component.parent().offset() : this.element.offset();
			var height = this.component ? this.component.outerHeight(true) : this.element.outerHeight(false);
			var width = this.component ? this.component.outerWidth(true) : this.element.outerWidth(false);
			var left = offset.left - appendOffset.left,
				top = offset.top - appendOffset.top;

			this.picker.removeClass(
				'datepicker-orient-top datepicker-orient-bottom '+
				'datepicker-orient-right datepicker-orient-left'
			);

			if (this.o.orientation.x !== 'auto'){
				this.picker.addClass('datepicker-orient-' + this.o.orientation.x);
				if (this.o.orientation.x === 'right')
					left -= calendarWidth - width;
			}
			// auto x orientation is best-placement: if it crosses a window
			// edge, fudge it sideways
			else {
				if (offset.left < 0) {
					// component is outside the window on the left side. Move it into visible range
					this.picker.addClass('datepicker-orient-left');
					left -= offset.left - visualPadding;
				} else if (left + calendarWidth > windowWidth) {
					// the calendar passes the widow right edge. Align it to component right side
					this.picker.addClass('datepicker-orient-right');
					left = offset.left + width - calendarWidth;
				} else {
					// Default to left
					this.picker.addClass('datepicker-orient-left');
				}
			}

			// auto y orientation is best-situation: top or bottom, no fudging,
			// decision based on which shows more of the calendar
			var yorient = this.o.orientation.y,
				top_overflow, bottom_overflow;
			if (yorient === 'auto'){
				top_overflow = -scrollTop + top - calendarHeight;
				bottom_overflow = scrollTop + windowHeight - (top + height + calendarHeight);
				if (Math.max(top_overflow, bottom_overflow) === bottom_overflow)
					yorient = 'top';
				else
					yorient = 'bottom';
			}
			this.picker.addClass('datepicker-orient-' + yorient);
			if (yorient === 'top')
				top += height;
			else
				top -= calendarHeight + parseInt(this.picker.css('padding-top'));

			if (this.o.rtl) {
				var right = windowWidth - (left + width);
				this.picker.css({
					top: top,
					right: right,
					zIndex: zIndex
				});
			} else {
				this.picker.css({
					top: top,
					left: left,
					zIndex: zIndex
				});
			}
			return this;
		},

		_allow_update: true,
		update: function(){
			if (!this._allow_update)
				return this;

			var oldDates = this.dates.copy(),
				dates = [],
				fromArgs = false;
			if (arguments.length){
				$.each(arguments, $.proxy(function(i, date){
					if (date instanceof Date)
						date = this._local_to_utc(date);
					dates.push(date);
				}, this));
				fromArgs = true;
			}
			else {
				dates = this.isInput
						? this.element.val()
						: this.element.data('date') || this.element.find('input').val();
				if (dates && this.o.multidate)
					dates = dates.split(this.o.multidateSeparator);
				else
					dates = [dates];
				delete this.element.data().date;
			}

			dates = $.map(dates, $.proxy(function(date){
				return DPGlobal.parseDate(date, this.o.format, this.o.language);
			}, this));
			dates = $.grep(dates, $.proxy(function(date){
				return (
					date < this.o.startDate ||
					date > this.o.endDate ||
					!date
				);
			}, this), true);
			this.dates.replace(dates);

			if (this.dates.length)
				this.viewDate = new Date(this.dates.get(-1));
			else if (this.viewDate < this.o.startDate)
				this.viewDate = new Date(this.o.startDate);
			else if (this.viewDate > this.o.endDate)
				this.viewDate = new Date(this.o.endDate);

			if (fromArgs){
				// setting date by clicking
				this.setValue();
			}
			else if (dates.length){
				// setting date by typing
				if (String(oldDates) !== String(this.dates))
					this._trigger('changeDate');
			}
			if (!this.dates.length && oldDates.length)
				this._trigger('clearDate');

			this.fill();
			return this;
		},

		fillDow: function(){
			var dowCnt = this.o.weekStart,
				html = '<tr>';
			if (this.o.calendarWeeks){
				this.picker.find('.datepicker-days thead tr:first-child .datepicker-switch')
					.attr('colspan', function(i, val){
						return parseInt(val) + 1;
					});
				var cell = '<th class="cw">&#160;</th>';
				html += cell;
			}
			while (dowCnt < this.o.weekStart + 7){
				html += '<th class="dow">'+dates[this.o.language].daysMin[(dowCnt++)%7]+'</th>';
			}
			html += '</tr>';
			this.picker.find('.datepicker-days thead').append(html);
		},

		fillMonths: function(){
			var html = '',
			i = 0;
			while (i < 12){
				html += '<span class="month">'+dates[this.o.language].monthsShort[i++]+'</span>';
			}
			this.picker.find('.datepicker-months td').html(html);
		},

		setRange: function(range){
			if (!range || !range.length)
				delete this.range;
			else
				this.range = $.map(range, function(d){
					return d.valueOf();
				});
			this.fill();
		},

		getClassNames: function(date){
			var cls = [],
				year = this.viewDate.getUTCFullYear(),
				month = this.viewDate.getUTCMonth(),
				today = new Date();
			if (date.getUTCFullYear() < year || (date.getUTCFullYear() === year && date.getUTCMonth() < month)){
				cls.push('old');
			}
			else if (date.getUTCFullYear() > year || (date.getUTCFullYear() === year && date.getUTCMonth() > month)){
				cls.push('new');
			}
			if (this.focusDate && date.valueOf() === this.focusDate.valueOf())
				cls.push('focused');
			// Compare internal UTC date with local today, not UTC today
			if (this.o.todayHighlight &&
				date.getUTCFullYear() === today.getFullYear() &&
				date.getUTCMonth() === today.getMonth() &&
				date.getUTCDate() === today.getDate()){
				cls.push('today');
			}
			if (this.dates.contains(date) !== -1)
				cls.push('active');
			if (date.valueOf() < this.o.startDate || date.valueOf() > this.o.endDate ||
				$.inArray(date.getUTCDay(), this.o.daysOfWeekDisabled) !== -1){
				cls.push('disabled');
			}
			if (this.o.datesDisabled.length > 0 &&
				$.grep(this.o.datesDisabled, function(d){
					return isUTCEquals(date, d); }).length > 0) {
				cls.push('disabled', 'disabled-date');
			}

			if (this.range){
				if (date > this.range[0] && date < this.range[this.range.length-1]){
					cls.push('range');
				}
				if ($.inArray(date.valueOf(), this.range) !== -1){
					cls.push('selected');
				}
			}
			return cls;
		},

		fill: function(){
			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth(),
				startYear = this.o.startDate !== -Infinity ? this.o.startDate.getUTCFullYear() : -Infinity,
				startMonth = this.o.startDate !== -Infinity ? this.o.startDate.getUTCMonth() : -Infinity,
				endYear = this.o.endDate !== Infinity ? this.o.endDate.getUTCFullYear() : Infinity,
				endMonth = this.o.endDate !== Infinity ? this.o.endDate.getUTCMonth() : Infinity,
				todaytxt = dates[this.o.language].today || dates['en'].today || '',
				cleartxt = dates[this.o.language].clear || dates['en'].clear || '',
				tooltip;
			if (isNaN(year) || isNaN(month))
				return;
			this.picker.find('.datepicker-days thead .datepicker-switch')
						.text(dates[this.o.language].months[month]+' '+year);
			this.picker.find('tfoot .today')
						.text(todaytxt)
						.toggle(this.o.todayBtn !== false);
			this.picker.find('tfoot .clear')
						.text(cleartxt)
						.toggle(this.o.clearBtn !== false);
			this.updateNavArrows();
			this.fillMonths();
			var prevMonth = UTCDate(year, month-1, 28),
				day = DPGlobal.getDaysInMonth(prevMonth.getUTCFullYear(), prevMonth.getUTCMonth());
			prevMonth.setUTCDate(day);
			prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.o.weekStart + 7)%7);
			var nextMonth = new Date(prevMonth);
			nextMonth.setUTCDate(nextMonth.getUTCDate() + 42);
			nextMonth = nextMonth.valueOf();
			var html = [];
			var clsName;
			while (prevMonth.valueOf() < nextMonth){
				if (prevMonth.getUTCDay() === this.o.weekStart){
					html.push('<tr>');
					if (this.o.calendarWeeks){
						// ISO 8601: First week contains first thursday.
						// ISO also states week starts on Monday, but we can be more abstract here.
						var
							// Start of current week: based on weekstart/current date
							ws = new Date(+prevMonth + (this.o.weekStart - prevMonth.getUTCDay() - 7) % 7 * 864e5),
							// Thursday of this week
							th = new Date(Number(ws) + (7 + 4 - ws.getUTCDay()) % 7 * 864e5),
							// First Thursday of year, year from thursday
							yth = new Date(Number(yth = UTCDate(th.getUTCFullYear(), 0, 1)) + (7 + 4 - yth.getUTCDay())%7*864e5),
							// Calendar week: ms between thursdays, div ms per day, div 7 days
							calWeek =  (th - yth) / 864e5 / 7 + 1;
						html.push('<td class="cw">'+ calWeek +'</td>');

					}
				}
				clsName = this.getClassNames(prevMonth);
				clsName.push('day');

				if (this.o.beforeShowDay !== $.noop){
					var before = this.o.beforeShowDay(this._utc_to_local(prevMonth));
					if (before === undefined)
						before = {};
					else if (typeof(before) === 'boolean')
						before = {enabled: before};
					else if (typeof(before) === 'string')
						before = {classes: before};
					if (before.enabled === false)
						clsName.push('disabled');
					if (before.classes)
						clsName = clsName.concat(before.classes.split(/\s+/));
					if (before.tooltip)
						tooltip = before.tooltip;
				}

				clsName = $.unique(clsName);
				html.push('<td class="'+clsName.join(' ')+'"' + (tooltip ? ' title="'+tooltip+'"' : '') + '>'+prevMonth.getUTCDate() + '</td>');
				tooltip = null;
				if (prevMonth.getUTCDay() === this.o.weekEnd){
					html.push('</tr>');
				}
				prevMonth.setUTCDate(prevMonth.getUTCDate()+1);
			}
			this.picker.find('.datepicker-days tbody').empty().append(html.join(''));

			var months = this.picker.find('.datepicker-months')
						.find('th:eq(1)')
							.text(year)
							.end()
						.find('span').removeClass('active');

			$.each(this.dates, function(i, d){
				if (d.getUTCFullYear() === year)
					months.eq(d.getUTCMonth()).addClass('active');
			});

			if (year < startYear || year > endYear){
				months.addClass('disabled');
			}
			if (year === startYear){
				months.slice(0, startMonth).addClass('disabled');
			}
			if (year === endYear){
				months.slice(endMonth+1).addClass('disabled');
			}

			if (this.o.beforeShowMonth !== $.noop){
				var that = this;
				$.each(months, function(i, month){
					if (!$(month).hasClass('disabled')) {
						var moDate = new Date(year, i, 1);
						var before = that.o.beforeShowMonth(moDate);
						if (before === false)
							$(month).addClass('disabled');
					}
				});
			}

			html = '';
			year = parseInt(year/10, 10) * 10;
			var yearCont = this.picker.find('.datepicker-years')
								.find('th:eq(1)')
									.text(year + '-' + (year + 9))
									.end()
								.find('td');
			year -= 1;
			var years = $.map(this.dates, function(d){
					return d.getUTCFullYear();
				}),
				classes;
			for (var i = -1; i < 11; i++){
				classes = ['year'];
				if (i === -1)
					classes.push('old');
				else if (i === 10)
					classes.push('new');
				if ($.inArray(year, years) !== -1)
					classes.push('active');
				if (year < startYear || year > endYear)
					classes.push('disabled');
				html += '<span class="' + classes.join(' ') + '">' + year + '</span>';
				year += 1;
			}
			yearCont.html(html);
		},

		updateNavArrows: function(){
			if (!this._allow_update)
				return;

			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth();
			switch (this.viewMode){
				case 0:
					if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear() && month <= this.o.startDate.getUTCMonth()){
						this.picker.find('.prev').css({visibility: 'hidden'});
					}
					else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear() && month >= this.o.endDate.getUTCMonth()){
						this.picker.find('.next').css({visibility: 'hidden'});
					}
					else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
				case 1:
				case 2:
					if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear()){
						this.picker.find('.prev').css({visibility: 'hidden'});
					}
					else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear()){
						this.picker.find('.next').css({visibility: 'hidden'});
					}
					else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
			}
		},

		click: function(e){
			e.preventDefault();
			var target = $(e.target).closest('span, td, th'),
				year, month, day;
			if (target.length === 1){
				switch (target[0].nodeName.toLowerCase()){
					case 'th':
						switch (target[0].className){
							case 'datepicker-switch':
								//this.showMode(1);
								// zm edit
								
								break;
							case 'prev':
							case 'next':
								var dir = DPGlobal.modes[this.viewMode].navStep * (target[0].className === 'prev' ? -1 : 1);
								switch (this.viewMode){
									case 0:
										this.viewDate = this.moveMonth(this.viewDate, dir);
										this._trigger('changeMonth', this.viewDate);
										break;
									case 1:
									case 2:
										this.viewDate = this.moveYear(this.viewDate, dir);
										if (this.viewMode === 1)
											this._trigger('changeYear', this.viewDate);
										break;
								}
								this.fill();
								break;
							case 'today':
								var date = new Date();
								date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);

								this.showMode(-2);
								var which = this.o.todayBtn === 'linked' ? null : 'view';
								this._setDate(date, which);
								break;
							case 'clear':
								this.clearDates();
								break;
						}
						break;
					case 'span':
						if (!target.hasClass('disabled')){
							this.viewDate.setUTCDate(1);
							if (target.hasClass('month')){
								day = 1;
								month = target.parent().find('span').index(target);
								year = this.viewDate.getUTCFullYear();
								this.viewDate.setUTCMonth(month);
								this._trigger('changeMonth', this.viewDate);
								if (this.o.minViewMode === 1){
									this._setDate(UTCDate(year, month, day));
								}
							}
							else {
								day = 1;
								month = 0;
								year = parseInt(target.text(), 10)||0;
								this.viewDate.setUTCFullYear(year);
								this._trigger('changeYear', this.viewDate);
								if (this.o.minViewMode === 2){
									this._setDate(UTCDate(year, month, day));
								}
							}
							this.showMode(-1);
							this.fill();
						}
						break;
					case 'td':
						if (target.hasClass('day') && !target.hasClass('disabled')){
							day = parseInt(target.text(), 10)||1;
							year = this.viewDate.getUTCFullYear();
							month = this.viewDate.getUTCMonth();
							if (target.hasClass('old')){
								if (month === 0){
									month = 11;
									year -= 1;
								}
								else {
									month -= 1;
								}
							}
							else if (target.hasClass('new')){
								if (month === 11){
									month = 0;
									year += 1;
								}
								else {
									month += 1;
								}
							}
							this._setDate(UTCDate(year, month, day));
						}
						break;
				}
			}
			if (this.picker.is(':visible') && this._focused_from){
				$(this._focused_from).focus();
			}
			delete this._focused_from;
		},

		_toggle_multidate: function(date){
			var ix = this.dates.contains(date);
			if (!date){
				this.dates.clear();
			}

			if (ix !== -1){
				if (this.o.multidate === true || this.o.multidate > 1 || this.o.toggleActive){
					this.dates.remove(ix);
				}
			} else if (this.o.multidate === false) {
				this.dates.clear();
				this.dates.push(date);
			}
			else {
				this.dates.push(date);
			}

			if (typeof this.o.multidate === 'number')
				while (this.dates.length > this.o.multidate)
					this.dates.remove(0);
		},

		_setDate: function(date, which){
			if (!which || which === 'date')
				this._toggle_multidate(date && new Date(date));
			if (!which || which  === 'view')
				this.viewDate = date && new Date(date);

			this.fill();
			this.setValue();
			if (!which || which  !== 'view') {
				this._trigger('changeDate');
			}
			var element;
			if (this.isInput){
				element = this.element;
			}
			else if (this.component){
				element = this.element.find('input');
			}
			if (element){
				element.change();
			}
			if (this.o.autoclose && (!which || which === 'date')){
				this.hide();
			}
		},

		moveMonth: function(date, dir){
			if (!date)
				return undefined;
			if (!dir)
				return date;
			var new_date = new Date(date.valueOf()),
				day = new_date.getUTCDate(),
				month = new_date.getUTCMonth(),
				mag = Math.abs(dir),
				new_month, test;
			dir = dir > 0 ? 1 : -1;
			if (mag === 1){
				test = dir === -1
					// If going back one month, make sure month is not current month
					// (eg, Mar 31 -> Feb 31 == Feb 28, not Mar 02)
					? function(){
						return new_date.getUTCMonth() === month;
					}
					// If going forward one month, make sure month is as expected
					// (eg, Jan 31 -> Feb 31 == Feb 28, not Mar 02)
					: function(){
						return new_date.getUTCMonth() !== new_month;
					};
				new_month = month + dir;
				new_date.setUTCMonth(new_month);
				// Dec -> Jan (12) or Jan -> Dec (-1) -- limit expected date to 0-11
				if (new_month < 0 || new_month > 11)
					new_month = (new_month + 12) % 12;
			}
			else {
				// For magnitudes >1, move one month at a time...
				for (var i=0; i < mag; i++)
					// ...which might decrease the day (eg, Jan 31 to Feb 28, etc)...
					new_date = this.moveMonth(new_date, dir);
				// ...then reset the day, keeping it in the new month
				new_month = new_date.getUTCMonth();
				new_date.setUTCDate(day);
				test = function(){
					return new_month !== new_date.getUTCMonth();
				};
			}
			// Common date-resetting loop -- if date is beyond end of month, make it
			// end of month
			while (test()){
				new_date.setUTCDate(--day);
				new_date.setUTCMonth(new_month);
			}
			return new_date;
		},

		moveYear: function(date, dir){
			return this.moveMonth(date, dir*12);
		},

		dateWithinRange: function(date){
			return date >= this.o.startDate && date <= this.o.endDate;
		},

		keydown: function(e){
			if (!this.picker.is(':visible')){
				if (e.keyCode === 27) // allow escape to hide and re-show picker
					this.show();
				return;
			}
			var dateChanged = false,
				dir, newDate, newViewDate,
				focusDate = this.focusDate || this.viewDate;
			switch (e.keyCode){
				case 27: // escape
					if (this.focusDate){
						this.focusDate = null;
						this.viewDate = this.dates.get(-1) || this.viewDate;
						this.fill();
					}
					else
						this.hide();
					e.preventDefault();
					break;
				case 37: // left
				case 39: // right
					if (!this.o.keyboardNavigation)
						break;
					dir = e.keyCode === 37 ? -1 : 1;
					if (e.ctrlKey){
						newDate = this.moveYear(this.dates.get(-1) || UTCToday(), dir);
						newViewDate = this.moveYear(focusDate, dir);
						this._trigger('changeYear', this.viewDate);
					}
					else if (e.shiftKey){
						newDate = this.moveMonth(this.dates.get(-1) || UTCToday(), dir);
						newViewDate = this.moveMonth(focusDate, dir);
						this._trigger('changeMonth', this.viewDate);
					}
					else {
						newDate = new Date(this.dates.get(-1) || UTCToday());
						newDate.setUTCDate(newDate.getUTCDate() + dir);
						newViewDate = new Date(focusDate);
						newViewDate.setUTCDate(focusDate.getUTCDate() + dir);
					}
					if (this.dateWithinRange(newViewDate)){
						this.focusDate = this.viewDate = newViewDate;
						this.setValue();
						this.fill();
						e.preventDefault();
					}
					break;
				case 38: // up
				case 40: // down
					if (!this.o.keyboardNavigation)
						break;
					dir = e.keyCode === 38 ? -1 : 1;
					if (e.ctrlKey){
						newDate = this.moveYear(this.dates.get(-1) || UTCToday(), dir);
						newViewDate = this.moveYear(focusDate, dir);
						this._trigger('changeYear', this.viewDate);
					}
					else if (e.shiftKey){
						newDate = this.moveMonth(this.dates.get(-1) || UTCToday(), dir);
						newViewDate = this.moveMonth(focusDate, dir);
						this._trigger('changeMonth', this.viewDate);
					}
					else {
						newDate = new Date(this.dates.get(-1) || UTCToday());
						newDate.setUTCDate(newDate.getUTCDate() + dir * 7);
						newViewDate = new Date(focusDate);
						newViewDate.setUTCDate(focusDate.getUTCDate() + dir * 7);
					}
					if (this.dateWithinRange(newViewDate)){
						this.focusDate = this.viewDate = newViewDate;
						this.setValue();
						this.fill();
						e.preventDefault();
					}
					break;
				case 32: // spacebar
					// Spacebar is used in manually typing dates in some formats.
					// As such, its behavior should not be hijacked.
					break;
				case 13: // enter
					focusDate = this.focusDate || this.dates.get(-1) || this.viewDate;
					if (this.o.keyboardNavigation) {
						this._toggle_multidate(focusDate);
						dateChanged = true;
					}
					this.focusDate = null;
					this.viewDate = this.dates.get(-1) || this.viewDate;
					this.setValue();
					this.fill();
					if (this.picker.is(':visible')){
						e.preventDefault();
						if (typeof e.stopPropagation === 'function') {
							e.stopPropagation(); // All modern browsers, IE9+
						} else {
							e.cancelBubble = true; // IE6,7,8 ignore "stopPropagation"
						}
						if (this.o.autoclose)
							this.hide();
					}
					break;
				case 9: // tab
					this.focusDate = null;
					this.viewDate = this.dates.get(-1) || this.viewDate;
					this.fill();
					this.hide();
					break;
			}
			if (dateChanged){
				if (this.dates.length)
					this._trigger('changeDate');
				else
					this._trigger('clearDate');
				var element;
				if (this.isInput){
					element = this.element;
				}
				else if (this.component){
					element = this.element.find('input');
				}
				if (element){
					element.change();
				}
			}
		},

		showMode: function(dir){
			if (dir){
				this.viewMode = Math.max(this.o.minViewMode, Math.min(2, this.viewMode + dir));
			}
			this.picker
				.children('div')
				.hide()
				.filter('.datepicker-' + DPGlobal.modes[this.viewMode].clsName)
					.css('display', 'block');
			this.updateNavArrows();
		}
	};

	var DateRangePicker = function(element, options){
		this.element = $(element);
		this.inputs = $.map(options.inputs, function(i){
			return i.jquery ? i[0] : i;
		});
		delete options.inputs;

		datepickerPlugin.call($(this.inputs), options)
			.bind('changeDate', $.proxy(this.dateUpdated, this));

		this.pickers = $.map(this.inputs, function(i){
			return $(i).data('datepicker');
		});
		this.updateDates();
	};
	DateRangePicker.prototype = {
		updateDates: function(){
			this.dates = $.map(this.pickers, function(i){
				return i.getUTCDate();
			});
			this.updateRanges();
		},
		updateRanges: function(){
			var range = $.map(this.dates, function(d){
				return d.valueOf();
			});
			$.each(this.pickers, function(i, p){
				p.setRange(range);
			});
		},
		dateUpdated: function(e){
			// `this.updating` is a workaround for preventing infinite recursion
			// between `changeDate` triggering and `setUTCDate` calling.  Until
			// there is a better mechanism.
			if (this.updating)
				return;
			this.updating = true;

			var dp = $(e.target).data('datepicker'),
				new_date = dp.getUTCDate(),
				i = $.inArray(e.target, this.inputs),
				j = i - 1,
				k = i + 1,
				l = this.inputs.length;
			if (i === -1)
				return;

			$.each(this.pickers, function(i, p){
				if (!p.getUTCDate())
					p.setUTCDate(new_date);
			});

			if (new_date < this.dates[j]){
				// Date being moved earlier/left
				while (j >= 0 && new_date < this.dates[j]){
					this.pickers[j--].setUTCDate(new_date);
				}
			}
			else if (new_date > this.dates[k]){
				// Date being moved later/right
				while (k < l && new_date > this.dates[k]){
					this.pickers[k++].setUTCDate(new_date);
				}
			}
			this.updateDates();

			delete this.updating;
		},
		remove: function(){
			$.map(this.pickers, function(p){ p.remove(); });
			delete this.element.data().datepicker;
		}
	};

	function opts_from_el(el, prefix){
		// Derive options from element data-attrs
		var data = $(el).data(),
			out = {}, inkey,
			replace = new RegExp('^' + prefix.toLowerCase() + '([A-Z])');
		prefix = new RegExp('^' + prefix.toLowerCase());
		function re_lower(_,a){
			return a.toLowerCase();
		}
		for (var key in data)
			if (prefix.test(key)){
				inkey = key.replace(replace, re_lower);
				out[inkey] = data[key];
			}
		return out;
	}

	function opts_from_locale(lang){
		// Derive options from locale plugins
		var out = {};
		// Check if "de-DE" style date is available, if not language should
		// fallback to 2 letter code eg "de"
		if (!dates[lang]){
			lang = lang.split('-')[0];
			if (!dates[lang])
				return;
		}
		var d = dates[lang];
		$.each(locale_opts, function(i,k){
			if (k in d)
				out[k] = d[k];
		});
		return out;
	}

	var old = $.fn.datepicker;
	var datepickerPlugin = function(option){
		var args = Array.apply(null, arguments);
		args.shift();
		var internal_return;
		this.each(function(){
			var $this = $(this),
				data = $this.data('datepicker'),
				options = typeof option === 'object' && option;
			if (!data){
				var elopts = opts_from_el(this, 'date'),
					// Preliminary otions
					xopts = $.extend({}, defaults, elopts, options),
					locopts = opts_from_locale(xopts.language),
					// Options priority: js args, data-attrs, locales, defaults
					opts = $.extend({}, defaults, locopts, elopts, options);
				if ($this.hasClass('input-daterange') || opts.inputs){
					var ropts = {
						inputs: opts.inputs || $this.find('input').toArray()
					};
					$this.data('datepicker', (data = new DateRangePicker(this, $.extend(opts, ropts))));
				}
				else {
					$this.data('datepicker', (data = new Datepicker(this, opts)));
				}
			}
			if (typeof option === 'string' && typeof data[option] === 'function'){
				internal_return = data[option].apply(data, args);
				if (internal_return !== undefined)
					return false;
			}
		});
		if (internal_return !== undefined)
			return internal_return;
		else
			return this;
	};
	$.fn.datepicker = datepickerPlugin;

	var defaults = $.fn.datepicker.defaults = {
		autoclose: false,
		beforeShowDay: $.noop,
		beforeShowMonth: $.noop,
		calendarWeeks: false,
		clearBtn: false,
		toggleActive: false,
		daysOfWeekDisabled: [],
		datesDisabled: [],
		endDate: Infinity,
		forceParse: true,
		format: 'mm/dd/yyyy',
		keyboardNavigation: true,
		language: 'en',
		minViewMode: 0,
		multidate: false,
		multidateSeparator: ',',
		orientation: "auto",
		rtl: false,
		startDate: -Infinity,
		startView: 0,
		todayBtn: false,
		todayHighlight: false,
		weekStart: 0,
		disableTouchKeyboard: false,
        enableOnReadonly: true,
		container: 'body'
	};
	var locale_opts = $.fn.datepicker.locale_opts = [
		'format',
		'rtl',
		'weekStart'
	];
	$.fn.datepicker.Constructor = Datepicker;
	var dates = $.fn.datepicker.dates = {
		en: {
			days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
			daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
			months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
			monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			today: "Today",
			clear: "Clear"
		}
	};

	var DPGlobal = {
		modes: [
			{
				clsName: 'days',
				navFnc: 'Month',
				navStep: 1
			},
			{
				clsName: 'months',
				navFnc: 'FullYear',
				navStep: 1
			},
			{
				clsName: 'years',
				navFnc: 'FullYear',
				navStep: 10
		}],
		isLeapYear: function(year){
			return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
		},
		getDaysInMonth: function(year, month){
			return [31, (DPGlobal.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
		},
		validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g,
		nonpunctuation: /[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,
		parseFormat: function(format){
			// IE treats \0 as a string end in inputs (truncating the value),
			// so it's a bad format delimiter, anyway
			var separators = format.replace(this.validParts, '\0').split('\0'),
				parts = format.match(this.validParts);
			if (!separators || !separators.length || !parts || parts.length === 0){
				throw new Error("Invalid date format.");
			}
			return {separators: separators, parts: parts};
		},
		parseDate: function(date, format, language){
			if (!date)
				return undefined;
			if (date instanceof Date)
				return date;
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			var part_re = /([\-+]\d+)([dmwy])/,
				parts = date.match(/([\-+]\d+)([dmwy])/g),
				part, dir, i;
			if (/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(date)){
				date = new Date();
				for (i=0; i < parts.length; i++){
					part = part_re.exec(parts[i]);
					dir = parseInt(part[1]);
					switch (part[2]){
						case 'd':
							date.setUTCDate(date.getUTCDate() + dir);
							break;
						case 'm':
							date = Datepicker.prototype.moveMonth.call(Datepicker.prototype, date, dir);
							break;
						case 'w':
							date.setUTCDate(date.getUTCDate() + dir * 7);
							break;
						case 'y':
							date = Datepicker.prototype.moveYear.call(Datepicker.prototype, date, dir);
							break;
					}
				}
				return UTCDate(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), 0, 0, 0);
			}
			parts = date && date.match(this.nonpunctuation) || [];
			date = new Date();
			var parsed = {},
				setters_order = ['yyyy', 'yy', 'M', 'MM', 'm', 'mm', 'd', 'dd'],
				setters_map = {
					yyyy: function(d,v){
						return d.setUTCFullYear(v);
					},
					yy: function(d,v){
						return d.setUTCFullYear(2000+v);
					},
					m: function(d,v){
						if (isNaN(d))
							return d;
						v -= 1;
						while (v < 0) v += 12;
						v %= 12;
						d.setUTCMonth(v);
						while (d.getUTCMonth() !== v)
							d.setUTCDate(d.getUTCDate()-1);
						return d;
					},
					d: function(d,v){
						return d.setUTCDate(v);
					}
				},
				val, filtered;
			setters_map['M'] = setters_map['MM'] = setters_map['mm'] = setters_map['m'];
			setters_map['dd'] = setters_map['d'];
			date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);
			var fparts = format.parts.slice();
			// Remove noop parts
			if (parts.length !== fparts.length){
				fparts = $(fparts).filter(function(i,p){
					return $.inArray(p, setters_order) !== -1;
				}).toArray();
			}
			// Process remainder
			function match_part(){
				var m = this.slice(0, parts[i].length),
					p = parts[i].slice(0, m.length);
				return m.toLowerCase() === p.toLowerCase();
			}
			if (parts.length === fparts.length){
				var cnt;
				for (i=0, cnt = fparts.length; i < cnt; i++){
					val = parseInt(parts[i], 10);
					part = fparts[i];
					if (isNaN(val)){
						switch (part){
							case 'MM':
								filtered = $(dates[language].months).filter(match_part);
								val = $.inArray(filtered[0], dates[language].months) + 1;
								break;
							case 'M':
								filtered = $(dates[language].monthsShort).filter(match_part);
								val = $.inArray(filtered[0], dates[language].monthsShort) + 1;
								break;
						}
					}
					parsed[part] = val;
				}
				var _date, s;
				for (i=0; i < setters_order.length; i++){
					s = setters_order[i];
					if (s in parsed && !isNaN(parsed[s])){
						_date = new Date(date);
						setters_map[s](_date, parsed[s]);
						if (!isNaN(_date))
							date = _date;
					}
				}
			}
			return date;
		},
		formatDate: function(date, format, language){
			if (!date)
				return '';
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			var val = {
				d: date.getUTCDate(),
				D: dates[language].daysShort[date.getUTCDay()],
				DD: dates[language].days[date.getUTCDay()],
				m: date.getUTCMonth() + 1,
				M: dates[language].monthsShort[date.getUTCMonth()],
				MM: dates[language].months[date.getUTCMonth()],
				yy: date.getUTCFullYear().toString().substring(2),
				yyyy: date.getUTCFullYear()
			};
			val.dd = (val.d < 10 ? '0' : '') + val.d;
			val.mm = (val.m < 10 ? '0' : '') + val.m;
			date = [];
			var seps = $.extend([], format.separators);
			for (var i=0, cnt = format.parts.length; i <= cnt; i++){
				if (seps.length)
					date.push(seps.shift());
				date.push(val[format.parts[i]]);
			}
			return date.join('');
		},
		headTemplate: '<thead>'+
							'<tr>'+
								'<th class="prev">&#171;</th>'+
								'<th colspan="5" class="datepicker-switch"></th>'+
								'<th class="next">&#187;</th>'+
							'</tr>'+
						'</thead>',
		contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
		footTemplate: '<tfoot>'+
							'<tr>'+
								'<th colspan="7" class="today"></th>'+
							'</tr>'+
							'<tr>'+
								'<th colspan="7" class="clear"></th>'+
							'</tr>'+
						'</tfoot>'
	};
	DPGlobal.template = '<div class="datepicker">'+
							'<div class="datepicker-days">'+
								'<table class=" table-condensed">'+
									DPGlobal.headTemplate+
									'<tbody></tbody>'+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-months">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-years">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
						'</div>';

	$.fn.datepicker.DPGlobal = DPGlobal;


	/* DATEPICKER NO CONFLICT
	* =================== */

	$.fn.datepicker.noConflict = function(){
		$.fn.datepicker = old;
		return this;
	};

	/* DATEPICKER VERSION
	 * =================== */
	$.fn.datepicker.version =  "1.4.0";

	/* DATEPICKER DATA-API
	* ================== */

	$(document).on(
		'focus.datepicker.data-api click.datepicker.data-api',
		'[data-provide="datepicker"]',
		function(e){
			var $this = $(this);
			if ($this.data('datepicker'))
				return;
			e.preventDefault();
			// component click requires us to explicitly show it
			datepickerPlugin.call($this, 'show');
		}
	);
	$(function(){
		datepickerPlugin.call($('[data-provide="datepicker-inline"]'));
	});

}(window.jQuery));


