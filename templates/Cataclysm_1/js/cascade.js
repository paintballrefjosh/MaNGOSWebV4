// JavaScript Document

function transformData(startPoint)
{
	var branchLength = eval("Menu" + startPoint + "[3]");
	for (var i=1; i <= branchLength; i++)
	{	
		currentName = eval("Menu" + startPoint + "_" + i + "[0]");
		currentNameId = currentName + "@" + startPoint + "_" + i;
		currentUrl = eval("Menu" + startPoint + "_" + i + "[1]");
		parentName = (startPoint!=1) ? eval("Menu" + startPoint + "[0]") + "@" + startPoint : "TopLevel";
		eval("topicsArray[\"" + currentNameId + "\"] = new topicElement(\"" + currentNameId + "\",\"" + currentUrl + "\",\"" + parentName + "\"); topicList[k++] = \"" + currentNameId + "\";");
		if (eval('Menu' + startPoint + "_" + i + '[3]') != 0) transformData(startPoint + "_" + i);
	}
}
//transformData('1');

function revealTree(currentEntry)
{
	if (currentEntry != document.title)
	{
		document.getElementById("aBeautifulCherryTree").insertBefore(document.getElementById(currentEntry+"Link").cloneNode(true), document.getElementById("aBeautifulCherryTree").firstChild);
		document.getElementById("aBeautifulCherryTree").innerHTML = "&nbsp;&gt;&nbsp;" + document.getElementById("aBeautifulCherryTree").innerHTML;
		document.getElementById("abbreviatedTree").insertBefore(document.getElementById(currentEntry+"Link").cloneNode(true), document.getElementById("abbreviatedTree").firstChild);
		document.getElementById("abbreviatedTree").innerHTML = "&nbsp; | &nbsp;" + document.getElementById("abbreviatedTree").innerHTML;
	}
	if(topicsArray[currentEntry].parentString != "TopLevel")
	{
		toggleCategory(topicsArray[currentEntry].parentString);
		revealTree(topicsArray[topicsArray[currentEntry].parentString].topic);		
	}
}

function displaySubArticles(thisCategory)
{
	if (document.getElementById(thisCategory+"MenuGroup"))
	{
		document.getElementById("categoryArticles").style.display = "block";
		document.getElementById("categoryIdentifier").innerHTML = document.title;
		for(i=0; i<document.getElementById(thisCategory+"MenuGroup").childNodes.length; i++)
		{
			clonedNode = document.getElementById(thisCategory+"MenuGroup").childNodes[i].childNodes[0].cloneNode(true);
			clonedNode.id += "Copied";
			cloneDaddy = document.createElement("li");
			cloneDaddy.appendChild(clonedNode);
			document.getElementById("theSoundOfRunningWater").appendChild(cloneDaddy);
		}
	}
	else
	{
		document.getElementById("bufferDiv").appendChild(document.getElementById("categoryAlert"));
	}
//alert(document.getElementById("theSoundOfRunningWater").firstChild.id);
}

function toggleCategory(thisCategory)
{	
	document.getElementById(thisCategory).lastChild.style.display = (document.getElementById(thisCategory).lastChild.style.display == "block") ? "none" : "block";
	document.getElementById(thisCategory+"Toggler").style.backgroundImage = (document.getElementById(thisCategory+"Toggler").style.backgroundImage == "url(images/minus.gif)") ? "url(images/plus.gif)" : "url(images/minus.gif)";
	//alert(document.getElementById(thisCategory).lastChild.id+" has children: "+document.getElementById(thisCategory).lastChild.firstChild.id);
}

function createListEntry(thisEntry)
{
	listItemForThisEntry = document.createElement("div");
	listItemForThisEntry.id = thisEntry.topic;
	dotForThisEntry = document.createElement("span");
	dotForThisEntry.className = "menuEntryDotStyle";
	linkForThisEntry = document.createElement("a");
	linkForThisEntry.href = thisEntry.linkString;
	linkForThisEntry.id = thisEntry.topic+"Link";
	pureString = thisEntry.topic.split("@");
	textForTheLink = document.createTextNode(pureString[0]);
	linkForThisEntry.appendChild(textForTheLink);
	listItemForThisEntry.appendChild(linkForThisEntry);
	listItemForThisEntry.appendChild(dotForThisEntry);
	return listItemForThisEntry;
}

function createGroup(thisCategory)
{
	if (thisCategory != "TopLevel") document.getElementById("bufferDiv").appendChild(document.getElementById(thisCategory).childNodes[1]);
	groupContainer = document.createElement("div");
	groupContainer.id = thisCategory+"MenuGroup";
	return groupContainer;
}

function createToggler(thisCategory)
{
	groupToggler = document.createElement("span");
	groupToggler.className = "plusSign";
	groupToggler.style.backgroundImage = "url(images/plus.gif)";
	groupToggler.id = thisCategory+"Toggler";
	groupToggler.onclick = function(){toggleCategory(thisCategory)};
	return groupToggler;
}

function minimizeToggle()
{
	document.getElementById("TopLevel").style.display = (document.getElementById("TopLevel").style.display == "none") ? "block" : "none";
	document.getElementById("dragMenuContainer").style.backgroundImage = (document.getElementById("dragMenuContainer").style.backgroundImage == "url(images/openmenu.gif)") ? "url(images/closemenu.gif)" : "url(images/openmenu.gif)";
}

function assembleTheList()
{
	for (i=0; i<topicList.length; i++)
	{
		parentElement = topicsArray[topicList[i]].parentString;
		processThisItem = (document.getElementById(topicsArray[topicList[i]].topic)) ? document.getElementById(topicsArray[topicList[i]].topic) : createListEntry(topicsArray[topicList[i]]);
		if(!document.getElementById(parentElement)) document.getElementById("bufferDiv").appendChild(createListEntry(topicsArray[parentElement]));
		if(!document.getElementById(parentElement+"MenuGroup"))
		{
			if (parentElement != "TopLevel") document.getElementById(parentElement).appendChild(createToggler(parentElement));
			document.getElementById(parentElement).appendChild(createGroup(parentElement));
			if (parentElement != "TopLevel") document.getElementById(parentElement+"MenuGroup").style.display = "none";
		}
		document.getElementById(parentElement+"MenuGroup").appendChild(processThisItem);
	}
	currentNodeRef = (window.pageId) ? pageId+"@"+result : document.title;
	if (document.title != "The Warcraft Encyclopedia")
	{
		revealTree(currentNodeRef);
		document.getElementById(currentNodeRef+"Link").className = "currentArticleMenuStyle";
		document.getElementById(currentNodeRef+"Link").style.color = "#ff6600";
	}
}

function initializationSequence()
{
	document.getElementById("headLine").innerHTML = document.title;
	document.getElementById("TopLevel").style.display = "none";
	document.getElementById("dragMenuContainer").style.backgroundImage = "url(images/openmenu.gif)";
	document.getElementById("avatarImageContainer").style.backgroundImage = "url(images/icons/"+topicsArray[topicsArray[document.title].parentString].linkString.split(".xml")[0]+".jpg)";
	assembleTheList();
	replaceText();
	displaySubArticles(document.title);
	if(!document.getElementsByTagName("p")[0])
	{
		document.getElementById("articleContentContainer").style.visibility = "hidden";
		document.getElementById("categoryAlert").style.display = "none";
	}
}