<div id="content">
    <div id="title">
        <h1>Maintenance</h1>
    </div>

    <div id="body">
        <div id="subtitles">
            <ul class="nav">
                <li id="subtitle" class="activeSubtitle" onclick="changeTable(this)">Receiving</li>
                <li id="subtitle" onclick="changeTable(this)">Production</li>
                <li id="subtitle" onclick="changeTable(this)">Sales</li>
            </ul>
        </div>
        <div class="adTables">
            <div id="m" class="activeTable">
                {Materials_table}
            </div>
            <div id="r" class="notActiveTable">
                {Recipes_table}
            </div>
            <div id="p" class="notActiveTable">
                {Products_table}
            </div>
        </div>
    </div>
</div>