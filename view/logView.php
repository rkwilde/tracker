<?php
	$pageName = 'Log';
    require_once("viewHeader.php");
    require_once("viewNav.php");
?>

<section id="logSection" class="content-section margin-right-section">
<a id="pos1"></a>
    <!--Date Selection-->
        <div class="text-align-center margin-top-section2 padding-top-small">
            <span class="hover-hand" onclick="dayChange(-1); updateDate();">
                <span class="arrow arrow-left color-accent2-border valign-middle">
                </span>
            </span>
            <span id="dateHeader" class="text-large text-bold valign-middle">
            </span>
            <span class="hover-hand" onclick="dayChange(1); updateDate();">
                <span class="arrow arrow-right color-accent2-border valign-middle">
                </span>
            </span>
        </div>
        <button class="implement-later" onclick="refresh()">Refresh</button>
        <button class="implement-later" onclick="goToToday()">Go to Today</button>
        <span id="monthInput" class="implement-later"></span>
        <span id="dayInput" class="implement-later"></span>
        <span id="yearInput" class="implement-later"></span>
        <span id="proposedDate" class="implement-later"></span>

    <!--Calorie Tracker-->
        <div id="calorieTile" class="text-align-center 
                padding-bottom-small margin-top-medium padding-top-small2 color-dull2-bg">
            <h2 class="tile-title text-medium">Calorie Tracker</h2>
            <div class="text-align-center display-inline-block">
                <a id="pos2"></a>
                <div class="container-inline">
                    <h3 class="text-small">Calories</h3>
                    <span class="hover-hand" onclick="logCals(100)">
                        <span class="arrow arrow-up color-accent2-border">
                        </span>
                    </span>
                    <div class="text-medium" id="cals">
                    </div>
                    <span class="hover-hand" onclick="logCals(-100)">
                        <span class="arrow arrow-down color-accent2-border">
                        </span>
                    </span>
                </div>
                <div class="container-inline width-small">
                    <h3 class="text-small">Net</h3>
                    <div class="text-huge" id="netCals"></div>
                </div>
                <div class="container-inline">
                    <h3 class="text-small">Exercise</h3>
                    <span class="hover-hand" onclick="logEx(100)">
                        <span class="arrow arrow-up color-accent2-border">
                        </span>
                    </span>
                    <div class="text-medium" id="exercise">
                    </div>
                    <span class="hover-hand" onclick="logEx(-100)">
                        <span class="arrow arrow-down color-accent2-border">
                        </span>
                    </span>
                </div>
                <div class="implement-later">
                    <div class="implement-later">Lost track?</div>
                    <button class="implement-later" onclick="clearCals()">Clear calories</button>
                </div>
                <div id="msgCal" class="start-invisible padding-all-small"></div>
            </div>
    	</div>

    <!--Permanent Notes-->
        <a id="permNoteBookmark"></a>
        <div id="permNoteTile" class="text-align-center padding-top-small2 padding-bottom-small color-dull1-bg">
            <h2 class="tile-title text-medium">Permanent Notes</h2>
            <div class="width-medium3 display-inline-block padding-top-medium2">
                <p id="displayPermNotes" 
                    class="start-invisible pre-wrap text-align-left padding-all-small border-basic margin-none
                        color-accent1-bg color-black-border">
                </p>
                <button id="editPermNoteButton" onclick="editPermNoteFunc()" 
                        class="start-invisible button hover-hand float-right margin-all-small text-bold 
                            color-accent2-bg color-accent1-font">
                    Edit Note
                </button>
                <a id="pos3"></a>
                <textarea id="notes_perm" class="note-input width-medium4">
                </textarea>
                <button id="addPermNoteButton" onclick="addPermNoteFunc()" 
                        class="button hover-hand float-right margin-all-small text-bold 
                            color-accent2-bg color-accent1-font">
                    Add Note
                </button>
                <button id="clearPermButton" onclick="clearPermFunc()" 
                        class="button hover-hand float-left margin-all-small 
                            color-dull3-bg color-black-font">
                    Clear
                </button>
                <div id="msgPerm" class="start-invisible padding-all-small clear-both"></div>
            </div>
        </div>
    
    <!-- Temporary Notes -->
        <a id="tempNoteBookmark"></a>
        <div id="tempNoteTile" class="text-align-center padding-top-small2 padding-bottom-small color-dull2-bg">
            <h2 class="tile-title text-medium">Temporary Notes</h2>
            <div class="width-medium3 display-inline-block padding-top-medium2">
                <p id="displayTempNotes" 
                    class="start-invisible pre-wrap text-align-left padding-all-small border-basic margin-none
                        color-accent1-bg color-black-border">
                </p>
                <button id="editTempNoteButton" onclick="editTempNoteFunc()" 
                        class="start-invisible button hover-hand float-right margin-all-small text-bold 
                            color-accent2-bg color-accent1-font">
                    Edit Note
                </button>
                <textarea id="notes_temp" class="note-input width-medium4">
                </textarea>
                <button id="addTempNoteButton" onclick="addTempNoteFunc()" 
                        class="button hover-hand float-right margin-all-small text-bold 
                            color-accent2-bg color-accent1-font">
                    Add Note
                </button>
                <button id="clearTempButton" onclick="clearTempFunc()" 
                        class="button hover-hand float-left margin-all-small 
                            color-dull3-bg color-black-font">Clear
                </button>
                <div id="msgTemp" class="start-invisible padding-all-small clear-both"></div>
            </div>
        </div>

</section>

<!-- js file -->
<script src="view/js/code.js"></script>



<?php
	require_once("viewFooter.php");
?>
