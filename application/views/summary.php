<h1>{type} Processed So Far</h1>

<table class="table">
        <tr><th>{type} #</th><th>Type</th><th>Date/Time</th></tr>
{orders}
    <tr>
        <td><a href="/{type}/examine/{type}{number}">{number}</a></td>
        <td>{type}</td>
        <td>{datetime}</td>
    </tr>
{/orders}
</table>
            <hr>
            {previous}
