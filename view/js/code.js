// actions
    // date selector
        var trackerObj;
        var dateStr;
        goToToday();
    // other actions
        document.getElementById("notes_perm").value = "";
        document.getElementById("notes_temp").value = "";

// functions -- TABS
    function switchTabs(tabID)
    {
        var tabs = document.getElementsByClassName("tabContent");
        var tabLinks = document.getElementsByClassName("tabLink");
        if (tabs.length != tabLinks.length)
            return "Different numbers of tabs and links!";
        for (var i=0; i<tabs.length; i++)
        {
            if (tabs[i].id==tabID)
            {
                tabs[i].style.display = "block";
                tabLinks[i].style.backgroundColor = "#eee";
            }
            else
            {
                tabs[i].style.display = "none";
                tabLinks[i].style.backgroundColor = "inherit";
            }
        }
    }

// functions -- DATE
    function dateToStr(dateVar)
    {
        return dateVar.getFullYear() + '-' +
            ("0" + (dateVar.getMonth()+1)).slice(-2) + '-' +
            ("0" + dateVar.getDate()).slice(-2);
    }
    function refresh()
    {
        dateStr = document.getElementById("dateHeader").innerHTML;
        dataToFromDB("date=" + dateStr);
    }
    function updateDate()
    {
        dateStr = document.getElementById("proposedDate").innerHTML;
        document.getElementById("dateHeader").innerHTML = dateStr;
        dataToFromDB("date=" + dateStr);
    }
    function goToToday()
    {
        var curDate = new Date();
        dateStr = dateToStr(curDate);
        document.getElementById("dateHeader").innerHTML = dateStr;
        document.getElementById("monthInput").innerHTML = curDate.getMonth() + 1;
        document.getElementById("dayInput").innerHTML = curDate.getDate();
        document.getElementById("yearInput").innerHTML = curDate.getFullYear();
        document.getElementById("proposedDate").innerHTML = dateStr;
        dataToFromDB("date=" + dateStr);
    }
    function monthChange(delta)
    {
        var month = document.getElementById("monthInput");
        var year = document.getElementById("yearInput");
        month.innerHTML = Number(month.innerHTML) + delta;
        if (month.innerHTML < "1") {
            month.innerHTML = 12;
            yearChange(-1);
        } else if (Number(month.innerHTML) > "12") {
            month.innerHTML = 1;
            yearChange(1);
        }
        fixDayMax();
        setProposedDate();
    }
    function dayChange(delta)
    {
        var day = document.getElementById("dayInput");
        var month = document.getElementById("monthInput");
        var year = document.getElementById("yearInput");
        day.innerHTML = Number(day.innerHTML) + delta;
        if (day.innerHTML < "1") {
            day.innerHTML = 31;
            monthChange(-1);
        } else if (Number(day.innerHTML) > daysInMonth(
                Number(month.innerHTML),
                Number(year.innerHTML))) {
            day.innerHTML = 1;
            monthChange(1);
        }
        setProposedDate();
    }
    function yearChange(delta)
    {
        var year = document.getElementById("yearInput");
        year.innerHTML = Number(year.innerHTML) + delta;
        fixDayMax();
        setProposedDate();
    }
    function setProposedDate()
    {
        var day = document.getElementById("dayInput");
        var month = document.getElementById("monthInput");
        var year = document.getElementById("yearInput");
        var pDate = document.getElementById("proposedDate");
        pDate.innerHTML = year.innerHTML + '-' +
            ("0" + (month.innerHTML)).slice(-2) + '-' +
            ("0" + day.innerHTML).slice(-2);
    }
    function fixDayMax()
    {
        var day = document.getElementById("dayInput");
        var maxday = daysInMonth(
            Number(document.getElementById("monthInput").innerHTML),
            Number(document.getElementById("yearInput").innerHTML) );
        if (Number(day.innerHTML) > maxday) day.innerHTML = maxday;
    }
    function daysInMonth(monthNum,yearNum)
    {
        switch (monthNum) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                return 31;
            case 4:
            case 6:
            case 9:
            case 11:
                return 30;
            case 2:
                if (yearNum % 4 == 0) return 29;
                else return 28;
        }
    }

// functions -- CALORIES
    function showCals()
    {
        var calsElem = document.getElementById("cals")
        var exElem = document.getElementById("exercise");
        var netElem = document.getElementById("netCals");
        calsElem.style.color = 'black';
        exElem.style.color = 'black';
        netElem.style.color = 'black';
        calsElem.innerHTML = trackerObj.totalCalories;
        exElem.innerHTML = trackerObj.totalExercise;
        netElem.innerHTML = trackerObj.totalCalories - trackerObj.totalExercise;
    }
    function logCals(c)
    {
        document.getElementById("cals").style.color = "red";
        dataToFromDB("date=" + dateStr + "&calsToAdd=" + c);
    }
    function logEx(e) {
        document.getElementById("exercise").style.color = "red";
        dataToFromDB("date=" + dateStr + "&exToAdd=" + e);
    }
    function clearCals()
    {
        document.getElementById("cals").style.color = "red";
        dataToFromDB("date=" + dateStr + "&nullCals=yes");
    }

