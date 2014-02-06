/*!
 * jQuery Form Plugin
 * version: 2.84 (12-AUG-2011)
 * @requires jQuery v1.3.2 or later
 *
 * Examples and documentation at: http://malsup.com/jquery/form/
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
;(function(b){b.fn.ajaxSubmit=function(d){if(!this.length){a("ajaxSubmit: skipping submit process - no element selected");return this}var c,p,f,g=this;if(typeof d=="function"){d={success:d}}c=this.attr("method");p=this.attr("action");f=(typeof p==="string")?b.trim(p):"";f=f||window.location.href||"";if(f){f=(f.match(/^([^#]+)/)||[])[1]}d=b.extend(true,{url:f,success:b.ajaxSettings.success,type:c||"GET",iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank"},d);var j={};this.trigger("form-pre-serialize",[this,d,j]);if(j.veto){a("ajaxSubmit: submit vetoed via form-pre-serialize trigger");return this}if(d.beforeSerialize&&d.beforeSerialize(this,d)===false){a("ajaxSubmit: submit aborted via beforeSerialize callback");return this}var o,i,w=this.formToArray(d.semantic);if(d.data){d.extraData=d.data;for(o in d.data){if(b.isArray(d.data[o])){for(var r in d.data[o]){w.push({name:o,value:d.data[o][r]})}}else{i=d.data[o];i=b.isFunction(i)?i():i;w.push({name:o,value:i})}}}if(d.beforeSubmit&&d.beforeSubmit(w,this,d)===false){a("ajaxSubmit: submit aborted via beforeSubmit callback");return this}this.trigger("form-submit-validate",[w,this,d,j]);if(j.veto){a("ajaxSubmit: submit vetoed via form-submit-validate trigger");return this}var m=b.param(w);if(d.type.toUpperCase()=="GET"){d.url+=(d.url.indexOf("?")>=0?"&":"?")+m;d.data=null}else{d.data=m}var x=[];if(d.resetForm){x.push(function(){g.resetForm()})}if(d.clearForm){x.push(function(){g.clearForm()})}if(!d.dataType&&d.target){var e=d.success||function(){};x.push(function(n){var k=d.replaceTarget?"replaceWith":"html";b(d.target)[k](n).each(e,arguments)})}else{if(d.success){x.push(d.success)}}d.success=function(y,n,z){var v=d.context||d;for(var q=0,k=x.length;q<k;q++){x[q].apply(v,[y,n,z||g,g])}};var t=b("input:file",this).length>0;var s="multipart/form-data";var l=(g.attr("enctype")==s||g.attr("encoding")==s);if(d.iframe!==false&&(t||d.iframe||l)){if(d.closeKeepAlive){b.get(d.closeKeepAlive,function(){h(w)})}else{h(w)}}else{if(b.browser.msie&&c=="get"){var u=g[0].getAttribute("method");if(typeof u==="string"){d.type=u}}b.ajax(d)}this.trigger("form-submit-notify",[this,d]);return this;function h(T){var y=g[0],v,P,J,R,M,A,E,C,D,N,Q,H;var B=!!b.fn.prop;if(T){for(P=0;P<T.length;P++){v=b(y[T[P].name]);v[B?"prop":"attr"]("disabled",false)}}if(b(":input[name=submit],:input[id=submit]",y).length){alert('Error: Form elements must not have name or id of "submit".');return}J=b.extend(true,{},b.ajaxSettings,d);J.context=J.context||J;M="jqFormIO"+(new Date().getTime());if(J.iframeTarget){A=b(J.iframeTarget);N=A.attr("name");if(N==null){A.attr("name",M)}else{M=N}}else{A=b('<iframe name="'+M+'" src="'+J.iframeSrc+'" />');A.css({position:"absolute",top:"-1000px",left:"-1000px"})}E=A[0];C={aborted:0,responseText:null,responseXML:null,status:0,statusText:"n/a",getAllResponseHeaders:function(){},getResponseHeader:function(){},setRequestHeader:function(){},abort:function(n){var W=(n==="timeout"?"timeout":"aborted");a("aborting upload... "+W);this.aborted=1;A.attr("src",J.iframeSrc);C.error=W;J.error&&J.error.call(J.context,C,W,n);R&&b.event.trigger("ajaxError",[C,J,W]);J.complete&&J.complete.call(J.context,C,W)}};R=J.global;if(R&&!b.active++){b.event.trigger("ajaxStart")}if(R){b.event.trigger("ajaxSend",[C,J])}if(J.beforeSend&&J.beforeSend.call(J.context,C,J)===false){if(J.global){b.active--}return}if(C.aborted){return}D=y.clk;if(D){N=D.name;if(N&&!D.disabled){J.extraData=J.extraData||{};J.extraData[N]=D.value;if(D.type=="image"){J.extraData[N+".x"]=y.clk_x;J.extraData[N+".y"]=y.clk_y}}}var I=1;var F=2;function G(W){var n=W.contentWindow?W.contentWindow.document:W.contentDocument?W.contentDocument:W.document;return n}function O(){var Y=g.attr("target"),W=g.attr("action");y.setAttribute("target",M);if(!c){y.setAttribute("method","POST")}if(W!=J.url){y.setAttribute("action",J.url)}if(!J.skipEncodingOverride&&(!c||/post/i.test(c))){g.attr({encoding:"multipart/form-data",enctype:"multipart/form-data"})}if(J.timeout){H=setTimeout(function(){Q=true;L(I)},J.timeout)}function Z(){try{var n=G(E).readyState;a("state = "+n);if(n.toLowerCase()=="uninitialized"){setTimeout(Z,50)}}catch(ab){a("Server abort: ",ab," (",ab.name,")");L(F);H&&clearTimeout(H);H=undefined}}var X=[];try{if(J.extraData){for(var aa in J.extraData){X.push(b('<input type="hidden" name="'+aa+'" />').attr("value",J.extraData[aa]).appendTo(y)[0])}}if(!J.iframeTarget){A.appendTo("body");E.attachEvent?E.attachEvent("onload",L):E.addEventListener("load",L,false)}setTimeout(Z,15);y.submit()}finally{y.setAttribute("action",W);if(Y){y.setAttribute("target",Y)}else{g.removeAttr("target")}b(X).remove()}}if(J.forceSync){O()}else{setTimeout(O,10)}var U,V,S=50,z;function L(aa){if(C.aborted||z){return}try{V=G(E)}catch(ad){a("cannot access response document: ",ad);aa=F}if(aa===I&&C){C.abort("timeout");return}else{if(aa==F&&C){C.abort("server abort");return}}if(!V||V.location.href==J.iframeSrc){if(!Q){return}}E.detachEvent?E.detachEvent("onload",L):E.removeEventListener("load",L,false);var Y="success",ac;try{if(Q){throw"timeout"}var X=J.dataType=="xml"||V.XMLDocument||b.isXMLDoc(V);a("isXml="+X);if(!X&&window.opera&&(V.body==null||V.body.innerHTML=="")){if(--S){a("requeing onLoad callback, DOM not available");setTimeout(L,250);return}}var ae=V.body?V.body:V.documentElement;C.responseText=ae?ae.innerHTML:null;C.responseXML=V.XMLDocument?V.XMLDocument:V;if(X){J.dataType="xml"}C.getResponseHeader=function(ah){var ag={"content-type":J.dataType};return ag[ah]};if(ae){C.status=Number(ae.getAttribute("status"))||C.status;C.statusText=ae.getAttribute("statusText")||C.statusText}var n=J.dataType||"";var ab=/(json|script|text)/.test(n.toLowerCase());if(ab||J.textarea){var Z=V.getElementsByTagName("textarea")[0];if(Z){C.responseText=Z.value;C.status=Number(Z.getAttribute("status"))||C.status;C.statusText=Z.getAttribute("statusText")||C.statusText}else{if(ab){var W=V.getElementsByTagName("pre")[0];var af=V.getElementsByTagName("body")[0];if(W){C.responseText=W.textContent?W.textContent:W.innerHTML}else{if(af){C.responseText=af.innerHTML}}}}}else{if(J.dataType=="xml"&&!C.responseXML&&C.responseText!=null){C.responseXML=K(C.responseText)}}try{U=k(C,J.dataType,J)}catch(aa){Y="parsererror";C.error=ac=(aa||Y)}}catch(aa){a("error caught: ",aa);Y="error";C.error=ac=(aa||Y)}if(C.aborted){a("upload aborted");Y=null}if(C.status){Y=(C.status>=200&&C.status<300||C.status===304)?"success":"error"}if(Y==="success"){J.success&&J.success.call(J.context,U,"success",C);R&&b.event.trigger("ajaxSuccess",[C,J])}else{if(Y){if(ac==undefined){ac=C.statusText}J.error&&J.error.call(J.context,C,Y,ac);R&&b.event.trigger("ajaxError",[C,J,ac])}}R&&b.event.trigger("ajaxComplete",[C,J]);if(R&&!--b.active){b.event.trigger("ajaxStop")}J.complete&&J.complete.call(J.context,C,Y);z=true;if(J.timeout){clearTimeout(H)}setTimeout(function(){if(!J.iframeTarget){A.remove()}C.responseXML=null},100)}var K=b.parseXML||function(n,W){if(window.ActiveXObject){W=new ActiveXObject("Microsoft.XMLDOM");W.async="false";W.loadXML(n)}else{W=(new DOMParser()).parseFromString(n,"text/xml")}return(W&&W.documentElement&&W.documentElement.nodeName!="parsererror")?W:null};var q=b.parseJSON||function(n){return window["eval"]("("+n+")")};var k=function(aa,Y,X){var W=aa.getResponseHeader("content-type")||"",n=Y==="xml"||!Y&&W.indexOf("xml")>=0,Z=n?aa.responseXML:aa.responseText;if(n&&Z.documentElement.nodeName==="parsererror"){b.error&&b.error("parsererror")}if(X&&X.dataFilter){Z=X.dataFilter(Z,Y)}if(typeof Z==="string"){if(Y==="json"||!Y&&W.indexOf("json")>=0){Z=q(Z)}else{if(Y==="script"||!Y&&W.indexOf("javascript")>=0){b.globalEval(Z)}}}return Z}}};b.fn.ajaxForm=function(c){if(this.length===0){var d={s:this.selector,c:this.context};if(!b.isReady&&d.s){a("DOM not ready, queuing ajaxForm");b(function(){b(d.s,d.c).ajaxForm(c)});return this}a("terminating; zero elements found by selector"+(b.isReady?"":" (DOM not ready)"));return this}return this.ajaxFormUnbind().bind("submit.form-plugin",function(f){if(!f.isDefaultPrevented()){f.preventDefault();b(this).ajaxSubmit(c)}}).bind("click.form-plugin",function(j){var i=j.target;var g=b(i);if(!(g.is(":submit,input:image"))){var f=g.closest(":submit");if(f.length==0){return}i=f[0]}var h=this;h.clk=i;if(i.type=="image"){if(j.offsetX!=undefined){h.clk_x=j.offsetX;h.clk_y=j.offsetY}else{if(typeof b.fn.offset=="function"){var k=g.offset();h.clk_x=j.pageX-k.left;h.clk_y=j.pageY-k.top}else{h.clk_x=j.pageX-i.offsetLeft;h.clk_y=j.pageY-i.offsetTop}}}setTimeout(function(){h.clk=h.clk_x=h.clk_y=null},100)})};b.fn.ajaxFormUnbind=function(){return this.unbind("submit.form-plugin click.form-plugin")};b.fn.formToArray=function(q){var p=[];if(this.length===0){return p}var d=this[0];var g=q?d.getElementsByTagName("*"):d.elements;if(!g){return p}var k,h,f,r,e,m,c;for(k=0,m=g.length;k<m;k++){e=g[k];f=e.name;if(!f){continue}if(q&&d.clk&&e.type=="image"){if(!e.disabled&&d.clk==e){p.push({name:f,value:b(e).val()});p.push({name:f+".x",value:d.clk_x},{name:f+".y",value:d.clk_y})}continue}r=b.fieldValue(e,true);if(r&&r.constructor==Array){for(h=0,c=r.length;h<c;h++){p.push({name:f,value:r[h]})}}else{if(r!==null&&typeof r!="undefined"){p.push({name:f,value:r})}}}if(!q&&d.clk){var l=b(d.clk),o=l[0];f=o.name;if(f&&!o.disabled&&o.type=="image"){p.push({name:f,value:l.val()});p.push({name:f+".x",value:d.clk_x},{name:f+".y",value:d.clk_y})}}return p};b.fn.formSerialize=function(c){return b.param(this.formToArray(c))};b.fn.fieldSerialize=function(d){var c=[];this.each(function(){var h=this.name;if(!h){return}var f=b.fieldValue(this,d);if(f&&f.constructor==Array){for(var g=0,e=f.length;g<e;g++){c.push({name:h,value:f[g]})}}else{if(f!==null&&typeof f!="undefined"){c.push({name:this.name,value:f})}}});return b.param(c)};b.fn.fieldValue=function(h){for(var g=[],e=0,c=this.length;e<c;e++){var f=this[e];var d=b.fieldValue(f,h);if(d===null||typeof d=="undefined"||(d.constructor==Array&&!d.length)){continue}d.constructor==Array?b.merge(g,d):g.push(d)}return g};b.fieldValue=function(c,j){var e=c.name,p=c.type,q=c.tagName.toLowerCase();if(j===undefined){j=true}if(j&&(!e||c.disabled||p=="reset"||p=="button"||(p=="checkbox"||p=="radio")&&!c.checked||(p=="submit"||p=="image")&&c.form&&c.form.clk!=c||q=="select"&&c.selectedIndex==-1)){return null}if(q=="select"){var k=c.selectedIndex;if(k<0){return null}var m=[],d=c.options;var g=(p=="select-one");var l=(g?k+1:d.length);for(var f=(g?k:0);f<l;f++){var h=d[f];if(h.selected){var o=h.value;if(!o){o=(h.attributes&&h.attributes.value&&!(h.attributes.value.specified))?h.text:h.value}if(g){return o}m.push(o)}}return m}return b(c).val()};b.fn.clearForm=function(){return this.each(function(){b("input,select,textarea",this).clearFields()})};b.fn.clearFields=b.fn.clearInputs=function(){var c=/^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;return this.each(function(){var e=this.type,d=this.tagName.toLowerCase();if(c.test(e)||d=="textarea"){this.value=""}else{if(e=="checkbox"||e=="radio"){this.checked=false}else{if(d=="select"){this.selectedIndex=-1}}}})};b.fn.resetForm=function(){return this.each(function(){if(typeof this.reset=="function"||(typeof this.reset=="object"&&!this.reset.nodeType)){this.reset()}})};b.fn.enable=function(c){if(c===undefined){c=true}return this.each(function(){this.disabled=!c})};b.fn.selected=function(c){if(c===undefined){c=true}return this.each(function(){var d=this.type;if(d=="checkbox"||d=="radio"){this.checked=c}else{if(this.tagName.toLowerCase()=="option"){var e=b(this).parent("select");if(c&&e[0]&&e[0].type=="select-one"){e.find("option").selected(false)}this.selected=c}}})};function a(){var c="[jquery.form] "+Array.prototype.join.call(arguments,"");if(window.console&&window.console.log){window.console.log(c)}else{if(window.opera&&window.opera.postError){window.opera.postError(c)}}}})(jQuery);
var updatingSettings=false;function saveChanges(){if(allFormsValid()){sendFormValues()}}function displayInputError(a,c){var b=$("#errorDisplay");b.html(c);b.show()}function allFormsValid(){try{var c=$("#fullname");if(c.val().length<=0){throw"Please enter a name."}else{if(c.val().split(" ").length<2){throw"Please enter a first and last name."}}c=$("#email");if(c.val().length<=0){throw"Please enter an email"}else{if(c.val().indexOf("@")==-1){throw"Please enter a valid email."}}var a=$("#birthMonth").val()-1;if(!isValidDate($("#birthYear").val(),a,$("#birthDay").val())){throw"Please enter a valid birth date."}c=$("input:checked");if(c.length<=0){c=$("#gender_1");throw"Please choose a gender."}c=$("#new_password1");if(c.val()!=$("#new_password2").val()){throw"Passwords do not match."}}catch(b){displayInputError(c,b);return false}return true}function sendFormValues(){var b=$("#accountSettingsForm").attr("action")+"?acceptId="+getUrlVars()["acceptId"];var a=$("input:checked").val();$.post(b,{fullname:$("#fullname").val(),email:$("#email").val(),birthDay:$("#birthDay").val(),birthMonth:$("#birthMonth").val(),birthYear:$("#birthYear").val(),old_password:$("#old_password").val(),new_password:$("#new_password1").val(),gender:a},function(c){$dataArray=c.split(":");if($dataArray[0].toLowerCase()==="success"){if(updatingSettings){popupMessage("Success!","Your settings have been updated!",function(){location.reload()})}else{popupMessage("Success!","Congratulations, you have just created a new account on wishenda.com! Click OK to continue to the log in screen.",rerouteToHomepage)}}else{popupMessage("Uh oh!",c)}})}function rerouteToHomepage(){window.location=Routing.generate("WishlistFrontpageBundle_homepage")}function onClickPhotoImage(){$("#preview").html('<img src="/images/loader.gif" alt="Uploading...."/>');$("#imageform").ajaxForm({target:"#preview"}).submit()}$(document).ready(function(){updatingSettings=($("#old_password").length>0);$("#saveChanges").click(saveChanges);$("#photoimg").on("change",function(){$("#preview").html("");$("#preview").html('<img src="/images/loader.gif" alt="Uploading...."/>');$("#imageform").ajaxForm({target:"#preview"}).submit()});var b=$("#orig_gender").val();$("#gender_"+b).attr("checked",true);$("#fullname").val($("#orig_name").val());$("#email").val($("#orig_email").val()).prop("disabled",true);if(updatingSettings){var a=$("#orig_birthdate").val().split("-");if(a.length===3){$("#birthMonth").val(a[0]);$("#birthDay").val(a[1]);$("#birthYear").val(a[2])}}});