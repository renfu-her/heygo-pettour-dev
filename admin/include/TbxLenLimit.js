/*
Author	:	adamlee - ajunlee(at)gmail.com
Blog	:	http://blog.blueshop.com.tw/ajun
Date	:	2006/9/14
Version	:	0.4
--
update	:	(2006/9/14)
comment	:	新增class "ShowLenLimit" 設定,限制輸入字數的長度
update	:	(2006/9/21)
comment	:	修正用滑鼠貼上無法計算的問題,加上onchange時的判斷
update	:	(2008/4/30)
comment	:	新增對於input type="text"的處理
update	:	(2008/6/23)
comment	:	調整對asp.net中TextMode="MultiLine"時maxlength屬性無作用的支援,增加MaxLen的屬性設定
update	:	(2009/8/28)
comment	:	當有預設內容時,會顯示字數

*/
function addEvent( obj, type, fn )
{
	if (obj.addEventListener)
		obj.addEventListener( type, fn, false );
	else if (obj.attachEvent)
	{
		obj["e"+type+fn] = fn;
		obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
		obj.attachEvent( "on"+type, obj[type+fn] );
	}
}

function CountChar(){
	var intChars =  parseInt(this.value.length);
	var intMax = this.getAttribute('MaxLength');
	if (intMax == null) intMax = this.getAttribute('MaxLen');
	var objMsg = document.getElementById("div" + this.id);
	objMsg.innerHTML = "目前字數 : " + intChars + " , 剩餘字數 : " + (intMax - intChars);
}

function LimitChar() {
    LimitChars(this.id);
}

function LimitChars(objId) {
    var obj = document.getElementById(objId);
    var intChars = parseInt(obj.value.length);
    var intMax = obj.getAttribute('MaxLength');
    if (intMax == null) intMax = obj.getAttribute('MaxLen');
    var objMsg = document.getElementById("div" + obj.id);
    if (intChars > intMax) {
        obj.value = obj.value.substring(0, intMax);
        objMsg.innerHTML = "<font color='red'>目前字數 : " + intMax + " , 剩餘字數 : 0</font>";
    } else {
        objMsg.innerHTML = "目前字數 : " + intChars + " , 剩餘字數 : " + (intMax - intChars);
    }
}

function GenDivTag(objid,defMsg)
{
    var newDiv = document.createElement("div");
	newDiv.setAttribute("id", objid);
	newDiv.innerHTML = defMsg;
	return newDiv;
}

function GenLimitDiv(objId,objStr)
{
    return GenDivTag("div" + objId,"目前字數 : 0, 剩餘字數 : " + objStr);
}

function controlRender(tbxCtl,countChar,limitChar)
{
	var tbxParent = tbxCtl.parentNode;
	var intMax = tbxCtl.getAttribute('MaxLength');
	if (intMax == null) intMax = tbxCtl.getAttribute('MaxLen');
	tbxParent.insertBefore(GenLimitDiv(tbxCtl.id,intMax), tbxCtl);
	tbxCtl.onkeyup = countChar;
	tbxCtl.onchange = limitChar;
	LimitChars(tbxCtl.id);
}

function TbxLenInit(){
	if (document.getElementById && document.createElement && document.appendChild) {
		var tbxs = document.getElementsByTagName('textarea');
		var tbx;
		for (var i = 0; i < tbxs.length; i++) {
			tbx = tbxs[i];
			if (/\bShowLen\b/.test(tbx.className)) {
			    controlRender(tbx,CountChar,LimitChar);
			}else if(/\bShowLenLimit\b/.test(tbx.className)){
    			controlRender(tbx, LimitChar, LimitChar);
            }
        }
		
		tbxs = document.getElementsByTagName("input");
		for (var i = 0;i<tbxs.length;i++)
		{
		    tbx = tbxs[i];
		    if (tbx.getAttribute("type") == "text")
		    {
			    if (/\bShowLen\b/.test(tbx.className)) {
    			    controlRender(tbx,CountChar,LimitChar);
			    }else if(/\bShowLenLimit\b/.test(tbx.className)){
    			    controlRender(tbx,LimitChar,LimitChar);
    			}
			}
        }
	}
}
addEvent(window, 'load', TbxLenInit);