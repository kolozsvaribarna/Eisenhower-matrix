<?php

function boxScript() {
    echo <<<HTML
    <script src="boxLogic.js"></script>
HTML;
}

function displayMatrix() {
    echo <<<HTML
    <div class="section-matrix">
        <div class="container">
            <div class="dropBox" boxID="0" id="box_create">
                <button type="button" class="createButton" onclick="addItem();"></button>
            </div>
            <div class="matrix">
                <div class="dropBox" boxID="1" id="box_do"><span class="boxText">DO</span></div>
                <div class="dropBox" boxID="2" id="box_schedule"><span class="boxText">SCHEDULE</span></div>
                <div class="dropBox" boxID="3" id="box_delegate"><span class="boxText">DELEGATE</span></div>
                <div class="dropBox" boxID="4" id="box_delete"><span class="boxText">DELETE</span></div>
            </div>
        </div>
    </div>
HTML;
}