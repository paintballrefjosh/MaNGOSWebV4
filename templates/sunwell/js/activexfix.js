window.onload = function fixActiveX ()
{
  if(navigator.appName == "Microsoft Internet Explorer" && navigator.userAgent.indexOf('Opera') == -1)
  {
	var changeElements = new Array(3);
	changeElements[0] = "applet";
	changeElements[1] = "embed";
	changeElements[2] = "object";
	//mooooooo!
	offScreenBuffer = document.createElement("div");
	for (i = 0; i < changeElements.length; i++)
	{
		thisTypeElements = document.getElementsByTagName(changeElements[i]);
		elementsLength = thisTypeElements.length;
		for (j = 0; j < elementsLength; j++ )
		{
			totalString = "";
			eatMe(thisTypeElements[j]);
			newContainer = document.createElement("div");
			oldElement = thisTypeElements[j];
			newContainer.innerHTML = totalString;
			oldElement.parentNode.insertBefore(newContainer,oldElement);
			offScreenBuffer.appendChild(oldElement);
		}
	}
	clearBuffer = window.setInterval("biteMe()", 500);
  }
}

function biteMe()
{
	while(offScreenBuffer.hasChildNodes()) { offScreenBuffer.removeChild(offScreenBuffer.firstChild); }
	window.clearInterval(clearBuffer);
}


function eatMe(thisElement)
{
	if(thisElement.childNodes.length>0)
	{
	  totalString = "<"+thisElement.nodeName;
	  parentAttributesLength = thisElement.attributes.length;
	  for (k=0; k<parentAttributesLength; k++)
	  {
		if(thisElement.attributes[k].nodeValue != null && thisElement.attributes[k].nodeValue != "")
		  totalString += " "+ thisElement.attributes[k].nodeName +" = "+ thisElement.attributes[k].nodeValue;
	  }
	  totalString += ">";
	  parentLength = thisElement.childNodes.length;
	  for(k=0; k<parentLength; k++)
	  {
		eatMe(thisElement.childNodes[k]);
	  }
	  totalString += "</"+thisElement.nodeName+">";
	}
	else processElement(thisElement);
}


function processElement(thisElement)
{
	subElementString = "<"+thisElement.nodeName;
	attributesLength = thisElement.attributes.length;
	for (l=0; l<attributesLength; l++)
	{
	  if(thisElement.attributes[l].nodeValue != null && thisElement.attributes[l].nodeValue != "")
		subElementString += " "+ thisElement.attributes[l].nodeName +" = "+ thisElement.attributes[l].nodeValue;
	}
	subElementString += "></"+thisElement.nodeName+">";
	totalString += subElementString;
}