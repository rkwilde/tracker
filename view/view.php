<?php
	require_once("viewHeader.php");
?>

<!-- body of document -->
    <!--Date Currently Being Modified-->
        <div>
            <button class="numberIncrementerVert" onclick="dayChange(-1); updateDate();">&lt;</button>
            <h1 id="dateHeader"></h1>
            <button class="numberIncrementerVert" onclick="dayChange(1); updateDate();">&gt;</button>
        </div>
        <button class="long" onclick="refresh()">Refresh</button>
        <button class="long" onclick="goToToday()">Go to Today</button>
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
            <button class="long" onclick="updateDate()">Confirm</button>
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
            <button class="long" onclick="clearCals()">Clear calories</button>
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

<?php
	require_once("viewFooter.php");
?>
