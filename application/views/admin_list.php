<div id="content">
    <div id="title">
        <h1>Maintenance</h1>
    </div>

    <div id="body">
        <div id="subtitles">
            <ul class="nav">
                <li id="subtitle" class="activeSubtitle" onclick="changeTable(this)">Materials</li>
                <li id="subtitle" onclick="changeTable(this)">Recipes</li>
                <li id="subtitle" onclick="changeTable(this)">Products</li>
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