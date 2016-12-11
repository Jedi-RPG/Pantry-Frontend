<h1>{type} Processed</h1>

<table class="table">
        <tr><th>Order #</th><th>Type</th><th>Date/Time</th></tr>
{orders}
    <tr>
        <td><a href="/{type}/examine/{number}">{number}</a></td>
        <td>{type}</td>
        <td>{datetime}</td>
    </tr>
{/orders}
</table>
<hr>
{previous}
