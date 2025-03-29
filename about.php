<?php

session_start();

require_once "html.php";

htmlStart("About");

checkUserLogin();

displaySideBarNav();

echo <<<HTML
    <h2 style="text-align: center;">About the Eisenhower Matrix</h2>
    <h3 class="collapsible">What?</h3>
    <div class="contentCollapsible">
        <p>The Eisenhower Matrix is named after the American president Eisenhower who was known for his productivity during his time in Office.</p>
        <p>This time management technique is based on labelling each task as: <b>important/not important</b>, and <b>urgent/not urgent</b>. You tackle them in relation to this. </p>    
    </div>

    <h3 class="collapsible">How?</h3>
    <div class="contentCollapsible">
        <p>To implement, list and add all your tasks and divide them into 4 quadrants:</p>
        <ul>
            <li><span id="listDo">DO [Urgent and important] </span><br> You should do these tasks immediately.</li>
            <li><span id="listSchedule">SCHEDULE [Important, but not urgent] </span> <br> You should schedule a time for when you will tackle these tasks.</li>
            <li><span id="listDelegate">DELEGATE [Urgent, but not important] </span> <br> It is best you delegate these tasks to your colleagues, or subordinates.</li>
            <li><span id="listDelete">DELETE [Neither important, not urgent] </span> <br> You should eliminate these tasks altogether from your schedule.</li>
        </ul>
    </div>
    
    <h3 class="collapsible">Why?</h3>
    <div class="contentCollapsible">
        <p>The Eisenhower Matrix is an effective and rather simple time management technique which helps you battle time management issues. It also helps you with setting <b>SMART goals</b>, as well as prioritising.</p>
        <p><b>Some difficulties it solves include:</b></p>
        <ul>
            <li>Ineffective scheduling</li>
            <li>Missed deadlines</li>
            <li>Multitasking</li>
            <li>Distractions</li>
            <li>Procrastinating</li>
        </ul>
    </div>
HTML;

htmlEnd();