// functions -- NOTES
    function addPermNoteFunc()
    {
        addNoteFunc("notes_perm",false);
    }
    function addTempNoteFunc()
    {
        addNoteFunc("notes_temp",true);
    }
    function addNoteFunc(noteElement,temp) {
        var elem = document.getElementById(noteElement);
        var DBNoteStr = (temp) ? "&tempToAdd=" : "&notesToAdd=";
        dataToFromDB("date=" + dateStr + DBNoteStr +
            encodeURI(elem.value));
        elem.value = "";
    }
    function editPermNoteFunc()
    {
        editNoteFunc("displayPermNotes","editPermNoteButton","notes_perm",
            "addPermNoteButton","replacePermNoteFunc()");
    }
    function editTempNoteFunc()
    {
        editNoteFunc("displayTempNotes","editTempNoteButton","notes_temp",
            "addTempNoteButton","replaceTempNoteFunc()");
    }
    function editNoteFunc(dispNotes,editNoteButton,notes,addNoteButton,replaceNoteFunc)
    {
        var dispCurrent = document.getElementById(dispNotes);
        var editButton = document.getElementById(editNoteButton);
        var addNotes = document.getElementById(notes);
        var addButton = document.getElementById(addNoteButton);
        dispCurrent.style.display = "none";
        editButton.style.display = "none";
        addNotes.value = dispCurrent.innerHTML;
        addButton.innerHTML = "Replace Note";
        addButton.setAttribute('onclick',replaceNoteFunc);
    }
    function replacePermNoteFunc()
    {
        replaceNoteFunc("displayPermNotes","editPermNoteButton","notes_perm",
            "addPermNoteButton",'addPermNoteFunc()',false);
    }
    function replaceTempNoteFunc()
    {
        replaceNoteFunc("displayTempNotes","editTempNoteButton","notes_temp",
            "addTempNoteButton",'addTempNoteFunc()',true);
    }
    function replaceNoteFunc(dispNotes,editNoteButton,notes,addNoteButton,addNoteFunc,temp)
    {
        var dispCurrent = document.getElementById(dispNotes);
        var editButton = document.getElementById(editNoteButton);
        var addNotes = document.getElementById(notes);
        var addButton = document.getElementById(addNoteButton);
        var DBNoteStr = (temp) ? "&replaceTemp=" : "&replaceNotes=";
        dispCurrent.style.display = "block";
        editButton.style.display = "initial";
        addButton.innerHTML = "Add Note";
        addButton.setAttribute('onclick',addNoteFunc);
        dataToFromDB("date=" + dateStr + DBNoteStr +
            encodeURI(addNotes.value));
    	addNotes.value = "";
    }
    function showNotes()
    {
        var perm = document.getElementById("displayPermNotes");
        var editButtonPerm = document.getElementById("editPermNoteButton");
        var temp = document.getElementById("displayTempNotes");
        var editButtonTemp = document.getElementById("editTempNoteButton");
        document.getElementById("notes_perm").value = "";
        document.getElementById("notes_temp").value = "";
        perm.innerHTML = trackerObj.notes;
        if (trackerObj.notes == "") {
            perm.style.display = "none";
            editButtonPerm.style.display= "none";
        } else {
            perm.style.display = "block";
            editButtonPerm.style.display= "initial";
        }
        temp.innerHTML = trackerObj.temp;
        if (trackerObj.temp == "") {
            temp.style.display = "none";
            editButtonTemp.style.display= "none";
        } else {
            temp.style.display = "block";
            editButtonTemp.style.display= "initial";
        }
    }
    function clearPermFunc()
    {
        var addPerm = document.getElementById("notes_perm");
        addPerm.value = "";
    }
    function clearTempFunc()
    {
        var addTemp = document.getElementById("notes_temp");
        addTemp.value = "";
    }

// functions -- GENERAL
    function dataToFromDB(str)
    {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200)
                {
                    document.getElementById("demo").innerHTML = this.responseText;
                    trackerObj = JSON.parse(this.responseText);
                    showCals();
                    showNotes();
                }
                else
                {
                    document.getElementById("cals").style.color = 'blue';
                    document.getElementById("exercise").style.color = 'blue';
                }
            }
        };
        xhr.open("POST","controller/AjaxPassthru.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send(str);
    }
