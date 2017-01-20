function topicElement(topic, linkString, parentString, synonymsArray)
{
this.topic = topic;
this.linkString = linkString;
this.parentString = parentString;
this.synonymsArray = synonymsArray;
}

//topicsArray[""] = new topicElement("","",""); topicList[k++] = "";
topicsArray = new Object();
topicList = new Array();
k = 0;

topicsArray["Alleria Windrunner"] = new topicElement("Alleria Windrunner","315.xml","High Elves and Blood Elves",new Array("Alleria")); topicList[k++] = "Alleria Windrunner";
topicsArray["Anasterian Sunstrider"] = new topicElement("Anasterian Sunstrider","319.xml","High Elves and Blood Elves"); topicList[k++] = "Anasterian Sunstrider";
topicsArray["Azeroth"] = new topicElement("Azeroth","327.xml","The Warcraft Universe"); topicList[k++] = "Azeroth";
topicsArray["Azshara"] = new topicElement("Azshara","330.xml","Demigods"); topicList[k++] = "Azshara";
topicsArray["Blood Elves"] = new topicElement("Blood Elves","338.xml","High Elves and Blood Elves",new Array("blood elf")); topicList[k++] = "Blood Elves";
topicsArray["Burning Legion"] = new topicElement("Burning Legion","346.xml","Factions"); topicList[k++] = "Burning Legion";
topicsArray["Cenarion Circle"] = new topicElement("Cenarion Circle","349.xml","Factions"); topicList[k++] = "Cenarion Circle";
topicsArray["Cenarius"] = new topicElement("Cenarius","350.xml","Demigods"); topicList[k++] = "Cenarius";
topicsArray["Darnassian"] = new topicElement("Darnassian","361.xml","Languages"); topicList[k++] = "Darnassian";
topicsArray["Dath'Remar Sunstrider"] = new topicElement("Dath'Remar Sunstrider","363.xml","High Elves and Blood Elves"); topicList[k++] = "Dath'Remar Sunstrider";
topicsArray["Dejahna"] = new topicElement("Dejahna","367.xml","Night Elves"); topicList[k++] = "Dejahna";
topicsArray["Demigods"] = new topicElement("Demigods","369.xml","Immortals",new Array("demigod")); topicList[k++] = "Demigods";
topicsArray["Demons"] = new topicElement("Demons","371.xml","Immortals",new Array("demon")); topicList[k++] = "Demons";
topicsArray["Desdel Stareye"] = new topicElement("Desdel Stareye","785.xml","Night Elves"); topicList[k++] = "Desdel Stareye";
topicsArray["Druid"] = new topicElement("Druid","381.xml","Vocations",new Array("druids","druidism")); topicList[k++] = "Druid";
topicsArray["Elune"] = new topicElement("Elune","392.xml","Gods"); topicList[k++] = "Elune";
topicsArray["Emerald Dream"] = new topicElement("Emerald Dream","394.xml","The Warcraft Universe"); topicList[k++] = "Emerald Dream";
topicsArray["Factions"] = new topicElement("Factions","400.xml","TopLevel"); topicList[k++] = "Factions";
topicsArray["Fandral Staghelm"] = new topicElement("Fandral Staghelm","401.xml","Night Elves"); topicList[k++] = "Fandral Staghelm";
topicsArray["Farstriders"] = new topicElement("Farstriders","402.xml","Factions"); topicList[k++] = "Farstriders";
topicsArray["Gods"] = new topicElement("Gods","417.xml","Immortals",new Array("goddess")); topicList[k++] = "Gods";
topicsArray["High Elves"] = new topicElement("High Elves","429.xml","High Elves and Blood Elves",new Array("high elf")); topicList[k++] = "High Elves";
topicsArray["High Elves and Blood Elves"] = new topicElement("High Elves and Blood Elves","339.xml","Mortal Races"); topicList[k++] = "High Elves and Blood Elves";
topicsArray["Highborne"] = new topicElement("Highborne","430.xml","Factions"); topicList[k++] = "Highborne";
topicsArray["Illidan Stormrage"] = new topicElement("Illidan Stormrage","441.xml","Demons"); topicList[k++] = "Illidan Stormrage";
topicsArray["Immortals"] = new topicElement("Immortals","442.xml","TopLevel",new Array("immortal","immortality")); topicList[k++] = "Immortals";
topicsArray["Jarod Shadowsong"] = new topicElement("Jarod Shadowsong","449.xml","Night Elves",new Array("Jarod")); topicList[k++] = "Jarod Shadowsong";
topicsArray["Kael'thas Sunstrider"] = new topicElement("Kael'thas Sunstrider","451.xml","High Elves and Blood Elves"); topicList[k++] = "Kael'thas Sunstrider";
topicsArray["Kur'talos Ravencrest"] = new topicElement("Kur'talos Ravencrest","463.xml","Night Elves"); topicList[k++] = "Kur'talos Ravencrest";
topicsArray["Languages"] = new topicElement("Languages","577.xml","TopLevel"); topicList[k++] = "Languages";
topicsArray["Latosius"] = new topicElement("Latosius","464.xml","Night Elves"); topicList[k++] = "Latosius";
topicsArray["Maiev Shadowsong"] = new topicElement("Maiev Shadowsong","472.xml","Night Elves",new Array("Maiev")); topicList[k++] = "Maiev Shadowsong";
topicsArray["Malfurion Stormrage"] = new topicElement("Malfurion Stormrage","474.xml","Night Elves",new Array("Malfurion")); topicList[k++] = "Malfurion Stormrage";
topicsArray["Malorne"] = new topicElement("Malorne","475.xml","Demigods"); topicList[k++] = "Malorne";
topicsArray["Moon Guard"] = new topicElement("Moon Guard","481.xml","Factions"); topicList[k++] = "Moon Guard";
topicsArray["Mortal Races"] = new topicElement("Mortal Races","545.xml","TopLevel"); topicList[k++] = "Mortal Races";
topicsArray["Naga"] = new topicElement("Naga","487.xml","Mortal Races"); topicList[k++] = "Naga";
topicsArray["Night Elves"] = new topicElement("Night Elves","508.xml","Mortal Races",new Array("night elf")); topicList[k++] = "Night Elves";
topicsArray["Satyrs"] = new topicElement("Satyrs","540.xml","Demons",new Array("satyr")); topicList[k++] = "Satyrs";
topicsArray["Sentinels"] = new topicElement("Sentinels","546.xml","Factions"); topicList[k++] = "Sentinels";
topicsArray["Sisterhood of Elune"] = new topicElement("Sisterhood of Elune","554.xml","Factions",new Array("sisters of elune")); topicList[k++] = "Sisterhood of Elune";
topicsArray["Thalassian"] = new topicElement("Thalassian","576.xml","Languages"); topicList[k++] = "Thalassian";
topicsArray["The Warcraft Universe"] = new topicElement("The Warcraft Universe","580.xml","TopLevel"); topicList[k++] = "The Warcraft Universe";
topicsArray["Twisting Nether"] = new topicElement("Twisting Nether","594.xml","The Warcraft Universe"); topicList[k++] = "Twisting Nether";
topicsArray["Tyrande Whisperwind"] = new topicElement("Tyrande Whisperwind","598.xml","Night Elves"); topicList[k++] = "Tyrande Whisperwind";
topicsArray["Valstann Staghelm"] = new topicElement("Valstann Staghelm","608.xml","Night Elves"); topicList[k++] = "Valstann Staghelm";
topicsArray["Vashj"] = new topicElement("Vashj","610.xml","Naga"); topicList[k++] = "Vashj";
topicsArray["Vereesa Windrunner"] = new topicElement("Vereesa Windrunner","611.xml","High Elves and Blood Elves",new Array("Vereesa")); topicList[k++] = "Vereesa Windrunner";
topicsArray["Vocations"] = new topicElement("Vocations","612.xml","TopLevel"); topicList[k++] = "Vocations";
topicsArray["Watchers"] = new topicElement("Watchers","624.xml","Factions"); topicList[k++] = "Watchers";
topicsArray["Xavius"] = new topicElement("Xavius","634.xml","Demons"); topicList[k++] = "Xavius";
topicsArray["TopLevel"] = new topicElement("TopLevel","index.xml","TopLevel");




