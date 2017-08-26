<!DOCTYPE html>
<html>

<!--The purpose of this site is to help me track my calories and exercise, 
    as well as some stuff about the babies (notes, firsts, pp, lp)-->

<head>

    <title>Personal Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="tracker_styles.css">

</head>

<body>

    <!--Date Currently Being Modified-->
        <h1 id="dateHeader"></h1>
        <button class="small" onclick="refresh()">Refresh</button>
        <button class="small" onclick="goToToday()">Today</button> 
    
    <!--Tab Selection-->
    <div class="tabMenu">
        <a class="tabLink" id="dateTabLink" onclick="switchTabs('dateTab')">Date<br>Selector</a>
        <a class="tabLink" id="calorieTabLink" onclick="switchTabs('calorieTab')">Calorie<br>Tracker</a>
        <a class="tabLink" id="noteTabLink" onclick="switchTabs('noteTab')">Note<br>Tracker</a>
    </div>
    
    <!--Date Selectors-->
    <div id="dateTab" class="tabContent">
        <h2>Select Date</h2>
        <div class="container2">
            <div class="numberTitle">Month</div>
            <button class="numberIncrementer" onclick="monthChange(1)">&#x1431;</button>
            <div id="monthInput" class="numberDisplayer"></div>
            <button class="numberIncrementer" onclick="monthChange(-1)">&#x142F;</button>
        </div>
        
        <div class="container2">
            <div class="numberTitle">Day</div>
            <button class="numberIncrementer" onclick="dayChange(1)">&#x1431;</button>
            <div id="dayInput" class="numberDisplayer"></div>
            <button class="numberIncrementer" onclick="dayChange(-1)">&#x142F;</button>
        </div>
        
        <div class="container2">
            <div class="numberTitle">Year</div>
            <button class="numberIncrementer" onclick="yearChange(1)">&#x1431;</button>
            <div id="yearInput" class="numberDisplayer"></div>
            <button class="numberIncrementer" onclick="yearChange(-1)">&#x142F;</button>
        </div>
        
        <div>
            <div class="numberTitle">
                Selected date: 
                <span id="proposedDate"></span>
            </div>
            <button class="small" onclick="updateDate()">Confirm</button>
        </div>
            
    </div>
    
    <!--Calorie Tracker-->
    <div id="calorieTab" class="tabContent">
        <h2>Calorie Tracker</h2>
        <div class="container2">
            <div class="numberTitle">Calories</div>
            <button class="numberIncrementer" onclick="logCals(100)">&#x1431;</button>
            <div class="numberDisplayer" id="cals"></div>
            <button class="numberIncrementer" onclick="logCals(-100)">&#x142F;</button>
        </div>
        <div class="container2">
            <div class="numberTitle">Exercise</div>
            <button class="numberIncrementer" onclick="logEx(100)">&#x1431;</button>
            <div class="numberDisplayer" id="exercise"></div>
            <button class="numberIncrementer" onclick="logEx(-100)">&#x142F;</button>
        </div>
        <div class="container2">
            <div class="numberTitle">Net</div>
            <div class="numberDisplayer2" id="netCals"></div>
        </div>
        <div>
            <div class="numberTitle">Lost track?</div>
            <button class="small" onclick="clearCals()">Clear calories</button>
        </div>
	</div>
    
    <!--Notes-->
    <div id="noteTab" class="tabContent">
        <h2>Notes</h2>
            <h3 class="noteHeader">Permanent Notes</h3>
                <p id="displayPermNotes" class="dispNotes"></p>
                <button id="editPermNoteButton" onclick="editPermNoteFunc()" class="big">Edit Note</button>
                <textarea id="notes_perm" rows="2" cols="30"></textarea>
                <button id="addPermNoteButton" onclick="addPermNoteFunc()" class="big">Add Note</button>
                <button id="clearPermButton" onclick="clearPermFunc()" class="big">Clear</button>
            <h3 class="noteHeader">Temporary Notes</h3>
                <p id="displayTempNotes" class="dispNotes"></p>
                <button id="editTempNoteButton" onclick="editTempNoteFunc()" class="big">Edit Note</button>
                <textarea id="notes_temp" rows="2" cols="30"></textarea>
                <button id="addTempNoteButton" onclick="addTempNoteFunc()" class="big">Add Note</button>
                <button id="clearTempButton" onclick="clearTempFunc()" class="big">Clear</button>
    </div>
                    
    <pre id="demo"></pre>
    <pre id="demo2"></pre>    
    
    <script src="tracker_code.js"></script>
</body>

</html>